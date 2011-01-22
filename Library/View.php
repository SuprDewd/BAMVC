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
	
	public function Clear()
	{
		$this->Variables = array();
	}
	
	public function Render($view, $template = null)
	{
		$view = Views . $view . '.php';
		$template = $template == null ? null : SharedViews . $template . '.php';
		
		// TODO: Handle missing template or view.
		
		$this->Set('View', $view);
		$this->Set('Template', $template);
		
		unset($view);
		unset($template);
		
		extract($this->Variables);
		
		include $this->Get('Template') !== null ? $this->Get('Template') : $this->Get('View');
	}
}