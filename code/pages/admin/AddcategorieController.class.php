<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AddcategorieController extends AdminBaseController{
		private $errors = array();
		private $posted = false;
		private $check = true;
		private $saveid;
		
		public function handleForm(){
			if(!isset($_POST['cat_name']) || empty($_POST['cat_name'])){
				$this->errors[] = "U heeft geen categorie naam ingevoerd!";
				$this->check = false;
			}
			if($this->check){
				$res = DB::$db->query("SELECT * FROM categories WHERE cat_name=" . DB::$db->quote($_POST['cat_name']) . "");
				if($res->rowCount() > 0){
					$this->errors[] = "Er is al een categorie met deze naam!";
				}
			}
			if(count($this->errors) == 0){
				$res = DB::$db->query("SELECT * FROM categories WHERE cat_id =" . DB::$db->quote($_POST['cat_id']). "");
				$row = $res->fetch();
				$this->saveid = $row['cat_id'];
				DB::$db->query("INSERT INTO categories (parent_id, cat_name, image_path)
					VALUES (
						" . $row['cat_id'] . ",
						" . $this->escape('cat_name') . ", 
						" . $this->escape('image_path') . "
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
				if($item == "image_path" && empty($_POST[$item])){
					//muziek
					if($this->saveid == 1)
						return DB::$db->quote("muziek.png");
					//film
					elseif($this->saveid == 2)
						return DB::$db->quote("film.png");
					//games
					elseif($this->saveid == 3)
						return DB::$db->quote("no_image.png");
					//boek
					else
						return DB::$db->quote("boek.png");
				}else{
					return DB::$db->quote(ucfirst($_POST[$item]));
					}
			}else{
				return "''";
			}
		}
	
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Categorie Toevoegen</h2>
	<div id="contentboxsmall">
		<p>U kunt hier een nieuw categorie aanmaken.<br />Velden met een * zijn verplicht om in te vullen.</p>
		<br />
<?php
			if($this->posted){
				if(count($this->errors) > 0){
					echo "<p><span style=\"color: red;\">De categorie kon niet worden toegevoegd:<br />";
					foreach($this->errors as $error){
						echo $error . "<br />";
					}
					echo "</span></p>";
					echo "<br />";
				}else{
					echo "<p><span style=\"color: green;\">Uw categorie is toegevoegd.</span></p><br />";
				}
			}
?>
		<form action="?p=admin/addcategorie" method="post">
			<table>
				<tr>
					<td>
						Categorie:
					</td>
					<td>
						<select name="cat_id" size="1">
							<option value="1" selected="selected">Muziek</option>
							<option value="2">Films</option>
							<option value="3">Games</option>
							<option value="4">Boeken</option>
						</select>*
							
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						Categorie naam:
					</td>
					<td>
						<input type="text" name="cat_name" value="<?php $this->valueLoad('cat_name'); ?>" />*
					</td>
				</tr>
				<tr>
					<td>
						Afbeeldinglocatie: &nbsp;
					</td>
					<td>
						<input type="text" name="image_path" value="<?php $this->valueLoad('image_path'); ?>" />
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