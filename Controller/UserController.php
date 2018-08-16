<?php
namespace Api\Controller;

use Api\Library\ApiException;
use Api\Entity\User;
use Api\Entity\Sensor;

/**
 * Class UserController
 * Endpunkt für die User-Funktionen.
 *
 * @package Api\Controller
 */
class UserController extends ApiController
{
	public function indexAction()
	{
		try {
			// Checks auslösen
			//$this->initialize();

			$input = json_decode(file_get_contents('php://input'), true);
			//print_r($input);
			

			// Wir wählen die Operation anhand der Request Methode
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$result = $this->get((int)$_GET['id']);
			} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
				//print_r($input);
				$result = $this->create($input);
			} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
				$result = $this->update($input);
			} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
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
		echo json_encode($result);
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function get($id)
	{
		// Benutzer aus der Datenbank laden.
		// ...

		// Für das Beispiel einfach ein neuer User
		$sensor = $this->createExampleSensor();

		// Benutzerdaten als Array zurück geben.
		print_r('/ class UserController extends ApiController / ');
		return $sensor->toArray();
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	private function create(array $data)
	{
		// Benutzer anlegen ...
		$user           = new User();
		$user->username = $data['username'];

		// ... und in der Datenbank speichern

		
		// Für das Beispiel:
		$user->id = rand(100, 999);

		return ['id' => $user->id];
		//return $user->toArray();
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 * @throws ApiException
	 */
	private function update(array $data)
	{
		if (!isset($data['id'])) {
			throw new ApiException('Missing ID', ApiException::MALFORMED_INPUT);
		}

		// Benutzer aus der Datenbank laden
		// ...

		$user = $this->createExampleUser();

		// Benutzer aktualisieren
		$user->username = $data['username'];

		// Benutzer wieder in der DB speichern
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
		// Benutzer in der Datenbank löschen
		// ...

		return [];
	}

	/**
	 * @return User
	 */
	private function createExampleUser()
	{
		$user           = new User();
		$user->id       = 5;
		$user->username = 'stefan';

		return $user;
	}

	/**
	 * @return Sensor
	 */
	private function createExampleSensor()
	{
		$sensor           			= new Sensor();
		$sensor->id       			= 1;
		$sensor->sensor	  			= "Test";
		$sensor->sensorDescription 	= "Hallo Jörg Beschreibung Sensor";
		$sensor->value				= "22.5";
		$sensor->unit 				= "C";

		return $sensor;
	}
}