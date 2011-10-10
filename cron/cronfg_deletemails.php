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
$ps = exec("ps aux | grep cronfg_deletemails", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_deletemails.php") && !strstr($line, "/bin/sh -c"))
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

$lastsixmonth = date("Y-m-d H:i:s",mktime(0,0,0,date("m")-2,date("d"),date("Y")));
// $lastsixmonth = date("Y-m-d H:i:s",mktime(0,0,0,date("m")-6,date("d"),date("Y")));
echo "Two months: " . $lastsixmonth . "\n";


@$db->query("DELETE FROM `tblMails`        WHERE `date_sent` <= '" . $lastsixmonth . "'");
//@$db->query("DELETE FROM `tblTypeMails`    WHERE `date_sent` <= '" . $lastsixmonth . "'");
//@$db->query("DELETE FROM `tblTypeWhispers` WHERE `date_sent` <= '" . $lastsixmonth . "'");


/*    delete trash    */

$sevendays = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-7,date("Y")));

echo "Seven days: " . $sevendays . "\n";

/*
//@$db->query("DELETE FROM `tblMails`        WHERE `folder` = 3 AND `date_sent` <= '" . $sevendays . "'");
//@$db->query("DELETE FROM `tblTypeMails`    WHERE `folder` = 3 AND `date_sent` <= '" . $sevendays . "'");
//@$db->query("DELETE FROM `tblTypeWhispers` WHERE `folder` = 3 AND `date_sent` <= '" . $sevendays . "'");

*/

/*                       END START CRON                                                   */
?>
