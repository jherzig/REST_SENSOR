<?php
namespace Api\Entity;

use Api\inc\Db_sql;

/**
* Diese Klasse repräsentiert ein Sensor.
*
* @author   j.herzig
* @version 	1.0
*/

class Sensor extends BaseEntity
{
	//Definition der Eigenschaften
	public $id;
	public $date;
	public $sensor;					// Sensor Name
	public $sensorDescription;		// Beschreibung
	public $value;					// Wert
	public $unit; 					// Einheit

	/**
	 * Erstellt einen Eintrag in der tdaten Tabelle
	 *  
	 * @param Sensor
	 *
	 * @return Sensor
	 */
	public function create($sensor)
	{
		// Sensor Anlegen

		$db = db_sql::getInstance(); 
		$neuer_sensor = array();
		$neuer_sensor['id'] 					= $sensor->id;
		$neuer_sensor['datSensor'] 				= $sensor->sensor;
		$neuer_sensor['datSensorDescription']	= $sensor->sensorDescription;
		$neuer_sensor['datValue'] 				= $sensor->value;
 
		$statement = $db->prepare("INSERT INTO tdaten (id, datSensor, datSensorDescription, datValue) VALUES (:id, :datSensor, :datSensorDescription, :datValue)");
		$statement->execute($neuer_sensor);  	

		return $sensor;
	}
	
	/**
	 * Gibt anhand der ID Sensor Daten zurück
	 *  
	 * @param ID
	 *
	 * @return Sensor
	 */
	 public function getID($id)
	{	
		$db = db_sql::getInstance(); 

		if(isset($id)) {
			$statement = $db->prepare("SELECT * FROM tdaten WHERE id = ?");
			$statement->execute(array($id));   
			// nur zum testen
			while($row = $statement->fetch()) {
				$this->id       			= $id;
				$this->sensor	  			= $row['datSensor'];
				$this->sensorDescription 	= $row['datSensorDescription'];
				$this->value				= $row['datValue'];
				$this->unit 				= "C";
			}
		} else {
			// TODO: Andere Fehlerausgabe um darauf zu reagieren
			print_r('Bitte eine ?id übergeben');
		}

		return $this;
	}

	/**
	 * Gibt alle Sensor Daten zurück
	 *  
	 * @param 
	 *
	 * @return Array Sensor
	 */
	public function getALL()
	{	
		$db = db_sql::getInstance(); 
		$arrSensor = array();
		$i = 0;

		$statement = $db->prepare("SELECT * FROM tdaten");
		$statement->execute();   

			while($row = $statement->fetch()) {
				$sensor = new Sensor();

				$sensor->id       			= $row['id'];
				$sensor->sensor	  			= $row['datSensor'];
				$sensor->sensorDescription 	= $row['datSensorDescription'];
				$sensor->value				= $row['datValue'];
				$sensor->unit 				= "C";

				$arrSensor[$i] = $sensor;
				$i++;
			}

		return $arrSensor;
	}

}