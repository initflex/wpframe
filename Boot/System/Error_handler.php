<?php

namespace WPFP\Boot\System;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\FirePHPHandler;

class Error_handler {

    public function __construct()
    {
        // Something code.
    }

    public function WPFPErrorHandler($errorSet = '')
    {
        // create a log channel
        $log = new Logger('error_handler_wpframe');
        $log->pushHandler(new StreamHandler($GLOBALS['WPFP_CONFIG']['error_log_save'], Logger::DEBUG));
        $log->error($errorSet);
    }
}
