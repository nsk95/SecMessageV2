<?php

namespace SecMessage;

if(!file_exists(($autoload = __DIR__.'/../vendor/autoload.php')))
{
    die('Execution end. Err-code: 1');
}
require_once($autoload);

if(null == ($config = Core\ConfigReader::getConfig('main', 'o')))
{
    die('Execution end. Err-code: 2');
}

if($config->sys->debug == true)
{
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}
else
{
    error_reporting(0);
}
new Core\Router($_SERVER['QUERY_STRING']);

