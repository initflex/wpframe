<?php

/**
 * This file for Frontend Routing
 */

$frouting_config = [
    'default_first_url_regex'       =>  '',
    'default_last_url_regex'        =>  '(/(.*))?/?$',
    'default_flush_rewrite_rules'   =>  true
];

$frouting = [
    // 'page-name'    =>  [
    //     'method_set'        =>  'controller-name',
    //     'first_url_regex'   =>  '',
    //     'last_url_regex'    =>  '',
    //     'controller_set'    =>  ['WPFP\App\Fcontrollers\Wpf_test', 'index']
    // ],
    'karir'    =>  [
        'page_set'        =>  'Info_karir',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Info_karir', 'index']
    ],
    'sample-page'    =>  [
        'page_set'        =>  'Info_karir',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Info_karir', 'index']
    ],
    'karir-2'    =>  [
        'page_set'        =>  'Info_karir',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Info_karir', 'index']
    ],
    'test5'    =>  [
        'page_set'        =>  'Wpf_test',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Wpf_test', 'index']
    ],
    'user-account'    =>  [
        'page_set'          =>  'Pelanggan/Account_pelanggan',
        'controller_set'    =>  ['WPFP\App\Fcontrollers\Pelanggan\Account_pelanggan', 'index']
    ]
];

