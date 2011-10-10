<?
session_set_cookie_params(0);
session_start();

require("includes/cnn.php");

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
			if(!isset($_SESSION["admin"]) || !isset($_SESSION["p_admin"])) {
				include("includes/login.php");
			} else {
				include("main.php");
			}
			?>
		</td>
	</tr>
	<!-- FOOTER LINE -->
	<tr>
		<td width="100%" style="background:url(pics/footer/backgr_footer.jpg)" height="60">
			<? include("bottom.php");?>
		</td>
	</tr>
</table>
</BODY>
</HTML>