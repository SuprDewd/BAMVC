<?php

abstract class MyModel extends Model
{
	public function __construct($tableName = null)
	{
		parent::__construct($tableName);
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
}