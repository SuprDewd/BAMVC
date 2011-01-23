<?php

function ConfigureReporting()
{
	error_reporting(E_ALL);
	
	if (Config::Read('ProductionEnvironment'))
	{
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', Logs . 'Error.log');
	}
	else ini_set('display_errors','On');
}

function StripSlashesDeep($value)
{
	return is_array($value) ? array_map(StripSlashesDeep, $value) : stripslashes($value);
}

function RemoveMagicQuotes()
{
	if (!get_magic_quotes_gpc()) return;
	
	$_GET    = StripSlashesDeep($_GET);
	$_POST   = StripSlashesDeep($_POST);
	$_COOKIE = StripSlashesDeep($_COOKIE);
}

function UnregisterGlobals()
{
    if (!ini_get('register_globals')) return;
    
    $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
    foreach ($array as $value)
   	foreach ($GLOBALS[$value] as $key => $var)
    if ($var === $GLOBALS[$key]) unset($GLOBALS[$key]);
}

function __autoload($className)
{
	     if (file_exists($path = Controllers        . $className . '.php')) require_once $path;
	else if (file_exists($path = Models             . $className . '.php')) require_once $path;
	else if (file_exists($path = DefaultControllers . $className . '.php')) require_once $path;
	else if (file_exists($path = Components         . $className . '.php')) require_once $path;
	else if (file_exists($path = DefaultComponents  . $className . '.php')) require_once $path;
	else if (file_exists($path = Library            . $className . '.php')) require_once $path;
	else return false;
	
	return true;
}

ConfigureReporting();
RemoveMagicQuotes();
UnregisterGlobals();