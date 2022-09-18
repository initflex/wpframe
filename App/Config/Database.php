<?php

/**
 * This config for CakePHP v.4.x database Configuration
 */
$wpfp_database = [
    // Set Connection Class
    'className'     => 'Cake\Database\Connection',
    // Set Driver Class
    'driver'        => 'Cake\Database\Driver\Mysql',
    /**
     * Whether or not to use a persistent connection to the database. 
     * This option is not supported by SqlServer. 
     * An exception is thrown if you attempt to set persistent to true with SqlServer.
     */
    'persistent'    => false,
    // Set Host Database
    'host'          => 'localhost',
    // Set Username Database
    'username'      => 'cn023x',
    // Set Password Database
    'password'      => 'root',
    // Set Database Name
    'database'      => 'wpframe-plugin',
    // Set Type Encoding
    'encoding'      => 'utf8mb4',
    // Set Timezone Database
    'timezone'      => 'UTC',
    /**
     * Either boolean true, or a string containing the cache configuration to store meta data in. 
     * Having metadata caching disabled by setting it to false is not advised and can result in very poor performance.
     */
    'cacheMetadata' => true
];