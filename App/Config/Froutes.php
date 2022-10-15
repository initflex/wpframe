<?php

/**
 * This file for Frontend Routing
 */

$frouting_config = [
    'default_first_url_regex'       =>  '',
    'default_last_url_regex'        =>  '(/(.*))?/?$',
    'default_flush_rewrite_rules'   =>  true
];

/*
# Sample for Frontend Routing configuration

$frouting = [
    'page-name'    =>  [
        'page_set'        =>  'Controller_name',
        'first_url_regex'   =>  '',
        'last_url_regex'    =>  '',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Example_controller', 'index_method']
    ]
]; */

$frouting = [
    #--- DON'T DELETE AFTER THIS LINE IF YOU NEED CREATE FROUTING FROM WPFX -----
    #-wpfxautogeneratefroutes
    #--- END DON'T DELETE  ------
];

