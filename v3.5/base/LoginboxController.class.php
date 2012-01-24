<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	session_start();
	class LoginboxController{
		public function buildLoginbox($user){	
			if($user->is_member())
				echo '<a href="?p=logout">Uitloggen</a>&nbsp;';
			else{
				echo '<a href="?p=login">Inloggen</a>&nbsp;';
				echo '<a href="?p=registreer">Registreren</a>&nbsp;';
			}
			if($user->is_member() && $user->is_admin())
				echo '<a href="?p=admin/admin">Admin</a>&nbsp;';
			if($user->is_member()){
				echo '<a href="?p=accsettings">Account</a>&nbsp;';
				echo '<a href="?p=winkelwagen">Winkelwagen</a>&nbsp;';
			}
?>
<a href="?p=zoek">Zoeken</a>
<?php
		}
	}
?>