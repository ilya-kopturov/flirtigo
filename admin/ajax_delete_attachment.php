<?php

define("IN_MAINSITE", TRUE);

include_once '../includes/require/site_head.php';

if (isset($_GET['id']) && isset($_GET['e'])) {
	foreach($_SESSION['mail_attachments'][$_GET['e']] as $key => $attach) {
		if ($attach['tmp'] == $_GET['id']) {
			unset($_SESSION['mail_attachments'][$_GET['e']][$key]);
			$filename = $cfg['path']['dir_upload'] . $attach['tmp'];
			if (isset($filename)) {
				unlink($filename);
			}
			echo 'ok';
		}
	}
}
