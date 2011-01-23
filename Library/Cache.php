<?php

class Cache
{
	public static function Set($key, $object, $expires = false)
	{
		file_put_contents(Cache . $key . '.cache', serialize(array('Expires' => $expires, 'Object' => $object)));
	}
	
	public static function Get($key)
	{
		if (!file_exists(Cache . $key)) return false;
		$data = unserialize(file_get_contents(Cache . $key . '.cache'));
		
		if ($data['Expires'] === false || $data['Expires'] < time()) { self::Delete($key); return false; }
		else return $data['Object'];
	}
	
	public static function Delete($key)
	{
		unlink(Cache . $key . '.cache');
	}
}