<?php
use WPFP\Boot\System\Env;

/**
 * Default Configuration
 * @var  Array
 */
$config = [
  // time
  'default_time_zone'     =>  Env::get('DEFAULT_TIME_ZONE'),

  // Url
  // base Url 
  'base_url_admin'        =>  admin_url('admin.php'),
  // This Url Controller
  'controller_default'    =>  'wpf-page-not-found',
  // Method_default running if page requested and not have specific method.
  'method_default'        =>  'index',
  // Set if method not found in controller
  'method_not_found'      =>  'index',
  /* this is for a secure url free of special characters. You can set it to TRUE or FALSE. 
  URLs cleaned by regex_safe_url */
  'safe_url'              =>  FALSE,
  // Regex to clean URLs
  'regex_safe_url'        => '/[^a-zA-Z0-9]/',
  // Default plugin icon. Set by URL
  'plugin_icon_url'       =>  site_url() . '/wp-content/plugins/wpframe/public/assets/images/logos/favicon-16x16.png',
  // This Url Controller 404
  'page_404'              =>  'wpf-page-not-found',
  // set View errors if the view doesn't exist.
  'view_error_default'    =>  'error/v_view_error',
  // set View errors if the model doesn't exist.
  'model_error_view'      =>  'error/v_model_error',
  // set View errors if the helper doesn't exist.
  'helper_error_view'     =>  '/error/v_error_helper',
  // set View errors if the library doesn't exist.
  'library_error_view'    =>  '/error/v_error_library',
  // set View errors if the starter doesn't exist.
  'starter_error_view'    =>  '/error/v_error_starter',

  // namespace controller can be custom made if you want
  'controller_namespace'  =>  'WPFP\\App\\Controllers\\',
  // The url separator is used when you use a system controller with a directory structure in it.
  'url_separator_set'     =>  '--',

  //directory and files
  'plugin_dir'            =>  WP_PLUGIN_DIR . Env::get('WPFP_PLUGIN_DIR'),
  'base_path'             =>  WP_PLUGIN_DIR . Env::get('WPFP_BASE_DIR'),

  // current dir by base path
  // don't edit this if you don't understand the whole system flow wpframe
  'system_path'           =>  './Boot/System/',
  'config_path'           =>  './App/Config/',
  'controllers_path'      =>  './App/Controllers/',
  'fcontrollers_path'     =>  './App/Fcontrollers/',
  'models_path'           =>  './App/Models/',
  'views_path'            =>  './App/Views/',
  'views_path_cache'      =>  Env::get('VIEW_CACHE_SAVE_PATH'),
  'libraries_path'        =>  './App/Libraries/',
  'helpers_path'          =>  './App/Helpers/',
  'starter_path'          =>  './App/Starter/',
  'vendor_path'           =>  './vendor/',
  'lang_path'             =>  './App/Lang/',
  'migrations_path'       =>  './App/Migrations/',
  'env_path'              =>   './',

  // development mode. if is 'TRUE', you can see display error.
  'dev_mode'              =>  Env::get('APP_DEBUG'),
  'visual_error'          =>  Env::get('VISUAL_ERROR'),
  'write_log'             =>  Env::get('WRITE_LOG'),
  'error_log_save'        =>  WP_PLUGIN_DIR . Env::get('WPFP_PLUGIN_DIR') .'storage/logs/php_error.log',

  //app info
  'app_name'              =>  Env::get('APP_NAME'),
  'developer_app'         =>  Env::get('APP_DEV_NAME'),
  'developer_link'        =>  Env::get('APP_DEV_URL'),
  'copyright_app'         =>  Env::get('APP_DEV_NAME'),

  /* database_table_prefix is ​​used only as a database table prefix configuration only. 
  You still have to initialize if using custom query method */
  'db_table_prefix'       =>  Env::get('DB_PREFIX'),

  // session
  'session_save_path_active'  =>  Env::get('SESSION_SAVE_PATH_ACTIVE'),
  'session_save_path'         =>  WP_PLUGIN_DIR . Env::get('WPFP_PLUGIN_DIR') . Env::get('SESSION_SAVE_PATH'),

  //assets
  'assets_url'                    =>  site_url('wp-content/plugins/wpframe/public/assets/'),
  'assets_template_ct_theme'      =>  site_url('wp-content/plugins/wpframe/public/assets/templates/wpfp_theme/'),
  'assets_template_css_theme'     =>  site_url('wp-content/plugins/wpframe/public/assets/templates/wpfp_theme/css/'),
  'assets_template_js_theme'      =>  site_url('wp-content/plugins/wpframe/public/assets/templates/wpfp_theme/js/'),

  /*
		--------------------------------------
		- input file
		
		Example :

		- set default upload directory
		$config['default_upload_dir'] = './wpf-public/uploads/';

		- set max size file upload
		- in byte size
		$config['default_max_size'] = 1024;

		- set allowed type of file, you can add for multiple types
		$config['default_allowed_type'] = 'png|jpg|gif';

		- set default max upload
		$config['default_max_upload'] = 1;

		--------------------------------------
	  */

  'default_upload_dir'  =>  ABSPATH . './wpf-public/uploads/',
  'default_max_size'    =>  '1024', // in Bytes.
  'default_allow_type'  =>  'png|jpg|jpeg|gif|mp4|webp|webm|avi|3gp|svg|pdf|txt|xls|ppt|docs|doc',
  'default_max_upload'  =>  '5',

  /** 
   * CodeIgniter 3 prefix config is used to add configuration data required by the 
   * CodeIgniter 3 library and third party helpers. 
   * 
   * If you see an error when using the Codeigniter 3 library, 
   * you can add the required configuration information here. 
   * Also you have to resolve the error manually. 
  */
  'CI3_PREFIX_CONFIG' => [
    'time_reference'  =>  'local',
    'charset'         =>  'UTF-8'
  ]
];

// set globals config
$GLOBALS['CT_CONFIG'] = $config;
$GLOBALS['WPFP_CONFIG'] = $config;
$GLOBALS['CI3_PREFIX_CONFIG'] = $config;