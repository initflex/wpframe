<?php

namespace WPFP\Boot\System\WPFX;

class WpfxFuncsReady
{

    public $ds = DIRECTORY_SEPARATOR;
    public $dirSet = __DIR__;
    public $dirPluginCt = __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR;
    public $config;
    public $argv;

    public function __construct()
    {
        // ADD SOMETHING
    }

    public function cleanSpace($str = '')
    {
        return preg_replace('/\s+/', '', $str);
    }

    public function msgOprtErr($msgSet = null, $op = null)
    {
        $msg = '';
        $msg .= "Operation ". $op ." not found. \r\n";
        $msg .= "$msgSet \r\n";
        return $msg;
    }

    public function ctxInfoList()
    {
        return "You can view the list of commands by typing: 'php wpfx -clist' \r";
    }

    public function loadDefaultMessage()
    {
        return "\r
WELCOME TO WPFRAME EXECUTE \r
=================================== \r
Version: $this->CtxVersion \r
Developer: $this->CtxDev \r
Site: $this->CtxSite \r
Github: $this->CtxGit \r
=================================== \r
\r
1. For help you can typing 'php wpfx -h' or 'php wpfx -help' \r
2. For command list typing 'php wpfx -clist'\r\n". PHP_EOL;

    }

    public function loadListCommands()
    {
        return "\r
WPFX LIST COMMANDS V 0.1.0 BETA \r
=================================== \r
Site: $this->CtxSite \r
=================================== \r
\r
NOTES : don't use [ and ] at the beginning and end of the command line \r
\r
\r
(1). Welcome WPFX \r 
\033[32m Command: [php wpfx] \033[0m
This command for welcome message. \r
----------------------------------- \r
(2). Help \r 
\033[32m Command: [php wpfx -h] or [php wpfx -help] \033[0m \r
----------------------------------- \r
(3). Create Local Server \r 
\033[32m Command: [php wpfx serve] \033[0m (default port: 9876 and directory location is wordpress root)  \r
or \r
\033[32m Command: [php wpfx serve <set port> '<set root directory>'] \033[0m \r
----------------------------------- \r
(4). Create MVC (Model-View-Controller) \r 
\033[32m Command: [php wpfx -create -mvc '<model name>' '<view name>' '<controller name>'] \033[0m \r
----------------------------------- \r
(5). Create Model \r 
\033[32m Command: [php wpfx -create -model '<model name>'] \033[0m \r
----------------------------------- \r
(6). Create View \r 
\033[32m Command: [php wpfx -create -view '<view name>'] \033[0m \r
----------------------------------- \r
(7). Create Controller \r 
\033[32m Command: [php wpfx -create -controller '<controller name>'] \033[0m \r
----------------------------------- \r
(8). Create Library \r 
\033[32m Command: [php wpfx -create -library '<library name>'] \033[0m \r
----------------------------------- \r
(9). Create Helper \r 
\033[32m Command: [php wpfx -create -helper '<helper name>'] \033[0m \r
----------------------------------- \r
(10). Create Starter \r 
\033[32m Command: [php wpfx -create -starter '<starter name>'] \033[0m \r
----------------------------------- \r
(11). Add Routing \r 
- Add Parent Routing Page Menu
\033[32m Command: [php wpfx -routing -add -parent '<slug name>' <int position>] \033[0m \r

- -Add Sub Routing Page Menu\r 
\033[32m Command: [php wpfx -routing -add -sub '<sub slug name>' <int position> '<parent slug name>'] \033[0m \r

Note:
 - The name of the slug is the same as the name of the controller and class
- Accepted slug names are in lowercase
----------------------------------- \r
        ";
    }

    // create local server
    public function serve($setPort = null, $specDir = null)
    {
        $setPort = $setPort !== null && trim($setPort) !== '' ? $setPort : '9876';
        $specDir = $specDir !== null && trim($specDir) !== '' ? $specDir : __DIR__ ."{$this->ds}..{$this->ds}..{$this->ds}..{$this->ds}..{$this->ds}..{$this->ds}..{$this->ds}";

        echo "
HOST INFO \r
========================= \r
\033[32m Web: http://localhost:$setPort \033[0m \r 
\033[32m Port: $setPort \033[0m \r 
\033[32m Home Directory: $specDir \033[0m \r
        "; 

        exec("php -S localhost:$setPort -t $specDir");
    }
  
    // auto create
    public function create($createAct = null, $argv = null)
    {
        $this->config = $GLOBALS['CT_CONFIG'];
        $this->argv = $argv;

        $createAct = isset($this->argv[2]) ? trim($this->argv[2]) : null; 

        // create mvc
        if ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-mvc'
        ) { 
            $avModelName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            $avViewName = isset($this->argv[4]) ? 
                strtolower($this->cleanSpace(trim($this->argv[4]))) : null;
            $avControllerName = isset($this->argv[5]) ? 
                strtolower($this->cleanSpace(trim($this->argv[5]))) : null;
            
            // model check and create
            if ($avModelName !== null && $avModelName !== '') {

                // view check and create
                if ($avViewName !== null && $avViewName !== '') {

                    // controller check and create
                    if ($avControllerName !== null && $avControllerName !== '') {

                        //var_dump($this->config);
                
                        // set condition mvc
                        // model, view, controller is exists?
                        if (
                            !file_exists($this->dirPluginCt . 
                            $this->config['models_path'] . 
                            $avModelName
                            .'.php') && 
                            is_dir($this->dirPluginCt . 
                            $this->config['models_path'])
                        ) {

                            if (
                                !file_exists($this->dirPluginCt . 
                                $this->config['views_path'] . 
                                $avViewName
                                .'.php') && 
                                is_dir($this->dirPluginCt . 
                                $this->config['views_path'])
                            ) {
            
                                if (
                                    !file_exists($this->dirPluginCt . 
                                    $this->config['controllers_path'] . 
                                    $avControllerName
                                    .'.php') && 
                                    is_dir($this->dirPluginCt . 
                                    $this->config['controllers_path'])
                                ) {

                                    $fileModel = $this->dirPluginCt . $this->config['models_path'] . ucfirst($avModelName) .'.php';
                                    $fileView = $this->dirPluginCt . $this->config['views_path'] . $avViewName .'.php';
                                    $fileController = $this->dirPluginCt . $this->config['controllers_path'] . ucfirst($avControllerName) .'.php';
                
                                    // creating mvc file and auto script.
                                    //creating model
                                    echo " Creating Model (". ucfirst($avModelName) .")... \r\n ";
                                    $crtModel = fopen($fileModel, 'w');
                                    $modelContent = "<?php

namespace WPFP\App\Models;

use WPFP\Boot\System\Model;

class ". ucfirst($avModelName) ." extends Model
{
    // Add Something
    
    public function __construct()
    {
        // Add Something
    }
}

// Add Something
                                    ";

                                    fwrite($crtModel, $modelContent);
                                    echo "Model Created. \r\n ";
                                    fclose($crtModel);

                                    // creating view
                                    echo "Creating View (". $avViewName .")... \r\n ";
                                    $crtView = fopen($fileView, 'w');
                                    $viewContent = "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Welcome</title>
</head>
<body>
    <h1>page created successfully</h1>
    <p>build your app now.</p>
</body>
</html>
                                    ";

                                    fwrite($crtView, $viewContent);
                                    echo "View Created. \r\n ";
                                    fclose($crtView);

                                    //creating controller
                                    echo "Creating Controller (". ucfirst($avControllerName) .")... \r\n ";
                                    $crtController = fopen($fileController, 'w');
                                    $controllerContent = "<?php

namespace WPFP\App\Controllers;

use WPFP\Boot\System\Controller;
use WPFP\App\Models\\". ucfirst(str_replace('/', '', $avModelName)) .";

class ". ucfirst($avControllerName) ." extends Controller
{
    public \$". ucfirst(str_replace('/', '', $avModelName)) .";

    public function __construct()
    {
        \$this->model('". ucfirst($avModelName) ."');
        \$this->". ucfirst(str_replace('/', '', $avModelName)) ." = new ". ucfirst($avModelName) ."();

        // Add Something
    }

    public function index(){

        \$this->view('$avViewName');
    }
    
    // Add Something
}
                                    ";

                                    fwrite($crtController, $controllerContent);
                                    echo "Controller Created. \r\n ";
                                    fclose($crtController);
                                    
                
                                }else{
                                    echo "
Controller exist. \r\n ". $this->ctxInfoList();
                                }
            
                            }else{
                                echo "
View exist. \r\n ". $this->ctxInfoList();
                            }

                        }else{
                            echo "
Model exist. \r\n ". $this->ctxInfoList();
                        }
                        
                    }else{
                        echo "
Please insert controller name. \r\n ". $this->ctxInfoList();
                    }

                }else{
                    echo "
Please insert view name. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert model name. \r\n ". $this->ctxInfoList();
            }
        }

        // create model
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-model'
        ) { 
            $avModelName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // model check and create
            if ($avModelName !== null && $avModelName !== '') {


                //var_dump($this->config);
        
                // set condition mvc
                // model is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['models_path'] . 
                    $avModelName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['models_path'])
                ) {

                    

                    $fileModel = $this->dirPluginCt . $this->config['models_path'] . ucfirst($avModelName) .'.php';

                    //creating model
                    echo " Creating Model (". ucfirst($avModelName) .")... \r\n ";
                    $crtModel = fopen($fileModel, 'w');
                    $modelContent = "<?php

namespace WPFP\App\Models;

use WPFP\Boot\System\Model;

class ". ucfirst($avModelName) ." extends Model
{
    // Add Something

    public function __construct()
    {
        // Add Something
    }
}

// Add Something
                    ";

                    fwrite($crtModel, $modelContent);
                    echo "Model Created. \r\n ";
                    fclose($crtModel);

                }else{
                    echo "
Model exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert model name. \r\n ". $this->ctxInfoList();
            }
        }

        // create view
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-view'
        ) { 
            $avViewName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // view check and create
            if ($avViewName !== null && $avViewName !== '') {

                //var_dump($this->config);
        
                // set condition mvc
                // view  is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['views_path'] . 
                    $avViewName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['views_path'])
                ) {

                    

                    $fileView = $this->dirPluginCt . $this->config['views_path'] . $avViewName .'.php';

                    // creating view
                    echo "Creating View (". $avViewName .")... \r\n ";
                    $crtView = fopen($fileView, 'w');
                    $viewContent = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Welcome</title>
    </head>
    <body>
        <h1>page created successfully</h1>
        <p>build your app now.</p>
    </body>
</html>
                    ";

                    fwrite($crtView, $viewContent);
                    echo "View Created. \r\n ";
                    fclose($crtView);

                }else{
                    echo "
View exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert view name. \r\n ". $this->ctxInfoList();
            }
        }

        // create controller
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-controller'
        ) { 
            $avControllerName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // controller check and create
            if ($avControllerName !== null && $avControllerName !== '') {

                //var_dump($this->config);
        
                // set condition mvc
                // controller  is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['controllers_path'] . 
                    $avControllerName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['controllers_path'])
                ) {

                    $fileController = $this->dirPluginCt . $this->config['controllers_path'] . ucfirst($avControllerName) .'.php';

                    //creating controller
                    echo "Creating Controller (". ucfirst($avControllerName) .")... \r\n ";
                    $crtController = fopen($fileController, 'w');
                    $controllerContent = "<?php

namespace WPFP\App\Controllers;

use WPFP\Boot\System\Controller;

class ". ucfirst($avControllerName) ." extends Controller
{

    public function __construct()
    {

        // Add Something

    }

    public function index(){

        echo '
        <h1 class=\"color-content-theme\">Controller created successfully.</h1>
        <p class=\"color-content-theme\">build your app now.</p>
        ';
        
    }

    // Add Something
}
                    ";

                    fwrite($crtController, $controllerContent);
                    echo "Controller Created. \r\n ";
                    fclose($crtController);

                }else{
                    echo "
Controller exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert controller name. \r\n ". $this->ctxInfoList();
            }
        }

        // create starter
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-starter'
        ) { 

            //var_dump($this->config);
            
            $avStarterName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // Starter check and create
            if ($avStarterName !== null && $avStarterName !== '') {

                // Starter  is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['starter_path'] . 
                    $avStarterName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['starter_path'])
                ) {

                    $fileStarter = $this->dirPluginCt . $this->config['starter_path'] . ucfirst($avStarterName) .'.php';

                    //creating Starter
                    echo "Creating Starter (". ucfirst($avStarterName) .")... \r\n ";
                    $crtStarter = fopen($fileStarter, 'w');
                    $StarterContent = "<?php

namespace WPFP\App\Starter;

class ". ucfirst($avStarterName) ."
{
    public function __construct()
    {
        // Add Something
    }

    // Add Something
}

$". ucwords($avStarterName) ." = new ". ucfirst($avStarterName) ."();
                    ";

                    fwrite($crtStarter, $StarterContent);
                    echo "Starter Created. \r\n ";
                    fclose($crtStarter);

                }else{
                    echo "
Starter exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert starter name. \r\n ". $this->ctxInfoList();
            }

        }

        // create Library
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-library'
        ) { 

            //var_dump($this->config);
            
            $avLibraryName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // Library check and create
            if ($avLibraryName !== null && $avLibraryName !== '') {

                // Library  is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['libraries_path'] . 
                    $avLibraryName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['libraries_path'])
                ) {

                    $fileLibrary = $this->dirPluginCt . $this->config['libraries_path'] . ucfirst($avLibraryName) .'.php';

                    //creating Library
                    echo "Creating Library (". ucfirst($avLibraryName) .")... \r\n ";
                    $crtLibrary = fopen($fileLibrary, 'w');
                    $LibraryContent = "<?php

namespace WPFP\App\Libraries;

class ". ucfirst($avLibraryName) ."
{
    public function __construct()
    {
        // Add Something
    }

    // Add Something
}
                    ";

                    fwrite($crtLibrary, $LibraryContent);
                    echo "Library Created. \r\n ";
                    fclose($crtLibrary);

                }else{
                    echo "
Library exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert Library name. \r\n ". $this->ctxInfoList();
            }

        }

        // create Helper
        elseif ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-helper'
        ) { 

            //var_dump($this->config);
            
            $avHelperName = isset($this->argv[3]) ? 
                strtolower($this->cleanSpace(trim($this->argv[3]))) : null;
            
            // Helper check and create
            if ($avHelperName !== null && $avHelperName !== '') {

                echo $this->dirPluginCt . 
                $this->config['helpers_path'] . 
                $avHelperName
                .'.php';

                // Helper  is exists?
                if (
                    !file_exists($this->dirPluginCt . 
                    $this->config['helpers_path'] . 
                    $avHelperName
                    .'.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['helpers_path'])
                ) {

                    $fileHelper = $this->dirPluginCt . $this->config['helpers_path'] . ucfirst($avHelperName) .'.php';

                    //creating Helper
                    echo "Creating Helper (". ucfirst($avHelperName) .")... \r\n ";
                    $crtHelper = fopen($fileHelper, 'w');
                    $HelperContent = "<?php

namespace WPFP\App\Helpers;

class ". ucfirst($avHelperName) ."
{
    public function __construct()
    {
        // Add Something
    }

    // Add Something
}
                    ";

                    fwrite($crtHelper, $HelperContent);
                    echo "Helper Created. \r\n ";
                    fclose($crtHelper);

                }else{
                    echo "
Helper exist. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert Helper name. \r\n ". $this->ctxInfoList();
            }

        }

        // ADD SOMETHING
        else{
            echo $this->msgOprtErr("You can view the list of commands by typing: 'php wpfx -clist'", "$createAct");
        }
    }

    // auto create
    public function routing($createAct = null, $argv = null)
    {
        $this->config = $GLOBALS['CT_CONFIG'];
        $createAct = isset($this->argv[2]) ? trim($this->argv[2]) : null; 

        // add routing page menu
        if ( 
            $createAct !== null && $createAct !== '' && 
            $createAct == '-add'
        ) { 

            //var_dump($this->config);

            // check make subpagemenu or page menu parent
            // check set params 

            $typeAddPageMenu = isset($this->argv[3]) ? trim($this->argv[3]) : null; 

            if (
                $typeAddPageMenu !== '' && $typeAddPageMenu !== null &&
                $typeAddPageMenu == '-parent' || $typeAddPageMenu == '-sub' 
            ) {
                // add something
            } else {

                echo "
Please insert page menu type (-parent or -sub). \r\n ". $this->ctxInfoList();

                exit;
            }
            
            $avPageMenuName = isset($this->argv[4]) ? 
                strtolower($this->cleanSpace(trim($this->argv[4]))) : null;
            
            // PageMenu check and create
            if ($avPageMenuName !== null && $avPageMenuName !== '') {

                // config pagemenu is exists?
                if (
                    file_exists($this->dirPluginCt . 
                    $this->config['config_path'] . 
                    'Routes.php') && 
                    is_dir($this->dirPluginCt . 
                    $this->config['config_path'])
                ) {

                    $filePageMenu = $this->dirPluginCt . $this->config['config_path'] .'Routes.php';
                    $getContentPageMenu = @file_get_contents($filePageMenu);
                    
                    if ($getContentPageMenu) {

                        if ($typeAddPageMenu == '-parent') {

                            $posAddPageMenu = isset($this->argv[5]) ? trim($this->argv[5]) : null; 

                            if ($posAddPageMenu !== '' && $posAddPageMenu !== null) {
                                // add something
                            } else {
                
                                echo "
Please insert page menu position (integer). \r\n ". $this->ctxInfoList();
                
                                exit;
                            }
                            
                            //add routing
                            echo "Add routing parent Page Menu (". $avPageMenuName .")... \r\n ";
                            
                            $edtPageMenu = fopen($filePageMenu, 'w+');

                            // set name & tiitle
                            $setNameTitle = strtolower($avPageMenuName);
                            $setNameTitle = str_replace('-', ' ', $setNameTitle);
                            $setNameTitle = ucwords($setNameTitle);
                            
                            $newContentPageMenu = "\$menu_list[] = [
    'menu_item' =>  [
        'page_title'            =>  '$setNameTitle', // Title of the page
        'page_menu_text'        =>  '$setNameTitle', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  '$avPageMenuName', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array(\$this, 'default_page_render'), // render view by controller
        'page_menu_icon'        =>  \$this->config['plugin_icon_url'], // icon plugin
        'page_menu_position'    =>   $posAddPageMenu // position
    ]
];

#-wpfxgenerate";

                            $setPageMenuContent = str_replace(
                                '#-wpfxgenerate', $newContentPageMenu, $getContentPageMenu
                            );

                            fwrite($edtPageMenu, $setPageMenuContent);
                            echo "Routing parent Page Menu added. \r\n ";
                            fclose($edtPageMenu);

                        }

                        if ($typeAddPageMenu == '-sub') {

                            $posAddPageMenu = isset($this->argv[5]) ? trim($this->argv[5]) : null; 

                            if ($posAddPageMenu !== '' && $posAddPageMenu !== null) {
                                // add something
                            } else {
                
                                echo "
Please insert sub page menu position (integer). \r\n ". $this->ctxInfoList();
                
                                exit;
                            }

                            $parentAddPageMenu = isset($this->argv[6]) ? 
                                strtolower($this->cleanSpace(trim($this->argv[6]))) : null;

                            if ($parentAddPageMenu !== '' && $parentAddPageMenu !== null) {
                                // add something
                            } else {
                
                                echo "
Please insert sub page menu routing slug (Ex: page-parent-name). \r\n ". $this->ctxInfoList();
                
                                exit;
                            }
                            
                            //add routing
                            echo "Add routing Sub Page Menu (". $avPageMenuName .")... \r\n ";
                            
                            $edtPageMenu = fopen($filePageMenu, 'w+');

                            // set name & tiitle
                            $setNameTitle = strtolower($avPageMenuName);
                            $setNameTitle = str_replace('-', ' ', $setNameTitle);
                            $setNameTitle = ucwords($setNameTitle);
                            
                            $newContentPageMenu = "\$menu_list_sub[] = [
    'menu_item' =>  [
        'page_slug_current'     =>  '$parentAddPageMenu', // parent slug
        'page_title'            =>  '$setNameTitle', // Title of the page
        'page_menu_text'        =>  '$setNameTitle', // Text to show on the menu link
        'page_capability'       =>  'manage_options', // Capability requirement to see the link
        'page_slug'             =>  '$avPageMenuName', // The 'slug' - file to display when clicking the link,
        'page_render'           =>  array(\$this, 'default_page_render'), // render view by controller
        'page_menu_position'    =>  $posAddPageMenu // position
    ]
];

#-wpfxgenerate";

                            $setPageMenuContent = str_replace(
                                '#-wpfxgenerate', $newContentPageMenu, $getContentPageMenu
                            );

                            fwrite($edtPageMenu, $setPageMenuContent);
                            echo "Routing Sub Page Menu added. \r\n ";
                            fclose($edtPageMenu);

                        }
                        
                        else{
                            
                        }
                        
                    }else{
                        echo "
Failed open Page Menu config (Routes.php). Error Code :1 \r\n ". $this->ctxInfoList();
                    }

                }else{
                    echo "
Page Menu config (Routes.php) not exists. \r\n ". $this->ctxInfoList();
                }

            }else{
                echo "
Please insert Page Menu name. \r\n ". $this->ctxInfoList();
            }

        }else{
            echo $this->msgOprtErr("You can view the list of commands by typing: 'php wpfx -clist'", "$createAct");
        }
    }
}


