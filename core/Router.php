<?php

namespace SecMessage\Core;

class Router 
{
    private $requestHandler     = null;
    private $controller         = null;
    private $method             = null;
    private $additionalParams   = array();
    private $routeParams        = array(
        'controller'    => NULL,
        'action'        => NULL,
        'additional'    => NULL
    ); 

    public function __construct($url) 
    {
        $this->url              = $this->parseUrl($url);

        isset($url[0]) ? $this->routeParams['controller'] = $url[0] :  $this->routeParams['controller'] = 'index';
        isset($url[1]) ? $this->routeParams['action'] = $url[1] : $this->routeParams['action'] = 'index';
        isset($url[2]) ? $this->routeParams['additional'] = $url[2] : '';

        $this->requestHandler   = new Request($this->routeParams);

        if($this->controllerExistAndSet($this->routeParams['controller']) && $this->methodExistAndSet($this->routeParams['action']))
        {
            $action = str_replace('Action', '', $this->method);
            $this->controller->$action();
        }
        else
        {
            die('Execution end. Err-code: 3');
        }
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return array|null
     */
    private function parseUrl(string $url) :?array
    {
        if(!empty($url))
        {
            return explode('/', $url);
        }
        return null;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return boolean
     */
    private function controllerExistAndSet(string $name) :bool
    {
        $controllerName = ucfirst(strtolower(trim($name)))."Controller";
        if(file_exists(__DIR__."/../controller/".$controllerName.".php"))
        {
            if(!@include __DIR__."/../controller/".$controllerName.".php")
            {
                return false;
            }
            $this->controller = "SecMessage\\Controller\\".$controllerName;
            $this->controller = new $this->controller($this->requestHandler);
            return true;
        }
        return false;
    }

    private function methodExistAndSet(string $name) :bool
    {
        if(!is_object($this->controller))
        {
            return false;
        }
        
        $methodName = ucfirst(strtolower($name))."Action";
        if (method_exists($this->controller, $methodName)) 
        {
            $this->method = $methodName;
            return true;
        }
        return false;
    }
}
