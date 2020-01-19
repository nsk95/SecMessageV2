<?php

namespace SecMessage\Core;

class BaseUtility
{
    private $render         = null;
    private $messages       = null;
    public static $instance = null;

    protected function __construct()
    {
        $this->render   = \SecMessage\Core\Render::getInstance();
        $this->messages = \SecMessage\Core\SystemMessages::getInstance();
    }

    final public function getInstance() :self
    {
        static $instances   = array();
        $calledClass        = get_called_class();

        if(!isset($instances[$calledClass]))
        {
            $instances[$calledClass] =  new $calledClass();
        }
        return $instances[$calledClass];
    }
}