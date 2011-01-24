<?php

class UserModel extends AbstractUserModel
{
	public function __construct()
	{
		parent::__construct('Users');
	}
	
	public function GetUserByName($username)
	{
		$stmt = $this->Open()->prepare('SELECT * FROM Users WHERE Username = ?');
		$stmt->bind_param('s', $username);
		return $this->QueryPrepared($stmt, true, true);
	}
	
	public function Create($username, $password, $role = 'User')
	{
		$stmt = $this->Open()->prepare('INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)');
		$stmt->bind_param('sss', $username, $password, $role);
		return $this->QueryPrepared($stmt) === 1;
	}
}