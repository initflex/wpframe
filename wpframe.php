<?php

/**
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area.
 *
 * @link              https://initflex.com/projects/wpframe/
 * @package           WPFrame
 *
 * @wordpress-plugin
 * Plugin Name:       WPFrame
 * Plugin URI:        https://initflex.com/projects/wpframe/
 * Description:       Thank you for using WPFrame. Get started for your creative application :)
 * Version:           2.1.5
 * Author:            Initflex
 * Author URI:        https://github.com/initflex/wpframe/
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

use WPFP\Boot\System\Bootstrap;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Load File System by Bootstrap File
 */
include_once __DIR__ . '/Boot/System/Bootstrap.php';

// load boot system
$bootstrap = new Bootstrap();
$bootstrap->load();
