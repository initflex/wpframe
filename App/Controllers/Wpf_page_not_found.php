<?php

namespace WPFP\App\Controllers;

use WPFP\Boot\System\Controller;

class Wpf_page_not_found extends Controller
{
    public function __construct()
    {
        // Add Something
    }

    public function index()
    {
        $this->view('error/v_error_page');
    }
}
