<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LogoutController extends BaseController{
		public function buildPage(){
			$this->user->logout();
		
?>
<div id="contentcontainer">
	<div id="logincontainer">
		<p style="margin-top:20px;">U bent succesvol uitgelogt.<br /><br />
		Wij zien u graag gouw terug!</p>
	</div>
</div>
<?php
		}
	}
?>