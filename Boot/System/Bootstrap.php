<?php

namespace WPFP\Boot\System;

/** 
 * run WPFrame system boot
*/
class Bootstrap
{
    public $basePathWpfp;
    public $set_base_dir;
    public $base_system_dir;
    public $base_config_dir;
    public $base_controller_dir;
    public $base_model_dir;
    public $base_library_dir;
    public $base_helper_dir;
    public $base_view_dir;
    public $base_starter_dir;

    public $pathPlugin;
    public $pathConfig = 'App/Config/';
    protected $autoloadFile = __DIR__ .'/../../vendor/autoload.php';
    public $pathSystem;
    protected $funcsCheckFile = 'Default_funcs_checker.php';
    public $core;

    public function __construct()
    {
        // Something
    }

    /**
     * For Load Boot & Core system 
     * @return	void	Return is Void
     */
    public function load()
    {

        //------- Load vendor files
        include_once  $this->autoloadFile;

        //------- Load .Env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ .'/../../');
        $dotenv->safeLoad();

        // ------- Load WPFP Env function
        include_once WP_PLUGIN_DIR . $_ENV['WPFP_PLUGIN_DIR'] . $_ENV['WPFP_SYSTEM_PATH'] .'Env_loader.php';

        // Set Error Handler - Get Error
        // ------- display visual error
        $whoops = new \Whoops\Run;
        if (Env::get('VISUAL_ERROR') == 'true') {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        }

        // Load for create log file Error PHP.
        $whoops->pushHandler(function($exception, $inspector, $run) {
            include_once $this->base_system_dir . 'Error_handler.php';
            $WPFPErrorHandler = new Error_handler();
            $WPFPErrorHandler->WPFPErrorHandler($exception->getMessage() .' | Line: '. $exception->getLine() .' | File: '. $exception->getFile() .' | Code: '. $exception->getCode());
            return \Whoops\Handler\Handler::DONE;
        });
        $whoops->register();

        // directory separator
        $ds  = DIRECTORY_SEPARATOR;

        // run funcs checker
        include_once __DIR__ . $ds . $this->funcsCheckFile;
        
        // -------includes configs
        $pathConfigFull = __DIR__ . "$ds..$ds..$ds" . $this->pathConfig;
        $configFileLoad = $pathConfigFull . 'Config.php';
        include_once $configFileLoad;
        include_once $pathConfigFull . 'Constants.php';

        // set default const path
        $this->pathPlugin = WPF_BASEPATH;
        $this->pathSystem = WPF_PATHSYSTEM;

        // Load Core
        include_once $this->pathPlugin . $this->pathSystem . 'Core.php';

        //instance core
        $this->core = new Core($config);
        $coreWpfp = $this->core;

        // -------display errors
        if ($coreWpfp->configItem('dev_mode') == 'true') {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
        
        // session custom save path
        if($coreWpfp->configItem('session_save_path_active') == 'true') {
            if(is_dir($coreWpfp->configItem('session_save_path'))) {
                ini_set('session.save_path', $coreWpfp->configItem('session_save_path'));
            }else{
                echo "<h3>Session save path: Directory not found. </h3>";
            }
        }

        // Start Session
        @ob_start();
        if (session_status() === PHP_SESSION_NONE) session_start();

        // set default dir
        $this->basePathWpfp = $coreWpfp->configItem('base_path');
        $this->base_system_dir = $this->basePathWpfp . $coreWpfp->configItem('system_path');
        $this->base_vendor_dir = $this->basePathWpfp . $coreWpfp->configItem('vendor_path');
        $this->base_config_dir = $this->basePathWpfp . $coreWpfp->configItem('config_path');
        $this->base_library_dir = $this->basePathWpfp . $coreWpfp->configItem('libraries_path');
        $this->base_helper_dir = $this->basePathWpfp . $coreWpfp->configItem('helpers_path');
        $this->base_controller_dir = $this->basePathWpfp . $coreWpfp->configItem('controllers_path');
        $this->base_fcontroller_dir = $this->basePathWpfp . $coreWpfp->configItem('fcontrollers_path');
        $this->base_model_dir = $this->basePathWpfp . $coreWpfp->configItem('models_path');
        $this->base_view_dir = $this->basePathWpfp . $coreWpfp->configItem('views_path');
        $this->base_starter_dir = $this->basePathWpfp . $coreWpfp->configItem('starter_path');

        // ------includes system files
        include_once $this->base_system_dir . 'Prepare_funcs.php';
        include_once $this->base_system_dir . 'Http.php';
        include_once $this->base_system_dir . 'Autoload.php';
        include_once $this->base_system_dir . 'Frouting.php';
        include_once $this->base_system_dir . 'Fcontroller.php';
        include_once $this->base_system_dir . 'Controller.php';
        include_once $this->base_system_dir . 'Model.php';

        if(Env::get('DB_STATUS') == 'active'){
            // ------includes config files
            include_once $this->base_config_dir . 'Database.php';
        }

        // instances url cleaner & Security
        $cleanUrlController = new \WPFP\Boot\System\Http();

        // ------cleaner url action
        // set url 
        $setUrlController = isset($_GET['page']) && trim($_GET['page']) !== '' ?
            trim($_GET['page']) : trim($coreWpfp->configItem('page_404'));

        // set url clean & safe routing url
        if ($coreWpfp->configItem('safe_url') !== FALSE) {
            $setUrlController = $cleanUrlController->cleaner($setUrlController, $coreWpfp->configItem('regex_safe_url'));
        }

        // instancesx
        $WPFP_autoload = new \WPFP\Boot\System\Autoload($this);
        $WPFP_autoload->runAutoload();

        // instance Frontend Route
        $WPFP_Froute = new \WPFP\Boot\System\Frouting($this);

        // instance Backend Controller
        $WPFP_controller = new \WPFP\Boot\System\Controller($this, $config, $setUrlController);
        $WPFP_controller->loadInit($setUrlController);

    }
}
