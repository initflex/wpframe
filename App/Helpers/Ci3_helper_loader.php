<?php

namespace WPFP\App\Helpers;

class Ci3_helper_loader
{
	public $helperFileSet;

	public function __construct()
	{
		// add something
	}

	/**
     * Load Helper Third party CodeIgniter 3
     *
     * @param	string  $helperFile  Helper Filename
     * @return	void	Return is Void
     */
	public function load_helper($helperFile = null)
	{
		$this->helperFileSet = __DIR__ . '/CI3_Helpers/' . ucfirst($helperFile) . '.php';

		if (file_exists($this->helperFileSet)) {
			include $this->helperFileSet;
		} else {
			return false;
		}
	}
}
