<form name="form2" action="index.php?content=statspayment" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Logins Statistics</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
	<td>
	<table style="vertical-align:top; width:610px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1" align="center">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:220px"><font class="tablecateg">Date</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Logins count</font></td>
			</tr>
			<? 
			$tdcolor="#f2f2f2";
		//calculate the number of months that are selected to be showned
		//$nrmonths=13-$monthfrom+$monthuntil+(($yearuntil-$yearfrom-1)*12);

				
			$tdcolor = ($tdcolor=="#f2f2f2") ? "#FFFFFF" : "#f2f2f2";

			 $sql_t = mysql_query(
			 	"SELECT
					COUNT(*) AS count
				FROM
					tblloginlog
				WHERE
				DATE(date) = CURDATE()"
			 );
			 $row = mysql_fetch_assoc($sql_t);
			 $today = $row['count'];
			 
			 $sql_t = mysql_query(
			 	"SELECT
					COUNT(*) AS count
				FROM
					tblloginlog
				WHERE
				DATE(date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)"
			 );
			 $row = mysql_fetch_assoc($sql_t);
			 $yesterday = $row['count'];
			 
			 $sql_t = mysql_query(
			 	"SELECT
					COUNT(*) AS count
				FROM
					tblloginlog
				WHERE
				DATE(date) > DATE_SUB(CURDATE(), INTERVAL 7 DAY)"
			 );
			 $row = mysql_fetch_assoc($sql_t);
			 $last_week = $row['count'];
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Today</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?= $today ?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Yesterday</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?= $yesterday ?></font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext">Last 7 Days</font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?= $last_week ?></font></td>
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