<?php
	function createthumb($url,$filename,$new_w,$new_h){
		$src_img=imagecreatefrompng($url);
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) {
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) {
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) {
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img = imagecreatetruecolor($thumb_w, $thumb_h);
		
		imagealphablending($dst_img, false);
		imagesavealpha($dst_img,true);
		$transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
		imagefilledrectangle($dst_img, 0, 0, $thumb_w, $thumb_h, $transparent);
		
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y); 
		imagepng($dst_img, $filename);
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$url = $_POST['url'];
		$url = "img/" . $url;
		if(file_exists($url)){
			createThumb($url, "img_out/" . $_POST['url'], 170, 150);
			echo "OK!";
		}else{
			echo "File doesn't exists";
		}
	}
?>
<form action="#" method="post">
	<input type="text" name="url" value="<?php echo (isset($_POST['url'])) ? $_POST['url'] : ""; ?>" style="width: 300px;" />
	<input type="submit" value="Submit" name="submit" />
</form>