<?php
/* DIRTYFLIRTING.COM */

define("IN_MAINSITE", TRUE);

include ("./includes/" . "require" . "/" . "site_head.php");

$fb_coockie_id = "fbsr_" . $cfg['facebook']['app_id'];
if(isset($fb_coockie_id)) {
    setcookie("fbsr_" . $cfg['facebook']['app_id'], '', time()-3600, "/");
}

session_unregister("login_type");
session_unregister("sess_id");
session_unregister("sess_screenname");
session_unregister("sess_pass");
session_unregister("sess_sex");
session_unregister("sess_looking");
session_unregister("sess_accesslevel");
session_unregister("sess_rating");
session_unregister("sess_stats");
session_unregister("sess_newmails");

session_destroy();

header_location($cfg['path']['url_site']);
//print "<script type='text/javascript'>top.location = '" . $cfg['facebook']['canvas_url'] . "'</script>";

include ("./includes/" . "require" . "/" . "site_foot.php");
