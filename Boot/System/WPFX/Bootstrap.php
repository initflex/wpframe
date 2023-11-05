<?php

namespace WPFP\Boot\System\WPFX;
use WPFP\Boot\System\Env;

class Bootstrap
{
    public $argv;
    protected $pathPlugin = __DIR__ . '/../../../';
    protected $pathSystem = 'Boot/System/';
    protected $configFile = 'App/Config/Config.php';

    public function __construct($argv = null)
    {
        $this->argv = $argv;
    }

    public function default_404()
    {
        // ADD SOMETHING
    }

    public function system()
    {
        // check required functions
        include $this->pathPlugin . $this->pathSystem . 'Default_funcs_checker.php';

        //------- Load vendor files
        include $this->pathPlugin . 'vendor/autoload.php';

        //------- Load .Env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ .'/../../../');
        $dotenv->safeLoad();

        include $this->pathPlugin . $this->pathSystem . 'Env_loader.php';

        // include config
        include $this->pathPlugin . $this->configFile;

        $whoops = new \Whoops\Run;
        $whoops->pushHandler(function($exception, $inspector, $run) {
            include_once  $this->pathPlugin . $this->pathSystem . 'Error_handler.php';
            $WPFPErrorHandler = new \WPFP\Boot\System\Error_handler();
            $WPFPErrorHandler->WPFPErrorHandler($exception->getMessage() .' | Line: '. $exception->getLine() .' | File: '. $exception->getFile() .' | Code: '. $exception->getCode());            
            
            print("\033[31m
==========[ Error Info ]==========\r

Error Line: ". $exception->getLine() ." \r
Error File: ". $exception->getFile() ." \r
Error Code: ". $exception->getCode() ." \r
Error Message: ". $exception->getMessage() ." \r

==============[ End ]=============\r
\033[0m
            ");

            return \Whoops\Handler\Handler::DONE;
        });
        $whoops->register();

        // CTX Functions is Ready
        include __DIR__ .'/WpfxFuncsReady.php';

        // go action by command line
        include __DIR__ .'/WpfxActions.php';

        // run ctx commands
        $wpfxActions = new WpfxActions($this->argv);
        $wpfxActions->goAction();
                
    }
}
