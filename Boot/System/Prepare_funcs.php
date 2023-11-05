<?php

/**
 * CodeIgniter - Mit License
 */

if (!function_exists('is_really_writable')) {
	/**
	 * Tests for file writability
	 *
	 * is_writable() returns TRUE on Windows servers when you really can't write to
	 * the file, based on the read-only attribute. is_writable() is also unreliable
	 * on Unix servers if safe_mode is on.
	 *
	 * @link	https://bugs.php.net/bug.php?id=54709
	 * @param	string
	 * @return	bool
	 */
	function is_really_writable($file)
	{
		// If we're on a Unix server with safe_mode off we call is_writable
		if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or !ini_get('safe_mode'))) {
			return is_writable($file);
		}

		/* For Windows servers and safe_mode "on" installations we'll actually
		 * write a file then read it. Bah...
		 */
		if (is_dir($file)) {
			$file = rtrim($file, '/') . '/' . md5(mt_rand());
			if (($fp = @fopen($file, 'ab')) === FALSE) {
				return FALSE;
			}

			fclose($fp);
			@chmod($file, 0777);
			@unlink($file);
			return TRUE;
		} elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === FALSE) {
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
}

// Log Message
function log_message($logMessageSetStatus, $logMessageSetMsg)
{
	// echo "<div><hr>";
	// echo 'Status: '. $logMessageSetStatus .'<br/>';
	// echo 'Message: '. $logMessageSetMsg .'<br/>';
	// echo "<hr></div>";
}

// CI3 Prefix Config
function config_item($item)
{
	return $GLOBALS['WPFP_CONFIG']['CI3_PREFIX_CONFIG'][$item];
}

/**
 * Show error function
 *
 * @param	string
 * @return	void	Return is String or Void data.
 */
function show_error($errMsg = null)
{
	echo "<div><hr>";
	echo 'Message: ' . $errMsg . '<br/>';
	echo "<hr></div>";
}

if (!function_exists('is_php')) {
	/**
	 * Determines if the current version of PHP is equal to or greater than the supplied value
	 *
	 * @param	string
	 * @return	bool	TRUE if the current version is $version or higher
	 */
	function is_php($version)
	{
		static $_is_php;
		$version = (string) $version;

		if (!isset($_is_php[$version])) {
			$_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
		}
		return $_is_php[$version];
	}
}

 /** 
  * request fullscreen page
  */
function wpfp_fullscreen()
{
	@ob_end_clean();
}

/** 
  * end request fullscreen page
  */
function wpfp_fullscreen_end()
{
	@exit();
}

/** 
  * Redirect - Default Header Function
  * @param  String  $url  for set url redirect
  * @param  Integer  $permanent  For Set Redirect Status Code  
  */
function wpfp_redirect_url($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

/** 
  * Redirect Admin url
  * @param  String  $pageName  for set page name
  * @param  String  $methodName   For Set Method Name
  * @param  Array  $paramsSet  For Set Parameters Redirect - Default Empty Array
  * @param Integer  $statusCode  For set Status Code Redirect - Default Status Code 301
  * @return false|void  
  */
function wpfp_admin_redirect($pageName = null, $methodName = null, $paramsSet = [], $statusCode = 301)
{
	$adminUrl = admin_url('admin.php');
	$pageFormatUrl = '?page=';
	$methodUrl = '&m=';
	$setUrl = '';
	
	if (is_array($paramsSet) && count($paramsSet) > 0) {
		$paramSetTemp = '';
		foreach ($paramsSet as $key => $value) {
			$paramSetTemp .= '&'. $key .'='. $value;
		}
		$paramsSetData = $paramSetTemp;
	}else{
		$paramsSetData = '';
	}

	if ($pageName !== null && $pageName !== '' && 
		$methodName !== null && $methodName !== '') {
			$setUrl = $adminUrl . $pageFormatUrl . $pageName . $methodUrl . $methodName . $paramsSetData;
			wpfp_redirect_url($setUrl, $statusCode);
	} else {
		return FALSE;
	}
}

function __wpfp_lang($identifier_text_content = '')
{
	$identifier_text_content  = trim($identifier_text_content);
	if ($identifier_text_content !== '') {

		// detect locale
		if (function_exists('get_locale')) {

			$pluginDir = $GLOBALS['WPFP_CONFIG']['plugin_dir'];
			$pathLang = $GLOBALS['WPFP_CONFIG']['lang_path'];

			$langSetLocale = get_locale();

			$setlangFile = $pluginDir . $pathLang . $langSetLocale .'/'. $langSetLocale .'.php';

			// check lang file
			if (file_exists($setlangFile)) {
				
				include $setlangFile;

				// check set language in register variable
				if (isset($lang_register)) {

					// check set language in register variable
					if (isset($lang_register[$identifier_text_content])) {
						$setContent = $lang_register[$identifier_text_content];
						return $setContent;
					} else {
						return '';
					}
				} else {
					return 'Variable register not set.';
				}
			} else {
				return 'Language: '. $langSetLocale .'. File Not Found. ';
			}
			
			
		}else{
			// get_locale not avaiable.
			return '';
		}
		
	}else {
		return '';
	}
}