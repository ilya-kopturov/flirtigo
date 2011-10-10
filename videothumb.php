<?php
define("IN_MAINSITE", TRUE);
include ("includes/require/site_head.php");

$video_id = (int)$_GET['id'];
$uid = $_GET['user_id'] ? $_GET['user_id'] : $_SESSION['sess_id'];

if (!$video_id && $uid) {
	$video_id = $db->get_var("SELECT v.id FROM tblUsers u INNER JOIN tblVideos v ON u.id = v.user_id WHERE u.id = '$uid' AND v.video_main = 'Y'");
}

$video = $db->get_row("SELECT * FROM tblVideos WHERE user_id = '$uid' AND id = '$video_id' LIMIT 1");

try {
	$image = new Imagick($cfg['path']['dir_videos'] . "thumb/$video_id/00000001.jpg");
} catch (Exception $e) {
	$image = new Imagick($cfg['path']['dir_photos'] . 'novideo.jpg');
}

$t = $_GET['t'];
$t = $cfg['image']["{$t}_x"] && $cfg['image']["{$t}_y"] ? $t : 'm';

$image->scaleImage($cfg['image']["{$t}_x"], $cfg['image']["{$t}_y"]);

header("Content-type: image/jpeg");
print $image;