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
$ps = exec("ps aux | grep cronhb_testmovies", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronhb_testmovies.php") && !strstr($line, "/bin/sh -c"))
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
$sql_videos = mysql_query("SELECT * FROM `tblVideos` WHERE `approved` = 'Y'");

while($obj = mysql_fetch_object($sql_videos)){
	$isfile = is_file("/home/httpd/vhosts/flirtigo.com/html/media/media/videos/" . $obj->user_id . "_" . $obj->id .".flv");
	//if($isfile){
	echo "ID: " . $obj->id . ", UserId: " . $obj->user_id . "ISFILE: " . $isfile . "<br/>";
	echo "<img src='http://www.flirtigo.com/videothumb.php?id=" . $obj->id ."&user_id=" . $obj->user_id . "'/>";
	echo "<br/><br/>";
	//}else{
		//mysql_query("DELETE FROM `tblVideos` WHERE `id` = '" . $obj->id . "' LIMIT 1");
	//}
	@mysql_query("update `tblUsers` SET `withvideo` = 'Y' WHERE `id` = '" . $obj->user_id . "'");
}
/* end start cron */
?>