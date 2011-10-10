<?
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "db.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "path.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "image.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "config" . "/" . "option.php");
include ("/home/httpd/vhosts/hornybook.com/html/includes/" . "class"  . "/" . "db.php");

include ("class_image.php");
include ("functions_image.php");


$db = new db( $cfg['db']['user'], $cfg['db']['password'], $cfg['db']['db'], $cfg['db']['host']);


/* ... images upload ... */
if(isset($_POST['delete']) or isset($_POST['delete_x']))
{
	delete_picture($db, $_POST['pic_id']);
}

if(isset($_POST['upload_photo']) or isset($_POST['upload_photo_x']))
{
		if(!($upload_error = checkpicture())){
			upload_picture($db, $_POST['photo_name'], $_POST['photo_description']);
		}
}
/* ...end images upload ... */

header("Location: http://www.hornybook.com/mem_upload.php" . "?error=" . $upload_error . "&photo_name=" . urlencode($_POST['photo_name']) . "&photo_description=" . urlencode($_POST['photo_description']));
exit;
?>