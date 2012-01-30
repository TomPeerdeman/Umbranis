<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class RecoverController extends BaseController{
		private $success = false;
		private $key;
		private $errors;
		
		public function __construct(){
			parent::__construct();
			DB::$db->query("DELETE FROM password_requests WHERE NOW() > DATE_ADD(request_time, INTERVAL 10 MINUTE)");
			
			if(isset($_GET['key'])){
				$this->key = $_GET['key'];
				$res = DB::$db->query("SELECT *
					FROM password_requests
					WHERE request_hash = " . DB::$db->quote($this->key) . "
					LIMIT 1");
				if($res->rowCount() == 1){
					$this->success = true;
				}
			}elseif(isset($_POST['key'])){
				$this->success = true;
			}
		}
		
		public function handleForm(){
			$success = true;
			$this->key = addslashes($_POST['key']);
			$this->errors = array();
			
			if(!isset($_POST['newpass1']) || empty($_POST['newpass1'])){
				$this->errors[] = "U heeft uw nieuwe wachtwoord niet ingevoerd!";
			}
			if(!isset($_POST['newpass2']) || empty($_POST['newpass2'])){
				$this->errors[] = "U heeft het controle wachtwoord niet ingevoerd!";
			}
			if($_POST['newpass2'] != $_POST['newpass1']){
				$this->errors[] = "Het nieuwe wachtwoord komt niet overeen met het controle wachtwoord!";
			}
			
			if(count($this->errors) == 0){
				include("PasswordGenerator.class.php");
				$passgen = new PasswordGenerator();
				$salt = $passgen->getRandomSalt();
				$passhash = $passgen->getPasswordHash($_POST['newpass1'], $salt);
				
				$res = DB::$db->query("SELECT user_id FROM password_requests WHERE request_hash=" . DB::$db->quote($this->key) . " LIMIT 1");
				if($res->rowCount() !=1){
					$this->success = false;
				}else{
					$row = $res->fetch();
					DB::$db->query("UPDATE users SET login_tries = 0, password = '" . $passhash . "', password_salt = '" . $salt . "' WHERE id = " . $row['user_id'] . " LIMIT 1");
					
					//Geen limit 1 hier aangezien er sowieso maar een request per user hoort te zijn
					DB::$db->query("DELETE FROM password_requests WHERE user_id = " . $row['user_id']);
				}
			}
		}
		
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Login</h2>
	<div id="logincontainer">
<?php		
			if($this->success){
				if(!isset($this->errors) || count($this->errors) != 0){
?>
					<p>Het herstel process is geluk, u kunt hier een nieuw wachtwoord instellen.</p>
					<br />
<?php
					if(isset($this->errors) && count($this->errors) > 0){
						echo "<p><span style=\"color: red;\">Uw wachtwoord is niet gewijzigd:<br />";
						foreach($this->errors as $error){
							echo $error . "<br />";
						}
						echo "</span></p>";
						echo "<br />";
					}
?>
					<form action="?p=recover" method="post">
						<table>
							<tr>
								<td>Nieuw wachtwoord</td>
								<td><input type="password" name="newpass1" maxlength="32" /></td>
							</tr>
							<tr>
								<td>Wachtwoord controle</td>
								<td><input type="password" name="newpass2" maxlength="32" /></td>
							</tr>
							<tr>
								<td><input type="hidden" name="key" value="<?php echo $this->key; ?>" /></td>
								<td><input type="submit" name="submit" value="Bevestigen" /></td>
							</tr>
						</table>
						
					</form><br />
<?php
				}else{
					echo "<p><br />Uw nieuwe wachtwoord is ingesteld!";
					echo "<br /><br />U wordt automatisch doorgestuurd na 5 seconden gebeurt dit niet klik dan <a href=\"?p=login\">hier</a>.</p>";
					echo "<meta http-equiv=\"refresh\" content=\"5;url=?p=login\" />";
				}
			}else{
				echo "<p>Het herstellen van het wachtwoord is mislukt!<br />Dit kan komen doordat de aanvraag verlopen is.<br />Probeer opnieuw een nieuw paswoord aan te vragen.";
				echo "<br /><br />U wordt automatisch doorgestuurd na 10 seconden gebeurt dit niet klik dan <a href=\"?p=recovery\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"10;url=?p=recovery\" />";
			}
?>
	</div>
</div>
<?php
		}
	}
?>