<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class PasschangeController extends BaseController{
		private $errors = array();
		private $posted = false;
		private $check = true;
		private $showform = true;
		
		public function handleForm(){
			if(!isset($_POST['oldpass']) || empty($_POST['oldpass'])){
				$this->errors[] = "U heeft uw oude wachtwoord niet ingevoerd!";
				$this->check = false;
			}
			if(!isset($_POST['newpass1']) || empty($_POST['newpass1'])){
				$this->errors[] = "U heeft uw nieuwe wachtwoord niet ingevoerd!";
				$this->check = false;
			}
			if(!isset($_POST['newpass2']) || empty($_POST['newpass2'])){
				$this->errors[] = "U heeft het controle wachtwoord niet ingevoerd!";
				$this->check = false;
			}
			if($_POST['newpass2'] != $_POST['newpass1']){
				$this->errors[] = "Het nieuwe wachtwoord komt niet overeen met het controle wachtwoord!";
				$this->check = false;
				}
			// als voorgaande errors niet het geval zijn
			if($this->check){
				
				
				//decodeer oude wachtwoord om te kijken of het klopt
				$res = DB::$db->query("SELECT password_salt FROM users WHERE username=" 
				. DB::$db->quote($this->user->username) . " LIMIT 1");
				$row = $res->fetch();
				include("PasswordGenerator.class.php");
				$passgen = new PasswordGenerator();
				$passhash = $passgen->getPasswordHash($_POST['oldpass'], $row['password_salt']);
				$res = DB::$db->query("SELECT * FROM users 
				WHERE username=" . DB::$db->quote($this->user->username)  
				."AND password=" . DB::$db->quote($passhash) ." LIMIT 1");
				$row = $res->fetch();
				if(($res->rowCount() != 1)){
					$this->errors[] = "Uw heeft uw oude wachtwoord onjuist ingevoerd";
				}else{
				
					//password was juist, maak nieuw password aan
					$salt = $passgen->getRandomSalt();
					$passhash = $passgen->getPasswordHash($_POST['newpass1'], $salt);
					DB::$db->query("UPDATE users SET password='" . $passhash . "', password_salt='" . $salt . "' 
							WHERE username='" . $row['username']. "'
							LIMIT 1");
					$this->showform = false;
				}
			}
			$this->posted = true;
		}
		
		public function buildPage(){		
?>		
			<div id="contentcontainer">
				<h2>Wachtwoord wijzigen</h2>
				<div id="contentboxsmall">
<?php			if (!$this->user->is_member()){
					echo "<span style='color:red;'>Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</span>";
				}
				else{
				if($this->posted){
			if(count($this->errors) > 0){
				echo "<p><span style=\"color: red;\">Uw wachtwoord is niet gewijzigd:<br />";
				foreach($this->errors as $error){
					echo $error . "<br />";
				}
				echo "</span></p>";
				echo "<br />";
			}else{
				echo "<p>Hallo, " .$this->user->username. ".<br />";
				echo "<span style=\"color: green;\">Uw wachtwoord is gewijzigd</span><br /><br />";
				echo "U wordt automatisch doorgestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=account\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"2;url=?p=account\" />";
			}
		}
		
		//formulier alleen tonen als je nog niet bent ingelogt
		if($this->showform){

?>				
					<p>Om uw wachtwoord te wijzigen moet u bij huidig wachtwoord uw oude wachtwoord invoeren en bij
					nieuw wachtwoord uw nieuwe wachtwoord. Bij wachtwoord herhalen voert u opnieuw uw wachtwoord
					in als controle.</p><br />
					<form action="?p=passchange" method="post">
						<table>
							<tr>
								<td>Huidig wachtwoord:</td>
								<td><input type="password" name="oldpass" maxlength="32" /></td>
							</tr>
							<tr>
								<td>Nieuw wachtwoord:</td>
								<td><input type="password" name="newpass1" maxlength="32" /></td>
							</tr>
							<tr>
								<td>Wachtwoord herhalen:&nbsp;</td>
								<td><input type="password" name="newpass2" maxlength="32" /></td>
							</tr>
							<tr>
								<td><input type="button" name="submit" onClick="location.href='?p=account'" value="Annuleren" /></td>
								<td><input type="submit" name="submit" value="Bevestigen" /></td>
							</tr>
						</table>
					</form>
<?php			}
				}
?>
				</div>
			</div>
<?php
		}
	}
?>