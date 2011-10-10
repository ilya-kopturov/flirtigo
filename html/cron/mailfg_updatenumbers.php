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
$ps = exec("ps aux | grep mailfg_updatenumbers", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "mailfg_updatenumbers.php") && !strstr($line, "/bin/sh -c"))
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
//$campaignid="658";

$sql_mails = mysql_query("SELECT * FROM `tblMailQuick` WHERE `sent` = 'Y'");

$nrows_mails = mysql_num_rows($sql_mails);

if($nrows_mails > 0)
{
  while($obj = mysql_fetch_object($sql_mails))
  {
 if ($obj->campaignid!=null) $cmpid=$obj->campaignid;
    @mysql_query("Update `tblCampaignMails` set sent='Y' where id='$obj->sendid'");
    @mysql_query("Update `tblCampaign` set `sent`=`sent`+1 where id='".$obj->campaignid."'");
    @mysql_query("delete from `tblMailQuick` where id='$obj->id'");
  }                                                                                                    

$qry="SELECT recipients,sent FROM `tblCampaign` where id='$cmpid' limit 1";
$sql_mails2 = mysql_query($qry);
while($obj = mysql_fetch_object($sql_mails2))
 if  ( $obj->recipients == $obj->sent )  @mysql_query("UPDATE `tblCampaign` SET `quicktable` = 'N' WHERE `id` = '" . $cmpid . "'");

}


/*                       END START CRON                                                   */
?>
