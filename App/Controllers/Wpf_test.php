<?php

namespace WPFP\App\Controllers;

use WPFP\App\Helpers\Blade_view;
use WPFP\Boot\System\Controller;
use WPFP\App\Models\M_test;

class Wpf_test extends Controller
{
    public $M_test;
    public $bladeview;

    public function __construct()
    {
        $this->model('M_test');
        $this->M_test = new M_test();
        // $this->bladeview = new Blade_view();

        // Add Something
    }

    public function index(){

        $getDataTest = $this->M_test->getTest();
        $data['get_data_test'] = $getDataTest;

        $dataset = [
            'users' =>  $getDataTest,
            "name"  =>  "Nur Shodik"
        ];
        
        // View - Blade
        // Using $this Method
        // $this->bladeview->view('index', $dataset);
        // Using Static Method
        Blade_view::render('index', $dataset);

        // View - Default
        // $this->view('v_test', $data);
    }

    public function test_fullscreen()
    {
        wpfp_fullscreen();

        $getDataTest = $this->M_test->getTest();
        $dataset = [
            'users' =>  $getDataTest,
            "name"  =>  "Nur Shodik"
        ];

        Blade_view::render('index', $dataset);

        wpfp_fullscreen_end();
    }

    public function test_redirect()
    {
        wpfp_admin_redirect('wpf-test', 'index', ['name'    =>  'nur shodik', 'data'  =>  'hello']);
    }
    
    // Add Something
}
                                    