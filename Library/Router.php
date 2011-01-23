<?php

class Router
{
	public static function Initialize($url = Request, $isFallback = false)
	{
		$urlArray = explode(WDS, self::ApplyCustomRoutes(rtrim($url, WDS)));
	
		$controllerFile = (count($urlArray) > 0 && $urlArray[0] !== '' ? $urlArray[0] : Config::Read('Router.Default.Controller'));
		$controller = $controllerFile . 'Controller';
		array_shift($urlArray);
		$action = count($urlArray) > 0 ? $urlArray[0] : Config::Read('Router.Default.Action');
		array_shift($urlArray);
		
		if (!Bootstrap::LoadController($controllerFile)) { self::Error($isFallback); return; }
		
		$dispatch = new $controller();
		if (!($action[0] !== '_' && $action !== 'BeforeAction' && $action !== 'AfterAction' && method_exists($controller, $action))) { self::Error($isFallback); return; }

		$dispatchAction = new ReflectionMethod($dispatch, $action);
		if (!$dispatchAction->isPublic() || $dispatchAction->isStatic() || count($urlArray) < $dispatchAction->getNumberOfRequiredParameters()) { self::Error($isFallback); return; }

		if (method_exists($controller, 'BeforeAction')) call_user_func_array(array($dispatch, 'BeforeAction'), $urlArray);
		$ok = $dispatchAction->invokeArgs($dispatch, $urlArray);
		if (method_exists($controller, 'AfterAction')) call_user_func_array(array($dispatch, 'AfterAction'), $urlArray);
		
		if ($ok === false) self::Error($isFallback);
	}

	private static function Error($isFallback)
	{
		if ($isFallback) echo 'Error.';
		else self::Initialize('Error/NotFound', true);
	}

	public static function Redirect()
	{
		header('Location: ' . WebRoot . implode('/', func_get_args()));
		exit();
	}
	
	public static function ApplyCustomRoutes($url)
	{
		foreach (Config::Read('Router.CustomRoutes') as $pattern => $replacement)
		{
			if (preg_match($pattern, $url)) return preg_replace($pattern, $replacement, $url);
		}
		
		return $url;
	}
}