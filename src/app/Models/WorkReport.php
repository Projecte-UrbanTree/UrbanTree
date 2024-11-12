<?php

namespace App\Models;

use App\Core\Database;

class WorkReport
{
	private $work_order_id;
	private $observation;
	private $spent_fuel;
	private $picture;
	private $created_at;
	private $updated_at;

	// Constructor to initialize properties
	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	// Static method to retrieve all work_reports
	public static function getAll()
	{
		$query = "SELECT * FROM work_reports";
		$results = Database::prepareAndExecute($query);
		foreach ($results as $key => $value)
			$results[$key] = new self($value);

		return $results;
	}

	// Static method to find a worker by ID
	public static function findById($id)
	{
		$query = "SELECT * FROM work_reports WHERE id = :id AND deleted_at IS NULL";
		$results = Database::prepareAndExecute($query, ['id' => $id]);

		return $results ? new self($results[0]) : null;
	}

	// Method to save a new worker
	public function create()
	{
		$query = "INSERT INTO work_reports (work_order_id, observation, spent_fuel, picture, created_at) 
							VALUES (:work_order_id, :observation, :spent_fuel, :picture, NOW())";
		$params = [
			'work_order_id' => $this->work_order_id,
			'observation' => $this->observation,
			'spent_fuel' => $this->spent_fuel,
			'picture' => $this->picture
		];

		return Database::prepareAndExecute($query, $params);
	}

	// Method to update an existing worker
	public function update()
	{
		$query = "UPDATE work_reports SET observation = :observation, spent_fuel = :spent_fuel, picture = :picture,
							updated_at = NOW() WHERE work_order_id = :work_order_id AND deleted_at IS NULL";
		$params = [
			'work_order_id' => $this->work_order_id,
			'observation' => $this->observation,
			'spent_fuel' => $this->spent_fuel,
			'picture' => $this->picture,
		];

		return Database::prepareAndExecute($query, $params);
	}

	// Getters and setters (you can add more as needed)
	public function getId()
	{
		return $this->work_order_id;
	}

	public function setId($work_order_id)
	{
		$this->work_order_id = $work_order_id;
	}

	public function getObservation()
	{
		return $this->observation;
	}

	public function setObservation($observation)
	{
		$this->observation = $observation;
	}

	public function getSpentFuel()
	{
		return $this->spent_fuel;
	}

	public function setSpentFuel($spent_fuel)
	{
		$this->spent_fuel = $spent_fuel;
	}

	public function getPicture()
	{
		return $this->picture;
	}

	public function setPicture($picture)
	{
		$this->picture = $picture;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}
}
