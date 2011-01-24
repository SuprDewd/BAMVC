<?php

class UserController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->LoadComponent('Auth');
		$this->Auth->UserModel = $this->LoadModel('User');
		$this->View->LoadHelper('Html');
		$this->Auth->Allow('Add', 'Admin');
		$this->Auth->Allow('Role', array('User', 'Admin'));
	}
	
	public function Register($username = '', $error = false)
	{
		if ($this->Auth->Login()) Router::Redirect('');
		$this->View->Set('Username', $username);
		$this->View->Set('Error', $error !== false);
		return $this->View->Render('User/Register', 'Layout');
	}
	
	public function RegisterSubmit()
	{
		if ($this->Auth->Login()) Router::Redirect('');
		if (isset($_POST['Username']) &&
			isset($_POST['Password']) &&
			isset($_POST['PasswordAgain']) &&
			$_POST['Password'] === $_POST['PasswordAgain'] &&
			$this->User->Create($_POST['Username'], $this->Auth->HashPassword($_POST['Password'])))
		{
			$this->Auth->Login($_POST['Username'], $_POST['Password']);
			return $this->View->Render('User/RegisterSubmit', 'Layout');
		}
		else Router::Redirect('User', 'Register', isset($_POST['Username']) ? urlencode($_POST['Username']) : '', 'Error');
	}
	
	public function Login($username = '', $error = false)
	{
		if ($this->Auth->Login()) Router::Redirect('');
		$this->View->Set('Username', $username);
		$this->View->Set('Error', $error !== false);
		return $this->View->Render('User/Login', 'Layout');
	}
	
	public function LoginSubmit()
	{
		if ($this->Auth->Login(isset($_POST['Username']) ? $_POST['Username'] : null, isset($_POST['Password']) ? $_POST['Password'] : null)) Router::Redirect('');
		else Router::Redirect('User', 'Login', isset($_POST['Username']) ? urlencode($_POST['Username']) : '', 'Error');
	}
	
	public function Logout()
	{
		$this->Auth->Logout();
		Router::Redirect('');
	}

	public function Role()
	{
		var_dump($this->Auth->Role());
	}
}