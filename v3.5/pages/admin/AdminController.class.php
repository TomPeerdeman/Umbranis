<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AdminController extends BaseController{
		public function buildPage(){
		?>
			<div id="contentcontainer">
				<h2>Admin page</h2>
				<div id="admincontainer">
					<br />
					<p><a href="?p=admin/bestellingen">
						Bestellingen overzicht</a>
					<br />
					<br />
					<a href="?p=admin/addproduct">
						Product toevoegen</a>
					<br />
					<br />
					<a href="?p=admin/addcategorie">
						Categorie toevoegen</a>
					<br />
					<br /></p>
				</div>
			</div>
<?php			
		}
	}
?>