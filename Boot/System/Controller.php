<?php

namespace WPFP\Boot\System;

/**
 * Controller Class.
 * This class for extends to current Controller for access to view, model etc.
 */
class Controller
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
     * First Start Controller on Instance
     *
     * @param	object  $bootstrap
     * @param   array&object  $config
     * @param   string  $setUrlController
     * @return	void	Return is Void.
     */
    public function __construct($bootstrap, $config, $setUrlController)
    {
        $this->bootstrap  = $bootstrap;
        $this->config = $config;
        $this->setUrlController = $setUrlController;
        $this->baseSystemDir = $this->bootstrap->base_system_dir;
    }

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

    public function loadMenu()
    {
        add_action('admin_menu', array($this, 'set_menu_list'));
    }

    /**
     * For Load Controller Not Found 
     * @return	void	Return is Void
     */
    public function default_page_render()
    {
        // instances page 404
        include $this->bootstrap->base_controller_dir . 'Wpf_page_not_found.php';
        $pageNotFound  = new \WPFP\App\Controllers\Wpf_page_not_found();
        $pageNotFound->index();
    }

    /**
     * For Load Menu List 
     * @return	void	Return is Void
     */
    public function set_menu_list()
    {
        $controllerData = $this->setUrlController;
        $controllerData = urldecode($controllerData);
        $getUrlSegment = explode('/', $controllerData);
        $controllerSet = isset($_GET['page']) && trim($_GET['page']) !== '' ?
            $_GET['page'] : $this->config['controller_default'];

        $methodSet = isset($_GET['method']) && trim($_GET['method']) !== '' ?
            $_GET['method'] : $this->config['method_default'];

        $realControllerName = ucfirst($controllerSet);
        $realControllerName = str_replace('-', '_', $realControllerName);

        include $this->bootstrap->base_config_dir . 'Routes.php';

        //add menu by foreach all menu list item array
        // list main menu plugin
        $xCounterMenu = 0;
        foreach ($menu_list as $keyItem => $valueItem) {
            if ($valueItem['menu_item']['page_slug'] !== $controllerSet) {
                add_menu_page(
                    $valueItem['menu_item']['page_title'], // Title of the page
                    $valueItem['menu_item']['page_menu_text'], // Text to show on the menu link
                    $valueItem['menu_item']['page_capability'], // Capability requirement to see the link
                    $valueItem['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                    $valueItem['menu_item']['page_render'],
                    $valueItem['menu_item']['page_menu_icon'], // icon plugin
                    $valueItem['menu_item']['page_menu_position'] // item position
                );
            }
            $xCounterMenu++;
        }

        // list sub main menu plugin
        $yCounterMenu = 0;
        foreach ($menu_list_sub as $keyItem => $valueItem) {

            if ($valueItem['menu_item']['page_slug'] !== $controllerSet) {
                add_submenu_page(
                    $valueItem['menu_item']['page_slug_current'], // slug current menu
                    $valueItem['menu_item']['page_title'], // Title of the page
                    $valueItem['menu_item']['page_menu_text'], // Text to show on the menu link
                    $valueItem['menu_item']['page_capability'], // Capability requirement to see the link
                    $valueItem['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                    $valueItem['menu_item']['page_render'],
                    $valueItem['menu_item']['page_menu_position'] // item position
                );
            }else{
                add_submenu_page(
                    $_SESSION['controller_data_sub']['page_slug_current'], // slug current menu
                    $_SESSION['controller_data_sub']['page_title'], // Title of the page
                    $_SESSION['controller_data_sub']['page_menu_text'], // Text to show on the menu link
                    $_SESSION['controller_data_sub']['page_capability'], // Capability requirement to see the link
                    $_SESSION['controller_data_sub']['page_slug'], // The 'slug' - file to display when clicking the link,
                    $_SESSION['controller_data_sub']['page_render'], // render
                    $_SESSION['controller_data_sub']['page_menu_position'] // item position
                );
            }
            
            $yCounterMenu++;
        }
    }

    /**
     * For Initialize Route Menu Page
     *
     * @param	string|null  $controllerData  Filename
     * @return	void	Return is Void
     */
    public function loadInit($controllerData = null)
    {
        $controllerData = urldecode($controllerData);
        $getUrlSegment = explode('/', $controllerData);
        $controllerSet = isset($_GET['page']) && trim($_GET['page']) !== '' ?
            $_GET['page'] : $this->config['controller_default'];

        $methodSet = isset($_GET['m']) && trim($_GET['m']) !== '' ?
            $_GET['m'] : $this->config['method_default'];

        $upNameControllerSet = ucfirst($controllerSet);
        $toSlashControllerName = str_replace($this->config['url_separator_set'], '/', $upNameControllerSet);
        $backSlashControllerName = str_replace('/', '\\', $toSlashControllerName);
        $realControllerName = str_replace('-', '_', $backSlashControllerName);

        $controllerStructureSet = str_replace('\\', '/', $realControllerName);
        $controllerStructureSet = ucwords($controllerStructureSet, '/');
        $controllerFileSet = $this->bootstrap->base_controller_dir . $controllerStructureSet . '.php';

        if (file_exists($controllerFileSet)) {
            include_once $controllerFileSet;
            $instanceClassController = $this->config['controller_namespace'] . $realControllerName;
            $realControllerName =  new $instanceClassController();

            if (method_exists($realControllerName, $methodSet)) {
                $methodSet = $methodSet;
            } else {
                $methodSet = $this->config['method_not_found'];
            }
        }

        // check type is sub or not. and getting information menu page item
        include $this->bootstrap->base_config_dir . 'Routes.php';

        // check in is sub page menu or not or parent/current menu.
        $yCounterMenu = 0;
        $statusControllerpage = 'sub';
        $dataSetPageController = [];
        // first search in menu current
        foreach ($menu_list as $keyItem) {
            if ($keyItem['menu_item']['page_slug'] == $controllerSet) {
                $dataSetPageController = $keyItem;
                $statusControllerpage = 'current';
                break;
            }
            $yCounterMenu++;
        }

        if ($statusControllerpage == 'sub') {
            // first search in menu current
            foreach ($menu_list_sub as $keyItem) {
                if ($keyItem['menu_item']['page_slug'] == $controllerSet) {
                    $dataSetPageController = $keyItem;
                    $statusControllerpage = 'sub';
                    break;
                }
                $yCounterMenu++;
            }
        }

        // set session for transfer data controller to func set load controller menu
        // validation if page tying to access controller or not.

        if ($statusControllerpage == 'sub') {

            if (isset($dataSetPageController['menu_item']['page_slug_current'])) {
                $_SESSION['controller_data_sub']  = [
                    'page_slug_current'     =>  $dataSetPageController['menu_item']['page_slug_current'],
                    'page_title'            =>  $dataSetPageController['menu_item']['page_title'], // Title of the page
                    'page_menu_text'        =>  $dataSetPageController['menu_item']['page_menu_text'], // Text to show on the menu link
                    'page_capability'       =>  $dataSetPageController['menu_item']['page_capability'], // Capability requirement to see the link
                    'page_slug'             =>  $dataSetPageController['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                    'page_render'           =>  array($realControllerName, $methodSet), // render view by controller
                    'page_menu_position'    =>  $dataSetPageController['menu_item']['page_menu_position']
                ];

                $this->loadMenu();
                //add_action('admin_menu', array($this, 'setLoadControllerMenuSub'));
            } else {
                $this->loadMenu();
            }
        } else {
            $_SESSION['controller_data_current']  = [
                'page_title'            =>  $dataSetPageController['menu_item']['page_title'], // Title of the page
                'page_menu_text'        =>  $dataSetPageController['menu_item']['page_menu_text'], // Text to show on the menu link
                'page_capability'       =>  $dataSetPageController['menu_item']['page_capability'], // Capability requirement to see the link
                'page_slug'             =>  $dataSetPageController['menu_item']['page_slug'], // The 'slug' - file to display when clicking the link,
                'page_render'           =>  array($realControllerName, $methodSet), // render view by controller
                'page_menu_icon'     =>  $dataSetPageController['menu_item']['page_menu_icon'],
                'page_menu_position'    =>  $dataSetPageController['menu_item']['page_menu_position']
            ];
            add_action('admin_menu', array($this, 'setLoadControllerMenu'));
            $this->loadMenu();
        }
    }

    /**
     * For add Routes to List Menu
     * @return	void	Return is Void
     */
    public function setLoadControllerMenu()
    {
        add_menu_page(
            $_SESSION['controller_data_current']['page_title'], // Title of the page
            $_SESSION['controller_data_current']['page_menu_text'], // Text to show on the menu link
            $_SESSION['controller_data_current']['page_capability'], // Capability requirement to see the link
            $_SESSION['controller_data_current']['page_slug'],
            $_SESSION['controller_data_current']['page_render'],
            $_SESSION['controller_data_current']['page_menu_icon'],
            $_SESSION['controller_data_current']['page_menu_position']
        );
    }

    /**
     * For add Routes to List Menu Deprecated since v rc 1.0.0)
     * @return	void	Return is Void
     */
    public function setLoadControllerMenuSub()
    {
        add_submenu_page(
            $_SESSION['controller_data_sub']['page_slug_current'],
            $_SESSION['controller_data_sub']['page_title'], // Title of the page
            $_SESSION['controller_data_sub']['page_menu_text'], // Text to show on the menu link
            $_SESSION['controller_data_sub']['page_capability'], // Capability requirement to see the link
            $_SESSION['controller_data_sub']['page_slug'],
            $_SESSION['controller_data_sub']['page_render'],
            $_SESSION['controller_data_sub']['page_menu_position']
        );
    }
}
