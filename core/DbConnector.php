<?php

namespace SecMessage\Core;

use Exception;

class DbConnector 
{
    protected $em = null;

    public function __construct()
    {
        try 
        {
            require __DIR__.'/ext/rb.php';
        }
        catch (\Throwable $th)
        {
            throw new Exception('RB failed - Could not load rb.', 400, $th);
        }
        $this->setEm();
    }

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
            \R::setup('mysql:host='.$config->db->host.';dbname='.$config->db->name, $config->db->user, $config->db->pass);
            $this->em = new \R();
        }
    }
}
