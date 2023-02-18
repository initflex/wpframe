<?php

namespace WPFP\Boot\System;

/**
 * Boot system Environment .ENV
*/
class Env {

    public function __construct(){
        // Add Something
    }

    /**
     * Get value from ENV file.
     */
    static function get($env_name = null){
        return isset($_ENV) && trim($env_name) !== '' ? 
            (isset($_ENV[$env_name]) ? 
                $_ENV[$env_name] : 'Env name not found.') : '$_ENV not defined or Env name not set.';
    }

}