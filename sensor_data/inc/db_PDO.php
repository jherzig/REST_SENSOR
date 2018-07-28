<?php
    $pdo = new PDO('mysql:host=localhost;dbname=sensor_data', 'root', '');
    
    $sql = "SELECT * FROM tdaten";
        foreach ($pdo->query($sql) as $row) {
            echo $row['datSensor']." ".$row['datSensorDescription']."<br />";
            echo "Value: ".$row['datValue']."<br /><br />";
        }

?>