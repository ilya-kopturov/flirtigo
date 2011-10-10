<?
session_start();

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

include("includes/functions.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "image.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );

if(!($upload_error = admin_checkpicture())){
	admin_upload_picture($db, $_POST['id'], $_POST['photo_name'], $_POST['photo_description']);
}

header("Location:" . $_SERVER['HTTP_REFERER'] . "&msg=" . $upload_error);
exit;
?>