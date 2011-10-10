<?php
session_start();

require("includes/cnn.php");
include("../includes/config/" . "path.php");

$tbl = ($_GET['type'] == 'pic') ? 'tblPhotos' : 'tblVideos';

@mysql_query("DELETE FROM `" . $tbl . "` WHERE `id` = '" . $_GET['content_id'] . "'");

if($type == 'pic'){
	$sFile = $cfg['path']['dir_photos'] . $_GET['user_id'] . "_" . $_GET['content_id'] . "_";

	@unlink(substr($sFile, 0, -1) . ".jpg");
	@unlink($sFile . "s.jpg");
	@unlink($sFile . "m.jpg");
	@unlink($sFile . "b.jpg");
	@unlink($sFile . "r.jpg");
}else{
	$sFile = $cfg['path']['url_site']   . "media/media/videos/" . $_GET['user_id'] . "_" . $_GET['content_id'] . ".flv";
	$tFile = $cfg['path']['dir_videos'] . "thumbs/" . $_GET['content_id'] . "/00000001.jpg";
	@unlink($sFile);
	@unlink($tFile);
}

header("Location:" . $_SERVER['HTTP_REFERER']);
exit;
?>