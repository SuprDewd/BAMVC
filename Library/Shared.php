<?php

function configureReporting()
{
	error_reporting(E_ALL);
	
	if (Config::Read('ProductionEnvironment'))
	{
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', Root . DS . 'Temp' . DS . 'Logs' . DS . 'Error.log');
	}
	else ini_set('display_errors','On');
}

function stripSlashesDeep($value)
{
	return is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
}

function removeMagicQuotes()
{
	if (!get_magic_quotes_gpc()) return;
	
	$_GET = stripSlashesDeep($_GET);
	$_POST = stripSlashesDeep($_POST);
	$_COOKIE = stripSlashesDeep($_COOKIE);
}

function unregisterGlobals()
{
    if (!ini_get('register_globals')) return;
    
    $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
    foreach ($array as $value)
   	foreach ($GLOBALS[$value] as $key => $var)
    if ($var === $GLOBALS[$key]) unset($GLOBALS[$key]);
}

function __autoload($className)
{
	if (file_exists($path = Root . DS . 'Library' . DS . $className . '.php')) require_once $path;
	else if (file_exists($path = Root . DS . 'Controllers' . DS . $className . '.php')) require_once $path;
	else if (file_exists($path = Root . DS . 'Models' . DS . $className . '.php')) require_once $path;
	else return false; // TODO: Handle Error!
	
	return true;
}

configureReporting();
removeMagicQuotes();
unregisterGlobals();