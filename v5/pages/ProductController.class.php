<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ProductController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			$this->posted = true;
			if(!isset($_POST['message']) || empty($_POST['message'])){
				$this->errors[] = "U heeft geen bericht ingevuld!";
			}
			if(count($this->errors) == 0){	
				$res = DB::$db->query("SELECT * FROM users where username = '" .$this->user->username. "'");
				if(!$res){
					$this->errors[] = "Er is een fout in de database opgetreden!";
					return;
				}
				$row = $res->fetch();
				if(!DB::$db->query("INSERT INTO comment (product_id, rating, message, user_id)
					VALUES (
   					 " . DB::$db->quote($_GET["id"]) . ",
   					 " . DB::$db->quote($_POST['rating']) . ",
   					 " . DB::$db->quote($_POST['message']) . ",
   					 '" . $row['id'] . "'
					)")
				){
					$this->errors[] = "Er is een fout in de database opgetreden!";
				}
			}
		}
	
		public function buildPage(){
			//get product id
			$x= DB::$db->quote($_GET["id"]);
?>
			<div id="contentcontainer">
<?php
			$res = DB::$db->query("SELECT * FROM products where product_id = $x");

			while($res && $row = $res->fetch()){
				echo "<h2>";
				echo $row['product_name'];
				echo "</h2>";
?>
				<div id="productbox">

<?php					if($this->user->is_member() && $this->user->is_admin()){ ?>
							<table>
								<tr>
									<td width="300px">
<?php									echo '<a href="?p=admin/updateproduct&amp;id=' . $row['product_id'] . '">';?>
											Product bewerken</a>
									</td>
									<td>
<?php									echo '<a href="?p=admin/verwijderproduct&amp;id=' . $row['product_id'] . '">';?>
											Product verwijderen</a>
									</td>
								</tr>
							</table>
<?php					}
						if($this->posted){
							if(count($this->errors) > 0){ 
?>
								<p><span style="color: red;">De review kon niet worden toegevoegd:<br />
<?php								foreach($this->errors as $error){
									echo $error . "<br />";
								}
								echo "</span></p>";
								echo "<br />";
							}
						}
?>
						<div id="propertiescontainer">
							<div class="shadow">
								<div id="propertiesbox">
									<table>
										<tr>
											<td class="even">Artikelnummer</td>
											<td class="even"><?php echo $row['product_id'];?></td>
										</tr>
										<tr>
											<td class="uneven">Type</td>
											<td class="uneven">PC-DVD</td>
										</tr>
										<tr>
											<td class="even">Voorraad</td>
											<td class="even"><?php echo $row['stock'];?> stuks</td>
										</tr>
										<tr>
											<td class="uneven">Levertijd</td>
											<td class="uneven"><?php
												if ($row['stock'] > 0)
													echo '<span style="color: green;">Direct leverbaar</span>';
												else
													echo '<span style="color: red;">Uitverkocht; +- ' . $row['delivery_time'] . ' dagen</span>';?>
											</td>
										</tr>
										<tr>
											<td class="even">EAN-code</td>
											<td class="even"><?php echo $row['ean_code'];?></td>
										</tr>
										<tr>
											<td class="uneven">Prijs (incl. BTW)</td>
											<td class="uneven">&euro; <?php echo $this->price($row['price']);?></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						
						<div id="picturecontainer">
							<?php echo '<img src="img/products/' . $row['image_path'] . '" alt="' . $row['product_name'] . '" />';?>
						</div>
						
						<br />
						<?php
						if (($this->user->is_member()){
							echo '<div id="cartcontainer" style="clear:both;" >
							<a href="?p=winkelwagen&action=add&id='.$row['product_id'].'">
							<img src="img/Cart.png" alt="Cart">Stop in Winkelwagen.</a>
							</div><br /><br />';
						}
						?>
							<!-- kopjes -->
							<ul id="productTabs" >
								<li id="tab1" class="selected" onclick="tabs(this);">product beschrijving</li>
								<li id="tab2" onclick="tabs(this);">comments</li>
							</ul>
							<!-- onderstaande lege div tabContent mag NIET weg -->
							<div id="tabContent"></div>
							
						<!-- inhoud tab 1 -->
						<div id="tab1Content" style="display:none;">
							<strong><?php echo $row['product_name'];?></strong><br />
							<?php echo((!empty($row['description'])) ? str_replace("\n", "<br />", $row['description']) : "Geen omschrijving.");?>
						</div>
						
						<!-- inhoud tab 2 -->
						<div id="tab2Content" style="display:none;">
<?php
						$res2 = DB::$db->query("SELECT * FROM comment where product_id = $x");
							echo '<h3>Reviews van dit product:</h3><br />
							
								<div id="commentbox">
									<table width = "700px">';
							$total = 0;
							$count = 0;
							while($res2 && $row2 = $res2->fetch()){
								$total = $total + $row2['rating'];
								$count++;
							}
							if($count > 0){
								$avg = $total / $count;
							}
							
							echo '	
										<tr>
											<td>
												<i><u><b>';
												if($count == 0){
													echo 'Er zijn nog geen cijfers aan dit product gegeven.';
												}
												else{
												echo'Gemiddelde cijfer voor dit product: ';
												
												echo number_format($avg, 1);
												}
												echo '</b></u></i><br /> <br />
											</td>
										</tr>';
							
							$res2 = DB::$db->query("SELECT * FROM comment where product_id = $x");
							while($res2 && $row2 = $res2->fetch()){
								
								$res3 = DB::$db->query("SELECT * FROM users WHERE id =" . $row2['user_id'] . "");
								$row3 = $res3->fetch();
								echo '
										<tr>
											<td class="evencomment" width="500px">
												<b>' . $row3['username'] . ' heeft om ' . $row2['time'] . ' gepost:</b>
											</td>
											<td class="evencomment" width="100px" align="right">
												Cijfer:
											</td>
											<td class="evencomment" width="100px">
												' . $row2['rating'] . '
											</td>
										</tr>
										<tr>
											<td class="unevencomment">
												<br />' . $row2['message'] . '<br /><br />
											</td>
										</tr>';
							}
							
						
						echo'</table></div><br />';
						if($this->user->is_member()){
							$i = 10;
							echo'
								<form action="?p=product&amp;id=' .$_GET['id'] . '" method="post">
									<table width ="700px">
										<tr>
											<td>
												Zelf een reactie toevoegen:
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<textarea rows="5" cols="70" name="message"></textarea>
											</td>
										</tr>
										<tr>
											<td>Cijfer: 
												<select name="rating" size="1" style="width:70px;">	';
											while($i != 0){
												echo "<option value=" . $i . ">" . $i . "</option>";
												$i--;
											}
										echo'</select>
											</td>
											<td>
												<input id="submit" type="submit" name="submit" value="verstuur" />
											</td>
										</tr>
									</table>
								</form>
								';
						}
?>
</div>
						

				</div>
				</div>
<?php			}
		}
	}
?>