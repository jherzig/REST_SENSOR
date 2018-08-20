<?php
namespace Api\Entity;

use Api\inc\Db_con;

/**
* Diese Klasse repräsentiert ein Sensor.
*
* @author   j.herzig
* @version 	1.0
*/

class Sensor extends BaseEntity
{
	//Definition der Eigenschaften
	public $senKey;					// DB Key
	public $senStaId;				// Stations ID
	public $senName;				// Sensor Name
	public $senDescription;			// Beschreibung		

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

		$db = db_con::getInstance(); 
		$neuer_sensor = array();
		$neuer_sensor['senStaId'] 				= $sensor->senStaId;
		$neuer_sensor['senName']				= $sensor->senName;
		$neuer_sensor['senDescription'] 		= $sensor->senDescription;
 
		$statement = $db->prepare("INSERT INTO tsensor (senStaId, senName, senDescription) VALUES (:senStaId, :senName, :senDescription)");
		$statement->execute($neuer_sensor);
		$id = $db->lastInsertId();
		
		$sensor = $this->getSensor($id);

		return $sensor;
	}
	
	/**
	 * Gibt anhand der ID Sensor Daten zurück
	 *  
	 * @param senKey
	 *
	 * @return Sensor
	 */
	 public function getSensor($id)
	{	
		$db = db_con::getInstance(); 

		if(isset($id)) {
			$statement = $db->prepare("SELECT * FROM tsensor WHERE senKey = ?");
			$statement->execute(array($id));   
			
		} else {
			//TODO: Fehlerbehandlung wenn keine ID
			echo("ID wird benötigt");  
		}

		while($row = $statement->fetch()) {
			$this->senKey       		= $row['senKey'];
			$this->senStaId	  			= $row['senStaId'];
			$this->senName 				= $row['senName'];
			$this->senDescription		= $row['senDescription'];
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
		$db = db_con::getInstance(); 
		$arrSensor = array();
		$i = 0;

		$statement = $db->prepare("SELECT * FROM tsensor");
		$statement->execute();   

			while($row = $statement->fetch()) {
				$sensor = new Sensor();

				$sensor->senKey       		= $row['senKey'];
				$sensor->senStaId	  			= $row['senStaId'];
				$sensor->senName 				= $row['senName'];
				$sensor->senDescription		= $row['senDescription'];

				$arrSensor[$i] = $sensor;
				$i++;
			}

		return $arrSensor;
	}

}