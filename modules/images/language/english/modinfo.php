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

// Module definition headers for xoops_version.php
define('IMAGES_MI_NAME','Webdav Control');
define('IMAGES_MI_VERSION','1.01');
define('IMAGES_MI_RELEASEDATE','30-07-2017');
define('IMAGES_MI_STATUS','release');
define('IMAGES_MI_DESCRIPTION','User Webdav Controller');
define('IMAGES_MI_CREDITS','Mynamesnot, Wishcraft');
define('IMAGES_MI_AUTHORALIAS','wishcraft');
define('IMAGES_MI_HELP','page=help');
define('IMAGES_MI_LICENCE','gpl3+academic');
define('IMAGES_MI_OFFICAL','1');
define('IMAGES_MI_ICON','images/mlogo.png');
define('IMAGES_MI_WEBSITE','http://au.syd.snails.email');
define('IMAGES_MI_ADMINMODDIR','/Frameworks/moduleclasses/moduleadmin');
define('IMAGES_MI_ADMINICON16','../../Frameworks/moduleclasses/icons/16');
define('IMAGES_MI_ADMINICON32','../../Frameworks/moduleclasses/icons/32');
define('IMAGES_MI_RELEASEINFO',__DIR__ . DIRECTORY_SEPARATOR . 'release.nfo');
define('IMAGES_MI_RELEASEXCODE',__DIR__ . DIRECTORY_SEPARATOR . 'release.xcode');
define('IMAGES_MI_RELEASEFILE','https://sourceforge.net/projects/chronolabs/files/XOOPS%202.5/Modules/webdav/xoops2.5_IMAGES_1.03.7z/download');
define('IMAGES_MI_AUTHORREALNAME','Simon Antony Roberts');
define('IMAGES_MI_AUTHORWEBSITE','http://internetfounder.wordpress.com');
define('IMAGES_MI_AUTHORSITENAME','Exhumations from the desks of Chronographics');
define('IMAGES_MI_AUTHOREMAIL','simon@snails.email');
define('IMAGES_MI_AUTHORWORD','');
define('IMAGES_MI_WARNINGS','');
define('IMAGES_MI_DEMO_SITEURL','');
define('IMAGES_MI_DEMO_SITENAME','');
define('IMAGES_MI_SUPPORT_SITEURL','');
define('IMAGES_MI_SUPPORT_SITENAME','');
define('IMAGES_MI_SUPPORT_FEATUREREQUEST','');
define('IMAGES_MI_SUPPORT_BUGREPORTING','');
define('IMAGES_MI_DEVELOPERS','Simon Roberts (Wishcraft)'); // Sperated by a Pipe (|)
define('IMAGES_MI_TESTERS',''); // Sperated by a Pipe (|)
define('IMAGES_MI_TRANSLATERS',''); // Sperated by a Pipe (|)
define('IMAGES_MI_DOCUMENTERS',''); // Sperated by a Pipe (|)
define('IMAGES_MI_HASSEARCH',false);
define('IMAGES_MI_HASMAIN',true);
define('IMAGES_MI_HASADMIN',true);
define('IMAGES_MI_HASCOMMENTS',false);

// Admin Menu
define("IMAGES_MI_ADMENU_INDEX","Admin Homepage");
define("IMAGES_MI_ADMENU_LANGUAGES","Languages Admin");
define("IMAGES_MI_ADMENU_REQUESTS","Language Requests");
define("IMAGES_MI_ADMENU_HTACCESS", ".htaccess Config");
define("IMAGES_MI_ADMENU_ABOUT", "About Languages");

//Main Menu
define("IMAGES_MI_MENU_REQUESTS", "Request New Language");

// Configguration Categories
define('IMAGES_MI_CONFCAT_SEO','Search Engine Optimization');
define('IMAGES_MI_CONFCAT_SEO_DESC','');

// Configuration Descriptions and Titles
define('IMAGES_MI_HTACCESS','.htaccess SEO URL');
define('IMAGES_MI_HTACCESS_DESC','');
define('IMAGES_MI_BASE','Base .htaccess path');
define('IMAGES_MI_BASE_DESC','');
define('IMAGES_MI_HTML','Extension for HTML output with SEO URL');
define('IMAGES_MI_HTML_DESC','');
define("IMAGES_MI_ITEMSPERPAGE","Items per page");
define("IMAGES_MI_ITEMSPERPAGE_DESC","");

?>