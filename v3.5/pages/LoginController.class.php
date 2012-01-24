<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class LoginController extends BaseController{
		private $errors = array();
		private $posted = false;
		private $check = true;
		private $showform = true;
		
		public function handleForm(){
			if(!isset($_POST['username']) || empty($_POST['username'])){
				$this->errors[] = "U heeft geen username ingevoerd!";
				$this->check = false;
			}

			if(!isset($_POST['password']) || empty($_POST['password'])){
				$this->errors[] = "U heeft geen password ingevoerd!";
				$this->check = false;
			}
			
			// dit bericht is overbodig als 1 van de velden niet is ingevuld
			if($this->check){
				$res = DB::$db->query("SELECT username, password, password_salt, admin_rights, last_action, login_tries
					FROM users
					WHERE username=" . DB::$db->quote($_POST['username']) . "
					LIMIT 1");
				
				//Geen gebruiker met die username
				if(($res->rowCount() != 1)) {
					$this->errors[] = "Onjuiste username/wachtwoord combinatie. Nog 5 Pogingen";
				}
				
				$row = $res->fetch();
				if($row['last_action'] > 0){
					$this->errors[] = "Deze gebruiker is al ingelogd!";
				}
				
				if($row['login_tries'] ==5){
					$this->errors[] = "Dit account is gelocked! Vraag een nieuw paswoord aan.";
				}else if($row['login_tries'] > 5){
					$this->errors[] = "Dit account is geband!";
				}else{	
					include("PasswordGenerator.class.php");
					$passgen = new PasswordGenerator();
					$passhash = $passgen->getPasswordHash($_POST['password'], $row['password_salt']);
					
					//Onjuist wachtwoord ingevoerd 
					if($passhash != $row['password']) {
						$this->errors[] = "Onjuiste username/wachtwoord combinatie. Nog " . (4 - $row['login_tries']) . " Pogingen.";
						DB::$db->query("UPDATE users SET login_tries = login_tries + 1 WHERE username='" . $row['username'] . "' LIMIT 1");
					}
				}
				
				if(count($this->errors) == 0){
					DB::$db->query("UPDATE users SET login_tries = 0 WHERE username='" . $row['username'] . "' LIMIT 1");
					//gegevens worden opgeslagen zodat je later content kan laten zien op 
					//basis van checks op deze gegevens
					$_SESSION['username'] = $row['username'];
					$this->user->login($row['username'], true);
					$this->showform = false;
				}
			}
			$this->posted = true;	
		}

		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Login</h2>
	<div id="logincontainer">

		<br />
<?php 
		if($this->posted){
			if(count($this->errors) > 0){
				echo "<p><span style=\"color: red;\">De inlog procedure kon niet worden voltooid:<br />";
				foreach($this->errors as $error){
					echo $error . "<br />";
				}
				echo "</span></p>";
				echo "<br />";
			}else{
				echo "<p>Hallo, " .$this->user->username. ".<br />";
				echo "Je bent succesvol ingelogd!<br /><br />";
				echo "U wordt automatisch doorgestuurd na 5 seconden gebeurt dit niet klik dan <a href=\"?p=home\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"5;url=?p=home\" />";
			}
		}
		//formulier alleen tonen als je nog niet bent ingelogt
		if($this->showform){
?>
		<p>Als u al een account heeft kunt u hier inloggen.</p>
		<br />
		
		<form action"#" method="post">
			<table>
				<tr>
					<td>
						Username:
					</td>
					<td>
						<input type="text" name="username" maxlength="50" />
					</td>
				</tr>
				<tr>
					<td>
						Paswoord:
					</td>
					<td>
						<input type="password" name="password" maxlength="25" />
					</td>
				</tr>
				<tr>
					<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input id="submit" type="submit" name="submit" value="Login" />
					</td>
				</tr>
			</table>
		</form>
		<br />
		<p>Heeft u nog geen account, registreer u dan <a href="?p=registreer">hier</a>.</p>
		<p>Bent u uw wachtwoord vergeten, klik dan <a href="?p=recovery">hier</a>.</p>
		<br />
	</div>
</div>
<?php
		}
		}
	}
?>