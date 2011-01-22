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
		
		if (!__autoload($controller)) { self::Error(); return; }
		
		$dispatch = new $controller();
		
		if (!($action[0] !== '_' && $action !== 'BeforeAction' && $action !== 'AfterAction' && method_exists($controller, $action))) { self::Error(); return; }
		
		$dispatchAction = new ReflectionMethod($dispatch, $action);
		
		if (!$dispatchAction->isPublic() || $dispatchAction->isStatic()) { self::Error(); return; }
		
		if (method_exists($controller, 'BeforeAction')) call_user_func_array(array($dispatch, 'BeforeAction'), $urlArray);
		// call_user_func_array(array($dispatch, $action), $urlArray);
		$dispatchAction->invokeArgs($dispatch, $urlArray);
		if (method_exists($controller, 'AfterAction')) call_user_func_array(array($dispatch, 'AfterAction'), $urlArray);
	}

	private static function Error($isFallback)
	{
		if ($isFallback) return; // TODO: Handle Error!
		else self::Initialize('Http/Error404', true);
	}
}