<?php

class AuthComponent
{
	public $UserModel = null;
	public $Controller;
	public $Session;
	public $Allows = array();
	
	public function __construct($controller)
	{
		$this->Controller = $controller;
		$this->Session = $this->Controller->LoadComponent('Session');
	}
	
	public function Login($username = null, $password = null)
	{
		if ($this->UserModel === null || !($this->UserModel instanceof AbstractUserModel)) return false;
		
		if ($username !== null && $password !== null)
		{
			$password = $this->HashPassword($password);
			$userRow = $this->UserModel->GetUserByName($username);
			
			if ($userRow !== null && $userRow['Password'] === $password)
			{
				$this->Session->Set('UserLogin', $userRow);
				return true;
			}
			else return false;
		}
		else
		{
			if (!$this->Session->KeyExists('UserLogin')) return false;
			
			$userLogin = $this->Session->Get('UserLogin');
			$userRow = $this->UserModel->GetUserByName($userLogin['Username']);
			
			if ($userRow !== null && $userRow['Password'] === $userLogin['Password']) { $this->Session->Set('UserLogin', $userRow); return true; }
			else
			{
				$this->Logout();
				return false;
			}
		}
	}
	
	public function Allow($action, $roles = '*')
	{
		if ($roles === '*') $this->Allows[$action] = $roles;
		if (is_string($roles)) $roles = array($roles);
		
		if (!array_key_exists($action, $this->Allows))
		{
			if (is_array($roles)) $this->Allows[$action] = $roles;
		}
		else if (is_array($this->Allows[$action]))
		{
			if (is_array($roles)) foreach ($roles as $role) if (!in_array($role, $this->Allows[$action])) $this->Allows[$action][] = $role;
		}
	}
	
	public function Role($user = null, $password = null)
	{
		if (!$this->Login($user, $password)) return null;
		$userRow = $this->Session->Get('UserLogin');
		return $userRow['Role'];
	}
	
	public function IsAllowed($action, $user = null, $password = null)
	{
		if (!in_array($action, $this->Allows)) return false;
		if ($this->Allows[$action] === '*') return true;
		$role = $this->Role($user, $password);
		if ($role === null) return false;
		
		return in_array($role, $this->Allows[$action]);
	}
	
	public function RequireAllowed($action, $user = null, $password = null)
	{
		if (!$this->IsAllowed($action, $user, $password)) Router::Redirect('Error', 'NotAuthorized');
	}
	
	public function Logout()
	{
		$this->Session->Delete('UserLogin');
	}
	
	public function HashPassword($password, $algo = 'sha1')
	{
		return hash($algo, $password);
	}
}