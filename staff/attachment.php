<?php

define("IN_MAINSITE", true);

include('../includes/require/site_head.php');

if (!empty($_SESSION['admin'])) {
	$id = (int)$_GET['id'];
	$sql = "SELECT ma.* FROM tblMailAttachments ma INNER JOIN tblMails m ON ma.email_id = m.id WHERE ma.id = '$id' LIMIT 1";
	$attachment = $db->get_row($sql);

	header("Content-type: {$attachment['mime']}");
	header("Content-Disposition: inline; filename=" . urlencode($attachment['name']));

	$output = "{$cfg['path']['dir_attachments']}{$attachment['file']}";

	if (is_file($output) && is_readable($output)){
		readfile($output);
		die();
	}
} else {
	die;
}