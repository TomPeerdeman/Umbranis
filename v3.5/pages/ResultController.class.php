<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");


	
	class ResultController extends BaseController{
		public function buildPage(){
			if(!empty($_POST["products"])){
				$product_check = $_POST["products"];
			}
			else{
				$product_check = 'off';
			}
			if(!empty($_POST["categories"])){
				$cat_check = $_POST["categories"];
			}			
			else{
				$cat_check = 'off';
			}
			$x = $_POST['zoekwoord'];
			if (!$x){
				echo '<div id="contentcontainer">
							<div id="resultcontainer">
							<br /><p>Er is geen zoekterm ingevuld.</p>
								<br />
							</div>
						</div>';
			}
			else{
				if($product_check == 'on'){
					$res = DB::$db->query("SELECT * FROM products WHERE product_name LIKE '%".$x."%' OR publisher LIKE '%".$x."%' OR author LIKE '%".$x."%'");
					$num_res = $res->rowCount();
				}
				else{
					$num_res = 0;
				}
				if($cat_check == 'on'){
					$res2 = DB::$db->query("SELECT * FROM categories WHERE cat_name LIKE '%".$x."%'");
					$num_res2 = $res2->rowCount();
				}
				else{
					$num_res2 = 0;
				}
			$num_total = $num_res + $num_res2;
			echo '<div id="contentcontainer">
					<div id="resultcontainer">
					<br />';
			if($num_total == 0){
				echo '<p>Er zijn helaas geen zoekresultaten gevonden</p><br />';
			}
			else{
				echo "<b>Er zijn ".$num_total." resultaten gevonden op de zoekterm:</b> ' ".$x." '<br /><br />";
			}
			if($num_res > 0){
				echo '<table width = "720px">
						<tr>
							<td width = "200px">
								<b>Producten</b>
							</td>
							<td width = "70px">
								<b>Prijs</b>
							</td>
							<td width = "100px">
								<b>Categorie</b>
							</td>
							<td width = "175px">
								<b>Uitgever</b>
							</td>
							<td width = "175px">
								<b>Schrijver</b>
							</td>
						</tr>';
				for ($i=0; $i <$num_res; $i++){
					$num_found = $i + 1;
					$row = $res->fetch(PDO::FETCH_ASSOC);
					$cat = DB::$db->query("SELECT cat_name FROM categories WHERE cat_id = '".($row['cat_id'])."'");
					$catname = $cat->fetch(PDO::FETCH_ASSOC);
					echo "<tr>
							<td><a href=?p=product&amp;id=" .($row['product_id']). ">".($row['product_name'])."</a></td>
							<td>&euro;".($row['normal_price'])."</td>
							<td>".($catname['cat_name'])."</td>
							<td>".($row['publisher'])."</td>
							<td>".($row['author'])."</td>
						</tr>";
				}
				echo '</table><br />';
			}
			if($num_res2 > 0){
				echo '<table width = "700px">
						<tr>
							<td>
								<b>Categorie</b>
							</td>
						</tr>';
				for ($i=$num_res; $i <$num_total; $i++){
					$num_found = $i + 1;
					$row = $res2->fetch(PDO::FETCH_ASSOC);
					if(($row['cat_id']) < 4){
						echo "<tr>
								<td><a href=?p=categorie&amp;cat=" .($row['cat_id']). ">".($row['cat_name'])."</a>
								</td>
							</tr>";
					}
					else{
						echo "<tr>
								<td><a href=?p=producten&amp;cat=" .($row['cat_id']). ">".($row['cat_name'])."</a>
								</td>
							</tr>";
					}
					
				}
				echo '</table><br />';
			}
			echo '</div>
			</div>';
			}
		}
	}	
?>