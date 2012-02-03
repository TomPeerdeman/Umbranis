<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AdressgegevensController extends BaseController{
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
				if(!$res){
					echo "<p>Er is een fout in de database opgetreden!</p></div>";
					return;
				}
				
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
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr style="border: 1px solid black;">
									<td colspan="2" align="center"><input type="button" name="submit" onClick="location.href='?p=bestelling'" value="Bestellen" /></td>
								</tr>
							</table>
					</div><br />
<?php					
				}
			}
	echo "</div>";
		}
	}
?>		