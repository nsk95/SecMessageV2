<?php

namespace SecMessage\Core;

use \RedBeanPHP\R as R;

class DbConnector 
{
    private static  $instance   = null;
    protected $em               = null;

    protected function __construct()
    {
        if($this->em == null)
        {
            $this->setEm();
        }
    }

     /**
     * Get the value of instance
     */ 
    public static function getInstance() :self
    {
        if(self::$instance == null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the value of em
     */ 
    public function getEm()
    {
        return $this->em;
    }

    private function setEm() :void
    {
        if($this->em == null)
        {
            $config = ConfigReader::getConfig('main', 'o'); 
            R::setup('mysql:host='.$config->db->host.';dbname='.$config->db->name, $config->db->user, $config->db->pass);
            $this->em = new R();
            define( 'REDBEAN_MODEL_PREFIX', '\\SecMessage\\Model\\' );

            if($config->sys->debug == true)
            {
                //$this->em::fancyDebug( TRUE );
            }
            else
            {
                $this->em::freeze(TRUE);
            }
        }
    }
}
