<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	//eindig sessie
	session_unset();
	
	class LogoutController extends BaseController{
		public function buildPage(){
		
?>
<div id="contentcontainer">
	U bent succesvol uitgelogt.<br />
	Wij zien u graag gouw terug!
</div>
<?php
		}
	}
?>