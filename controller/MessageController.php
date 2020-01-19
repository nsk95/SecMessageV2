<?php

namespace SecMessage\Controller;

class MessageController extends \SecMessage\Core\BaseController 
{

    public function CreateAction()
    {
        $this->setShow(false);

        $post   = $this->getRequest()->getPost();
        $config = \SecMessage\Core\ConfigReader::getConfig('main', 'o');
        
        if(!empty($post) && isset($post['data']))
        {
            $data = json_decode($post['data'], true);
            if(!empty($data['cryptedMessage']) && !empty($data['pass']))
            {
                $em         = $this->getEm();
                $a_return   = array();

                if(isset($data['hashedPass']))
                {
                    $hashedPass = trim($data['hashedPass']);
                    $pass       = str_replace($hashedPass, '', trim($data['pass']));
                }
                else
                {
                    $hashedPass = null;
                    $pass       = trim($data['pass']);
                } 
                
                $message        = trim($data['cryptedMessage']);                   
                $delteAfterRead = (int)$data['deleteAfterRead'];
            }

            $cryptUtility = \SecMessage\Utility\CryptUtility::getInstance();

            do 
            {
                $url = $cryptUtility->createRandomString(24);
            } 
            while ($em::find('messages', 'url = ?', [$url]));

            $messEntry = $em::dispense('messages');
            $messEntry->deleteAfterRead = $delteAfterRead;
            $messEntry->pass = $pass;
            $messEntry->hashedPass = $hashedPass;
            $messEntry->url = $url;
            $messEntry->timestampRead = null;

            $tmpMessage = $cryptUtility->encryptMessage($message);
            if($hashedPass != null)
            {
                $tmpMessage =  $cryptUtility->encryptMessage($tmpMessage, $hashedPass);
            }
            $messEntry->message = $tmpMessage;
            $id = $em::store($messEntry);
            $em::close();
            if($id != 0)
            {
                $a_return['url'] = $url;
                $a_return['success'] = true;
                $a_return['append'] = '<br/><div class="col-md-12"><div class="row justify-content-center"><div class="alert alert-success" role="alert"><strong>Success!</strong> Message url: <a href="'.$config->sys->url.'proceed/read/'.$url.'">'.$config->sys->url.'proceed/read/'.$url.'</a></div></div></div>';
            }
            else
            {
                $a_return['append'] = '<br/><div class="col-md-12"><div class="row justify-content-center"><div class="alert alert-danger" role="alert"><strong>Failed!</strong> Retry please.</div></div></div>';
                $a_return['success'] = false;
            }

            echo json_encode($a_return);
            die();
        }
    }

}
