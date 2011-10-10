<?
	if(!empty($_POST["block"])){
		$query="select `disabled` from `tblUsers` where `id`='".$_POST["block"]."'";
		$query=mysql_query($query);
		$query=mysql_fetch_array($query);
		mysql_free_result($query);
		if($query["disabled"]=='N'){$block='Y';}else{$block='N';}
		
		$qu=mysql_query("update `tblUsers` set `disabled`='".$block."' where `id`='".$_POST["block"]."'");
	}
	
	if(!empty($_POST["changefake"])){
		$qry=mysql_query("update `tblUsers` set `typeusr`='".$_POST["fake".$_POST["changefake"]]."' where `id`='".$_POST["changefake"]."'");
	}
	
	if(!empty($_POST["upgrade"])){
		$qry=mysql_query("update `tblUsers` set `accesslevel`='".$_POST["accesslevel".$_POST["upgrade"]]."',`upgraded`=now() where `id`='".$_POST["upgrade"]."'");
	}
?>
<form name="form2" action="index.php?content=mostemails" method="post">
	<input type="hidden" name="block" value="" />
	<input type="hidden" name="upgrade" value="" />
	<input type="hidden" name="changefake" value="" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Accounts with Most Emails</font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<? 
		$ago = date("Y-m-d H:i:s", mktime( 0,0,0,date("m"),date("d")-60,date("Y")) );
		
		$qry = "SELECT t2.*, COUNT( t1.user_id ) AS cc 
		        FROM `tblMails` AS t1, `tblUsers` AS t2
                WHERE t2.id = t1.user_id AND t1.type = 'E' AND t1.new = 'Y' AND t2.sex = '1' AND t2.lastlogin < '" . $ago . "' 
                GROUP BY t1.user_id
                ORDER BY `cc` DESC
                LIMIT 20";
		
		$qry = mysql_query($qry);
		$nr_found=mysql_num_rows($qry);
	?>
	<tr>
	<td>
	<table style="vertical-align:top; width:1020px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="8" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:120px"><img id="picScreenName" onclick="ordertabels('screenname')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:200px"><img id="picEmail" alt="arrows" onclick="ordertabels('email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Email</font></td>
					<td align="center" style="width:150px"><img id="picLastLogin" onclick="ordertabels('lastlogin')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Last login</font></td>


					<td align="center" style="width:50px"><img id="pictypeusr" onclick="ordertabels('typeusr')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Staff Acc</font></td>
					<td align="center" style="width:170px"><font class="tablecateg">Member type</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Transaction ID</font></td>
					<td align="center" style="width:100px"><font class="tablecateg"></font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Operations</font></td>
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=1; $i<=$nr_found; $i++){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				
				$theaccount=mysql_fetch_array($qry);
				
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;(<?=$theaccount['cc'];?>)&nbsp;<font class="tabletext"><?=$theaccount["screenname"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["email"] ?></font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["lastlogin"] ?></font></td>


					<td align="center">&nbsp;&nbsp;<font class="tabletext"><? if($theaccount["typeusr"]=='N'){ echo "no"; }else{ echo "yes"; } ?>&nbsp;&nbsp;<select name="fake<?=$theaccount["id"] ?>" onchange="document.form2.changefake.value='<?=$theaccount["id"] ?>'; document.form2.submit()">
					<option value="">- change -</option>
					<option value="N">No</option>
					<option value="Y">Yes</option>
					</select></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><? if($theaccount["accesslevel"]==2){ echo "Gold"; }elseif($theaccount["accesslevel"]==1){echo "Silver";}else{ echo "Free"; } ?>&nbsp;&nbsp;<select name="accesslevel<?=$theaccount["id"] ?>" onchange="document.form2.upgrade.value='<?=$theaccount["id"] ?>'; document.form2.submit()">
					<option value="">- change type -</option>
					<option value="0">Free</option>
					<option value="1">Silver</option>
					<option value="2">Gold</option>
					</select></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">Transaction ID</font></td>
					<td align="center"><? if($theaccount["disabled"]=='N'){?><a href="#" onclick="document.form2.block.value='<?=$theaccount["id"] ?>'; document.form2.submit()"><font class="tabletext"><img src="images/greensquare.gif" width="10" height="10" border="0" /> Block</font></a><? }else{ ?><a href="#" onclick="document.form2.block.value='<?=$theaccount["id"];?>'; document.form2.submit()"><font class="tabletext"><img src="images/redsquare.gif" width="10" height="10" border="0" /> Unblock</font></a><? } ?></td>
					<td align="center">
					  <a href="index.php?content=viewuser&id=<?=$theaccount["id"] ?>"><img border="0" title="View" alt="View" src="images/button_view.gif" width="16" height="16" /></a>
					  <a href="index.php?content=edituser&id=<?=$theaccount["id"] ?>"><img border="0" title="Edit" alt="Edit" src="images/button_edit.gif" width="16" height="16" /></a>
					  <a href="index.php?content=viewinbox&id=<?php echo $theaccount["id"];?>"><img src="images/inbox.jpg" width="16" alt="Inbox" title="Inbox" height="16" align="Inbox" border="0" style="border:0" /></a>
					  <a href="index.php?content=viewoutbox&id=<?php echo $theaccount["id"] ?>"><img src="images/outbox.jpg" width="16" alt="Outbox" title="Outbox" align="Outbox" height="16" border="0" style="border:0" /></a>
					</td>
			</tr>
			<?
				}
			?>
			<tr>
				<td colspan="8" height="3" bgcolor="#990000" width="100%"></td>
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