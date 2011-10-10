<?
function create_thumb_def($toImg,$new_width,$new_height,$quality) {

		if (is_null($quality)) {
			$quality=75; //default image processing	
		}
	
		$im  = imagecreate($new_width,$new_height); /* Create a blank image */
        $bgc = imagecolorallocate($im, 199, 219, 242);
        $tc  = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, $new_width, $new_height, $bgc);
        /* Output an errmsg */
        imagestring($im, 1, 5, 5, "Thumbnail N/A", $tc);

        if (!imagejpeg($im,$toImg,$quality)) {
			imagedestroy($source);
			imagedestroy($thumb);
			return false;	
		}
        
        
		return true;	
}

function LoadJpeg($imgname) 
{
    $im = @imagecreatefromjpeg($imgname); /* Attempt to open */
    if (!$im) { /* See if it failed */
        $im  = imagecreate(150, 30); /* Create a blank image */
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        /* Output an errmsg */
        imagestring($im, 1, 5, 5, "Nedisponibil", $tc);
    }
    return $im;
}

function create_thumbnail($fromImg,$toImg,$new_width,$new_height,$quality) {
	
	/////// Atentie - numai daca avem GD.2.0.1 sau mai mult
	///////////////////////////////////////////////////////

	$gd_vers_2_0 = true;
	
	// verify parametters
	if (is_null($quality)) {
		$quality=75; //default image processing	
	}
	$new_width = (int)$new_width;
	$new_height = (int)$new_height;
	
	if ($new_height<1 || $new_height>1024 || $new_width<1 || $new_width>1024) {
		//$im = LoadJpeg("sdsdsd");
		//imagejpeg($im,$toImg,$quality);
		return false;
	}

	// end verifying parametters
	
	//header('Content-type: image/jpeg');
	
	///// Get new sizes
	list($width, $height) = getimagesize($fromImg);
	$lastDot = strrpos($fromImg,".");
	$ext = strtolower(substr($fromImg,$lastDot+1));
	
	
	//die($width);
	if ($new_width && ($width < $height)) {
	   $new_width = ($new_height / $height) * $width;
	} else {
	   $new_height = ($new_width / $width) * $height;
	}
	

	////// Load
	if (!$gd_vers_2_0) {
		$thumb = imagecreate($new_width, $new_height);// for GD early than 2.0
	} else {
		$thumb = imagecreatetruecolor($new_width, $new_height); //  for GD >= 2.0
	}

	
	//$source = LoadJpeg($fromImg);
	switch ($ext) {
		case "jpg":
		case "jpeg":

			$source = @imagecreatefromjpeg($fromImg); /* Attempt to open */
			break;
			//die("after source");			
		case "bmp";		
			//die("e BMP!");		
			//$source = @imagecreatefromxbm($fromImg); /* Attempt to open */
        	// rename file to bmp

        	//unlink($toImg);
        	//die("am sters");

        	
        	copy($fromImg, "$toImg.bmp");
	        //die("copiata");
	        $myfile = substr($toImg,0,strrpos($toImg,".")+1);
	        
	        
	        $toolPath = "/usr/bin/";
	        //die($workingDir);
	        // convert bmp to png using shell command
	        $command = $toolPath."bmptoppm $toImg.bmp | ".
	                   $toolPath."ppmtojpeg > $toImg.jpg";
	        
			//die($command);
	        exec($command);
	        sleep(10);
	        
	        // remove original bmp
	        unlink("$toImg.bmp");
	        
	        // check png image by loading and saving the file
	        //  to prevent wrong uploaded files and errors

	        $source = imagecreatefromjpeg("$toImg.jpg");

	        unlink("$toImg.jpg");		
			
			break;
			
		case "gif";				
			$source = @imagecreatefromgif($fromImg); /* Attempt to open */
			break;

		case "png";				
			$source = @imagecreatefrompng($fromImg); /* Attempt to open */
			break;
			
		default:
			imagedestroy($thumb);
			return false;
			
			
	}

	
	if (!$source) {
		imagedestroy($source);
		imagedestroy($thumb);
		return false;
	}	
	
	///// Resize
	if (!$gd_vers_2_0) {
		$img_resized = imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	} else {
		$img_resized = imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
	}

	if (!$img_resized) {
		imagedestroy($source);
		imagedestroy($thumb);
		return false;	
	}
	//die("after resize");	
	
	
	// Output
	if (!imagejpeg($thumb,$toImg,$quality)) {
		imagedestroy($source);
		imagedestroy($thumb);
		return false;	
	}
	//die("made jpg from '$toImg': w= $new_width,h=$new_height");		
	
	imagedestroy($source);
	imagedestroy($thumb);
	return true;
}
?>