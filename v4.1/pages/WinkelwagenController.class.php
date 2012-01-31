<?php
//Dit bestand kan alleen vanuit de index aangeroepen worden
if(!defined("INDEX"))die("NO INDEX!");


class WinkelwagenController extends BaseController{

	public function buildPage(){
		$totalcost = 0;
		//If an option is selected
		if(isset($_get['action'])){
			$action = $_get['action'];
			$productid = $_get['id'];
			$res = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
			while($res && $row = $res->fetch()){
				switch ($action){
				case 'add':
					DB::$db->query("INSERT INTO winkelwagen VALUES (".$productid.", ".$row['id'].", '1')");
					break;
				case 'delete':
					DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = '$productid' AND user_id = ".$row['id']."");
					break;
				case 'plus':
					DB::$db->query("UPDATE winkelwagen SET amount += 1 WHERE user_id = ".$row['id']." AND prod_id = '$productid'");
					break;
				case 'minus':
					DB::$db->query("UPDATE winkelwagen SET amount -= 1 WHERE user_id = ".$row['id']." AND prod_id = '$productid'");
					break;
				}
			}
		}
		//building the actual page
		//sets up the top of the table
		echo '
			<table border="1" cellpadding = "2">
			<tr>
			<th>Product name</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Price</th>
			<th>Amount</th>
			<th></th>
			</tr>
		';
		$res0 = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
		while($res0 && $row0 = $res0->fetch()){
			$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id =". $row0['id']. "");
			while($res1 && $row1 = $res1->fetch()){
				//builds up the individual's shopping list
				$res2 = DB::$db->query("SELECT * FROM products where product_id = ".$row1['prod_id']."");
				while($res2 && $row2 = $res2->fetch()){
					echo '
						<tr>
						<th>'.$row2['product_name'].'</th>
						<th>'.$row2['author'].'</th>
						<th>'.$row2['publisher'].'</th>
						<th>'.$row2['price'].'</th>
						<th>'.$row1['amount'].'</th>
						<th><a href="?p=winkelwagen&action=minus&id='.$row2['product_id'].'"><img src="img/minus.png"></a><a href="?p=winkelwagen&action=plus&id='.$row2['product_id'].'"><img src="img/plus.png"></a></th>
						</tr>
					';
					$totalcost += ($row2['price'] * $row1['amount']);
				}
			}
		}
		echo '
			<td colspan="5">Total price:</td>
			<th>&euro;'.$totalcost.'</th>
			</table>
		';
	}
}
?>