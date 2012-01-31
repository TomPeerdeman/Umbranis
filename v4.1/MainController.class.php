<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class MainController{
		private $controller;
		private $page;
		private $cssfile;
		//Pagina's die zijn toegestaan om te laden
		private $allowedPages = array("account", 
			"activatie", 
			"adresschange", 
			"categorie", 
			"contact", 
			"faq", 
			"home", 
			"login", 
			"logout", 
			"mijnBestelling", 
			"passchange", 
			"product", 
			"producten", 
			"recover", 
			"recovery", 
			"registreer", 
			"zoek", 
			"winkelwagen",
			"result", 
			"admin/admin",
			"admin/addcategorie", 
			"admin/addproduct", 
			"admin/bestelling", 
			"admin/bestellingen", 
			"admin/updateproduct", 
			"admin/verwijderproduct",
			"admin/klantenoverzicht",
			"admin/klantoverzicht");
	
		public function __construct(){	
			//Bijbehorende controller zoeken, als geen pagina aangegeven is dan de home gebruiken
			if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] == "home"){
				$this->page = "home";
			}else{
				$this->page = $_GET['p'];
			}
			
			if(!in_array($this->page, $this->allowedPages)){
?>
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Access denied</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="3;url=?p=home" />
	</head>
	<body>
		<p><strong>Access denied!</strong></p>
	</body>
</html>
<?php
				exit();
			}
			
			if(HTTPS && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on')){
				//Als https aan staat redirecten als https:// nog niet gebruikt wordt
				header("Location: https://" . SITE_ROOT . "?p=" . $this->page);
				exit();
			}
			
			$this->cssfile = $this->page;
			//Pagina naam wijzigen van naam naar NaamController
			$this->page = ucfirst($this->page);
			$this->page .= "Controller";
			$url = "pages/";
			$arr = explode("/", $this->page);
			if(count($arr) == 2 && $arr[0] == "Admin"){
				//admin pagina
				include("AdminBaseController.class.php");
				$this->page = ucfirst($arr[1]);
				$url = "pages/admin/";
			}
			
			if(!file_exists($url . $this->page . ".class.php")){
				die("404 - page not found (yet).<br />" . $this->page);
			}
			
			//Bestand laden
			include($url . $this->page . ".class.php");
			
			//Controller aanmaken
			$this->controller = new $this->page();
			
			//Kijken of er een formulier gepost is zo ja, afhandelen laten door de controller
			if($this->formPosted()){
				$this->controller->handleForm();
			}
			
			//Pagina beginnen
			$this->beginPage();

			//Controller de pagina laten bouwen
			$this->controller->buildPage();
			
			//Pagina beeindigen
			$this->endPage();
		}
	
		private function beginPage(){
?>
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?php
			echo $this->controller->getTitle();
?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/base.css" type="text/css" />
<?php
			if(file_exists("style/" . $this->cssfile . ".css")){
				echo "<link rel=\"stylesheet\" href=\"style/" . $this->cssfile . ".css\" type=\"text/css\" />\n";
			}
			if(file_exists("javascript/" . $this->cssfile . ".js")){
				echo "<script src=\"javascript/" . $this->cssfile . ".js\" type=\"text/javascript\"></script>\n";
			}
?>
<script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<div id="header"><h1>Umbranis multimedia webshop</h1></div>
<div id="menu">
<?php 
			//menu bouwen
			$o = new MenuController();
			$o->buildMenu();
 ?>
</div>		
<div id="content">
<div id="sidebar">
<?php
			$o = new TopsalesController($this->page);
			$o->buildTopsales();
?>
</div>
<div id="maincontent">
<?php
		}
	
		private function endPage(){
?>
</div>
<br />
<br />
<br />
<div id="contentclear"></div>
</div>
<div id="loginbox">
<?php
			$o = new LoginboxController();
			$o->buildLoginbox($this->controller->user);
?>
</div>
<div id="footer">
<?php
			$o = new FooterController();
			$o->buildFooter();
?>
</div>
</div>
</body>
</html>
<?php
		}
		
		private function formPosted(){
			return $_SERVER['REQUEST_METHOD'] == "POST";
		}	
	}
?>