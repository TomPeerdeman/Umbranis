<?php
	session_start();
	define("INDEX", true);
	
	//Error handler vervangen zodat deze naar een file schrijft ipv naar het scherm
	
	set_error_handler(function($errno, $errstr, $errfile, $errline){
		$file = fopen("log/log_" . date("d-m-Y") . ".txt", "a+");
		$errstr = str_replace("<br />", "\r\n", $errstr);
		$errstr = strip_tags($errstr);
		switch($errno){
			case E_USER_WARNING:
				fwrite($file, "Warning: " . date("d-m-Y H:i:s") . " from " . $_SERVER['REMOTE_ADDR'] . "\r\n" . $errstr);
				break;
			case E_USER_ERROR:
				fwrite($file, "Error: " . date("d-m-Y H:i:s") . " from " . $_SERVER['REMOTE_ADDR'] . "\r\n" . $errstr);
				break;
			case E_ERROR:
				fwrite($file, "Error: " . date("d-m-Y H:i:s") . " from " . $_SERVER['REMOTE_ADDR'] . "\r\n" . $errstr . "\r\n\tin " . $errfile . " on line " . $errline);
				break;
			case E_WARNING:
				fwrite($file, "Warning: " . date("d-m-Y H:i:s") . " from " . $_SERVER['REMOTE_ADDR'] . "\r\n" . $errstr . "\r\n\tin " . $errfile . " on line " . $errline);
				break;
			default:
				fwrite($file, "Notice: " . date("d-m-Y H:i:s") . " from " . $_SERVER['REMOTE_ADDR'] . "\r\n" . $errstr . "\r\n\tin " . $errfile . " on line " . $errline);
				break;
		}
		fwrite($file, "\r\n\r\n");
		fclose($file);
	});
	
	//Site base root
	define("SITE_ROOT", "www.umbranis.nl/");
	
	//Voor https moet de site_root correct gezet zijn
	define("HTTPS", true);
	
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