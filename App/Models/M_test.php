<?php

namespace WPFP\App\Models;

use WPFP\Boot\System\Model;

class M_test extends Model
{
    // Add Something
    
    public function __construct()
    {
        // Add Something
    }

    public function getTest()
    {
        // Query Builder - Cake PHP
        $getResults = $this->qbuilder()
            ->newQuery()
            ->select('*')
            ->from('wp_users')
            ->execute()
            ->fetchAll('obj');
            
        return $getResults;
    }
}

// Add Something
                                    