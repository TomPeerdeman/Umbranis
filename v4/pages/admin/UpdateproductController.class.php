<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class UpdateproductController extends BaseController{
		private $posted = false;
		private $errors = array();
		private $showform = true;

		public function handleForm(){
			if(!isset($_POST['prnaam']) || empty($_POST['prnaam'])){
				$this->errors[] = "U heeft geen productnaam ingevoerd!";
			}
			if(!isset($_POST['normalprice']) || empty($_POST['normalprice'])){
				$this->errors[] = "U heeft geen prijs ingevoerd!";
			}
			if(!isset($_POST['price']) || empty($_POST['price'])){
				$this->errors[] = "U heeft geen aanbieding prijs ingevoerd!
					Is er geen aanbeiding vul dan hetzelfde bedrag in als bij de normale prijs";
			}			
			if(!isset($_POST['stock']) || empty($_POST['stock'])){
				$this->errors[] = "U heeft geen voorraad ingevoerd!";
			}
			if(!isset($_POST['delivery']) || empty($_POST['delivery'])){
				$this->errors[] = "Er is geen bezorgtijd ingevuld!";
			}
			if(!isset($_POST['ean']) || empty($_POST['ean'])){
				$this->errors[] = "U heeft geen EAN-code ingevoerd!";
			}
			if(count($this->errors) == 0){
				DB::$db->query("UPDATE products SET
							cat_id =" . DB::$db->quote($_POST['cat_id']) . ",
							product_name =" . DB::$db->quote($_POST['prnaam']) . ",
							normal_price =" . DB::$db->quote($_POST['normalprice']) . ",
							price =" . DB::$db->quote($_POST['price']) . ",
							stock =" . DB::$db->quote($_POST['stock']) . ",
							delivery_time =" . DB::$db->quote($_POST['delivery']) . ",
							publisher =" . DB::$db->quote($_POST['publisher']) . ",
							author =" . DB::$db->quote($_POST['author']) . ",
							image_path =" . DB::$db->quote($_POST['image']) . ",
							description =" . DB::$db->quote($_POST['description']) . ",
							ean_code =" . DB::$db->quote($_POST['ean']) . "
							WHERE product_id =" . DB::$db->quote($_GET['id']) . "
					");
					$this->showform = false;
			}
			$this->posted = true;
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
			if($item == "prnaam"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['product_name'];
			}
			if($item == "normalprice"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['normal_price'];
			}
			if($item == "price"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['price'];
			}
			if($item == "stock"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['stock'];
			}
			if($item == "delivery"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['delivery_time'];
			}
			if($item == "publisher"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['publisher'];
			}
			if($item == "author"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['author'];
			}
			if($item == "image"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['image_path'];
			}
			if($item == "description"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['description'];
			}
			if($item == "ean"){
				echo (isset($_POST[$item])) ?  $_POST[$item] : $row['ean_code'];
			}
		}

		
		
		public function buildPage(){

?>
			<div id="contentcontainer">
				<h2>Product Gegevens</h2>
				<div class="klantcontact"><br />
				<?php
				if (!$this->user->is_member() && !$this->user->is_admin()){
				
?>
					<span style="color:red;">Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</span>
<?php
				}
				else{
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
							echo "<p>U wordt automatisch doorgestuurd na 2 seconden gebeurt dit niet klik dan <a href=\"?p=product&amp;id=" .$_GET["id"]. "\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"2;url=?p=product&amp;id=" .$_GET["id"]. "\" /></p>";
						}
					}
				if($this->showform){
					$res = DB::$db->query("SELECT * FROM products WHERE product_id =" . DB::$db->quote($_GET['id']) . "");
					if(($res->rowCount() == 1)) {
						$row = $res->fetch();
?>
							<form action="#" method="post">
								<table>
									<tr>
										<td>Categorie</td>
										<td>
											<select name="cat_id" size="1">		
<?php

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
										<td>Product naam</td>
										<td><input type="text" name="prnaam" value="<?php $this->valueLoad('prnaam'); ?>" /></td>
									</tr>
									<tr>
										<td>Normale prijs</td>
										<td><input type="text" name="normalprice" value="<?php $this->valueLoad('normalprice');?>" /></td>
									</tr>
									<tr>
										<td>Aanbieding prijs</td>
										<td><input type="text" name="price" value="<?php $this->valueLoad('price');?>" /></td>
									</tr>
									<tr>
										<td>Voorraad</td>
										<td><input type="text" name="stock" value="<?php $this->valueLoad('stock');?>" /></td>
									</tr>
									<tr>
										<td>Levertijd</td>
										<td><input type="text" name="delivery"  value="<?php $this->valueLoad('delivery');?>" /></td>
									</tr>
									<tr>
										<td>Uitgever</td>
										<td><input type="text" name="publisher" value="<?php $this->valueLoad('publisher');?>" /></td>
									</tr>
									<tr>
										<td>Schrijver</td>
										<td><input type="text" name="author" value="<?php $this->valueLoad('author');?>" /></td>
									</tr>
									<tr>
										<td>Image-path</td>
										<td><input type="text" name="image" value="<?php $this->valueLoad('image');?>" /></td>
									</tr>
									<tr>
										<td>Beschrijving</td>
										<td><input type="text" name="description" value="<?php $this->valueLoad('description');?>" /></td>
									</tr>
									<tr>
										<td>EAN-code</td>
										<td><input type="text" name="ean" value="<?php $this->valueLoad('ean');?>" /></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="submit" value="bevestigen" /></td>
									</tr>
								</table>
							</form><br />
						</div>
<?php				}
				}
			}
?>
			</div>
<?php	}
	}
?>