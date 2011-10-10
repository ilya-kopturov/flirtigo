<?
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "db.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "path.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "video.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "image.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "option.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "class"  . "/" . "db.php");

include ("class_image.php");
include ("functions_video.php");


set_time_limit(0);

$db = new db( $cfg['db']['user'], $cfg['db']['password'], $cfg['db']['db'], $cfg['db']['host']);


/* ... images upload ... */
if(isset($_POST['delete']) or isset($_POST['delete_x']))
{
	delete_video($db, $_POST['video_id'], $_POST['id']);
}

if(isset($_POST['upload_video']) or isset($_POST['upload_video_x']))
{
		if(!($upload_error = checkvideo())){
			upload_video($db, $_POST['video_name'], $_POST['video_description']);
		}
}
/* ...end images upload ... */

header("Location: http://www.hornybook.com/mem_uploadvideos.php" . "?error=" . urlencode($upload_error) . "&video_name=" . urlencode($_POST['video_name']) . "&video_description=" . urlencode($_POST['video_description']));
exit;
?>