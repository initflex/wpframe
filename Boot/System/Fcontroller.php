<?php

namespace WPFP\Boot\System;

/**
 * Frontend Controller Class.
 * This class for extends to current Controller for access to view, model etc.
 */
class Fcontroller
{
    protected $bootstrap;
    protected $config;
    protected $setUrlController;
    protected $ctView;
    protected $baseSystemDir;
    protected $defaultView;
    protected $pathView;
    protected $viewSet;
    protected $modelFile;
    protected $modelSet;
    protected $defaultModel;
    protected $pathModel;
    protected $pathHelper;
    protected $pathLibrary;
    protected $core;
    protected $configFile = WPF_CONFIG_FILE;

    /**
     * For Load Autoload File
     *
     * @param	string  $fileLoad  Filename
     * @param   string  $typeLoad  
     * @return	void|false	Return is Void or false.
     */
    public function autoload($fileLoad = null, $typeLoad = null)
    {
        include $this->configFile;

        $this->pathHelper = $config['base_path'] . $config['helpers_path'];
        $this->pathLibrary = $config['base_path'] . $config['libraries_path'];
        $this->pathView = $config['base_path'] . $config['views_path'];

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
                    $this->pathView . $config['helper_error_view'] . '.php' :
                    $this->pathView . $config['library_error_view'] . '.php';

                include  $fileSetLoadError;
            }
        } else {
            return false;
        }
    }

    /**
     * For Load View File
     *
     * @param	string  $viewFile  Filename
     * @param   array  $dataView   Array Data
     * @return	void	Return is Void.
     */
    public function view($viewFile = null, $dataView = [])
    {

        include $this->configFile;

        $this->defaultView = $config['view_error_default'];
        $this->viewSet = $viewFile !== null ? $viewFile : $this->defaultView;
        $this->pathView = $config['base_path'] . $config['views_path'] . $this->viewSet . '.php';
        $this->pathView = is_file($this->pathView) ?
            $this->pathView : $config['base_path'] . $config['views_path'] .  $this->defaultView . '.php';

        // check is view file exists
        if (count($dataView) > 0) {
            foreach ($dataView as $keyData => $valData) {
                ${$keyData} = $valData;
            }
            if ($dataView !== null) {
                $data = $dataView;
            }
        }

        include $this->pathView;
    }

    /**
     * For Load Model File
     *
     * @param	string  $modelFile  Filename
     * @param   array  $dataForModelConstruct (Deprecated) Since 0.0.5  
     * @return	void	Return is Void
     */
    public function model($modelFile = null, $dataForModelConstruct = null)
    {
        include $this->configFile;

        $this->defaultModelViewError = $config['model_error_view'];
        $this->modelSet = ucfirst($modelFile);
        $this->pathModel = $config['base_path'] . $config['models_path'] . $this->modelSet . '.php';

        if (is_file($this->pathModel)) {

            include $this->pathModel;

            // Deprecated Auto Instances
            // check auto isntance class
            // $classModelIns = "WPFP\\App\\Models\\$this->modelSet";
            // if ($dataForModelConstruct !== null) {
            //     return new $classModelIns($dataForModelConstruct);
            // } else {
            //     return new $classModelIns();
            // }

        } else {
            $this->view($this->defaultModelViewError);
        }
    }

}