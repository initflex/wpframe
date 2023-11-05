<?php

/** 
 * #Route Configuration
 * 
 * In the route configuration, it will add the route url in the
 *  wordpress admin menu which will later connect to the related controller.
 * 
 * The rules for adding routes can be found in our documentation or 
 * you can create them using the wpfx console system.
 * 
 * The menu is divided into 2 levels. namely Parent Menu and Sub Menu.
 * */

// register parent menu
$menu_list = [];

$menu_list[] = [
    'menu_item' =>  [
        'page_title'            =>  'WPFrame', // Title of the page
        'page_menu_text'        =>  'WPFrame', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  'wpf-dashboard', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array($this, 'default_page_render'), // render view by controller
        'page_menu_icon'        =>  $this->config['plugin_icon_url'], // icon plugin
        'page_menu_position'    =>   15 // position
    ]
];

// register submenu
$menu_list_sub = [];

$menu_list_sub[] = [
    'menu_item' =>  [
        'page_slug_current'     =>  'wpf-dashboard', // parent slug
        'page_title'            =>  'Sub Menu', // Title of the page
        'page_menu_text'        =>  'Sub Menu', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  'wpf-sub-menu', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array($this, 'default_page_render'), // render view by controller
        'page_menu_position'    =>  16 // position
    ]
];

#---------------- (start) wpfx ------------------
#- don't delete or edit comments "#- wpfxgenerate" from start to end wpfx
#-wpfxgenerate
#---------------- (end) wpfx --------------------

// set globals config
$GLOBALS['CT_PAGEMENU'] = $menu_list;
$GLOBALS['CT_SUBPAGEMENU'] = $menu_list_sub;
