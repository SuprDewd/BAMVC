<?php

class HttpController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->View->Set('Title', 'Error');
	}
	
	public function Error404()
	{
		$this->View->Render('Http/Error404', 'Layout');
	}
}