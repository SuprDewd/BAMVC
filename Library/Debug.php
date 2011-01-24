<?php

class Debug
{
	public $Log = '';
	
	public static function Dump($file)
	{
		if (Config::Read('ProductionEnvironment') && $this->Log !== '')
		{
			file_put_contents($file, $this->Log, FILE_APPEND);
		}
	}
	
	public static function Log($message)
	{
		if (Config::Read('ProductionEnvironment')) $Log .= Date('YY/MM/DD H:i:s') . ' ' . $message . NL;
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