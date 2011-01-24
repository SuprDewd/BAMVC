<?php

class SessionComponent
{
	public $Started = false;
	
	public function Start()
	{
		if (!$this->Started)
		{
			session_start();
			$this->Started = true;
		}
	}
	
	public function Get($key)
	{
		$this->Start();
		return $_SESSION[$key];
	}
	
	public function Set($key, $value)
	{
		$this->Start();
		$_SESSION[$key] = $value;
	}
	
	public function Delete($key)
	{
		$this->Start();
		unset($_SESSION[$key]);
	}
	
	public function Clear()
	{
		$this->Start();
		session_unset();
	}
	
	public function KeyExists($key)
	{
		$this->Start();
		return array_key_exists($key, $_SESSION);
	}
}