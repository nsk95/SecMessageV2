<?php

namespace SecMessage\Core;

use \RedBeanPHP\R as R;

class DbConnector 
{
    protected $em = null;

    /**
     * Get the value of em
     */ 
    public function getEm()
    {
        if($this->em == null)
        {
            $this->setEm();
        }
        return $this->em;
    }

    private function setEm()
    {
        if($this->em == null)
        {
            $config = ConfigReader::getConfig('main', 'o'); 
            R::setup('mysql:host='.$config->db->host.';dbname='.$config->db->name, $config->db->user, $config->db->pass);
            $this->em = new R();
        }
    }
}
