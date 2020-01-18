<?php

namespace SecMessage\Controller;

class IndexController extends \SecMessage\Core\BaseController 
{

    public function IndexAction()
    {
        echo '<pre>'; var_dump($this->getRequest()->getData()); echo '</pre>';
        $this->systemMessages()->setMessage('success', '', 'testmessage');
        $this->systemMessages()->setMessage('info', '', 'testmessage');
        $this->systemMessages()->setMessage('warning', '', 'testmessage');
        $this->systemMessages()->setMessage('error', '', 'testmessage');
    }

}
