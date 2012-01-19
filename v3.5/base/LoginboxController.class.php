<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LoginboxController{
		public function buildLoginbox(){
?>
<a href="?p=login">Inloggen</a>&nbsp;
<a href="?p=registreer">Registreren</a>&nbsp;
<a href="?p=zoek">Zoeken</a>&nbsp;
<a href="?p=admin/bestellingen">Admin</a>&nbsp;
<a href="?p=accsettings">klant</a>&nbsp;
<a href="?p=winkelwagen">Winkelwagen</a>
<?php
		}
	}
?>