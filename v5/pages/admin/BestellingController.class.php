<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class BestellingController extends AdminBaseController{
		private $order;
		private $products;
		
		public function __construct(){
			parent::__construct();
			if(isset($_GET['oid']) && ctype_digit($_GET['oid'])){
				$oid = intval($_GET['oid']);
			}elseif(isset($_POST['oid']) && ctype_digit($_POST['oid'])){
				$oid = intval($_POST['oid']);
			}
			if(isset($oid)){
				$res = DB::$db->query("SELECT * FROM orders JOIN users ON users.id = orders.user_id WHERE order_id=" . $oid . " LIMIT 1");
				$this->order = $res->fetch();
				
				$res = DB::$db->query("SELECT * FROM order_products JOIN products ON order_products.product_id = products.product_id WHERE order_id=" . $oid);
				while($row = $res->fetch()){
					$this->products[] = $row;
				}
			}
		}
		
		public function handleForm(){
			$pay = intval($_POST['payed']);
			$deliver = intval($_POST['delivered']);
			if(isset($this->order['order_id'])){
				DB::$db->query("UPDATE orders SET delivery_status=" . $deliver . ", payment_status=" . $pay . " WHERE order_id=" . $this->order['order_id'] . " LIMIT 1");
				$this->order['payment_status'] = $pay;
				$this->order['delivery_status'] = $deliver;
			}
		}
	
		public function buildPage(){
			echo '<div id="contentcontainer">
				<h2>Bestelling no. ' . $this->order['order_id'] . '</h2>
				<div id="contentbox">
					<table class="normal">
						<tr>
							<td>Klant naam: </td>
							<td>: ' . $this->order['firstname'] . ' ' . $this->order['lastname'] . '</td>
						</tr>
						<tr>
							<td>Totale prijs: </td>
							<td>: &euro;' . $this->price($this->order['total_price']) . '</td>
						</tr>
						<tr>
							<td>Betaald</td>
							<td>: ' . (($this->order['payment_status'] == 1) ? "Ja" : "Nee") . '</td>
						</tr>
						<tr>
							<td>Afgeleverd</td>
							<td>: ' . (($this->order['delivery_status'] == 1) ? "Ja" : "Nee") . '</td>
						</tr>
						<tr>
							<td class="spacer"></td>
						</tr>
						<tr>
							<td colspan="2"><span style="text-decoration: underline;">Klantgegevens</span></td>
						</tr>
						<tr>
							<td>Postcode</td>
							<td>: ' . $this->order['zipcode'] . '</td>
						</tr>
						<tr>
							<td>Straat</td>
							<td>: ' . $this->order['street'] . '</td>
						</tr>
						<tr>
							<td>Huisnummer</td>
							<td>: ' . $this->order['house_number'] . '</td>
						</tr>
						<tr>
							<td>Hoofd telefoonnummer</td>
							<td>: ' . $this->order['tel1'] . ' </td>
						</tr>
					</table>
					<br />
					<table class="tdspace">
						<tr>
							<td><strong>Artikel no.</strong></td>
							<td><strong>Artikel naam</strong></td>
							<td><strong>Aantal</strong></td>
							<td><strong>Prijs / stuk</strong></td>
							<td><strong>Prijs totaal</strong></td>
						</tr>
					';
				$total_price = 0;
				foreach($this->products as $product){
					$price = $product['price'] * $product['amount'];
					$total_price += $price;
					echo "<tr>
							<td>" . $product['product_id'] . "</td>
							<td>" . $product['product_name'] . "</td>
							<td>" . $product['amount'] . "</td>
							<td>&euro;" . $this->price($product['price']) . "</td>
							<td>&euro;" . $this->price($price) . "</td>
						</tr>";	
				}
				echo '<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><strong>Totaal:</strong></td>
							<td><strong>&euro;' . $this->price($total_price) . '</strong></td>
						</tr>
					</table>
					<br />
					<form action="?p=admin/bestelling" method="post">
						<table class="normal">
							<tr>
								<td>Betaald</td>
								<td>
									<select name="payed">
										<option value="1"' . (($this->order['payment_status'] == 1) ? " selected=\"selected\"" : "") . '>Ja</option>
										<option value="0"' . (($this->order['payment_status'] == 0) ? " selected=\"selected\"" : "") . '>Nee</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Afgeleverd</td>
								<td>
									<select name="delivered">
										<option value="1"' . (($this->order['delivery_status'] == 1) ? " selected=\"selected\"" : "") . '>Ja</option>
										<option value="0"' . (($this->order['delivery_status'] == 0) ? " selected=\"selected\"" : "") . '>Nee</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><input type="hidden" name="oid" value="' . $this->order['order_id'] . '" /></td>
								<td><input class="submit" type="submit" name="submit" value="Update" id="submit" /></td>
							</tr>
						</table>
					</form>
					<br />
				</div>
			</div>';
		}
	}
?>