<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LoginboxController{
		public function buildLoginbox($user){	
			if($user->is_member())
				echo '<a href="?p=logout" onclick="return page_load(\'logout\');">Uitloggen</a>&nbsp;';
			else{
				echo '<a href="?p=login" onclick="return page_load(\'login\');">Inloggen</a>&nbsp;';
				echo '<a href="?p=registreer" onclick="return page_load(\'registreer\');">Registreren</a>&nbsp;';
			}
			if($user->is_member() && $user->is_admin())
				echo '<a href="?p=admin/admin" onclick="return page_load(\'admin/admin\');">Admin</a>&nbsp;';
			if($user->is_member()){
				echo '<a href="?p=account" onclick="return page_load(\'account\');">Account</a>&nbsp;';
				echo '<a href="?p=winkelwagen" onclick="return page_load(\'winkelwagen\');">Winkelwagen</a>&nbsp;';
			}
?>
<a href="?p=zoek" onclick="return page_load('zoek');">Zoeken</a>
<?php
		}
	}
?>