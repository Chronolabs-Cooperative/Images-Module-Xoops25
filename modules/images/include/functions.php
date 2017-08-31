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



function images_load_config()
{
	global $xoopsModuleConfig;
	static $moduleConfig;
	
	if (isset($moduleConfig)) {
		return $moduleConfig;
	}
	
	if (isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname", "n") == basename(dirname(__DIR__))) {
		if (!empty($GLOBALS["xoopsModuleConfig"])) {
			$moduleConfig = $GLOBALS["xoopsModuleConfig"];
		} else {
			return null;
		}
	} else {
		$module = xoops_gethandler('module')->getByDirname(basename(dirname(__DIR__)));
		
		$config_handler =& xoops_gethandler('config');
		$criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
		$configs = $config_handler->getConfigs($criteria);
		foreach (array_keys($configs) as $i) {
			$moduleConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
		}
		unset($configs);
	}
	if (file_exists($cfile = XOOPS_ROOT_PATH . "/modules/" . basename(dirname(__DIR__)) . "/include/configs.php"))
		if ($customConfig = @include $cfile)
			$moduleConfig = array_merge($moduleConfig, $customConfig);
	
	return $moduleConfig;
}


if (!function_exists("imagesStatisticalTiming")) {
    /**
     * Loads a field enumerator values
     *
     * @param string $filename
     * @param string $variable
     * @return array():
     */
    function imagesStatisticalTiming($values = array())
    {
        $options = array(   'hourly' => 3600, 'daily' => 3600 * 24, 'weekly' => 3600 * 24 * 7, 'biweekly' => 3600 * 24 * 7 * 2,
                            'monthly' => 3600 * 24 * 7 * 4, 'quarterly' => 3600 * 24 * 7 * 4 * 4, 'yearly' => 3600 * 24 * 7 * 4 * 12    );
        
        foreach($options as $key => $seconds)
        {
            if (isset($values['ended_'.$key]) && !empty($values['ended_'.$key]) && $values['ended_'.$key] < time())
            {
                $values['start_'.$key] = $values['ended_'.$key] + $seconds;
                $values['ended_'.$key] = $values['start_'.$key] + $seconds;
            } elseif (!isset($values['ended_'.$key]) || empty($values['ended_'.$key])) {
                $values['start_'.$key] = time();
                $values['ended_'.$key] = time() + $seconds;
            }
        }
        return $values;
    }
}

if (!function_exists("imagesEnumeratorValues")) {
    /**
     * Loads a field enumerator values
     *
     * @param string $filename
     * @param string $variable
     * @return array():
     */
    function imagesEnumeratorValues($filename = '', $variable = '')
    {
        $variable = str_replace(array('-', ' '), "_", $variable);
        static $ret = array();
        if (!isset($ret[basename($file)]))
            if (file_exists($file = __DIR__ . DIRECTORY_SEPARATOR . 'enumerators' . DIRECTORY_SEPARATOR . "$variable__" . str_replace("php", "diz", basename($filename))))
                foreach( file($file) as $id => $value )
                    if (!empty($value))
                        $ret[basename($file)][$value] = $value;
        return $ret[basename($file)];
    }
}

if (!function_exists("imagesDecryptPassword")) {
    /**
     * Decrypts a password
     *
     * @param string $password
     * @param string $cryptiopass
     * @return string:
     */
    function imagesDecryptPassword($password = '', $cryptiopass = '')
    {
        $sql = "SELECT AES_DECRYPT(%s, %s) as `crypteec`";
        list($result) = $GLOBALS["xoopsDB"]->fetchRow($GLOBALS["xoopsDB"]->queryF(sprintf($sql, $GLOBALS["xoopsDB"]->quote($password), $GLOBALS["xoopsDB"]->quote($cryptiopass))));
        return $result;
    }
}


if (!function_exists("imagesEncryptPassword")) {
    /**
     * Encrypts a password
     *
     * @param string $password
     * @param string $cryptiopass
     * @return string:
     */
    function imagesEncryptPassword($password = '', $cryptiopass = '')
    {
        $sql = "SELECT AES_ENCRYPT(%s, %s) as `encrypic`";
        list($result) = $GLOBALS["xoopsDB"]->fetchRow($GLOBALS["xoopsDB"]->queryF(sprintf($sql, $GLOBALS["xoopsDB"]->quote($password), $GLOBALS["xoopsDB"]->quote($cryptiopass))));
        return $result;
    }
}


if (!function_exists("imagesCompressData")) {
    /**
     * Compresses a textualisation
     *
     * @param string $data
     * @return string:
     */
    function imagesCompressData($data = '')
    {
        $sql = "SELECT COMPRESS(%s) as `compressed`";
        list($result) = $GLOBALS["xoopsDB"]->fetchRow($GLOBALS["xoopsDB"]->queryF(sprintf($sql, $GLOBALS["xoopsDB"]->quote($data))));
        return $result;
    }
}


if (!function_exists("imagesDecompressData")) {
    /**
     * Compresses a textualisation
     *
     * @param string $data
     * @return string:
     */
    function imagesDecompressData($data = '')
    {
        $sql = "SELECT DECOMPRESS(%s) as `compressed`";
        list($result) = $GLOBALS["xoopsDB"]->fetchRow($GLOBALS["xoopsDB"]->queryF(sprintf($sql, $GLOBALS["xoopsDB"]->quote($data))));
        return $result;
    }
}
