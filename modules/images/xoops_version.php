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


if (!defined('XOOPS_ROOT_PATH')) { exit(); }


$modversion = array();
$modversion["name"]         			     = IMAGES_MI_NAME;
$modversion["version"]      			     = IMAGES_MI_VERSION;
$modversion["description"]  			     = IMAGES_MI_DESCRIPTION;
$modversion["dirname"]      			     = basename(__DIR__);
$modversion['releasedate'] 				     = IMAGES_MI_RELEASEDATE;
$modversion['status']      				     = IMAGES_MI_STATUS;
$modversion['credits']     				     = IMAGES_MI_CREDITS;
$modversion['author']      				     = IMAGES_MI_AUTHORALIAS;
$modversion['help']        				     = IMAGES_MI_HELP;
$modversion['license']     				     = IMAGES_MI_LICENCE;
$modversion['academic']    				     = IMAGES_MI_ACADEMIC;
$modversion['official']    				     = IMAGES_MI_OFFICAL;
$modversion['image']       				     = IMAGES_MI_ICON;
$modversion['dirmoduleadmin'] 			     = IMAGES_MI_ADMINMODDIR;
$modversion['icons16'] 					     = IMAGES_MI_ADMINICON16;
$modversion['icons32'] 					     = IMAGES_MI_ADMINICON32;
$modversion['author']['realname'] 		     = IMAGES_MI_AUTHORREALNAME;
$modversion['author']['website']['url']      = IMAGES_MI_AUTHORWEBSITE;
$modversion['author']['website']['name'] 	 = IMAGES_MI_AUTHORSITENAME;
$modversion['author']['email'] 			     = IMAGES_MI_AUTHOREMAIL;
$modversion['author']['word'] 				 = IMAGES_MI_AUTHORWORD;
$modversion['author']['feed'] 				 = IMAGES_MI_AUTHORFEED;
$modversion['warning']['install'] 			 = IMAGES_MI_WARNINGS_INSTALL;
$modversion['warning']['update'] 			 = IMAGES_MI_WARNINGS_UPDATE;
$modversion['warning']['uninstall'] 	     = IMAGES_MI_WARNINGS_UNINSTALL;
$modversion['demo']['site']['url'] 			 = IMAGES_MI_DEMO_SITEURL;
$modversion['demo']['site']['name'] 		 = IMAGES_MI_DEMO_SITENAME;
$modversion['support']['site']['url'] 		 = IMAGES_MI_SUPPORT_SITEURL;
$modversion['support']['site']['name'] 		 = IMAGES_MI_SUPPORT_SITENAME;
$modversion['submit']['form']['feature'] 	 = IMAGES_MI_SUPPORT_FEATUREREQUEST;
$modversion['submit']['form']['bug'] 		 = IMAGES_MI_SUPPORT_BUGREPORTING;

// People Arrays
$modversion['people']['developers']['wishcraft']['name'] = 'Simon Antony Roberts';
$modversion['people']['developers']['wishcraft']['email'] = 'wishcraft@users.sourceforge.net';
$modversion['people']['developers']['wishcraft']['handle'] = 'wishcraft';
$modversion['people']['developers']['wishcraft']['version'] = array('1.00', '1.01', '1.05');
$modversion['people']['testers'] = array();
$modversion['people']['translaters'] = array();
$modversion['people']['documenters'] = array();

// Releases Identity Hashes
$modversion['keys']['module']        	= 'imagesUITU432536';
$modversion['keys']['release']          = '11432fdfr37ryhf';

// Requirements
$modversion['minimal']['php']        	= '7.0';
$modversion['minimal']['xoops']      	= '2.5.8';
$modversion['minimal']['db']         	= array('mysql' => '5.0.7', 'mysqli' => '5.0.7');
$modversion['minimal']['admin']      	= '1.1';

// database tables
$modversion["sqlfile"]["mysql"] 		= "sql/mysql.sql";
$modversion["tables"] 					= array(
												"images_images",
											);

// Main
$modversion['hasMain'] 					= IMAGES_MI_HASMAIN;

// Admin
$modversion['hasAdmin'] 				= IMAGES_MI_HASADMIN;
$modversion['adminindex']  				= "admin/index.php";
$modversion['adminmenu']   				= "admin/menu.php";
$modversion['system_menu'] 				= 1;

// Search
$modversion["hasSearch"] 				= IMAGES_MI_HASSEARCH;
$modversion['search']['file'] 			= "include/search.inc.php";
$modversion['search']['func'] 			= "IMAGES_search";

// Comments
$modversion["hasComments"] 				= IMAGES_MI_HASCOMMENTS;

//$modversion["onInstall"] 				= "include/action.module.php";
//$modversion["onUpdate"] 				= "include/action.module.php";
//$modversion["onUninstall"] 				= "include/action.module.php";

// Use smarty
$modversion["use_smarty"] 				= true;

// Add extra menu items
if (is_object($GLOBALS['xoopsUser']))
{
	$modversion['sub'][1]['name'] = IMAGES_MI_MENU_CHECKIMAGES;
	$modversion['sub'][1]['url']  = "check.php";
}

// Blocks
$modversion['blocks']    				= array();

// Config categories
$modversion['configcat']['seo']['name']        			= IMAGES_MI_CONFCAT_SEO;
$modversion['configcat']['seo']['description'] 			= IMAGES_MI_CONFCAT_SEO_DESC;
$modversion['configcat']['module']['name']        		= IMAGES_MI_CONFCAT_MODULE;
$modversion['configcat']['module']['description'] 		= IMAGES_MI_CONFCAT_MODULE_DESC;
$modversion['configcat']['paths']['name']        		= IMAGES_MI_CONFCAT_PATHS;
$modversion['configcat']['paths']['description'] 		= IMAGES_MI_CONFCAT_PATHS_DESC;
$modversion['configcat']['times']['name']        		= IMAGES_MI_CONFCAT_TIMES;
$modversion['configcat']['times']['description'] 		= IMAGES_MI_CONFCAT_TIMES_DESC;

// Configs
$modversion["config"] 					= array();
$modversion["config"][] 				= array(
													"name"          => "htaccess",
													"title"         => "IMAGES_MI_HTACCESS",
													"description"   => "IMAGES_MI_HTACCESS_DESC",
													"formtype"      => "yesno",
													"valuetype"     => "int",
													"default"       => false,
													"category"		=> "seo"
											);

$modversion["config"][] 				= array(
													"name"          => "base",
													"title"         => "IMAGES_MI_BASE",
													"description"   => "IMAGES_MI_BASE_DESC",
													"formtype"      => "text",
													"valuetype"     => "text",
													"default"       => "images",
													"category"		=> "seo"
											);

$modversion["config"][] 				= array(
                                                    "name"          => "html",
                                                    "title"         => "IMAGES_MI_HTML",
                                                    "description"   => "IMAGES_MI_HTML_DESC",
                                                    "formtype"      => "text",
                                                    "valuetype"     => "text",
                                                    "default"       => ".html",
                                                    "category"		=> "seo"
                                                );
                                                

$modversion["config"][] 				= array(
													"name"          => "png",
													"title"         => "IMAGES_MI_PNG",
													"description"   => "IMAGES_MI_PNG_DESC",
													"formtype"      => "text",
													"valuetype"     => "text",
													"default"       => ".png",
													"category"		=> "seo"
											);

$modversion["config"][] 				= array(
                                                    "name"          => "jpg",
                                                    "title"         => "IMAGES_MI_JPG",
                                                    "description"   => "IMAGES_MI_JPG_DESC",
                                                    "formtype"      => "text",
                                                    "valuetype"     => "text",
                                                    "default"       => ".jpg",
                                                    "category"		=> "seo"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "ascii",
                                                    "title"         => "IMAGES_MI_ASCII",
                                                    "description"   => "IMAGES_MI_ASCII_DESC",
                                                    "formtype"      => "text",
                                                    "valuetype"     => "text",
                                                    "default"       => ".txt",
                                                    "category"		=> "seo"
                                                );

$modversion["config"][] 				= array(
													"name"          => "tmp_path",
													"title"         => "IMAGES_MI_TMP_PATH",
													"description"   => "IMAGES_MI_TMP_PATH_DESC",
													"formtype"      => "textbox",
													"valuetype"     => "text",
													"default"       => "/tmp",
													"category"		=> "paths"
											);

$modversion["config"][] 				= array(
                                                    "name"          => "data_path",
                                                    "title"         => "IMAGES_MI_DATA_PATH",
                                                    "description"   => "IMAGES_MI_DATA_PATH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "text",
                                                    "default"       => basename(__DIR__),
                                                    "category"		=> "paths"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "history_data_path",
                                                    "title"         => "IMAGES_MI_HISTORY_DATA_PATH",
                                                    "description"   => "IMAGES_MI_HISTORY_DATA_PATH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "text",
                                                    "default"       => basename(__DIR__).'-history',
                                                    "category"		=> "paths"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "convert_path",
                                                    "title"         => "IMAGES_MI_CONVERT_PATH",
                                                    "description"   => "IMAGES_MI_CONVERT_PATH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "text",
                                                    "default"       => "/usr/bin/convert -antialias -auto-gamma -auto-level \"%source\" \"%destination\"",
                                                    "category"		=> "paths"
                                                );
$options = array();
for($d=2;$d<=96;$d++)
    $options[($d * (24*3600))] = "$d Days";
$modversion["config"][] 				= array(
                                                    "name"          => "checking",
                                                    "title"         => "IMAGES_MI_CHECKING",
                                                    "description"   => "IMAGES_MI_CHECKING_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(5,31)*(24*3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "emailing",
                                                    "title"         => "IMAGES_MI_EMAILING",
                                                    "description"   => "IMAGES_MI_EMAILING_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(3,7)*(24*3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );

$options = array();
for($d=2;$d<=48;$d++)
{
    $options[($d * (3600))] = "$d Hours";
    $options[($d * (3600) + (3600/2))] = "$d Hours 30 Minutes";
}

$modversion["config"][] 				= array(
                                                    "name"          => "minimal_preload_wait",
                                                    "title"         => "IMAGES_MI_MINIMAL_PRELOAD_WAIT",
                                                    "description"   => "IMAGES_MI_MINIMAL_PRELOAD_WAIT_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(2,7)*(3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_preload_wait",
                                                    "title"         => "IMAGES_MI_MAXIMUM_PRELOAD_WAIT",
                                                    "description"   => "IMAGES_MI_MAXIMUM_PRELOAD_WAIT_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(8,21)*(3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );
$modversion["config"][] 				= array(
                                                    "name"          => "minimal_cache_wait",
                                                    "title"         => "IMAGES_MI_MINIMAL_CACHE_WAIT",
                                                    "description"   => "IMAGES_MI_MINIMAL_CACHE_WAIT_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(2,7)*(3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_cache_wait",
                                                    "title"         => "IMAGES_MI_MAXIMUM_CACHE_WAIT",
                                                    "description"   => "IMAGES_MI_MAXIMUM_CACHE_WAIT_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "int",
                                                    "default"       => mt_rand(8,21)*(3600),
                                                    "options"       => $options,
                                                    "category"		=> "times"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "crons_type",
                                                    "title"         => "IMAGES_MI_CRONS_TYPE",
                                                    "description"   => "IMAGES_MI_CRONS_TYPE_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "text",
                                                    "default"       => 'preloads',
                                                    "options"       => array('preloads' => IMAGES_MI_CRONS_TYPE_PRELOADS, 'cronjobs' => IMAGES_MI_CRONS_TYPE_CRONJOBS),
                                                    "category"		=> "times"
                                                );

if (xoops_getHandler('module')->getCount(new Criteria('dirname', 'profile')) > 0)
{
    $fieldsHandler = xoops_getModuleHandler('fields', 'profile');
    $options = array();
    $criteria = new CriteriaCompo(new Criteria('field_weight', '0', "<>"));
    $criteria->setSort('`cat_id` ASC, `field_weight`');
    $criteria->setOrder('ASC');
    foreach($fieldsHandler->getObjects($criteria) as $key => $field)
    {
        $options[$field->getVar('field_name')] = (!defined($field->getVar('field_title'))?$field->getVar('field_title'):constant($field->getVar('field_title')));
    }
} else
    $options = array();
$modversion["config"][] 				= array(
                                                    "name"          => "ascii_fields",
                                                    "title"         => "IMAGES_MI_ASCII_FIELDS",
                                                    "description"   => "IMAGES_MI_ASCII_FIELDS_DESC",
                                                    "formtype"      => "select_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array("group_icon_url","group_logo_url"),
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "icons_fields",
                                                    "title"         => "IMAGES_MI_ICONS_FIELDS",
                                                    "description"   => "IMAGES_MI_ICONS_FIELDS_DESC",
                                                    "formtype"      => "select_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array("group_icon_url"),
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );
                                                
$modversion["config"][] 				= array(
                                                    "name"          => "logo_fields",
                                                    "title"         => "IMAGES_MI_LOGO_FIELDS",
                                                    "description"   => "IMAGES_MI_LOGO_FIELDS_DESC",
                                                    "formtype"      => "select_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array("group_logo_url"),
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "photo_fields",
                                                    "title"         => "IMAGES_MI_PHOTO_FIELDS",
                                                    "description"   => "IMAGES_MI_PHOTO_FIELDS_DESC",
                                                    "formtype"      => "select_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array("author_photo_url"),
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "avatar_fields",
                                                    "title"         => "IMAGES_MI_AVARTA_FIELDS",
                                                    "description"   => "IMAGES_MI_AVATAR_FIELDS_DESC",
                                                    "formtype"      => "select_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array("group_icon_url","group_logo_url","author_photo_url","author_avatar_url"),
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "moderator_groups",
                                                    "title"         => "IMAGES_MI_MODERATOR_GROUPS",
                                                    "description"   => "IMAGES_MI_MODERATOR_GROUPS_DESC",
                                                    "formtype"      => "group_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array(XOOPS_GROUP_ADMIN=>XOOPS_GROUP_ADMIN),
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "reporting_groups",
                                                    "title"         => "IMAGES_MI_REPORTING_GROUPS",
                                                    "description"   => "IMAGES_MI_REPORTING_GROUPS_DESC",
                                                    "formtype"      => "group_multi",
                                                    "valuetype"     => "array",
                                                    "default"       => array(XOOPS_GROUP_ADMIN=>XOOPS_GROUP_ADMIN),
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
													"name"          => "populate_groups",
													"title"         => "IMAGES_MI_POPULATE_GROUPS",
													"description"   => "IMAGES_MI_POPULATE_GROUPS_DESC",
													"formtype"      => "group_multi",
													"valuetype"     => "array",
													"default"       => explode(",", XOOPS_GROUPS_EXTRA),
													"category"		=> "module"
											);

$modversion["config"][] 				= array(
                                                    "name"          => "storage",
                                                    "title"         => "IMAGES_MI_STORAGE",
                                                    "description"   => "IMAGES_MI_STORAGE_DESC",
                                                    "formtype"      => "radio",
                                                    "valuetype"     => "text",
                                                    "default"       => "files",
                                                    "options"       => array("files"=>IMAGES_MI_STORAGE_FILES, "database"=>IMAGES_MI_STORAGE_DATABASE),
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "format",
                                                    "title"         => "IMAGES_MI_FORMAT",
                                                    "description"   => "IMAGES_MI_FORMAT_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "text",
                                                    "default"       => "png",
                                                    "options"       => array("jpg"=>IMAGES_MI_FORMAT_JPG, "png"=>IMAGES_MI_FORMAT_PNG, "gif"=>IMAGES_MI_FORMAT_GIF),
                                                    "category"		=> "module"
                                                );
xoops_load('XoopsLists');
$options = XoopsLists::getDirListAsArray(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'ascii');

$modversion["config"][] 				= array(
                                                    "name"          => "ascii_engine",
                                                    "title"         => "IMAGES_MI_ASCII_ENGINE",
                                                    "description"   => "IMAGES_MI_ASCII_ENGINE_DESC",
                                                    "formtype"      => "select",
                                                    "valuetype"     => "text",
                                                    "default"       => 'text-image.com',
                                                    "options"       => $options,
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "ascii_small_width",
                                                    "title"         => "IMAGES_MI_ASCII_SMALL_WIDTH",
                                                    "description"   => "IMAGES_MI_ASCII_SMALL_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '28',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "ascii_medium_width",
                                                    "title"         => "IMAGES_MI_ASCII_MEDIUM_WIDTH",
                                                    "description"   => "IMAGES_MI_ASCII_MEDIUM_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '60',
                                                    "category"		=> "module"
                                                );
                                                
$modversion["config"][] 				= array(
                                                    "name"          => "ascii_large_width",
                                                    "title"         => "IMAGES_MI_ASCII_LARGE_WIDTH",
                                                    "description"   => "IMAGES_MI_ASCII_LARGE_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '124',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "icons_width",
                                                    "title"         => "IMAGES_MI_ICONS_WIDTH",
                                                    "description"   => "IMAGES_MI_ICONS_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "128",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "icons_height",
                                                    "title"         => "IMAGES_MI_ICONS_HEIGHT",
                                                    "description"   => "IMAGES_MI_ICONS_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '128',
                                                    "category"		=> "module"
                                                );


$modversion["config"][] 				= array(
                                                    "name"          => "logo_width",
                                                    "title"         => "IMAGES_MI_LOGO_WIDTH",
                                                    "description"   => "IMAGES_MI_LOGO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "128",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "logo_height",
                                                    "title"         => "IMAGES_MI_LOGO_HEIGHT",
                                                    "description"   => "IMAGES_MI_LOGO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '128',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "photo_width",
                                                    "title"         => "IMAGES_MI_PHOTO_WIDTH",
                                                    "description"   => "IMAGES_MI_PHOTO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "1024",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "photo_height",
                                                    "title"         => "IMAGES_MI_PHOTO_HEIGHT",
                                                    "description"   => "IMAGES_MI_PHOTO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '1024',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "avatar_width",
                                                    "title"         => "IMAGES_MI_AVATAR_WIDTH",
                                                    "description"   => "IMAGES_MI_AVATAR_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "256",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "avatar_height",
                                                    "title"         => "IMAGES_MI_AVATAR_HEIGHT",
                                                    "description"   => "IMAGES_MI_AVATAR_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '256',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_icons_width",
                                                    "title"         => "IMAGES_MI_MAXIMUM_ICONS_WIDTH",
                                                    "description"   => "IMAGES_MI_MAXIMUM_ICONS_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "1024",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_icons_height",
                                                    "title"         => "IMAGES_MI_MAXIMUM_ICONS_HEIGHT",
                                                    "description"   => "IMAGES_MI_MAXIMUM_ICONS_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '1024',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_logo_width",
                                                    "title"         => "IMAGES_MI_MAXIMUM_LOGO_WIDTH",
                                                    "description"   => "IMAGES_MI_MAXIMUM_LOGO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "2048",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_logo_height",
                                                    "title"         => "IMAGES_MI_MAXIMUM_LOGO_HEIGHT",
                                                    "description"   => "IMAGES_MI_MAXIMUM_LOGO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '2048',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_photo_width",
                                                    "title"         => "IMAGES_MI_MAXIMUM_PHOTO_WIDTH",
                                                    "description"   => "IMAGES_MI_MAXIMUM_PHOTO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "3076",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_photo_height",
                                                    "title"         => "IMAGES_MI_MAXIMUM_PHOTO_HEIGHT",
                                                    "description"   => "IMAGES_MI_MAXIMUM_PHOTO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '3076',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "maximum_avatar_width",
                                                    "title"         => "IMAGES_MI_MAXIMUM_AVATAR_WIDTH",
                                                    "description"   => "IMAGES_MI_MAXIMUM_AVATAR_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "796",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_icons_width",
                                                    "title"         => "IMAGES_MI_MINUMUM_ICONS_WIDTH",
                                                    "description"   => "IMAGES_MI_MINUMUM_ICONS_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "48",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_icons_height",
                                                    "title"         => "IMAGES_MI_MINUMUM_ICONS_HEIGHT",
                                                    "description"   => "IMAGES_MI_MINUMUM_ICONS_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '48',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_logo_width",
                                                    "title"         => "IMAGES_MI_MINUMUM_LOGO_WIDTH",
                                                    "description"   => "IMAGES_MI_MINUMUM_LOGO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "128",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_logo_height",
                                                    "title"         => "IMAGES_MI_MINUMUM_LOGO_HEIGHT",
                                                    "description"   => "IMAGES_MI_MINUMUM_LOGO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '128',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_photo_width",
                                                    "title"         => "IMAGES_MI_MINUMUM_PHOTO_WIDTH",
                                                    "description"   => "IMAGES_MI_MINUMUM_PHOTO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "320",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_photo_height",
                                                    "title"         => "IMAGES_MI_MINUMUM_PHOTO_HEIGHT",
                                                    "description"   => "IMAGES_MI_MINUMUM_PHOTO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '320',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_avatar_width",
                                                    "title"         => "IMAGES_MI_MINUMUM_AVATAR_WIDTH",
                                                    "description"   => "IMAGES_MI_MINUMUM_AVATAR_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "100",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "minimum_avatar_height",
                                                    "title"         => "IMAGES_MI_MINUMUM_AVATAR_HEIGHT",
                                                    "description"   => "IMAGES_MI_MINUMUM_AVATAR_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '100',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_icons_width",
                                                    "title"         => "IMAGES_MI_ORIGINAL_ICONS_WIDTH",
                                                    "description"   => "IMAGES_MI_ORIGINAL_ICONS_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "128",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_icons_height",
                                                    "title"         => "IMAGES_MI_ORIGINAL_ICONS_HEIGHT",
                                                    "description"   => "IMAGES_MI_ORIGINAL_ICONS_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '128',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_logo_width",
                                                    "title"         => "IMAGES_MI_ORIGINAL_LOGO_WIDTH",
                                                    "description"   => "IMAGES_MI_ORIGINAL_LOGO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "512",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_logo_height",
                                                    "title"         => "IMAGES_MI_ORIGINAL_LOGO_HEIGHT",
                                                    "description"   => "IMAGES_MI_ORIGINAL_LOGO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '512',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_photo_width",
                                                    "title"         => "IMAGES_MI_ORIGINAL_PHOTO_WIDTH",
                                                    "description"   => "IMAGES_MI_ORIGINAL_PHOTO_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "1024",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_photo_height",
                                                    "title"         => "IMAGES_MI_ORIGINAL_PHOTO_HEIGHT",
                                                    "description"   => "IMAGES_MI_ORIGINAL_PHOTO_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '1024',
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_avatar_width",
                                                    "title"         => "IMAGES_MI_ORIGINAL_AVATAR_WIDTH",
                                                    "description"   => "IMAGES_MI_ORIGINAL_AVATAR_WIDTH_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "valuetype"     => "210",
                                                    "category"		=> "module"
                                                );

$modversion["config"][] 				= array(
                                                    "name"          => "original_avatar_height",
                                                    "title"         => "IMAGES_MI_ORIGINAL_AVATAR_HEIGHT",
                                                    "description"   => "IMAGES_MI_ORIGINAL_AVATAR_HEIGHT_DESC",
                                                    "formtype"      => "textbox",
                                                    "valuetype"     => "int",
                                                    "default"       => '210',
                                                    "category"		=> "module"
                                                );

// Notification

$modversion["hasNotification"] 			= 0;
$modversion["notification"] 			= array();
?>