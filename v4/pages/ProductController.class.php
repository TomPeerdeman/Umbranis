<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ProductController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			if(!isset($_POST['message']) || empty($_POST['message'])){
				$this->errors[] = "U heeft geen bericht ingevuld!";
			}
			if(count($this->errors) == 0){	
				$res = DB::$db->query("SELECT * FROM users where user_name = " .$_SESSION['username']. "");
				DB::$db->query("INSERT INTO comment (product_id, rating, message, user_id)
					VALUES (
						'" . $_GET["id"] . "',
						'" . $_POST['rating'] . "',
						'" . $_POST['message'] . "',
						'" . $res['id'] . "'
					)");
			}
			$this->posted = true;
		}
	
		public function buildPage(){
			//get product id
			$x= DB::$db->quote($_GET["id"]);
			echo '<div id="contentcontainer">';
			$res = DB::$db->query("SELECT * FROM products where product_id = $x");

			while($row = $res->fetch()){
				echo "<h2>";
				echo $row['product_name'];
				echo "</h2>";
				echo '<div id="productbox">';
						if($this->user->is_member() && $this->user->is_admin()){
							echo'<table>
								<tr>
									<td width="300px">
										<a href="?p=admin/updateproduct&amp;id=' . $row['product_id'] . '">
											Product bewerken</a>
									</td>
									<td>
										<a href="?p=admin/verwijderproduct&amp;id=' . $row['product_id'] . '">
											Product verwijderen</a>
									</td>
								</tr>
							</table>';
						}
						if($this->posted){
							if(count($this->errors) > 0){
								echo "<p><span style=\"color: red;\">De review kon niet worden toegevoegd:<br />";
								foreach($this->errors as $error){
									echo $error . "<br />";
								}
								echo "</span></p>";
								echo "<br />";
							}
						}
						echo'<div id="propertiescontainer">
							<div class="shadow">
								<div id="propertiesbox">
									<table>
										<tr>
											<td class="even">Artikelnummer</td>
											<td class="even">' . $row['product_id'] . '</td>
										</tr>
										<tr>' . //TODO Type in db? boeken gaan met deze file ook pc-dvd krijgen
											'
											<td class="uneven">Type</td>
											<td class="uneven">PC-DVD</td>
										</tr>
										<tr>
											<td class="even">Voorraad</td>
											<td class="even">' . $row['stock'] . ' stuks</td>
										</tr>
										<tr>
											<td class="uneven">Levertijd</td>
											<td class="uneven">';
												if ($row['stock'] > 0)
													echo '<span style="color: green;">Direct leverbaar</span>';
												else
													echo '<span style="color: red;">Uitverkocht; +- ' . $row['delivery_time'] . ' dagen</span>';
											echo '</td>
										</tr>
										<tr>
											<td class="even">EAN-code</td>
											<td class="even">' . $row['ean_code'] . '</td>
										</tr>
										<tr>
											<td class="uneven">Prijs (incl. BTW)</td>
											<td class="uneven">&euro;' . $this->price($row['price']) . '</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div id="picturecontainer">
							<img src="img/products/' . $row['image_path'] . '" alt="' . $row['product_name'] . '" />
						</div>
						<div id="descriptioncontainer">
							<strong>' . $row['product_name'] . '</strong><br />
							' . ((!empty($row['description'])) ? $row['description'] : "Geen omschrijving.") . '
							<br /><br />
						</div>';

						$res2 = DB::$db->query("SELECT * FROM comment where product_id = $x");
							echo '<h3>Reviews van dit product:</h3><br />
									<table width = "700px">';
							$total = 0;
							$count = 0;
							while($row2 = $res2->fetch()){
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
							while($row2 = $res2->fetch()){
								
								$res3 = DB::$db->query("SELECT * FROM users WHERE id =" . $row2['user_id'] . "");
								$row3 = $res3->fetch();
								echo '
										<tr>
											<td>
												<b>' . $row3['username'] . ' heeft om ' . $row2['time'] . ' gepost:</b>
											</td>
											<td>
												Cijfer: ' . $row2['rating'] . '<br /><br />
											</td>
										</tr>
										<tr>
											<td>
												' . $row2['message'] . '<br /><br />
											</td>
										</tr>';
							}
							
						
						echo'</table><br />';
						if($this->user->is_member()){
							$i = 10;
							echo'
								<form action="#" method="post">
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
				echo'</div>
				</div>';
			}
		}
	}
?>