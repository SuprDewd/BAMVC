<?php

class View
{
	protected $Variables = array();
	protected $Controller;
	
	public function __construct($controller)
	{
		$this->Controller = $controller;
	}
	
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
		$view = Bootstrap::GetViewPath($view);
		$template = $template === null ? null : Bootstrap::GetSharedViewPath($template);
		
		if (!file_exists($view) || ($template !== null && !file_exists($template))) return false;
		
		$this->Set('View', $view);
		$this->Set('Template', $template);
		$this->Set('Controller', $this->Controller);
		
		unset($view);
		unset($template);
		
		extract($this->Variables);
		include ($t = $this->Get('Template')) !== null ? $t : $this->Get('View');
		$this->Clear();
		
		return true;
	}
	
	private function RenderElementPrivate($element, $variables = array())
	{
		$element = Bootstrap::GetElementPath($element);
		if ($element === null) return false;
		
		$this->Variables = $variables;
		$this->Set('Element', $element);
		
		unset($element);
		unset($variables);
		
		extract($this->Variables);
		include $this->Get('Element');
		$this->Clear();
		
		return true;
	}
	
	public static function RenderElement($element, $variables = array())
	{
		$view = new View(null);
		return $view->RenderElementPrivate($element, $variables);
	}
	
	public function LoadHelper($helper)
	{
		$helperName = $helper . 'Helper';
		if (!Bootstrap::LoadHelper($helper)) return false;
		$this->Set($helper, new $helperName($this, $this->Controller));
		
		return true;
	}
	
	public function LoadHelpers()
	{
		$all = true;
		foreach (func_get_args() as $helper) if (!self::LoadHelper($helper)) $all = false;
		return $all;
	}
}