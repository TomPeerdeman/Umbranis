<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class BaseController{	
		public $user;
		
		public function __construct(){
			$this->user = new UserController();
		}
	
		public function getTitle(){
			return "Umbranis webshop b&egrave;ta versie 3! Ingelogd: " . (($this->user->is_member()) ? "Ja" : "Nee");
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