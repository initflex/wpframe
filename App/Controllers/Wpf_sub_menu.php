<?php

namespace WPFP\App\Controllers;

use WPFP\App\Helpers\Blade_view;
use WPFP\App\Helpers\Blade;
use WPFP\Boot\System\Controller;

class Wpf_sub_menu extends Controller
{

    public function __construct()
    {
        // Add Something
    }

    public function index()
    {
        // set data
        $dataUsers = [
            'name'      =>  wp_get_current_user()->display_name . ' - Sub Menu'
        ];

        // Old - Since RC 1.0.0 - Default WPFrame View
        // $this->view('default_wpframe/index.blade', $dataUsers);

        // Old - Since RC 1.2.1 - Blade
        // Blade_view::render('default_wpframe/index', $dataUsers);

        // New
        Blade::view('default_wpframe.index', $dataUsers);
    }

    public function test(){

        wpfp_fullscreen();

        echo 'request fullscreen active sub menu. <br/> Welcome: '. wp_get_current_user()->display_name;

        wpfp_fullscreen_end();

    }
}