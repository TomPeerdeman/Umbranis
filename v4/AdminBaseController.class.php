<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");
	
	class AdminBaseController extends BaseController{
		public function __construct(){
			parent::__construct();
			if(!$this->user->is_member() || !$this->user->is_admin()){
				//Geen admin access
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Access denied</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="3;url=?p=home" />
	</head>
	<body>
		<p><strong>Access denied!</strong></p>
	</body>
</html>
<?php
				exit();
			}
		}
	}
?>