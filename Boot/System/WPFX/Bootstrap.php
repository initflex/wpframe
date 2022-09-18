<?php

namespace WPFP\Boot\System\WPFX;

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

        // include config
        include $this->pathPlugin . $this->configFile;

        // CTX Functions is Ready
        include __DIR__ .'/WpfxFuncsReady.php';

        // go action by command line
        include __DIR__ .'/WpfxActions.php';

        // run ctx commands
        $wpfxActions = new WpfxActions($this->argv);
        $wpfxActions->goAction();
    }
}
