<?php

namespace WPFP\App\Controllers;

use WPFP\App\Helpers\Blade_view;
use WPFP\Boot\System\Controller;

class Wpf_sub_menu extends Controller
{

    public function __construct()
    {
        // Add Something
    }

    public function index()
    {
        $dataUsers = [
            'name'      =>  wp_get_current_user()->display_name . ' - Sub Menu'
        ];

        Blade_view::render('default_wpframe/index', $dataUsers);
    }
}