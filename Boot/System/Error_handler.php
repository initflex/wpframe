<?php

namespace WPFP\Boot\System;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Error_handler {

    public function __construct()
    {
        // Something code.
    }

    /**
     * This for crealog log file error PHP.
     * @param  $errorSet  Error message set.
     */
    public function WPFPErrorHandler($errorSet = '')
    {
        // create a log channel
        $log = new Logger('error_handler_wpframe');
        $log->pushHandler(new StreamHandler($GLOBALS['WPFP_CONFIG']['error_log_save'], Logger::DEBUG));
        $log->error($errorSet);
    }
}
