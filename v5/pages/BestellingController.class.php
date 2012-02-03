<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class BestellingController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			$this->posted = true;
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
			if(!isset($_POST['email']) || empty($_POST['email']) || !preg_match("/^.+@.+\..+$/", $_POST['email'])){
				$this->errors[] = "U heeft geen geldig e-mailadres ingevoerd!";
			}
			
			include("MailSender.class.php");
			$msg = "<html>
				<head>
				<title>Umbranis Bestelling</title>
				</head>
				<body>
				<p>Beste " . ucfirst($_POST['name']) . " " . ucfirst($_POST['lastname']) . ",<br />bedankt voor het plaatsen van uw bestelling bij Umbranis, de webshop voor al uw multimedia!</p>
				</body>
				</html>";
			
			if(count($this->errors) == 0 && !MailSender::sendMail($_POST['email'], "Bestel", $msg, true)){
				$this->errors[] = "De bevestigings mail kon niet verstuurd worden!";
			}
			
			if(count($this->errors) == 0){
				
<<<<<<< HEAD
				if(count($this->errors) == 0){
					
					$total = 0;
					$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$_SESSION['username']."' LIMIT 1");
					if($res0 && $row0 = $res0->fetch()){
						$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id =". $row0['id']."");		
						DB::$db->query("INSERT INTO orders (user_id) VALUE (". $row0['id'].")");	
						$resorderid = DB::$db->query("SELECT order_id FROM orders WHERE user_id='". $row0['id']."' LIMIT 1");
						$roworderid = $resorderid->fetch();
						while($res1 && $row1 = $res1->fetch()){
							//builds up the individual's shopping list
							$res2 = DB::$db->query("SELECT * FROM products where product_id = ".$row1['prod_id']);
							if($res2 && $row2 = $res2->fetch()){	
								$total = $total + ($row2['price'] * $row1['amount']);
								DB::$db->query("INSERT INTO order_products (order_id, product_id, price, amount)
								VALUES ('".$roworderid['order_id']."',
									'".$row1['prod_id']."',
									'".$row2['price']."',
									'".$row1['amount']."'
								)");
								DB::$db->query("UPDATE products SET sales = sales + (1 *".$row['amount'].", stock = stock - (1 *".$row['amount']." WHERE product_id =".$row2['prod_id']."");
							}
							DB::$db->query("DELETE FROM winkelwagen WHERE user_id=".$row1['user_id']."");
=======
				$res = DB::$db->query("INSERT INTO order (user_id, firstname, lastname, zipcode, city, street, house_number, email)
					VALUES (
						" . $this->escape('name') . ",
						" . $this->escape('lastname') . ",
						" . DB::$db->quote($_POST['zip1'] . strtoupper($_POST['zip2'])) . ",
						" . $this->escape('city') . ",
						" . $this->escape('street') . ",
						" . $this->escape('housenr') . ",
						" . $this->escape('email') . "
					)");
				$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
				if($res0 && $row0 = $res0->fetch()){
					$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id =". $row0['id']);
					while($res1 && $row1 = $res1->fetch()){
						//builds up the individual's shopping list
						$res2 = DB::$db->query("SELECT * FROM products where product_id = ".$row1['prod_id']);
						if($res2 && $row2 = $res2->fetch()){	
							DB::$db->query("INSERT INTO order_products VALUES ".$row1['prod_id'].",".$row2['price'].",".$row1['amount']."");
							DB::$db->query("DELETE FROM winkelwagen WHERE prod_id=".$row1['prod_id'].", user_id = ".$row1['user_id']."");
>>>>>>> 074c9afad9a6c407e2710f79d7d1fd5e6bb9850e
						}
					}
				}
				if(!$res || $res0 || $res1 || $res2){
					$this->errors[] = "Er is een fout in de database opgetreden!";
					return;
				}
			}
		}
		
		private function valueLoad($item){		
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
	<h2>Bestelling</h2>
	<div id="contentboxsmall">
<?php	
			if(!$this->posted || count($this->errors) != 0){
				echo "<p>Vul hier uw adresgegevens in.</p>";
			}else{
				echo "<p>Bestelling geplaatst!</p>";
			}
			echo "<br />";

			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">De bestelling kon niet worden geplaatst:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span></p>";
					echo "<br />";
				}else{
					echo "<p><span style=\"color: green;\">Uw bestelling is geplaatst.</span></p><br />";
					$_POST['gender'] = null;
				}
			}
			if(!$this->posted || count($this->errors) != 0){
?>
		<form action="#" method="post">
			<table>
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
						Postcode:
					</td>
					<td>
						<input type="text" name="zip1" maxlength="4" id="zip1" value="<?php $this->valueLoad('zip1'); ?>" />
						<input type="text" name="zip2" maxlength="2" id="zip2" value="<?php $this->valueLoad('zip2'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
					Plaats:
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
					<td>&nbsp;</td>
					<td>
						<input class="submit" type="submit" name="submit" value="Bestel" />
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