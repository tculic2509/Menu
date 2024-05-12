<?php

require_once('system/control/Abstract.class.php');
class RequestHandler
{
    function __construct($className)
    {
        $className = $className . 'Page';
        require_once('system/control/' . $className . '.class.php');
        new $className();
    }

    static function handle()
    {
        $request = $_GET['page'] ?? 'Index';
        new RequestHandler($request);
    }
    
}
