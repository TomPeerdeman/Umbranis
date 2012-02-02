<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LogoutController extends BaseController{
		public function buildPage(){
			$this->user->logout();
		
?>
<div id="contentcontainer">
	<div id="contentboxsmall">
		<p>U bent succesvol uitgelogt.<br /><br />
		Wij zien u graag snel terug!<br /><br />
		U wordt automatisch doorgestuurd na 5 seconden gebeurt dit niet klik dan <a href="?p=home">hier</a>.</p>
		<meta http-equiv="refresh" content="5;url=?p=home" />
	</div>
</div>
<?php
		}
	}
?>