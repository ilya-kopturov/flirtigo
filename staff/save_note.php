<?php
session_set_cookie_params(0);
session_start();

require("includes/cnn.php");



if(isset($_POST['form_submited'])) {
	$user_from	= (int)$_POST['user_from'];
	$user_to	= (int)$_POST['user_to'];
	$text		= addslashes($_POST['text']);
	
	$db->exec("INSERT INTO tblchatnotes (`user_from`, `user_to`, `text`, `created`, `admin_id`) VALUES ({$user_from}, {$user_to}, '{$text}', NOW(), {$_SESSION['admin']})");
}
