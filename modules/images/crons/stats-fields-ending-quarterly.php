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

$period = 'quarterly';
$class = 'fields';
$state = 'ended';
$logic = "<=";

global $objectsConfigList;

include_once dirname(__DIR__) . "/header.php";
$GLOBALS["xoopsDB"]->queryF("START TRANSACTION");
$objectHandler = xoops_getModuleHandler($class, basename(dirname(__DIR__)));
$lestatHandler = xoops_getModuleHandler('statistics', basename(dirname(__DIR__)));
$criteria = new Criteria($state.'_'.$period, time(), $logic);
foreach($objectHandler->getObjects($criteria) as $object)
    if ($object->isStatistianEnding($period))
    {
        foreach($objectHandler->$_statistian_fields as $field)
        {
            $stats = $lestatHandler->create();
            $stats->setVar('hash', $object->getVar('hash'));
            $stats->setVar('key', "$class::$period::$field");
            $stats->setVar('stat', $object->getVar("$field_$period"));
            $stats->setVar('mode', $period);
            $stats->setVar('typal', $object->getFieldTypal());
            $stats->setVar('type', $class);
            $stats->setVar('typeid', $object->getVar('id'));
            if ($lestatHandler->insert($stats, true))
            {
                $object->setVar("$field_$period", 0);
            } else 
                die($GLOBALS["xoopsDB"]->queryF("ROLLBACK TRANSACTION"));
            
        }
        $timing = imagesStatisticalTiming($object->getValues(array('start_'.$period, 'ended_'.$period)));
        $object->setVar('start_'.$period, $timing['start_'.$period]);
        $object->setVar('ended_'.$period, $timing['ended_'.$period]);
        if (!$objectHandler->insert($object, true))
            die($GLOBALS["xoopsDB"]->queryF("ROLLBACK TRANSACTION"));
    }
}
$GLOBALS["xoopsDB"]->queryF("COMMIT");
?>