<?php

namespace SecMessage\Core;

class Request
{
    private $get            = null;
    private $post           = null;
    private $cookie         = null;
    private $route_params   = null;
    private $data           = null;
    public function __construct(array $route_params)
    {

        $antiXss = new \Voku\helper\AntiXSS();

        foreach($route_params as $r)
        {
            
        }

        $this->route_params = $route_params;


    }

    /**
     * Get the value of post
     */ 
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get the value of get
     */ 
    public function getGet()
    {
        return $this->get;
    }

    /**
     * Get the value of cookie
     */ 
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Get the value of route_params
     */ 
    public function getRouteParams()
    {
        return $this->route_params;
    }

    
}