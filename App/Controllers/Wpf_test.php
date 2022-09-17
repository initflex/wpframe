<?php

namespace WPFP\App\Controllers;

use WPFP\Boot\System\Controller;
use WPFP\App\Models\M_test;

class Wpf_test extends Controller
{
    public $M_test;

    public function __construct()
    {
        $this->model('M_test');
        $this->M_test = new M_test();

        // Add Something
    }

    public function index(){

        $getDataTest = $this->M_test->getTest();
        $data['get_data_test'] = $getDataTest;
        $this->view('v_test', $data);
    }
    
    // Add Something
}
                                    