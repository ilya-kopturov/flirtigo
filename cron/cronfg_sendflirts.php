<?php
/* DIRTYFLIRTING.COM */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');
ini_set("display_errors", 1);

set_include_path(".:/home/httpd/vhosts/flirtigo.com/html/pear:/home/httpd/vhosts/flirtigo.com/html/includes");

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once($include_dir . "/includes/config/" . "db.php");
include_once($include_dir . "/includes/config/" . "path.php");
include_once($include_dir . "/includes/config/" . "mail.php");
include_once($include_dir . "/includes/config/" . "crypt.php");
include_once($include_dir . "/includes/config/" . "image.php");
include_once($include_dir . "/includes/config/" . "option.php");
include_once($include_dir . "/includes/config/" . "profile.php");
include_once($include_dir . "/includes/config/" . "template.php");

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");


include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES */


/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_sendflirts", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_sendflirts.php") && !strstr($line, "/bin/sh -c"))
		{
			echo $line. "\n";
			$cronruns++;
		}
	}
}
if ($cronruns >= 2)
{
	die("Cron allready runs!!!");
}
/* ................................ end of check  ........................................*/

/*          mailer and set headers                */
$mail = new PHPMailer();
/*          end mailer set                       */


/*                         START CRON                                                     */
$sql = mysql_query("SELECT * FROM `tblTypeWhispers` WHERE `new` = 'Y'");

$sql = mysql_query("SELECT m.*, ((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(m.`date_sent`)) / 60) as timedif
                    FROM  `tblTypeWhispers` m 
                    INNER JOIN `tblAutoWhisper` a ON ( a.user_id = m.user_to ) 
                    WHERE m.`new` = 'Y' AND ((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(m.`date_sent`))/60) >= a.`minutes`");

if(mysql_error()){
	echo "Eroare(73)" . mysql_error();
}
$nrows = mysql_num_rows($sql);

if($nrows > 0)
{
	while($obj = mysql_fetch_object($sql))
	{
		$subject = @$db->get_var("SELECT `subject` 
		                          FROM `tblAutoWhisper` 
		                          WHERE (`user_id` = '" . $obj->user_id . "' OR `user_id` = '0')
		                          LIMIT 1");
		$message = @$db->get_var("SELECT `message` 
		                          FROM `tblAutoWhisper` 
		                          WHERE (`user_id` = '" . $obj->user_id . "' OR `user_id` = '0') 
		                          ORDER BY `user_id` DESC
		                          LIMIT 1");
		
		$redirect_to = "mem_mail.php?folder=inbox";
		$subject = htmlentities(strip_tags(trim($subject)));
		$to      = (int) $obj->user_from;
		$message = htmlentities(strip_tags(trim($message)));
		
		$_SESSION['sess_id'] = $obj->user_id;
		$_POST['message_type'] = "S";
		$_POST['attachment_id'] = -1;
		
		$try = 0;
		
		if(trim($subject) and trim($message))
		{
			if(!@mysql_num_rows( mysql_query(" SELECT * FROM `tblTypeWhispers` WHERE `user_from` = '" . $obj->user_from . "' AND `user_to` = '" . $obj->user_to . "' AND `new` = 'N'") )) {
				$error = sent_message($db, $to, $subject, $message, 0);
				echo "SELECT * FROM `tblTypeWhispers` WHERE `user_from` = '" . $obj->user_from . "' AND `user_to` = '" . $obj->user_to . "' AND `new` = 'N'"; echo "\n<br/>";
			}
			 
			$try = 1;
			
			echo "Trimis whisper: " . $subject . ", Message: " . $message . " , From: " . $_SESSION['sess_id'] . ", To: " . $to . " \n<br/>";
		}
		else
		{
			echo "WHisper: " . $obj->message . " , TypeID: " . $obj->user_id . "\n<br/>";
		} 
		
		if(!$error AND $try == 1){
			@$db->query("UPDATE `tblTypeWhispers` SET `new` = 'N' WHERE `id` = '" . $obj->id . "' LIMIT 1");
			@$db->query("UPDATE `tblUsers` SET `lastlogin` = NOW() WHERE `id` = '" . $_SESSION['sess_id'] . "' LIMIT 1");
			
			/* ... update viewed table ... */
			if(!@mysql_num_rows(mysql_query("SELECT `user_id` FROM `tblViewedProfile` WHERE `user_id` = '" . $to . "' AND `viewed_user_id` = '" . $_SESSION['sess_id'] . "'"))){
				@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $to . "', '" . $_SESSION['sess_id'] . "', NOW())");
			}
			/* ..end update viewed.. */
			
			sleep(10);
		}
		else
		{
			echo "Error: " . $error . "EndError;\n<br/>";
			@$db->query("DELETE FROM `tblTypeWhispers` WHERE `id` = '" . $obj->id . "' LIMIT 1");
		}
	}
} 
else 
{
	echo "No flirts into TypeWhispers table! \n";
}

/*                       END START CRON                                                   */
?>
