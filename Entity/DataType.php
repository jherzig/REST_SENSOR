<?php
namespace Api\Entity;

use Api\inc\Db_con;

/**
* Diese Klasse repräsentiert ein Daten Typen.
*
* @author   j.herzig
* @version 	1.0
*/

class DataType extends BaseEntity
{
	//Definition der Eigenschaften
	public $dtyKey;					// Key aus DB
	public $dtyName;				// Datum Zeit
	public $dtyUnit;				// Einheit
	
	/**
	 * Erstellt einen Eintrag in der tdaten Tabelle
	 *  
	 * @param DataType
	 *
	 * @return DataType
	 */
	public function create($datatype)
	{
		// DataType Anlegen

		$db = db_con::getInstance(); 
		$neuer_datatype = array();
		$neuer_datatype['dtyName'] 				= $datatype->dtyName;
		$neuer_datatype['dtyUnit']				= $datatype->dtyUnit;
 
		$statement = $db->prepare("INSERT INTO tdatatype (dtyName, dtyName) VALUES (:dtyName, :dtyName)");
		$statement->execute($neuer_datatype);
		$id = $db->lastInsertId();
		
		$datatype = $this->getDataType($id);

		return $datatype;
	}
	
	/**
	 * Gibt anhand der ID DataType Daten zurück
	 *  
	 * @param dtyKey
	 *
	 * @return getDataType
	 */
	 public function getDataType($id)
	{	
		$db = db_con::getInstance(); 

		if(isset($id)) {
			$statement = $db->prepare("SELECT * FROM tdatatype WHERE dtyKey = ?");
			$statement->execute(array($id));   
			
		} else {
			//TODO: Fehlerbehandlung wenn keine ID
			echo("ID wird benötigt");  
		}

		while($row = $statement->fetch()) {
			$this->dtyKey       		= $row['dtyKey'];
			$this->dtyName 				= $row['dtyName'];
			$this->dtyUnit				= $row['dtyUnit'];
		}

		return $this;
	}


	/**
	 * Gibt alle DataType zurück
	 *  
	 * @param 
	 *
	 * @return Array DataType
	 */
	public function getALL()
	{	
		$db = db_con::getInstance(); 
		$arrDataType = array();
		$i = 0;

		$statement = $db->prepare("SELECT * FROM tdatatype");
		$statement->execute();   

			while($row = $statement->fetch()) {
				$datatype = new DataType();

				$datatype->dtyKey       		= $row['dtyKey'];
				$datatype->dtyName 				= $row['dtyName'];
				$datatype->dtyUnit				= $row['dtyUnit'];

				$arrDataType[$i] = $datatype;
				$i++;
			}

		return $arrDataType;
	}

}