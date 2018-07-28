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
class IndexController extends ApiController
{
	public function indexAction()
	{
		echo "\n<br />";
		echo ("index Seite rest API:  ");
		echo "\n<br />";
		echo date("H:i:s");
		echo "\n<br />";
		echo "\n<br />";

		require 'inc/db.php';
		echo "<h1>Programm Adressbuch</h1>";
		$erg = $db->query("SELECT * FROM tdaten");
		print_r($erg);
		if ($erg->num_rows) {
			echo "<p>Daten vorhanden: Anzahl ";
			echo $erg->num_rows;
		}
		//$datensatz = $erg->fetch_assoc();  // nur der erste Satz
		$datensatz = $erg->fetch_all(MYSQLI_ASSOC);
		echo "<pre>";
		print_r($datensatz);
		echo "</pre>";

		require 'inc/db_PDO.php';
		$sql = "SELECT * FROM tdaten";
        foreach ($pdo->query($sql) as $row) {
            echo $row['datSensor']." ".$row['datSensorDescription']."<br />";
            echo "Value: ".$row['datValue']."<br /><br />";
        }
	
	}
}