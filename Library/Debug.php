<?php

class Debug
{
	public static $Log = '';
	
	public static function Dump($file)
	{
		if (is_string(Config::Read('Error.Log')) && self::$Log !== '')
		{
			file_put_contents($file, self::$Log, FILE_APPEND);
		}
	}
	
	public static function Log($message)
	{
		self::$Log .= Date('Y/m/d H:i:s') . ' ' . $message . NL;
	}
	
	public static function LogIf($bool, $message)
	{
		if ($bool) self::Log($message);
	}
	
	public static function LogNotice($message)
	{
		self::Log('Notice: ' . $message);
	}
	
	public static function LogNoticeIf($bool, $message)
	{
		if ($bool) self::LogNotice($message);
	}
	
	public static function LogWarning($message)
	{
		self::Log('Warning: ' . $message);
	}
	
	public static function LogWarningIf($bool, $message)
	{
		if ($bool) self::LogWarning($message);
	}
	
	public static function LogError($message)
	{
		self::Log('Error: ' . $message);
	}
	
	public static function LogErrorIf($bool, $message)
	{
		if ($bool) self::LogError($message);
	}
}