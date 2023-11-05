<?php

namespace WPFP\App\Starter;

use WPFP\App\Helpers\Blade_view;

class First_started
{

    protected $dirPublicDefault = ABSPATH . './wpf-public/';
    protected $dirUploadDefault = ABSPATH . './wpf-public/uploads/';

    public function __construct()
    {

        /*
        auto create folder in root wordpress
        - './wpf-public/'
        - './wpf-public/uploads/'
        */

        if (!is_dir($this->dirPublicDefault)) {
            @mkdir($this->dirPublicDefault);
        } else {
            if (!is_dir($this->dirUploadDefault)) {
                @mkdir($this->dirUploadDefault);
            }
        }

        add_action('admin_head', array($this, 'load_default_header_assets'), 100);
    }

    public function load_default_header_assets() {
        $assetsDir = $GLOBALS['WPFP_CONFIG']['assets_url'];

        $data = [
            'assets_dir' => $assetsDir
        ];
        Blade_view::render('default_wpframe/default_wpframe_header_assets', $data);
    }

    // Add Something
}

$First_started = new First_started();
