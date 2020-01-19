<?php

namespace SecMessage\Core;

class Render
{
    private static $instance        = null;
    private $smarty                 = null;
    private $js                     = array();
    private $css                    = array();
    private $jsUrl                  = array();
    private $cssUrl                 = array();
    private $templates              = array();

    protected function __construct() 
    {
        $smarty = new \Smarty();
        $smarty->template_dir   = __DIR__.'/../templates';
        $smarty->compile_dir    = __DIR__.'/../tmp';
        $this->smarty           = $smarty;
    }

    public static function getInstance() :self
    {
        if(self::$instance == null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Undocumented function
     *
     * @param string $data
     * @return self
     */
    public function setAdditionalJsString(string $data) :self
    {
        $this->js[] = trim($data);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $data
     * @return void
     */
    public function setAdditionalCssString(string $data) :self
    {
        $this->css[] = trim($data);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return self
     */
    public function setAdditionalJsUrl(string $url) :self
    {
        $this->jsUrl[] = $url;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return self
     */
    public function setAdditionalCssUrl(string $url) :self
    {
        $this->cssUrl[] = $url;
        return $this;
    }

    public function doRender() :self
    {
        $this->smarty->assign('js', $this->js);
        $this->smarty->assign('jsUrl', $this->jsUrl);
        $this->smarty->assign('css', $this->css);
        $this->smarty->assign('cssUrl', $this->cssUrl);
        $this->smarty->assign('messages', SystemMessages::getInstance()->getMessages());

        if(!empty($this->templates))
        {
            foreach($this->templates as $template)
            {
                $this->smarty->display($template);
            }
        }
        return $this;
    }

    public function addTemplate(string $templatePath) :self
    {
        $this->templates[] = $templatePath.'.tpl';
        return $this;
    }

    public function fetchTemplate(string $templatePath) :string
    {
        return $this->smarty->fetch($templatePath.'.tpl');
    }
}