<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class CategorieController extends BaseController{
		public function buildPage(){
			// x = categories.cat_id
			$x = DB::$db->quote($_GET["cat"]);
			echo '<div id="contentcontainer">';	
			$res = DB::$db->query("SELECT * FROM categories where cat_id = " . $x);
			$row = $res->fetch();
			echo "<h2>";
			echo $row['cat_name'];
			echo "</h2>";
			
			$res2 = DB::$db->query("SELECT cat_id, parent_id, categories.image_path, cat_name
									FROM categories
									WHERE parent_id = " . $x);
			$teller = 0;
			echo "<table><tr>";
			while($row = $res2->fetch())
			{
				echo "<td>
					<div class='category'>";		
								echo "<a href=\"?p=producten&amp;cat=" . $row['cat_id'] . "\">";
								echo "<img src= 'img/cats/" . $row['image_path'] . "' alt='" . $row['cat_name'] . "'/>";
								echo "</a>";
								
								echo "<a href=\"?p=producten&amp;cat=" . $row['cat_id'] . "\">";
								echo $row['cat_name'];								
								echo "</a>
					</div>
				</td>";
				// maak rijen van 2;
				$teller++;
				if ($teller%2==0 && $res2->rowCount() != $teller)
					echo "</tr><tr>";
				}
				echo "</tr></table>";
			echo "</div>";
		
		}
	}
?>