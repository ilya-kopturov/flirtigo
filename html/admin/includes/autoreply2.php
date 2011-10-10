<?php
	$query="select * from `tblWhispers`";
	$query=mysql_query($query);
	$nrmails=mysql_num_rows($query);
	if($_POST["action"]=="add" && (int)$_GET["id"] >= 0){
		$qry="insert into `tblAutoWhisper` (`user_id`,`whisper_id`,`subject`,`message`,`hour`) values('".(int)$_GET["id"]."','".(int)$_POST["whisper_new"]."','".addslashes($_POST["subject"])."','".addslashes($_POST["message"])."','".(int)$_POST["hour"]."')";
		$qry=mysql_query($qry);
		$msg="Auto-reply was inserted into the database";
	}
	if($_POST["action"]=="del" && (int)$_GET["id"] >= 0){
		$qry="delete from `tblAutoWhisper` where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="Auto-reply was deleted from the database";
	}
	if($_POST["action"]=="update" && (int)$_GET["id"] >= 0){
		echo $qry="update `tblAutoWhisper` set `whisper_id` = '".(int)$_POST["whisper".$_POST["id"]]."', `subject` = '".addslashes($_POST["subject".$_POST["id"]])."', `message` = '".addslashes($_POST["message".$_POST["id"]])."', `hour` = '".(int)$_POST["hour".$_POST["id"]]."' where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="Auto-reply updated";
	}
?> 
<form name="addform" method="post" action="addflirtreply.php?id=<?=($_GET["id"]!="")?("&id=".$_GET["id"]):("") ?>">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="id" value="" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Manage Whispers </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$msg ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">Select Staff Accountusers</font></td>
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
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="center">&nbsp;<font class="tabletext">Select Staff Accountuser: <select name="typeusr" onchange="document.location.href='addflirtreply.php?id='+document.addform.typeusr.value">
					<option value="">--Select Staff Accountuser--</option>
					<?
					$qry="select * from `tblUsers` where `typeusr` = 'Y' order by `screenname` ASC";
					$qry=mysql_query($qry);
					$nrusers=mysql_num_rows($qry);
					for($i=0;$i<$nrusers;$i++){
						$user=mysql_fetch_array($qry);
						list($new_w) = @mysql_fetch_array(mysql_query("SELECT COUNT( DISTINCT `user_from` ) as new FROM `tblTypeWhispers` WHERE `user_id` = '" . $user['id'] . "' AND `new` = 'Y'"));
						$selected=($_GET["id"]==$user["id"])?("selected='selected'"):("");
						echo "<option value='".$user["id"]."' ".$selected.">".$user["screenname"]." (". $new_w .")</option>";
					}
					 ?></select></font></td>
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
	<tr>
		<td><font class="tablename">Auto-replyes for whispers</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:800px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:600px"><font class="tablecateg">Auto-reply </font></td>
					<td align="center" style="width:200px"><font class="tablecateg">Action</font></td>
					
			</tr>
			<?
				$tdcolor="#f2f2f2";
				$qry="select * from `tblAutoWhisper` where `user_id` = '". (int) $_GET["id"]."' order by `whisper_id`";
				$qry=mysql_query($qry);
				$nrreply=mysql_num_rows($qry);
				for($i=0; $i<$nrreply; $i++){
					$reply=mysql_fetch_array($qry);
					if($tdcolor=="#f2f2f2"){
						$tdcolor="#FFFFFF";
					} else {
						$tdcolor="#f2f2f2";
					}
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left" valign="top" style="padding-left: 10px;"><font class="tabletext">
					<b>Subject:</b> <br /><input type="text" maxlength="35" name="subject<?=$reply["id"] ?>" value="<?=$reply["subject"] ?>" style="width: 350px;" /><br />
					<b>Message:</b><br /><textarea name="message<?=$reply["id"] ?>" style="height: 100px; width: 350px;" ><?=$reply["message"] ?></textarea><br />
					<b>Reply after:</b> <br /><input type="text" name="hour<?=$reply["id"] ?>" value="<?=$reply['hour']?>" /> hour(s)
					</font></td>
					<td align="center"><font class="tabletext"><input type="button" name="Delete" value="Delete" onclick="document.addform.action.value='del'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.submit()" /><input type="button" name="Update" value="Update" onclick="document.addform.action.value='update'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.submit()" /></font></td>
			</tr>
			
			<?
				}
			?>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="right"></td>
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
		<td height="10"></td>
	</tr>
	<? if($i == 0){?>
	<tr>
		<td><font class="tablename">Add auto-reply</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:800px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td colspan="2" align="center" style="width:800px"><font class="tablecateg"> </font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='#cccccc'" style="background-color:#cccccc">
					<td align="right" valign="top"><font class="tabletext">
					<b>Subject:</b> &nbsp;&nbsp;</font></td>
					<td align="left" valign="top" width="65%"><input type="text" maxlength="35" name="subject" value="" style="width: 350px;" />
					</font></td>
					
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
					<td align="right" valign="top"><font class="tabletext">
					<b>Message:</b> &nbsp;&nbsp;</font></td>
					<td align="left" valign="top" width="65%"><textarea name="message" style="width: 350px; height: 200px;"></textarea></font></td>
					
			</tr>
			<tr onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='#cccccc'" style="background-color:#cccccc">
					<td align="right" valign="top"><font class="tabletext">
					<b>Reply after:</b> &nbsp;&nbsp;</font></td>
					<td align="left" valign="top" width="65%"><input type="text" maxlength="35" name="hour" value="" style="width: 350px;" /> <font class="tabletext">hour(s)</font></td>
					
			</tr>
			<!--<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td colspan="2" align="left" valign="top"><font class="tabletext">
					<input type="checkbox" name="ultimate_new" value="1" />Ultimate message*
					</font></td>
					
			</tr> -->
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<?
					//create the list of fields that have to ve verified
					$verif="subject,message";
					
				?>
				<tr style="padding: 5px 5px 5px 5px;">
					<td width="100%" align="center"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="width: 150px; height: 30px; color:#333333" name="insert" value="Set">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="width: 150px; height: 30px; color:#333333" name="reset" value="Reset"></td>
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
		<td height="10"></td>
	</tr>
	<?}?>
	<!-- <tr>
		<td height="100%"><font class="tabletext" style="color:#990000">* If an user sends the same whisper to this Staff Accountuser more than the number of different auto-replyes that exists than he will receive this message.</font></td>
	</tr> -->
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('whispers1').style.display == 'none'){
		document.getElementById('whispers1').style.display = '';
	}
	if(document.getElementById('whispers2').style.display == 'none'){
		document.getElementById('whispers2').style.display = '';
	}
	if(document.getElementById('whispers3').style.display == 'none'){
		document.getElementById('whispers3').style.display = '';
	}
	if(document.getElementById('whispers4').style.display == 'none'){
		document.getElementById('whispers4').style.display = '';
	}
	if(document.getElementById('whispers5').style.display == 'none'){
		document.getElementById('whispers5').style.display = '';
	}
	if(document.getElementById('whispers6').style.display == 'none'){
		document.getElementById('whispers6').style.display = '';
	}
</script>