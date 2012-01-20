<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");


	
	class ZoekController extends BaseController{
		public function buildPage(){
			echo '<div id="contentcontainer">
				<h2>Zoeken</h2>
				<div id="searchcontainer">
					<br />
					<p>Zoek hier op producten en categorie&euml;n</p>
					<br />
					<form action="?p=result" method="post">
						<table>
							<tr>
								<td>
									Zoekterm: 
								</td>
								<td>
									<input type="text" name="zoekwoord" maxlength="50" />
								</td>
								<td width = "30px">
									&nbsp;
								</td>
								<td>
									Producten<br />
									Categorie&euml;n
								</td>
								<td align = left>
									<input type="checkbox" name="products" /><br />
									<input type="checkbox" name="categories" />
								</td>
							</tr>
							<tr>
								<td colspan ="3" >
									&nbsp;
								</td>
								<td colspan ="2" align = center>
									<input id="submit" type="submit" name="submit" value="Zoek" />
								</td>
							</tr>
						</table>
					</form>
					<br />
				</div>
			</div>';
		}
	}	
?>