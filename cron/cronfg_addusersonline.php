<?php
/* DIRTYFLIRTING.COM */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

set_include_path(".:/home/httpd/vhosts/flirtigo.com/html/pear:/home/httpd/vhosts/flirtigo.com/html/includes");

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

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_addusersonline", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_addusersonline.php") && !strstr($line, "/bin/sh -c"))
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
 $min_online = 200;
 $max_online = 500;
 
 $rnd_online = mt_rand($min_online, $max_online);
 
 
 @$db->query("UPDATE `tblUsers` SET `typelogin` = NOW() ORDER BY rand() LIMIT " . $rnd_online);
 
 @$db->query("UPDATE `tblUsers` SET `typelogin` = NOW() WHERE `sex` = 1 ORDER BY rand() LIMIT " . mt_rand(32,64));
 @$db->query("UPDATE `tblUsers` SET `typelogin` = NOW() WHERE `sex` = 2 ORDER BY rand() LIMIT " . mt_rand(19,35));
 @$db->query("UPDATE `tblUsers` SET `typelogin` = NOW() WHERE `sex` = 3 ORDER BY rand() LIMIT " . mt_rand(22,30));
 
 @$db->close();
 
 echo "Done!\n";
 
/*                       END START CRON                                                   */
?>