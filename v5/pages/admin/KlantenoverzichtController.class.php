<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class KlantenoverzichtController extends AdminBaseController{
		private $users = array();
		
		public function __construct(){
			parent::__construct();
		
			$res = DB::$db->query("SELECT id, username, firstname, lastname FROM users");
			
			while($row = $res->fetch()){
				$this->users[] = $row;
			}
		}
	
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Klanten Overzicht</h2>
	<div id="contentbox">
		<p>Hier staan alle users en enkele basisgegevens.<br /><br /></p>
		<table class="tdspace" width="600px">
			<tr>
				<td width='75px'><strong>User ID</strong></td>
				<td width='150px'><strong>Username</strong></td>
				<td width='150px'><strong>First Name</strong></td>
				<td width='150px'><strong>Last Name</strong></td>
				<td width='75px'>&nbsp;</td>
			</tr>
<?php
				foreach($this->users as $users){
					echo "<tr>
							<td width='75px'>" . $users['id'] . "</td>
							<td width='150px'>" . $users['username'] . "</td>
							<td width='150px'>" . $users['firstname'] . "</td>
							<td width='150px'>" . $users['lastname'] . "</td>
							<td width='75px'>
								<a href=\"?p=admin/klantoverzicht&amp;id=" . $users['id'] . "\">Wijzig</a>
							</td>
						</tr>";	
				}
?>
		</table>
		<p><br /></p>
	</div>
</div>
<?php
		}
	}
?>