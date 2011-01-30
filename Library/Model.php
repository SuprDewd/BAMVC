<?php

abstract class Model
{
	public $Connection = null;
	public $TableName = null;
	
	public function __construct($tableName = null)
	{
		$this->TableName = $tableName;
	}
	
	public abstract function Open();
	public abstract function Close();
	protected abstract function Query($sql, $singleRow = false);
	
	public function FindAll()
	{
		if ($this->TableName === null) Debug::LogError('Default FindAll called, but Model->TableName not set.');
		else return $this->Query('SELECT * FROM ' . $this->TableName);
	}
	
	public function FindByID($id, $idColumn = 'ID')
	{
		if ($this->TableName === null) { Debug::LogError('Default FindByID called, but Model->TableName not set.'); return; }
		$stmt = $this->Open()->prepare('SELECT * FROM ' . $this->TableName . ' WHERE ' . $idColumn . ' = ?');
		$stmt->bind_param('d', $id);
		return $this->QueryPrepared($stmt, true, true);
	}
	
	protected function MatchesRegex($input, $regex)
	{
		return preg_match($regex, $input);
	}
	
	protected function LengthBetween($input, $min, $max)
	{
		$length = strlen($input);
		return $length >= $min && $length <= $max;
	}
	
	protected function LengthIs($input, $length)
	{
		return strlen($input) === $length;
	}
	
	protected function LengthIsAtLeast($input, $least)
	{
		return strlen($input) >= $least;
	}
	
	protected function LengthIsNotMoreThan($input, $max)
	{
		return strlen($input) <= $max;
	}
	
	protected function IsNumber($input)
	{
		return is_numeric($input);
	}
	
	protected function IsEmail($input)
	{
		return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
	}
}