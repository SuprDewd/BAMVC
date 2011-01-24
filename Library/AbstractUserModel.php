<?php

abstract class AbstractUserModel extends Model
{
	public function __construct($tableName = null)
	{
		parent::__construct($tableName);
	}
	
	public abstract function GetUserByName($username);
}