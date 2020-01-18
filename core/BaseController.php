<?php

namespace SecMessage\Core;

class BaseController
{
    
    private $em             = null;
    
    private $request        = null;

    private $messages       = null;

    private $show           = true;

    private $render         = null;

    public function __construct(Request $requestHandler)
    {
        $this->render   = Render::getInstance();
        $this->request  = $requestHandler;
        $this->params   = $this->request->getRouteParams();
        $this->messages = SystemMessages::getInstance();
    }

    public function __call($name, $arg) :void
    {
        if(method_exists($this, $methodName = ucfirst($this->params['action']).'Action'))
        {
            $this->$methodName();
            if($this->show)
            {
                try 
                {
                    $this->setJs();
                    $this->setCss();
                    $this->render->renderTemplate($this->params['controller'].'/'.$this->params['action']);
                } 
                catch (\Throwable $th) 
                {
                    throw new \Exception('Template missing - Could not find template', 400, $th);
                }
            }
            $this->render->render();
        }
        else
        {
            echo 'doesnt exist';
        }
        die();
    }

    /**
     * Get the value of request
     */ 
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the value of show
     *
     * @return  void
     */ 
    public function setShow($show) :void
    {
        $this->show = $show;
    }

    /**
     * Undocumented function
     *
     * @return object
     */
    protected function getEm() :object
    {
        if($this->em == null)
        {
            $dbCon = new DbConnector();
            $this->em = $dbCon->getEm();
        }
        return $this->em;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function setJs() :void
    {
        if(file_exists($jsPath = __DIR__.'/../templates/'.$this->params['controller'].'/'.$this->params['action'].'.js'))
        {   
            $fgc = file_get_contents($jsPath);
            if($fgc !== false)
            {
                $this->render->setAdditionalJsString($fgc);
            }
        }
    }

     /**
     * Undocumented function
     *
     * @return void
     */
    private function setCss() :void
    {
        if(file_exists($cssPath = __DIR__.'/../templates/'.$this->params['controller'].'/'.$this->params['action'].'.css'))
        {   
            $fgc = file_get_contents($cssPath);
            if($fgc !== false)
            {
                $this->render->setAdditionalCssString($fgc);
            }
        }
    }

    /**
     * Get the value of messages
     */ 
    public function systemMessages()
    {
        return $this->messages;
    }

    /**
     * Get the value of render
     */ 
    public function getRender()
    {
        return $this->render;
    }
}