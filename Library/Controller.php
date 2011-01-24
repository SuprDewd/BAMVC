<?php

abstract class Controller
{
	public $View;
	public $LoadedModels = array();
	public $LoadedComponents = array();
	
	public function __construct()
	{
		$this->View = new View();
	}
	
	public function LoadModel($model)
	{
		if (in_array($model, $this->LoadedModels)) return $this->$model;
		
		$modelName = $model . 'Model';
		if (!Bootstrap::LoadModel($model)) return false;
		$this->LoadedModels[] = $model;
		
		return $this->$model = new $modelName();
	}
	
	public function LoadModels()
	{
		$all = true;
		foreach (func_get_args() as $model) if ($this->LoadModel($model) === false) $all = false;
		return $all;
	}
	
	public function LoadComponent($component)
	{
		if (in_array($component, $this->LoadedComponents)) return $this->$component;
		
		$componentName = $component . 'Component';
		if (!Bootstrap::LoadComponent($component)) return false;
		$this->LoadedComponents[] = $component;
		
		return $this->$component = new $componentName($this);
	}
	
	public function LoadComponents()
	{
		$all = true;
		foreach (func_get_args() as $component) if ($this->LoadComponent($component) === false) $all = false;
		return $all;
	}
	
	public function SendContentType($contentType)
	{
		$this->SendHeader('Content-Type', $contentType);
	}
	
	public function SendLocation($location)
	{
		$this->SendHeader('Location', $location);
	}
	
	public function SendHeader($key, $value)
	{
		header($key . ': ' . $value);
	}
}