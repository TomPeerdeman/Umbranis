<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class AdresschangeController extends BaseController{
		private $posted = false;
		private $errors = array();
		private $showform = true;
		
		public function handleForm(){
			if(!isset($_POST['vnaam']) || empty($_POST['vnaam'])){
				$this->errors[] = "U heeft geen naam ingevoerd!";
			}
			if(!isset($_POST['anaam']) || empty($_POST['anaam'])){
				$this->errors[] = "U heeft geen achternaam ingevoerd!";
			}
			if(!isset($_POST['pstc']) || empty($_POST['pstc']) || !preg_match("/^[1-9]{1}[0-9]{3}[a-zA-Z]{2}$/", $_POST['pstc'])){
				$this->errors[] = "U heeft geen geldige postcode ingevoerd!";
			}
			if(!isset($_POST['plaats']) || empty($_POST['plaats'])){
				$this->errors[] = "U heeft geen plaatsnaam ingevoerd!";
			}
			if(!isset($_POST['huisnr']) || empty($_POST['huisnr']) || !preg_match("/^[0-9]{1,}[a-zA-Z]{0,}$/", $_POST['huisnr'])){
				$this->errors[] = "U heeft geen geldige huisnummer ingevoerd!";
			}
			if(!isset($_POST['tel1']) || empty($_POST['tel1']) || !preg_match("/^[0-9]{2,4}-?[0-9]{6,8}$/", $_POST['tel1'])){
				$this->errors[] = "U heeft geen geldig telefoonnummer ingevoerd!";
			}
			if(isset($_POST['tel2']) && !empty($_POST['tel2']) && (!preg_match("/^[0-9]{2,4}-?[0-9]{6,8}$/", $_POST['tel2']) || $_POST['tel2'] == $_POST['tel1'])){
				$this->errors[] = "U heeft een ongeldig tweede telefoonnummer ingevoerd!";
			}
			if(!isset($_POST['mail']) || empty($_POST['mail']) || !preg_match("/^.+@.+\..+$/", $_POST['mail'])){
				$this->errors[] = "U heeft geen geldig e-mailadres ingevoerd!";
			}
			if(count($this->errors) == 0){
				DB::$db->query("UPDATE users SET
							firstname =" . DB::$db->quote(ucfirst($_POST['vnaam'])) . ",
							lastname =" . DB::$db->quote(ucfirst($_POST['anaam'])) . ",
							zipcode =" . DB::$db->quote(strtoupper($_POST['pstc'])) . ",
							city =" . DB::$db->quote(ucfirst($_POST['plaats'])) . ",
							street =" . DB::$db->quote(ucfirst($_POST['straat'])) . ",
							house_number =" . DB::$db->quote($_POST['huisnr']) . ",
							tel1 =" . DB::$db->quote($_POST['tel1']) . ",
							tel2 =" . DB::$db->quote($_POST['tel2']) . ",
							email =" . DB::$db->quote($_POST['mail']) . "
							WHERE username =" . DB::$db->quote($_SESSION['username']) . "
					");
					$this->showform = false;
			}
			$this->posted = true;
		}

		private function valueLoad($item){
		$res = DB::$db->query("SELECT * FROM users WHERE username =" . DB::$db->quote($_SESSION['username'])."");
		$row = $res->fetch();
			//if($this->posted && count($this->errors) == 0){
				//return;
			//}
			if($item == "vnaam"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['firstname'];
			}
			if($item == "anaam"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['lastname'];
			}
			if($item == "pstc"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['zipcode'];
			}
			if($item == "plaats"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['city'];
			}
			if($item == "straat"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['street'];
			}
			if($item == "huisnr"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['house_number'];
			}
			if($item == "tel1"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['tel1'];
			}
			if($item == "tel2"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['tel2'];
			}
			if($item == "mail"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['email'];
			}
		}

		
		
		public function buildPage(){

?>
			<div id="contentcontainer">
				<h2>Adres gegevens</h2>
				<div class="klantcontact"><br />
				<?php
				if (!$this->user->is_member()){
				
?>
					<span style="color:red;">Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</span>
<?php
				}
				else{
					if($this->posted){
						if(count($this->errors) > 0){
							echo "<p><span style=\"color: red;\">De gegevens konden niet gewijzigd worden:<br />";
							foreach($this->errors as $error){
								echo $error . "<br />";
							}
							echo "</span></p>";
							echo "<br />";
						}
						if(count($this->errors) == 0){
							echo "<p><span style=\"color: green;\">Uw gegevens zijn gewijzigd.</span></p><br />";
							echo "<p>U wordt automatisch doorgestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=account\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"2;url=?p=account\" /></p>";
						}
					}
				if($this->showform){
					$res = DB::$db->query("SELECT * FROM users WHERE username =" . DB::$db->quote($_SESSION['username'])."");
					if(($res->rowCount() == 1)) {
						$row = $res->fetch();
?>
							<form action="#" method="post">
								<table>
									<tr>
										<td>voornaam</td>
										<td><input type="text" name="vnaam" maxlength="32" value="<?php $this->valueLoad('vnaam'); ?>" /></td>
									</tr>
									<tr>
										<td>achternaam</td>
										<td><input type="text" name="anaam" maxlength="32" value="<?php $this->valueLoad('anaam'); ?>" /></td>
									</tr>
									<tr>
										<td>Postcode</td>
										<td><input type="text" class="cpstc" name="pstc" maxlength="6" value="<?php $this->valueLoad('pstc');?>" /></td>
									</tr>
									<tr>
										<td>Plaats</td>
										<td><input type="text" name="plaats" maxlength="32" value="<?php $this->valueLoad('plaats');?>" /></td>
									</tr>
									<tr>
										<td>Straat</td>
										<td><input type="text" name="straat" maxlength="32" value="<?php $this->valueLoad('straat');?>" /></td>
									</tr>
									<tr>
										<td>Huisnummer</td>
										<td><input type="text" class="huisnr" name="huisnr" maxlength="5" value="<?php $this->valueLoad('huisnr');?>" /></td>
									</tr>
									<tr>
										<td>telefoon 1</td>
										<td><input type="text" class="ctel" name="tel1" maxlength="12" value="<?php $this->valueLoad('tel1');?>" /></td>
									</tr>
									<tr>
										<td>telefoon 2</td>
										<td><input type="text" class="ctel" name="tel2" maxlength="12" value="<?php $this->valueLoad('tel2');?>" /></td>
									</tr>
									<tr>
										<td>Email adress</td>
										<td><input type="text" class="cmail" name="mail" maxlength="32" value="<?php $this->valueLoad('mail');?>" /></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="submit" value="bevestigen" /></td>
									</tr>
								</table>
							</form><br />
						</div>
<?php				}
				}
			}
?>
			</div>
<?php	}
	}
?>