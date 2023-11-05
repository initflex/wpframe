<?php


namespace WPFP\Boot\System;

class Autoload
{
    public $config;
    public $bootstrap;
    public $openDirLibraries;
    public $openDirHelpers;
    public $openDirStarter;
    public $pathHelper;
    public $pathLibrary;
    public $pathView;
    public $exBootstrap;
    protected $core;
    protected $basePathWpfp;

    /**
     * Started running Autoload
     *
     * @param	object|mixed  $exBootstrap
     * @return	void	Return is Void
     */
    public function __construct($exBootstrap)
    {
        $this->exBootstrap = $exBootstrap;
        $this->core = $this->exBootstrap->core;
        $this->config = $GLOBALS['CT_CONFIG'];
        $this->bootstrap = new \stdClass();

        $this->basePathWpfp = $this->exBootstrap->basePathWpfp;
        $this->bootstrap->base_system_dir = $this->exBootstrap->base_system_dir;
        $this->bootstrap->base_config_dir = $this->exBootstrap->base_config_dir;
        $this->bootstrap->base_library_dir = $this->exBootstrap->base_library_dir;
        $this->bootstrap->base_helper_dir = $this->exBootstrap->base_helper_dir;
        $this->bootstrap->base_controller_dir = $this->exBootstrap->base_controller_dir;
        $this->bootstrap->base_model_dir = $this->exBootstrap->base_model_dir;
        $this->bootstrap->base_view_dir = $this->exBootstrap->base_view_dir;
        $this->bootstrap->base_starter_dir = $this->exBootstrap->base_starter_dir;
    }

    /**
     * For Running Autoload 
     * @return	void	Return is Void
     */
    public function runAutoload()
    {
        include $this->bootstrap->base_config_dir . "Autoload.php";
        $this->openDirLibraries = $autoload['libraries'];
        $this->openDirHelpers = $autoload['helpers'];
        $this->openDirStarter = $autoload['starter'];

        // check starter and includes
        if (is_array($this->openDirStarter) && count($this->openDirStarter) > 0) {
            foreach ($this->openDirStarter as $key => $strtrFileName) {
                // check file exits
                $fileSetStrtr = $this->bootstrap->base_starter_dir . ucfirst($strtrFileName) . '.php';
                if (is_file($fileSetStrtr)) {
                    include $fileSetStrtr;
                } else {
                    include $this->bootstrap->base_view_dir . $this->core->configItem('starter_error_view') . '.php';
                }
            }
        }

        // check libraries and includes
        if (is_array($this->openDirLibraries) && count($this->openDirLibraries) > 0) {
            foreach ($this->openDirLibraries as $key => $libFileName) {
                // check file exits
                $fileSetLib = $this->bootstrap->base_library_dir . ucfirst($libFileName) . '.php';
                if (is_file($fileSetLib)) {
                    include $fileSetLib;
                } else {
                    include $this->bootstrap->base_view_dir . $this->core->configItem('library_error_view') . '.php';
                }
            }
        }

        // check helpers and includes
        if (is_array($this->openDirHelpers) && count($this->openDirHelpers) > 0) {
            foreach ($this->openDirHelpers as $key => $hlpFileName) {
                // check file exits
                $fileSetHlp = $this->bootstrap->base_helper_dir . ucfirst($hlpFileName) . '.php';
                if (is_file($fileSetHlp)) {
                    include $fileSetHlp;
                } else {
                    include $this->bootstrap->base_view_dir . $this->core->configItem('helper_error_view') . '.php';
                }
            }
        }
    }

    /**
     * For load External Autoload 
     * This is deprecated function since 0.5.0
     * @return	void	Return is Void
     */
    public function set($fileLoad = null, $typeLoad = null)
    {

        $this->pathHelper = $this->bootstrap->base_helper_dir;
        $this->pathLibrary = $this->bootstrap->base_library_dir;
        $this->pathView = $this->bootstrap->base_view_dir;

        if ($typeLoad !== null && $fileLoad !== null) {
            // check load type
            // check file exits
            $fileSetLoad = $typeLoad == 'helper' ?
                $this->pathHelper . ucfirst($fileLoad) . '.php' :
                $this->pathLibrary . ucfirst($fileLoad) . '.php';
            if (is_file($fileSetLoad)) {
                include $fileSetLoad;
            } else {

                $fileSetLoadError = $typeLoad == 'helper' ?
                    $this->pathView . $this->core->configItem('helper_error_view') . '.php' :
                    $this->pathView . $this->core->configItem('library_error_view') . '.php';

                include  $fileSetLoadError;
            }
        } else {
            return false;
        }
    }
}
