<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ProductController extends BaseController{
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
							echo'<a href="?p=admin/updateproduct&amp;id=' . $row['product_id'] . '">
								Product bewerken</a>
								<br />';
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
						</div>
					</div>
				</div>';
			}
		}
	}
?>

