<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class MenuController{
		private $cats;
		
		public function __construct(){
			//Alle categorieen selecteren en zetten in een array
			$res = DB::$db->query("SELECT cat_id, parent_id, cat_name FROM categories");
			$this->cats = array();
			while($row = $res->fetch()){
				if($row['parent_id'] == "0"){
					$this->cats[$row['cat_id']] = $row; 
				}else{
					$this->cats[$row['parent_id']]['subcats'][] = $row;
				}
			}
		}
	
		public function buildMenu(){
?>
<ul id="nav">
	<li>
		<a href="?p=home">Home</a>
	</li>
<?php
			foreach($this->cats as $category){
				echo "<li>";
				echo "<a href=\"?p=categorie.php&amp;cat=" . $category['cat_id'] . "\">" . $category['cat_name'] . "</a>";
				echo "<ul>";
				foreach($category['subcats'] as $subcat){
					echo "<li><a href=\"?p=producten&amp;cat=" . $subcat['cat_id'] . "\">" . $subcat['cat_name'] . "</a>";
					echo "<ul>";
					echo "<li><a href=\"?p=producten&amp;cat=" . $subcat['cat_id'] . "\">alle muziek</a></li>";
					echo "<li><a href=\"?p=producten&amp;cat=" . $subcat['cat_id'] . "&amp;spec=new\">nieuwe muziek</a></li>";
					echo "<li><a href=\"?p=producten&amp;cat=" . $subcat['cat_id'] . "&amp;spec=action\">aanbiedingen</a></li>";
					echo "</ul>";
				}
				echo "</ul>";
				echo "</li>";	
			}
?>
	<li>
		<a href="?p=faq">FAQ</a>
	</li>
	<li style="width: 146px;">
		<a style="width: 146px;" href="?p=contact">Contact</a>
	</li>
</ul>
<?php
		}
	}
?>