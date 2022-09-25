<?php

namespace WPFP\App\Fcontrollers\Vendor;

use WPFP\App\Helpers\Blade_view;
use WPFP\Boot\System\Fcontroller;

class Account_vendor extends Fcontroller
{

    public function __construct()
    {
        // Add Something
    }

    public function index($a = '', $b = '')
    {
        $dataset = [$a, $b];
        add_shortcode( 'sucofindo_account', function($atts) use ($dataset) {
 
            $atts = shortcode_atts( array(
                'data' => false
            ), $atts, 'sucofindo_account' );

            $data = ['dataset'  =>  $dataset];
    
            Blade_view::render('v_karir', $data);

        } ); 
    }

    public function account_vendor()
    {
        $dataset = [$a, $b];
        add_shortcode( 'sucofindo_account', function($atts) use ($dataset) {
 
            $atts = shortcode_atts( array(
                'data' => false
            ), $atts, 'sucofindo_account' );

            $data = ['dataset'  =>  $dataset];
    
            Blade_view::render('v_karir', $data);

        } ); 
    }

    public function info_karir($a= '', $b = '')
    {
        $dataset = [$a, $b];

        add_shortcode( 'sucofindo_account', function($atts) use ($dataset) {
 
            $atts = shortcode_atts( array(
                'data' => false
            ), $atts, 'sucofindo_account' );

            $data = ['dataset'  =>  $dataset];
    
           Blade_view::render('v_karir', $data);

        } ); 
    }

    public function test($a, $b)
    {
        $dataset = [$a, $b];

        add_shortcode( 'sucofindo_account', function($atts) use ($dataset) {
 
            $atts = shortcode_atts( array(
                'data' => false
            ), $atts, 'sucofindo_account' );

            $data = ['dataset'  =>  $dataset];
    
           Blade_view::render('v_karir', $data);

        } ); 
    }
}
