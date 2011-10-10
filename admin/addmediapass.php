<?
session_set_cookie_params(0);
session_start();

define("IN_MAINSITE", TRUE);

include('../includes/require/site_head.php');

require("includes/cnn.php");


include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

/*
$db = new db( $cfg['db']['user'],
              $cfg['db']['password'],
              $cfg['db']['db'],
              $cfg['db']['host']
            );
*/
$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
?>
<html>
<head>
<title>MANAGEME - CONTENT MANAGER</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="default.css" type="text/css">
<script language="javascript" type="text/javascript" src="includes/function.js"></script>
<script type='text/javascript' src='includes/calendar.js'></script>
<script type='text/javascript' src='includes/calendar-en.js'></script>
<script type='text/javascript' src='includes/calendar-setup.js'></script>
<link href='calendar2.css' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
	include_once("includes/gallery_autoreply2.php")
?>
</body>
</html>

<?php
@$db->close();
?>