<?
	if(!$_GET['id'] or $_GET['id'] <= 0){
		echo "<script>window.location='index.php?content=addnewsletter'</script>";
		exit;
	}
	
	if(!empty($_POST["action"]) && $_POST["action"]=="edit")
	{
		@mysql_query("DELETE FROM `tblNewsletterMails` WHERE `newsletterid` = '" . $_GET['id'] . "'");
		
		$looking_arr = array();
		$looking_arr = $_POST['looking'];
		
		$looking = 0;
	    foreach ($looking_arr as $param)
	    {
		 	$looking |= (1 << $param);
		}
		
		$sql = "UPDATE `tblNewsletter` SET `title` = '" . addslashes(trim($_POST['title'])) . "', 
		                                 `description` = '" . addslashes(trim($_POST['description'])) . "', 
		                                 `sex` = '" . $_POST['sex'] . "', 
		                                 `looking` = '" . $looking . "', 
		                                 `joinedfrom` = '" . $_POST['joinedfrom'] . "', 
		                                 `joinedto` = '" . $_POST['joinedto'] . "', 
		                                 `lastloginfrom` = '" . $_POST['lastloginfrom'] . "', 
		                                 `lastloginto` = '" . $_POST['lastloginto'] . "', 
		                                 `mailreceived` = '" . $_POST['mailreceived'] . "', 
		                                 `mailresponded` = '" . $_POST['mailresponded'] . "', 
		                                 `mailopened` = '" . $_POST['mailopened'] . "', 
		                                 `payed` = '" . $_POST['payed'] . "', 
		                                 `cancelled` = '" . $_POST['cancelled'] . "', 
		                                 `howmany` = '" . $_POST['howmany'] . "', 
		                                 `interval` = '" . $_POST['interval'] . "', 
		                                 `subject` = '" . addslashes(trim($_POST['subject'])) . "', 
		                                 `message` = '" . addslashes(trim($_POST['message'])) . "', 
		                                 `sendemail` = '" . $_POST['sendemail'] . "', 
		                                 `sendname` = '" . $_POST['sendname'] . "', 
		                                 `toscreenname` = '" . addslashes(trim($_POST['toscreenname'])) . "', 
		                                 `finishedaddmails` = 'N', 
		                                 `finished` = 'N', 
		                                 `running` = 'N', 
		                                 `recipients` = '0', 
		                                 `sent` = '0', 
		                                 `readed` = '0', 
		                                 `bounced` = '0', 
		                                 `login` = '0', 
		                                 `upgraded` = '0' 
		                               WHERE `id` = '" . $_GET['id'] . "'";
		
		if($looking > 0 OR trim($_POST['toscreenname']))
		{
			$query = mysql_query($sql);
		    
			if(mysql_affected_rows() > 0){
				$msg = "Newsletter WAS SUCCESFULLY INSERT";
			} else {
				$msg = "<font color='red'> ERROR: newsletter WAS NOT INSERT!! Unknown Error!!</font>";
			}
		} else {
			$msg = "<font color='red'> ERROR: newsletter WAS NOT INSERT!! <br> Select 'Looking For'!</font>";
		}
	} else {
		$msg = '';
	}
	
	$array_newsletter = mysql_fetch_array(mysql_query("SELECT * FROM `tblNewsletter` WHERE `id` = '" . $_GET['id'] . "'"));
?>
<form name="editform" method="post" action="index.php?content=editnewsletter&id=<?=$_GET["id"]?>">
<input type="hidden" name="action" value="edit" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
			<td width="100%"><font class="pagetitle">Edit Newsletter </font></td>
	</tr>
	<tr>
			<td height="30" width="100%"><span style="font-size: 12px;"> <font color="red">(if you edit a newsletter ALL old newsletter will be lost)</font> </span></td>
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
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="100" type="text" class="tabletext" name="title" id="title" size="35" value="<?=$array_newsletter['title']?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Description:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="150" type="text" class="tabletext" name="description" id="description" size="35" value="<?=$array_newsletter['description']?>" /></font></td>
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
					      	if($array_newsletter['sex'] == $s_i){
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
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking for:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					    <?for($s_i = 0; $s_i < count($cfg['profile']['looking']); $s_i++)
					      {
					      	echo "<input type='checkbox' name='looking[". $s_i ."]' value='". $s_i ."'>" . $cfg['profile']['looking'][$s_i] . "&nbsp;&nbsp;&nbsp;";
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
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-1" name="joinedfrom" size="27" value="<?=$array_newsletter['joinedfrom']?>"><a id="f-calendar-trigger-1" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joinedto" size="25" value="<?=$array_newsletter['joinedto']?>"><a id="f-calendar-trigger-2" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="25%" align="right"><font class="tabletext">Last login from:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-3" name="lastloginfrom" size="27" value="<?=$array_newsletter['lastloginfrom']?>"><a id="f-calendar-trigger-3" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="lastloginto" size="25" value="<?=$array_newsletter['lastloginto']?>"><a id="f-calendar-trigger-4" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
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
					<option value="A" <? if($array_newsletter['mailreceived'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_newsletter['mailreceived'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_newsletter['mailreceived'] == 'N'){echo "selected";}?> >No</option>
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
					<option value="A" <? if($array_newsletter['mailresponded'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_newsletter['mailresponded'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_newsletter['mailresponded'] == 'N'){echo "selected";}?> >No</option>
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
					<option value="A" <? if($array_newsletter['mailopened'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_newsletter['mailopened'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_newsletter['mailopened'] == 'N'){echo "selected";}?> >No</option>
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
					<option value="A" <? if($array_newsletter['payed'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_newsletter['payed'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_newsletter['payed'] == 'N'){echo "selected";}?> >No</option>
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
					<option value="A" <? if($array_newsletter['cancelled'] == 'A'){echo "selected";}?> >--All--</option>
					<option value="Y" <? if($array_newsletter['cancelled'] == 'Y'){echo "selected";}?> >Yes</option>
					<option value="N" <? if($array_newsletter['cancelled'] == 'N'){echo "selected";}?> >No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send it from email:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <input name="sendemail" value="<?=$array_newsletter['sendemail'];?>">
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send it from name:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <input name="sendname" value="<?=$array_newsletter['sendname'];?>">
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">How many emails:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="howmany" id="nr">
					<option value="0" <? if($array_newsletter['howmany'] == '0'){echo "selected";}?> >-all-</option>
					<option value="1" <? if($array_newsletter['howmany'] == '1'){echo "selected";}?> >1</option>
					<option value="50" <? if($array_newsletter['howmany'] == '50'){echo "selected";}?> >50</option>
					<option value="100" <? if($array_newsletter['howmany'] == '100'){echo "selected";}?> >100</option>
					<option value="250" <? if($array_newsletter['howmany'] == '250'){echo "selected";}?> >250</option>
					<option value="500" <? if($array_newsletter['howmany'] == '500'){echo "selected";}?> >500</option>
					<option value="1000" <? if($array_newsletter['howmany'] == '1000'){echo "selected";}?> >1000</option>
					<option value="1500" <? if($array_newsletter['howmany'] == '1500'){echo "selected";}?> >1500</option>
					<option value="2000" <? if($array_newsletter['howmany'] == '2000'){echo "selected";}?> >2000</option>
					<option value="5000" <? if($array_newsletter['howmany'] == '5000'){echo "selected";}?> >5000</option>
					<option value="10000" <? if($array_newsletter['howmany'] == '10000'){echo "selected";}?> >10000</option>
					<option value="60000" <? if($array_newsletter['howmany'] == '60000'){echo "selected";}?> >60000</option>
					<option value="125000" <? if($array_newsletter['howmany'] == '125000'){echo "selected";}?> >125000</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Interval between emails(in seconds):</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="interval" id="interval">
					<option value="3" <? if($array_newsletter['interval'] == '3'){echo "selected";}?> >3</option>
					<option value="10" <? if($array_newsletter['interval'] == '10'){echo "selected";}?> >10</option>
					<option value="15" <? if($array_newsletter['interval'] == '15'){echo "selected";}?> >15</option>
					<option value="20" <? if($array_newsletter['interval'] == '20'){echo "selected";}?> >20</option>
					<option value="30" <? if($array_newsletter['interval'] == '30'){echo "selected";}?> >30</option>
					<option value="60" <? if($array_newsletter['interval'] == '60'){echo "selected";}?> >60</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td bgcolor="#FFFFE6" width="100%" style="padding:10px"><font class="tabletext" style="font-weight:bold"><font color="#990000">Note!</font> You can use: [%to_name%], [%from_name%], [%to_location%], [%from_location%], [%to_imagelink%], [%from_imagelink%], [%to_videolink%], [%from_videolink%],<br/> [%hidden_image%], [%login_link%] and [%to_password%].</font></td>
			</tr>
			<tr>
				<td  height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr style="padding-top: 30px;">
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Subject<font class="tablename">*</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="100" type="text" class="tabletext" name="subject" id="subject" style="width: 95%" value="<?=$array_newsletter['subject'];?>" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Message<font class="tablename">*</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><textarea class="tabletext" name="message" id="message" style="width: 95%; height: 400px;"><?=trim($array_newsletter['message']);?></textarea></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send only a test to this screen name<br /><font style="font-size:10px">(let it be blank if you don't wish to send a test message)</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="15" type="text" class="tabletext" name="toscreenname" id="testscreen" size="35" value="<?=trim($array_newsletter['toscreenname']);?>" /></font></td>
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
					$verif="subject,message";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('editform','<?=$verif ?>')" style="color:#333333; width: 200px; height: 35px;" name="insert" value="Save Changes">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333; width: 200px; height: 35px;" name="reset" value="Reset Fields"></font></td>
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
	if(document.getElementById('newsletter1').style.display == 'none'){
		document.getElementById('newsletter1').style.display = '';
	}
	if(document.getElementById('newsletter2').style.display == 'none'){
		document.getElementById('newsletter2').style.display = '';
	}
	if(document.getElementById('newsletter3').style.display == 'none'){
		document.getElementById('newsletter3').style.display = '';
	}
</script>