<form name="form2" action="index.php?content=statspayment" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Upgrades</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
	<td>
	<table style="vertical-align:top; width:610px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td width="220" align="center" style="width:420px"><font class="tablecateg">Username</font></td>
					<td width="246" align="center" style="width:350px"><font class="tablecateg">Time betwen login and upgrade</font></td>
			</tr>
			<? 
			$tdcolor="#f2f2f2";
		//calculate the number of months that are selected to be showned
		//$nrmonths=13-$monthfrom+$monthuntil+(($yearuntil-$yearfrom-1)*12);
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}

			$qry_today=mysql_query("SELECT now()");
			$row_today=mysql_fetch_array($qry_today); 
			$today=$row_today[0];
			//PayedMember
			$qry_upgr=mysql_query("SELECT *,datediff(`Upgraded`,`Joined` ) as `DIFER` from tblUsers ");
			while($row_upgr=mysql_fetch_array($qry_upgr)){
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$row_upgr['ScreenName']?></font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					<? if($row_upgr['DIFER']>0){ echo $row_upgr['DIFER']." days"; } else{ 
					if($row_upgr['PayedMember']==0){
					echo "User has not upgraded";
					}else{
						if($row_upgr['PayedMember']==1){ echo "SILVER";}
						if($row_upgr['PayedMember']==2){ echo "GOLD";}
					}
					
					}?> </font></td>
			</tr>	
			<? }?>		
			<tr>
				<td colspan="14" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="14" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
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