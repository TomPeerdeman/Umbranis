<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class VerwijderproductController extends BaseController{
		private $posted = false;
		private $ja = array();
		private $nee = array();
		public function buildPage(){
			//get product id
			$x= DB::$db->quote($_GET["id"]);
			echo '<div id="contentcontainer">';
			$res = DB::$db->query("SELECT * FROM products where product_id = $x");

			while($row = $res->fetch()){
				if($this->user->is_member() && $this->user->is_admin()){
					if($this->posted){
						echo '<div class="klantcontact">';
						if(count($this->ja) > 0){
							
							DB::$db->query("DELETE FROM products WHERE product_id ='".$_GET["id"]."'");
							echo "<p>Het product is verwijderd.<br />";
							foreach($this->ja as $ja){
								echo $ja . "<br />";
							}
							echo "</p>";
							echo "<br />";
						}
						elseif(count($this->nee) > 0){
							foreach($this->nee as $nee){
								echo $nee . "<br />";
							}
							echo "</p>";
							echo "<br />";
						}
						echo "</div></div>";
					}
					else{
						echo "<h2>";
						echo $row['product_name'];
						echo "</h2>";
						echo '<div id="productbox">';
							echo'<div id="propertiescontainer">
								<div class="shadow">
									<div id="propertiesbox">
										<table>
											<tr>
												<td class="even">Artikelnummer</td>
												<td class="even">' . $row['product_id'] . '</td>
											</tr>
											<tr>
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
								<img src="img/' . $row['image_path'] . '" alt="' . $row['product_name'] . '" />
							</div>
							<div id="descriptioncontainer">
								Weet u zeker dat u het product: <strong>' . $row['product_name'] . '</strong> wilt verwijderen?
								<br /><br />
								<form action="#" method="post">
									<table>
										<tr>
											<td width = "200px" align = "center">
												<input id="submit" type="submit" name="ja" value="ja" />
											</td>
											<td width = "200px" align = "center">
												<input id="submit" type="submit" name="nee" value="nee" />
											</td>
										</tr>
									</table>
								</form>
								<br />
							</div>
						</div>
					</div>';
					}
				}
				else{
					echo "<p>U wordt automatisch teruggestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=product&amp;id=" .$_GET["id"]. "\">hier</a>.</p>";
					echo "<meta http-equiv=\"refresh\" content=\"2;url=?p=product&amp;id=" .$_GET["id"]. "\" /></p>";
				}
			}
		}
		
		public function handleForm(){
			if(isset($_POST['ja'])){
				$this->ja[] = "<p>U wordt automatisch teruggestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=home\">hier</a>.</p>";
				$this->ja[] = "<meta http-equiv=\"refresh\" content=\"2;url=?p=home\" /></p>";
			}
			elseif(isset($_POST['nee'])){
				$this->nee[] = "<p>U wordt automatisch teruggestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=product&amp;id=" .$_GET["id"]. "\">hier</a>.</p>";
				$this->nee[] = "<meta http-equiv=\"refresh\" content=\"2;url=?p=product&amp;id=" .$_GET["id"]. "\" /></p>";
			}
				
			$this->posted = true;
		}
	}
?>

