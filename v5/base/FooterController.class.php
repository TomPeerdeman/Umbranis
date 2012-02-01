<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class FooterController{
		public function buildFooter(){
?>
Copyright &copy; 2012
<?php
		}
	}
?>