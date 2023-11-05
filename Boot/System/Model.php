<?php

namespace WPFP\Boot\System;

use Cake\Datasource\ConnectionManager;

class Model
{

    private $pathConfigDatabase;
    private $databaseConfigFileName = 'Database.php';
    private $databaseConfigFile;

    public function __construct()
    {
        // Something
    }

    public static function wpdb()
    {
        global $wpdb;
        return $wpdb;
    }

    public function qbuilder()
    {
        $this->pathConfigDatabase = $GLOBALS['WPFP_CONFIG']['base_path'] . $GLOBALS['WPFP_CONFIG']['config_path'];
        $this->databaseConfigFile = $this->pathConfigDatabase . $this->databaseConfigFileName;

        // check file database config is exist
        if (file_exists($this->databaseConfigFile)) {

            ConnectionManager::setConfig('default', $wpfp_database);
            $connection = ConnectionManager::get('default');
            return $connection;

        } else {
            return 'Database Config File Not Found.';
        }
    }
}
