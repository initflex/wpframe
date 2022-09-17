<?php

namespace WPFP\App\Helpers;

class Url
{
	public function __construct()
	{
		// add something
	}

	public function typeConnection()
	{
		$this->type_conn = $_SERVER['REQUEST_SCHEME'];
		return $this->type_conn;
	}

	public function getHost()
	{
		$this->getHost = $_SERVER['SERVER_NAME'];
		return $this->getHost;
	}

	public function getPort()
	{
		$this->getPort = $_SERVER['SERVER_PORT'];
		return $this->getPort;
	}

	public function getHostPort()
	{
		$this->getHostPort = $this->getHost() . ':' . $_SERVER['SERVER_PORT'];
		return $this->getHostPort;
	}

	public function requestUri()
	{
		$this->requestUri = $_SERVER['REQUEST_URI'];
		return $this->requestUri;
	}

	public function locSelf()
	{
		$this->locSelf = $_SERVER['REQUEST_URI'];

		return $this->locSelf;
	}

	public function createSlug($slug = NULL)
	{
		// check first slug, and create slug
		$this->slug = $slug !== NULL ? str_replace(' ', '-', $slug) : FALSE;
		return $this->slug;
	}

	public function get_load_time_start()
	{
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[0] + $time[1];
		$start = $time;
		return $start;
	}

	public function get_load_time_end($start)
	{
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[0] + $time[1];
		$finish = $time;

		$tRender = round($finish - $start, 4);
		return $tRender;
	}
}
