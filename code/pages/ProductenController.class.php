<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ProductenController extends BaseController{
		public function buildPage(){
			// x = categories.cat_id
			$x = DB::$db->quote($_GET["cat"]);
			echo '<div id="contentcontainer">';	
			$res = DB::$db->query("SELECT * FROM categories where cat_id = " . $x);
			while($res && $row = $res->fetch()){
				echo "<h2>";
				echo $row['cat_name'];
				$catName = $row['cat_name'];
				$parent = $row['parent_id'];
				echo "</h2>";
			}
			echo "<table class=\"nocenter\"><tr>";
			// nieuwe producten van de afgelopen  maand, lijkt me niet dat je 
			// dingen van een jaar oud hier wilt zien
			if (isset($_GET['spec']) && $_GET['spec'] == 'new'){
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									AND date >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH)");
				echo "<td colspan=\"3\"><p><strong>Nieuw in de winkel:</strong></p></td></tr>";
				$subcat="nieuw (in de afgelopen maand).";
			}

			elseif (isset($_GET['spec']) && $_GET['spec'] == 'action'){
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									AND price < normal_price ");
				echo "<td colspan=\"3\"><p><strong>Aanbiedingen:</strong></p></td></tr>";
				$subcat="aanbiedingen.";
			}
			else{
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									ORDER BY product_name");
			}
			$teller = 0;
			$max = $res2->rowCount();
			while($res2 && $row = $res2->fetch())
			{
				echo "<td>
					<div class=\"small\">
						<table>
							<tr>
								<td class=\"image\">";
								
								echo "<a href=\"?p=product&amp;id=" . $row['product_id'] . "\" onclick=\"return page_load('product', 'id=" . $row['product_id'] . "');\">";
								echo "<img src= 'img/products/thumbs/" . $row['image_path'] . "' alt='" . $row['product_name'] . "' style=\"max-width: 170px; max-height: 150px;\" />
									</a>
								</td>
								<td>
									CD-DVD<br />
									<br />";
									 //oude prijs in rood + doorstrepen en nieuwe prijs in groen
									if ($row['price'] < $row['normal_price']){ 
										echo "<span style=\"color: red; text-decoration: line-through;\" >&euro;" . $this->price($row['normal_price']) . "</span>";
										echo "<br /><span style=\"color: green;\" > &euro;" . $this->price($row['price']) . "</span>";
									}
									
									 else {
										echo "<br />&euro;" . $this->price($row['price']);
									 }
								echo "</td>
							</tr>
							<tr>
								<td>";
									echo "<a href=\"?p=product&amp;id=" . $row['product_id'] . "\" onclick=\"return page_load('product', 'id=" . $row['product_id'] . "');\">";
									echo $row['product_name'];								
									echo "</a>
								</td>
							</tr>
						</table>
					</div>
				</td>";
				
				// maak rijen van 3; meer past niet
				$teller++;
				if($teller == $max){
					//Lege kolom(men) aanmaken
					$d = $teller % 3;
					if($d > 0){
						echo "<td>&nbsp;</td>";
					}
					if($d > 1){
						echo "<td>&nbsp;</td>";
					}
				}
				if($teller % 3 == 0  && $res2->rowCount() != $teller)
					echo "</tr><tr>";
				}
				echo "</tr></table>";
				
				//melding als er niets in de database is
				if ($teller==0){
					$res = DB::$db->query("SELECT cat_name FROM categories where cat_id = " . $parent);
					while($res && $row = $res->fetch()){
						$parentName = $row['cat_name'];
					}
				echo "<p style=\"text-align:center\" ><br /><br />
				Niets gevonden in de database onder ". $parentName . " -> " . $catName;
					if (isset($_GET['spec'])){
						echo " -> ". $subcat . "</p>";
					}
				}
			echo "</div>";
		
		}
	}
?>