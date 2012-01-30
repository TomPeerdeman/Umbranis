<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class MainController{
		private $controller;
		private $page;
		private $cssfile;
	
		public function __construct(){	
			//Bijbehorende controller zoeken, als geen pagina aangegeven is dan de home gebruiken
			if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] == "home"){
				$this->page = "home";
			}else{
				$this->page = $_GET['p'];
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
				echo "<link rel=\"stylesheet\" href=\"style/" . $this->cssfile . ".css\" type=\"text/css\" />";
			}
?>
<script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<div id="header"><h1>Umbranis webshop b&egrave;ta versie 4</h1></div>
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