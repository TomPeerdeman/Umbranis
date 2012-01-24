<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class RecoveryController extends BaseController{
		private $errors = array();
		private $posted = false;
		private $check = true;
		private $showform = true;
		private $newpass;
		
		public function handleForm(){
			if(!isset($_POST['username']) || empty($_POST['username'])){
				$this->errors[] = "U heeft geen username ingevoerd!";
				$this->check = false;
			}

			if(!isset($_POST['email']) || empty($_POST['email'])){
				$this->errors[] = "U heeft geen email-adress ingevoerd!";
				$this->check = false;
			}
			
			if($this->check){
				$res = DB::$db->query("SELECT * FROM users 
				WHERE username=" . DB::$db->quote($_POST['username'])  
				. "AND email=" . DB::$db->quote($_POST['email']) ." LIMIT 1");
										
				// dit bericht is overbodig als 1 van de velden niet is ingevuld
				if(($res->rowCount() != 1)) {
					$this->errors[] = "Onjuiste username/email combinatie";
				}else{
					$row = $res->fetch();
					
					if($row['login_tries'] > 5){
						$this->errors[] = "Dit account is geband!";
					}else{	
						include("PasswordGenerator.class.php");
						$passgen = new PasswordGenerator();
						$salt = $passgen->getRandomSalt();
						$passhash = $passgen->getPasswordHash("welkom", $salt);
					
						DB::$db->query("UPDATE users SET password='" . $passhash . "', password_salt='" . $salt . "', login_tries = 0 
							WHERE username='" . $row['username']. "'
							LIMIT 1");
						
						$_SESSION['username']= $row['username'];
						$this->newpass = "welkom";
						
						$this->user->login($row['username'], true);
						$this->showform = false;
						//
						//TODO: doe iets
						//mail nieuwe dingen ofzo
						//
					}	
				}
			}
			$this->posted = true;
		}
		
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Recover pass</h2>
	<div id="logincontainer">
		<br />
		<?php 
		if($this->posted){
			if(count($this->errors) > 0){
				echo "<p><span style=\"color: red;\">Het wachtwoord herstel process kon niet worden voltooid:<br />";
				foreach($this->errors as $error){
					echo $error . "<br />";
				}
				echo "</span></p>";
				echo "<br />";
			}else{
				echo "<p>Hello, " .$this->user->username. "<br />";
				echo "Uw aanvraag voor een nieuw wachtwoord is ontvangen<br />";
				echo "Uw nieuw wachtwoord is: " . $this->newpass. "<br / ><br />";
				echo "<strong>Belangrijk: vergeet niet om uw wachtwoord te wijzigen!</strong><br /><br />";
				echo "U wordt automatisch doorgestuurd na 5 seconden gebeurt dit niet klik dan <a href=\"?p=home\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"5;url=?p=home\" />";
			}
		}
		//formulier alleen tonen als je nog niet bent ingelogt
		if($this->showform){
?>
		<p>Vul de onderstaande velden in om uw wachtwoord te resetten.</p>
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
					<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Emailadres:
					</td>
					<td>
						<input type="text" name="email" maxlength="50" name="mail" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input id="submit" type="submit" name="submit" value="recover" />
					</td>
				</tr>
			</table>
		</form>
		<br />
		</div>
</div>
<?php
		}
		}
	}
?>