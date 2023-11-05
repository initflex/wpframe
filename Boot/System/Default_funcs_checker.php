<?php

// check fuction exists
if (!function_exists('admin_url')) {
    function admin_url($var = null)
    {
    }
}
if (!function_exists('site_url')) {
    function site_url($var = null)
    {
    }
}
if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path($var = null)
    {
    }
}

if (!defined('ABSPATH')) {
    define('ABSPATH', './');
}

if (!defined('WP_PLUGIN_DIR')) {
    define('WP_PLUGIN_DIR', __DIR__ . '/../../../');
}
