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
	
	public function FlashExists($key)
	{
		return $this->KeyExists('Flash.' . $key);
	}
	
	public function SetFlash($key, $value)
	{
		$this->Set('Flash.' . $key, $value);
	}
	
	public function GetFlash($key)
	{
		$key = 'Flash.' . $key;
		if ($this->KeyExists($key))
		{
			$value = $this->Get($key);
			$this->Delete($key);
			return $value;
		}
		else return null;
	}
	
	public function DeleteFlash($key)
	{
		$this->Delete('Flash.' . $key);
	}
	
	public function ClearFlash()
	{
		foreach ($_SESSION as $key => $value) if (strpos('Flash.', $key) === 0) $this->Delete($key);
	}
}