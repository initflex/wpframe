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
    }

    public function index(){

        $getDataTest = $this->M_test->getTest();

        $dataset = [
            'users' =>  $getDataTest,
            "name"  =>  "Nur Shodik"
        ];
        
        // Using Static Method
        Blade_view::render('index', $dataset);
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
                                    