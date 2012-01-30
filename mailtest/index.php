<?php
	error_reporting(E_ALL);
	
	$to = "nogwat4@gmail.com";
	$from = "Umbranis admin <admin@umbranis.nl>";
	$subject = "Test mail";
	$msg = "Test mail!";
	
	$headers = "From: " . $from . "\r\nReply-To: " . $from;
	
	var_dump(mail($to, $subject, $msg, $headers));
?>