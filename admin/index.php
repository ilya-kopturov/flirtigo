<?
session_set_cookie_params(0);
session_start();


include_once realpath('./../includes/config') . '/common.php';		// fphp

require("includes/cnn.php");

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "countries.php");

@include('../includes/config/local.conf.php');

include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");


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


if (empty($_GET["content"])) {
	$result = mysql_query(
		"SELECT
			*
		FROM
			`tblsettings`
		WHERE
			`key` = 'admin_start_page'"
	);
	$row = mysql_fetch_assoc($result);
	
	header("Location: " . $row['value']);
	die;
}


?>
<html>
<head>
<title>MANAGEME - CONTENT MANAGER</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="default.css" type="text/css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="includes/function.js"></script>
<script type="text/javascript" src="/js/hb.jgz"></script>
<script type='text/javascript' src='includes/calendar.js'></script>
<script type='text/javascript' src='includes/calendar-en.js'></script>
<script type='text/javascript' src='includes/calendar-setup.js'></script>
<link href='calendar2.css' rel='stylesheet' type='text/css'>
</HEAD>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<!-- HEADER LINE -->
	<tr>
		<td width="100%" style="background:url(pics/header/backgr_header.jpg)" height="60">
			<? include("top.php");?>
		</td>
	</tr>
	<!-- BODY LINE -->
	<tr>
		<script language="javascript" type="text/javascript">
		getheight();
		document.write("<td width='100%' align='center' height='"+$h+"' valign='middle'>");
		</script>
		<?php
				include("main.php");
			?>
		</td>
	</tr>
	<!-- FOOTER LINE -->
	<tr>
		<td width="100%" style="background:url(pics/footer/backgr_footer.jpg)" height="60">
			<? include("bottom.php");?>		</td>
	</tr>
</table>
</BODY>
</HTML>

<?php
@$db->close();
?>