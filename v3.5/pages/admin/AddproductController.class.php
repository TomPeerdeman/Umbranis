<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AddproductController extends BaseController{
		private $errors = array();
		private $posted = false;
		
		public function handleForm(){
			if(!isset($_POST['product_name']) || empty($_POST['product_name'])){
				$this->errors[] = "U heeft geen productnaam ingevoerd!";
			}
			if(!isset($_POST['normal_price']) || empty($_POST['normal_price'])){
				$this->errors[] = "U heeft geen prijs ingevoerd!";
			}
			if(!isset($_POST['price']) || empty($_POST['price'])){
				$this->errors[] = "U heeft geen aanbieding prijs ingevoerd!
					Is er geen aanbeiding vul dan hetzelfde bedrag in als bij de normale prijs";
			}			
			if(!isset($_POST['stock']) || empty($_POST['stock'])){
				$this->errors[] = "U heeft geen voorraad ingevoerd!";
			}


			
			$res = DB::$db->query("SELECT * FROM products WHERE product_name=" . DB::$db->quote($_POST['product_name']) . "");
			if($res->rowCount() > 0){
				$this->errors[] = "Er is al een product met deze naam!";
			}

			$res = DB::$db->query("SELECT * FROM products WHERE ean_code=" . DB::$db->quote($_POST['ean_code']) . "");
			if($res->rowCount() > 0){
				$this->errors[] = "Er is al een product met deze EAN-code!";
			}	

				
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
					
			$this->posted = true;
		}
		
		private function valueLoad($item){
			if($this->posted && count($this->errors) == 0){
				return;
			}
		}
		
		private function escape($item){
			if(isset($_POST[$item])){
				if($item != "ean_code" && $item != "product_name"){
					return DB::$db->quote(ucfirst($_POST[$item]));
				}else{
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
	<div id="registercontainer">
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
		<form action="#" method="post">
			<table>
				<tr>
					<td>
						Categorie:
					</td>
					<td>
						<select name="cat_id" size="1">
							<option value="5" selected="selected">Jazz</option>
							<option value="6">Blues</option>
							<option value="7">Disco</option>
							<option value="8">Death Metal</option>
							<option value="9">Horror</option>
							<option value="10">Actie</option>
							<option value="11">Alternative</option>
							<option value="12">Scifi</option>
							<option value="13">PC</option>
							<option value="14">Xbox 360</option>
							<option value="15">PS3</option>
							<option value="16">Wii</option>
							<option value="17">Suspense</option>
							<option value="18">Roman</option>
							<option value="19">Non-Fiction</option>
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
						<input type="text" name="price" maxlength="25" value="<?php $this->valueLoad('price'); ?>" />*
					</td>
				</tr>
				<tr>
				<tr>
					<td>
						Voorraad:
					</td>
					<td>
						<input type="text" name="stock" maxlength="25" value="<?php $this->valueLoad('stock'); ?>" />*
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
						<input type="text" name="ean_code" value="<?php $this->valueLoad('ean_code'); ?>"/>
					</td>
				</tr>
			
				<tr>
					<td>&nbsp;</td>
					<td>
						<input id="submit" type="submit" name="submit" value="Registreer" />
					</td>
				</tr>
			</table>
		</form>
		<br />
	</div>
</div>
<?php
		}
	}
?>