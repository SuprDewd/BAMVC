<?php

class UserModel extends Model implements IUserModel
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
	
	public function CountUsersWithName($username)
	{
		$stmt = $this->Open()->prepare('SELECT COUNT(*) AS C FROM Users WHERE Username = ?');
		$stmt->bind_param('s', $username);
		$row = $this->QueryPrepared($stmt, true, true);
		return $row['C'];
	}
	
	public function Create($username, $password, $role = 'User')
	{
		$stmt = $this->Open()->prepare('INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)');
		$stmt->bind_param('sss', $username, $password, $role);
		return $this->QueryPrepared($stmt) === 1;
	}
	
	public function IsValid($username, $password, $passwordAgain, $role = 'User')
	{
		$errors = array();

		if (!isset($username)) $errors[] = 'Please specify a username';
		if (!isset($password)) $errors[] = 'Please specify a password';
		if (!isset($password)) $errors[] = 'Please specify a password again';
		if (count($errors) > 0) return $errors;

		if (!$this->LengthBetween($username, 3, 12)) $errors[] = 'Username must contain 3 to 12 letters';
		if (!$this->MatchesRegex($username, '/^[a-zA-Z0-9\-_\. ]+$/')) $errors[] = 'Username must only contain letters, digits, hyphens, underscores and dots';
		if (count($errors) === 0 && $this->CountUsersWithName($username)) $errors[] = 'Username is already taken';
		if (!$this->LengthIsAtLeast($password, 5)) $errors[] = 'Password needs to be at least 5 characters';
		if (!$this->LengthIsNotMoreThan($password, 20)) $errors[] = 'Password can not be longer than 20 characters';
		if ($password !== $passwordAgain) $errors[] = 'Passwords do not match';
		if (!in_array($role, Config::Read('Auth.Roles'))) $errors[] = 'Not a valid role';
		

		return count($errors) === 0 ? true : $errors;
	}
}