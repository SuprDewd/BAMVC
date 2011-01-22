<?php

class View
{
	private $Variables = array();
	
	public function Set($key, $value)
	{
		$this->Variables[$key] = $value;
	}
	
	public function Get($key)
	{
		return $this->Variables[$key];
	}
	
	public function Render($view, $template = null)
	{
		$view = Views . $view . '.php';
		$template = SharedViews . $view . '.php';
		
		$this->Set('View', $view);
		$this->Set('Template', $template);
		
		unset($view);
		unset($template);
		
		export($this->Variables);
		
		// TODO: Handle missing template or view.
		
		include $this->Get('Template') !== null ? $this->Get('Template') : $this->Get('View');
	}
}