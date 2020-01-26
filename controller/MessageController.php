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
            if(!empty($post['cryptedMessage']) && !empty($post['pass']))
            {
                $em         = $this->getEm();
                $a_return   = array();

                if(isset($post['hashedPass']))
                {
                    $hashedPass = trim($post['hashedPass']);
                    $pass       = str_replace($hashedPass, '', trim($post['pass']));
                }
                else
                {
                    $hashedPass = null;
                    $pass       = trim($post['pass']);
                } 
                
                $message        = trim($post['cryptedMessage']);                   
                $delteAfterRead = (int)$post['deleteAfterRead'];

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
                    $this->systemMessages()->setMessage('error', 'Message already read', 'Message already read @ '.$messageModel->timestampRead);
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
            $em::close();
        }
        $render = $this->getRender();
        $render->assign('passRequired', $passRequired);
        $render->assign('noForm', $noForm);
        $render->assign('textPanel', $textPanel);
        $render->assign('idMessage', $additional);
    }

    public function ProcessAction()
    {
        $displayMessage = false;
        $textPanel      = '';
        $post           = $this->getRequest()->getPost();
        $passRequired   = false;
        $error          = false;
        $config         = \SecMessage\Core\ConfigReader::getConfig('main', 'o');
        $render         = $this->getRender();

        if(!isset($post['idMessage']))
        {
            $textPanel = 'Processing error. Please try again.';
        }
        else
        {
            $idMessage = $post['idMessage'];
            $em = $this->getEm();
            $messageModel = $em::findOne(
                'message', 'url = ?', 
                array($idMessage)
            );

            if($messageModel == null)
            {
                $textPanel  = 'Could not find message.';
                $error      = true;
            }
            else if($messageModel->timestampRead != null)
            {
                $textPanel  = 'Message already read @ '.$messageModel->timestampRead;
                $error      = true;
            }
            else
            {
                if($messageModel->hashed_pass != null && !isset($post['pass']))
                {
                    $textPanel  = 'Password missing.';
                    $error      = true;
                }
                elseif(isset($post['pass']))
                {
                    $passRequired = true;
                }

                if(!$error)
                {
                    $cryptUtility   = \SecMessage\Utility\CryptUtility::getInstance();
                    $message        = $messageModel->message;
                    if($passRequired == true)
                    {
                        $userpass   = trim($post['pass']);
                        $message    = $cryptUtility->decryptMessage($message, $userpass);
                    }
                    $message = $cryptUtility->decryptMessage($message, $config->sys->key);

                    if($passRequired == true)
                    {
                        $render->setAdditionalJsString($this->genJs($message, ($messageModel->pass.$userpass)));
                    }
                    else
                    {
                        $render->setAdditionalJsString($this->genJs($message, $messageModel->pass));
                    }

                    if($messageModel->deleteAfterRead = 1)
                    {
                        $messageModel->pass         = null;
                        $messageModel->hashedPass   = null;
                        $messageModel->message      = null;
                        $messageModel->timestampRead = new \DateTime();
                        $em::store($messageModel);
                    }
                    $displayMessage = true;
                }
            }
            $em::close();
        }

        $render->assign('displayMessage', $displayMessage);
        $render->assign('textPanel', $textPanel);
    }

    private function genJs($cryptedMessage, string $pass) :string
    {
        return "$( document ).ready(function() {var cryptedMessage = '".$cryptedMessage."';var pass = '".$pass."';$(\"#message\").text(CryptoJS.AES.decrypt(cryptedMessage, pass).toString(CryptoJS.enc.Utf8));});";
    }
}
