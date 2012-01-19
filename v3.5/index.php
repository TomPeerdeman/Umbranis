<?php
	error_reporting(E_ALL);
	define("INDEX", true);
	
	include("MainController.class.php");
	include("BaseController.class.php");
	include("DB.class.php");
	
	//Database connectie maken
	DB::create();
	
	new MainController();
?>