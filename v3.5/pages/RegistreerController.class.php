<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class RegistreerController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			if(!isset($_POST['username']) || empty($_POST['username'])){
				$this->errors[] = "U heeft geen username ingevoerd!";
			}		
			if(!isset($_POST['name']) || empty($_POST['name'])){
				$this->errors[] = "U heeft geen naam ingevoerd!";
			}
			if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
				$this->errors[] = "U heeft geen achternaam ingevoerd!";
			}
			if(!isset($_POST['zip1']) || empty($_POST['zip1']) || !isset($_POST['zip2']) || empty($_POST['zip2'])){
				$this->errors[] = "U heeft geen of een onvolledige postcode ingevoerd!";
			}elseif(!ctype_digit($_POST['zip1']) || !ctype_alpha($_POST['zip2']) || strlen($_POST['zip1']) != 4 || strlen($_POST['zip2']) != 2){
				$this->errors[] = "U heeft een ongeldige postcode ingevoerd!";
			}
			
			if(!isset($_POST['street']) || empty($_POST['street'])){
				$this->errors[] = "U heeft geen straatnaam ingevoerd!";
			}
			if(!isset($_POST['city']) || empty($_POST['city'])){
				$this->errors[] = "U heeft geen straatnaam ingevoerd!";
			}
			if(!isset($_POST['housenr']) || empty($_POST['housenr']) || !ctype_alnum($_POST['housenr']) || !preg_match("/^[0-9]{1,}[a-zA-Z]{0,}$/", $_POST['housenr'])){
				$this->errors[] = "U heeft geen geldig huisnummer ingevoerd!";
			}
			if(!isset($_POST['phone1']) || empty($_POST['phone1']) || !preg_match("/^[0-9]{2,4}-?[0-9]{6,8}$/", $_POST['phone1'])){
				$this->errors[] = "U heeft geen geldig telefoonnummer ingevoerd!";
			}
			if(isset($_POST['phone2']) && !empty($_POST['phone2']) && (!preg_match("/^[0-9]{2,4}-?[0-9]{6,8}$/", $_POST['phone2']) || $_POST['phone2'] == $_POST['phone1'])){
				$this->errors[] = "U heeft een ongeldig tweede telefoonnummer ingevoerd!";
			}
			if(!isset($_POST['email']) || empty($_POST['email']) || !preg_match("/^.+@.+\..+$/", $_POST['email'])){
				$this->errors[] = "U heeft geen geldig e-mailadres ingevoerd!";
			}
			if(!isset($_POST['pass1']) || empty($_POST['pass1'])){
				$this->errors[] = "U heeft geen paswoord ingevoerd!";
			}
			if(!isset($_POST['pass2']) || empty($_POST['pass2'])){
				$this->errors[] = "U heeft het controle paswoord niet ingevoerd!";
			}
			if($_POST['pass2'] != $_POST['pass1']){
				$this->errors[] = "Het paswoord komt niet overeen met het controle paswoord!";
			}
			
			$res = DB::$db->query("SELECT * FROM users WHERE email=" . DB::$db->quote($_POST['email']) . "");
			if($res->rowCount() > 0){
				$this->errors[] = "Er is al een gebruiker met dit e-mailadres!";
			}

			$res = DB::$db->query("SELECT * FROM users WHERE username=" . DB::$db->quote($_POST['username']) . "");
			if($res->rowCount() > 0){
				$this->errors[] = "Er is al een gebruiker met deze username!";
			}	
			
			if(!in_array("sha1", hash_algos()))die("Register hash algorithm not available!");
			
			$reghash = hash("sha1", "Register[" . $_POST['username'] . $_POST['email'] . chr(mt_rand(65, 90)) . "]/Register");
			
			include("MailSender.class.php");
			$msg = "<html><body><a href=\"umbranis.nogwat.co.cc/v3.5/?p=activatie&amp;key=" . $reghash . "\">Klik hier om uw account te activeren</a></body></html>";
			
			if(count($this->errors) == 0 && !MailSender::sendMail($_POST['email'], "Registratie", $msg, true)){
				$this->errors[] = "De registratie mail kon niet verstuurd worden!";
			}
			
			if(count($this->errors) == 0){
				include("PasswordGenerator.class.php");
				$passgen = new PasswordGenerator();
				$salt = $passgen->getRandomSalt();
				
				DB::$db->query("INSERT INTO users (username, password, password_salt, firstname, lastname, gender, zipcode, city, street, house_number, tel1, tel2, email)
					VALUES (
						" . $this->escape('username') . ", 
						'" . $passgen->getPasswordHash($_POST['pass1'], $salt) . "',
						'" . $salt . "',
						" . $this->escape('name') . ",
						" . $this->escape('lastname') . ",
						" . $this->escape('gender') . ",
						" . DB::$db->quote($_POST['zip1'] . strtoupper($_POST['zip2'])) . ",
						" . $this->escape('city') . ",
						" . $this->escape('street') . ",
						" . $this->escape('housenr') . ",
						" . $this->escape('phone1') . ",
						" . $this->escape('phone2') . ",
						" . $this->escape('email') . "
					)");
					
				$res = DB::$db->query("SELECT id FROM users WHERE username = " . $this->escape('username') . " LIMIT 1");	
				if(!$res->rowCount() == 1){
					$this->errors[] = "De registratie kon niet verwerkt worden!";
				}else{
					$row = $res->fetch();
				
					DB::$db->query("INSERT INTO password_requests (user_id, request_hash) VALUES (" . $row['id'] . ", '" . $reghash . "')");
				}
			}
			$this->posted = true;
		}
		
		private function valueLoad($item){
			//Velden leeg laten als het formulier successvol afgehandelt is
			if($this->posted && count($this->errors) == 0){
				return;
			}
			
			if($item == "zip2"){
				echo (isset($_POST[$item])) ? strtoupper($_POST[$item]) : "";
			}else{
				echo (isset($_POST[$item])) ? $_POST[$item] : "";
			}
		}
		
		private function escape($item){
			if(isset($_POST[$item])){
				if($item != "username" && $item != "email"){
					return DB::$db->quote(ucfirst($_POST[$item]));
				}else{
					return DB::$db->quote($_POST[$item]);
				}
			}else{
				return "''";
			}
		}
	
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Registreren</h2>
	<div id="registercontainer">
		<p>U kunt hier een nieuw account aanmaken.<br />Velden met een * zijn verplicht om in te vullen.</p>
		<br />
<?php
			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">De registratie kon niet worden voltooid:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span></p>";
					echo "<br />";
				}else{
					echo "<p><span style=\"color: green;\">Uw account is aangemaakt.</span></p><br />";
					$_POST['gender'] = null;
				}
			}
?>
		<form action="#" method="post">
			<table>
				<tr>
					<td>
						Username:
					</td>
					<td>
						<input type="text" name="username" maxlength="25" value="<?php $this->valueLoad('username'); ?>" />*
					</td>
				</tr>
				<tr>
				<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Naam:
					</td>
					<td>
						<input type="text" name="name" maxlength="25" value="<?php $this->valueLoad('name'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Achternaam:
					</td>
					<td>
						<input type="text" name="lastname" maxlength="25" value="<?php $this->valueLoad('lastname'); ?>" />*
					</td>
				</tr>
				<tr>
				<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Geslacht:
					</td>
					<td>
						<input style="width: 15px;" type="radio" name="gender" value="m" <?php echo (!isset($_POST['gender']) || $_POST['gender'] == "m") ? "checked=\"checked\" " : ""; ?>/>Man
						<input style="width: 15px;" type="radio" name="gender" value="f" <?php echo (isset($_POST['gender']) && $_POST['gender'] == "f") ? "checked=\"checked\" " : ""; ?>/>Vrouw *
					</td>
				</tr>
				<tr>
				<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Postcode:
					</td>
					<td>
						<input type="text" name="zip1" maxlength="4" id="zip1" value="<?php $this->valueLoad('zip1'); ?>" />
						<input type="text" name="zip2" maxlength="2" id="zip2" value="<?php $this->valueLoad('zip2'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Plaats
					</td>
					<td>
						<input type="text" name="city" maxlength="25" value="<?php $this->valueLoad('city'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Straat:
					</td>
					<td>
						<input type="text" name="street" maxlength="25" value="<?php $this->valueLoad('street'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Huisnummer:
					</td>
					<td>
						<input type="text" name="housenr" maxlength="5" value="<?php $this->valueLoad('housenr'); ?>" />*
					</td>
				</tr>
				<tr>
					<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Telefoon:
					</td>
					<td>
						<input type="text" name="phone1" maxlength="25" value="<?php $this->valueLoad('phone1'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Telefoon 2:
					</td>
					<td>
						<input type="text" name="phone2" maxlength="25" value="<?php $this->valueLoad('phone2'); ?>" />
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
						<input type="text" name="email" maxlength="50" value="<?php $this->valueLoad('email'); ?>" />*
					</td>
				</tr>
				<tr>
					<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>
						Paswoord:
					</td>
					<td>
						<input type="password" name="pass1" maxlength="25" />*
					</td>
				</tr>
				<tr>
					<td>
						Paswoord controle:
					</td>
					<td>
						<input type="password" name="pass2" maxlength="25" />*
					</td>
				</tr>
				<tr>
					<td colspan="2" class="spacer"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input id="submit" type="submit" name="submit" value="Registreer" />
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
?>