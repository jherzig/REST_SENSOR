<?php
namespace Api\Controller;

use Api\Library\ApiException;
use Api\Entity\User;
use Api\Entity\Sensor;

/**
 * Class UserController
 * Endpunkt für die Sensor-Funktionen.
 *
 *  @author   	j.herzig
 * @version 	1.0
 * @package 	Api\Controller
 */

class SensorController extends ApiController
{
	public function indexAction()
	{
		try {
			//TODO: Authentifizierung hinzufügen  Checks auslösen
			//$this->initialize();

			$input = json_decode(file_get_contents('php://input'), true);

			// Wir wählen die Operation anhand der Request Methode
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				if (empty($_GET['id'])) {
					$result = $this->getALL();
				}
				else{
					$result = $this->getID((int)$_GET['id']);
				} 
			} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$result = $this->create($input);
			} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
				//TODO: implementieren
				$result = $this->update($input);
			} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE'){ 
				//TODO: implementieren
				$result = $this->delete((int)$_GET['id']);
			} else {
				throw new ApiException('', ApiException::UNKNOWN_METHOD);
			}

			header('HTTP/1.0 200 OK');
		} catch (ApiException $e) {
			if ($e->getCode() == ApiException::AUTHENTICATION_FAILED)
				header('HTTP/1.0 401 Unauthorized');
			elseif ($e->getCode() == ApiException::MALFORMED_INPUT) {
				header('HTTP/1.0 400 Bad Request');
			}

			$result = ['message' => $e->getMessage()];
		}

		header('Content-Type: application/json');

		// Überprüfen ob es nur ein Senor ist oder ein Array
		if ($this->getLevel($result) > 1) {
			foreach ($result as $obj) {
				$result_json = json_encode($obj);
				echo $result_json;
			}
		} else {
			$result_json = json_encode($result);
			echo $result_json;
		}
	}


	/**
	 * Gibt das level eines Array zurück
	 * @param array
	 *
	 * @return int
	 */
	private function getLevel($arr, $level = 0)
	{
		$return = $level;
		if (is_array($arr)|| is_object($arr))
		{
			foreach ($arr as $key => $value)
			{
				$level_new = $this->getLevel($value, $level + 1);
				if($level_new > $return)
					return $level_new;
			}
		}

		return $return;
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function getID($id)
	{	
		$sensor = new Sensor();

		$sensor->getID($id);		

		return $sensor->toArray();
	}

		/**
	 *
	 *
	 * @return array
	 */
	private function getALL()
	{	
		$sensor = new Sensor();

		$arrSensoren = $sensor->getALL();

		return $arrSensoren;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	private function create(array $data)
	{
		// Sensor Anlegen
		$sensor 		= new Sensor();
		$sensor->id					= (int)$data['id'];
		$sensor->sensor	  			= $data['sensor'];
		$sensor->sensorDescription 	= $data['sensorDescription'];
		$sensor->value				= $data['value'];
		$sensor->unit 				= $data['unit'];

		$sensor->create($sensor); 

		return $sensor->toArray();
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 * @throws ApiException
	 */
	private function update(array $data)
	{
		//TODO: implementieren
		if (!isset($data['id'])) {
			throw new ApiException('Missing ID', ApiException::MALFORMED_INPUT);
		}

		// Sensor aus der Datenbank laden
		// ...

		$user = $this->createExampleUser();

		// Sensor aktualisieren
		$user->username = $data['username'];

		// Sensor wieder in der DB speichern
		// ...

		return ['id' => $user->id];
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function delete($id)
	{
		//TODO: implementieren
		// Sensor in der Datenbank löschen
		// ...

		return [];
	}
}