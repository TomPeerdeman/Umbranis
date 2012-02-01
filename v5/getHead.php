<?php
	if(isset($_GET['p'])){
		$page = str_replace("/", "", $_GET['p']);
		echo ((file_exists("style/" . $page . ".css")) ? "true," : "false,") . ((file_exists("javascript/" . $page . ".js")) ? "true" : "false");
	}else{
		echo "false,false";
	}
?>