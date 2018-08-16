<?php
namespace Api\Controller;

use Api\Library\ApiException;
use Api\Entity\User;
use Api\Entity\Sensor;
use Api\inc\Db_sql;

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
		if (FALSE) {
			//TODO: Debug Modul einbauen
		} else {
			echo "\n<br />";
			echo ("index Seite rest API:  ");
			echo "\n<br />";
			echo date("H:i:s");
			echo "\n<br />";
			echo "Version: v1 ";
			echo "\n<br />";
			echo "Objekt: sensor ";
			echo "\n<br />";
			echo "URL: REST_SENSOR/v1/sensor {?id=4} ";
			echo "\n<br />";
		}
		
		
	}
}