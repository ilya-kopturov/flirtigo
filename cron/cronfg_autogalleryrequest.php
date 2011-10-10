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
$ps = exec("ps aux | grep cronfg_autogalleryrequest", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_autogalleryrequest.php") && !strstr($line, "/bin/sh -c"))
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

/* start cron */
$sqlRequests = mysql_query("SELECT m.`id`, m.`user_from`, m.`user_to`, m.`date_sent`, 
                                   ((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(m.`date_sent`)) / 60) as timedif
                            FROM  `tblMails` m 
                            INNER JOIN `tblAutoGalleryReply` a ON ( a.user_id = m.user_to ) 
                            WHERE m.`type` = 'R' AND m.`new` = 'Y' AND
                                 (
		                          (
		                            UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(m.`date_sent`)
		                           ) / 60
		                          ) >= a.`minutes`");

while($arrRequests = mysql_fetch_assoc($sqlRequests)){
	mailermachine($db, null, 'accept_request', 'internal', $arrRequests['user_from'], $arrRequests['user_to']);
	mailermachine($db, 'emailnotif', 'accept_request', 'external', $arrRequests['user_from'], $arrRequests['user_to']);
	echo "User_from: " . $arrRequests['user_from'] . ", User_to: " . $arrRequests['user_to'] . 
	     "Date_sent: " . $arrRequests['date_sent'] . "TimeDif: " . $arrRequests['timedif'] . "Now: " . date("Y-m-d H:i:s") . "<br/>\n";
	mysql_query("UPDATE `tblMails` SET `new` = 'N' WHERE `id` = " . $arrRequests['id']);
}
/* end cron */
?>