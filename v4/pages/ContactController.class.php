<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ContactController extends BaseController{
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Contact</h2>
	<div id="contentbox">
		<u>Contact:</u></br>
		<a href="mailto:umbranis@hotmail.com">umbranis@hotmail.com</a><br />
		Uva Sciencepark 904<br />
		1090 GE Amsterdam<br />
		020-525 8080
	</div>
</div>
<?php
		}
	}
?>