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
							<img src="img/' . $row['image_path'] . '" alt="' . $row['product_name'] . '" />
						</div>
						<div id="descriptioncontainer">
							<strong>' . $row['product_name'] . '</strong><br />
							
							*game beschrijving* <br /><br />' .
							/* TODO kolom in db voor de beschrijving?
							Het koninkrijk Tamriel staat in de role playing game The Elder Scrolls V: Skyrim op instorten. De High King of Skyrim is vermoord, diverse allianties azen op de troon en een eeuwenoud gevleugeld gevaar laat van zich horen. Draken zijn teruggekeerd naar Tamriel en terroriseren het land. Vrezend voor hun leven heeft het volk zijn hoop gevestigd op Dragonborn, een held geboren met de kracht van The Voice die als enige stand kan houden tegen deze vliegende monsters.
							<br /><br /><strong>Kies je eigen pad, maak je eigen keuzes</strong><br />
							Fans van deze razend populaire RPG-franchise weten al lang wat ze mogen verwachten van The Elder Scrolls V: Skyrim. Een enorme open wereld waarin alles mogelijk is. Stap in de schoenen van de zelf samen te stellen krijger Dragonborn en doe wat je wilt. Verken de ruige landschappen van Tamriel, reis van stad naar stad en verzamel een schat aan wapens, spreuken en vaardigheden. Ontwikkel je personage, steel de magische krachten van de draken en druk voor eens en altijd een stempel op het koninkrijk.
							<br /><br /><strong>Ook verkrijgbaar voor</strong><br />
							Playstation 3, Xbox 360<br /><br />  */ '
						</div>
					</div>
				</div>';
			}
		}
	}
?>

