<?php

namespace WPFP\App\Controllers;

use WPFP\App\Helpers\Blade_view;
use WPFP\App\Helpers\Blade;
use WPFP\Boot\System\Controller;
use WPFP\App\Models\M_user;
use WPFP\App\Models\M_post;

class Wpf_dashboard extends Controller
{

    public function __construct()
    {
        // Add Something
        $this->model('Model1/M_post');
        $this->model('m_user');
    }

    public function index()
    {
        var_dump(date("Y-m-d H:m:s"));

        // create
        M_user::create([
            'user_login'    => 'initflex',
            'user_pass'     => 'abcde',
            'user_nicename' => 'initflex',
            'user_email '   => 'initflex22@gmail.com',
            'user_registered'  => current_time('mysql')
        ]);

        $data = M_post::all();

        foreach ($data as $key => $value){
            echo $value->ID .'<br/>';
        }

        $dataUsers = [
            'name'      =>  wp_get_current_user()->display_name
        ];

        a

        // New
        Blade::view('default_wpframe.test');

        // Old - Since RC 1.2.1
        Blade_view::render('default_wpframe/index', $dataUsers);
    }

    public function test(){

        wpfp_fullscreen();

        echo 'request fullscreen active. <br/> Welcome: '. wp_get_current_user()->display_name;

        wpfp_fullscreen_end();

    }
}