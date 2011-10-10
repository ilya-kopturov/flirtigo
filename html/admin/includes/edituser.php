<?php

if(isset($_POST['action']) and $_POST['action'] == "edit")
{
	if(isset($_POST['looking']))
	{
		$looking_arr = array();
		$looking_arr = $_POST['looking'];
		
		$looking = 0;
		foreach ($looking_arr as $param)
		{
			$looking |= (1 << $param);
		}
		
		$insert_looking = "`looking` = '" . $looking . "', ";
	}
	else
	{
		$msg .= "LOOKING fields are all empty. <br/>";
	}
	
	if(isset($_POST['for']))
	{
		$for_arr = array();
		$for_arr = $_POST['for'];
		
		$for = 0;
		foreach ($for_arr as $param)
		{
			$for |= (1 << $param);
		}
		
		$insert_for = "`for` = '" . $for . "', ";
	}
	else
	{
		$msg .= "FOR fields are all empty. <br/>";
	}
	
	if(isset($_POST['fetishes']))
	{
		$fetishes_arr = array();
		$fetishes_arr = $_POST['fetishes'];
		
		$fetishes = 0;
		foreach ($fetishes_arr as $param)
		{
			$fetishes |= (1 << $param);
		}
		
		$insert_fetishes = "`sexualactivities` = '" . $fetishes . "', ";
	}
	
    if(!checkdate($_POST['month'],$_POST['day'],$_POST['year'])){
		$msg .= "Invalid Birth Date. <br/>";
	}
	else
	{
		$_POST['birthdate'] = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
		
		$insert_birthdate = "`birthdate` = '" . $_POST['birthdate'] . "', ";
	}
	
		$_POST['redirect'] = $_POST['typeusr']=="N"?"N":$_POST['redirect'];
		$_POST['redirect'] = isset($_POST['redirect'])?($_POST['redirect']=="Y"?"Y":"N"):"N";
		
		$sql = "UPDATE `tblUsers` SET `pass` = '" . $_POST['pass'] . "', 
									  `email` = '" . $_POST['email'] . "', 
									  `sex` = '" . $_POST['sex'] . "', 
									  " . $insert_looking . " 
									  " . $insert_for . "
									  " . $insert_fetishes . " 
									  `introtitle` = '" . addslashes($_POST['introtitle']) . "', 
									  `introtext` = '" . addslashes($_POST['introtext']) . "', 
									  `describe` = '" . addslashes($_POST['describe']) . "', 
									  " . $insert_birthdate . " 
									  `country` = '" . $_POST['country'] . "', 
									  `state` = '" . $_POST['state'] . "', 
									  `city` = '" . $_POST['city'] . "', 
									  `zip` = '" . $_POST['zip'] . "', 
									  `hide` = '" . $_POST['hide'] . "', 
									  `emailstatus` = '" . $_POST['emailstatus'] . "', 
									  `emailnotif` = '" . $_POST['emailnotif'] . "', 
									  `whispernotif` = '" . $_POST['whispernotif'] . "', 
									  `newsletternotif` = '" . $_POST['newsletternotif'] . "', 
									  `typeusr` = '" . $_POST['typeusr'] . "', 
									  `typeloc` = '" . $_POST['typeloc'] . "', 
									  `redirect` = '" . $_POST['redirect'] . "', 
									  `approved` = '" . $_POST['approved'] . "', 
									  `firsttime` = '" . $_POST['firsttime'] . "', 
									  `disabled` = '" . $_POST['disabled'] . "', 
									  `lastlogin` = '" . $_POST['lastlogin'] . "',
									  `accesslevel` = '" . $_POST['accesslevel'] . "', 
									  `height` = '" . $_POST['height'] . "',
									  `weight` = '" . $_POST['weight'] . "',
									  `bodytype` = '" . $_POST['bodytype'] . "',
									  `smoking` = '" . $_POST['smoking'] . "',
									  `drinking` = '" . $_POST['drinking'] . "',
									  `eyecolor` = '" . $_POST['eyecolor'] . "',
									  `haircolor` = '" . $_POST['haircolor'] . "',
									  `ethnicity` = '" . $_POST['ethnicity'] . "',
									  `p_height` = '" . $_POST['p_height'] . "',
									  `p_weight` = '" . $_POST['p_weight'] . "',
									  `p_bodytype` = '" . $_POST['p_bodytype'] . "',
									  `p_smoking` = '" . $_POST['p_smoking'] . "',
									  `p_drinking` = '" . $_POST['p_drinking'] . "',
									  `p_eyecolor` = '" . $_POST['p_eyecolor'] . "',
									  `p_haircolor` = '" . $_POST['p_haircolor'] . "',
									  `p_ethnicity` = '" . $_POST['p_ethnicity'] . "'
								  WHERE `id` = '" . $_POST['id'] . "' LIMIT 1";
		
		$query = mysql_query($sql);
		if(mysql_affected_rows() > 0 and !isset($msg))
		{
			$new = "<font color='green'>USER succesfully updated.</font><Br>";
		}
		elseif(!isset($msg) && mysql_error())
		{
			$new = "<font color='red'>ERROR: " . mysql_error() . "</font><Br>";
		}
}

/**
 * Pictures SQL
 */
$pictures_sql = "SELECT   `id`, `photo_name`, `photo_description`, `gallery` 
                 FROM     `tblPhotos` 
                 WHERE    `user_id` = '" . $_GET['id'] . "' 
                 ORDER BY `id` ASC";
$pics_sql     = mysql_query($pictures_sql);

/**
 * Videos SQL
 */
$videos_sql   = "SELECT   `id`, `video_name`, `video_description`, `gallery` 
                 FROM     `tblVideos` 
                 WHERE    `user_id` = '" . $_GET['id'] . "' 
                 ORDER BY `id` ASC";
$videos_sql    = mysql_query($videos_sql);
?>
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Edit User </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<?php if($msg || $new){ ?>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?if($msg){?><font color="red" size="2" face="Verdana"><?=$msg;?></font><?}elseif($new) echo $new;?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<?php } ?>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0" width="100%">
					<tr valign="middle">
						<td valign="middle" height="22" align="left" style="font: bold 12px verdana;">
						<a href="#Pictures">View Pictures</a> | <a href="#Videos">View Videos</a>
						</td>
						<td valign="middle" height="22" align="right" style="font: bold 12px verdana;">
						<a href="javascript: void(0);" onclick="javascript: window.open('addphoto.php?t=image&e=<?php echo $_GET['id'];?>','addpicture','resizable=yes,scrollbars=yes,width=700,height=400');" target="_blank">Add Picture</a> | 
						<a href="javascript: void(0);" onclick="javascript: window.open('addvideo.php?t=video&e=<?php echo $_GET['id'];?>','addvideo','resizable=yes,scrollbars=yes,width=700,height=400');" target="_blank">Add Video</a>
						</td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">Main details (* - required fields)</font></td>
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
<?php
	$theuser = mysql_fetch_array(mysql_query("SELECT * FROM `tblUsers` WHERE `id` = '".$_GET["id"]."' LIMIT 1"));
	list($theuser["year"], $theuser["month"], $theuser["day"])     = split("-", $theuser["birthdate"]);
	list($theuser["p_year"],$theuser["p_month"],$theuser["p_day"]) = split("-", $theuser["p_birthdate"]);
	
	$forr     = forr_array($theuser['for']); 
	$looking  = looking_array($theuser['looking']);
	$fetishes = fetishes_array($theuser['sexualactivities']);
?>
		<form name="editform" method="post" action="index.php?content=edituser&id=<?=$_GET['id']?>">
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="id" value="<?=$_GET['id'];?>" />
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Screen name<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" maxlength="12" name="screenname" id="screenname" size="35" value="<?=$theuser["screenname"]?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Password<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" maxlength="12" name="pass" id="pass" size="35" value="<?=$theuser["pass"]?>" />
					</font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="email" id="email" size="35" value="<?=$theuser["email"]?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Acc:</font></td>
					<td width="70%" align="left">&nbsp;
					  <font class="tabletext">
					    <select class="tabletext" name="typeusr">
					      <option value="N" <? if($theuser['typeusr'] == "N"){ echo "selected"; }?>>No</option>
					      <option value="Y"<? if($theuser['typeusr'] == "Y"){ echo "selected"; }?>>Yes</option>
					    </select>
					    <? if($theuser['typeusr'] == "Y"){ ?> &nbsp; <input type="checkbox" name="redirect" value="Y" <? if($theuser['redirect'] == "Y") {?> checked <? } ?> > - redirect mails to chatinterface <? } ?>
		              </font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Account Location:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="typeloc" id="typeloc">
					  <option value="N" <? if($theuser["typeloc"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($theuser["typeloc"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
		      <td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Last Login:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="lastlogin" id="lastlogin" size="35" value="<?=$theuser["lastlogin"]?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailnotif">
					<option value="N" <? if($theuser["emailnotif"] == "N"){ echo "selected"; }?>>No</option>
					<option value="Y" <? if($theuser["emailnotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Whisper Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="whispernotif" id="whispernotif">
					  <option value="N" <? if($theuser["whispernotif"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($theuser["whispernotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Newsletter Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="newsletternotif">
					<option value="N" <? if($theuser["newsletternotif"] == "N"){ echo "selected"; }?>>No</option>
					<option value="Y" <? if($theuser["newsletternotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Hide:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="hide">
					  <option value="N" <? if($theuser["hide"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($theuser["hide"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">First Time:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="firsttime">
					  <option value="N" <? if($theuser["firsttime"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($theuser["firsttime"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Disabled:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="disabled" id="disabled">
					  <option value="N" <? if($theuser["disabled"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($theuser["disabled"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Access Level:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="accesslevel">
					  <option value="0" <? if($theuser["accesslevel"] == 0){ echo "selected"; }?>>Free</option>
					  <option value="1" <? if($theuser["accesslevel"] == 1){ echo "selected"; }?>>Silver</option>
					  <option value="2" <? if($theuser["accesslevel"] == 2){ echo "selected"; }?>>Gold</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email status:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailstatus">
					  <option value="G" <? if($theuser["emailstatus"] == "G"){ echo "selected"; }?>>Good</option>
					  <option value="I" <? if($theuser["emailstatus"] == "I"){ echo "selected"; }?>>Invalid</option>
					  <option value="B" <? if($theuser["emailstatus"] == "B"){ echo "selected"; }?>>Bounced</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="sex" onchange="javascript: if(this.value == 2) document.getElementById('partener_profile').style.display = ''; else document.getElementById('partener_profile').style.display = 'none';">
					  <option value="0" <? if($theuser['sex'] == 0) echo "selected";?> >Man</option>
					  <option value="1" <? if($theuser['sex'] == 1) echo "selected";?> >Woman</option>
					  <option value="2" <? if($theuser['sex'] == 2) echo "selected";?> >Couple</option>
					  <option value="3" <? if($theuser['sex'] == 3) echo "selected";?> >Group</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking<font color="red">*</font>:</font></td>
					<td width="70%" align="left" style="padding-left: 10px;">
					<font class="tabletext">
					  <input class="tabletext" name="looking[0]" value="0" type="checkbox" <? if($looking[0]){ echo "checked";} ?> > Man 
					  <input class="tabletext" name="looking[1]" value="1" type="checkbox" <? if($looking[1]){ echo "checked";} ?> > Woman 
					  <input class="tabletext" name="looking[2]" value="2" type="checkbox" <? if($looking[2]){ echo "checked";} ?> > Couple 
					  <input class="tabletext" name="looking[3]" value="3" type="checkbox" <? if($looking[3]){ echo "checked";} ?> > Group 
					</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">For<font color="red">*</font>:</font></td>
					<td width="35%" valign="top" align="left" style="padding-left: 10px;">
					<font class="tabletext">
					  <input class="tabletext" name="for[0]" value="0" type="checkbox" <? if($forr[0]){ echo "checked";} ?> > <?=$cfg['profile']['for'][0];?> <br>
					  <input class="tabletext" name="for[1]" value="1" type="checkbox" <? if($forr[1]){ echo "checked";} ?> > <?=$cfg['profile']['for'][1];?> <br>
					  <input class="tabletext" name="for[2]" value="2" type="checkbox" <? if($forr[2]){ echo "checked";} ?> > <?=$cfg['profile']['for'][2];?> <br>
					</font>
					<td width="35%" align="left">
					<font class="tabletext">
					  <input class="tabletext" name="for[3]" value="3" type="checkbox" <? if($forr[3]){ echo "checked";} ?> > <?=$cfg['profile']['for'][3];?> <br> 
					  <input class="tabletext" name="for[4]" value="4" type="checkbox" <? if($forr[4]){ echo "checked";} ?> > <?=$cfg['profile']['for'][4];?> <br> 
					  <input class="tabletext" name="for[5]" value="5" type="checkbox" <? if($forr[5]){ echo "checked";} ?> > <?=$cfg['profile']['for'][5];?> <br> 
					  <input class="tabletext" name="for[6]" value="6" type="checkbox" <? if($forr[6]){ echo "checked";} ?> > <?=$cfg['profile']['for'][6];?> <br> 
					</font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Fetishes<font color="red">*</font>:</font></td>
					<td width="70%" valign="top" align="left" style="padding-left: 10px;">
					  <table width="100%">
					    <tr>
						<?php for($i=1; $i<=count($cfg['profile']['sexualactivities']); $i++){?>
							<td width="20%"><input type="checkbox" name="fetishes[<?=$i-1;?>]" value="<?=$i-1;?>" <? if(isset($fetishes[$i-1])) echo "checked";?> /> <font class="tabletext"><?=$cfg['profile']['sexualactivities'][$i-1]?></font></td>
						<? if($i%5 == 0) echo "</tr><tr>";?>	
						<?}?>
						</tr>
					  </table>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Intro title:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="introtitle" id="introtitle" size="65" value="<?=$theuser["introtitle"];?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Intro text:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><textarea class="tabletext" name="introtext" id="introtext" cols="62" rows="5"><?=$theuser["introtext"];?></textarea></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Describe looking:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><textarea class="tabletext" name="describe" cols="62" rows="5"><?=$theuser["describe"];?></textarea></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date<font color="red">*</font>:</font></td>
					<td width="20%" align="left">&nbsp;<font class="tabletext"> <select class="tabletext" name="month">
					<option value="">Month</option>
					<?
						for($i=1;$i<=12; $i++){
							if($theuser["month"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="day">
					<option value="">Day</option>
					<?
						for($i=1;$i<=31; $i++){
							if($theuser["day"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="year">
					<option value="">Year</option>
					<?
						for($i=1989;$i>=1920; $i--){
							if($theuser["year"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select></font></td>
					<td width="10%" align="right"><font class="tabletext">Height:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="height">
							<?php for($i=0; $i<count($cfg['profile']['height']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['height'] == $i) echo "selected";?> ><?=$cfg['profile']['height'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Weight:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="weight">
							<?php for($i=0; $i<count($cfg['profile']['weight']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['weight'] == $i) echo "selected";?> ><?=$cfg['profile']['weight'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Body shape:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="bodytype">
							<?php for($i=0; $i<count($cfg['profile']['bodytype']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['bodytype'] == $i) echo "selected";?> ><?=$cfg['profile']['bodytype'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Hair Color:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="haircolor">
							<?php for($i=0; $i<count($cfg['profile']['haircolor']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['haircolor'] == $i) echo "selected";?> ><?=$cfg['profile']['haircolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Eye color:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="eyecolor">
							<?php for($i=0; $i<count($cfg['profile']['eyecolor']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['eyecolor'] == $i) echo "selected";?> ><?=$cfg['profile']['eyecolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Smoker:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="smoking">
							<?php for($i=0; $i<count($cfg['profile']['smoking']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['smoking'] == $i) echo "selected";?> ><?=$cfg['profile']['smoking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Drinker:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="drinking">
							<?php for($i=0; $i<count($cfg['profile']['drinking']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['drinking'] == $i) echo "selected";?> ><?=$cfg['profile']['drinking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Ethnicity:</font></td>
					<td width="70%" align="left" colspan="3">
						&nbsp;<font class="tabletext">
							<select name="ethnicity">
							<?php for($i=0; $i<count($cfg['profile']['ethnicity']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['ethnicity'] == $i) echo "selected";?> ><?=$cfg['profile']['ethnicity'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>
			
			
<!-- partener -->

			<tr id="partener_profile" <?if($theuser['sex'] == 2){?> style="display: block;" <?}else{?> style="display: none;" <?}?> >
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date<font color="red">*</font>:</font></td>
					<td width="20%" align="left">&nbsp;<font class="tabletext"> <select class="tabletext" name="p_month">
					<option value="">Month</option>
					<?
						for($i=1;$i<=12; $i++){
							if($theuser["p_month"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="p_day">
					<option value="">Day</option>
					<?
						for($i=1;$i<=31; $i++){
							if($theuser["p_day"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="p_year">
					<option value="">Year</option>
					<?
						for($i=1989;$i>=1920; $i--){
							if($theuser["p_year"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select></font></td>
					<td width="10%" align="right"><font class="tabletext">Height:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_height">
							<?php for($i=0; $i<count($cfg['profile']['height']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_height'] == $i) echo "selected";?> ><?=$cfg['profile']['height'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Weight:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_weight">
							<?php for($i=0; $i<count($cfg['profile']['weight']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_weight'] == $i) echo "selected";?> ><?=$cfg['profile']['weight'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Body shape:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_bodytype">
							<?php for($i=0; $i<count($cfg['profile']['bodytype']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_bodytype'] == $i) echo "selected";?> ><?=$cfg['profile']['bodytype'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Hair Color:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_haircolor">
							<?php for($i=0; $i<count($cfg['profile']['haircolor']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_haircolor'] == $i) echo "selected";?> ><?=$cfg['profile']['haircolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Eye color:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_eyecolor">
							<?php for($i=0; $i<count($cfg['profile']['eyecolor']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_eyecolor'] == $i) echo "selected";?> ><?=$cfg['profile']['eyecolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Smoker:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_smoking">
							<?php for($i=0; $i<count($cfg['profile']['smoking']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_smoking'] == $i) echo "selected";?> ><?=$cfg['profile']['smoking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Drinker:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_drinking">
							<?php for($i=0; $i<count($cfg['profile']['drinking']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_drinking'] == $i) echo "selected";?> ><?=$cfg['profile']['drinking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Ethnicity:</font></td>
					<td width="70%" align="left" colspan="3">
						&nbsp;<font class="tabletext">
							<select name="p_ethnicity">
							<?php for($i=0; $i<count($cfg['profile']['ethnicity']); $i++){?>
								<option value="<?=$i;?>" <?if($theuser['p_ethnicity'] == $i) echo "selected";?> ><?=$cfg['profile']['ethnicity'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>

<!-- end partener -->
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Country<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="country">
					<?
						$cqry="select * from `tblCountries` order by `id` ASC";
						$cqry=mysql_query($cqry);
						$nrc=mysql_num_rows($cqry);
						$sel="";
						for($i=0;$i<$nrc;$i++){
							$country=mysql_fetch_array($cqry);
							if($theuser["country"]==$country["id"]){
								$sel=" selected='selected'";
							} else {
								$sel="";
							}
							echo "<option".$sel." value='".$country["id"]."' class='forms'>".$country["name"]."</option>";
						}
					?>
					</select> (<?=$theuser["lastip"];?>, <?=strtoupper(ip2country($theuser["lastip"]));?>)
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
				
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">State:</font></td>
					<td width="70%" align="left"><font class="tabletext">
					<div id="country1" style="padding-left:5px">
					<select class="tabletext" name="state" id="state1" style="width:170px">
					<option value="" class="forms">--Select--</option>
					<?
						$cqry="SELECT * FROM `tblStates` ORDER BY `id` ASC";
						$cqry=mysql_query($cqry);
						$nrc=mysql_num_rows($cqry);
						$sel="";
						for($i=0;$i<$nrc;$i++){
							$country=mysql_fetch_array($cqry);
							if($theuser["state"]==$country["id"]){
								$sel=" selected='selected'";
							} else {
								$sel="";
							}
							echo "<option".$sel." value='".$country["id"]."' class='forms'>".$country["name"]."</option>";
						}
					?>
					</select></div>
					</font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">City<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="city" id="city" size="35" value="<?=$theuser["city"]?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Zip:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="zip" id="zip" size="35" value="<?=$theuser["zip"]?>" />
					</font></td>
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
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<?
					//create the list of fields that have to ve verified
					$verif="screenname,pass,email,sex,month,day,year,country,city";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('editform','<?=$verif ?>')" style="width: 100px; height: 30px; color:#333333;" name="insert" value="Save">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="width: 100px; height: 30px; color:#333333;" name="reset" value="Reset"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>	
	</form>
	
	<tr>
		<td height="40"></td>
	</tr>

	
	<tr>
	  <td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%" >
		  <tr>
			<td align="left"><a name="Pictures"><font class="tablename">Pictures</font></a></td>
			<td align="right" style="font: bold 12px verdana;"><a href="javascript: void(0);" onclick="javascript: window.open('addphoto.php?t=image&e=<?php echo $_GET['id'];?>','addpicture','resizable=yes,scrollbars=yes,width=700,height=400');" target="_blank">Add Picture</a></td>
		  </tr>
		</table>
	  </td>
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
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="top">
					
						<table border="0" width="100%" cellpadding="1" cellspacing="1">
						  <tr>
						    <?php
						    $pic_i = 0; 
						    while($pics_obj = @mysql_fetch_object($pics_sql)){ ?>
					        <td align="center">
					          <table  <?php if($pics_obj->gallery == 0) echo "bgcolor='#F7B5B5'"; else  echo "bgcolor='#CCCCCC'";?> width="200" style="font-size:13px; font-face:Verdana;" border="0" cellpadding="1" cellspacing="1">
					            <tr>
					             <td width="105" align="center" valign="top">
					               <a href="javascript: window.open('<?php echo $cfg['path']['url_site']?>showphoto.php?photo_id=<?=$pics_obj->id;?>&t=b','picwindow','resizable=yes,scrollbars=yes,width=700, height=700'); void(0);"><img src="<?=$cfg['path']['url_site'] . "showphoto.php?id=" . $_GET['id'] . "&t=s&photo_id=" . $pics_obj->id; ?>" border="1">
					             </td>
					             <td valign="top" width="95">
					              <b><?php echo $pics_obj->photo_name;?></b><br>
					                 <?php echo $pics_obj->photo_description;?>
					             </td>
					            </tr>
					            <tr>
					              <td colspan="2" align="left">
					                <a href="deletecontent.php?type=pic&user_id=<?=$_GET['id'];?>&content_id=<?php echo $pics_obj->id;?>">Delete</a> | <a href="setgallery.php?type=pic&gallery=<?php echo $pics_obj->gallery;?>&content_id=<?php echo $pics_obj->id;?>"><?php if($pics_obj->gallery == 1) echo "Make Private"; else echo "Make Public"; ?></a>
					              </td>
					            </tr>
					          </table>
					          <br>
					        </td>
					        <?php
					        $pic_i++;
					        if($pic_i % 5 == 0 ){
					        	echo "</tr><tr>";
					        } 
						    } ?>
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
		<td height="20"></td>
	</tr>
	
	<tr>
	  <td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		  <tr>
			<td align="left"><a name="Videos"><font class="tablename">Videos</font></a></td>
			<td align="right" style="font: bold 12px verdana;"><a href="javascript: void(0);" onclick="javascript: window.open('addvideo.php?t=video&e=<?php echo $_GET['id'];?>','addvideo','resizable=yes,scrollbars=yes,width=700,height=400');" target="_blank">Add Video</a></td>
		  </tr>
		</table>
	  </td>
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
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="top">
					
						<table border="0" width="100%" cellpadding="1" cellspacing="1">
						  <tr>
						    <?php
						    $video_i = 0; 
						    while($videos_obj = @mysql_fetch_object($videos_sql)){ ?>
					        <td align="center">
					          <table <?php if($videos_obj->gallery == 0) echo "bgcolor='#F7B5B5'"; else  echo "bgcolor='#CCCCCC'";?> width="200" style="font-size:13px; font-face:Verdana;" border="0" cellpadding="1" cellspacing="1">
					            <tr>
					             <td width="105" align="center" valign="top">
					               <a href="javascript: window.open('video_player.php?vid=<?=$videos_obj->id;?>','videowindow','resizable=yes,scrollbars=yes,width=400, height=350'); void(0);"><img src="<?=$cfg['path']['url_site'] . "videothumb.php?user_id=" . $_GET['id'] . "&id=" . $videos_obj->id; ?>" border="1"></a>
					             </td>
					             <td valign="top" width="95">
					              <b><?php echo $videos_obj->video_name;?></b><br>
					                 <?php echo $videos_obj->video_description;?>
					             </td>
					            </tr>
					            <tr>
					              <td colspan="2" align="left">
					                <a href="deletecontent.php?type=video&user_id=<?=$_GET['id'];?>&content_id=<?php echo $videos_obj->id;?>">Delete</a> | <a href="setgallery.php?type=video&gallery=<?php echo $videos_obj->gallery;?>&content_id=<?php echo $videos_obj->id;?>"><?php if($videos_obj->gallery == 1) echo "Make Private"; else echo "Make Public"; ?></a>
					              </td>
					            </tr>
					          </table>
					          <br>
					        </td>
					        <?php
					        $video_i++;
					        if($video_i % 5 == 0 ){
					        	echo "</tr><tr>";
					        } 
						    } ?>
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
		<td height="100%"></td>
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