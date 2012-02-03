<?php
//Dit bestand kan alleen vanuit de index aangeroepen worden
if(!defined("INDEX"))die("NO INDEX!");


class WinkelwagenController extends BaseController{

	public function buildPage(){
		if (!$this->user->is_member()){
				echo '<span style="color:red;">Je moet ingelogt zijn om deze pagina te kunnen bezichtigen!</span>';
		}
		else{
			//If an option is selected
			if(isset($_GET['action'])){
				$action = $_GET['action'];
				$productid = DB::$db->quote($_GET['id']);
				$res = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
				if($res && $row = $res->fetch()){
					switch ($action){
						case 'add':
							$res4 = DB::$db->query("SELECT amount FROM winkelwagen WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							if($res4 && $row4 = $res4->fetch()){
								if(!($row4 = NULL)){
									break;
								}
							}
							DB::$db->query("INSERT INTO winkelwagen (prod_id, user_id, amount) VALUES (".$productid.", ".$row['id'].", '1')");
							break;
						case 'delete':
							DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = " . $productid . " AND user_id = ".$row['id']."");
							break;
						case 'plus':
							DB::$db->query("UPDATE winkelwagen SET amount = amount + 1 WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							break;
						case 'minus':
							$res3 = DB::$db->query("SELECT amount FROM winkelwagen WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							if($res3 && $row3 = $res3->fetch()){
								if ($row3['amount'] > 1){
									DB::$db->query("UPDATE winkelwagen SET amount = amount - 1 WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
								}
								else{
									DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = " . $productid . " AND user_id = ".$row['id']."");
								}
							}
							break;
					}
				}
			}
			//building the actual page
			//sets up the top of the table
			echo '
				<div id="contentcontainer">
				<h2>Mijn winkelwagen</h2>
				<div id="contentbox">
				<table border="1" cellpadding = "2">
				<tr>
				<th>Product naam</th>
				<th>Auteur</th>
				<th>Uitgever</th>
				<th width="70px">Prijs</th>
				<th width="60px">Aantal</th>
				<th>Aantal aanpassen</th>
				<th>Product verwijderen</th>
				</tr>
			';
			$totalcost = 0;
			$carsize = 0;
			$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
			if($res0 && $row0 = $res0->fetch()){
				$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id =". $row0['id']);
				while($res1 && $row1 = $res1->fetch()){
					//builds up the individual's shopping list
					$res2 = DB::$db->query("SELECT * FROM products where product_id = ".$row1['prod_id']);
					if($res2 && $row2 = $res2->fetch()){
						echo '
							<tr>
							<th>'.$row2['product_name'].'</th>
							<th>'.$row2['author'].'</th>
							<th>'.$row2['publisher'].'</th>
							<th>'.$row2['price'].'</th>
							<th align="center">'.$row1['amount'].'</th>
							<th align="center"><a href="?p=winkelwagen&action=minus&id='.$row2['product_id'].'" onclick="return page_load(\'winkelwagen\', \'action=minus&id='.$row2['product_id'].'\');"><img src="img/minus.png"></a><a href="?p=winkelwagen&action=plus&id='.$row2['product_id'].'"  onclick="return page_load(\'winkelwagen\', \'action=plus&id='.$row2['product_id'].'\');"><img src="img/plus.png"></a></th>
							<th align="center"><a href="?p=winkelwagen&action=delete&id='.$row2['product_id'].'"  onclick="return page_load(\'winkelwagen\', \'action=delete&id='.$row2['product_id'].'\');"><img src="img/garbage.png"> </a></th>
							</tr>
						';
						$totalcost += ($row2['price'] * $row1['amount']);
						$carsize += 1;
					}
				}
			}
			echo '
				<tr style="border-top:2px solid black;">
				<td colspan="3">Totale prijs:</td>
				<th colspan="4">&euro;'.$totalcost.'</th>
				</tr>
				</table>';
				if ($carsize >0){
				echo '<table><tr>
						<td colspan="3" >&nbsp;</td>
						<td colspan="4"><br /><form><input type="button" name="submit" onClick="location.href=\'?p=adressgegevens\'" value="Bestellen" /></form></td>
						</tr>
					</table>';
				}
?>				</div>
				</div>
<?php
		}
	}
}
?>