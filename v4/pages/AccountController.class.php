<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AccountController extends BaseController{
		public function buildPage(){
?>
			<div id="contentcontainer">
<?php
			if (!$this->user->is_member()){
?>
				<span style="color:red;">Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</span>
<?php
			}else{
				$res = DB::$db->query("SELECT * FROM users where username =" . DB::$db->quote($_SESSION['username'])."");
				if(($res->rowCount() == 1)) {
					$row = $res->fetch();
					$_SESSION['id'] = $row['id'];
					
?>
						<h2>Adres gegevens</h2>
						<div id="contentboxsmall">
							<p>Dit zijn uw adres gegevens. Druk op aanpassen om deze gegevens aan te passen.</p>
							
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
								<tr>
									<td>&nbsp;</td>
									<td><input type="button" name="submit" onClick="location.href='?p=adresschange'" value="Aanpassen" /></td>
								</tr>
							</table>
					</div><br />
					<h2>Wachtwoord wijzigen</h2>
					<div id="contentboxsmall">
						<p>Klik op wachtwoord wijzigen om uw wachtwoord te wijzigen<br /></p>
						
							<table>
								<tr>
									<td><input type="button" name="submit" onClick="location.href='?p=passchange'" value="Wachtwoord wijzigen" /></td>
								</tr>
							</table>
					</div>
<?php				$res = DB::$db->query("SELECT * FROM orders 
										where user_id =" . DB::$db->quote($_SESSION['id'])."
										ORDER BY date DESC");
					if(($res->rowCount() > 0)) {
?>
					<br /><h2>Bestelling overzicht</h2>
					<div id="contentbox">
						<p>Dit is een overzicht van uw bestellingen. 
						Klik op toon bestelling om de bijbehorende producten te zien.</p>

							<table id="orders">
								<tr>
									<th class="begin">&nbsp;</th>
									<th>Order no.</th>
									<th>Prijs</th>
									<th>Betaling<br />ontvangen</th>
									<th>Afgeleverd</th>
									<th>Datum bestelling</th>
								</tr>
<?php
								while($row = $res->fetch()){

									echo "<tr>";
									echo "<td class=\"begin\"><a href=\"?p=mijnBestelling&amp;id=" .  $row['order_id'] . "\" >Toon bestelling</a>&nbsp;&nbsp;</td>";
?>	
										<td><?php echo $row['order_id'];?></td>
										<td>&euro;<?php echo $row['total_price'];?></td>
										<td><?php echo (($row['payment_status'] == 1) ? "Ja" : "Nee");?></td>
										<td><?php echo (($row['delivery_status'] == 1) ? "Ja" : "Nee");?></td>
										<td><?php echo $row['date'];?></td>
									</tr>
<?php						}
?>
							</table>
					
				
<?php					echo "</div>";
						}
					
				}
			}
	echo "</div>";
		}
	}
?>
			