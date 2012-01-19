<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class TestController extends BaseController{
		public function buildPage(){
			echo "<p>Hello world!</p>";
			$res = DB::$db->query("SELECT COUNT(*) AS num FROM categories WHERE parent_id != 0");
			$row = $res->fetch();
			echo "<p>Number of subcategories: " . $row['num'] . "</p>";
		}
	}
?>