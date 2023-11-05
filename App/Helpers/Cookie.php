<?php

namespace WPFP\App\Helpers;

class Cookie
{
	public function set_cookie($c_name = NULL, $c_val = NULL, $c_exp = NULL, $c_path = NULL, $c_do = NULL, $c_sec = NULL, $c_ho = NULL)
	{
		// check cookie
		if (
			isset($c_name) && $c_name !== NULL && trim($c_name) !== '' &&
			isset($c_val) && $c_val !== NULL && trim($c_val) !== ''
		) {

			// set cookie params
			$cookie_name = isset($c_name) && trim($c_name) !== '' && $c_name !== '' ?
				$c_name : null;
			$cookie_val = isset($c_val) && trim($c_val) !== '' && $c_val !== '' ?
				$c_val : null;
			$cookie_exp = isset($c_exp) && trim($c_exp) !== '' && $c_exp !== '' ?
				$c_exp : 0;
			$cookie_path = isset($c_path) && trim($c_path) !== '' && $c_path !== '' ?
				$c_path : '/';
			$cookie_do = isset($c_do) && trim($c_do) !== '' && $c_do !== '' ?
				$c_do : false;
			$cookie_sec = isset($c_sec) && trim($c_sec) !== '' && $c_sec !== '' ?
				$c_sec : false;
			$cookie_ho = isset($c_ho) && trim($c_ho) !== '' && $c_ho !== '' ?
				$c_ho : false;

			// set cookie
			$set_cookie = setcookie($cookie_name, $cookie_val, $cookie_exp, $cookie_path, $cookie_do, $cookie_sec, $cookie_ho);

			// return $cookie
			return $set_cookie !== FALSE ? TRUE : FALSE;
		} else {
			return FALSE;
		}
	}

	public function get_cookie($c_name = NULL)
	{

		// get cookie
		$getCookie = isset($c_name) && $c_name !== NULL && trim($c_name) !== '' && isset($_COOKIE[$c_name]) ? $_COOKIE[$c_name] : FALSE;

		return $getCookie;
	}

	public function unset_cookie($c_name = NULL, $c_val = NULL, $c_exp = NULL, $c_path = NULL, $c_do = NULL, $c_sec = NULL, $c_ho = NULL)
	{
		// check cookie
		if (
			isset($c_name) && $c_name !== NULL && trim($c_name) !== ''
		) {

			// set cookie params
			$cookie_name = isset($c_name) && trim($c_name) !== '' && $c_name !== '' ?
				$c_name : null;
			$cookie_val = isset($c_val) && trim($c_val) !== '' && $c_val !== '' ?
				$c_val : '';
			$cookie_exp = isset($c_exp) && trim($c_exp) !== '' && $c_exp !== '' ?
				$c_exp : 0;
			$cookie_path = isset($c_path) && trim($c_path) !== '' && $c_path !== '' ?
				$c_path : '/';
			$cookie_do = isset($c_do) && trim($c_do) !== '' && $c_do !== '' ?
				$c_do : false;
			$cookie_sec = isset($c_sec) && trim($c_sec) !== '' && $c_sec !== '' ?
				$c_sec : false;
			$cookie_ho = isset($c_ho) && trim($c_ho) !== '' && $c_ho !== '' ?
				$c_ho : false;

			// set cookie
			$set_cookie = setcookie($cookie_name, '', $cookie_exp, $cookie_path, $cookie_do, $cookie_sec, $cookie_ho);

			// return $cookie
			return $set_cookie !== FALSE ? TRUE : FALSE;
		} else {
			return FALSE;
		}
	}
}
