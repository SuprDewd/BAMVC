<?php

class Config
{
	private static $Config = array();
	private function Config() {}
	
	public static function Write($path, $value = null)
	{
		if ($path === '') self::$Config = $value;
		
		$split = explode('.', $path);
		$last = &self::$Config;
		$count = count($split) - 1;
		$key = $split[$count];
		
		for ($i = 0; $i < $count; $i++)
		{
			if (!array_key_exists($split[$i], $last)) $last[$split[$i]] = array();
			$last = &$last[$split[$i]];
		}
		
		$last[$key] = $value;
		return $value;
	}
	
	public static function Read($path = '')
	{
		if ($path === '') return self::$Config;
		
		$split = explode('.', $path);
		$last = self::$Config;
		$count = count($split);
		
		for ($i = 0; $i < $count; $i++)
		{
			if ($i + 1 == $count) return $last[$split[$i]];
			$last = $last[$split[$i]];
		}
	}
	
	public static function Clear()
	{
		self::$Config = array();
	}
}