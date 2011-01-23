<?php

abstract class Controller
{
	public $View;
	
	public function __construct()
	{
		$this->View = new View();
	}
	
	protected function LoadModel($model)
	{
		$modelName = $model . 'Model';
		if (!Bootstrap::LoadModel($model)) return false;
		$this->$model = new $modelName();
		
		return true;
	}
	
	protected function LoadModels()
	{
		$all = true;
		foreach (func_get_args() as $model) if (!$this->LoadModel($model)) $all = false;
		return $all;
	}
	
	protected function LoadComponent($component)
	{
		$componentName = $component . 'Component';
		if (!Bootstrap::LoadComponent($component)) return false;
		$this->$component = new $componentName($this);
		
		return true;
	}
	
	protected function LoadComponents()
	{
		$all = true;
		foreach (func_get_args() as $component) if (!$this->LoadComponent($component)) $all = false;
		return $all;
	}
}