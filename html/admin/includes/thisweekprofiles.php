<?
	$sql_countries = mysql_query("SELECT * FROM `tblCountries`");
	while($obj_countries = mysql_fetch_object($sql_countries))
	{
		$country[$obj_countries->id] = $obj_countries->name;
	}
?>

<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">This Week Approved Profiles</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	   <?
			    $qry_user="select * from `tblUsers` where `approved` = 'Y' AND `approveddate` >= '" . date("Y-m-d", mktime(0,0,0,date("m"),date("d")-7,date("Y")))  . "'";
				$qry1=mysql_query($qry_user);
		?>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">Profiles</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td   height="25" bgcolor="#FFFFFF" width="100%">
					
					<table width="100%" cellpadding="1" cellspacing="1">
						<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
							<td align="center" width="3%"></td>
							<td align="center" width="19%"><strong>Username</strong></td>
							<td align="center" width="26%"><strong>Intro Title</strong></td>
							<td align="center" width="26%"><strong>Intro Text</strong></td>
							<td align="center" width="26%"><strong>Describe</strong></td>
						</tr>
			            <tr>
				            <td colspan="5" height="1" bgcolor="#990000" width="100%"></td>
			            </tr>
						<? 
							$tdcolor=="#f2f2f2";
							while($theuser=mysql_fetch_array($qry1))
							{
								if($tdcolor=="#f2f2f2"){
									$tdcolor="#FFFFFF";
								} else {
									$tdcolor="#f2f2f2";
								}
						?>
						<tr bgcolor="<?=$tdcolor;?>" align="center" style="font-size:13px; font-face:Verdana;" height="35" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor;?>'">
							<td></td>
							<td>Approved by: <b><?=idtooperator($theuser["approvedby"]);?></b><br><br><br><a href="javascript: window.open('viewprofile.php?id=<?=$theuser["id"];?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=$theuser["screenname"];?></a><br><br> <b>Sex:</b> <?=$cfg['profile']['sex'][$theuser["sex"]];?> <br><br> <b>Profile Town,Country:</b><br> <?=ucfirst($theuser["city"]);?>, <?if(strtolower($country[$theuser["country"]]) != strtolower(ip2country($theuser['lastip']))) echo "<font color='red'>"; else echo "<font color='black'>";?> <?=$country[$theuser["country"]];?> </font> <br><br><b>Posted from:</b><br> <?=$theuser["lastip"];?>, <?if(strtolower($country[$theuser["country"]]) != strtolower(ip2country($theuser['lastip']))) echo "<font color='red'>"; else echo "<font color='black'>";?><?=strtoupper(ip2country($theuser['lastip']));?></font></td>
							<td align="center">
							  <span id="text_introtitle[<?=$ai;?>]"><?=bannedwords($db,"E",$theuser["introtitle"])?></span>
							</td>
							<td align="center">
							  <span id="text_introtext[<?=$ai;?>]"><?=bannedwords($db,"E",$theuser["introtext"])?></span>
							</td>
							<td align="center">
							  <span id="text_describe[<?=$ai;?>]"><?=bannedwords($db,"E",$theuser["describe"])?></span>
							</td>
						</tr>
						<? }?>
					</table>
					
				</td>
			</tr>
			
			 <tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
</table>

<script language="JavaScript">
	if(document.getElementById('users1').style.display == 'none'){
		document.getElementById('users1').style.display = '';
	}
	if(document.getElementById('users2').style.display == 'none'){
		document.getElementById('users2').style.display = '';
	}
	if(document.getElementById('users3').style.display == 'none'){
		document.getElementById('users3').style.display = '';
	}
	if(document.getElementById('users4').style.display == 'none'){
		document.getElementById('users4').style.display = '';
	}
	if(document.getElementById('users5').style.display == 'none'){
		document.getElementById('users5').style.display = '';
	}
	if(document.getElementById('users6').style.display == 'none'){
		document.getElementById('users6').style.display = '';
	}
	if(document.getElementById('users7').style.display == 'none'){
		document.getElementById('users7').style.display = '';
	}
	if(document.getElementById('users8').style.display == 'none'){
		document.getElementById('users8').style.display = '';
	}
	if(document.getElementById('users9').style.display == 'none'){
		document.getElementById('users9').style.display = '';
	}
	if(document.getElementById('users10').style.display == 'none'){
		document.getElementById('users10').style.display = '';
	}
	if(document.getElementById('users11').style.display == 'none'){
		document.getElementById('users11').style.display = '';
	}
</script>