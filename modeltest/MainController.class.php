<?php
	class MainController{
		public function __construct(){
			$this->beginPage();
			if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] == "home"){
				$page = "home";
			}else{
				$page = $_GET['p'];
			}
			$page = ucfirst($page);
			$page .= "Controller";
			include("pages/" . $page . ".class.php");
			$obj = new $page();
			$obj->buildPage();
			$this->endPage();
		}
	
		private function beginPage(){
			echo "<html><head><title>Test</title></head><body>";
		}
	
		private function endPage(){
			echo "</body></html>";
		}
	}
?>