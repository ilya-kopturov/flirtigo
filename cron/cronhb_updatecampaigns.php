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

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronhb_updatecampaigns", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronhb_updatecampaigns.php") && !strstr($line, "/bin/sh -c"))
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

$sql = mysql_query("SELECT * FROM `tblCampaign` WHERE `finishedaddmails` = 'Y' AND `ready` = 'Y' AND `finished` = 'N' AND `running` = 'Y' ORDER BY `id` ASC");
$nrows = mysql_num_rows($sql);

if($nrows > 0)
{
	while($obj = mysql_fetch_object($sql)){
		list($update_campaign_b) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'B'"));
		
		list($update_campaign_d) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'D'"));
		
		@mysql_query("UPDATE `tblCampaign` SET `bounced` = '" . $update_campaign_b . "', `defered` = '" . $update_campaign_d . "' WHERE `id` = '" . $obj->id . "' LIMIT 1");
		
		echo "Campaign id: " . $obj->id . ", Bounced: " . $update_campaign_b . ", Defered: " . $update_campaign_d . "\n";
	}
}
else 
{
	echo "No campaign is running in this moment!";
}

/*                       END START CRON                                                   */
?>
