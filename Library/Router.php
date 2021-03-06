<?php

class Router
{
	public static function Initialize($url = Request, $isFallback = false, $depth = 0)
	{
		if (($maxDepth = Config::Read('Router.MaxDepth')) !== 0 && $depth > $maxDepth) { self::Error($isFallback); return; }
		$urlArray = explode(WDS, self::ApplyCustomRoutes(rtrim($url, WDS)));
		
		$controllerFile = (count($urlArray) > 0 && $urlArray[0] !== '' ? $urlArray[0] : Config::Read('Router.Default.Controller'));
		$controller = $controllerFile . 'Controller';
		array_shift($urlArray);
		$action = count($urlArray) > 0 ? $urlArray[0] : Config::Read('Router.Default.Action');
		array_shift($urlArray);
		
		if (!Bootstrap::LoadController($controllerFile)) { self::Error($isFallback); return; }
		
		$forbiddenActions = array('BeforeAction', 'AfterAction', 'LoadComponent', 'LoadComponents', 'LoadModel', 'LoadModels', 'SendContentType', 'SendLocation', 'SendHeader');
		if (!($action[0] !== '_' && !in_array($action, $forbiddenActions) && method_exists($controller, $action))) { self::Error($isFallback); return; }

		$dispatchAction = new ReflectionMethod($controller, $action);
		if (!$dispatchAction->isPublic() || $dispatchAction->isStatic() || count($urlArray) < $dispatchAction->getNumberOfRequiredParameters()) { self::Error($isFallback); return; }

		$dispatch = new $controller($action, $urlArray);
		$dispatch->ControllerName = $controllerFile;
		if (method_exists($controller, 'BeforeAction')) call_user_func_array(array($dispatch, 'BeforeAction'), $urlArray);
		$ok = $dispatchAction->invokeArgs($dispatch, $urlArray);
		if (method_exists($controller, 'AfterAction')) call_user_func_array(array($dispatch, 'AfterAction'), $urlArray);
		
		if (isset($ok))
		{
			if ($ok === false) self::Error($isFallback);
			else if (is_string($ok)) self::Initialize($ok, false, $depth + 1);
		}
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
			if (preg_match($pattern, $url))
			{
				return preg_replace($pattern, $replacement, $url);
			}
		}
		
		return $url;
	}
}