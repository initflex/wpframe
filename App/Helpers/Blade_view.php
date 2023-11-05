<?php

namespace WPFP\App\Helpers;

use Jenssegers\Blade\Blade;

/**
 * Run Blade template engine
 */
class Blade_view
{

    private $pathView;
    private $pathViewCache;
    private $basePath;

    public function __construct()
    {
        // Add Something
    }

    /**
     * Set View - Blade Template - $this Method
     * @param  String $viewSet  Set View
     * @param  Array $data  Set data to consume in view
     * @return  Void
     */
    public function view($viewSet = null, $data = [])
    {
        $this->basePath = $GLOBALS['WPFP_CONFIG']['base_path'];
        $this->pathView = $this->basePath . $GLOBALS['WPFP_CONFIG']['views_path'];
        $this->pathViewCache = $this->basePath . $GLOBALS['WPFP_CONFIG']['views_path_cache'];
        $bladeSet = new Blade($this->pathView, $this->pathViewCache);

        // check view is exist?
        if (file_exists($this->pathView . $viewSet .'.blade.php')) {
            echo $bladeSet->render($viewSet, $data);
        } else {
            echo "<h3>View - Blade | Not Found.</h3>";
        }
    }

    /**
     * Set View - Blade Template - Static Method
     * @param  String $viewSet  Set View
     * @param  Array $data  Set data to consume in view
     * @return  Void
     */
    public static function render($viewSet = null, $data = [])
    {
        $basePath = $GLOBALS['WPFP_CONFIG']['base_path'];
        $pathView = $basePath . $GLOBALS['WPFP_CONFIG']['views_path'];
        $pathViewCache = $basePath . $GLOBALS['WPFP_CONFIG']['views_path_cache'];
        $bladeSet = new Blade($pathView, $pathViewCache);

        // check view is exist?
        if (file_exists($pathView . $viewSet .'.blade.php')) {
            echo $bladeSet->render($viewSet, $data);
        } else {
            echo "<h3>View - Blade | Not Found.</h3>";
        }
    }

    // Add Something
}
                    