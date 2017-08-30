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


include_once __DIR__ . "/header.php";

$GLOBALS['xoopsLogger']->activated = false;
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

$fieldsHandler = xoops_getModuleHandler('fields', basename(__DIR__));
$imagesHandler = xoops_getModuleHandler('images', basename(__DIR__));

if ($field = $fieldsHandler->getByHash($_REQUEST['field'], $_REQUEST['typal']))
{
    if ($image = $imagesHandler->getByHash($_REQUEST['hash'], $field->getVar('field')))
    {
        if (isset($_REQUEST['width']) && !empty($_REQUEST['width']))
            $width = $_REQUEST['width'];
        if (isset($_REQUEST['height']) && !empty($_REQUEST['height']))
            $height = $_REQUEST['height'];
        else 
            $height = $width;
        
        switch((isset($_REQUEST['format']) && !empty($_REQUEST['format'])?$_REQUEST['format']:'default'))
        {
            default:
            case $imagesConfigList['png']:
                $result = $image->getImageData('png', $width, $height);
                break;
            case $imagesConfigList['jpg']:
                $result = $image->getImageData('jpg', $width, $height);
                break;
            case $imagesConfigList['gif']:
                $result = $image->getImageData('gif', $width, $height);
                break;
            case $imagesConfigList['txt']:
                switch((isset($_REQUEST['scale']) && !empty($_REQUEST['scale'])?$_REQUEST['scale']:'default'))
                {
                    default:
                        $result = $image->getImageData('ascii', ($width<=0?$imagesConfigList['ascii_medium_width']:$width));
                        break;
                    case 'small':
                        $result = $image->getImageData('ascii', $imagesConfigList['ascii_small_width']);
                        break;
                    case 'medium':
                        $result = $image->getImageData('ascii', $imagesConfigList['ascii_medium_width']);
                        break;
                    case 'large':
                        $result = $image->getImageData('ascii', $imagesConfigList['ascii_large_width']);
                        break;
                break;
            }
        }
        if (!empty($result['data']))
        {
            if(ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
            if (function_exists('http_response_code'))
                http_response_code(201);
            header('Content-Type: ' . $result['mimetype']); 
            die($result['data']);
        }
    }
}
if (function_exists('http_response_code'))
    http_response_code(501);
die("No Resulting Images Found for Hash Keys!");
?>