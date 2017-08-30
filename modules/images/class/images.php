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


 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'objects.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'xcp' . DIRECTORY_SEPARATOR . 'xcp.class.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ascii' . DIRECTORY_SEPARATOR . 'engine.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'WideImage' . DIRECTORY_SEPARATOR . 'WideImage.php';

class ImagesImages extends ImagesXoopsObject
{
    /**
     * Constructor
     *
     * @param int $id ID of the tag, deprecated
     */
	function __construct($id = null)
	{
		$this->initVar("id",        XOBJ_DTYPE_INT,    		null, false);
		$this->initVar("uid",       XOBJ_DTYPE_INT,    		null, false);
		$this->initVar("hash",	    XOBJ_DTYPE_TXTBOX,    	null, false, 16);
		$this->initVar("field",     XOBJ_DTYPE_TXTBOX,    	null, false, 64);
		$this->initVar("type",      XOBJ_DTYPE_ENUM,     	'unknown', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'type'));
		$this->initVar("storage",   XOBJ_DTYPE_ENUM,     	'files', false, false, false, imagesEnumeratorValues(basename(__FILE__), 'storage'));
		$this->initVar("md5",       XOBJ_DTYPE_TXTBOX,     	null, false, 32);
		$this->initVar("url",       XOBJ_DTYPE_TXTBOX,     	null, false, 255);
		$this->initVar("width",     XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("height",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("bytes",     XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("views",     XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("viewed",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("updates",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("errors",    XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("megabytes", XOBJ_DTYPE_FLOAT,     	null, false);
		$this->initVar("updated",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("created",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("checked",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("errored",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("emailed",   XOBJ_DTYPE_INT,     	null, false);
		$this->initVar("data",      XOBJ_DTYPE_OTHER,     	null, false);
	}
	
	/**
	 * destructor
	 * 
	 */
	function __destruct()
	{
	    $changed = false;
	    if (!$this->isNew())
	    {
    	    if (self::$_vars['md5']['changed'] == true)
    	        $changed = true;
            if (self::$_vars['url']['changed'] == true)
                $changed = true;
            if (self::$_vars['checked']['changed'] == true)
                $changed = true;
            if (self::$_vars['data']['changed'] == true)
                $changed = true;
            if (self::$_vars['emailed']['changed'] == true)
                $changed = true;
	    }
	    if ($changed == true)
	        xoops_getModuleHandler('images', basename(dirname(__DIR__)))->insert($this, true);
	}
	
	/**
	 * gets a Temporary file for the image data
	 * 
	 * @return string|boolean
	 */
	public function getTmpFileSource()
	{
	    static $tmp = '';
	    if (!empty($tmp) && file_exists($tmp) && filesize($tmp) > 0)
	        return $tmp;
	    
	    global $imagesConfigList;
	    if (self::getVar('storage') == 'database')
	    {
	        if (!is_dir($imagesConfigList['tmp_path']))
	            mkdir($imagesConfigList['tmp_path'], 0777, true);
	        $tmp = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5(microtime(true).self::getVar('data').microtime(true)) . "." . self::getVar('type');
	        file_put_contents($tmp, self::getVar('data'));
	        if (file_exists($tmp) && filesize($tmp) > 0)
	            return $tmp;
	    } elseif (self::getVar('storage') == 'files')
	    {
	        if (!is_dir($imagesConfigList['tmp_path']))
	            mkdir($imagesConfigList['tmp_path'], 0777, true);
	        $tmp = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5(microtime(true).self::getVar('data').microtime(true)) . "." . self::getVar('type');
	        if (file_exists($source = XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . self::getVar('data')))
	            copy($source, $tmp);
            if (file_exists($tmp) && filesize($tmp) > 0)
                return $tmp;
	    }
	    return false;
	}
	
	/**
	 * Adds View(s) count to object
	 * 
	 * @param number $number
	 * @return unknown
	 */
	public function addViews($number = 1)
	{
	    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_images") . "` SET `views` = `views` + $number, `viewed` = UNIX_TIMESTAMP() WHERE `id` = " . self::getVar('id');
	    @$GLOBALS['xoopsDB']->queryF($sql);
	    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_fields") . "` SET `views` = `views` + $number, `viewed` = UNIX_TIMESTAMP() WHERE `field` = '" . self::getVar('field') . "'";
	    @$GLOBALS['xoopsDB']->queryF($sql);
	}
	
	
	/**
	 * Adds megabyte count to object
	 *
	 * @param number $bytes
	 * @return unknown
	 */
	public function addMegabytes($bytes = 0)
	{
	    $megabytes = $bytes / 1024 / 1024;
	    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_images") . "` SET `megabytes` = `megabytes` + '$megabytes', `updated` = UNIX_TIMESTAMP() WHERE `id` = " . self::getVar('id');
	    @$GLOBALS['xoopsDB']->queryF($sql);
	    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix("images_fields") . "` SET `megabytes` = `megabytes` + '$megabytes' WHERE `field` = '" . self::getVar('field') . "'";
	    @$GLOBALS['xoopsDB']->queryF($sql);
	}
	
	/**
     * checks the URL for a new MD5 and updates it if it exists
	 */
	public function check()
	{
	    global $imagesConfigList;
	    if (self::getVar('checked') > time())
	        return false;
	    $data = self::getURLData(self::getVar('url'));
	    if (!is_dir($imagesConfigList['tmp_path']))
	        mkdir($imagesConfigList['tmp_path'], 0777, true);
	    $tmp = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5(microtime(true).$data.microtime(true)) . ".image";
        file_put_contents($tmp, self::getVar('data'));
        if (file_exists($tmp) && filesize($tmp) > 0)
        {
            switch (self::getVar('type'))
            {
                default:
                    $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($tmp) . "." . 'jpg';
                    shell_exec(str_replace('%destination', $source, str_replace('%source', $tmp, $imagesConfigList['convert_path'])));
                    if (file_exits($source) && filesize($source)> 0)
                    {
                        if (self::getVar('md5')!=md5_file($source))
                        {
                            switch(self::getVar('storage'))
                            {
                                case "files":
                                    
                                    if (self::getVar('uid')==0)
                                    {
                                        $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                    } else {
                                        $userHandler = xoops_getHandler('users');
                                        if ($user = $userHandler->get(self::getVar('uid')))
                                        {
                                            if (strlen($user->getVar('uname')) >= 3)
                                                $destination = substr($user->getVar('uname'),0,1) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,2) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,3) . DIRECTORY_SEPARATOR . $user->getVar('uname') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                            else
                                                $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                        } else {
                                            $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                        }
                                    }

                                    if (!is_dir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination)))
                                        mkdir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination), 0777, true);
                                        
                                    if (copy($source, XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination))
                                    {
                                        self::setVar('data', $destination);
                                        self::setVar('md5', md5_file($source));
                                        self::setVar('bytes', filesize($source));
                                        $img = WideImage::loadFromFile($source);
                                        self::setVar('width', $img->getWidth());
                                        self::setVar('height', $img->getHeight());
                                    }
                                    
                                    break;
                                case "database":
                                    
                                    self::setVar('data', file_get_contents($source));
                                    self::setVar('md5', md5_file($source));
                                    self::setVar('bytes', filesize($source));
                                    $img = WideImage::loadFromFile($source);
                                    self::setVar('width', $img->getWidth());
                                    self::setVar('height', $img->getHeight());
                                    break;
                                    
                                  
                            }
                    
                        }
                        unlink($source);
                    }
                    break;
                case 'ascii-small':
                    $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($tmp) . "." . 'jpg';
                    shell_exec(str_replace('%destination', $source, str_replace('%source', $tmp, $imagesConfigList['convert_path'])));
                    if (file_exits($source) && filesize($source)> 0)
                    {
                        $asciiHandler = new AsciiEngineHandler();
                        if ($data = $asciiHandler->getAsciiArt($source, $imagesConfigList['ascii_small_width'], $imagesConfigList['ascii_mode'], $imagesConfigList['ascii_engine']))
                        {
                            unlink($source);
                            $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5($data) . "." . self::getVar('type');
                            file_put_contents($data, $source);
                            
                            if (self::getVar('md5')!=md5_file($source))
                            {
                                switch(self::getVar('storage'))
                                {
                                    case "files":
                                        
                                        if (self::getVar('uid')==0)
                                        {
                                            $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                        } else {
                                            $userHandler = xoops_getHandler('users');
                                            if ($user = $userHandler->get(self::getVar('uid')))
                                            {
                                                if (strlen($user->getVar('uname')) >= 3)
                                                    $destination = substr($user->getVar('uname'),0,1) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,2) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,3) . DIRECTORY_SEPARATOR . $user->getVar('uname') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                                else
                                                    $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                            } else {
                                                $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                            }
                                        }
                                        if (!is_dir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination)))
                                            mkdir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination), 0777, true);
                                        if (copy($source, XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination))
                                        {
                                            self::setVar('data', $destination);
                                            self::setVar('md5', md5_file($source));
                                            self::setVar('bytes', filesize($source));
                                            $data = file($source);
                                            self::setVar('width', strlen($data[0]) - 1);
                                            self::setVar('height', count($data));
                                        }
                                        
                                    break;
                                case "database":
                                    
                                    self::setVar('data', file_get_contents($source));
                                    self::setVar('md5', md5_file($source));
                                    self::setVar('bytes', filesize($source));
                                    $data = file($source);
                                    self::setVar('width', strlen($data[0]) - 1);
                                    self::setVar('height', count($data));
                                    
                                    break;
                                    
                                }
                            }
                            unlink($source);
                        }
                    }
                    break;
                case 'ascii-medium':
                    $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($tmp) . "." . 'jpg';
                    shell_exec(str_replace('%destination', $source, str_replace('%source', $tmp, $imagesConfigList['convert_path'])));
                    if (file_exits($source) && filesize($source)> 0)
                    {
                        $asciiHandler = new AsciiEngineHandler();
                        if ($data = $asciiHandler->getAsciiArt($source, $imagesConfigList['ascii_medium_width'], $imagesConfigList['ascii_mode'], $imagesConfigList['ascii_engine']))
                        {
                            unlink($source);
                            $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5($data) . "." . self::getVar('type');
                            file_put_contents($data, $source);
                            
                            if (self::getVar('md5')!=md5_file($source))
                            {
                                switch(self::getVar('storage'))
                                {
                                    case "files":
                                        
                                        if (self::getVar('uid')==0)
                                        {
                                            $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                        } else {
                                            $userHandler = xoops_getHandler('users');
                                            if ($user = $userHandler->get(self::getVar('uid')))
                                            {
                                                if (strlen($user->getVar('uname')) >= 3)
                                                    $destination = substr($user->getVar('uname'),0,1) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,2) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,3) . DIRECTORY_SEPARATOR . $user->getVar('uname') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                                else
                                                    $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                        } else {
                                            $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                        }
                                    }
                                    if (!is_dir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination)))
                                        mkdir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination), 0777, true);
                                    if (copy($source, XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination))
                                    {
                                        self::setVar('data', $destination);
                                        self::setVar('md5', md5_file($source));
                                        self::setVar('bytes', filesize($source));
                                        $data = file($source);
                                        self::setVar('width', strlen($data[0]) - 1);
                                        self::setVar('height', count($data));
                                        
                                    }
                                    
                                    break;
                                case "database":
                                    
                                    self::setVar('data', file_get_contents($source));
                                    self::setVar('md5', md5_file($source));
                                    self::setVar('bytes', filesize($source));
                                    $data = file($source);
                                    self::setVar('width', strlen($data[0]) - 1);
                                    self::setVar('height', count($data));
                                    
                                    break;
                                    
                                }
                            }
                            unlink($source);
                        }
                    }
                    break;
                case 'ascii-large':
                    $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5_file($tmp) . "." . 'jpg';
                    shell_exec(str_replace('%destination', $source, str_replace('%source', $tmp, $imagesConfigList['convert_path'])));
                    if (file_exits($source) && filesize($source)> 0)
                    {
                        $asciiHandler = new AsciiEngineHandler();
                        if ($data = $asciiHandler->getAsciiArt($source, $imagesConfigList['ascii_large_width'], $imagesConfigList['ascii_mode'], $imagesConfigList['ascii_engine']))
                        {
                            unlink($source);
                            $source = $imagesConfigList['tmp_path'] . DIRECTORY_SEPARATOR . md5($data) . "." . self::getVar('type');
                            file_put_contents($data, $source);
                            
                            if (self::getVar('md5')!=md5_file($source))
                            {
                                switch(self::getVar('storage'))
                                {
                                    case "files":
                                        
                                        if (self::getVar('uid')==0)
                                        {
                                            $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                        } else {
                                            $userHandler = xoops_getHandler('users');
                                            if ($user = $userHandler->get(self::getVar('uid')))
                                            {
                                                if (strlen($user->getVar('uname')) >= 3)
                                                    $destination = substr($user->getVar('uname'),0,1) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,2) . DIRECTORY_SEPARATOR . substr($user->getVar('uname'),0,3) . DIRECTORY_SEPARATOR . $user->getVar('uname') . DIRECTORY_SEPARATOR . self::getVar('field') . "." . self::getVar('type');
                                                    else
                                                        $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                            } else {
                                                $destination = '--anonymous--' . DIRECTORY_SEPARATOR . self::getVar('hash') . DIRECTORY_SEPARATOR . self::getVar('field') . "." .  self::getVar('type');
                                            }
                                        }
                                        if (!is_dir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination)))
                                            mkdir(dirname(XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination), 0777, true);
                                        if (copy($source, XOOPS_VAR_PATH . DIRECTORY_SEPARATOR . $imagesConfigList['data_path'] . DIRECTORY_SEPARATOR . $destination))
                                        {
                                            self::setVar('data', $destination);
                                            self::setVar('md5', md5_file($source));
                                            self::setVar('bytes', filesize($source));
                                            $data = file($source);
                                            self::setVar('width', strlen($data[0]) - 1);
                                            self::setVar('height', count($data));
                                        }
                                        break;
                                    case "database":
                                        
                                        self::setVar('data', file_get_contents($source));
                                        self::setVar('md5', md5_file($source));
                                        self::setVar('bytes', filesize($source));
                                        $data = file($source);
                                        self::setVar('width', strlen($data[0]) - 1);
                                        self::setVar('height', count($data));
                                        break;
                                        
                                }
                            }
                            unlink($source);
                        }
                    }
                    break;
                
            }
            unlink($tmp);
        }
        self::setVar('checked', time() + $imagesConfigsList['checking']);
	}
	
	/**
	 * gets Field Typal
	 * @return string|boolean
	 */
	public function getFieldTypal($options = NULL)
	{
	    global $imagesConfigList;
	    if (is_null($options) || empty($options))
	    {
    	    $options = array('icons', 'logo', 'photo', 'avatar');
    	    shuffle($options);
    	    shuffle($options);
    	    shuffle($options);
    	    shuffle($options);
	    }
	    foreach($options as $option)
    	    if (in_array(self::getVar('field'), $imagesConfigList["$option_fields"]))
    	        return $option;
	    return false;
	}
	
	/**
	 * get Default Width
	 * 
	 * @return unknown|boolean
	 */
	function getWidth()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["$typal_width"];
	    return false;
	}

	/**
	 * gets maximum width
	 * 
	 * @return unknown|boolean
	 */
	function getMaximumWidth()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["maximum_$typal_width"];
	    return false;
	}
	
	/*
	 * gets minimal width
	 */
	function getMinumumWidth()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["minimum_$typal_width"];
	    return false;
	}
	
	
	/*
	 * gets original master minimal width
	 */
	function getOriginalWidth()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["original_$typal_width"];
	    return false;
	}
	/**
	 * gets default height
	 * 
	 * @return unknown|boolean
	 */
	function getHeight()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["$typal_height"];
	    return false;
	}
	
	/**
	 * gets maximum height
	 * 
	 * @return unknown|boolean
	 */
	function getMaximumHeight()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["maximum_$typal_height"];
	    return false;
	}
	
	/**
	 * gets minimal height
	 * 
	 * @return unknown|boolean
	 */
	function getMinumumHeight()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["minimum_$typal_height"];
	    return false;
	}
	
	
	/**
	 * gets original master minimal height
	 *
	 * @return unknown|boolean
	 */
	function getOriginalHeight()
	{
	    global $imagesConfigList;
	    if ($typal = self::getFieldTypal())
	        return $imagesConfigList["original_$typal_height"];
	    return false;
	}
	
	/**
	 * gets the image data and mime type
	 * 
	 * @param string $type
	 * @param number $width
	 */
	function getImageData($type = 'png', $width = 0, $height = 0)
	{
	    global $imagesConfigList;
	    xoops_load("XoopsCache");
	    if (!$result = XoopsCache::read($cachekey = basename(dirname(__DIR__)) . '-' . $type . '--' . $width . 'x' . $height . '--' . self::getVar('hash')))
        {
            $result = array('mimetype' => "text/plane", 'data' => '');
    	    switch ($type)
    	    {
    	        case 'png':
    	            if ($width <= 0 && $height <= 0)
    	            {
    	                $width = self::getWidth();
    	                $height = self::getHeight();
    	            }
    	            if ($width > 0 && $height <= 0)
    	                $height = self::getHeight();
                    if ($width < self::getMinumumWidth())
                        $width = self::getMinumumWidth();
                    if ($width > self::getMaximumWidth())
                        $width = self::getMaximumWidth();
                    if ($height < self::getMinumumHeight())
                        $height = self::getMinumumHeight();
                    if ($height > self::getMaximumHeight())
                        $height = self::getMaximumHeight();
    	            $img = WideImage::loadFromFile(self::getTmpFileSource());
    	            $result = array('mimetype' => 'image/png', 'data' => $img->resize($width, $height)->asString($type));
    	            break;
    	        case 'jpg':
    	            if ($width <= 0 && $height <= 0)
    	            {
    	                $width = self::getWidth();
    	                $height = self::getHeight();
    	            }
    	            if ($width > 0 && $height <= 0)
    	                $height = self::getHeight();
                    if ($width < self::getMinumumWidth())
                        $width = self::getMinumumWidth();
                    if ($width > self::getMaximumWidth())
                        $width = self::getMaximumWidth();
                    if ($height < self::getMinumumHeight())
                        $height = self::getMinumumHeight();
                    if ($height > self::getMaximumHeight())
                        $height = self::getMaximumHeight();
    	            $img = WideImage::loadFromFile(self::getTmpFileSource());
    	            $result = array('mimetype' => 'image/jpeg', 'data' => $img->resize($width, $height)->asString($type));
    	            break;
    	        case 'gif':
    	            if ($width <= 0 && $height <= 0)
    	            {
    	                $width = self::getWidth();
    	                $height = self::getHeight();
    	            }
    	            if ($width > 0 && $height <= 0)
    	                $height = self::getHeight();
                    if ($width < self::getMinumumWidth())
                        $width = self::getMinumumWidth();
                    if ($width > self::getMaximumWidth())
                        $width = self::getMaximumWidth();
                    if ($height < self::getMinumumHeight())
                        $height = self::getMinumumHeight();
                    if ($height > self::getMaximumHeight())
                        $height = self::getMaximumHeight();
    	            $img = WideImage::loadFromFile(self::getTmpFileSource());
    	            $result = array('mimetype' => 'image/gif', 'data' => $img->resize($width, $height)->asString($type));
    	            break;
    	        case 'ascii':
    	            $asciiHandler = new AsciiEngineHandler();
    	            if ($data = $asciiHandler->getAsciiArt(self::getTmpFileSource(), $width, $imagesConfigList['ascii_mode'], $imagesConfigList['ascii_engine']))
    	            {
    	                $result = array('mimetype' => 'text/plane', 'data' => $data);
    	            }
    	            break;
    	    }
        }
        XoopsCache::write($cachekey, $result, $wait = mt_rand($imagesConfigList['minimum_cache_wait'], $imagesConfigList['maximum_cache_wait']));
        if (!$caches = XoopsCache::read($sesskey = basename(dirname(__DIR__)) . '-sessions'))
        {
            $caches = array();
            $caches[$cachekey] = time() + $wait;
        } else 
            $caches[$cachekey] = time() + $wait;
        XoopsCache::write($sesskey, $caches, $imagesConfigList['maximum_cache_wait']);
        self::addMegabytes(strlen($result['data']));
        return $result;
	    
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
	private function getURLData($uri = '', $timeout = 0, $connectout = 0, $posts = array())
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
	    curl_setopt($art, CURLOPT_CONNECTTIMEOUT, ($connectout!=0?$connectout:$imagesConfigsList['curl_connections']));
	    curl_setopt($art, CURLOPT_TIMEOUT, ($timeout!=0?$timeout:$imagesConfigsList['curl_timeout']));
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


class ImagesImagesHandler extends ImagesXoopsPersistableObjectHandler
{

    
    /**
     * Constructor
     *
     * @param object $db reference to the {@link XoopsDatabase} object     
     **/
    function __construct(&$db)
    {
    	parent::__construct($db, "images_images", "ImagesImages", "id", "hash");
    }
  
    /**
     * Inserts a ImagesImages Object into the database
     * 
     * {@inheritDoc}
     * @see XoopsPersistableObjectHandler::insert()
     */
    function insert(ImagesImages $object, $force = true)
    {
        global $imagesConfigList;
        if ($object->isNew())
        {
            if (strlen($object->getVar('field'))==0 || strlen($object->getVar('url'))== 0)
                return false;
            if ($object->getVar('uid')==0 && is_object($GLOBALS['xoopsUser']))
                $object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
            $object->setVar('created', time());
            $object->setVar('type', $imagesConfigList['format']);
            $object->setVar('storage',  $imagesConfigList['storage']);
            $crc = new xcp($data = $object->getVar('uid').$imagesConfigList['format'].microtime().$object->getVar('url'), mt_rand(0,255), mt_rand(5,14));
            $object->setVar('hash', $crc->crc);
            $criteria = new CriteriaCompo(new Criteria('uid', $object->getVar('uid')));    
            $criteria->add(new Criteria('field', $object->getVar('field')));
            if (!in_array($object->getVar('field'), $imagesConfigList['ascii_fields']))
                $criteria->add(new Criteria('type', $object->getVar('type')));
            else
                $criteria->add(new Criteria('type', "('" . $object->getVar('type') . "','ascii-small','ascii-medium','ascii-large')", "IN"));
            if (self::getCount($criteria) > 0)
            {
                foreach(self::getObjects($criteria) as $obj)
                {
                    $obj->setVar('url', $object->getVar('url'));
                    $obj->setVar('checked', time() + mt_rand(320, 4800));
                    if ($obj->getVar('type') == $object->getVar('type'))
                        $id = parent::insert($obj, true);
                    else 
                        @parent::insert($obj, true);
                }
                return $id;
            } else {

                if (in_array($object->getVar('field'), $imagesConfigList['ascii_fields']))
                {
                    $crc = new xcp($data = $object->getVar('uid').'ascii'.microtime().$object->getVar('url'), mt_rand(0,255), mt_rand(5,14));
                    $asciiobjs = array();
                    $asciiobjs['small'] = $object;
                    $asciiobjs['small']->setVar('type', 'ascii-small');
                    $asciiobjs['small']->setVar('hash', $crc->crc);
                    $asciiobjs['medium'] = $object;
                    $asciiobjs['medium']->setVar('type', 'ascii-medium');
                    $asciiobjs['medium']->setVar('hash', $crc->crc);
                    $asciiobjs['large'] = $object;
                    $asciiobjs['large']->setVar('type', 'ascii-large');
                    $asciiobjs['large']->setVar('hash', $crc->crc);
                    @parent::insert($asciiobjs['small'], true);
                    @parent::insert($asciiobjs['medium'], true);
                    @parent::insert($asciiobjs['large'], true);
                    unset($asciiobjs);
                }
            }
        }
        $object->setVar('updated', time());
        return parent::insert($object, true);
    }
    
    /**
     * gets ImagesFields object from hash info
     *
     * @param string $hash
     * @param string $field
     * @param string $type
     * @return mixed|boolean
     */
    function getByHash($hash = '', $field = '', $type = '')
    {
        $criteria = new CriteriaCompo(new Criteria('hash', $hash));
        if (!empty($field))
            $criteria->add(new Criteria('field', $field));
        if (!empty($type))
            $criteria->add(new Criteria('type', $type));
        if (self::getCount($criteria) > 0)
        {
            $objs = self::getObjects($criteria);
            if (isset($objs[0]) && !empty($objs[0]))
                return $objs[0];
        }
        return false;
    }
    
}
?>