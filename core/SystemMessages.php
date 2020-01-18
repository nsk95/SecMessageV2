<?php

namespace SecMessage\Core;

class SystemMessages
{
    private static $instance           = null;
    private $a_messages         = array();
    private $a_allowed_types    = array(
        'success',
        'info',
        'warning',
        'error',
    );

    protected function __construct(){}
    
    /**
     * Undocumented function
     *
     * @return self
     */
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
     * @return array
     */
    public function getMessages() :array
    {
        return $this->a_messages;
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param string $title
     * @param string $message
     * @return void
     */
    public function setMessage(string $type = 'success', string $title = '', string $message = '') :void
    {
        if(!in_array(strtolower($type), $this->a_allowed_types))
        {
            throw new \Exception('Not allowed message type.');
        }

        $this->a_messages[] = array(
            'type'      => $type,
            'title'     => $title,
            'message'   => $message
        );
    }
}