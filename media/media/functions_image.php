<?


function checkpicture()
{
	global $cfg, $_FILES;
	
	if (is_uploaded_file($_FILES['photo_file']['tmp_name']) AND isset($_FILES['photo_file']['tmp_name']))
	{
		$picture_size = getimagesize($_FILES['photo_file']['tmp_name']);
		
		if( (int) $picture_size[2] != 1 AND (int) $picture_size[2] != 2){
			return "Invalid image type! Upload only .jgp or .gif files! ";
		}
		if($picture_size[0] < 200 OR $picture_size[1] < 200){
			return "Photo must be a minimum 200x200 pixels!";
		}
		if($picture_size[0] > 2000 OR $picture_size[1] > 2000){
			return "Photo must be a maximum 2000x2000 pixels!";
		}
         
		if ($_FILES['photo_file']['size'] > ceil($cfg['option']['picture_size'] * 1024 * 1024))
			return "<br />File to big. Maximum file size: " . $cfg['option']['picture_size'] . " MB.";
	}
	elseif ($_FILES['photo_file']['tmp_name'] == "" or $_FILES['photo_file']['size'] == 0)
	{
		return "Unknown file type.";
	}
	else
	{
		return "Uknown Error.";
	}
     
	return 0;
}

function upload_picture($db, $pic_name, $pic_description)
{
	global $cfg, $_FILES, $_POST;
	 
	if (is_uploaded_file($_FILES['photo_file']['tmp_name']) AND isset($_FILES['photo_file']['tmp_name']))
	{
		if($_POST['typeusr'] == 'Y'){ $approved = 'Y';} else {$approved = 'N';}
		
		@$db->query("INSERT INTO `tblPhotos` (`user_id`, `photo_name`, `photo_description`, `approved`, `upload_ip`, `upload_date`) 
			         VALUES ('" . (int) $_POST['id'] . "', '" . addslashes($pic_name) . "', '" . addslashes($pic_description) ."', '" . $approved . "', '" . $_SERVER['REMOTE_ADDR'] . "', NOW())"
		);
		
		$pic_tblid = mysql_insert_id(); 
        
		if($_POST['typeusr'] == 'Y'){
			$db->query("UPDATE `tblUsers` SET `withpicture` = 'Y' WHERE `id` = '" . (int) $_POST['id'] . "' LIMIT 1");
		}
        
        
		$has_main_pic = @$db->get_var("SELECT COUNT(*) FROM `tblPhotos` WHERE `user_id` = '" . (int) $_POST['id'] . "' AND `photo_main` = 'Y'");
		
		if($has_main_pic == 0)
		{
			@$db->query("UPDATE `tblPhotos` SET `photo_main` = 'Y' WHERE `user_id` = '" . (int) $_POST['id'] . "' ORDER BY `id` ASC LIMIT 1");
		}
        
        
		$sFile_ = $cfg['path']['dir_photos'] . $_POST['id'] . "_" . $pic_tblid . "_";
		$im = new Image();
         echo $_FILES['photo_file']['tmp_name'];
         
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->noresize($cfg['image']['b_x'], $cfg['image']['b_y'], $cfg['image']['watermark'], $cfg['image']['watermark_size']+3);
			$im->save($sFile_ . "b.jpg", $cfg['image']['quality']);
		}
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['s_x'], $cfg['image']['s_y'], $cfg['image']['watermark'], 0);
			$im->save($sFile_ . "s.jpg", $cfg['image']['quality']);
		}
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['r_x'], $cfg['image']['r_y'], $cfg['image']['watermark'], 0);
			$im->save($sFile_ . "r.jpg", $cfg['image']['quality']);
		}
	}
}

function delete_picture($db, $pic_id)
{
	global $cfg, $_POST;
	
	$pic_tblid = @$db->get_var("SELECT `id` FROM `tblPhotos` WHERE `user_id` = '" . $_POST['id'] . "' ORDER BY `id` ASC LIMIT 1 OFFSET " . ($pic_id - 1));
	
	$sFile_ = $cfg['path']['dir_photos'] . $_POST['id'] . "_" . $pic_tblid . "_";
	$nFile_ = $cfg['path']['dir_photos'] . $_POST['id'] . "_";
	
	@unlink($sFile_ .    "b.jpg");
	@unlink($sFile_ .    "m.jpg");
	@unlink($sFile_ .    "s.jpg");
	@unlink($nFile_ . "_0_b.jpg");
	@unlink($nFile_ . "_0_m.jpg");
	@unlink($nFile_ . "_0_s.jpg");
	
	@$db->query("DELETE FROM `tblPhotos` WHERE `user_id` = '" . $_POST['id'] . "' AND `id` = '" . $pic_tblid . "' LIMIT 1");
	
	$has_pics = @$db->get_var("SELECT COUNT(*) FROM `tblPhotos` WHERE `user_id` = '" . $_POST['id'] . "'");
	
	if($has_pics == 0)
	{
		@$db->query("UPDATE `tblUsers` SET `withpicture` = 'N', `featured` = 'N' WHERE `id` = '" . (int) $_POST['id'] . "' LIMIT 1");
	}
	else
	{
		$has_main_pic = @$db->get_var("SELECT COUNT(*) FROM `tblPhotos` WHERE `user_id` = '" . (int) $_POST['id'] . "' AND `photo_main` = 'Y'");
		
		if($has_main_pic == 0)
		{
			@$db->query("UPDATE `tblPhotos` SET `photo_main` = 'Y' WHERE `user_id` = '" . (int) $_POST['id'] . "' ORDER BY `id` ASC LIMIT 1");
		}
	}
}
?>