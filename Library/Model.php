<?php

abstract class Model
{
	public $Connection = null;
	public $TableName = null;
	
	public function __construct($tableName = null)
	{
		$this->TableName = $tableName;
	}
	
	public function Open()
	{
		if ($this->Connection === null)
		{
			$db = Config::Read('Database');
			$instance = new mysqli($db['Host'], $db['Username'], $db['Password'], $db['Schema']);
			if (!$instance) return false;
			$this->Connection = $instance;
		}
		
		return $this->Connection;
	}
	
	public function Close()
	{
		if ($this->Connection !== null)
		{
			$this->Connection->close();
			$this->Connection = null;
		}
	}
	
	protected function Query($sql, $singleRow = false)
	{
		$result = $this->Open()->query($sql);
	
		if (strtoupper(substr($sql, 0, 6)) === 'SELECT')
		{
			$table = array();
			
			while ($row = $result->fetch_assoc())
			{
				$table[] = $row;
				
				if ($singleRow) break;
			}
			
			$result->free();
			
			return !$singleRow ? $table : (count($table) != 0 ? $table[0] : false);
		}
		else return $this->Connection->affected_rows;
	}
	
	protected function QueryPrepared(&$stmt, $isSelect = false, $singleRow = false)
	{
		$stmt->execute();
			
		if ($isSelect)
		{
			$table = array();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			while ($stmt->fetch())
			{
				$table[] = $row;
				
				if ($singleRow) break;
			}
			
			$stmt->free_result();
			
			
			return !$singleRow ? $table : (count($table) != 0 ? $table[0] : false);
		}
		else return $this->Connection->affected_rows;
	}
	
	public function FindAll()
	{
		if ($this->TableName === null) { Debug::LogError('Default FindAll called, but Model->TableName not set.'); return; }
		return $this->Query('SELECT * FROM ' . $this->TableName);
	}
	
	public function FindByID($id, $idColumn = 'ID')
	{
		if ($this->TableName === null) { Debug::LogError('Default FindByID called, but Model->TableName not set.'); return; }
		$stmt = $this->Open()->prepare('SELECT * FROM ' . $this->TableName . ' WHERE ' . $idColumn . ' = ?');
		$stmt->bind_param('d', $id);
		return $this->QueryPrepared($stmt, true, true);
	}
	
	private function stmt_bind_assoc(&$stmt, &$out)
	{
	    $data = mysqli_stmt_result_metadata($stmt);
	    $fields = array();
	    $out = array();
		
	    $count = 1;
	
	    while ($field = mysqli_fetch_field($data))
	    {
	        $fields[$count] = &$out[$field->name];
	        $count++;
	    }
		
	    call_user_func_array(array($stmt, 'bind_result'), $fields);
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
}