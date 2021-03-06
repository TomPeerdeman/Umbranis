<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AddproductController extends AdminBaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			if(!isset($_POST['product_name']) || empty($_POST['product_name'])){
				$this->errors[] = "U heeft geen productnaam ingevoerd!";
			}
			if(!isset($_POST['normal_price']) || empty($_POST['normal_price'])){
				$this->errors[] = "U heeft geen prijs ingevoerd!";
			}
			if((!isset($_POST['price']) || empty($_POST['price'])) && isset($_POST['normal_price']) && !empty($_POST['normal_price'])){
				//Prijs = normale prijs
				$_POST['price'] = $_POST['normal_price'];
			}else if(!isset($_POST['price']) || empty($_POST['price'])){
				//Prijs en normale prijs niet gezet
				$this->errors[] = "U heeft geen aanbieding prijs ingevoerd!
					Is er geen aanbeiding vul dan alleen een bedrag bij normale prijs in.";
			}
			
			if(!isset($_POST['ean_code']) || empty($_POST['ean_code'])){
				$this->errors[] = "U heeft geen EAN-code ingevoerd!";
			}


			$res = DB::$db->query("SELECT * FROM products WHERE ean_code=" . DB::$db->quote($_POST['ean_code']) . "");
			if($res->rowCount() > 0){
				$this->errors[] = "Er is al een product met deze EAN-code!";
			}	

			if(count($this->errors) == 0){				
				DB::$db->query("INSERT INTO products (cat_id, product_name, normal_price, price, stock, delivery_time, publisher, author, image_path, description, ean_code)
					VALUES (
						" . $this->escape('cat_id') . ", 
						" . $this->escape('product_name') . ", 
						" . $this->escape('normal_price') . ",
						" . $this->escape('price') . ",
						" . $this->escape('stock') . ",
						" . $this->escape('delivery_time') . ",
						" . $this->escape('publisher') . ",
						" . $this->escape('author') . ",
						" . $this->escape('image_path') . ",
						" . $this->escape('description') . ",
						" . $this->escape('ean_code') . "
					)");
			}
			$this->posted = true;
		}
		
		private function valueLoad($item){
			if($this->posted && count($this->errors) == 0){
				return;
			}
			else{
				echo (isset($_POST[$item])) ? $_POST[$item] : "";
			}
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
					elseif($item == "stock" && empty($_POST[$item])){
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
	
		public function buildPage(){
			
?>
<div id="contentcontainer">
	<h2>Product Toevoegen</h2>
	<div id="contentboxsmall">
		<p>U kunt hier een nieuw product aanmaken.<br />Velden met een * zijn verplicht om in te vullen.</p>
		<br />
<?php
			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">Het product kon niet worden toegevoegd:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span></p>";
					echo "<br />";
				}else{
					echo "<p><span style=\"color: green;\">Uw product is toegevoegd.</span></p><br />";
				}
			}
?>
		<form action="?p=admin/addproduct" method="post">
			<table>
				<tr>
					<td>
						Categorie:
					</td>
					<td>
				<select name="cat_id" size="1">		
<?php
$res = DB::$db->query("SELECT * FROM categories WHERE cat_id > 4");
	while($row = $res->fetch()){
		echo "<option value=" . $row['cat_id'] . ">" . $row['cat_name'] . "</option>";
	}								
?>
					</select>*
							
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						Productnaam:
					</td>
					<td>
						<input type="text" name="product_name" value="<?php $this->valueLoad('product_name'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Prijs:
					</td>
					<td>
						<input type="text" name="normal_price" maxlength="25" value="<?php $this->valueLoad('normal_price'); ?>" />*
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						Aanbiedingprijs:
					</td>
					<td>
						<input type="text" name="price" maxlength="25" value="<?php $this->valueLoad('price'); ?>" />
					</td>
				</tr>
				<tr>
				<tr>
					<td>
						Voorraad:
					</td>
					<td>
						<input type="text" name="stock" maxlength="25" value="<?php $this->valueLoad('stock'); ?>" />
					</td>
				</tr>
				<tr>
				<tr>
					<td>
						Bezorgtijd:
					</td>
					<td>
						<input type="text" name="delivery_time" maxlength="25" value="<?php $this->valueLoad('delivery_time'); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Uitgever:
					</td>
					<td>
						<input type="text" name="publisher" maxlength="25" value="<?php $this->valueLoad('publisher'); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Auteur:
					</td>
					<td>
						<input type="text" name="author" maxlength="25" value="<?php $this->valueLoad('author'); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Afbeeldinglocatie:
					</td>
					<td>
						<input type="text" name="image_path" value="<?php $this->valueLoad('image_path'); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Omschrijving:
					</td>
					<td>
						<input type="text" name="description" value="<?php $this->valueLoad('decription'); ?>" style="height:30px;" />
					</td>
				</tr>				
				<tr>
					<td>
						EAN-code:
					</td>
					<td>
						<input type="text" name="ean_code" value="<?php $this->valueLoad('ean_code'); ?>"/>*
					</td>
				</tr>
			
				<tr>
					<td>&nbsp;</td>
					<td>
						<input class="submit" type="submit" name="submit" value="Voeg toe" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php
		}
	}
?>