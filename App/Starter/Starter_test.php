<?php

namespace WPFP\App\Starter;

use WP_Query;

class Starter_test
{
    public function __construct()
    {
        add_shortcode( 'sucofindo_account', function(){
            return 'Sucofindo page account not found.';
        });
    }

    // Add Something
}

$Starter_test = new Starter_test();
                    