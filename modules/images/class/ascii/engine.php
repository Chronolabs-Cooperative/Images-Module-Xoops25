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


class AsciiEngine
{
    
    /**
     * arrays of configs for this or child engine
     * 
     * @var array
     */
    var $_configs = array();
    
    /**
     * constructor
     * 
     * @param array $config
     */
    public static function __construct($config = array())
    {
        self::$_configs = $config;
    }
    
    /**
     * get config value or subvalue
     * 
     * @param string $element
     * @param string $node
     * @return boolean
     */
    public static function getConfig($element = '', $node = '', $field = '')
    {
        if (!empty($field) && !empty($node) && !empty($element))
            if (isset(self::$_configs[$element][$node][$field]) && !empty(self::$_configs[$element][$node]))
                return self::$_configs[$element][$node][$field];
        elseif (empty($field) && !empty($node) && !empty($element))
            if (isset(self::$_configs[$element][$node]) && !empty(self::$_configs[$element]))
                return self::$_configs[$element][$node];
        elseif (empty($node) && !empty($element))
            if (isset(self::$_configs[$element]))
                return self::$_configs[$element];
        return false;
    }
    
    
    /**
     * gets the ASCII Art
     *
     * @param string $image
     * @param number $width
     */
    public static function modeAvailable($mode = 'white')
    {
        return (self::getConfig('site', 'mode', $mode)?true:false);
    }
    
    /**
     * gets the ASCII Art
     * 
     * @param string $image
     * @param number $width
     */
    public static function getAsciiArt($image = '', $width = 80, $mode = 'white')
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
        $tmp = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($image) . "." . self::getConfig('site', 'image', 'type');
        shell_exec(str_replace('%destination', $tmp, str_replace('%source', $image, $imagesConfigList['convert_path'])));
        if (file_exists($tmp) && filesize($tmp) > 0)
        {
            $form = self::getConfig('forms', $mode);
            $fieldkeys = array_keys($form['fields']);
            $uri = $form['submit']['url'];
            $post = array();
            foreach($fieldkeys as $field)
            {
                if (!is_array($form['fields'][$field]))
                    $post[$field] = str_replace('%xoopsurl', XOOPS_URL, str_replace('%referee', XOOPS_URL . $_SERVER['REQUEST_URI'], str_replace('%image', "@$tmp", str_replace('%width', $width, $form['fields'][$field]))));
                else
                    $post[$field] = str_replace('%xoopsurl', XOOPS_URL, str_replace('%referee', XOOPS_URL . $_SERVER['REQUEST_URI'], str_replace('%image', "@$tmp", str_replace('%width', $width,  self::getHTMLItem(self::getURLData($form['fields'][$field]['uri'], 21, 25, $form['fields'][$field]['post']), $form['fields'][$field]['clause'], $form['fields'][$field]['item'], $form['fields'][$field]['return'])))));
            }
            $html = self::getURLData($uri, 120, 120, $post);
            unlink($tmp);
            if (!empty($html))
            {
                return self::getHTMLItem($html, self::getConfig('result', self::getConfig('result', 'method'), 'clause'), self::getConfig('result', self::getConfig('result', 'method'), 'item'));
            }
            return false;
        }
        if (function_exists('http_response_code'))
            http_response_code(501);
        die("Image Magick Convert Missing or Failed File Type!\n\nRemember on Ubuntu/Debian:\n\n\t$ sudo apt-get install imagemagic*");
    }
    
    /**
     * Gets Contents of a HTML Element Item by index number and DOM Tag Clause
     * 
     * @param string $html
     * @param string $clause
     * @param number $item
     * @return unknown|boolean
     */
    private function getHTMLItem($html = '', $clause = 'pre', $item = 0, $return = 'textContent')
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        if (is_a($dom, 'DOMDocument'))
            if ($node = $dom->getElementsByTagName($clause)->item($item))
                if (is_a($node, 'DOMNode'))
                    return $node->{$return};
        return false;
    }
    
    
    /* function getURIData()
     * cURL Routine for passing $_POST Variable and retreiving URL
     *
     * @author Simon Roberts (Chronolabs Cooperative) simon@staff.snails.email
     *
     * @param $url string
     * @param $timeout integer
     * @param $connectout integer
     * @param $posts array
     *
     * @return string
     */
    private function getURLData($uri = '', $timeout = 65, $connectout = 65, $posts = array())
    {
        global $imagesModule, $imagesConfigsList, $imagesConfigs, $imagesConfigsOptions;
        
        if (!function_exists("curl_init"))
        {
            die("You need to install cURL: $ sudo apt-get install php-curl");
        }
        if (!$art = curl_init($uri)) {
            return false;
        }
        curl_setopt($art, CURLOPT_HTTPHEADER, "Content-type: multipart/form-data");
        curl_setopt($art, CURLOPT_HEADER, false);
        curl_setopt($art, CURLOPT_POST, (count($posts)==0?false:true));
        if (count($posts)!=0)
            curl_setopt($art, CURLOPT_POSTFIELDS, http_build_query($posts));
        curl_setopt($art, CURLOPT_CONNECTTIMEOUT, $connectout);
        curl_setopt($art, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($art, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($art, CURLOPT_VERBOSE, false);
        curl_setopt($art, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($art, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($art, CURLOPT_COOKIE, true);
        if (!is_dir(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'curl'))
            mkdir(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'curl', 0777, true);
        curl_setopt($art, CURLOPT_COOKIEFILE, XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'curl' . DIRECTORY_SEPARATOR . parse_url($uri, PHP_URL_HOST) . '.cookie.jar');
        $data = curl_exec($art);
        curl_close($art);
        return $data;
    }
}


class AsciiEngineHandler 
{
    /**
     * array of engines
     * 
     * @var array
     */
    var $_engines = array();
    
    /**
     * array of engines configurations
     * 
     * @var array
     */
    var $_configs = array();
    
    /**
     * array of engines AsciiEngine Objects
     * 
     * @var array
     */
    var $_objects = array();
    
    /**
     * constructor
     * 
     * @throws Exception
     */
    public static function __construct()
    {
        if (!in_array('curl', get_loaded_extensions()))
        {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
        
        global $imagesModule, $imagesConfigsList, $imagesConfigs, $imagesConfigsOptions;
        self::loadEngines($imagesConfigsList['ascii']);
    }
    
    /**
     * Loads the ASCII Art Engines
     * 
     * @param array $engines
     */
    private function loadEngines($engines = array())
    {
        xoops_load('XoopsLists');
        foreach($engines as $engine)
        {
            if (in_array($engine, XoopsLists::getDirListAsArray(__DIR__)) && !in_array($engine, self::$_enginess))
            {
                if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $engine . DIRECTORY_SEPARATOR . 'ascii_engine.php'))
                    self::$_configs[$engine] = @include(__DIR__ . DIRECTORY_SEPARATOR . $engine . DIRECTORY_SEPARATOR . 'ascii_engine.php');
                if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $engine . DIRECTORY_SEPARATOR . $_configs[$engine]['class']['file']))
                {
                    require_once(__DIR__ . DIRECTORY_SEPARATOR . $engine . DIRECTORY_SEPARATOR . $_configs[$engine]['class']['file']);
                    $class = $_configs[$engine]['class']['name'];
                    if (class_exists($class))
                        self::$_objects[$engine] = new $class(self::$_configs[$engine]);
                }
                if (!empty(self::$_configs[$engine]) && is_array(self::$_configs[$engine]) && is_object(self::$_objects[$engine]))
                {
                    self::$_engines[$engine] = $engine;
                } else {
                    unset(self::$_configs[$engine]);
                    unset(self::$_objects[$engine]);
                }
            }
        }
    }
    
    
    /**
     * gets ascii art from the engine providers
     * 
     * @param string $image
     * @param number $width
     * @param string $mode
     * @param string $engine
     * @return string
     */
    public function getAsciiArt($image = '', $width = 80, $mode = 'white', $engine = 'random')
    {
        if (!file_exists($image))
        {
            if (function_exists('http_response_code'))
                http_response_code(501);
            die("Image Source Missing ~ " . str_replace(XOOPS_ROOT_PATH, 'XOOPS_ROOT_PATH:/', str_replace(XOOPS_VAR_PATH, 'XOOPS_VAR_PATH:/', str_replace(XOOPS_PATH, 'XOOPS_PATH:/', $image))));
        }
        
        if (!in_array($engine, array_keys(self::$_engines[$engine])))
        {
            $keys = array_keys(self::$_engines[$engine]);
            $engine = $keys[mt_rand(0, count($keys))];
        }
        
        if (!self::$_engines[$engine]->modeAvailable($mode))
        {
            $keys = array_keys(self::$_engines[$engine]);
            shuffle($keys);
            foreach($keys as $key)
                if (self::$_engines[$key]->modeAvailable($mode))
                {
                    $engine = $key;
                    continue;
                } else 
                    unset($keys[$key]);
            if (count($keys) == 0)
                die("Ascii Art Mode: $mode ~ is not supported by any of the engines!");
        }
        return self::$_engines[$engine]->getAsciiArt($image, $width, $mode);
    }
}

?>