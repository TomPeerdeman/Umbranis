<?php
	if(isset($_GET['p'])){
		$page = str_replace("/", "", $_GET['p']);
		echo ((file_exists("style/" . $page . ".css")) ? file_get_contents("style/" . $page . ".css") . "," : "false,") . ((file_exists("javascript/" . $page . ".js")) ? "true" : "false");
	}else{
		echo "false,false";
	}
?>