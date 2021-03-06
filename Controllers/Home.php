<?php

class HomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->View->Set('Title', 'Home');
		$this->View->LoadHelper('Html');
		$this->LoadComponent('Auth');
		$this->Auth->UserModel = $this->LoadModel('User');
		$this->Auth->Roles = Config::Read('Auth.Roles');
	}
	
	public function Index()
	{
		$this->LoadModel('Animal');
		$this->LoadComponent('Test');
		$this->View->Set('Title', 'Meow');
		
		$animals = array();
		foreach ($this->Animal->FindAll() as $animal)
		{
			$animals[] = $this->Test->ToUpperCase($animal['Name']);
		}
		
		$this->View->Set('Animals', $animals);
		return $this->View->Render('Home/Index', 'Layout');
	}
	
	public function View($id)
	{
		$this->LoadModel('Animal');
		$this->View->Set('Animal', $this->Animal->FindByID($id));
		return $this->View->Render('Home/View', 'Layout');
	}
	
	public function Test()
	{
		Router::Redirect('Home/Index');
	}
	
	public function Cache()
	{
		if (($time = Cache::Get('TestCache')) === false)
		{
			$time = date('d m Y G:i:s');
			Cache::Set('TestCache', $time, strtotime('+10 minute'));
		}
		
		echo $time;
	}
	
	public function ElementHelp()
	{
		$this->View->Render('Home/ElementHelp', 'Layout');
	}
}