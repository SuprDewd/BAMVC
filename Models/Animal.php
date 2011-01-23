<?php

class AnimalModel extends Model
{
	public function FindAll()
	{
		return $this->Query('SELECT * FROM Animals');
	}
	
	public function FindByID($id)
	{
		$stmt = $this->Open()->prepare('SELECT * FROM Animals WHERE ID = ?');
		$stmt->bind_param('d', $id);
		return $this->QueryPrepared($stmt, true, true);
	}
}