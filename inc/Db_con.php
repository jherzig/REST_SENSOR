<?php 
namespace Api\inc;

use \PDO;

class Db_con
   { 
      //per Komma mehrere Variablen definieren 
      private $host = 'localhost',      //Host 
              $user = 'root',           //Username 
              $pw   = '',               //DBpasswort 
              $name = 'jhesensor';      //Datenbankname 

      //Unser PDO-Objekt 
      static public $db_obj = null; 
      static private $objekt; 

      //Der Konstruktor 
      private function __construct () 
         { 
             //MySQL verbindungsdaten 
             $con = 'mysql:dbname=' . $this->name . ';host=' . $this->host; 

                try 
             { 
                self::$db_obj = new PDO ($con, $this->user, $this->pw, array 
                                            ( 
                                               PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING 
                                            ) 
                                        ); 
             } 
             catch(PDOException $e) 
             { 
                printf('Fehler beim &Ouml;ffnen der Datenbank.<br><br>%s', 
                $e->getMessage); exit(); 
             } 
         } 

      //Hiermit holen wir uns die PDO Instanz und 
      //verhindern eine doppelte Verbindung 
      public static function getInstance () 
         { 
            //Wenn das Objekt noch keine PDO-Instanz hat 
            if(self::$db_obj === null) 
               //Dann eine erzeugen 
               self::$objekt = new db_con; 

            //Und das PDO-Objekt zurückgeben 
            return self::$db_obj; 
         } 

      //klonen von dieser Instanz verhindern 
      private final function __clone () { } 
   } 
?>