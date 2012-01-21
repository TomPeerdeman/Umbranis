<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class RecoveryController extends BaseController{
		private $errors = array();
		private $posted = false;
		private $check = true;
		private $showform = true;
		
		public function handleForm(){
			if(!isset($_POST['username']) || empty($_POST['username'])){
				$this->errors[] = "U heeft geen username ingevoerd!";
				$this->check = false;
			}

			if(!isset($_POST['email']) || empty($_POST['email'])){
				$this->errors[] = "U heeft geen email-adress ingevoerd!";
				$this->check = false;
			}
			
			$res = DB::$db->query("SELECT * FROM users 
			WHERE username=" . DB::$db->quote($_POST['username'])  
			. "AND email=" . DB::$db->quote($_POST['email']) ."");
									
			// dit bericht is overbodig als 1 van de velden niet is ingevuld
			if(($res->rowCount() == 0) && $this->check) {
				$this->errors[] = "onjuist username/email combinatie";
			}
			if($res->rowCount() == 1){
				while($row = $res->fetch()){
				$rechten = $row['admin_rights'];
				}
			}

			if(count($this->errors) == 0){
				DB::$db->query("UPDATE users SET password=\"welkom\" 
				WHERE username=" . DB::$db->quote($_POST['username']). " LIMIT 1");
				$_SESSION['username']=$_POST['username'];
				$_SESSION['password']="welkom";
				if($rechten == 1){
					$_SESSION['rechten'] = "admin";
				}
				if($rechten == 0){
					$_SESSION['rechten']= "klant";
				}
				$this->showform = false;
				//
				//TODO: doe iets
				//mail nieuwe dingen ofzo
				//
			}
			$this->posted = true;
		}
		
		//geen idee wat dit doet, maar ik zag het bij tom's registratie :P
		private function valueLoad($item){
		if($this->posted && count($this->errors) == 0){
			return;
			}
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
				echo "<p>Hello, " .$_SESSION['username']. "<br />";
				echo "Uw aanvraag voor een nieuw wachtwoord is ontvangen<br />";
				echo "Uw nieuw wachtwoord is: " . $_SESSION['password']. "<br / ><br />";
				echo "<strong>Belangrijk: vergeet niet om uw wachtwoord te wijzigen!</strong><br /><br />";
				echo "<a href=\"?p=home\">home</a></p>";
			}
		}
		//wist niet precies hoe redirect ging dus heb ik ipv daarvan heb ik
		//de formulier verborgen als je bent ingelogt
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