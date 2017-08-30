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

$ascengine = array();
$ascengine['class']['file']                 = basename(__DIR__).'.php';
$ascengine['class']['name']                 = str_replace(" ", "", ucwords(str_replace(array('-','_','.', ' ', basename(__DIR__))))) . 'AsciiArtEngine';
$ascengine['dirname']                       = basename(__DIR__);
$ascengine['version']                       = "1.00";
$ascengine['author']['realfullname']        = "Simon Antony Roberts";
$ascengine['author']['handle']              = "wishcraft";
$ascengine['author']['email']               = "wishcraft@users.sourceforge.net";

$ascengine['site']['url']                   = "";

$ascengine['site']['width']['maximum']      = 500;
$ascengine['site']['width']['minimum']      = 1;
$ascengine['site']['mode']['white']         = true;
$ascengine['site']['mode']['black']         = true;
$ascengine['site']['image']['type']         = 'jpg';
$ascengine['site']['image']['size']         = '0';

return $ascengine;