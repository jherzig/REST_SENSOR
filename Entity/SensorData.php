<?php
namespace Api\Entity;

use Api\inc\Db_con;

/**
* Diese Klasse repräsentiert ein Sensor.
*
* @author   j.herzig
* @version 	1.0
*/

class SensorData extends BaseEntity
{
	//Definition der Eigenschaften
	public $sdaKey;					// Key aus DB
	public $sdaDt;					// Datum Zeit
	public $sdaSenId;				// Sensor ID	Sensor()
	public $sdaValue;				// Wert
	public $sdaDtyId;				// Einheit ID	

	/**
	 * Erstellt einen Eintrag in der tdaten Tabelle
	 *  
	 * @param SensorDaten
	 *
	 * @return 
	 */
	public function create($sensorData)
	{
		$sensor = new Sensor();
		$sensor->getSensor($sensorData->sdaSenId); 

		if (isset($sensor->senKey)) {
			//
		} else {
			$sensor->senStaId	  			= "Neuer Sensor Unbekannt";
			$sensor->senName 				= "Neuer Sensor ID noch nicht vorhanden";
			$sensor->senDescription			= "Neuer Sensor";

			$sensor->create($sensor);
		}

		$this->sdaSenId = $sensor->senKey;

		$datatype = new DataType();
		$datatype->getDataType($sensorData->sdaDtyId); 

		if (isset($datatype->dtyKey)) {
			//
		} else {
			$datatype->dtyName				= "Neue Einheit";
			$datatype->dtyUnit				= "Neue Einheit noch nicht definiert";

			$datatype->create($datatype);
		}

		$this->sdaDtyId = $datatype->dtyKey;

		// Sensor Anlegen
		$db = db_con::getInstance(); 
		$neuer_sensorData = array();
		$neuer_sensorData['sdaDt'] 					= $sensorData->sdaDt;
		$neuer_sensorData['sdaSenId'] 				= $sensorData->sdaSenId;
		$neuer_sensorData['sdaValue']				= $sensorData->sdaValue;
		$neuer_sensorData['sdaDtyId'] 				= $sensorData->sdaDtyId;
 
		$statement = $db->prepare("INSERT INTO tsensordata (sdaDt, sdaSenId, sdaValue, sdaDtyId) VALUES (:sdaDt, :sdaSenId, :sdaValue, :sdaDtyId)");
		$statement->execute($neuer_sensorData);
		$id = $db->lastInsertId();
		
		$sensorData = $this->getSensorData($id);

		return $sensorData;

	}

		/**
	 * Gibt anhand der ID die Sensor Daten aus der DB zurück
	 *  
	 * @param sdaKey
	 *
	 * @return SensorData
	 */
	public function getSensorData($id)
	{	
		$db = db_con::getInstance(); 

		if(isset($id)) {
			$statement = $db->prepare("SELECT * FROM tsensordata WHERE sdaKey = ?");
			$statement->execute(array($id));   
			
		} else {
			//TODO: Fehlerbehandlung wenn keine ID
			echo("ID wird benötigt");  
		}

		while($row = $statement->fetch()) {
			$this->sdaKey       		= $row['sdaKey'];
			$this->sdaDt 				= $row['sdaDt'];
			$this->sdaSenId				= $row['sdaSenId'];
			$this->sdaValue				= $row['sdaValue'];
			$this->sdaDtyId				= $row['sdaDtyId'];
		}

		return $this;
	}
	
	public function getALL()
	{	
		$db = db_con::getInstance(); 
		$arrSensorDaten = array();
		$i = 0;

		$statement = $db->prepare("SELECT * FROM tsensordata");
		$statement->execute();   

			while($row = $statement->fetch()) {
				$sensordaten = new SensorData();

				$sensordaten->sdaKey       		= $row['sdaKey'];
				$sensordaten->sdaDt 				= $row['sdaDt'];
				$sensordaten->sdaSenId				= $row['sdaSenId'];
				$sensordaten->sdaValue				= $row['sdaValue'];
				$sensordaten->sdaDtyId				= $row['sdaDtyId'];

				$arrSensorDaten[$i] = $sensordaten;
				$i++;
			}

		return $arrSensorDaten;
	}
	

}