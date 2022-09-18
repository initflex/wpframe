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
        $query = $this->qb()->newQuery();
        $b  = $query->select('*')
            ->from('wp_users')
            ->execute();

        $results = $b->fetchAll('obj');
        return $results;
    }
}

// Add Something
                                    