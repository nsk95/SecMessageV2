<?php

namespace SecMessage\Utility;

class DefaultUtility extends \SecMessage\Core\BaseUtility
{
    public static function debug($var) :void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}