<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ProductenController extends BaseController{
		public function buildPage(){
			// x = categories.cat_id
			$x = DB::$db->quote($_GET["cat"]);
			echo '<div id="contentcontainer">';	
			$res = DB::$db->query("SELECT * FROM categories where cat_id = " . $x);
			while($row = $res->fetch()){
				echo "<h2>";
				echo $row['cat_name'];
				$catName = $row['cat_name'];
				$parent = $row['parent_id'];
				echo "</h2>";
			}
			// nieuwe producten van de afgelopen  maand, lijkt me niet dat je 
			// dingen van een jaar oud hier wilt zien
			if (isset($_GET['spec']) && $_GET['spec'] == 'new'){
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									AND date >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH)");
				echo "<br /><br /><table style=\"margin-left:auto;margin-right:auto \" ><tr><th>Nieuw in de winkel:</th></tr></table>";
				$subcat="nieuw (in de afgelopen maand).";
			}

			elseif (isset($_GET['spec']) && $_GET['spec'] == 'action'){
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									AND price < normal_price ");
				echo "<br /><br /><table style=\"margin-left:auto;margin-right:auto \" ><tr><th>Aanbiedingen:</th></tr></table>";
				$subcat="aanbiedingen.";
			}
			else{
				$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id, normal_price
									FROM products
									WHERE cat_id = " . $x ."
									ORDER BY product_name");
			}
			$teller = 0;
			echo "<table><tr>";
			while($row = $res2->fetch())
			{
				echo "<td>
					<div class='small'>
						<table width='240px'>
							<tr>
								<td style=\"width: 170px; height: 150px;\">";
								
								echo "<a href=\"?p=product&amp;id=" . $row['product_id'] . "\">";
								echo "<img src= 'img/thumbs/" . $row['image_path'] . "' alt='" . $row['product_name'] . "' style=\"max-width: 170px; max-height: 150px; margin-left: auto; margin-right: auto;\" />
									</a>
								</td>
								<td>
									CD-DVD<br />
									<br />";
									 //oude prijs in rood + doorstrepen en nieuwe prijs in groen
									if ($row['price'] < $row['normal_price']){ 
										echo "<span style=\"color: red;\" ><s>&euro;" . $this->price($row['normal_price']) . "</s></span>";
										echo "<br /><span style=\"color: green;\" > &euro;" . $this->price($row['price']) . "</span>";
									}
									
									 else {
										echo "<br />&euro;" . $this->price($row['price']);
									 }
								echo "</td>
							</tr>
							<tr>
								<td>";
									echo "<a href=\"?p=product&amp;id=" . $row['product_id'] . "\">";
									echo $row['product_name'];								
									echo "</a>
								</td>
							</tr>
						</table>
					</div>
				</td>";
				// maak rijen van 3; meer past niet
				$teller++;
				if ($teller%3==0)
					echo "</tr><tr>";
				}
				echo "</tr></table>";
				//melding als er niets in de database is
				if ($teller==0){
					$res = DB::$db->query("SELECT cat_name FROM categories where cat_id = " . $parent);
					while($row = $res->fetch()){
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