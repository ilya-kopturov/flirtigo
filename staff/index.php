<?php
session_set_cookie_params(0);
session_start();


include_once realpath('./../includes/config') . '/common.php';		// fphp

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

//override server settings
@include_once('../includes/config/local.conf.php');


include("includes/functions.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

$db = new db( $cfg['db']['user'],
              $cfg['db']['password'],
              $cfg['db']['db'],
              $cfg['db']['host']
            );
?>
<html>
<head>
<title>FlirtiGo  - Staff</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="default.css" type="text/css">

<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.form.js"></script>
<script type="text/javascript" src="/js/validate/lib/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.dimensions.js"></script>
<script type="text/javascript" src="/js/jqModal.js"></script>
<script type="text/javascript" src="/js/ui.core.js"></script>
<script type="text/javascript" src="/tabs3/ui.tabs.js"></script>

<script type="text/javascript" src="/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/swfupload/swfupload.graceful_degradation.js"></script>
<script type="text/javascript" src="/swfupload/handlers.js"></script>
<script type="text/javascript" src="/swfupload/fileprogress.js"></script>

<script type="text/javascript" src="/js/parseuri.js"></script>
<script type="text/javascript" src="/captcha/captcha.js"></script>

<script type="text/javascript" src="/history/json2.js"></script>
<script type="text/javascript" src="/history/rsh.js"></script>

<script type="text/javascript" src="/js/common.js"></script>

<script language="javascript" type="text/javascript" src="includes/function.js"></script>
<script type='text/javascript' src='includes/calendar.js'></script>
<script type='text/javascript' src='includes/calendar-en.js'></script>
<script type='text/javascript' src='includes/calendar-setup.js'></script>
<link href='calendar2.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/js/jqModal.css">
</HEAD>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<!-- HEADER LINE -->

	<!-- BODY LINE -->
	<tr>
		<td>
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

</table>
</BODY>
</HTML>
