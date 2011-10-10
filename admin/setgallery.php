<?php
session_start();

require("includes/cnn.php");
include("../includes/config/" . "path.php");

$tbl     = ($_GET['type'] == 'pic') ? 'tblPhotos' : 'tblVideos';
$gallery = ($_GET['gallery'] == 1) ? 0 : 1;

@mysql_query("UPDATE `" . $tbl . "` SET `gallery` = '{$gallery}' WHERE `id` = '" . $_GET['content_id'] . "'");

header("Location:" . $_SERVER['HTTP_REFERER']);
exit;
?>