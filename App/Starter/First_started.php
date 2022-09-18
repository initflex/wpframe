<?php

namespace WPFP\App\Starter;

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
    }

    // Add Something
}

$First_started = new First_started();
