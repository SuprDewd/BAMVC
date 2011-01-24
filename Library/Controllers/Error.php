<?php

class ErrorController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->View->Set('Title', 'Error');
		$this->View->LoadHelper('Html');
	}
	
	public function NotFound()
	{
		return $this->View->Render('Error/NotFound', 'Layout');
	}
	
	public function NotAuthorized()
	{
		return $this->View->Render('Error/NotAuthorized', 'Layout');
	}
}