<form name="form2" action="index.php?content=statspayment" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">New Members</font></td>
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
					<td align="center" style="width:220px"><font class="tablecateg">Date</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">New Members</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">New Males</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">New Females</font></td>
			</tr>
			<? 
			$tdcolor="#f2f2f2";
		//calculate the number of months that are selected to be showned
		//$nrmonths=13-$monthfrom+$monthuntil+(($yearuntil-$yearfrom-1)*12);

		?>
			<?
				
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				
			?>
			<? 
			 $today = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d"),date("Y")));
			 $yesterday = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			 $sevendays  = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			 $twomonths  = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-60,date("Y")));
			 
			 $sql_t = mysql_query("SELECT COUNT(*) as count, sex FROM `tblUsers` WHERE `joined` >= '".$today."' GROUP BY `sex`");
			 while($obj_t = mysql_fetch_object($sql_t)){
			 	$row_t[$obj_t->sex] = $obj_t->count;
			 	$row_t['all'] += $obj_t->count;
			 }
			 
			 $sql_y = mysql_query("SELECT COUNT(*) as count, sex FROM `tblUsers` WHERE `joined` >= '".$yesterday."' GROUP BY `sex`");
			 while($obj_y = mysql_fetch_object($sql_y)){
			 	$row_y[$obj_y->sex] = $obj_y->count;
			 	$row_y['all'] += $obj_y->count;
			 }
			 
			 $sql_s = mysql_query("SELECT COUNT(*) as count, sex FROM `tblUsers` WHERE `joined` >= '".$sevendays."' GROUP BY `sex`");
			 while($obj_s = mysql_fetch_object($sql_s)){
			 	$row_s[$obj_s->sex] = $obj_s->count;
			 	$row_s['all'] += $obj_s->count;
			 }
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Today</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_t['all']?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_t[0] ?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_t[1];?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Yesterday</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_y['all']-$row_t['all'];?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_y[0]-$row_t[0];?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_y[1]-$row_t[1];;?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Last 7 Days</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_s['all']?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_s[0]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=(int)$row_s[1]?></font></td>
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
	<tr>
		<td width="100%"><font class="pagetitle">Total Members</font></td>
	</tr>
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
					<td align="center" style="width:110px"><font class="tablecateg">Total Members</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Total Free</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Total Silver</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Total Gold</font></td>
					<td align="center" style="width:110px"><font class="tablecateg">Total Reccuring</font></td>
					<td align="center" style="width:90px"><font class="tablecateg">Cancels</font></td>
			</tr>
			<? 
			$tdcolor="#f2f2f2";
		//calculate the number of months that are selected to be showned
		//$nrmonths=13-$monthfrom+$monthuntil+(($yearuntil-$yearfrom-1)*12);

		?>
			<?
				
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				
			?>

			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="center"><font class="tabletext"><?=number_format($row[0]+$row[1]+$row[2], 0, '', '.');?></font></td>
					<td align="center"><font class="tabletext"><?=number_format($row[0], 0, '', '.');?></font></td>
					<td align="center"><font class="tabletext"><?=number_format($row[1], 0, '', '.');?></font></td>
					<td align="center"><font class="tabletext"><?=number_format($row[2], 0, '', '.');?></font></td>
					<td align="center"><font class="tabletext"><?=number_format((($row[1]+$row[2])-($row[3]+$row[4]+$row[5])), 0, '', '.');?></font></td>
					<td align="center"><font class="tabletext"><?=number_format($row[3]+$row[4]+$row[5], 0, '', '.');?></font></td>
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
	if(document.getElementById('statistics1').style.display == 'none'){
		document.getElementById('statistics1').style.display = '';
	}
	if(document.getElementById('statistics2').style.display == 'none'){
		document.getElementById('statistics2').style.display = '';
	}
	if(document.getElementById('statistics3').style.display == 'none'){
		document.getElementById('statistics3').style.display = '';
	}
</script>