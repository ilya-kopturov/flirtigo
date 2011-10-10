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

/* ................................ end of check  ........................................*/




/*                         START CRON                                                     */

$nr = 0;
$max = 50;

$query = mysql_query("SELECT * FROM `tblUsers` WHERE `state` > 61");

while($obj = mysql_fetch_object($query))
{
	list($id) = mysql_fetch_array(mysql_query("SELECT `id` FROM `tblStates` WHERE `smid` = '" . $obj->state . "'"));
	
	mysql_query("UPDATE `tblUsers` SET `state` = '" . $id . "' WHERE `id` = '" . $obj->id . "'");
	
	//echo "id: " . $id . ", state_id: " . $obj->state . ", user_id: " . $obj->id . "<br/>";
}

echo "Done";

//$upload_date = date("Y-m-d", mktime(0,0,0,5,13+$upload,2006) );
//@$db->query("UPDATE `tblPhotos` SET `upload_date` = ''");
/*                       END START CRON                                                   */
?>