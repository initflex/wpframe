<?php
use WPFP\Boot\System\Env;
use Illuminate\Database\Capsule\Manager as Capsule;

/** 
 * First, create a new "Capsule" manager instance. 
 * Capsule aims to make configuring the library for usage outside of 
 * the Laravel framework as easy as possible.
  */
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    =>  Env::get('DB_CONNECTION'),
    'host'      =>  DB_HOST,
    'database'  =>  DB_NAME,
    'username'  =>  DB_USER,
    'password'  =>  DB_PASSWORD,
    'charset'   =>  Env::get('DB_CHARSET'),
    'collation' =>  Env::get('DB_COLLATION'),
    'prefix'    =>  Env::get('DB_PREFIX'),
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher as LaravelDispatcher;
use Illuminate\Container\Container as LaravelContainer;
$capsule->setEventDispatcher(new LaravelDispatcher(new LaravelContainer));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();


#=====================END LARAVEL CONFIG ========================#


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
    'host'          => DB_HOST,
    // Set Username Database
    'username'      => DB_USER,
    // Set Password Database
    'password'      => DB_PASSWORD,
    // Set Database Name
    'database'      => DB_NAME,
    // Set Type Encoding
    'encoding'      => DB_CHARSET,
    // Set Timezone Database
    'timezone'      => 'UTC',
    /**
     * Either boolean true, or a string containing the cache configuration to store meta data in. 
     * Having metadata caching disabled by setting it to false is not advised and can result in very poor performance.
     */
    'cacheMetadata' => true
];