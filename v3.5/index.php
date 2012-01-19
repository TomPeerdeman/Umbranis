<?php
	error_reporting(E_ALL);
	define("INDEX", true);
	
	include("MainController.class.php");
	include("BaseController.class.php");
	include("DB.class.php");
	
	//basis layout controllers
	include("base/LoginboxController.class.php");
	include("base/MenuController.class.php");
	include("base/TopsalesController.class.php");
	include("base/FooterController.class.php");
	
	//Database connectie maken
	DB::create();
	
	new MainController();
?>