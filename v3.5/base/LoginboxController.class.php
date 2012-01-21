<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	session_start();
	class LoginboxController{
		public function buildLoginbox(){
		
		if(isset($_SESSION['username']))
			echo '<a href="?p=logout">uitloggen</a>&nbsp;';
		else{
			echo '<a href="?p=login">Inloggen</a>&nbsp;';
			echo '<a href="?p=registreer">Registreren</a>&nbsp;';
		}
		if(isset($_SESSION['rechten']) && $_SESSION['rechten'] == "admin")
			echo '<a href="?p=admin/bestellingen">Admin</a>&nbsp;';
		if(isset($_SESSION['rechten']) && $_SESSION['rechten'] == "klant"){
			echo '<a href="?p=accsettings">account</a>&nbsp;';
			echo '<a href="?p=winkelwagen">Winkelwagen</a>&nbsp;';
		}
?>
<a href="?p=zoek">Zoeken</a>
<?php
		}
	}
?>