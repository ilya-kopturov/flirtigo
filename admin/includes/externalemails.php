<?php
	$query="select * from `tblMailerMachine` where `type`='external'";
	$query=mysql_query($query);
	$nrmails=mysql_num_rows($query);
	if($_POST["action"]=="add"){
		$query="insert into `tblMailerMachine` (`for`,`type`,`subject`,`message`) values ('".$_POST["usefor"]."','external','".addslashes($_POST["subject"])."','".addslashes($_POST["message"])."')";
		echo "insert into `tblMailerMachine` (`for`,`type`,`subject`,`message`) values ('".$_POST["usefor"]."','external','".addslashes($_POST["subject"])."','".addslashes($_POST["message"])."')";
		$query=mysql_query($query);
		$msg="External mail saved";
		echo "<script>document.location.href='index.php?content=externalemails&msg=".$msg."'</script>";
	}
	if($_POST["action"]=="del"){
		$qry="delete from `tblMailerMachine` where `id`='".$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="External mail deleted";
		echo "<script>document.location.href='index.php?content=externalemails&msg=".$msg."'</script>";
	}
	if($_POST["action"]=="update"){
		$qry="update `tblMailerMachine` set `for`='".$_POST["usefor_".$_POST["id"]]."', `subject`='".addslashes($_POST["subject_".$_POST["id"]])."', `message`='".addslashes($_POST["message_".$_POST["id"]])."' where `id`='".$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="External mail updated";
		echo "<script>document.location.href='index.php?content=externalemails&msg=".$msg."'</script>";
	}
?>
<form name="addform" method="post" action="index.php?content=externalemails">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="id" value="" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">External Emails </font></td>
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
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename"><? if($nrmails>0){ echo $nrmails;}else{ echo "0";} ?> external emails found</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:1050px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:160px"><font class="tablecateg">Sent mail when</font></td>
					<td align="center" style="width:230px"><font class="tablecateg">Subject</font></td>
					<td align="center" style="width:510px"><font class="tablecateg">Message</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Action</font></td>
					
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=1; $i<=$nrmails; $i++){
				$theaccount=mysql_fetch_array($query);
					if($tdcolor=="#f2f2f2"){
						$tdcolor="#FFFFFF";
					} else {
						$tdcolor="#f2f2f2";
					}
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="center"><font class="tabletext">
					<select class="tabletext" name="usefor_<?=$theaccount["id"] ?>" id="usefor">
					<option value="" <?=($theaccount["for"]=="")?("selected='selected'"):("") ?>>none</option>
					<option value="approved" <?=($theaccount["for"]=="approved")?("selected='selected'"):("") ?>>profile approved</option>
					<option value="disapproved" <?=($theaccount["for"]=="disapproved")?("selected='selected'"):("") ?>>profile disapproved</option>
					<option value="emailprofile" <?=($theaccount["for"]=="emailprofile")?("selected='selected'"):("") ?>>email profile to a friend</option>
					<option value="inviteprofile" <?=($theaccount["for"]=="inviteprofile")?("selected='selected'"):("") ?>>invite to view your profile</option>
					<option value="join" <?=($theaccount["for"]=="join")?("selected='selected'"):("") ?>>join notification</option>
					<option value="forgot" <?=($theaccount["for"]=="forgot")?("selected='selected'"):("") ?>>forgot password</option>
					<option value="new_message" <?=($theaccount["for"]=="new_message")?("selected='selected'"):("") ?>>receive new message</option>
					<option value="new_pic_message" <?=($theaccount["for"]=="new_pic_message")?("selected='selected'"):("") ?>>receive new picture message</option>
					<option value="new_video_message" <?=($theaccount["for"]=="new_video_message")?("selected='selected'"):("") ?>>receive new video message</option>
					<option value="new_multimedia_message" <?=($theaccount["for"]=="new_multimedia_message")?("selected='selected'"):("") ?>>receive new picture&video message</option>
					<option value="new_whisper" <?=($theaccount["for"]=="new_whisper")?("selected='selected'"):("") ?>>receive new whisper</option>
			    <!--<option value="email_notification" <?=($theaccount["for"]=="email_notification")?("selected='selected'"):("") ?>>e-mail notification</option>-->
					<option value="blocked" <?=($theaccount["for"]=="blocked")?("selected='selected'"):("") ?>>user blocked</option>
					<option value="unblocked" <?=($theaccount["for"]=="unblocked")?("selected='selected'"):("") ?>>user unblocked</option>
					<option value="disabled" <?=($theaccount["for"]=="disabled")?("selected='selected'"):("") ?>>user disabled</option>
					<option value="enabled" <?=($theaccount["for"]=="enabled")?("selected='selected'"):("") ?>>user enabled</option>
					<option value="payed" <?=($theaccount["for"]=="payed")?("selected='selected'"):("") ?>>payment confirmation</option>
					<option value="needtopay" <?=($theaccount["for"]=="needtopay")?("selected='selected'"):("") ?>>user needs to pay</option>
					<option value="upgraded" <?=($theaccount["for"]=="upgraded")?("selected='selected'"):("") ?>>account upgraded</option>
					<option value="downgraded" <?=($theaccount["for"]=="downgraded")?("selected='selected'"):("") ?>>account downgraded</option>
					<option value="pic_approved" <?=($theaccount["for"]=="pic_approved")?("selected='selected'"):("") ?>>picture approved</option>
					<option value="pic_disapproved" <?=($theaccount["for"]=="pic_disapproved")?("selected='selected'"):("") ?>>picture disapproved</option>
					<option value="video_approved" <?=($theaccount["for"]=="video_approved")?("selected='selected'"):("") ?>>video approved</option>
					<option value="video_disapproved" <?=($theaccount["for"]=="video_disapproved")?("selected='selected'"):("") ?>>video disapproved</option>
					<option value="request_password" <?=($theaccount["for"]=="request_password")?("selected='selected'"):("") ?>>request password</option>
					<option value="accept_request" <?=($theaccount["for"]=="accept_request")?("selected='selected'"):("") ?>>accept pass request</option>
					<option value="deny_request" <?=($theaccount["for"]=="deny_request")?("selected='selected'"):("") ?>>deny pass request</option>
					<option value="confirm_mail" <?=($theaccount["for"]=="confirm_mail")?("selected='selected'"):("") ?>>confirm email</option>
					</select>
					</font></td>
					<td align="center"><font class="tabletext"><textarea class="tabletext" name="subject_<?=$theaccount["id"] ?>" cols="35" rows="4" ><?=$theaccount["subject"] ?></textarea></font></td>
					<td align="center"><font class="tabletext"><textarea class="tabletext" name="message_<?=$theaccount["id"] ?>" cols="100" rows="10" ><?=$theaccount["message"] ?></textarea></font></td>
					<td align="center"><font class="tabletext"><input type="button" name="Delete" value="Delete" onclick="document.addform.action.value='del'; document.addform.id.value='<?=$theaccount["id"] ?>';document.addform.submit()" />&nbsp;<input type="button" name="Update" value="Update" onclick="document.addform.action.value='update'; document.addform.id.value='<?=$theaccount["id"] ?>';document.addform.submit()" /></font></td>
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
	<tr>
		<td><font class="tablename">Add external email</font></td>
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
				<td bgcolor="#FFFFE6" width="100%" style="padding:10px"><font class="tabletext" style="font-weight:bold"><font color="#990000">Note!</font> You can use: [%to_name%], [%from_name%], [%to_location%], [%from_location%], [%to_imagelink%], [%from_imagelink%], [%to_videolink%], [%from_videolink%],<br/> [%hidden_image%], [%login_link%], [%to_password%], [%confirm_link%] and [%gallery_password%].</font></td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%" align="right">&nbsp;&nbsp;<font class="tabletext">Sent email when:</font></td>
					<td width="90%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="usefor" id="usefor">
					<option value="">none</option>
					<option value="approved">profile approved</option>
					<option value="disapproved">profile disapproved</option>
					<option value="emailprofile">email profile to a friend</option>
					<option value="inviteprofile">invite to view your profile</option>
					<option value="join">join notification</option>
					<option value="forgot">forgot password</option>
					<option value="new_message">receive new message</option>
					<option value="new_pic_message">receive new picture message</option>
					<option value="new_video_message">receive new video message</option>
					<option value="new_multimedia_message">receive new picture&video message</option>
					<option value="new_whisper">receive new whisper</option>
			    <!--<option value="email_notification" <?=($theaccount["for"]=="email_notification")?("selected='selected'"):("") ?>>e-mail notification</option>-->
					<option value="blocked">user blocked</option>
					<option value="unblocked">user unblocked</option>
					<option value="disabled">user disabled</option>
					<option value="enabled">user enabled</option>
					<option value="payed">payment confirmation</option>
					<option value="needtopay">user needs to pay</option>
					<option value="upgraded">account upgraded</option>
					<option value="downgraded">account downgraded</option>
					<option value="pic_approved">picture approved</option>
					<option value="pic_disapproved">picture disapproved</option>
					<option value="video_approved">video approved</option>
					<option value="video_disapproved">video disapproved</option>
					<option value="request_password">request password</option>
					<option value="accept_request">accept pass request</option>
					<option value="deny_request">deny pass request</option>
					<option value="confirm_mail">confirm email</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%" align="right">&nbsp;&nbsp;<font class="tabletext">Subject:</font></td>
					<td width="90%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="subject" id="subject" size="172" value="" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%" align="right">&nbsp;&nbsp;<font class="tabletext">Message:</font></td>
					<td width="90%" align="left">&nbsp;<font class="tabletext"><textarea class="tabletext" name="message" id="message" cols="175" rows="20"></textarea></font></td>
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
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<?
					//create the list of fields that have to ve verified
					$verif="action";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="color:#333333" name="insert" value="Set">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333" name="reset" value="Reset"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('mailermachine1').style.display == 'none'){
		document.getElementById('mailermachine1').style.display = '';
	}
	if(document.getElementById('mailermachine2').style.display == 'none'){
		document.getElementById('mailermachine2').style.display = '';
	}
	if(document.getElementById('mailermachine3').style.display == 'none'){
		document.getElementById('mailermachine3').style.display = '';
	}
	if(document.getElementById('mailermachine4').style.display == 'none'){
		document.getElementById('mailermachine4').style.display = '';
	}
	if(document.getElementById('mailermachine5').style.display == 'none'){
		document.getElementById('mailermachine5').style.display = '';
	}
	if(document.getElementById('mailermachine6').style.display == 'none'){
		document.getElementById('mailermachine6').style.display = '';
	}
	if(document.getElementById('mailermachine7').style.display == 'none'){
		document.getElementById('mailermachine7').style.display = '';
	}
	if(document.getElementById('mailermachine8').style.display == 'none'){
		document.getElementById('mailermachine8').style.display = '';
	}
	if(document.getElementById('mailermachine9').style.display == 'none'){
		document.getElementById('mailermachine9').style.display = '';
	}
</script>