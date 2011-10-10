<?php
/* DIRTYFLIRTING.COM                                                                         
                                                                                           
                                                                                           
                                                                                         */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once( $include_dir . "/includes/config/" . "db.php" );
include_once( $include_dir . "/includes/config/" . "path.php" );
include_once( $include_dir . "/includes/config/" . "image.php" );
include_once( $include_dir . "/includes/config/" . "option.php" );
include_once( $include_dir . "/includes/config/" . "profile.php" );
include_once( $include_dir . "/includes/config/" . "template.php" );

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

include_once( "phpmailer" . "/" . "class.phpmailer.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronhb_sendnewslettermails", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronhb_sendnewslettermails.php") && !strstr($line, "/bin/sh -c"))
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
$sql = mysql_query("SELECT `id`, `interval` FROM `tblNewsletter` WHERE `finishedaddmails` = 'Y' AND `finished` = 'N' AND `running` = 'Y'");
$nrows = mysql_num_rows($sql);

if($nrows > 0)
{
	while($obj = mysql_fetch_object($sql))
	{
		$sql_mails = mysql_query("SELECT * FROM `tblNewsletterMails` WHERE `sent` = 'N' AND `newsletterid` = '" . $obj->id ."' LIMIT 25");
		$nrows_mails = mysql_num_rows($sql_mails);
		
		if($nrows_mails > 0)
		{
			$mailsent = 0;
			while($obj_mails = mysql_fetch_object($sql_mails))
			{
				$mail->FromName = trim($obj_mails->sendname)!=""?trim($obj_mails->sendname):$cfg['option']['from_name'];
				$mail->From = trim($obj_mails->sendemail)!=""?trim($obj_mails->sendemail):$cfg['option']['from_email'];
				
				$mail->Hostname = "207.44.254.36";
				
				$mail->Subject = stripslashes($obj_mails->subject);
				$mail->Body    = stripslashes($obj_mails->message);
				
				$mail->AddAddress($obj_mails->toemail,id_to_screenname($obj_mails->toid));
				
				$mail->IsHTML(true);
				$mail->IsSMTP();
				
				$mail->send();
				
				$mail->ClearAddresses();
				
				@mysql_query("UPDATE `tblNewsletterMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
				sleep($obj->interval);
				$mailsent++;
			 }
			 
			 @mysql_query("UPDATE `tblNewsletter` SET `sent` = `sent` + " . $mailsent . " WHERE `id` = '" . $obj->id . "'");
		}
		else
		{
			echo "Newsletter " . $obj->id . " it's Finished! All mails was sent!!";
			@mysql_query("UPDATE `tblNewsletter` SET `finished` = 'Y', `running` = 'N' WHERE `id` = '" . $obj->id . "'");
		}
		
	}
} 
else 
{
	echo "No newsletter is running in this moment!";
}

/*                       END START CRON                                                   */
?>