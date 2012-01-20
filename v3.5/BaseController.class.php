<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class BaseController{	
		public function getTitle(){
			return "Umbranis webshop b&egrave;ta versie 3";
		}
	
		public function handleForm(){
		}
	
		public function buildPage(){
		}
		
		public function price($double){
			return number_format($double, 2, ',', '.');
		}
	}
?>