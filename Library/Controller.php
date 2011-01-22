<?php

abstract class Controller
{
	public $View;
	
	public function __construct()
	{
		$this->View = new View();
	}
}