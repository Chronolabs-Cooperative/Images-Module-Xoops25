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

class ImagesErrors extends ImagesXoopsObject
{
    /**
     * Constructor
     *
     * @param int $id ID of the tag, deprecated
     */
    function __construct($id = null)
    {
        $this->initVar("id",        XOBJ_DTYPE_INT,    		null, false);
        $this->initVar("type",      XOBJ_DTYPE_ENUM,     	'unknown', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'type'));
        $this->initVar("uid",       XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("imageid",   XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("fieldid",   XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("code",	    XOBJ_DTYPE_TXTBOX,    	null, false, 64);
        $this->initVar("when",      XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("message",   XOBJ_DTYPE_TXTBOX,    	null, false, 255);
        $this->initVar("emailed",   XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("created",   XOBJ_DTYPE_INT,     	null, false);
        $this->initVar("deleted",   XOBJ_DTYPE_INT,     	null, false);
    }
    
}


class ImagesErrorsHandler extends ImagesXoopsPersistableObjectHandler
{
    
    
    /**
     * Constructor
     *
     * @param object $db reference to the {@link XoopsDatabase} object
     **/
    function __construct(&$db)
    {
        parent::__construct($db, "images_errors", "ImagesErrors", "id", "hash");
    }
    
    /**
     * Inserts a ImagesErrors Object into the database
     *
     * {@inheritDoc}
     * @see XoopsPersistableObjectHandler::insert()
     */
    function insert(ImagesErrors $object, $force = true)
    {
        global $imagesConfigList;
        if ($object->isNew())
        {
            $object->getVar('created', time());
        }
        return parent::insert($object, true);
    }
    
}
?>