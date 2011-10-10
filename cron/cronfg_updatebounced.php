<?php
/* DIRTYFLIRTING.COM                                                                         
                                                                                           
                                                                                           
                                                                                         */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once($include_dir . "/includes/config/" . "db.php");
include_once($include_dir . "/includes/config/" . "path.php");
include_once($include_dir . "/includes/config/" . "image.php");
include_once($include_dir . "/includes/config/" . "option.php");
include_once($include_dir . "/includes/config/" . "profile.php");
include_once($include_dir . "/includes/config/" . "template.php");

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");


include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_updatebounced", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_updatebounced.php") && !strstr($line, "/bin/sh -c"))
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




/*                         START BOUNCE CRON                                                     */
 $sql = @mysql_query("SELECT * FROM `tblBounce` WHERE `updated` = 'N'");
 
 while($obj = mysql_fetch_object($sql))
 {
 	@$db->query("UPDATE `tblUsers`  SET `emailstatus` = 'B' WHERE `id`      = '" . $obj->user_id . "' and `email`='" . $obj->email ."' LIMIT 1");
 	@$db->query("UPDATE `tblBounce` SET `updated`     = 'Y' WHERE `user_id` = '" . $obj->user_id . "' and `email`='" . $obj->email. "'");
 	
// 	echo "Bounced Userid: " . $obj->user_id . ", Email:" . $obj->email . "\n";
 }
 
 echo "Hmmm ... nici un bounced.";
/*                       END START CRON                                                   */


/*                         START DEFERER CRON                                                     */
 $sql2 = @mysql_query("SELECT * FROM `tblDefered` WHERE `updated` = 'N'");
 
 while($obj2 = mysql_fetch_object($sql2))
 {
 	@$db->query("UPDATE `tblUsers`  SET `emailstatus` = 'D' WHERE `id`      = '" . $obj2->user_id . "' and `email`='" . $obj2->email . "' LIMIT 1");
 	@$db->query("UPDATE `tblDefered` SET `updated`     = 'Y' WHERE `user_id` = '" . $obj2->user_id . "' and `email`='" . $obj2->email. "'");
 	
// 	echo "Defered Userid: " . $obj2->user_id . ", Email:" . $obj2->email . "\n";
 }
 
 echo "Hmmm ... nici un defered.";
/*                       END START CRON                                                   */

?>