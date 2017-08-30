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


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'mainfile.php';
require_once __DIR__ . "/include/functions.php";

$myts =& MyTextSanitizer::getInstance();

global $imagesModule, $imagesConfigsList, $imagesConfigs, $imagesConfigsOptions;

if (empty($imagesModule))
{
	if (is_a($imagesModule = xoops_getHandler('module')->getByDirname(basename(__DIR__)), "XoopsModule"))
	{
		if (empty($imagesConfigsList))
		{
			$imagesConfigsList = images_load_config();
		}
		if (empty($imagesConfigs))
		{
			$imagesConfigs = xoops_getHandler('config')->getConfigs(new Criteria('conf_modid', $imagesModule->getVar('mid')));
		}
		if (empty($imagesConfigsOptions) && !empty($imagesConfigs))
		{
			foreach($imagesConfigs as $key => $config)
				$imagesConfigsOptions[$config->getVar('conf_name')] = $config->getConfOptions();
		}
	}
}

global $start, $limit, $op;

$op  		=  empty($_REQUEST["op"]) || !in_array($_REQUEST['op'], array('default', 'save')) ? 'default' : $_REQUEST["op"] ;
$start  	= intval( empty($_REQUEST["start"]) ? 0 : $_REQUEST["start"] );
$limit 		= intval( empty($_REQUEST["limit"]) ? $imagesConfigsList['items_perpage']: $_REQUEST["limit"] );
