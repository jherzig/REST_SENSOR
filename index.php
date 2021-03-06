<?php
// simple autoloader
spl_autoload_register(function ($className) {
	if (substr($className, 0, 4) !== 'Api\\') {
		// not our business
		return;
	}

	$fileName = __DIR__.'/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 4)).'.php';

	if (file_exists($fileName)) {
		include $fileName;
	}
	else{
		return;
	}
});

/**
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X GET "http://localhost/api/v1/user?id=5"
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X POST "http://localhost/api/v1/user" -d "{\"username\":\"Patrick\"}"
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X PUT "http://localhost/api/v1/user" -d "{\"id\":\"5\",\"username\":\"Patrick\"}"
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X GET "https://api.jherzig.ch/test_rest/v1/user?id=5"
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X POST "https://api.jherzig.ch/test_rest/v1/user" -d "{\"username\":\"Patrick\"}"
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X PUT "https://api.jherzig.ch/test_rest/v1/user" -d "{\"id\":\"5\",\"username\":\"Patrick\"}"
 * 
 * 
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X POST "http://localhost/REST_SENSOR/v1/sensor" -d "{\"id\":\"190\",\"date\":null,\"sensor\":\"Test Name 16.08.2018\",\"sensorDescription\":\"POST Beschreibung Sensor TEST\",\"value\":\"32\",\"unit\":\"C\"}"
 * 
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X POST "http://localhost/REST_SENSOR/v1/sensordata" -d "{\"sdaDt\":\"2018-08-20 11:45:50:00\",\"sdaSenId\":22,\"sdaValue\":\"29\",\"sdaDtyId\":\"1\"}
 * 
 * curl -g -H "Authorization: Token token=\"super_geheimes_token\"" -X POST "https://api.jherzig.ch/test_rest/v1/sensordata" -d "{\"sdaDt\":\"2018-08-22 15:03:50:00\",\"sdaSenId\":2,\"sdaValue\":\"29\",\"sdaDtyId\":\"1\"}
 */


// get the requested url
$url      = (isset($_GET['_url']) ? $_GET['_url'] : '');
$urlParts = explode('/', $url);

// shift the version away
array_shift($urlParts);

// build the controller class
$controllerName      = (isset($urlParts[0]) && $urlParts[0] ? $urlParts[0] : 'index');
$controllerClassName = '\\Api\\Controller\\'.ucfirst($controllerName).'Controller';


// build the action method
$actionName       = (isset($urlParts[1]) && $urlParts[1] ? $urlParts[1] : 'index');
$actionMethodName = $actionName.'Action';

$controller = new $controllerClassName();
$controller->$actionMethodName();
?> 