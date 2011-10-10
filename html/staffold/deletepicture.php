<?
session_start();

require("includes/cnn.php");
include("../includes/config/" . "path.php");

@mysql_query("DELETE FROM `tblPhotos` WHERE `id` = '" . $_GET['pic_id'] . "'");

$sFile = $cfg['path']['dir_photos'] . $_GET['user_id'] . "_" . $_GET['pic_id'] . "_";

@unlink($sFile . "s.jpg");
@unlink($sFile . "m.jpg");
@unlink($sFile . "b.jpg");
@unlink($sFile . "r.jpg");

header("Location:" . $_SERVER['HTTP_REFERER']);
exit;
?>