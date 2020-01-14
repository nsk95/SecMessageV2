<?php

namespace SecMessage\Core;

class ConfigReader 
{
    
    static $configDir  = __DIR__."/config/";
    static $config     = null;

    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $type
     * @return array|null
     */
    public static function getConfig(string $name = 'main', $type = 'a')
    {
        if(empty($name) || $name == '')
        {
            return null;
        }

        self::$config = parse_ini_file(self::$configDir.trim($name).'config.ini', true, INI_SCANNER_TYPED);
        if(self::$config == false)
        {
            return null;
        }

        switch (trim($type))
        {
            case 'a':
                return self::$config;
                break;
            case 'o':
                return json_decode(json_encode(self::$config), FALSE);
                break;
            case 's':
                return self::toString(self::$config);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Undocumented function
     *
     * @param array $arr
     * @return string|null
     */
    private static function toString(array $arr) :?string
    {
        if(empty($arr))
        {
            return null;
        }

        $ret = array();
        array_walk_recursive($arr, function($k, $v) use (&$ret) {
            if(isset($ret[$k]))
            {
                $k = $k.'+1';
            }
            $ret[$v] = $k;
        });

        $s = '';
        foreach($ret as $k => $v)
        {
            if($k == array_key_last($ret))
            {
                $s .= '['.$k.'] = '.$v;  
            }
            else
            {
                $s .= '['.$k.'] = '.$v.' & '; 
            }
        }
        return $s;
    }
}
