<?php

namespace WPFP\App\Helpers;

class File
{
	public function download($fileLocation = NULL, $forceDwn = NULL)
	{
		// check set file location
		if ($fileLocation !== NULL) {

			//File exists ?
			if ($fileLocation !== NULL && trim($fileLocation) !== '') {

				function force_file($fileLocation, $forceDwn)
				{
					// make a file
					$openFile = fopen($fileLocation, 'w');
					// write
					fwrite($openFile, $forceDwn);
					// close
					fclose($openFile);

					return $openFile !== FALSE ? TRUE : FALSE;
				}

				$forceDown = $forceDwn !== NULL && trim($forceDwn) !== '' ?
					force_file($fileLocation, $forceDwn) : FALSE;

				if (file_exists($fileLocation)) {

					// prepare download file
					$this->file = $fileLocation;
					$this->fileSize = filesize($this->file);
					$this->fileMime = mime_content_type($this->file);

					// set header for download
					header("Content-Description: File Transfer");
					header("Content-Transfer-Encoding: Binary");
					header("Content-Length: $this->fileSize");
					header("Content-Type: $this->fileMime");
					header("Content-Disposition: attachment; filename=\"" . basename($this->file) . "\"");
					readfile($this->file);
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				// file not found
				return FALSE;
			}
		} else {
			//File location not set.
			return FALSE;
		}
	}

	public function file_folder_map($dir = NULL, $type = NULL)
	{
		if ($dir !== NULL && is_dir($dir)) {
			///  get items
			$recFile = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));

			// recursive get files
			if ($type !== NULL && trim($type) == 'file') {
				$file = [];
				foreach ($recFile as $file)
					if (!$file->isDir())
						$files[] = $file->getPathname();
				return $files;
			}
			// recursive get dirs
			elseif ($type !== NULL && trim($type) == 'dir') {
				$dir = [];
				foreach ($recFile as $dir)
					if (!$dir->isFile())
						$dirs[] = $dir->getPathname();
				return $dirs;
			}
			// recursive get all items
			else {
				$all = [];
				foreach ($recFile as $all)
					$alls[] = $all->getPathname();
				return $alls;
			}
		} else {
			// dir not set or die
			return FALSE;
		}
	}
}
