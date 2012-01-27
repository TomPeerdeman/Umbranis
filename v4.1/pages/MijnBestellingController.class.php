<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class MijnBestellingController extends BaseController{
		public function buildPage(){
		
?>
			<div id="contentcontainer">
				<h2>bestelling overzicht</h2>
				<div id="contentbox">
<?php
					if (!$this->user->is_member()){
?>
<span style="color:red;"><p>Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</p></span>
<?php
					}
					else{
						$res = DB::$db->query("SELECT * FROM orders INNER JOIN users 
										ON users.id = orders.user_id 
										WHERE order_id=" . DB::$db->quote($_GET["id"]) . " LIMIT 1");
						
						if(!$res){
							$row['username'] = "";
						}else{
							$row = $res ->fetch();
						}		
						
						if($row['username'] != $this->user->username){
?>
<p><span style="color:red;">Deze bestelling is niet geregistreert onder uw account!</span></p>
<?php
						}else{

?>	
							<table id="lijstvklant">
								<tr>
									<th>Artikel no.</th>
									<th>Artikel naam</th>
									<th>Aantal</th>
									<th>Prijs / stuk</th>
									<th>Prijs totaal</th>
								</tr>
<?php
							$nummer = 1;
							$totaal =0;
							$res = DB::$db->query("SELECT * FROM order_products INNER JOIN products 
											ON order_products.product_id = products.product_id 
											WHERE order_id=" . DB::$db->quote($_GET["id"])."");
							while($res && $row = $res->fetch()){
								echo "<tr>";
								echo "<td>$nummer</td>";
								echo "<td>" . $row['product_name'] ."</td>";
								echo "<td>" . $row['amount']. "</td>";
								echo "<td>&euro;" .$row['price']."</td>";
								echo "<td>&euro;".$row['amount'] * $row['price']."</td>";
								echo "</tr>";
								$nummer++;
								$totaal+= ($row['amount'] * $row['price']);
							}
?>
								<tr>
									<td class="leeg" colspan="3">&nbsp;</td>
									<td><strong>Totaal:</strong></td>
									<td><strong>&euro;<?php echo $totaal;?></strong></td>
								</tr>
								<tr>
									<td class="leeg" colspan="5">&nbsp;</td>
								</tr>
								<tr>
									<td class="leeg" colspan="2">&nbsp;</td>
									<td class="leeg" colspan="2">
										<input type="submit" name="submit" onClick="location.href='?p=account'" value="Terug" />
									</td>
									<td class="leeg">&nbsp;</td>
								</tr>
							</table>

<?php					}
					}
?>
				</div>
			</div>
<?php	}
	}
?>