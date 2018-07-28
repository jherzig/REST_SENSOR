<?php
namespace Api\Entity;

class Sensor extends BaseEntity
{
	//Definition der Eigenschaften
	public $id;
	public $date;
	public $sensor;				// Sensor Name
	public $sensorDescription;		// Beschreibung
	public $value;					// Wert
	public $unit; 					// Einheit

	public function __construct($date, $sensor, $sensorDescription, $value, $unit) {
		$this->date = $ddate;
		$this->sensor = $sensor;
		$this->sensorDescription = $sensorDescription;
		$this->value = $value;
		$this->unit = $unit;
	 }

}