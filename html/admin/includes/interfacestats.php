<?
$yesterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$thisweek = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$currentmonth = date("Y-m", mktime(0,0,0,date("m"),date("d"),date("Y")));
$lastmonth = date("Y-m", mktime(0,0,0,date("m")-1,date("d"),date("Y")));

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
					<td rowspan="2" align="center" style="width:200px"><font class="tablecateg">Operator/Time</font></td>
					<td colspan="4" align="center"><font class="tablecateg">Total Messages replied</font></td>

			</tr>
			
			                                        
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:340px"><font class="tablecateg">Yesterday</font></td>
					<td align="center" style="width:270px"><font class="tablecateg">Last 7 Days</font></td>
					<td align="center" style="width:270px"><font class="tablecateg">Curent Month</font></td>
					<td align="center" style="width:270px"><font class="tablecateg">Last Month</font></td>

			</tr>
			<?php
			
			$yesterday_total=0;
			$thisweek_total=0;
			$currentmonth_total=0;
			$lastmonth_total=0;
			
			$qry_sel=mysql_query("SELECT * FROM tblAdmin");
			while($rows=mysql_fetch_array($qry_sel)){
			                    
			$yesterday_stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $yesterday ."%' AND `operator_id` = '".$rows['id']."'"));
			$thisweek_stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` >= '" . $thisweek ."' AND `operator_id` = '".$rows['id']."'"));
			$currentmonth_stats   = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $currentmonth ."%' AND `operator_id` = '".$rows['id']."'"));
			$lastmonth_stats  = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `folder` = 2 AND `date_sent` like '" . $lastmonth ."%' AND `operator_id` = '".$rows['id']."'"));

			$yesterday_total=$yesterday_total+$yesterday_stats['count'];
			$thisweek_total=$thisweek_total+$thisweek_stats['count'];
			$currentmonth_total=$currentmonth_total+$currentmonth_stats['count'];
			$lastmonth_total=$lastmonth_total+$lastmonth_stats['count'];						                    
			                    
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td align="left">&nbsp;<font class="tabletext"><?echo $rows['user']?></font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$yesterday_stats['count']?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$thisweek_stats['count']?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$currentmonth_stats['count']?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$lastmonth_stats['count']?></font></td>
			</tr>
			<?}?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td align="left">&nbsp;<font class="tabletext">TOTALS</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$yesterday_total?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$thisweek_total?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$currentmonth_total?></font></td
					<td align="center">&nbsp;&nbsp;<font class="tabletext">&nbsp;&nbsp;</font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$lastmonth_total?></font></td>
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

<script language="JavaScript">
	if(document.getElementById('chatinterface1').style.display == 'none'){
		document.getElementById('chatinterface1').style.display = '';
	}
	if(document.getElementById('chatinterface2').style.display == 'none'){
		document.getElementById('chatinterface2').style.display = '';
	}
	if(document.getElementById('chatinterface3').style.display == 'none'){
		document.getElementById('chatinterface3').style.display = '';
	}
	if(document.getElementById('chatinterface4').style.display == 'none'){
		document.getElementById('chatinterface4').style.display = '';
	}
	if(document.getElementById('chatinterface5').style.display == 'none'){
		document.getElementById('chatinterface5').style.display = '';
	}
	if(document.getElementById('chatinterface6').style.display == 'none'){
		document.getElementById('chatinterface6').style.display = '';
	}
</script>
