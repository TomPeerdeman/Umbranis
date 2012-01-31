<?php
//Dit bestand kan alleen vanuit de index aangeroepen worden
if(!defined("INDEX"))die("NO INDEX!");


class WinkelwagenController extends BaseController{

	public function buildPage(){
		//If an option is selected
		if(isset($_get['action'])){
			$action = $_get['action'];
			$productid = $_get ['id'];
			$userid = DB::$db->query("SELECT id FROM users WHERE username=” . $this->user->username . ” LIMIT 1");
			switch ($action){
			case 'add':
				DB::$db->query("INSERT INTO winkelwagen VALUES ('$productid', '$userid', '1')");
				break;
			case 'delete':
				DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = '$productid' AND user_id = '$userid'");
				break;
			case 'plus':
				$oldnum =  DB::$db->query("SELECT amount FROM winkelwagen WHERE user_id = '$userid' AND prod_id = '$productid'");
				DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = '$productid' AND user_id = '$userid'");
				DB::$db->query("INSERT INTO winkelwagen VALUES ('$productid', '$userid', '($oldnum + 1)')");
				break;
			case 'minus':
				$oldnum =  DB::$db->query("SELECT amount FROM winkelwagen WHERE user_id = '$userid' AND prod_id = '$productid'");
				DB::$db->query("DELETE FROM winkelwagen WHERE prod_id = '$productid' AND user_id = '$userid'");
				DB::$db->query("INSERT INTO winkelwagen VALUES ('$productid', '$userid', '($oldnum - 1)')");
				break;
			}
		}
		//building the actual page
		//sets up the top of the table
		echo '
			<table border="1">
			<tr>
			<th>Product name</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Price</th>
			<th>Amount</th>
			<th></th>
			</tr>
		';
		$userid = DB::$db->query("SELECT id FROM users WHERE username=”.$this->user->username.” LIMIT 1");
		$res1 = DB::$db->query("SELECT * FROM winkelwagen where user_id = $userid");
		while($res1 && $row1 = $res1->fetch()){
			//builds up the individual's shopping list
			$res2 = DB::$db->query("SELECT * FROM products where product_id = $res1");
			while($res2 && $row2 = $res2->fetch()){
				echo '
					<tr>
					<th>'.$row['product_name'].'</th>
					<th>'.$row['author'].'</th>
					<th>'.$row['publisher'].'</th>
					<th>'.$row['price'].'</th>
					<th>'.$amount = countcart($x).'</th>
					<th><a href="cart.php?action=minus&id='.$x.'"><img src="img/minus.png"></a><a href="cart.php?action=add&id='.$x.'"><img src="img/plus.png"></a></th>
					</tr>
				';
				$totalcost += ($row['price'] * $amount);
				}
			
		}
		echo '
		'
	}
}
?>