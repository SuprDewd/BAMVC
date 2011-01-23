<?php

class ErrorController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->View->Set('Title', 'Error');
	}
	
	public function NotFound()
	{
		return $this->View->Render('Error/NotFound', 'Layout');
	}
}