<form method="post" action="index.php?content=statspayment">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Payment Record </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="left" valign="middle" bgcolor="#EEEEEE" style="border:1px solid #CCCCCC">
		            
					<table id="filterdiv" bgcolor="#EEEEEE" style="vertical-align:middle" align="left" border="0" cellpadding="0" cellspacing="4" class="filternameblack" width="100%">
					
					<? 
						if(!empty($_POST["monthfrom"])){
							$monthfrom=$_POST["monthfrom"];
						} else {
							$monthfrom="01";
						}
						if(!empty($_POST["monthuntil"])){
							$monthuntil=$_POST["monthuntil"];
						} else {
							$monthuntil="12";
						}
						if(!empty($_POST["yearfrom"])){
							$yearfrom=$_POST["yearfrom"];
						} else {
							$yearfrom="2008";
						}
						if(!empty($_POST["yearuntil"])){
							$yearuntil=$_POST["yearuntil"];
						} else {
							$yearuntil="2008";
						}
					?>
					
					<tr>
						<td colspan="2" width="100%" align="left">
						Filter by period: <select name="monthfrom" class="tabletext">
						<option value="01"<? if(monthfrom=="01") echo " selected='selected'" ?>>January</option>
						<option value="02"<? if($monthfrom=="02") echo " selected='selected'" ?>>February</option>
						<option value="03"<? if($monthfrom=="03") echo " selected='selected'" ?>>March</option>
						<option value="04"<? if($monthfrom=="04") echo " selected='selected'" ?>>April</option>
						<option value="05"<? if($monthfrom=="05") echo " selected='selected'" ?>>May</option>
						<option value="06"<? if($monthfrom=="06") echo " selected='selected'" ?>>June</option>
						<option value="07"<? if($monthfrom=="07") echo " selected='selected'" ?>>July</option>
						<option value="08"<? if($monthfrom=="08") echo " selected='selected'" ?>>August</option>
						<option value="09"<? if($monthfrom=="09") echo " selected='selected'" ?>>September</option>
						<option value="10"<? if($monthfrom=="10") echo " selected='selected'" ?>>Octomber</option>
						<option value="11"<? if($monthfrom=="11") echo " selected='selected'" ?>>November</option>
						<option value="12"<? if($monthfrom=="12") echo " selected='selected'" ?>>December</option>
						</select> <select name="yearfrom" class="tabletext">
						<?
							for($i=2007;$i<=2010;$i++){
						?>
						<option value="<?=$i ?>"<? if($yearfrom==$i) echo " selected='selected'" ?>><?=$i?></option>
						<? } ?>
						</select> to: <select name="monthuntil" class="tabletext">
						<option value="01"<? if($monthuntil=="01") echo " selected='selected'" ?>>January</option>
						<option value="02"<? if($monthuntil=="02") echo " selected='selected'" ?>>February</option>
						<option value="03"<? if($monthuntil=="03") echo " selected='selected'" ?>>March</option>
						<option value="04"<? if($monthuntil=="04") echo " selected='selected'" ?>>April</option>
						<option value="05"<? if($monthuntil=="05") echo " selected='selected'" ?>>May</option>
						<option value="06"<? if($monthuntil=="06") echo " selected='selected'" ?>>June</option>
						<option value="07"<? if($monthuntil=="07") echo " selected='selected'" ?>>July</option>
						<option value="08"<? if($monthuntil=="08") echo " selected='selected'" ?>>August</option>
						<option value="09"<? if($monthuntil=="09") echo " selected='selected'" ?>>September</option>
						<option value="10"<? if($monthuntil=="10") echo " selected='selected'" ?>>Octomber</option>
						<option value="11"<? if($monthuntil=="11") echo " selected='selected'" ?>>November</option>
						<option value="12"<? if($monthuntil=="12") echo " selected='selected'" ?>>December</option>
						</select> <select name="yearuntil" class="tabletext">
						<?
							for($i=2007;$i<=2013;$i++){
						?>
						<option value="<?=$i ?>"<? if($yearuntil==$i) echo " selected='selected'" ?>><?=$i?></option>
						<? } ?>
						</select> 
                       <input type="hidden" name="submitfilter" value="Filter" />
						<input type="submit" name="thesubmit" value="Filter" /></td>
					</tr>
					
					</table>	
		
		  </td>
	</tr>
	
		<?
		for($y=$yearfrom;$y<=$yearuntil;$y++){
			if($y!=$yearuntil){
				$maxmonth=12;
			}else{
				$maxmonth=$monthuntil;
			}
			if($y!=$yearfrom){
				$minmonth=01;
			}else{
				$minmonth=$monthfrom;
			}
		?>	
	<tr>
		<td align="center"><font class="tablename">Year: <?=$y ?></font></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:490px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:220px"><font class="tablecateg">Date</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Total users</font></td>
			   <!--<td align="center" style="width:120px"><font class="tablecateg">Total fee</font></td> -->
					<td align="center" style="width:120px"><font class="tablecateg">Operations</font></td>
			</tr>
			<? 
			$tdcolor="#f2f2f2";
		//calculate the number of months that are selected to be showned
		//$nrmonths=13-$monthfrom+$monthuntil+(($yearuntil-$yearfrom-1)*12);
		
		
			for($m=$minmonth;$m<=$maxmonth;$m++){
				//select from database the months
				$datefrom=$y."-".$m."-01 00:00:00";
				$dateuntil=$y."-".$m."-31 23:59:59";
				$qry="select `id` from `tblUsers` where (`accesslevel` = '1' or `accesslevel` = '2') AND `upgraded` >= '".$datefrom."' AND `upgraded` <= '".$dateuntil."'";
				//echo "<tr><td>".$qry."</td></tr>";
				$qry=mysql_query($qry);
				$nr_found=mysql_num_rows($qry);
				if($nr_found>0){
		?>
			<?
				
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				
			?>
			<form method="post" action="index.php?content=users">
			  <input type="hidden" name="joined" value="" />
			  <input type="hidden" name="joineduntil" value="" />
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=Date_Month($m) ?></font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$nr_found ?></font></td>
					<!--<td align="center">&nbsp;&nbsp;<font class="tabletext"><? //$feetotal=mysql_fetch_array(mysql_query("select SUM(Fee) from tblPayments where Date>='".$datefrom."' and Date<='".$dateuntil."'")); echo $feetotal[0] ?></font></td> -->
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><input type="hidden" name="upgraded" value="<?=$y?>-<?=$m?>-01" /><input type="hidden" name="upgradeduntil" value="<?=$y?>-<?=$m?>-31" /><input type="hidden" name="accesslevel" value="4" /><input type="submit" value="Show users" /></font></td>
			</tr>
			</form>
			<? 
				}
			}
		
		?>
			
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
	<? } ?>
	<tr>
	<td>
	<table style="vertical-align:top; width:490px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:305px"><font class="tablecateg">Total payed members: <font color="#990000"><?list($count_pay) = mysql_fetch_array(mysql_query("select count(*) from `tblUsers` where (`accesslevel` = '1' or `accesslevel` = '2') and `upgraded` != '00-00-00 00:00:00'")); echo number_format($count_pay, 0, '', '.'); ?></font> </font></td>
					<td align="center" style="width:305px"><font class="tablecateg">Total free members: <font color="#990000"><?list($count_free) =  mysql_fetch_array(mysql_query("select count(*) from `tblUsers` where `accesslevel` = '0' OR (`accesslevel` != '0' and `upgraded` = '00-00-00 00:00:00')")); echo number_format($count_free, 0, '', '.'); ?></font></font></td>
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