<?
include("cnn.php");
?>
<html>
<head>
<link rel="stylesheet" href="../default.css" type="text/css">
</head>
<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table style="vertical-align:top" align="center" width="100%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">View Mail</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<?
				$themail = mysql_fetch_array(mysql_query("SELECT * FROM `tblTypeMails` WHERE `id` = '" . $_GET["id"] . "'"));
			?>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext"><b>From:</b></font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><? if($themail['folder'] == 1){ echo id_to_screenname($themail["user_from"]); } else { echo id_to_screenname($themail["user_to"]); }?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext"><b>To:</b></font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><?if($themail['folder'] == 1){ echo id_to_screenname($themail["user_to"]); } else { echo id_to_screenname($themail["user_from"]); }?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext"><b>Date:</b></font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><?=$themail["date_sent"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext"><b>Subject:</b></font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><?=$themail["subject"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext"><b>Message:</b></font></td>
					<td width="85%" align="left" valign="top" style="padding:5px 5px 5px 5px;"><font class="tabletext"><?=str_replace("\r\n","<br />",$themail["message"]) ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="center"><font class="tablecateg"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>
</table>
</body>
</html>
  