<?php
    error_reporting(0);
    $db = new mysqli('localhost', 'root', '', 'sensor_data');
    print_r ($db->connect_error);

    if ($db->connect_errno) {
        echo "\n<br />";
        die('Sorry - gerade gibt es ein Problem');
    }
?>

