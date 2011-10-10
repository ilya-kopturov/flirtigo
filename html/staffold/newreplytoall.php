<?php
session_set_cookie_params(0);
session_start();

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );

//* ... submit reply message ...*//
if(isset($_POST['form_submited']))
{
	$subject = htmlentities(strip_tags(trim($_POST['subject'])))?htmlentities(strip_tags(trim($_POST['subject']))):'(no subject)';
	$to      = id_to_screenname(trim($_POST['user_from']));
	$message = htmlentities(strip_tags(trim($_POST['message'])));
	$savemail= 1;
	$redirect_to = "mem_mail.php?folder=inbox";
	 
	$error = admin_sent_message($db, $to, $_POST['user_to'], $subject, $message, $savemail);
	
	sleep(1);
	
	echo "<script>parent.document.getElementById('checkreply" . $_POST['messid'] . "').innerHTML = '<img src=\"/staff/images/checked.gif\" />'; parent.document.getElementById('reply_" . $_POST['messid'] . "').style.display = 'none';</script>";
}
//* . end submit reply message .*//
