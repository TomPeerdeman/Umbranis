<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Umbranis webshop b&egrave;ta versie 3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style/base.css" type="text/css" />
	<link rel="stylesheet" href="style/menu.css" type="text/css" />
	<link rel="stylesheet" href="style/zoek.css" type="text/css" />
	<link rel="stylesheet" href="style/login.css" type="text/css" />
	<link rel="stylesheet" href="style/categorie.css" type="text/css" />
	<link rel="stylesheet" href="style/contact.css" type="text/css" />
</head>
<body>
	<div id="container">
		<div id="header"><h1>Umbranis webshop b&egrave;ta versie 3</h1></div>
		<div id="menu">
			<?php include("basis/menu.html"); ?>
		</div>		
		<div id="content">
			<div id="topsales"><?php include("basis/top_sales.html"); ?></div>
			<div id="maincontent">
				<?php
					//als er geen ?p=.. is of er is geen pagina aangegeven dan home 
					if(!isset($_GET['p']) || $_GET['p'] == ""){ 
				?>
				<h2>Home</h2>
				<?php
					}else{
						//bestand laden wat achter ?p= staat
						include($_GET['p']);
					}
				?>
			</div>
			<br />
			<br />
			<br />
			<div id="contentclear"></div>
		</div>
		<div id="loginbox">
			<?php include("basis/loginbox.html"); ?>
		</div>
		<div id="footer">
			<?php include("basis/footer.html"); ?>
		</div>
	</div>
</body>
</html>