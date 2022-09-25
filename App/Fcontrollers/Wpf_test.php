<?php

namespace WPFP\App\Fcontrollers;

use WPFP\Boot\System\Fcontroller;

class Wpf_test extends Fcontroller
{
    public function index()
    {

        wpfp_fullscreen();

        echo "asd";

        wpfp_fullscreen_end();
    }

    
}
