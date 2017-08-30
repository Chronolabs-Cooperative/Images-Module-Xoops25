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

global $imagesConfigList;

include_once dirname(__DIR__) . "/header.php";

$userHandler = xoops_getHandler('users');
$imagesHandler = xoops_getModuleHandler('images', basename(dirname(__DIR__)));
$profileHandler = xoops_getModuleHandler('profile', 'profile');

foreach($imageConfigList['logo_fields'] as $field)
{
    $criteria = new CriteriaCompo(new Criteria($field, "('" . implode("', '", $imagesHandler->getFieldArray($field, 'url')) . "')", "NOT IN"));
    foreach($profileHandler->getObjects($criteria) as $profile)
    {
        $populate = false;
        if ($user = $userHandler->get($profile->getVar('profile_id')))
        {
            foreach($user->getGroups() as $groupid)
                if (in_array($groupid, $imageConfigList['populate_groups']))
                {
                    $populate = true;
                    continue;
                }
        }
        if ($populate == true)
        {
            $image = $imagesHandler->create();
            $image->setVar('uid', $profile->getVar('profile_id'));
            $image->setVar('field', $field);
            $image->setVar('url', $profile->getVar($field));
            $imagesHandler->insert($image, true);
        }
    }
    
}
?>