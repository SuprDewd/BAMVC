<?php

class Router
{
	public static function Initialize($url = Request, $isFallback = false)
	{
		$urlArray = explode("/", rtrim($url, WDS));
	
		$controller = (count($urlArray) > 0 && $urlArray[0] !== '' ? $urlArray[0] : Config::Read('Router.Default.Controller')) . 'Controller';
		array_shift($urlArray);
		$action = count($urlArray) > 0 ? $urlArray[0] : Config::Read('Router.Default.Action');
		array_shift($urlArray);
		
		if (__autoload($controller))
		{
			$dispatch = new $controller(/*$model, $controllerName, $action*/);
			
			if ($action[0] !== '_' && method_exists($controller, $action)/* && TODO: Action must be a public function! */)
			{
				if (method_exists($controller, 'BeforeAction')) call_user_func_array(array($dispatch, 'BeforeAction'), $urlArray);
				call_user_func_array(array($dispatch, $action), $urlArray);
				if (method_exists($controller, 'AfterAction')) call_user_func_array(array($dispatch, 'AfterAction'), $urlArray);
			}
			else if ($isFallback) return; // TODO: Handle Error! 
			else self::Initialize('Http/Error404', true);
		}
		else if ($isFallback) return; // TODO: Handle Error!
		else self::Initialize('Http/Error404', true);
	}
}