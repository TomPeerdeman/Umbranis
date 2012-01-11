<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Umbranis webshop b&egrave;ta</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<div id="header"><h1>Header</h1></div>
			<div id="tabs"><strong>Tabs</strong></div>
			<div id="cats"><strong>Categorie&euml;n</strong></div>
			<div id="content">
				<h2>Inhoud</h2>
				<?php
					if(isset($_GET['n'])){
						for($i = 0; $i < intval($_GET['n']); $i++){
							echo "<br />" . $i;
						}
					}
				?>
				<br /><br /><br />
				<div id="footer"><strong>Footer</strong></div>
			</div>
		</div>
	</body>
</html>
