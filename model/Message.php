<?php

namespace SecMessage\Model;

class Message extends \SecMessage\Core\Model
{
    protected $properties = array(
        'id',
        'delete_after_read',
        'pass',
        'hashed_pass',
        'url',
        'timestamp_read',
        'message'
    );
}
