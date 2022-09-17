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
        $a = $this->qb()->execute("SELECT * FROM `wp_users`");

        $query = $this->qb()->newQuery();
        $b  = $query->select('*')->from('wp_users')->where(['ID'    =>  2]);

        $b = $b->execute();

        $results = $b->fetchAll('assoc');
        return $results;
    }
}

// Add Something
                                    