<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ContactController extends BaseController{
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Contact</h2>
	<div id="contentbox">
		<strong>Email</strong><br /><a href="mailto:admin@umbranis.nl">admin@umbranis.nl</a><br /><br />
		<strong>Adres</strong><br />
		Uva Sciencepark 904<br />
		1090 GE Amsterdam<br /><br />
		<strong>Telefoon</strong><br />
		020-525 8080
	</div>
</div>
<?php
		}
	}
?>