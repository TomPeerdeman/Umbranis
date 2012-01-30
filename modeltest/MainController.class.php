<?php
	class MainController{
		public function __construct(){
			//pagina beginnen
			$this->beginPage();
			
			//Bijbehorende controller zoeken als geen pagina aangegeven is dan de home gebruiken
			if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] == "home"){
				$page = "home";
			}else{
				$page = $_GET['p'];
			}
			
			//pagina naam wijzigen van naam naar NaamController
			$page = ucfirst($page);
			$page .= "Controller";
			
			//Bestand laden
			include("pages/" . $page . ".class.php");
			
			//Controller aanmaken
			$obj = new $page();
			
			//kijken of er een formulier gepost is zo ja, afhandelen laten door de controller
			if($this->formPosted()){
				$obj->handleForm();
			}

			//controller de pagina laten bouwen
			$obj->buildPage();
			
			//pagina beeindigen
			$this->endPage();
		}
	
		private function beginPage(){
			echo "<html><head><title>Test</title></head><body>";
		}
	
		private function endPage(){
			echo "</body></html>";
		}
		
		private function formPosted(){
			return $_SERVER['REQUEST_METHOD'] == "POST";
		}	
	}
?>