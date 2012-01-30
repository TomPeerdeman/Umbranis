<?php
	session_start();
	
	$fonts = array("font1.ttf", "font2.ttf", "font3.ttf", "font4.ttf", "font5.otf", "font6.otf");
	$alphabet = array_merge(range('a', 'h'), range(2, 8), range('A', 'H'), range('j', 'z'), range('J', 'Z'));
	
	$img = imagecreatetruecolor(150, 60);
	//Niet precies wit
	$bgcolor = imagecolorallocate($img, 0xFE, 0xFE, 0xFE);
	//Niet precies zwart
	$black = imagecolorallocate($img, 1, 1, 1);
	for($i = 0; $i < 15; $i++){
		$colors[$i] = imagecolorallocatealpha($img, mt_rand(0, 0xFF), mt_rand(0, 0xFF), mt_rand(0, 0xFF), mt_rand(50, 100));
	}
	
	imagefill($img, 0, 0, $bgcolor);
	imageline($img, 0, 0, 0, 59, $black);
	imageline($img, 0, 59, 150, 59, $black);
	imageline($img, 149, 0, 149, 59, $black);
	imageline($img, 149, 0, 0, 0, $black);
	
	for($i = 0; $i < mt_rand(3, 10); $i++){
		imageline($img, mt_rand(0, 150), 0, mt_rand(0, 150), 60, $colors[mt_rand(0, 14)]);;
	}

	for($i = 0; $i < mt_rand(2, 4); $i++){
		imageline($img, 0, mt_rand(0, 60), 150, mt_rand(0, 60), $colors[mt_rand(0, 14)]);;
	}
	
	for($i = 0; $i < mt_rand(5, 7); $i++){
		for($j = 0; $j < mt_rand(10, 30); $j++){
			$n[$j] = mt_rand(0, 56);
		}
		$code[$i] = $alphabet[$n[mt_rand(0, (count($n) - 1))]];
	}
	
	$x = 10;
	for($i = 0; $i < count($code); $i++){
		$arr = imagettftext($img, mt_rand(15, 20), mt_rand(-20, 20), $x, mt_rand(30, 40), $black, "fonts/" . $fonts[mt_rand(0, 5)], $code[$i]);
		$x += 20;
	}
	
	$_SESSION['captcha'] = strtolower(implode($code));
	
	header("Content-type: image/png");
	imagepng($img);
	imagedestroy($img);
?>