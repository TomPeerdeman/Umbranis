<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class DB extends PDO{
		public static $db;
		
		public static function create(){
			//Statische instantie van zichzelf maken
			self::$db = new DB();
		}
		
		public function __construct(){
			try{
				//Connectie maken
				parent::__construct("mysql:hostname=localhost;dbname=webdb1242", "webdb1242", "gap84kas");
				//Standaard fetch mode op assoc zetten
				parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				//Zorgen dat PDO een Exception gooit bij een gefaalde query
				parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				trigger_error("Could not connect to DB: " . $e->getMessage() . "in " . $e->getFile() . " on line " . $e->getLine() . ".<br />", E_USER_ERROR);
			}
		}
		
		public function query($sql){
			try{
				return parent::query($sql);
			}catch(PDOException $e){
				//De exception bestandsnaam en lijn zijn waardeloos aangezien deze naar parent::query($sql) wijzen. debug_backtrace geeft wel de goede informatie.
				$stack = debug_backtrace();
				trigger_error("Error in SQL: " . $e->getMessage() . "in <strong>" . $stack[0]['file'] . "</strong> on line <strong>" . $stack[0]['line'] . "</strong>.<br />Query: " . $sql . "<br />", E_USER_WARNING);
				return false;
			}
		}
	}
?>