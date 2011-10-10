<?php
/* $Id: video_player.php 535 2008-06-13 12:40:11Z bogdan $ */

set_include_path(".:..:../includes:/usr/share/php:/usr/share/pear");

define("IN_MAINSITE", true);

include ("includes/require/site_head.php");

$video_id = (int)$_GET['vid'];
$video = $db->get_row("SELECT v.* FROM tblVideos v WHERE v.id = '$video_id' LIMIT 1");

$smarty->assign('video', $video);

$smarty->display("{$cfg['template']['dir_template']}ajax/admin_video_player.tpl");