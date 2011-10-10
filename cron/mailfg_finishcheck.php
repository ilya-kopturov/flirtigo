<?php
/* HOOKUPHOTEL.COM  */

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
/* end INCLUDES  */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep mailfg_finishcheck", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "mailfg_finishcheck.php") && !strstr($line, "/bin/sh -c"))
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

$sql_running_camps = mysql_query("Select * from tblCampaign where running='Y' and finished='N'");
$nrows_running_camps = mysql_num_rows($sql_running_camps);
if($nrows_running_camps)
{
  while($objcamps= mysql_fetch_object($sql_running_camps))
  {
    $sql_finish   = mysql_query("SELECT * FROM `tblCampaignMails` WHERE `sent` = 'N' AND `campaignid` = '" . $objcamps->id ."' Limit 10");
    $nrows_finish = mysql_num_rows($sql_finish);
    if($nrows_finish < 10)
    {
    list($update_campaign_b) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
                            WHERE t1.campaignid = '" . $objcamps->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'B'"));
				
    list($update_campaign_d) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
                            WHERE t1.campaignid = '" . $objcamps->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'D'"));
				
    @mysql_query("UPDATE `tblCampaign` SET `bounced` = '" . $update_campaign_b . "', `defered` = '" . $update_campaign_d . "' WHERE `id` = '" . $objcamps->campaignid . "' LIMIT 1");
			
    echo "Campaign " . $objcamps->id . " it's Finished! All mails was sent!!";
    @mysql_query("UPDATE `tblCampaign` SET `finished` = 'Y', `running` = 'N', `finishedon` = NOW() WHERE `id` = '" . $objcamps->id . "'");
    }
  }    
}

/*                       END START CRON                                                   */
?>
