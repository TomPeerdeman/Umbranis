<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class TestController extends BaseController{
		public function buildPage(){
			echo "<div id=\"testdiv\">Test</div>";
			echo "<a href=\"#\" onclick=\"ajax_init(); return false;\">Init me</a><br />";
			echo "<a href=\"#\" onclick=\"ajax_test(); return false;\">Test me</a><br />";
			echo "<a href=\"#\" onclick=\"return page_load('product', 'id=1');\">Load me</a>";
		}
	}
?>