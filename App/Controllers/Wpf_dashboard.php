<?php

namespace WPFP\App\Controllers;

use WPFP\Boot\System\Controller;

class Wpf_dashboard extends Controller
{

    public function __construct()
    {
        // Add Something
    }

    public function index()
    {

        $dataUsers = [
            'name'      =>  'WPFrame',
            'message'   =>  'Welcome!, This is Dashboard Menu'
        ];

        $data['data_users'] = $dataUsers;

        $this->view('v_wpf_dashboard', $data);
    }
}