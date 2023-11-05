<?php

namespace WPFP\Boot\System\WPFX;

class WpfxActions extends WpfxFuncsReady
{
    public $argv;
    public $CtxVersion  = '1.0.2';
    public $CtxDev = 'Initflex';
    public $CtxSite = 'https://initflex.com/projects/wpframe/';
    public $CtxGit = 'https://github.com/initflex/wpframe/';

    public function __construct($argv = null)
    {
        $this->argv = $argv;
    }

    /**
     * For running wpfx
     * @return	void	Return is Void
     */
    public function goAction()
    {
        $msg  = '';

        function setMsgClean($msg){
            return trim(preg_replace('/\t/', '', $msg));
        };

        // go action
        if ($this->argv !== null) {
            
            // serve
            if (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == 'serve'
            ) {

                $setPort = isset($this->argv[2]) ? trim($this->argv[2]) : ''; 
                $specDirRoot = isset($this->argv[3]) ? trim($this->argv[3]) : ''; 
                $this->serve($setPort, $specDirRoot);
                echo "\n";

            }
            
            // command list
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == '-clist'
            ) {
                $msg = $this->loadListCommands();
                echo $msg;
                echo "\n";
            }

            // create
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == 'create'
            ) {
                $this->create('', $this->argv);
                echo "\n";
            }

            // routing page & menu
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == 'routing'
            ) {
                $this->routing($this->argv);
                echo "\n";
            }

            // routing page & menu
            elseif (
                isset($this->argv[1]) && 
                trim($this->argv[1]) !== '' && 
                trim($this->argv[1]) == 'migration'
            ) {
                $this->migration('', $this->argv);
                echo "\n";
            }
            
            // ADD SOMETHING
            
            else{
                $msg = $this->loadDefaultMessage();
                echo $msg;
                echo "\n";
            }

        } else{
            echo 'Please set action.';
        }

    }
}
