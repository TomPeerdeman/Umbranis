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
				echo "</h2>";
			}
			
			$res2 = DB::$db->query("SELECT products.image_path, product_name, price, product_id
									FROM products
									WHERE cat_id = " . $x);
			$teller = 0;
			echo "<table><tr>";
			while($row = $res2->fetch())
			{
				$imgPath = $row['image_path'];
				echo "<td>
					<div class='small'>
						<table width='240px'>
							<tr>
								<td>";
								
								echo "<a href=\"?p=product&amp;id=" . $row['product_id'] . "\">";
								echo "<img src= '$imgPath' alt='generic' width='170px' height='150px' align='left' />
									</a>
								</td>
								<td>
									CD-DVD<br />
									<br />
									<br />";
									echo "&euro;" . $row['price'];
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
			echo "</div>";
		
		}
	}
?>