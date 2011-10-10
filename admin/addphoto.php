<?php
/* $Id: ajax_upload_popup.php 526 2008-06-11 18:18:30Z bogdan $ */

define("IN_MAINSITE", TRUE);

include('../includes/require/site_head.php');

$uid = $_POST['sess_id'];
$photo_id = ($_POST['photo_id']) ? $_POST['photo_id'] : -1;

if (strcmp($_GET['u'], 't') == 0) {
	$fileInfo = base64_decode(urldecode($_POST["hidFileID"]));
	list($tmpFile, $origFile, $mime) = explode('<=>', $fileInfo);
	$path_parts = pathinfo($origFile);
	$gallery = (ereg('[01]', $_POST['gallery'])) ? $_POST['gallery'] : 0;
	$extension = strtolower($path_parts['extension']);
	if ($photo_id == -1) {
		$db->query("INSERT INTO `tblPhotos`
			(`user_id`, `gallery`, `photo_name`, `photo_description`, `extension`, `upload_ip`, `upload_date`)
			VALUES ('$uid', '$gallery', '" . addslashes($_POST['title']) . "', '" . addslashes($_POST['description']) ."', '$extension', '" . $_SERVER['REMOTE_ADDR'] . "', NOW())"
		);
		$photo_id = $db->lastInsertID();
		/* after picture is approved */
		//$db->query("UPDATE `tblUsers` SET `withpicture` = 'Y' WHERE `id` = '$uid' LIMIT 1");
		$has_main_pic = $db->get_var("SELECT COUNT(*) FROM tblUsers u INNER JOIN tblPhotos p ON u.id = p.user_id WHERE u.id = '$uid' AND p.photo_main = 'Y'");
		if ($has_main_pic == 0) {
			$db->query("UPDATE tblPhotos SET photo_main = 'Y' WHERE id = '$photo_id'");
		}
	}
	if ($_POST["hidFileID"]) {
		$newFile = $cfg['path']['dir_photos'] . $uid . "_" . $photo_id . "." . $extension;
		@unlink($newFile);
		rename($cfg['path']['dir_upload'] . $tmpFile, $newFile);
	}
print <<< EOF
window.close();
EOF;
exit;
}

$type = (empty($_GET['t']) || !(in_array($_GET['t'], array('picture', 'video')))) ? 'picture' : $_GET['t'];

$smarty->assign('type', $type);
$smarty->assign('galleries', array('Private Gallery', 'Public Gallery'));
$smarty->display("{$cfg['template']['dir_template']}ajax/admin_upload_picture.tpl");
?>