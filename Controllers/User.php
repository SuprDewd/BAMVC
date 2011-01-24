<?php

class UserController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->LoadComponents('Auth', 'Recaptcha');
		$this->Auth->UserModel = $this->LoadModel('User');
		$this->View->LoadHelpers('Html', 'Recaptcha');
		$this->Auth->Roles = Config::Read('Auth.Roles');
		$this->Auth->Allow('Add', 'Admin');
		$this->Auth->Allow('Role', array('User', 'Admin'));
	}
	
	public function Register()
	{
		if ($this->Auth->Login()) Router::Redirect('');
		$this->View->Set('Username', $this->Session->GetFlash('Register.Username'));
		$this->View->Set('GeneralError', $this->Session->GetFlash('Register.Error') === true);
		$this->View->Set('Errors', $this->Session->GetFlash('Register.Errors'));
		return $this->View->Render('User/Register', 'Layout');
	}
	
	public function RegisterSubmit()
	{
		if ($this->Auth->Login()) Router::Redirect('');
		if (isset($_POST['Username']) &&
			isset($_POST['Password']) &&
			isset($_POST['PasswordAgain']) &&
			($errors = $this->User->IsValid(trim($_POST['Username']), $_POST['Password'], $_POST['PasswordAgain'], $this->Recaptcha->CheckAnswer($_SERVER['REMOTE_ADDR'])->IsValid)) === true)
		{
			if (!$this->User->Create(trim($_POST['Username']), $this->Auth->HashPassword($_POST['Password']))) Router::Redirect('User', 'Register', isset($_POST['Username']) ? urlencode($_POST['Username']) : '', 'Error');
			else
			{
				$this->Auth->Login($_POST['Username'], $_POST['Password']);
				return $this->View->Render('User/RegisterSubmit', 'Layout');
			}
		}
		else
		{
			$this->Session->SetFlash('Register.Errors', $errors);
			$this->Session->SetFlash('Register.Username', $_POST['Username']);
			$this->Session->SetFlash('Register.Error', true);
			Router::Redirect('User', 'Register');
		}
	}
	
	public function Login()
	{
		if ($this->Auth->Login()) Router::Redirect('');
		$this->View->Set('Username', $this->Session->GetFlash('Login.Username'));
		$this->View->Set('Error', $this->Session->GetFlash('Login.Error') === true);
		return $this->View->Render('User/Login', 'Layout');
	}
	
	public function LoginSubmit()
	{
		if ($this->Auth->LoginPost()) Router::Redirect($this->Session->FlashExists('Login.ReturnTo') ? $this->Session->GetFlash('Login.ReturnTo') : '');
		else
		{
			$this->Session->SetFlash('Login.Username', $_POST['Username']);
			$this->Session->SetFlash('Login.Error', true);
			Router::Redirect('User', 'Login');
		}
	}
	
	public function Logout()
	{
		$this->Auth->Logout();
		Router::Redirect('');
	}

	public function Role()
	{
		$this->Auth->RequireAllowed('Role', null, null, 'Login');
		var_dump($this->Auth->Role());
	}
}