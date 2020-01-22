<?php

namespace SecMessage\Core;

class Model extends \RedBeanPHP\SimpleModel
{
    public function __call($name, $arguments)
    {
        switch(substr($name, 0, 3))
        {
            case 'set':
                if($this->checkExists(($converted = substr($name, 3))))
                {
                    $this->__set($converted, $arguments[0]);
                }
                else
                {
                    throw new \Exception('Propierty: '.$converted.' does not exist');
                }
                break;
            case 'get':
                if($this->checkExists(($converted = substr($name, 3))))
                {
                    $this->__get($converted, $arguments);
                }
                else
                {
                    throw new \Exception('Propierty: '.$converted.' does not exist');
                }
                break;
            default:
                throw new \Exception('Method: '.$name.' does not exist');
                break;
        }
    }

    public function __set($name, $value)
    {
        if(($converted = $this->checkExists(substr($name, 3))))
        {
            parent::__set($converted, $value);
        }
        else
        {
            throw new \Exception('Propierty: '.$converted.' does not exist');
        }
    }
    public function __get($name)
    {
        if(($converted = $this->checkExists(substr($name, 3))))
        {
            parent::__get($converted);
        }
        else
        {
            throw new \Exception('Propierty: '.$converted.' does not exist');
        }
    }

    /**
     * Konvertiert Camelcase to underscore
     *
     * @param string $input
     * @return string
     */
    public function convertCamelCaseToUnderscore(string $input) :string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }    

    public function checkExists($name) :bool
    {
        if(in_array($this->convertCamelCaseToUnderscore($name), $this->properties))
        {
            return true;
        }
        return false;
    }
}
