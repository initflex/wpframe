<?php

namespace WPFP\Boot\System;

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;

class Model
{
    public $wpdb;

    public function __construct()
    {
        // SOMETHING
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function qb()
    {
        $driver = new Mysql([
            'database' => 'wpframe-plugin',
            'username' => 'cn023x',
            'password' => 'root'
        ]);
        $connection = new Connection([
            'driver' => $driver
        ]);

        return $connection;
    }

    
}
