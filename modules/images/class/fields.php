<?php
/**
 * XOOPS Remote Images URL Cache and Management in Profile Module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   	The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     	General Public License version 3
 * @author      	Simon Roberts <wishcraft@users.sourceforge.net>
 * @subpackage  	images
 * @description 	Module for importing image URL listed in profile module
 * @version			1.0.1
 * @link        	https://sourceforge.net/projects/chronolabs/files/XOOPS%202.5/Modules/images
 * @link        	https://sourceforge.net/projects/chronolabs/files/XOOPS%202.6/Modules/images
 * @link			https://sourceforge.net/p/xoops/svn/HEAD/tree/XoopsModules/images
 * @link			http://internetfounder.wordpress.com
 */

 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'objects.php';

class ImagesFields extends ImagesXoopsObject
{
    /**
     * Constructor
     *
     * @param int $id ID of the tag, deprecated
     */
	function __construct($id = null)
	{
		$this->initVar("id",        XOBJ_DTYPE_INT,    		null, false);
		$this->initVar("hash",	    XOBJ_DTYPE_TXTBOX,    	null, false, 16);
		$this->initVar("field",     XOBJ_DTYPE_TXTBOX,    	null, false, 64);
		$this->initVar("typal",     XOBJ_DTYPE_ENUM,     	'unknown', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'typal'));
		$this->initVar("views",     XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("viewed",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("images",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("errors",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("megabytes", XOBJ_DTYPE_FLOAT,     	null, false);
		$this->initVar("created",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("errored",   XOBJ_DTYPE_INT,     	null, false);
	}

	
	/**
	 * gets Field Typal
	 * @return string|boolean
	 */
	public function getFieldTypal($options = NULL)
	{
	    global $imagesConfigList;
	    if (is_null($options) || empty($options))
	    {
	        $options = array('icons', 'logo', 'photo', 'avatar');
	        shuffle($options);
	        shuffle($options);
	        shuffle($options);
	        shuffle($options);
	    }
	    foreach($options as $option)
	        if (in_array(self::getVar('field'), $imagesConfigList["$option_fields"]))
	            return $option;
	    return 'unknown';
	}
}


class ImagesFieldsHandler extends ImagesXoopsPersistableObjectHandler
{

    
    /**
     * Constructor
     *
     * @param object $db reference to the {@link XoopsDatabase} object     
     **/
    function __construct(&$db)
    {
    	parent::__construct($db, "images_fields", "ImagesFields", "id", "hash");
    }
  
    /**
     * Inserts a ImagesFields Object into the database
     * 
     * {@inheritDoc}
     * @see XoopsPersistableObjectHandler::insert()
     */
    function insert(ImagesFields $object, $force = true)
    {
        global $imagesConfigList;
        if ($object->isNew())
        {
            $object->getVar('created', time());
            $object->getVar('typal', $object->getFieldTypal());
            $criteria = new CriteriaCompo(new Criteria('field', $object->getVar('field')));
            $criteria->add(new Criteria('typal', $object->getVar('typal')));
            if (self::getCount($criteria) > 0)
            {
                $objs = self::getObjects($criteria);
                if (isset($objs[0]) && !empty($objs[0]))
                    return $objs[0]->getVar('id');
            }
            $crc = new xcp($data = $object->getVar('field').$object->getVar('created').microtime().$object->getVar('typal'), mt_rand(0,255), mt_rand(5,14));
            $object->setVar('hash', $crc->crc);
        }
        return parent::insert($object, true);
    }
    
    /**
     * gets ImagesFields object from hash info 
     * 
     * @param string $hash
     * @param string $typal
     * @return mixed|boolean
     */
    function getByHash($hash = '', $typal = '')
    {
        $criteria = new CriteriaCompo(new Criteria('hash', $hash));
        $criteria->add(new Criteria('typal', $typal));
        if (self::getCount($criteria) > 0)
        {
            $objs = self::getObjects($criteria);
            if (isset($objs[0]) && !empty($objs[0]))
                return $objs[0];
        }
        return false;
    }
    
    /**
     * get an Array of a field
     * 
     * @param string $field
     * @param string $return
     * @return string[]
     */
    function getFieldArray($field = '', $return = 'url')
    {
        $result = array('');
        $sql = "SELECT DISTINCT `$return` FROM `" . $GLOBALS['xoopsDB']->prefix('images_images') . "` WHERE `field` = '$field'";
        if ($query = $GLOBALS['xoopsDB']->queryF($sql))
        {
            $value = 'https://';
            while(count($result)<$GLOBALS['xoopsDB']->getRowsNum($query))
            {
                list($value) = $GLOBALS['xoopsDB']->fetchRow($query);
                $result[] = $value;
            }
            if ($return == 'url')
            {
                $result[] = 'http://';
                $result[] = 'https://';
                $result[] = '';
            }
            array_unique($result);
            sort($result, SORT_ASC);
        }
        return $result;
    }
    
    /**
     * adds to the images count
     * 
     * @param string $field
     * @param string $typal
     * @param number $number
     */
    function addImages($field = '', $typal = '', $number = 1)
    {
        $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_fields") . "` SET `images` = `images` + '$number' WHERE `field` = '" . $field . "' AND `typal` = '" . $typal . "'";
        @$GLOBALS['xoopsDB']->queryF($sql);
    }
    
    
    /**
     * adds to the error count
     *
     * @param string $field
     * @param string $typal
     * @param number $number
     */
    function addErrors($field = '', $typal = '', $number = 1)
    {
        $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_fields") . "` SET `errors` = `errors` + '$number', `errored` = UNIX_TIMESTAMP() WHERE `field` = '" . $field . "' AND `typal` = '" . $typal . "'";
        @$GLOBALS['xoopsDB']->queryF($sql);
    }
}
?>