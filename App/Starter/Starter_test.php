<?php

namespace WPFP\App\Starter;

use WP_Query;

class Starter_test
{
    public function __construct()
    {
       // Add Something
        register_activation_hook( __FILE__, array($this, 'add_rewrite_urls') );
        add_action( 'init', array($this, 'add_rewrite_urls') );

        add_filter( 'query_vars', function( $query_vars ) { 
            $query_vars[] = 'data'; 
            $query_vars[] = 'hellow'; 

            return $query_vars; 
         } );

        add_action( 'wp_footer', array($this, 'test2') );
    }

    public function add_rewrite_urls() {
        
        // add_rewrite_tag( '%YourNewVariable%', '([^/]*)' );
    
        // $get_rewrite_rules = get_option( 'rewrite_rules' );
    
        $reg_exp = 'karir(/(.*))?/?$';
        $reg_exp2 = 'test5(/(.*))?/?$';
    
        // check if the rule exists
        if ( !isset( $get_rewrite_rules[$reg_exp] ) ) {
    
            add_rewrite_rule(
                $reg_exp,
                'index.php?pagename=karir&data=$matches[2]&=datas',
                'top'
            );

            add_rewrite_rule(
                $reg_exp2,
                'index.php?pagename=test5&data=$matches[2]&=datas',
                'top'
            );

            flush_rewrite_rules(false);
        }
    }

    public function test2()
    {
        $variable = get_query_var( 'data', 'no value.' );
        var_dump($variable);

    }

    // Add Something
}

$Starter_test = new Starter_test();
                    