<?php

namespace SecMessage\Core;
use voku\helper\AntiXSS;

class Request
{
    private $get            = null;
    private $post           = null;
    private $route_params   = null;
    private $data           = null;
    private $xss            = null;
    public function __construct($route_params)
    {
        $this->xss = new AntiXSS();
        
        $this->data['post']         = (!empty($_POST) ? ($this->post = $this->cleanXss($_POST)) : array()); 
        $this->data['get']          = (!empty($_GET) ? ($this->get = $this->cleanXss($_GET)) : array()); 
        $this->data['route_params'] = (!empty($route_params) ? ($this->route_params = $this->cleanXss($route_params)) : array()); 
    }

    /**
     * Get the value of post
     */ 
    public function getPost() :?array
    {
        return $this->post;
    }

    /**
     * Get the value of get
     */ 
    public function getGet() :?array
    {
        return $this->get;
    }

    /**
     * Get the value of route_params
     */ 
    public function getRouteParams() :?array
    {
        return $this->route_params;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * CSS cleaner
     *
     * @param mixed $data
     * @return array
     */
    private function cleanXss($data) :array
    {
        $a_return = array();

        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(is_array($value))
                {
                    $a_return[$this->xss->xss_clean($key)] = $this->cleanXss($value);
                }                
                else
                {
                    $a_return[$this->xss->xss_clean($key)] = $this->xss->xss_clean($value);
                }
            }
        }
        else
        {
            $a_return[$this->xss->xss_clean($key)] = $this->xss->xss_clean($value);
        }

        if($this->xss->isXssFound() === true)
        {
            SystemMessages::getInstance()->setMessage('warning', 'XSS detection', 'xss attack detected.');
        }
        return $a_return;
    }
}