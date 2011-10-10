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

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES */


/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_livecams", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_livecams.php") && !strstr($line, "/bin/sh -c"))
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

/**
 * Get Amateur Cams
 */
$access_id = 'UV5HZVCE'; 
$niche     = 'amateur';

$file      = '/home/httpd/vhosts/flirtigo.com/html/livecams.php';

$string = file_get_contents('http://camz.com/app/xml/get_schedule/index.php?access_id='.$access_id.'&niche='.$niche);

if(strlen($string) > 1000){
	$fp = fopen($file, "w");
	fwrite($fp, $string);
	fclose($fp);
}

/**
 * Get Pornstar Cams
 */
$niche     = 'pornstar';

$file      = '/home/httpd/vhosts/flirtigo.com/html/livecamsp.php';

$string = file_get_contents('http://camz.com/app/xml/get_schedule/index.php?access_id='.$access_id.'&niche='.$niche);

if(strlen($string) > 1000){
	$fp = fopen($file, "w");
	fwrite($fp, $string);
	fclose($fp);
}
/* end start cron */
?>