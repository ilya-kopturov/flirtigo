<?php
/* $Id$ */

	if(!$_GET['id'] or $_GET['id'] <= 0){
		echo "<script>window.location='index.php?content=gallery_listmass'</script>";
		exit;
	}
	
	if(!empty($_POST["action"]) && $_POST["action"]=="edit")
	{
		@mysql_query("DELETE FROM `tblMassRequestMails` WHERE `campaignid` = '" . (int) $_GET['id'] . "'");
		
		$looking_arr = array();
		$looking_arr = $_POST['looking'];
		
		$looking = 0;
	    foreach ($looking_arr as $param)
	    {
		 	$looking |= (1 << $param);
		}
		
		
		$emailserver_arr = array();
		$emailserver_arr = $_POST['emailserver'];
		
		$emailserver = 0;
	    foreach ($emailserver_arr as $param)
	    {
		 	$emailserver |= (1 << $param);
		}
		
		$sql = "UPDATE `tblMassRequest` SET `title` = '" . addslashes(trim($_POST['title'])) . "', 
		                                 `description` = '" . addslashes(trim($_POST['description'])) . "', 
		                                 `age_from` = '" . (int) $_POST['age_from'] . "', 
		                                 `age_to` = '" . (int) $_POST['age_to'] . "', 
		                                 `sex` = '" . (int) $_POST['sex'] . "', 
		                                 `looking` = '" . (int) $looking . "', 
		                                 `joinedfrom` = '" . $_POST['joinedfrom'] . "', 
		                                 `joinedto` = '" . $_POST['joinedto'] . "', 
		                                 `lastloginfrom` = '" . $_POST['lastloginfrom'] . "', 
		                                 `lastloginto` = '" . $_POST['lastloginto'] . "', 
		                                 `mailreceived` = '" . $_POST['mailreceived'] . "', 
		                                 `mailresponded` = '" . $_POST['mailresponded'] . "', 
		                                 `mailopened` = '" . $_POST['mailopened'] . "', 
		                                 `loggedin` = '" . $_POST['loggedin'] . "', 
		                                 `payed` = '" . $_POST['payed'] . "', 
		                                 `cancelled` = '" . $_POST['cancelled'] . "', 
		                                 `sendexternal` = '" . $_POST['sendexternal'] . "', 
		                                 `howmany` = '" . (int) $_POST['howmany'] . "', 
		                                 `emailserver` = '" . (int) $emailserver . "', 
		                                 `interval` = '" . (int) $_POST['interval'] . "', 
		                                 `origin` = '" . $_POST['origin'] . "', 
		                                 `originaccesslevel` = '" . $_POST['originaccesslevel'] . "', 
		                                 `emailstatus` = '" . $_POST['emailstatus'] . "', 
		                                 `sendid` = '" . (int) $_POST['sendid'] . "', 
		                                 `toscreenname` = '" . addslashes(trim($_POST['toscreenname'])) . "', 
		                                 `toseed` = '" . addslashes(trim($_POST['seed_to'])) . "', 
		                                 `toevery` = '" . (int) $_POST['seed_every'] . "', 
		                                 `finishedaddmails` = 'N', 
		                                 `ready` = 'N',
		                                 `finished` = 'N', 
		                                 `running` = 'N', 
		                                 `recipients` = '0', 
		                                 `sent` = '0', 
		                                 `readed` = '0', 
		                                 `bounced` = '0', 
		                                 `login` = '0', 
		                                 `upgraded` = '0', 
		                                 `date` = NOW() 
		                               WHERE `id` = '" . (int) $_GET['id'] . "'";
		
		if(($emailserver > 0 AND $looking > 0) OR trim($_POST['toscreenname']))
		{
			$query = mysql_query($sql);
		    
			if(mysql_affected_rows() > 0 OR !@mysql_error()){
				$msg = "MassRequest SUCCESFULLY INSERT";
			} else {
				$msg = "<font color='red'> ERROR: MassRequest WAS NOT INSERT!! Unknown Error!! <br> " . mysql_error() . "</font>";
			}
		} else {
			$msg = "<font color='red'> ERROR: MassRequest WAS NOT INSERT!! <br> Select 'Looking For' AND 'Email Server'!</font>";
		}
	} else {
		$msg = '';
	}
	
	$array_campaign = mysql_fetch_array(mysql_query("SELECT * FROM `tblMassRequest` WHERE `id` = '" . $_GET['id'] . "'"));
?>
<form name="editform" method="post" action="index.php?content=editgallery_listmass&id=<?=$_GET["id"]?>">
<input type="hidden" name="action" value="edit" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
			<td width="100%"><font class="pagetitle">Edit MassRequest Campaign</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$msg;?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">* - required fields</font></td>
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
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Title:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="100" type="text" class="tabletext" name="title" id="title" size="35" value="<?=$array_campaign['title']?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Description:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="150" type="text" class="tabletext" name="description" id="description" size="35" value="<?=$array_campaign['description']?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr><tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Age:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <select class="tabletext" name="age_from" id="age_from">
					    <?for($s_i = 18; $s_i < 100; $s_i++)
					      {
					      	if($array_campaign['age_from'] == $s_i){
					      		echo "<option value='". $s_i ."' selected>" . $s_i . "</option>";
					      	} else {
					      		echo "<option value='". $s_i ."'>" . $s_i . "</option>";
					      	}
					      }
					    ?>
					  </select> 
					  - 
					  <select class="tabletext" name="age_to" id="age_to">
					    <?for($s_i = 18; $s_i < 100; $s_i++)
					      {
					      	if($array_campaign['age_to'] == $s_i){
					      		echo "<option value='". $s_i ."' selected>" . $s_i . "</option>";
					      	} else {
					      		echo "<option value='". $s_i ."'>" . $s_i . "</option>";
					      	}
					      }
					    ?>
					  </select> 
					</font></td>
				</tr>
				</table>				
				</td>
			</tr><tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <select class="tabletext" name="sex" id="sex">
					    <?for($s_i = 0; $s_i < count($cfg['profile']['sex']); $s_i++)
					      {
					      	if($array_campaign['sex'] == $s_i){
					      		echo "<option value='". $s_i ."' selected>" . $cfg['profile']['sex'][$s_i] . "</option>";
					      	} else {
					      		echo "<option value='". $s_i ."'>" . $cfg['profile']['sex'][$s_i] . "</option>";
					      	}
					      }
					    ?>
					  </select>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking for<font color="red">*</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					    <?for($s_i = 0; $s_i < count($cfg['profile']['looking']); $s_i++)
					      {
					      	if($array_campaign['looking'] & (1 << $s_i)){ $sel = 'checked'; } else { $sel = ''; }
					      	echo "<input type='checkbox' name='looking[". $s_i ."]' value='". $s_i ."' " . $sel .">" . $cfg['profile']['looking'][$s_i] . "&nbsp;&nbsp;&nbsp;";
					      }
					    ?>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="25%" align="right"><font class="tabletext">Joined on:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-1" name="joinedfrom" size="27" value="<?=$array_campaign['joinedfrom']?>"><a id="f-calendar-trigger-1" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joinedto" size="25" value="<?=$array_campaign['joinedto']?>"><a id="f-calendar-trigger-2" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="25%" align="right"><font class="tabletext">Last login from:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-3" name="lastloginfrom" size="27" value="<?=$array_campaign['lastloginfrom']?>"><a id="f-calendar-trigger-3" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="lastloginto" size="25" value="<?=$array_campaign['lastloginto']?>"><a id="f-calendar-trigger-4" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
					</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Received Staff Accountmail:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="mailreceived">
					<option value="A" <? if($array_campaign['mailreceived'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['mailreceived'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['mailreceived'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Responded to Staff Accountmail:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="mailresponded">
					<option value="A" <? if($array_campaign['mailresponded'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['mailresponded'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['mailresponded'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Who never opened mail:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="mailopened">
					<option value="A" <? if($array_campaign['mailopened'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['mailopened'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['mailopened'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Users Who logged in:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="loggedin">
					<option value="A" <? if($array_campaign['loggedin'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['loggedin'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['loggedin'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Payed members:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="payed">
					<option value="A" <? if($array_campaign['payed'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['payed'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['payed'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Cancelled members:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="cancelled" >
					<option value="A" <? if($array_campaign['cancelled'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_campaign['cancelled'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['cancelled'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send External emails:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="sendexternal" >
					<option value="Y" <? if($array_campaign['sendexternal'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_campaign['sendexternal'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send it from:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<? $qry_staffacc=mysql_query("SELECT `id`,`screenname` FROM `tblUsers` WHERE `typeusr` = 'Y' ORDER BY `screenname` ASC");?>
					<select class="tabletext" name="sendid" id="sendfrom">
					<? while($row_staffacc=mysql_fetch_array($qry_staffacc)){?>
					<option value="<?=$row_staffacc['id']?>"  <? if($array_campaign['sendid'] == $row_staffacc['id']){echo "selected";}?>  ><?=$row_staffacc['screenname']?></option>
					<? }?>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">How many emails:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="howmany" id="nr">
					<option value="1" <? if($array_campaign['howmany'] == '1'){echo "selected";}?> >1</option>
					<option value="50" <? if($array_campaign['howmany'] == '50'){echo "selected";}?> >50</option>
					<option value="100" <? if($array_campaign['howmany'] == '100'){echo "selected";}?> >100</option>
					<option value="250" <? if($array_campaign['howmany'] == '250'){echo "selected";}?> >250</option>
					<option value="500" <? if($array_campaign['howmany'] == '500'){echo "selected";}?> >500</option>
					<option value="1000" <? if($array_campaign['howmany'] == '1000'){echo "selected";}?> >1000</option>
					<option value="1500" <? if($array_campaign['howmany'] == '1500'){echo "selected";}?> >1500</option>
					<option value="2000" <? if($array_campaign['howmany'] == '2000'){echo "selected";}?> >2000</option>
					<option value="5000" <? if($array_campaign['howmany'] == '5000'){echo "selected";}?> >5000</option>
					<option value="10000" <? if($array_campaign['howmany'] == '10000'){echo "selected";}?> >10000</option>
					<option value="60000" <? if($array_campaign['howmany'] == '60000'){echo "selected";}?> >60000</option>
					<option value="125000" <? if($array_campaign['howmany'] == '125000'){echo "selected";}?> >125000</option>
					<option value="0" <? if($array_campaign['howmany'] == '0'){echo "selected";}?> >all</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Server:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					    <?for($s_i = 0; $s_i < count($cfg['option']['emailserver']); $s_i++)
					      {
					      	if($array_campaign['emailserver'] & (1 << $s_i)){ $sel = 'checked'; } else { $sel = ''; }
					      	echo "<input type='checkbox' name='emailserver[". $s_i ."]' value='". $s_i ."' " . $sel .">" . $cfg['option']['emailserver'][$s_i] . "&nbsp;&nbsp;&nbsp;";
					      }
					    ?>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Interval between emails(in seconds):</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="interval" id="interval">
					<option value="3" <? if($array_campaign['interval'] == '3'){echo "selected";}?> >3</option>
					<option value="10" <? if($array_campaign['interval'] == '10'){echo "selected";}?> >10</option>
					<option value="15" <? if($array_campaign['interval'] == '15'){echo "selected";}?> >15</option>
					<option value="20" <? if($array_campaign['interval'] == '20'){echo "selected";}?> >20</option>
					<option value="30" <? if($array_campaign['interval'] == '30'){echo "selected";}?> >30</option>
					<option value="60" <? if($array_campaign['interval'] == '60'){echo "selected";}?> >60</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Origin:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<? $qry_origin=mysql_query("SELECT DISTINCT `origin` FROM `tblUsers` WHERE `origin` != ''");?>
					<select class="tabletext" name="origin">
					<option value="A">--All--</option>
					<? while($row_staffacc=mysql_fetch_array($qry_origin)){?>
					<option value="<?=$row_staffacc['origin'];?>" <? if($array_campaign['origin'] == $row_staffacc['origin']){echo "selected";} ?> ><?=ucfirst($row_staffacc['origin']);?></option>
					<? }?>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Origin access level:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="originaccesslevel">
					<option value="A">--All--</option>
					<option value="F" <? if($array_campaign['originaccesslevel'] == 'F'){echo "selected";}?>>Free</option>
					<option value="P" <? if($array_campaign['originaccesslevel'] == 'P'){echo "selected";}?>>Paid</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Status:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailstatus">
					<option value="A">--All--</option>
					<option value="G" <? if($array_campaign['emailstatus'] == 'G'){echo "selected";}?>>Good</option>
					<option value="GD" <? if($array_campaign['emailstatus'] == 'GD'){echo "selected";}?>>Good+Defered</option>
					<option value="B" <? if($array_campaign['emailstatus'] == 'B'){echo "selected";}?>>Bounced</option>
					<option value="I" <? if($array_campaign['emailstatus'] == 'I'){echo "selected";}?>>Invalid</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send only a test to this screen name<br /><font style="font-size:10px">(let it be blank if you don't wish to send a test message)</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="15" type="text" class="tabletext" name="toscreenname" id="testscreen" size="35" value="<?=trim($array_campaign['toscreenname']);?>" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Add Seed:</font></td>
					<td width="75%" align="left" class="tabletext">&nbsp;
					  <input type="text" name="seed_to" size="100" value="<?=trim($array_campaign['toseed']);?>" class="tabletext" maxlength="250" /> &nbsp; every &nbsp; 
					  <select name="seed_every">
					    <option value="0" >-none-</option>
					    <option value="1" <?if($array_campaign['toevery'] == '1') echo 'selected';?> >1.000th</option>
					    <option value="2" <?if($array_campaign['toevery'] == '2') echo 'selected';?> >2.000th</option>
					    <option value="10" <?if($array_campaign['toevery'] == '10') echo 'selected';?> >10.000th</option>
					    <option value="25" <?if($array_campaign['toevery'] == '25') echo 'selected';?> >25.000th</option>
					    <option value="50" <?if($array_campaign['toevery'] == '50') echo 'selected';?> >50.000th</option>
					    <option value="75" <?if($array_campaign['toevery'] == '75') echo 'selected';?> >75.000th</option>
					    <option value="100" <?if($array_campaign['toevery'] == '100') echo 'selected';?> >100.000th</option>
					    <option value="150" <?if($array_campaign['toevery'] == '150') echo 'selected';?> >150.000th</option>
					    <option value="200" <?if($array_campaign['toevery'] == '200') echo 'selected';?> >200.000th</option>
					    <option value="250" <?if($array_campaign['toevery'] == '250') echo 'selected';?> >250.000th</option>
					    <option value="300" <?if($array_campaign['toevery'] == '300') echo 'selected';?> >300.000th</option>
					    <option value="400" <?if($array_campaign['toevery'] == '400') echo 'selected';?> >400.000th</option>
					    <option value="500" <?if($array_campaign['toevery'] == '500') echo 'selected';?> >500.000th</option>
					  </select>
					  <br>
					  &nbsp;&nbsp;&nbsp;&nbsp;<font color="red" size="1">Ex: mail1@mailserver.com, mail2@mailserver.com, .....</font>
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
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="submit" style="color:#333333; width: 200px; height: 35px;" name="insert" value="Save Changes">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333; width: 200px; height: 35px;" name="reset" value="Reset Fields"></font></td>
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
	if(document.getElementById('gallerypass1').style.display == 'none'){
		document.getElementById('gallerypass1').style.display = '';
	}
	if(document.getElementById('gallerypass2').style.display == 'none'){
		document.getElementById('gallerypass2').style.display = '';
	}
	if(document.getElementById('gallerypass3').style.display == 'none'){
		document.getElementById('gallerypass3').style.display = '';
	}
	if(document.getElementById('gallerypass4').style.display == 'none'){
		document.getElementById('gallerypass4').style.display = '';
	}
</script>