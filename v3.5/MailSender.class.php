<?php
	//Dit bestand kan alleen vanuit de index aangeroepen worden
	if(!defined("INDEX"))die("NO INDEX!");

	class MailSender{
		public static function sendMail($to, $subject, $message, $html = false, $from = "no-reply@umbranis.nl", $fromName = "Umbranis"){		
			$headers = "From: " . $fromName . " <" . $from . ">\r\n";
			$headers .= "To: <" . $to . ">\r\n";
			$headers .= "Subject: " .$subject . "\r\n";
			if($from != "no-reply@umbranis.nl"){
				$headers .= "Reply-to: <" .$from . ">\r\n";
			}else{
				$headers .= "Reply-to: <admin@umbranis.nl>\r\n";
			}
			if($html){
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			}
			$headers .= "Return-Path: <admin@umbranis.nl>";
			
			return mail($to, $subject, $message, $headers);
		}
	}
?>