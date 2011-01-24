<?php

class AuthComponent
{
	public $UserModel = null;
	public $Controller;
	public $Session;
	public $Allows = array();
	public $Roles = null;
	
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
				$this->Session->Set('Auth.Login', $userRow);
				return true;
			}
			else return false;
		}
		else
		{
			if (!$this->Session->KeyExists('Auth.Login')) return false;
			
			$userLogin = $this->Session->Get('Auth.Login');
			$userRow = $this->UserModel->GetUserByName($userLogin['Username']);
			
			if ($userRow !== null && $userRow['Password'] === $userLogin['Password']) { $this->Session->Set('Auth.Login', $userRow); return true; }
			else
			{
				$this->Logout();
				return false;
			}
		}
	}
	
	public function LoginPost()
	{
		return $this->Login(isset($_POST['Username']) ? $_POST['Username'] : null, isset($_POST['Password']) ? $_POST['Password'] : null);
	}
	
	public function Allow($action, $roles = '*')
	{
		if ($roles === '*') $this->Allows[$action] = $this->Roles != null ? $this->Roles : $roles;
		if (is_string($roles)) $roles = array($roles);
		
		if (!array_key_exists($action, $this->Allows))
		{
			if (is_array($roles))
			{
				if (in_array('*', $roles)) $this->Allows[$action] = $this->Roles != null ? $this->Roles : '*';
				else $this->Allows[$action] = $roles;
			}
		}
		else if (is_array($this->Allows[$action]))
		{
			if (in_array('*', $roles)) $this->Allows[$action] = $this->Roles != null ? $this->Roles : '*';
			else if (is_array($roles)) foreach ($roles as $role) if (!in_array($role, $this->Allows[$action])) $this->Allows[$action][] = $role;
		}
	}
	
	public function AllowLoggedIn($action)
	{
		if ($this->Roles === null) { Debug::LogWarning('Auth->Roles is not set.'); return; }
		$this->Allows[$action] = $this->Roles;
	}

	public function Deny($action, $roles = '*')
	{
		if ($roles === '*') $this->Allows = array();
		if (is_string($roles)) $roles = array($roles);
		
		if (array_key_exists($action, $this->Allows))
		{
			if (is_string($this->Allows[$action]))
			{
				if ($this->Roles !== null)
				{
					foreach ($this->Roles as $role) if (!in_array($role, $roles)) $this->Allows[$action][] = $role;
				}
				else Debug::LogWarning('Auth->Roles is not set.');
			}
			else $this->Allows[$action] = array_filter($this->Allows[$action], function ($role) use ($roles) { return !in_array($role, $roles); });
		}
	}
	
	public function Role($user = null, $password = null)
	{
		if (!$this->Login($user, $password)) return null;
		$userRow = $this->Session->Get('Auth.Login');
		return $userRow['Role'];
	}
	
	public function IsAllowed($action, $user = null, $password = null)
	{
		if (!array_key_exists($action, $this->Allows)) return false;
		if ($this->Allows[$action] === '*') return true;
		$role = $this->Role($user, $password);
		if ($role === null) return false;
		
		return in_array($role, $this->Allows[$action]);
	}
	
	public function RequireAllowed($action, $user = null, $password = null, $goto = 'Error/NotAuthorized', $setReturnFlash = true)
	{
		if (!$this->IsAllowed($action, $user, $password))
		{
			if ($setReturnFlash)
			{
				if (isset($this->Controller->ControllerName)) $this->Session->SetFlash('Login.ReturnTo', $this->Controller->ControllerName . '/' . $action);
				else Debug::LogWarning('Controller->ControllerName is not set.');
			}
			
			Router::Redirect($goto);
		}
	}
	
	public function Logout()
	{
		$this->Session->Delete('Auth.Login');
	}
	
	public function HashPassword($password, $algo = 'sha1')
	{
		return hash($algo, $password);
	}
}