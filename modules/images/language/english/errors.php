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

define("IMAGES_ERRORS_ORIGINAL_WIDTH_CODE","100");
define("IMAGES_ERRORS_ORIGINAL_WIDTH_MESSAGE","The original source URL minimal width has not been met it is %spx and a width of %spx is required!");
define("IMAGES_ERRORS_ORIGINAL_HEIGHT_CODE","101");
define("IMAGES_ERRORS_ORIGINAL_HEIGHT_MESSAGE","The original source URL minimal height has not been met it is %spx and a height of %spx is required!");
define("IMAGES_ERRORS_EMAIL_NOT_SENDING_CODE","200");
define("IMAGES_ERRORS_EMAIL_NOT_SENDING_MESSAGE","You need to check the setting for postfix and mailman, for some reason the mail isn't transmitting!");