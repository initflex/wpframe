<?php

namespace WPFP\App\Libraries;

class Ci3_library_loader
{
	public $libraryFileSet;

	public function __construct()
	{
		// add something
	}

	/**
     * Load Library Third party CodeIgniter 3
     *
     * @param	string  $libraryFile  Library Filename
     * @return	void	Return is Void
     */
	public function load_library($libraryFile = null)
	{
		$this->libraryFileSet = __DIR__ .'/CI3_Libraries/'. ucfirst($libraryFile) .'.php';

		if (file_exists($this->libraryFileSet)) {
			include $this->libraryFileSet;
		} else {
			return false;
		}
	}
}
