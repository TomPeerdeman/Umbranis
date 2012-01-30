<?php
//Dit bestand kan alleen vanuit de index aangeroepen worden
if(!defined("INDEX"))die("NO INDEX!");
$cart = $_SESSION['cart'];
$action = $_GET['action'];

class WinkelwagenController extends BaseController{
	
	public function cartchange(){
			//updates the cart;
			switch ($action){
				case 'add':
					if ($cart) {
						$cart = $cart.','.$_get['id'];
					}
					else{
						$cart = $_get['id'];
					}
				break;
				case 'remove':
					$inhoud = explode(',',$cart);
					$nextcart = '';
					foreach ($inhoud as $x){
						if ($x != $_get['id']){
							if ($nextcart = ''){
								$nextcart = $x;
							} 
							else{
								$nextcart = $nextcart.''.$x;
							}
						} 
						
					}
					$cart=$nextcart;
				break;
				case 'minus':
					$inhoud = explode(',',$cart);
					$nextcart = '';
					$subtracted = false;
					foreach ($inhoud as $x){
						if ($x != $_get['id'] || ($subtracted)){ 
							if ($nextcart = ''){
								$nextcart = $x;
							} 
							else{
								$nextcart = $nextcart.''.$x;
							}
						} else{
							$subtracted = true;
						}
					}
				break;
			}
			$_SESSION['cart'] = $cart;
		}
	
	public function countcart($id){
		$count = 0;
		$inhoud = explode(',',$cart);
		foreach ($inhoud as $x){
			if ($x = $id){
				$count += 1;
			}
		}
		return $count;
	}
	
	public function buildcart(){
		if ($cart){
			$inhoud = explode(',',$cart);
			$builtlist = '';
			$totalcost;
			// sets up the top of the table
			echo '
				<table borders=1>
				<tr>
				<th>Product name</th>
				<th>Author</th>
				<th>Publisher</th>
				<th>Price</th>
				<th>Amount</th>
				<th></th>
				</tr>
			';
			//builds the list product for product
			foreach ($inhoud as $x){
				//checks whether this product is already present.
				$alreadydone = false;
				$builtarray = explode(',',$builtlist);
				foreach ($builtarray as $y){
					if ($x = $y) {
						$alreadydone = true;
					}
				}
				//does the actual building
				if (!($alreadydone)){
					$res = DB::$db->query("SELECT * FROM products where product_id = $x");
					while($res && $row = $res->fetch()){
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
						$builtlist = $builtlist.','.$x;
					}
				}
			}
			//Gives the total price.
			echo '
				<tr>
				<td colspan="4">Total Price:</td>
				<th>'.$totalcost.'</th>
				</tr>
			';
		}
		else{
			echo 'Je winkelwagen is leeg';
		}
	}
	
	public function buildPage(){
		$cart = $_SESSION['cart'];
		if ($_GET['action']){
			$this->cartchange();
		}
		echo '
			<div id="fullcart">'.$this->buildcart().'</div>
		';
	}
}
?>