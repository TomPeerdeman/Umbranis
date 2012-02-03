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
			$x = addslashes($_POST['zoekwoord']);
			echo '<div id="contentcontainer">
					<h2>Resultaten</h2>
					<div id="contentbox">
						<br />
						<form action="?p=result" method="post">
						<table>
							<tr>
								<td>
									Zoekterm: &nbsp;
								</td>
								<td>
									<input type="text" name="zoekwoord" maxlength="50" />&nbsp;&nbsp;
								</td>
								<td>
									Producten<br />
								</td>
								<td>
									<input class="box" type="checkbox" name="products" checked="checked" />
								</td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
								<td>
									Categorie&euml;n&nbsp;
								</td>
								<td>
									<input class="box" type="checkbox" name="categories" checked="checked" />
								</td>
							</tr>
							<tr>
								<td colspan ="2" >
									&nbsp;
								</td>
								<td colspan ="2">
									<input id="submit" type="submit" name="submit" value="Zoek" />
								</td>
							</tr>
						</table>
					</form><br />';
			if (!$x){
				echo '<p>Er is geen zoekterm ingevuld.</p>
							<br />';
				if ($product_check == 'on' || $cat_check == 'on'){
					echo '</div>
					</div>';
				}
			}
			if ($product_check == 'off' && $cat_check == 'off'){
				echo '<p>Er is niks aangevinkt.</p>
							<br />
						</div>
					</div>';
			}
			if ($x != '' && ($product_check == 'on' || $cat_check == 'on')){
				if($product_check == 'on'){
					$res = DB::$db->query("SELECT * FROM products WHERE product_name LIKE '%".$x."%' OR publisher LIKE '%".$x."%' OR author LIKE '%".$x."%'");	
					if(!$res){
						$num_res = 0;
					}else{
						$num_res = $res->rowCount();
					}
				}
				else{
					$num_res = 0;
				}
				if($cat_check == 'on'){
					$res2 = DB::$db->query("SELECT * FROM categories WHERE cat_name LIKE '%".$x."%'");	
					if(!$res2){
						$num_res2 = 0;
					}else{
						$num_res2 = $res2->rowCount();
					}
				}
				else{
					$num_res2 = 0;
				}
			$num_total = $num_res + $num_res2;
			if($num_total == 0){
				echo '<p>Er zijn helaas geen zoekresultaten gevonden</p><br />';
			}
			else{
				echo "<b>Er zijn ".$num_total." resultaten gevonden op de zoekterm:</b> ' ".$x." '<br /><br />";
			}
			if($num_res > 0){
				echo '<table width="720px">
						<tr>
							<td width="200px">
								<b>Producten</b>
							</td>
							<td width="70px">
								<b>Prijs</b>
							</td>
							<td width="100px">
								<b>Categorie</b>
							</td>
							<td width="175px">
								<b>Uitgever</b>
							</td>
							<td width="175px">
								<b>Schrijver</b>
							</td>
						</tr>';
				for ($i=0; $i <$num_res; $i++){
					$num_found = $i + 1;
					$row = $res->fetch();
					$cat = DB::$db->query("SELECT cat_name FROM categories WHERE cat_id = '".($row['cat_id'])."'");
					if($cat){
						$catname = $cat->fetch();
						echo "<tr>
								<td><a href=?p=product&amp;id=" .($row['product_id']). ">".($row['product_name'])."</a></td>
								<td>&euro;".($row['normal_price'])."</td>
								<td>".($catname['cat_name'])."</td>
								<td>".($row['publisher'])."</td>
								<td>".($row['author'])."</td>
							</tr>";
					}
				}
				echo '</table><br />';
			}
			if($num_res2 > 0){
				echo '<table width="720px">
						<tr>
							<td>
								<b>Categorie</b>
							</td>
						</tr>';
				for ($i=$num_res; $i <$num_total; $i++){
					$num_found = $i + 1;
					$row = $res2->fetch();
					if(($row['parent_id']) == 0){
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