<?php

namespace WPFP\App\Libraries;

class Session
{
	public function set_session($session_name = NULL, $session_val = NULL)
	{
		if ($session_name !== NULL && is_array($session_name) && count($session_name) > 0) {
			// array method is set

			// is data session
			$this->dataSess = $session_name;

			foreach ($this->dataSess as $name => $val) {
				if (trim($name) !== '' && trim($val) !== '') {

					// set session
					$_SESSION[$name] = $val;
				}
			}
		} else {

			// array method not set
			if ($session_name !== NULL && !empty($session_name)) {
				if ($session_val !== NULL && !empty($session_val)) {

					// set session
					$_SESSION[$session_name] = $session_val;
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
	}

	public function get_session($session_name = NULL)
	{
		if ($session_name !== NULL && !empty($session_name)) {
			$this->session = isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : FALSE;
			return $this->session;
		} else {
			return FALSE;
		}
	}

	public function set_flashsession($session_name = NULL, $session_val = NULL)
	{
		// check name and val session
		if ($session_name !== NULL && !empty($session_name)) {
			if ($session_val !== NULL && !empty($session_val)) {

				// set flash session
				$_SESSION[$session_name] = $session_val;
				$this->session = isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : FALSE;
				return $this->session;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function flashsession($session_name = NULL)
	{
		if ($session_name !== NULL && !empty($session_name)) {
			// get data flash session
			$this->flashsession = isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : FALSE;

			// unset session
			if (isset($_SESSION[$session_name])) {
				unset($_SESSION[$session_name]);
			}

			return $this->flashsession;
		} else {
			return FALSE;
		}
	}

	public function unset_session($session_name = NULL)
	{
		if ($session_name !== NULL && is_array($session_name) && count($session_name) > 0) {

			$this->sessionName = $session_name;
			foreach ($this->sessionName as $name) {
				if (isset($_SESSION[$name]) && trim($_SESSION[$name]) !== '') {

					// unset session
					unset($_SESSION[$name]);
				}
			}
		} else {

			// session name is not array
			if ($session_name !== NULL) {
				if (isset($_SESSION[$session_name])) {
					// unset session
					unset($_SESSION[$session_name]);
				}
			} else {
				return FALSE;
			}
		}
	}
}
