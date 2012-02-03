<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class BestellingController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){			
			include("MailSender.class.php");
			if ($_POST['submit']){
				$resgegevens = DB::$db->query("SELECT * FROM users WHERE username =" . DB::$db->quote($_SESSION['username'])."");
				$row = $resgegevens->fetch();
				$msg = "<html>
					<head>
					<title>Umbranis Bestelling</title>
					</head>
					<body>
					<p>Beste " . ucfirst($row['firstname']) . " " . ucfirst($row['lastname']) . ",<br />bedankt voor het plaatsen van uw bestelling bij Umbranis, de webshop voor al uw multimedia!</p>
					</body>
					</html>";
				
				if(!MailSender::sendMail($row['email'], "Bestel", $msg, true)){
					$this->errors[] = "De bevestigings mail kon niet verstuurd worden!";
				}
				
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
								DB::$db->query("UPDATE products SET stock = stock - 1 WHERE product_id =".$row2['prod_id']."");
							}
							DB::$db->query("DELETE FROM winkelwagen WHERE user_id=".$row1['user_id']."");
						}
					}
					$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$_SESSION['username']."' LIMIT 1");
					$row0 = $res0->fetch();	
						$resorderid = DB::$db->query("SELECT order_id FROM orders WHERE user_id='". $row0['id']."' LIMIT 1");
						$roworderid = $resorderid->fetch();
						
					DB::$db->query("UPDATE orders 
						SET total_price=".$total."
						WHERE order_id =".$roworderid['order_id']."");
					if(!$res0){
						$this->errors[] = "Er is een fout in de database opgetreden!";
						return;
					}
				}
				$this->posted = true;
			}
		}
	
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Bestelling gegevens</h2>
	<div id="contentboxsmall">
<?php	
			if(!$this->posted || count($this->errors) != 0){
				echo "<b>Controleer goed of alles klopt!</b>";
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
			else{
				$resgegevens = DB::$db->query("SELECT * FROM users WHERE username =" . DB::$db->quote($_SESSION['username'])."");
				if(!$resgegevens || ($resgegevens->rowCount() == 1)) {
					if(!$resgegevens)$row = null;
					else $row = $resgegevens->fetch();
?>
					<table>
						<tr>
							<td>Voornaam</td>
							<td><?php echo ": ". $row['firstname'];?></td>
						</tr>
						<tr>
							<td>Achternaam</td>
							<td><?php echo ": ". $row['lastname'];?></td>
						</tr>
						<tr>
								<td>Postcode</td>
								<td><?php echo ": ". $row['zipcode'];?></td>
						</tr>
						<tr>
							<td>Plaats</td>
							<td><?php echo ": ". $row['city'];?></td>
						</tr>
						<tr>
							<td>Straat</td>
							<td><?php echo ": ". $row['street'];?></td>
						</tr>
						<tr>
							<td>Huisnummer</td>
							<td><?php echo ": ". $row['house_number'];?></td>
						</tr>
						<tr>
							<td>Telefoon 1</td>
							<td><?php echo ": ". $row['tel1'];?></td>
						</tr>
						<tr>
							<td>Telefoon 2</td>
							<td><?php echo ": ". $row['tel2'];?></td>
						</tr>
						<tr>
							<td>Email adress</td>
							<td><?php echo ": ". $row['email'];?></td>
						</tr>
					</table>
					<br />
					</div>
				</div>
<?php
			 
					echo '
					<div id="contentcontainer">
					<table border="1" cellpadding = "2" width="520px">
					<tr>
					<th>Product naam</th>
					<th>Prijs</th>
					<th>Aantal</th>
					</tr>';
					$totalcost = 0;
					$carsize = 0;
					$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
					if($res0 && $row0 = $res0->fetch()){
						$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id =". $row0['id']);
						while($res1 && $row1 = $res1->fetch()){
							//builds up the individual's shopping list
							$res2 = DB::$db->query("SELECT * FROM products where product_id = ".$row1['prod_id']);
							if($res2 && $row2 = $res2->fetch()){
								echo '
									<tr>
									<th>'.$row2['product_name'].'</th>
									<th>'.$row2['price'].'</th>
									<th align="center">'.$row1['amount'].'</th>
									</tr>
								';
								$totalcost += ($row2['price'] * $row1['amount']);
								$carsize += 1;
							}
						}
					}
					echo '
					<tr style="border-top:2px solid black;">
					<td>Totale prijs:</td>
					<th colspan="2">&euro;'.$totalcost.'</th>
					</tr>
					</table>
					</div>';
?>
					<div id="contentcontainer">
						<form action="?p=bestelling" method="post">
							<table width="400px">
								<tr align="center">
									<td>
									<input class="submit" type="submit" name="submit" value="Bevestigen"/>
									</td>
									<td>
									<input type="button" name="annuleren" onClick="location.href='?p=winkelwagen'" value="Annuleren" />
									</td>
								</tr>
							</table>
						</form>
<?php
				}
			}
		}
	}
?>