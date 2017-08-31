<?php
/**
 * Legal Consent is a module for obtain legal guardianship Images
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   	The XOOPS Project http://fonts2web.org.uk
 * @license     	General Public License version 3 (http://labs.coop/briefs/legal/general-public-licence/13,3.html)
 * @author      	Simon Roberts (wishcraft) <wishcraft@users.sourceforge.net>
 * @subpackage  	Images
 * @description 	Legal Consent is a module for obtain legal guardianship Images
 * @version		    1.0.1
 * @link			http://internetfounder.wordpress.com
 */

if (!defined('_MD_CONSENT_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');

/**
 * Database Table for statistics_score in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `images_statistics_score` (
  `id` mediumint(32) NOT NULL AUTO_INCREMENT,
  `mode` enum('hourly','daily','weekly','biweekly','monthly','quarterly','yearly') NOT NULL DEFAULT '',
  `typal` enum('icons','logo','photo','avatar') NOT NULL DEFAULT '',
  `type` enum('fields','images') NOT NULL DEFAULT '',
  `typeid` mediumint(15) NOT NULL DEFAULT '0',
  `hash` varchar(18) NOT NULL DEFAULT '',
  `key` varchar(64) NOT NULL DEFAULT '',
  `timezone` varchar(128) NOT NULL DEFAULT '',
  `commence` int(13) NOT NULL DEFAULT '0',
  `finished` int(13) NOT NULL DEFAULT '0',
  `year` int(4) NOT NULL DEFAULT '0',
  `month` int(2) NOT NULL DEFAULT '0',
  `day` int(2) NOT NULL DEFAULT '0',
  `week` int(2) NOT NULL DEFAULT '0',
  `hour` int(2) NOT NULL DEFAULT '0',
  `minute` int(2) NOT NULL DEFAULT '0',
  `seconds` int(2) NOT NULL DEFAULT '0',
  `segment-month` enum('0-3','3-6','6-9','9-12') NOT NULL DEFAULT '0-3',
  `segment-hour` enum('0-3','3-6','6-9','9-12','12-15','15-18','18-21','21-24') NOT NULL DEFAULT '0-3',
  `segment-minute` enum('0-15','15-30','30-45','45-60') NOT NULL DEFAULT '0-15',
  `day-name` enum('Sun','Sat','Mon','Tue','Wed','Thu','Fri') NOT NULL DEFAULT 'Sun',
  `stat` float(22,9) NOT NULL DEFAULT '0.000000000',
  `sum_item_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_hourly` int(13) NOT NULL DEFAULT '0',
  `sum_item_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_daily` int(13) NOT NULL DEFAULT '0',
  `sum_item_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_weekly` int(13) NOT NULL DEFAULT '0',
  `sum_item_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_biweekly` int(13) NOT NULL DEFAULT '0',
  `sum_item_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_monthly` int(13) NOT NULL DEFAULT '0',
  `sum_item_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_quarterly` int(13) NOT NULL DEFAULT '0',
  `sum_item_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_item_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_item_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_item_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_item_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_item_yearly` int(13) NOT NULL DEFAULT '0',
  `sum_key_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_hourly` int(13) NOT NULL DEFAULT '0',
  `sum_key_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_daily` int(13) NOT NULL DEFAULT '0',
  `sum_key_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_weekly` int(13) NOT NULL DEFAULT '0',
  `sum_key_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_biweekly` int(13) NOT NULL DEFAULT '0',
  `sum_key_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_monthly` int(13) NOT NULL DEFAULT '0',
  `sum_key_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_quarterly` int(13) NOT NULL DEFAULT '0',
  `sum_key_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_key_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_key_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_key_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_key_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_key_yearly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_hourly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_daily` int(13) NOT NULL DEFAULT '0',
  `sum_typal_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_weekly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_biweekly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_monthly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_quarterly` int(13) NOT NULL DEFAULT '0',
  `sum_typal_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_typal_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_typal_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_typal_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_typal_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_typal_yearly` int(13) NOT NULL DEFAULT '0',
  `sum_type_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_hourly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_hourly` int(13) NOT NULL DEFAULT '0',
  `sum_type_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_daily` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_daily` int(13) NOT NULL DEFAULT '0',
  `sum_type_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_weekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_weekly` int(13) NOT NULL DEFAULT '0',
  `sum_type_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_biweekly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_biweekly` int(13) NOT NULL DEFAULT '0',
  `sum_type_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_monthly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_monthly` int(13) NOT NULL DEFAULT '0',
  `sum_type_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_quarterly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_quarterly` int(13) NOT NULL DEFAULT '0',
  `sum_type_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `max_type_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `min_type_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `adv_type_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `std_type_yearly` float(22,9) NOT NULL DEFAULT '0.000000000',
  `end_type_yearly` int(13) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `SEARCH` (`key`,`year`,`month`,`day`,`week`,`hour`,`minute`,`segment-month`,`segment-hour`,`segment-minute`,`day-name`) USING BTREE KEY_BLOCK_SIZE=32,
  KEY `PERIODICS` (`commence`,`finished`,`mode`,`typal`,`type`,`typeid`),
  KEY `INDICATING` (`mode`,`typal`,`type`,`typeid`,`hash`(11),`key`(16)),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class ImagesScores extends ImagesXoopsObject
{

	var $handler = 'ImagesScoresHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('statistic_id', XOBJ_DTYPE_INT, null, false);
        self::initVar('value', XOBJ_DTYPE_ENUM, null, false, false, imagesEnumeratorValues(basename(__FILE__), 'value'));
        self::initVar("mode", XOBJ_DTYPE_ENUM, '', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'mode'));
        self::initVar('field', XOBJ_DTYPE_ENUM, null, false, false, imagesEnumeratorValues(basename(__FILE__), 'field'));
        self::initVar('state', XOBJ_DTYPE_ENUM, null, false, false, imagesEnumeratorValues(basename(__FILE__), 'state'));
        self::initVar("typal", XOBJ_DTYPE_ENUM, '', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'typal'));
        self::initVar("type", XOBJ_DTYPE_ENUM, '', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'type'));
        self::initVar('typeid', XOBJ_DTYPE_INT, null, false);
        self::initVar('timezone', XOBJ_DTYPE_ENUM, null, false, false, imagesEnumeratorValues(basename(__FILE__), 'timezone'));
        self::initVar('written', XOBJ_DTYPE_INT, null, false);
        self::initVar('float', XOBJ_DTYPE_FLOAT, null, false);
        self::initVar('integer', XOBJ_DTYPE_FLOAT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for statistics_score
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class ImagesScoresHandler extends ImagesXoopsPersistableObjectHandler
{
	
    /**
     * 
     * @var array
     */
    var $_periodics = array();
    
	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'images_scores';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'ImagesScores';
	
	/**
	 * Child Object Identity Key
	 *
	 * @var string
	 */
	var $identity = 'id';
	
	/**
	 * Child Object Default Envaluing Costs
	 *
	 * @var string
	 */
	var $envalued = 'value';
	
    function __construct(&$db) 
    {
        self::$_periodics = array(      'hourly' => 3600, 'daily' => 3600 * 24, 'weekly' => 3600 * 24 * 7, 'biweekly' => 3600 * 24 * 7 * 2,
                                        'monthly' => 3600 * 24 * 7 * 4, 'quarterly' => 3600 * 24 * 7 * 4 * 4, 'yearly' => 3600 * 24 * 7 * 4 * 12    );
    	if (!is_object($db))
    		$db = $GLOBAL["xoopsDB"];
        parent::__construct($db, $this->tbl, $this->child, $this->identity, $this->envalued);
    }

    
    /**
     * inserts a new record into the database
     * 
     * {@inheritDoc}
     * @see XoopsPersistableObjectHandler::insert()
     */
    function insert(ImagesScores $object, $force = true)
    {
        if ($object->isNew())
        {
            if ($object->getVar('float')==0 && $object->getVar('integer')==0 )
                return -1;
            $object->setVar('timezone', time());
            $object->setVar('written', time());
        }
        return parent::insert($object, $force);
    }
    
    /**
     * get all itemised running score statistics_score matching a condition
     *
     * @param  CriteriaElement $criteria  {@link CriteriaElement} to match
     * @return array           of objects/array {@link XoopsObject}
     */
    public function getStatisticArray(CriteriaElement $criteria = null)
    {
        $sql   = "SELECT SUM(`stat`) as `sum`, MAXIMUM(`stat`) as `max`, MINIMUM(`stat`) as `min`, ADVERAGE(`stat`) as `adv`, STDEV(`stat`) as `std`, `end` as UNIX_TIMESTAMP() FROM `{$this->handler->table}`";
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($groupby = $criteria->getGroupby()) {
                $sql .= $groupby;
            }
            if ($sort = $criteria->getSort()) {
                $sql .= " ORDER BY {$sort} " . $criteria->getOrder();
                $orderSet = true;
            }
        }
        $result = $this->handler->db->query($sql, $limit, $start);
        return $this->handler->db->fetchArray($result);
    }
    
}
?>