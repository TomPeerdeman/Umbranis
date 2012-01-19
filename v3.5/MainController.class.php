<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class MainController{
		private $controller;
	
		public function __construct(){	
			//Bijbehorende controller zoeken, als geen pagina aangegeven is dan de home gebruiken
			if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] == "home"){
				$page = "home";
			}else{
				$page = $_GET['p'];
			}
			
			//Pagina naam wijzigen van naam naar NaamController
			$page = ucfirst($page);
			$page .= "Controller";
			
			//Bestand laden
			include("pages/" . $page . ".class.php");
			
			//Controller aanmaken
			$this->controller = new $page();
			
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
<link rel="stylesheet" href="style/menu.css" type="text/css" />
<link rel="stylesheet" href="style/zoek.css" type="text/css" />
<link rel="stylesheet" href="style/login.css" type="text/css" />
<link rel="stylesheet" href="style/categorie.css" type="text/css" />
<link rel="stylesheet" href="style/contact.css" type="text/css" />
<link rel="stylesheet" href="style/bestel.css" type="text/css" />
<link rel="stylesheet" href="style/admin.css" type="text/css" />
<link rel="stylesheet" href="style/faq.css" type="text/css" />
<link rel="stylesheet" href="style/addcart.css" type="text/css" />
<link rel="stylesheet" href="style/accsettings.css" type="text/css" />
<link rel="stylesheet" href="style/home.css" type="text/css" />
<link rel="stylesheet" href="style/topsales.css" type="text/css" />
<script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<div id="header"><h1>Umbranis webshop b&egrave;ta versie 3</h1></div>
<div id="menu">
<?php 
			include("base/menu.html");
 ?>
</div>		
<div id="content">
<div id="topsales">
<?php
			include("base/top_sales.html");
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
			include("base/loginbox.html");
?>
</div>
<div id="footer">
<?php
			include("base/footer.html"); 
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