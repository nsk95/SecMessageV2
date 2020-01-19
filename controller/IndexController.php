<?php

namespace SecMessage\Controller;

class IndexController extends \SecMessage\Core\BaseController 
{

    public function IndexAction()
    {
        $this->systemMessages()->setMessage('success', '', 'testmessage');
        $this->systemMessages()->setMessage('info', '', 'testmessage');
        $this->systemMessages()->setMessage('warning', '', 'testmessage');
        $this->systemMessages()->setMessage('error', '', 'testmessage');



        // $utility = \SecMessage\Utility\DefaultUtility::getInstance();
        // \SecMessage\Utility\DefaultUtility::debug(array(array(array(array(array(123,321,1234,31223123),'test'),1,2,3,4),'array',array())));
        //echo '<pre>';var_dump($this->getRequest()->getData());echo'</pre>';
    }

}
