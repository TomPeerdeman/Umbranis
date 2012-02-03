<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class UpdateproductController extends AdminBaseController{
		private $posted = false;
		private $errors = array();
		private $showform = true;

		public function handleForm(){
			if(!isset($_POST['product_name']) || empty($_POST['product_name'])){
				$this->errors[] = "U heeft geen productnaam ingevoerd!";
			}
			if(!isset($_POST['normal_price']) || empty($_POST['normal_price'])){
				$this->errors[] = "U heeft geen prijs ingevoerd!";
			}
			if(!isset($_POST['price']) || empty($_POST['price'])){
				$this->errors[] = "U heeft geen aanbieding prijs ingevoerd!<br />
					Is er geen aanbieding vul dan hetzelfde bedrag in als bij de normale prijs";
			}
			if(!isset($_POST['ean_code']) || empty($_POST['ean_code'])){
				$this->errors[] = "U heeft geen EAN-code ingevoerd!";
			}
			$res = DB::$db->query("SELECT * FROM products WHERE ean_code=" . DB::$db->quote($_POST['ean_code']) . "");
			if($res->rowCount() > 0){
				$row = $res->fetch();
				if($res->rowCount() == 1 && $_GET['id'] != $row['product_id']){
					$this->errors[] = "Er is al een product met deze EAN-code!";
				}
				if($res->rowCount() > 1){
					$this->errors[] = "Er is al een product met deze EAN-code!";
				}
			}	
			
			if(count($this->errors) == 0){
				DB::$db->query("UPDATE products SET
						cat_id =" . $this->escape('cat_id') . ", 
						product_name =" . $this->escape('product_name') . ", 
						normal_price =" . $this->escape('normal_price') . ",
						price =" . $this->escape('price') . ",
						stock =" . $this->escape('stock') . ",
						delivery_time =" . $this->escape('delivery_time') . ",
						publisher =" . $this->escape('publisher') . ",
						author =" . $this->escape('author') . ",
						image_path =" . $this->escape('image_path') . ",
						description =" . $this->escape('description') . ",
						ean_code =" . $this->escape('ean_code') . "
						WHERE product_id =" . DB::$db->quote($_GET['id']) . "
					");
					$this->showform = false;
			}
			$this->posted = true;
		}
		
		private function escape($item){
			if(isset($_POST[$item])){
				if($item != "ean_code" && $item != "product_name"){
					if($item == "image_path" && empty($_POST[$item])){
						return DB::$db->quote("no_image.png");
					}
					elseif($item == "publisher" && empty($_POST[$item])){
						return DB::$db->quote("Onbekend");
					}
					elseif($item == "author" && empty($_POST[$item])){
						return DB::$db->quote("Onbekend");
					}
					elseif($item == "delivery_time" && empty($_POST[$item])){
						return DB::$db->quote("0");
					}
					elseif($item == "description" && empty($_POST[$item])){
						return DB::$db->quote("Geen beschrijving beschikbaar");
					}
					else{
						return DB::$db->quote(ucfirst($_POST[$item]));
					}
				}
				else{
					return DB::$db->quote($_POST[$item]);
				}
			}else{
				return "''";
			}
		}

		private function valueLoad($item){
		$res = DB::$db->query("SELECT * FROM products WHERE product_id =" .DB::$db->quote($_GET["id"]) . "");
		$row = $res->fetch();
			//if($this->posted && count($this->errors) == 0){
				//return;
			//}
			if($item == "cat_id"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['cat_id'];
			}
			if($item == "product_name"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['product_name'];
			}
			if($item == "normal_price"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['normal_price'];
			}
			if($item == "price"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['price'];
			}
			if($item == "stock"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['stock'];
			}
			if($item == "delivery_time"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['delivery_time'];
			}
			if($item == "publisher"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['publisher'];
			}
			if($item == "author"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['author'];
			}
			if($item == "image_path"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['image_path'];
			}
			if($item == "description"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['description'];
			}
			if($item == "ean_code"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['ean_code'];
			}
		}

		
		
		public function buildPage(){

?>
			<div id="contentcontainer">
				<h2>Product Gegevens</h2>
				<div id="contentboxsmall"><br />
				<?php
			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">De gegevens konden niet gewijzigd worden:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span></p>";
					echo "<br />";
				}
				if(count($this->errors) == 0){
					echo "<p><span style=\"color: green;\">Uw gegevens zijn gewijzigd.</span></p><br />";
					echo '<p>U wordt automatisch doorgestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=product&amp;id=' .$_GET["id"]. '\">hier</a>.</p>';
					echo "<meta http-equiv=\"refresh\" content=\"2;url=?p=product&amp;id=" .$_GET["id"]. "\" /></p>";
				}
			}
			if($this->showform){
				$res = DB::$db->query("SELECT * FROM products WHERE product_id =" . DB::$db->quote($_GET['id']) . "");
				if(($res->rowCount() == 1)) {
					$row = $res->fetch();

							echo'<form action="?p=admin/updateproduct&amp;id=' .$_GET["id"]. '" method="post">
								<table>
									<tr>
										<td>Categorie</td>
										<td>
											<select name="cat_id" size="1">';

										$res = DB::$db->query("SELECT * FROM products WHERE product_id =" . DB::$db->quote($_GET['id']) . "");
										$row = $res->fetch();
										$y = $row['cat_id'];
										$res = DB::$db->query("SELECT * FROM categories WHERE cat_id > 4");
										while($row = $res->fetch()){
											if($row['cat_id'] == $y){
												echo "<option value=" . $row['cat_id'] . " selected='selected'>" . $row['cat_name'] . "</option>";	
											}
											else{
												echo "<option value=" . $row['cat_id'] . ">" . $row['cat_name'] . "</option>";
											}
										}								
?>
											</select>*
										</td>
									</tr>
									<tr>
										<td>Product naam:</td>
										<td><input type="text" name="product_name" value="<?php $this->valueLoad('product_name'); ?>" />*</td>
									</tr>
									<tr>
										<td>Normale prijs:</td>
										<td><input type="text" name="normal_price" value="<?php $this->valueLoad('normal_price');?>" />*</td>
									</tr>
									<tr>
										<td>Aanbieding prijs:&nbsp;</td>
										<td><input type="text" name="price" value="<?php $this->valueLoad('price');?>" />*</td>
									</tr>
									<tr>
										<td>Voorraad:</td>
										<td><input type="text" name="stock" value="<?php $this->valueLoad('stock');?>" /></td>
									</tr>
									<tr>
										<td>Levertijd:</td>
										<td><input type="text" name="delivery_time"  value="<?php $this->valueLoad('delivery_time');?>" /></td>
									</tr>
									<tr>
										<td>Uitgever:</td>
										<td><input type="text" name="publisher" value="<?php $this->valueLoad('publisher');?>" /></td>
									</tr>
									<tr>
										<td>Schrijver:</td>
										<td><input type="text" name="author" value="<?php $this->valueLoad('author');?>" /></td>
									</tr>
									<tr>
										<td>image-path:</td>
										<td><input type="text" name="image_path" value="<?php $this->valueLoad('image_path');?>" /></td>
									</tr>
									<tr>
										<td>Beschrijving:</td>
										<td><input type="text" name="description" value="<?php $this->valueLoad('description');?>" /></td>
									</tr>
									<tr>
										<td>EAN-code:</td>
										<td><input type="text" name="ean_code" value="<?php $this->valueLoad('ean_code');?>" /></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input class="submit" type="submit" name="submit" value="Bevestigen" /></td>
									</tr>
								</table>
							</form>
						</div>
<?php			}
			}
?>
			</div>
<?php	}
	}
?>