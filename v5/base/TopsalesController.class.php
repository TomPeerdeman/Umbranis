<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class TopsalesController{
		private $topsales;
	
		public function __construct($page){
			//todo: selecteren van producten die ook gekocht werden als er een productpagina geopend is.
			$res = DB::$db->query("SELECT product_id, product_name, price, subcat.cat_name AS subcat_name, hoofdcat.cat_name AS hoofdcat_name
				FROM products
				JOIN categories AS subcat ON products.cat_id = subcat.cat_id
				JOIN categories AS hoofdcat ON subcat.parent_id = hoofdcat.cat_id
				LIMIT 5");
			while($row = $res->fetch()){
				$this->topsales[] = $row;
			}
		}
	
		public function buildTopsales(){
?>
<div id="topsales">
	<strong>Meest verkocht</strong><br />
	<table>
<?php
	$base = new BaseController();
	for($i = 0; $i < 5; $i++){
		echo '<tr>
			<td rowspan="3" class="topnum"><a href="?p=product&amp;id=' . $this->topsales[$i]['product_id'] . '" onclick="return page_load(\'product\', \'id=' . $this->topsales[$i]['product_id'] . '\');">' . ($i + 1) . '</a></td>
			<td class="topitemtop"><a href="?p=product&amp;id=' . $this->topsales[$i]['product_id'] . '" onclick="return page_load(\'product\', \'id=' . $this->topsales[$i]['product_id'] . '\');">' . $this->topsales[$i]['hoofdcat_name'] . ' - ' . $this->topsales[$i]['subcat_name'] . '</a></td>
		</tr>
		<tr>
			<td class="topitem"><a href="?p=product&amp;id=' . $this->topsales[$i]['product_id'] . '" onclick="return page_load(\'product\', \'id=' . $this->topsales[$i]['product_id'] . '\');">' . $this->topsales[$i]['product_name'] . '</a></td>
		</tr>
		<tr>
			<td class="topitem"><a href="?p=product&amp;id=' . $this->topsales[$i]['product_id'] . '" onclick="return page_load(\'product\', \'id=' . $this->topsales[$i]['product_id'] . '\');">&euro;' . $base->price($this->topsales[$i]['price']) . '</a></td>
		</tr>		
		<tr>
			<td class="spacer" colspan="2"></td>
		</tr>';
	}
?>
	</table>
</div>
<div id="twitter">
	<script type="text/javascript">
	new TWTR.Widget({
	  version: 2,
	  type: 'profile',
	  rpp: 4,
	  interval: 30000,
	  width: 164,
	  height: 180,
	  theme: {
		shell: {
		  background: '#333333',
		  color: '#ffffff'
		},
		tweets: {
		  background: '#000000',
		  color: '#ffffff',
		  //links: '#4aed05'
		  links: 'rgb(248, 213, 12)'
		}
	  },
	  features: {
		scrollbar: true,
		loop: false,
		live: false,
		behavior: 'all'
	  }
	}).render().setUser('Umbranis').start();
	</script>
</div>
<?php
		}
	}
?>