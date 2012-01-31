<?php
//Dit bestand kan alleen vanuit de index aangeroepen worden
if(!defined("INDEX"))die("NO INDEX!");


class WinkelwagenController extends BaseController{

	public function buildPage(){
		
		//If an option is selected
		if(isset($_GET['action'])){
			$action = $_GET['action'];
			$productid = DB::$db->quote($_GET['id']);
			$res = DB::$db->query("SELECT id FROM users WHERE username='".$this->user->username."' LIMIT 1");
			if($res && $row = $res->fetch()){
				$finished = false;
				while(!$finished){
					switch ($action){
						case 'add':
							$res = DB::$db->query("SELECT  * FROM winkelwagen WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							if($res->rowCount() > 0){
								$action = 'plus';
							}else{
								DB::$db->query("INSERT INTO winkelwagen (prod_id, user_id, amount)VALUES (".$productid.", ".$row['id'].", '1')");
								$finished = true;
							}
							break;
						case 'delete':
							DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = " . $productid . " AND user_id = ".$row['id']."");
							$finished = true;
							break;
						case 'plus':
							$res = DB::$db->query("SELECT * FROM winkelwagen WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							if($res->rowCount() > 0){
								DB::$db->query("UPDATE winkelwagen SET amount = amount + 1 WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
								$finished = true;
							}else{
								$action = 'add';
							}
							break;
						case 'minus':
							$res = DB::$db->query("SELECT amount FROM winkelwagen WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
							$arow = $res->fetch();
							if($arow['amount'] > 1){
								DB::$db->query("UPDATE winkelwagen SET amount = amount - 1 WHERE user_id = ".$row['id']." AND prod_id = " . $productid);
								$finished = true;
							}else{
								$action = 'delete';
							}
							break;
					}
				}
			}
		}
		//building the actual page
		//sets up the top of the table
		echo '
			<table border="1" cellpadding = "2">
			<tr>
			<th></th>
			<th>Product name</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Price</th>
			<th>Amount</th>
			<th></th>
			</tr>
		';
		$totalcost = 0;
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
						<th>'.$row1['amount'].'</th>
						<th><a href="?p=winkelwagen&action=minus&id='.$row2['product_id'].'"><img src="img/minus.png"></a><a href="?p=winkelwagen&action=plus&id='.$row2['product_id'].'"><img src="img/plus.png"></a></th>
						</tr>
					';
					$totalcost += ($row2['price'] * $row1['amount']);
				}
			}
		}
		echo '
			<td colspan="6">Total price:</td>
			<th>&euro;'.$totalcost.'</th>
			</table>
		';
	}
}
?>