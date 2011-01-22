<?php

class HomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->View->Set('Title', 'Home');
	}
	
	public function Index()
	{
		$this->View->Set('Title', 'Meow');
		$this->View->Set('Animals', array('Cat', 'Dog', 'Horse', 'Frog', 'Snake', 'Hamster', 'Parrot', 'Donkey', 'Spider', 'Rabbit'));
		$this->View->Render('Home/Index', 'Layout');
	}
}