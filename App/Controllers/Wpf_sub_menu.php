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
            'name'      =>  'WPFrame User - Sub Menu.',
            'message'   =>  'Welcome!, This is Dashboard Menu'
        ];

        Blade_view::render('index', $dataUsers);
    }
}