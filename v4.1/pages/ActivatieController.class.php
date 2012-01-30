<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class ActivatieController extends BaseController{
		private $success = false;
		
		public function __construct(){
			parent::__construct();
			DB::$db->query("DELETE FROM password_requests WHERE NOW() > DATE_ADD(request_time, INTERVAL 10 MINUTE)");
			
			if(isset($_GET['key'])){
				$key = DB::$db->quote($_GET['key']);
				$res = DB::$db->query("UPDATE users
					SET login_tries = 0
					WHERE id = (
						SELECT user_id
						FROM password_requests 
						WHERE request_hash = " . $key . "
						LIMIT 1
					)
					LIMIT 1");
				if(!$res)return;
				if($res->rowCount() ==1){
					if(DB::$db->query("DELETE FROM password_requests WHERE request_hash = " . $key . " LIMIT 1")){
						$this->success = true;
					}
				}
			}
		}
		
		public function buildPage(){
?>
<div id="contentcontainer">
	<h2>Login</h2>
	<div id="contentbox">
<?php		
			if($this->success){
				echo "<br /><p>Uw account is geactiveerd!";
				echo "<br /><br />U wordt automatisch doorgestuurd na 5 seconden gebeurt dit niet klik dan <a href=\"?p=login\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"5;url=?p=login\" />";
			}else{
				echo "<p>Het activeren is mislukt!<br />Dit kan komen doordat de activatie aanvraag verlopen is.<br />Probeer een nieuw paswoord aan te vragen.";
				echo "<br /><br />U wordt automatisch doorgestuurd na 10 seconden gebeurt dit niet klik dan <a href=\"?p=home\">hier</a>.</p>";
				echo "<meta http-equiv=\"refresh\" content=\"10;url=?p=home\" />";
			}
?>
	</div>
</div>
<?php
		}
	}
?>