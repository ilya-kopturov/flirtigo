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

/*$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );*/
$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
            
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_updateupgraded", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_updateupgraded.php") && !strstr($line, "/bin/sh -c"))
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




/*                         START CRON                                                     */
 $one = date("Y-m-d H:i:s", time() - 30*60);
 
 $sql = @mysql_query("SELECT `id`, `email` FROM `tblUsers` WHERE (`accesslevel` = '1' OR `accesslevel` = '2') AND `upgraded` >= '" . $one . "' ");
 
 while($obj = mysql_fetch_object($sql))
 {
 	$c_id = @$db->get_var("SELECT `campaignid` FROM `tblCampaignMails` WHERE `sent` = 'Y' AND `toemail` = '" . $obj->email . "' ORDER BY `id` DESC LIMIT 1");
 	
 	if((int) $c_id > 0){
 		@$db->query("UPDATE `tblCampaign` SET `upgraded` = `upgraded` + 1 WHERE `id` = '" . (int) $c_id . "' LIMIT 1");
 	}
 	
 	echo "Userid: " . $obj->id . ", Email:" . $obj->email . ", Campaign: " . $c_id . ", DATE: " . $one . "\n";
 }
 
 echo ":-( Last hour - no money ... !!! ";
/*                       END START CRON                                                   */
?>