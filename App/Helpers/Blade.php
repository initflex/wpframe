<?php

namespace WPFP\App\Helpers;

use eftec\bladeone\BladeOne;

/**
 * Run Blade template engine
 */
class Blade
{

    private $pathView;
    private $pathViewCache;
    private $basePath;

    public function __construct()
    {
        // Add Something
    }

    /**
     * Set View - Blade Template - Static Method
     * @param  String $viewSet  Set View
     * @param  Array $data  Set data to consume in view
     * @return  Void
     */
    public static function view($viewSet = null, $data = [])
    {
        $basePath = $GLOBALS['WPFP_CONFIG']['base_path'];
        $pathView = $basePath . $GLOBALS['WPFP_CONFIG']['views_path'];
        $pathViewCache = $basePath . $GLOBALS['WPFP_CONFIG']['views_path_cache'];

        // MODE_DEBUG allows to pinpoint troubles.
        $bladeSet = new BladeOne($pathView, $pathViewCache, BladeOne::MODE_DEBUG); 
        // pipes are disable by default so it must be enable.
        $bladeSet->pipeEnable = TRUE; 

        $viewSetCheck = str_replace(['.'], ['/'], $viewSet);

        // check view is exist?
        if (file_exists($pathView . $viewSetCheck .'.blade.php')) {
            echo $bladeSet->run($viewSet, $data);
        } else {
            echo "<h3>View - Blade | Not Found.</h3>";
        }
    }

    // Add Something
}
                    