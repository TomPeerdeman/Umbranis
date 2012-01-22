<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LogoutController extends BaseController{
		public function buildPage(){
			$this->user->logout();
		
?>
<div id="contentcontainer">
	U bent succesvol uitgelogt.<br />
	Wij zien u graag gouw terug!
</div>
<?php
		}
	}
?>