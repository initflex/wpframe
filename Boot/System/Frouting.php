<?php

namespace WPFP\Boot\System;

/**
 * Set Frontend Routing
 */
 class Frouting
 {
    private $frConfig;
    private $fRoutingRegister;
    private $bootConfig;

    public function __construct($dataBoot = null)
    {
        $this->bootConfig = $dataBoot;

        // get routes config
        include_once  $this->bootConfig->base_config_dir . 'Froutes.php';
        $this->frConfig = $frouting;
        $this->fRoutingRegister = $frouting_config;

        // register activation hook
        register_activation_hook( __FILE__, array($this, 'add_rewrite_urls') );

        // load and set rewrite rule url
        add_action( 'init', array($this, 'add_rewrite_urls') );

        // register vars params
        add_filter( 'query_vars', function( $query_vars ) { 
            $query_vars[] = 'wiew-page'; 
            return $query_vars; 
         } );
        
        // load page controller in header 
        add_action( 'wp_head', array($this, 'load_page_controller') );
        
    }

    public function add_rewrite_urls() {

        // set default config rewrite url
        $get_rewrite_rules = get_option( 'rewrite_rules' );
        $default_last_url_regex = $this->fRoutingRegister['default_last_url_regex'];
        $default_flush_rewrite_rules = $this->fRoutingRegister['default_flush_rewrite_rules'];
        $default_first_url_regex = $this->fRoutingRegister['default_first_url_regex'];

        // register routes
        foreach ($this->frConfig as $pageName => $value) {

            $set_first_url_regex = isset($this->frConfig[$pageName]['first_url_regex']) ? 
                $this->frConfig[$pageName]['first_url_regex'] : $default_first_url_regex;

            $set_last_url_regex = isset($this->frConfig[$pageName]['last_url_regex']) ? 
                $this->frConfig[$pageName]['last_url_regex'] : $default_last_url_regex;

            $regex_url_rewrite = $set_first_url_regex . $pageName . $set_last_url_regex;
            
            add_rewrite_rule(
                $regex_url_rewrite,
                'index.php?pagename='. $pageName .'&wiew-page=$matches[2]',
                'top'
            );
        }

        flush_rewrite_rules($default_flush_rewrite_rules);
    }

    public function load_page_controller()
    {
        global $post;

        // check $post data
        if (is_object($post)) {

            // set slug page
            $pageSet = $post->post_name;

            // check route set
            if (isset($this->frConfig[$pageSet])) {

                // set route
                $get_page_set_name = $this->frConfig[$pageSet]['page_set'];
                $clean_get_page_set_name = str_replace('-', '_', $get_page_set_name);
                $set_page_name_load = ucfirst($clean_get_page_set_name);
                $controller_set = $this->frConfig[$pageSet]['controller_set'][0];
                $default_set_method = $this->frConfig[$pageSet]['controller_set'][1];

                // get data Page & parameters
                $httpDataSet = get_query_var( 'wiew-page', null);
                $httpDataSet = trim($httpDataSet);

                // check method in url
                if ($httpDataSet !== null && $httpDataSet !== '' || $default_set_method !== '') {

                    // set parsing url
                    $parsingUrl = explode('/', $httpDataSet);
                    $tempParsingUrl = $parsingUrl;

                    $setMethodFromUrl = $parsingUrl[0];
                    
                    // unset method name from parsing url.
                    unset($parsingUrl[0]);

                    // clean parsing url & set data Params
                    $dataCleanParsingUrl = is_array($parsingUrl) ? $parsingUrl : [];
                    $paramsFromUrl = array_values($dataCleanParsingUrl);

                    // include controller
                    $controllerLoadFileSet = $this->bootConfig->base_fcontroller_dir . $set_page_name_load  . '.php';

                    // check controller file if exist
                    if (file_exists($controllerLoadFileSet)) {
                        
                        include_once $controllerLoadFileSet;

                        // load method set for call func
                        $loadMethodSet = str_replace('-', '_', $setMethodFromUrl);
                        $loadMethodSetClean = trim($loadMethodSet) !== '' ? trim($loadMethodSet) : 
                            $default_set_method;

                        // auto instance Frontend Controller
                        $controllerLoad = new $controller_set();

                        // check method in controller is set.
                        if (method_exists($controllerLoad, $loadMethodSetClean)) {
                            call_user_func_array([$controllerLoad, $loadMethodSetClean], $paramsFromUrl);
                        } else {

                            // Add Something. Method not found in controller. 
                            // Trying find in parent directory & sub directory and restructure url data & params

                            $controllerFolderSet = ucfirst(str_replace('-', '_', $tempParsingUrl[0]));

                            $controllerLoadFileSetParent = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet . '.php';

                            // check controller file in parent directoy controller
                            if (file_exists($controllerLoadFileSetParent)) {

                                $controllerFileNameSet = ucfirst($tempParsingUrl[0]);
                                $controllerFileNameSet = str_replace('-', '_', $controllerFileNameSet);

                                $controllerLoadFileSet = $this->bootConfig->base_fcontroller_dir .  $controllerFileNameSet . '.php';

                                // check controller file if exist
                                if (file_exists($controllerLoadFileSet)) {
                                    
                                    include_once $controllerLoadFileSet;

                                    $trySetMethodFromUrl = isset($tempParsingUrl[1]) ?  
                                        $tempParsingUrl[1] : $default_set_method;
                    
                                    // unset method name from parsing url.
                                    unset($tempParsingUrl[0]);
                                    unset($tempParsingUrl[1]);

                                    // clean parsing url & set data Params
                                    $tryDataCleanParsingUrl = is_array($tempParsingUrl) ? $tempParsingUrl : [];
                                    $tryParamsFromUrl = array_values($tryDataCleanParsingUrl);
                                    
                                    // load method set for call func
                                    $tryLoadMethodSet = str_replace('-', '_', $trySetMethodFromUrl);
                                    $tryLoadMethodSetClean = trim($tryLoadMethodSet) !== '' ? 
                                        trim($tryLoadMethodSet) : $default_set_method;

                                    $try_controller_sets = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet;

                                    // auto instance Frontend Controller
                                    $tryControllerLoad = new $controller_set();

                                    // check method in controller is set.
                                    if (method_exists($tryControllerLoad, $tryLoadMethodSetClean)) {
                                        call_user_func_array([$tryControllerLoad, $tryLoadMethodSetClean], $tryParamsFromUrl);
                                    } else {
                                        // Method not found in controller. 
                                    }

                                } else {
                                    // Controller File not found in directory. 
                                }

                            }else {

                                // check controller file in any directory in parent controller directory

                                // check set controller name in url
                                if (isset($tempParsingUrl[1])) {

                                    $controllerFileNameSet = ucfirst($tempParsingUrl[1]);
                                    $controllerFileNameSet = str_replace('-', '_', $controllerFileNameSet);

                                    $controllerLoadFileSet = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet . '.php';

                                    // check controller file if exist
                                    if (file_exists($controllerLoadFileSet)) {
                                        
                                        include_once $controllerLoadFileSet;

                                        $trySetMethodFromUrl = isset($tempParsingUrl[2]) ?  
                                            $tempParsingUrl[2] : $default_set_method;
                        
                                        // unset method name from parsing url.
                                        unset($tempParsingUrl[0]);
                                        unset($tempParsingUrl[1]);

                                        if (isset($tempParsingUrl[2])) {
                                            unset($tempParsingUrl[2]);
                                        }

                                        // clean parsing url & set data Params
                                        $tryDataCleanParsingUrl = is_array($tempParsingUrl) ? $tempParsingUrl : [];
                                        $tryParamsFromUrl = array_values($tryDataCleanParsingUrl);
                                        
                                        // load method set for call func
                                        $tryLoadMethodSet = str_replace('-', '_', $trySetMethodFromUrl);
                                        $tryLoadMethodSetClean = trim($tryLoadMethodSet) !== '' ? 
                                            trim($tryLoadMethodSet) : $default_set_method;

                                        $try_controller_sets = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet;

                                        // auto instance Frontend Controller
                                        $tryControllerLoad = new $controller_set();

                                        // check method in controller is set.
                                        if (method_exists($tryControllerLoad, $tryLoadMethodSetClean)) {
                                            call_user_func_array([$tryControllerLoad, $tryLoadMethodSetClean], $tryParamsFromUrl);
                                        } else {
                                            // Method not found in controller. 
                                        }

                                    } else {
                                        // Controller File not found in directory. 
                                    }

                                } else {
                                    // Controller name not set in url. 
                                }
                            }
                        }

                    } else {

                        // Add Something. Method not found in controller. 
                        // Trying find in parent directory & sub directory and restructure url data & params

                        $controllerFolderSet = ucfirst(str_replace('-', '_', $tempParsingUrl[0]));

                        $controllerLoadFileSetParent = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet . '.php';

                        // check controller file in parent directoy controller
                        if (file_exists($controllerLoadFileSetParent)) {

                            $controllerFileNameSet = ucfirst($tempParsingUrl[0]);
                            $controllerFileNameSet = str_replace('-', '_', $controllerFileNameSet);

                            $controllerLoadFileSet = $this->bootConfig->base_fcontroller_dir .  $controllerFileNameSet . '.php';

                            // check controller file if exist
                            if (file_exists($controllerLoadFileSet)) {
                                
                                include_once $controllerLoadFileSet;

                                $trySetMethodFromUrl = isset($tempParsingUrl[1]) ?  
                                    $tempParsingUrl[1] : $default_set_method;
                
                                // unset method name from parsing url.
                                unset($tempParsingUrl[0]);
                                unset($tempParsingUrl[1]);

                                // clean parsing url & set data Params
                                $tryDataCleanParsingUrl = is_array($tempParsingUrl) ? $tempParsingUrl : [];
                                $tryParamsFromUrl = array_values($tryDataCleanParsingUrl);
                                
                                // load method set for call func
                                $tryLoadMethodSet = str_replace('-', '_', $trySetMethodFromUrl);
                                $tryLoadMethodSetClean = trim($tryLoadMethodSet) !== '' ? 
                                    trim($tryLoadMethodSet) : $default_set_method;

                                $try_controller_sets = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet;

                                // auto instance Frontend Controller
                                $tryControllerLoad = new $controller_set();

                                // check method in controller is set.
                                if (method_exists($tryControllerLoad, $tryLoadMethodSetClean)) {
                                    call_user_func_array([$tryControllerLoad, $tryLoadMethodSetClean], $tryParamsFromUrl);
                                } else {
                                    // Method not found in controller. 
                                }

                            } else {
                                // Controller File not found in directory. 
                            }

                        }else {

                            // check controller file in any directory in parent controller directory

                            // check set controller name in url
                            if (isset($tempParsingUrl[1])) {

                                $controllerFileNameSet = ucfirst($tempParsingUrl[1]);
                                $controllerFileNameSet = str_replace('-', '_', $controllerFileNameSet);

                                $controllerLoadFileSet = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet . '.php';

                                // check controller file if exist
                                if (file_exists($controllerLoadFileSet)) {
                                    
                                    include_once $controllerLoadFileSet;

                                    $trySetMethodFromUrl = isset($tempParsingUrl[2]) ?  
                                        $tempParsingUrl[2] : $default_set_method;
                    
                                    // unset method name from parsing url.
                                    unset($tempParsingUrl[0]);
                                    unset($tempParsingUrl[1]);

                                    if (isset($tempParsingUrl[2])) {
                                        unset($tempParsingUrl[2]);
                                    }

                                    // clean parsing url & set data Params
                                    $tryDataCleanParsingUrl = is_array($tempParsingUrl) ? $tempParsingUrl : [];
                                    $tryParamsFromUrl = array_values($tryDataCleanParsingUrl);
                                    
                                    // load method set for call func
                                    $tryLoadMethodSet = str_replace('-', '_', $trySetMethodFromUrl);
                                    $tryLoadMethodSetClean = trim($tryLoadMethodSet) !== '' ? 
                                        trim($tryLoadMethodSet) : $default_set_method;

                                    $try_controller_sets = $this->bootConfig->base_fcontroller_dir . $controllerFolderSet .'/'. $controllerFileNameSet;

                                    // auto instance Frontend Controller
                                    $tryControllerLoad = new $controller_set();

                                    // check method in controller is set.
                                    if (method_exists($tryControllerLoad, $tryLoadMethodSetClean)) {
                                        call_user_func_array([$tryControllerLoad, $tryLoadMethodSetClean], $tryParamsFromUrl);
                                    } else {
                                        // Method not found in controller. 
                                    }

                                } else {
                                    // Controller File not found in directory. 
                                }

                            } else {
                                // Controller name not set in url. 
                            }
                        }
                    }
                } else {
                    // Method not found in Url.
                }
            }
        } else {
           // Page Not Found.
        }
    }
 }