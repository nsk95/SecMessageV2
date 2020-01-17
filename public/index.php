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
    $monologger = new \Monolog\Logger('SecMessage-Log', 
            array(
                new \Monolog\Handler\StreamHandler(__DIR__.'/../logs/syslog.txt'),
                new \Monolog\Handler\FirePHPHandler()
            )
    );

    $whoops = new \Whoops\Run();
    $whoops->pushHandler(function($ex, $inspector, $run) use($monologger) {
        $monologger->error('['.$ex->getCode().'] Message: '.$ex->getMessage().' Thrown in: '.$ex->getFile().' Line:'.$ex->getLine(), $ex->getTrace());
    });
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}
else
{
    error_reporting(0);
}
new Core\Router($_SERVER['QUERY_STRING']);

