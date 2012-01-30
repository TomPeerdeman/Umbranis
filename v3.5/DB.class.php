<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class DB{
		public static $db;
	
		public static function create(){
			try{
				//Connectie maken & database selecteren
				DB::$db = new PDO("mysql:hostname=localhost;dbname=webdb1242", "webdb1242", "gap84kas");
				//Standaard fetch mode op FETCH_ASSOC zetten
				DB::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				die("<p>Connection with the database failed: " . $e->getMessage() ."</p>");
			}
		}
	}
?>