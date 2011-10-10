<?
$yeasterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$thisweek = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$currentmonth = date("Y-m", mktime(0,0,0,date("m"),date("d"),date("Y")));
$lastmonth = date("Y-m", mktime(0,0,0,date("m")-1,date("d"),date("Y")));

$stats["yeasterday"] = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $yeasterday ."%'"));
$stats["thisweek"]   = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` >= '" . $thisweek ."'"));
$stats["currentmonth"]   = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $currentmonth ."%'"));
$stats["lastmonth"]   = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $lastmonth ."%'"));
?>
<form name="form2" action="index.php?content=statspayment" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Interface Stats</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
	<td>
	<table style="vertical-align:top; width:610px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:340px"><font class="tablecateg">Date</font></td>
					<td align="center" style="width:270px"><font class="tablecateg">Total Messages replied</font></td>

			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td align="left">&nbsp;<font class="tabletext">Yesterday</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$stats["yeasterday"]["count"];?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
					<td align="left">&nbsp;<font class="tabletext">This week</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$stats["thisweek"]["count"];?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td align="left">&nbsp;<font class="tabletext">Current month</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$stats["currentmonth"]["count"];?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
					<td align="left">&nbsp;<font class="tabletext">Last month</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$stats["lastmonth"]["count"];?></font></td>
			</tr>
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="14" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"></font></td>
					<td width="50%" align="right">
					</td>
				</tr>
				</table>			
				</td>
			</tr>
			
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
</table>
</form>