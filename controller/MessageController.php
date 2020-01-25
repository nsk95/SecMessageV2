<?php

namespace SecMessage\Controller;

class MessageController extends \SecMessage\Core\BaseController 
{

    public function CreateAction()
    {
        $this->setShow(false);

        $post   = $this->getRequest()->getPost();
        $utility = \SecMessage\Utility\DefaultUtility::getInstance();
        // \SecMessage\Utility\DefaultUtility::debug($_POST);
        // \SecMessage\Utility\DefaultUtility::debug($this->getRequest());
        // \SecMessage\Utility\DefaultUtility::debug($_FILES);
        // die();
        $config = \SecMessage\Core\ConfigReader::getConfig('main', 'o');
        
        if(!empty($post))
        {
            // $data = json_decode($post, true);
            $data = $post;
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
            while ($em::find('message', 'url = ?', [$url]));

            $messEntry = $em::dispense('message');
            $messEntry->deleteAfterRead = $delteAfterRead;
            $messEntry->pass = $pass;
            $messEntry->hashedPass = $hashedPass;
            $messEntry->url = $url;
            $messEntry->timestampRead = null;

            $tmpMessage = $cryptUtility->encryptMessage($message, $config->sys->key);
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
                $a_return['append'] = '<br/><div class="col-md-12"><div class="row justify-content-center"><div class="alert alert-success" role="alert"><strong>Success!</strong> Message url: <a href="'.$config->sys->url.'message/read/'.$url.'">'.$config->sys->url.'message/read/'.$url.'</a></div></div></div>';
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

    public function ReadAction()
    {
        $additional     = $this->getRequest()->getAdditional();
        $config         = \SecMessage\Core\ConfigReader::getConfig('main', 'o');
        $passRequired   = false;
        $noForm         = false;
        $message        = '';
        $textPanel      = '';

        if(empty($additional) || !is_string($additional))
        {
            $textPanel  = 'Could not find any entry for given id';
            $noForm     = true;
        }
        else
        {
            $em = $this->getEm();
            $messageModel = $em::findOne(
                'message', 'url = ?', 
                array($additional)
            );
            if($messageModel != null)
            {
                if($messageModel->timestampRead != null)
                {
                    $textPanel      = 'Message already read @ '.$messageModel->timestampRead;
                    $this->systemMessages()->setMessage('errer', 'Message already read', 'Message already read @ '.$messageModel->timestampRead);
                    $noForm         = true;
                }
                else
                {
                    $textPanel = 'Really want to continue?';
                    if($messageModel->hashed_pass != null)
                    {
                        $passRequired   = true;
                        $textPanel      .= ' Message requires a password.';
                        $this->systemMessages()->setMessage('info', 'Password required', 'Message requires a password');
                    }
                }
            }
            else
            {
                $textPanel  = 'Could not find any entry for given id';
                $noForm = true;
            }
        }
        $render = $this->getRender();
        $render->assign('passRequired', $passRequired);
        $render->assign('noForm', $noForm);
        $render->assign('textPanel', $textPanel);
    }
}
