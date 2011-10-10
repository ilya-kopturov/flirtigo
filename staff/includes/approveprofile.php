<script language="javascript" type="text/javascript">
function checkAll()
{
	var cbs = document.forms["approveprofile"].elements;
	if(cbs)
	{
		if(cbs.length)
		{
			for (var i=0; i<cbs.length; i++)
			{       
				cbs[i].checked = document.forms["approveprofile"].elements["selectAll"].checked;
			}
		}
		else 
		{
			cbs.checked = document.forms["approveprofile"].elements["selectAll"].checked;
		}
	}
}
function setdisplay(element1, element2)
{
	document.getElementById(element1).style.display = 'none';
	document.getElementById(element2).style.display = '';
}
</script>
<?php
	
	if($_POST["actiune"]=="approve")
	{
		
		foreach($_POST['approve'] as $key=>$value)
		{
			@mysql_query("UPDATE `tblUsers` SET `introtitle` = '" . addslashes($_POST["introtitle"][$key]) . "', 
			                                   `introtext` = '" . addslashes($_POST["introtext"][$key]) . "', 
			                                   `describe` = '" . addslashes($_POST["describe"][$key]) . "', 
											   `approvedby` = '" . $_SESSION['admin'] . "', 
											   `approveddate` = NOW(), 
			                                   `approved` = 'Y' WHERE `id` = '".$value."'");
			
			//@mysql_query("UPDATE `tblUsers` SET `firsttime` = 'N' WHERE `id` = '".$value."' AND `firsttime` = 'Y'");
			@mysql_query("DELETE FROM `tblUpdateProfile` WHERE `user_id` = '" . $value . "'");
		}
	}
	
	
	if($_POST["actiune"]=="dissapprove")
	{
		
		foreach($_POST['approve'] as $key=>$value)
		{
			@mysql_query("UPDATE `tblUsers` SET `approved` = 'Y' WHERE `id` = '".$value."'");
			
			@mysql_query("DELETE FROM `tblUpdateProfile` WHERE `user_id` = '" . $value . "'");
		}
	}
	
	
	if($_POST["actiune"]=="blockaccounts")
	{
		foreach($_POST['approve'] as $key=>$value)
		{
			@mysql_query("UPDATE `tblUsers` SET `approved` = 'N',`disabled` = 'Y' WHERE `id` = '".$value."'");
			
			@mysql_query("DELETE FROM `tblUpdateProfile` WHERE `user_id` = '" . $value . "'");
		}
	}
	
	$sql_countries = mysql_query("SELECT * FROM `tblCountries`");
	while($obj_countries = mysql_fetch_object($sql_countries))
	{
		$country[$obj_countries->id] = $obj_countries->name;
	}
?>

<form name="approveprofile" method="post" action="index.php?content=approveprofile">
	<input type="hidden" name="actiune" id="actiune" value="" />

<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Approve Profiles</font></td>
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
			   $qry_user="select * from `tblUsers` where `approved` = 'N' AND `disabled` = 'N' LIMIT 100";
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
							<td align="center" width="3%"><input onclick="javascript: checkAll();" type="checkbox" name="selectAll"></td>
							<td align="center" width="19%"><strong>Username</strong></td>
							<td align="center" width="26%"><strong>Intro Title</strong></td>
							<td align="center" width="26%"><strong>Intro Text</strong></td>
							<td align="center" width="26%"><strong>Describe</strong></td>
						</tr>
			            <tr>
				            <td colspan="5" height="1" bgcolor="#990000" width="100%"></td>
			            </tr>
						<? 
							$tdcolor=="#f2f2f2"; $ai = 0;
							while($theuser=mysql_fetch_array($qry1))
							{
								if($tdcolor=="#f2f2f2"){
									$tdcolor="#FFFFFF";
								} else {
									$tdcolor="#f2f2f2";
								}
								
								$infos = @mysql_fetch_array(mysql_query("SELECT * FROM `tblUpdateProfile` WHERE `user_id` = '" . $theuser['id'] . "' LIMIT 1"));
						?>
						<tr bgcolor="<?=$tdcolor;?>" align="center" style="font-size:13px; font-face:Verdana;" height="35" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor;?>'">
							<td><input type="checkbox" name="approve[<?=$ai?>]"  value="<?=$theuser["id"];?>"></td>
							<td><br><a href="javascript: window.open('viewprofile.php?id=<?=$theuser["id"];?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=$theuser["screenname"];?></a><br> <br> <b>Profile Town,Country:</b><br> <?=ucfirst($theuser["city"]);?>, <?=$country[$theuser["country"]];?> <br><br><b>Posted from:</b><br> <?=$theuser["lastip"];?>, <?=strtoupper(ip2country($theuser['lastip']));?></td>
							<td align="center">
							  <span id="text_introtitle[<?=$ai;?>]"><?=bannedwords($db,"E",$infos["introtitle"])?> &nbsp;&nbsp;&nbsp; (<img onclick="setdisplay('text_introtitle[<?=$ai;?>]', 'input_introtitle[<?=$ai;?>]');" style="cursor: hand;" src="images/button_edit.gif" border="0" align="absmiddle">)</span>
							  <span style="display: none;" id="input_introtitle[<?=$ai;?>]"><textarea rows="5" cols="29" name="introtitle[<?=$ai?>]"><?=$infos["introtitle"];?></textarea></span>
							</td>
							<td align="center">
							  <span id="text_introtext[<?=$ai;?>]"><?=bannedwords($db,"E",$infos["introtext"])?> &nbsp;&nbsp;&nbsp; (<img onclick="setdisplay('text_introtext[<?=$ai;?>]', 'input_introtext[<?=$ai;?>]');" style="cursor: hand;" src="images/button_edit.gif" border="0" align="absmiddle">)</span>
							  <span style="display: none;" id="input_introtext[<?=$ai;?>]"><textarea rows="5" cols="29" name="introtext[<?=$ai?>]"><?=$infos["introtext"];?></textarea></span>
							</td>
							<td align="center">
							  <span id="text_describe[<?=$ai;?>]"><?=bannedwords($db,"E",$infos["describe"])?> &nbsp;&nbsp;&nbsp; (<img onclick="setdisplay('text_describe[<?=$ai;?>]', 'input_describe[<?=$ai;?>]');" style="cursor: hand;" src="images/button_edit.gif" border="0" align="absmiddle">)</span>
							  <span style="display: none;" id="input_describe[<?=$ai;?>]"><textarea rows="5" cols="29" name="describe[<?=$ai?>]"><?=$infos["describe"];?></textarea></span>
							</td>
						</tr>
						<? $ai++;}?>
						<tr>
							<td colspan="5" style="text-align:center; padding: 40px 10px 10px 10px;">
							<input style="width: 200px; height: 40px;" type="button" name="approve" value="Approve" onclick="document.approveprofile.actiune.value='approve'; document.approveprofile.submit()" />&nbsp;&nbsp;
							<input style="width: 200px; height: 40px;" type="button" name="dissapprove" value="Dissapprove" onclick="document.approveprofile.actiune.value='dissapprove'; document.approveprofile.submit()" />&nbsp;&nbsp;
							<input style="width: 200px; height: 40px;" type="button" name="blockaccounts" value="Block Account" onclick="if(confirm('Are you sure you want to block selected accounts?')){document.approveprofile.actiune.value='blockaccounts'; document.approveprofile.submit();}" />
							</td>
						</tr>
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
</form>