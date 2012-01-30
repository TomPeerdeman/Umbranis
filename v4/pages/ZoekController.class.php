<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class ZoekController extends BaseController{
		public function buildPage(){
			echo '<div id="contentcontainer">
				<h2>Zoeken</h2>
				<div id="contentbox">
					<br />
					<p>Zoek hier op producten en categorie&euml;n</p>
					<br />
					<form action="?p=result" method="post">
						<table>
							<tr>
								<td>
									Zoekterm: &nbsp;
								</td>
								<td>
									<input type="text" name="zoekwoord" maxlength="50" />&nbsp;&nbsp;
								</td>
								<td>
									Producten<br />
								</td>
								<td>
									<input class="box" type="checkbox" name="products" checked="checked" />
								</td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
								<td>
									Categorie&euml;n&nbsp;
								</td>
								<td>
									<input class="box" type="checkbox" name="categories" checked="checked" />
								</td>
							</tr>
							<tr>
								<td colspan ="2" >
									&nbsp;
								</td>
								<td colspan ="2">
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