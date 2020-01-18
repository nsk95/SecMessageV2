<?php

namespace SecMessage\Core;

class BaseController
{
    
    private $em             = null;
    
    private $request        = null;

    private $messages       = null;

    private $smarty         = null;
    private $render         = true;
    private $js             = array();
    private $css            = array();
    private $jsUrl          = array();
    private $cssUrl         = array();

    public function __construct(Request $requestHandler)
    {
        $this->initSmarty();
        $this->request  = $requestHandler;
        $this->params   = $this->request->getRouteParams();
        $this->messages = SystemMessages::getInstance();
    }

    public function __call($name, $arg) :void
    {
        if(method_exists($this, $methodName = ucfirst($this->params['action']).'Action'))
        {
            $this->$methodName();
            if($this->render)
            {
                try 
                {
                    $this->setJs();
                    $this->setCss();
                    $this->smarty->assign('js', $this->js);
                    $this->smarty->assign('jsUrl', $this->jsUrl);
                    $this->smarty->assign('css', $this->css);
                    $this->smarty->assign('cssUrl', $this->cssUrl);
                    $this->smarty->assign('messages', $this->messages->getMessages());
                    $this->smarty->display($this->params['controller'].'/'.$this->params['action'].'.tpl');
                } 
                catch (\Throwable $th) 
                {
                    throw new \Exception('Template missing - Could not find template', 400, $th);
                }
            }
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
     * Set the value of render
     *
     * @return  void
     */ 
    public function setRender($render) :void
    {
        $this->render = $render;
    }

    /**
     * Undocumented function
     *
     * @param string $data
     * @return void
     */
    protected function setAdditionalJsString(string $data) :void
    {
        $this->js[] = trim($data);
    }

    /**
     * Undocumented function
     *
     * @param string $data
     * @return void
     */
    protected function setAdditionalCssString(string $data) :void
    {
        $this->css[] = trim($data);
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return void
     */
    protected function setAdditionalJsUrl(string $url) :void
    {
        $this->jsUrl[] = $url;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return void
     */
    protected function setAdditionalCssUrl(string $url) :void
    {
        $this->cssUrl[] = $url;
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
                $this->js[] = $fgc;
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
                $this->css[] = $fgc;
            }
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function initSmarty() :void
    {
        $smarty = new \Smarty();
        $smarty->template_dir = __DIR__.'/../templates';
        $smarty->compile_dir = __DIR__.'/../tmp';
        $this->smarty = $smarty;
    }

    /**
     * Get the value of messages
     */ 
    public function systemMessages()
    {
        return $this->messages;
    }
}