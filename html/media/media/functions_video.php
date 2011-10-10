<?
function checkvideo()
{
	global $cfg, $_FILES;
	
	if (is_uploaded_file($_FILES['video_file']['tmp_name']) AND isset($_FILES['video_file']['tmp_name']))
	{
		$ext = pathinfo($_FILES['video_file']['name']);
		
		if ($_FILES['video_file']['size'] > ceil($cfg['option']['video_size'] * 1024 * 1024))
			return "File to big. Maximum file size: " . $cfg['option']['video_size'] . " MB.";
		
		if (!in_array($ext['extension'], $cfg['video']['extension']))
			return "Invalid file type.";
	}
	elseif ($_FILES['video_file']['tmp_name'] == "" or $_FILES['video_file']['size'] == 0)
	{
		return "Unknown file type.";
	}
	else
	{
		return "Uknown Error.";
	}
    
	return 0;
}

function upload_video($db, $video_name, $video_description)
{
	global $cfg, $_FILES, $_POST;
	 
	if (is_uploaded_file($_FILES['video_file']['tmp_name']) AND isset($_FILES['video_file']['tmp_name']))
	{
		$ext = pathinfo($_FILES['video_file']["name"]);
		
		if($_POST['typeusr'] == 'Y'){$approved = 'Y';}else{$approved = 'N';}
		
		@$db->query("INSERT INTO tblVideos (`user_id`, `video_name`, `video_description`, `video_ext`, `approved`, `upload_ip`, `upload_date`) 
			         VALUES ('" . (int) $_POST['id'] . "', '" . addslashes($video_name) . "', '" . addslashes($video_description) ."', '" . $ext['extension'] . "', '" . $approved . "', '" . $_SERVER['REMOTE_ADDR'] . "', NOW())"
		);
		
		$video_tblid = mysql_insert_id(); 
		
		if($_POST['typeusr'] == 'Y'){
			@$db->query("UPDATE `tblUsers` SET `withvideo` = 'Y' WHERE `id` = '" . $_POST['id'] . "' LIMIT 1");
		}
        
        
		$has_main_video = @$db->get_var("SELECT COUNT(*) FROM `tblVideos` WHERE `user_id` = '" . (int) $_POST['id'] . "' AND `video_main` = 'Y'");
		
		if($has_main_video == 0)
		{
			@$db->query("UPDATE `tblVideos` SET `video_main` = 'Y' WHERE `user_id` = '" . (int) $_POST['id'] . "' ORDER BY `id` ASC LIMIT 1");
		}
        
		$sFile   = $cfg['path']['dir_videos'] . "movie" . "/" . $_POST['id'] . "_" . $video_tblid . "." . $ext['extension'];
		$toFile  = $cfg['path']['dir_videos'] . "flv"   . "/" . $_POST['id'] . "_" . $video_tblid . ".flv";
		
		move_uploaded_file($_FILES['video_file']["tmp_name"], $sFile);
		
		convert_video($sFile, $toFile);
		video_to_frame($toFile, $video_tblid, $_POST['id']);
	}
}

function delete_video($db, $video_id, $user_id)
{
	global $cfg, $_POST;
	
	$video_tblid  = @$db->get_var("SELECT `id` FROM `tblVideos` WHERE `user_id` = '" . (int) $user_id . "' ORDER BY `id` ASC LIMIT 1 OFFSET " . ($video_id - 1));
	$video_tblext = @$db->get_var("SELECT `video_ext` FROM `tblVideos` WHERE `user_id` = '" . (int) $user_id . "' AND `id` = '" . $video_tblid . "'");
	
	$sFile_1 = $cfg['path']['dir_videos'] . "flv"   . "/" . $user_id . "_" . $video_tblid . "." . "flv";
	$sFile_2 = $cfg['path']['dir_videos'] . "thumb" . "/" . $user_id . "_" . $video_tblid . "." . "jpg";
	$sFile_3 = $cfg['path']['dir_videos'] . "thumb" . "/" . $user_id . "_" . $video_tblid . "_r." . "jpg";
	$sFile_4 = $cfg['path']['dir_videos'] . "thumb" . "/" . $user_id . "_" . $video_tblid . "_m." . "jpg";
	$sFile_5 = $cfg['path']['dir_videos'] . "movie" . "/" . $user_id . "_" . $video_tblid . "." . $video_tblext;
	
	$nFile   = $cfg['path']['dir_videos'] . "thumb" . "/" . $user_id . "_";
	
	@unlink($sFile_1);
	@unlink($sFile_2);
	@unlink($sFile_3);
	@unlink($sFile_4);
	@unlink($sFile_5);
	
	@unlink($nFile . "_0.jpg");
	@unlink($nFile . "_0_r.jpg");
	@unlink($nFile . "_0_s.jpg");
	@unlink($nFile . "_0_m.jpg");
	@unlink($nFile . "_0_b.jpg");
	
	@$db->query("DELETE FROM `tblVideos` WHERE `user_id` = '" . (int) $user_id . "' AND `id` = '" . $video_tblid . "' LIMIT 1");
	
	$has_videos = @$db->get_var("SELECT COUNT(*) FROM `tblVideos` WHERE `user_id` = '" . (int) $user_id . "'");
	
	if($has_videos == 0)
	{
		@$db->query("UPDATE `tblUsers` SET `withvideo` = 'N' WHERE `id` = '" . (int) $user_id . "' LIMIT 1");
	}
	else
	{
		$has_main_video = @$db->get_var("SELECT COUNT(*) FROM `tblVideos` WHERE `user_id` = '" . (int) $_POST['id'] . "' AND `video_main` = 'Y'");
		
		if($has_main_video == 0)
		{
			@$db->query("UPDATE `tblVideos` SET `video_main` = 'Y' WHERE `user_id` = '" . (int) $_POST['id'] . "' ORDER BY `id` ASC LIMIT 1");
		}
	}
}

function convert_video($fromFile, $toFile)
{
	//$encodecommand="/usr/bin/mencoder $fromFile -o $toFile -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames -vf scale=320:260 -srate 22050";
	$encodecommand="ffmpeg  -i $fromFile  -aspect 4:3  -b 30000 -r 12 -f flv -s 320x240 -an $toFile";
	exec("$encodecommand");
}

function video_to_frame($video, $vid, $uid)
{
	global $cfg;
	
		$cmd = "/usr/bin/mplayer $video -ss 27 -nosound -vo jpeg:outdir=".$cfg['path']['dir_videos'] . "thumb" . "/" .$vid." -frames 2";
        exec($cmd);
        
        $fd_m = $cfg['path']['dir_videos'] . "thumb" . "/" . $uid . "_" . $vid . "_m.jpg";
        $fd_s = $cfg['path']['dir_videos'] . "thumb" . "/" . $uid . "_" . $vid . ".jpg";
        $fd_r = $cfg['path']['dir_videos'] . "thumb" . "/" . $uid . "_" . $vid . "_r.jpg";
		 
		$ff   = $cfg['path']['dir_videos'] . "thumb" . "/" . $vid . "/00000001.jpg";
		 
		if(!file_exists($ff)) $ff = $cfg['path']['dir_videos'] . "thumb" . "/" . $vid . "/00000002.jpg";
		if(!file_exists($ff)) $ff = $cfg['path']['dir_videos'] . "thumb" . "/" . "nothumb.jpg";
		
		
		$im = new Image();
        
		if ($im->load($ff))
		{
			$im->resize($cfg['image']['m_x'], $cfg['image']['m_y'], $cfg['image']['watermark'], $cfg['image']['watermark_size']);
			$im->save($fd_m, $cfg['image']['quality']);
		}
		if ($im->load($ff))
		{
			$im->resize($cfg['image']['s_x'], $cfg['image']['s_y'], $cfg['image']['watermark'], 0);
			$im->save($fd_s, $cfg['image']['quality']);
		}
		if ($im->load($ff))
		{
			$im->resize($cfg['image']['r_x'], $cfg['image']['r_y'], $cfg['image']['watermark'], 0);
			$im->save($fd_r, $cfg['image']['quality']);
		}
		
		@unlink($cfg['path']['dir_videos'] . "thumb" . "/" . $vid . "/00000001.jpg");
		@unlink($cfg['path']['dir_videos'] . "thumb" . "/" . $vid . "/00000002.jpg");
		@rmdir($cfg['path']['dir_videos'] . "thumb" . "/" . $vid);
}
?>