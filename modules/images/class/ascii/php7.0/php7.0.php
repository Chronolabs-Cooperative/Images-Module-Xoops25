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

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'engine.php';
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'WideImage' . DIRECTORY_SEPARATOR . 'WideImage.php';

class Php70AsciiArtEngine extends AsciiEngine
{
   
    function getAsciiArt($image = '', $width = 80, $mode = 'white')
    {
        global $imagesModule, $imagesConfigsList, $imagesConfigs, $imagesConfigsOptions;
        
        if (!self::modeAvailable($mode))
        {
            $keys = array_keys(self::getConfig('site', 'mode'));
            shuffle($keys);
            foreach($keys as $key)
                if (self::modeAvailable($key))
                {
                    $mode = $key;
                    continue;
                }
            
        }
        if ($width <= self::getConfig('site', 'width', 'minimum'))
            $width = self::getConfig('site', 'width', 'minimum') + 1;
        if ($width >= self::getConfig('site', 'width', 'maximum'))
            $width = self::getConfig('site', 'width', 'maximum') - 1;
        if (!file_exists($image))
        {
            if (function_exists('http_response_code'))
                http_response_code(501);
            die("Image Source Missing ~ " . str_replace(XOOPS_ROOT_PATH, 'XOOPS_ROOT_PATH:/', str_replace(XOOPS_VAR_PATH, 'XOOPS_VAR_PATH:/', str_replace(XOOPS_PATH, 'XOOPS_PATH:/', $image))));
        }
        $tmp = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($image) . "." . 'jpg';
        shell_exec(str_replace('%destination', $tmp, str_replace('%source', $image, $imagesConfigList['convert_path'])));
        if (file_exists($tmp) && filesize($tmp) > 0)
        {
            $img = WideImage::loadFromFile($tmp);
            $img->resize($width)->saveToFile($tmp);
            unset($img);
            $data = array();
            $image = imagecreatefromjpeg($tmp);
            if ($image) {
                $asciichars = array(    "white" => array("@", "#", "+", "*", ";", ":", ",", ".", "`", " "),
                                        "black" => array(" ", "`", ".", ",", ":", ";", "*", "+", "#", "@")      );
                $width = imagesx($image);
                $height = imagesy($image);
                for($y = 0; $y < $height; ++$y) {
                    $data[$y] = '';
                    for($x = 0; $x < $width; ++$x) {
                        $thiscol = imagecolorat($image, $x, $y);
                        $rgb = imagecolorsforindex($image, $thiscol);
                        $brightness = $rgb['red'] + $rgb['green'] + $rgb['blue'];
                        $brightness = round($brightness / 85);
                        $data[$y] .= $asciichars[$mode][$brightness];
                    }
                }
                unlink($tmp);
                return implode("\n", $data);
            }
            return false;
        }
        if (function_exists('http_response_code'))
            http_response_code(501);
        die("Image Magick Convert Missing or Failed File Type!\n\nRemember on Ubuntu/Debian:\n\n\t$ sudo apt-get install imagemagic*");
    }
}

?>