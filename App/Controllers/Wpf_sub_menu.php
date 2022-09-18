<?php

namespace WPFP\App\Controllers;

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
            'name'      =>  'WPFrame',
            'message'   =>  'Welcome!, This is Sub Menu'
        ];

        $data['data_users'] = $dataUsers;

        $this->view('v_wpf_submenu', $data);
    }
}
