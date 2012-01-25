<?php
	error_reporting(E_ALL);
	define("INDEX", true);
	
	define("SITE_ROOT", "127.0.0.1/v3.5/");
	ini_set("SMTP", "mail.nogwat.co.cc");
	
	include("MainController.class.php");
	include("BaseController.class.php");
	include("DB.class.php");
	include("UserController.class.php");
	
	//basis layout controllers
	include("base/LoginboxController.class.php");
	include("base/MenuController.class.php");
	include("base/TopsalesController.class.php");
	include("base/FooterController.class.php");
	
	//Database connectie maken
	DB::create();
	
	new MainController();
?>