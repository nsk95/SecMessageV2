<?php

namespace SecMessage\Utility;

class CryptUtility extends \SecMessage\Core\BaseUtility
{

    private $config = null;

    protected function __construct()
    {
        parent::__construct();
        if($this->config == null)
        {
            if(null == ($this->config = \SecMessage\Core\ConfigReader::getConfig('main', 'o')))
            {
                throw new \Exception('Could not read config');
            }
        }
    }

    /**
     * Undocumented function
     *
     * @param string $cryptedMessage
     * @return string|null
     */
    public function decryptMessage(string $cryptedMessage) :?string
    {
        if(empty($cryptedMessage))
        {
            return null;
        }
        if(strpos($cryptedMessage, ':--:') !== false)
        {
            list($cryptedMessage, $iv) = explode(':--:', $cryptedMessage);
        }
        else if(strpos($cryptedMessage, '::'))
        {
            list($cryptedMessage, $iv) = explode('::', $cryptedMessage);
        }
        else
        {
            return null;
        }
        $key = openssl_digest($this->config->sys->key, $this->config->crypt->digest, true);

        if(false !== ($decrypted = openssl_decrypt($cryptedMessage, $this->config->crypt->method, $key, 0, hex2bin($iv))))
        {
            return $decrypted;
        }
        return null;
    }

    /**
     * Undocumented function
     *
     * @param string $message
     * @return string|null
     */
    public function encryptMessage(string $message) :?string
    {
        if(empty($message))
        {
            return null;
        }

        if(in_array($this->config->crypt->method, openssl_get_cipher_methods()))
        {
            $iv     = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->config->crypt->method));
            $key    = openssl_digest($this->config->sys->key, $this->config->crypt->digest, true);

            if(strpos($message, '::'))
            {
                if(false === ($encrypted = openssl_encrypt($message, $this->config->crypt->method, $key, 0, $iv).':--:'.bin2hex($iv)))
                {
                    return null;
                }
                return $encrypted;
            }
            if(false === ($encrypted = openssl_encrypt($message, $this->config->crypt->method, $key, 0, $iv).'::'.bin2hex($iv)))
            {
                return null;
            }
            return $encrypted;
        }
        return null;
    }

    public function createRandomString(int $length = 24)
    {
        $str    = '';
        $pool   = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        for($i = 0; $i < $length; $i++)
        {
            $str .= $pool[random_int(0, count($pool) - 1)];
        }
        return $str;
    }
}