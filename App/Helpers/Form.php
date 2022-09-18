<?php

namespace WPFP\App\Helpers;

class Form
{
	public function __construct()
	{
	}

	public function post($inputName, $replaceText = NULL)
	{
		if (isset($_POST[$inputName]) and $_POST[$inputName] !== NULL) {

			if ($replaceText !== NULL) {

				$param_repl = "";
				$param_repr = "";


				foreach ($replaceText as $getRepl => $getRepr) {
					$param_repl = "$param_repl," . trim($getRepl);
					$param_repr = "$param_repr," . trim($getRepr);
				}

				$param_repl = ltrim($param_repl, ', ');
				$param_repl = explode(',', $param_repl);

				$param_repr = ltrim($param_repr, ', ');
				$param_repr = explode(',', $param_repr);

				return str_replace($param_repl, $param_repr, $_POST[$inputName]);
			} else {
				return $_POST[$inputName];
			}
		} else {
			return FALSE;
		}
	}

	public function request($inputName, $replaceText = NULL)
	{
		if (isset($_REQUEST[$inputName]) and $_REQUEST[$inputName] !== NULL) {

			if ($replaceText !== NULL) {

				$param_repl = "";
				$param_repr = "";


				foreach ($replaceText as $getRepl => $getRepr) {
					$param_repl = "$param_repl," . trim($getRepl);
					$param_repr = "$param_repr," . trim($getRepr);
				}

				$param_repl = ltrim($param_repl, ', ');
				$param_repl = explode(',', $param_repl);

				$param_repr = ltrim($param_repr, ', ');
				$param_repr = explode(',', $param_repr);

				return str_replace($param_repl, $param_repr, $_REQUEST[$inputName]);
			} else {
				return $_REQUEST[$inputName];
			}
		} else {
			return FALSE;
		}
	}

	public function get($inputName, $replaceText = NULL)
	{
		if (isset($_GET[$inputName]) and $_GET[$inputName] !== NULL) {

			if ($replaceText !== NULL) {

				$param_repl = "";
				$param_repr = "";


				foreach ($replaceText as $getRepl => $getRepr) {
					$param_repl = "$param_repl," . trim($getRepl);
					$param_repr = "$param_repr," . trim($getRepr);
				}

				$param_repl = ltrim($param_repl, ', ');
				$param_repl = explode(',', $param_repl);

				$param_repr = ltrim($param_repr, ', ');
				$param_repr = explode(',', $param_repr);

				return str_replace($param_repl, $param_repr, $_GET[$inputName]);
			} else {
				return $_GET[$inputName];
			}
		} else {
			return FALSE;
		}
	}

	public function uploadFile($inputName, $config = NULL)
	{

		// if config user not set, use default config
		$max_size	= isset($config['max_size']) && trim($config['max_size']) !== "" ?
			$config['max_size']	:
			$GLOBALS['CT_CONFIG']['default_max_size'];

		$upload_dir	= isset($config['upload_dir']) && trim($config['upload_dir']) !== "" ?
			$config['upload_dir']	:
			$GLOBALS['CT_CONFIG']['default_upload_dir'];

		$allow_type	= isset($config['allow_type']) && trim($config['allow_type']) !== "" ?
			$config['allow_type']	:
			$GLOBALS['CT_CONFIG']['default_allow_type'];

		$max_upload	= isset($config['max_upload']) && trim($config['max_upload']) !== "" ?
			$config['max_upload']	:
			$GLOBALS['CT_CONFIG']['default_max_upload'];

		$filename_upload = isset($config['filename']) && trim($config['filename']) !== "" ?
			$config['filename']	: date('HisdmY');


		//check file upload
		if (isset($_FILES[$inputName]) and $_FILES[$inputName] !== NULL) {

			// count file upload
			$count_file = is_array($_FILES[$inputName]['name']) ?
				count($_FILES[$inputName]['name']) : 1;

			// check max upload

			if ($count_file > $max_upload) {
				return FALSE;
			}

			// single upload

			elseif (
				$count_file >= 1 &&
				$count_file < 2
			) {

				// get file upload
				// if isset array value
				$i_fileName		= $_FILES[$inputName]['name'];
				$i_fileType		= $_FILES[$inputName]['type'];
				$i_fileSize		= $_FILES[$inputName]['size'];
				$i_fileTmp		= $_FILES[$inputName]['tmp_name'];

				// set vars
				$getType = explode('/', $i_fileType);
				$u_fileType = strtolower($getType[1]);

				// check filesize upload file
				if ($i_fileSize > $max_size) {
					echo "hello";
					return FALSE;
				} else {

					// check upload dir
					if (is_dir($upload_dir) !== FALSE) {

						// check type of file upload
						if (
							strpos($allow_type, $u_fileType) !== FALSE or
							trim($allow_type) == ""
						) {

							// upload file

							$filename_upload = isset($config['filename']) &&
								trim($config['filename']) !== "" ?
								trim($config['filename']) : $filename_upload . '_' . $i_fileName;

							// user filename

							$saveFile = "{$upload_dir}{$filename_upload}";

							// upload
							if (move_uploaded_file($i_fileTmp, $saveFile) !== FALSE) {

								// set data values and return this data
								$dataUpload = array(
									'upload_dir'	=>	$upload_dir,
									'allow_type'	=>	$allow_type,
									'max_size'		=>	$max_size,
									'max_upload'	=>	$max_upload,
									'file_upload'	=>
									array(
										'file_location'		=>	$saveFile,
										'file_name'			=>	$filename_upload,
										'file_size'			=>	$i_fileSize,
										'file_mime'			=>	$i_fileType,
										'file_type'			=>	$u_fileType
									)
								);

								return $dataUpload;
							} else {
								return FALSE;
							}
						} else {
							return FALSE;
						}
					} else {

						return FALSE;
					}
				}
			}

			// multiple upload

			elseif ($count_file > 1 || is_array($_FILES[$inputName]['name'])) {

				// set var counter error
				$error = 0;

				// upload all
				for ($i = 0; $i < $count_file; $i++) {
					// get file upload
					// if isset array value
					$i_fileName		= $_FILES[$inputName]['name'][$i];
					$i_fileType		= $_FILES[$inputName]['type'][$i];
					$i_fileSize		= $_FILES[$inputName]['size'][$i];
					$i_fileTmp		= $_FILES[$inputName]['tmp_name'][$i];

					// set vars
					$getType = explode('/', $i_fileType);
					$u_fileType = strtolower($getType[1]);

					// check filesize upload file
					if ($i_fileSize > $max_size) {
						$error++;
						return FALSE;
						break;
					} else {

						// check upload dir
						if (is_dir($upload_dir) !== FALSE) {

							// check type of file upload
							if (
								strpos($allow_type, $u_fileType) !== FALSE or
								trim($allow_type) == ""
							) {

								// upload file

								$filename_upload = isset($config['filename']) &&
									trim($config['filename']) !== "" ?
									$i . '_' . date('HisdmY') . '_' . trim($config['filename']) . '.' . $u_fileType : $i . '_' . date('HisdmY') . '_' . $i_fileName;

								// user filename
								$saveFile = "{$upload_dir}{$filename_upload}";

								// upload
								if (move_uploaded_file($i_fileTmp, $saveFile) !== FALSE) {

									$file_name_all[] = $filename_upload;
									$file_location_all[] = $saveFile;
									$file_size_all[] = $i_fileSize;
									$file_mime_all[] = $i_fileType;
									$file_type_all[] = $u_fileType;
								} else {
									$error++;
									break;
								}
							} else {
								$error++;
								break;
							}
						} else {
							$error++;
							break;
						}
					}
				}

				if ($error >= 1) {

					// error detect
					//delete file if detect error upload file
					if (isset($file_location_all) && is_array($file_location_all)) {
						foreach ($file_location_all as $key => $value) {
							@unlink($value);
						}
					}

					return FALSE;
				} else {
					// set data values and return this data
					$dataUpload = array(
						'upload_dir'	=>	$upload_dir,
						'allow_type'	=>	$allow_type,
						'max_size'		=>	$max_size,
						'max_upload'	=>	$max_upload,
						'file_upload'	=>
						array(
							'file_location'		=>	$file_location_all,
							'file_name'			=>	$file_name_all,
							'file_size'			=>	$file_size_all,
							'file_mime'			=>	$file_mime_all,
							'file_type'			=>	$file_type_all
						)
					);

					return $dataUpload;
				}
			}

			// file not found
			else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}
