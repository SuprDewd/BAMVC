<?php

require_once Library . 'Config.php';
require_once Library . 'Cache.php';

if (($config = Cache::Get('Config')) === false)
{
	require_once DefaultConfig  . 'Main.php';

	require_once Config  . 'Main.php';
	require_once Config  . 'Database.php';
	require_once Config  . 'Routing.php';
	
	Cache::Set('Config', Config::Read(), strtotime('+1 week'));
}
else Config::Write('', $config);

require_once Library . 'Debug.php';
require_once Library . 'Shared.php';
require_once Library . 'Router.php';
require_once Library . 'Model.php';
require_once Library . 'View.php';
require_once Library . 'Controller.php';


class Bootstrap
{
	public static function LoadController($controller)
	{
		return self::Load($controller, Controllers, DefaultControllers);
	}
	
	public static function LoadModel($model)
	{
		return self::Load($model, Models);
	}
	
	public static function LoadComponent($component)
	{
		return self::Load($component, Components, DefaultComponents);
	}
	
	public static function LoadHelper($helper)
	{
		return self::Load($helper, Helpers, DefaultHelpers);
	}
	
	public static function GetViewPath($view)
	{
		return self::GetPath($view, Views, DefaultViews);
	}
	
	public static function GetElementPath($element)
	{
		return self::GetPath($element, Elements, DefaultElements);
	}
	
	public static function GetSharedViewPath($view)
	{
		return self::GetPath($view, SharedViews, DefaultSharedViews);
	}
	
	public static function GetPath($item, $userPath, $defaultPath = null)
	{
		if (file_exists($path = $userPath . $item . '.php')) return $path;
		if ($defaultPath !== null && file_exists($path = $defaultPath . $item . '.php')) return $path;
		
		return null;
	}
	
	public static function Load($item, $userPath, $defaultPath = null)
	{
		$path = self::GetPath($item, $userPath, $defaultPath);
		if ($path === null) return false;
		require_once $path;
		
		return true;
	}
}