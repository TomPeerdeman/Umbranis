<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class RecoveryController extends BaseController{
		private $errors = array();
		private $posted = false;
			
		public function handleForm(){
			$this->posted = true;
			if(!isset($_POST['username']) || empty($_POST['username'])){
				$this->errors[] = "U heeft geen username ingevoerd!";
			}

			if(!isset($_POST['email']) || empty($_POST['email'])){
				$this->errors[] = "U heeft geen email-adress ingevoerd!";
			}
			
			if($this->user->is_member()){
				$this->errors[] = "U bent al ingelogd!";
			}
			
			if(count($this->errors) == 0){
				$res = DB::$db->query("SELECT login_tries, id, email FROM users 
				WHERE username=" . DB::$db->quote($_POST['username'])  
				. "AND email=" . DB::$db->quote($_POST['email']) ." LIMIT 1");
				
				if(!$res){
					$this->errors[] = "Er is een fout in de database opgetreden!";
					return;
				}
				
				// dit bericht is overbodig als 1 van de velden niet is ingevuld
				if(($res->rowCount() != 1)) {
					$this->errors[] = "Onjuiste username/email combinatie";
				}else{
					$row = $res->fetch();
					
					if($row['login_tries'] == 6){
						$this->errors[] = "Dit account is geband!";
					}else{						
						if(!DB::$db->query("UPDATE users
							SET password='', password_salt='', login_tries = 7 
							WHERE id='" . $row['id']. "'
							LIMIT 1")
						){
							$this->errors[] = "Er is een fout in de database opgetreden!";
							return;
						}
						
						if(!in_array("sha1", hash_algos()))die("Recovery hash algorithm not available!");
			
						$rechash = hash("sha1", "Recover[" . $_POST['username'] . $_POST['email'] . chr(mt_rand(65, 90)) . "]/Recover");
						
						if(!DB::$db->query("INSERT INTO password_requests (user_id, request_hash) VALUES (" . $row['id'] . ", '" . $rechash . "')")){
							$this->errors[] = "Er is een fout in de database opgetreden!";
							return;
						}
						
						include("MailSender.class.php");
						$msg = "<html><body><a href=\"" . SITE_ROOT . "?p=recover&amp;key=" . $rechash . "\">Klik hier om een nieuw wachtwoord in te stellen</a></body></html>";
						
						if(count($this->errors) == 0 && !MailSender::sendMail($row['email'], "Paswoord recovery", $msg, true)){
							$this->errors[] = "De recovery mail kon niet verstuurd worden!";
						}
					}	
				}
			}
		}
		
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Recover paswoord</h2>
	<div id="contentboxsmall">
		<?php 
			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">Het wachtwoord herstel process kon niet worden voltooid:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span><br /></p>";
				}else{
					echo "<p>";
					echo "Uw aanvraag voor een nieuw wachtwoord is ontvangen<br />";
					echo "U ontvangt een e-mail met daar in verdere instructies.<br /><strong>Let op deze e-mail blijf maar 10 minuten geldig!</strong><br /><br />";
					echo "U wordt automatisch doorgestuurd na 20 seconden gebeurt dit niet klik dan <a href=\"?p=home\">hier</a>.</p>";
					echo "<meta http-equiv=\"refresh\" content=\"20;url=?p=home\" />";
				}
			}
			
			if(!$this->posted || count($this->errors) != 0){
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
					<td>
						Emailadres:&nbsp;
					</td>
					<td>
						<input type="text" name="email" maxlength="50" name="mail" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input class="submit" type="submit" name="submit" value="Recover" />
					</td>
				</tr>
			</table>
		</form>
		</div>
</div>
<?php
			}
		}
	}
?>