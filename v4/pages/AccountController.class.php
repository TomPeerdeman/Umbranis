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
						<div class="klantcontact">
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
									<td>telefoon 1</td>
									<td><?php echo ": ". $row['tel1'];?></td>
								</tr>
								<tr>
									<td>telefoon 2</td>
									<td><?php echo ": ". $row['tel2'];?></td>
								</tr>
								<tr>
									<td>Email adress</td>
									<td><?php echo ": ". $row['email'];?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type="submit" name="submit" onClick="location.href='?p=adresschange'" value="aanpassen" /></td>
								</tr>
							</table>
						<br />
					</div><br />
					<h2>Wachtwoord wijzigen</h2>
					<div class="klantcontact">
						<p>Klik op wachtwoord wijzigen om uw wachtwoord te wijzigen<br /></p>
						
							<table>
								<tr>
									<td><input type="submit" name="submit" onClick="location.href='?p=passchange'" value="wachtwoord wijzigen" /></td>
								</tr>
							</table>
						
						<br />
					</div>
<?php				$res = DB::$db->query("SELECT * FROM orders 
										where user_id =" . DB::$db->quote($_SESSION['id'])."
										ORDER BY date DESC");
					if(($res->rowCount() > 0)) {
?>
					<br /><h2>Bestelling overzicht</h2>
					<div class="klantbestel" style ="width:700px;">
						<p>Dit is een overzicht van uw bestellingen. 
						Klik op toon bestelling om de bijbehorende producten te zien.</p>

							<table id="orders">
								<tr>
									<th class="begin">&nbsp;</th>
									<th>Order no.</th>
									<th>prijs</th>
									<th>betaling<br />ontvangen</th>
									<th>afgeleverd</th>
									<th>datum bestelling</th>
								</tr>
<?php
								while($row = $res->fetch()){

									echo "<tr>";
									echo "<td class=\"begin\"><a href=\"?p=mijnBestelling&amp;id=" .  $row['order_id'] . "\" >toon bestelling</a></td>";
?>	
										<td><?php echo $row['order_id'];?></td>
										<td>&euro;<?php echo $row['total_price'];?></td>
										<td><?php echo (($row['payment_status'] == 1) ? "Ja" : "Nee");?></td>
										<td><?php echo (($row['delivery_status'] == 1) ? "Ja" : "Nee");?></td>
										<td><?php echo $row['date'];?></td>
									</tr>
<?php						}
?>
							</table><br />
					
				
<?php					echo "</div>";
						}
					
				}
			}
	echo "</div>";
		}
	}
?>
			