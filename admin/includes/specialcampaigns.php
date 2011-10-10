<?
	if(!empty($_POST["action"]) && $_POST["action"]=="add"){
		$anr=rand(0, 200);
		echo $qry="insert into tblCampaign (SubjectIntern) values ('campaignneedstobeupdated".$anr."')";
		echo "<br>";
		$qry=mysql_query($qry);
		$qry="update tblCampaign set";
		$qry.=" Sex='".$_POST["sex"]."'";
		$qry.=", LookingFor='".$_POST["looking"]."'";
		$qry.=", Joined='".$_POST["joined"]." 00:00:00'";
		$qry.=", JoinedUntil='".$_POST["joineduntil"]." 23:59:59'";
		$qry.=", LastLogin='".$_POST["login"]." 00:00:00'";
		$qry.=", LastLoginUntil='".$_POST["loginuntil"]." 23:59:59'";
		$qry.=", ReceivedFakeMail='".$_POST["receivedfakemail"]."'";
		$qry.=", Revived='".$_POST["revived"]."'";
		$qry.=", Marlon='".$_POST["marlon"]."'";
		$qry.=", RespondedFakeMail='".$_POST["respondedfakemail"]."'";
		$qry.=", NeverOpened='".$_POST["neveropened"]."'";
		$qry.=", PayedMembers='".$_POST["payed"]."'";
		$qry.=", Cancelled='".$_POST["cancelled"]."'";
		$qry.=", March06DB='".$_POST["march"]."'";
		$qry.=", JoinedOn='".$_POST["joinedon"]." 00:00:00'";
		$qry.=", JoinedOnUntil='".$_POST["joinedonuntil"]." 23:59:59'";
		$qry.=", SendFrom='".$_POST["sendfrom"]."'";
		$qry.=", Nr='".$_POST["nr"]."'";
		$qry.=", `Interval`='".$_POST["interval"]."'";
		$qry.=", SubjectExtern='".$_POST["subjectext"]."'";
		$qry.=", MessageExtern='".$_POST["messageext"]."'";
		$qry.=", SubjectIntern='".$_POST["subjectint"]."'";
		$qry.=", MessageIntern='".$_POST["messageint"]."'";
		$qry.=", MultiDelay='".$_POST["multidelay"]."'";
		echo $qry.=" where SubjectIntern='campaignneedstobeupdated".$anr."'";
		$msg="The campaign ".$_POST["subject"]." was inserted into the database!";
		$qry=mysql_query($qry);
		echo("<script>document.location.href='index.php?content=addcampaign&msg=".$msg."'</script>");
	}
?>
<form name="addform" method="post" action="index.php?content=addcampaign">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
			<td width="100%"><font class="pagetitle">Special Campaign </font></td>
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
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="sex" id="sex">
					<option value="man">Man</option>
					<option value="woman">Woman</option>
					<option value="couple">Couple (man and woman)</option>
					<option value="group">Group</option>
					<option value="lesbian">Lesbian Couple (two women)</option>
					<option value="gay">Gay Coople (who men)</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking for:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="looking" id="looking">
					<option value="">-anything--</option>
					<option value="man">Man</option>
					<option value="woman">Woman</option>
					<option value="couple">Couple (man and woman)</option>
					<option value="group">Group</option>
					<option value="lesbian">Lesbian Couple (two women)</option>
					<option value="gay">Gay Coople (who men)</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="30%" align="right"><font class="tabletext">Joined from:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-1" name="joined" size="27" value="<?=$_POST["joined"] ?>"><a id="f-calendar-trigger-1" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joineduntil" size="25" value="<?=$_POST["joineduntil"] ?>"><a id="f-calendar-trigger-2" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="30%" align="right"><font class="tabletext">Last login from:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-3" name="login" size="27" value="<?=$_POST["login"] ?>"><a id="f-calendar-trigger-3" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="loginuntil" size="25" value="<?=$_POST["loginuntil"] ?>"><a id="f-calendar-trigger-4" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
					</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Received Staff Accountmail:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="receivedfakemail" id="receivedfakemail">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Revived:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="revived" id="revived">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Marlon:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="marlon" id="marlon">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Responded to Staff Accountmail:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="respondedfakemail" id="respondedfakemail">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Who never opened mail:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="neveropened" id="neveropened">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Payed members:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="payed" id="payed">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Cancelled members:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="cancelled" id="cancelled">
					<option value="">--All--</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">March 06 DB :</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="march" id="march">
					<option value="">--All--</option>
					<option value="1">Paid</option>
					<option value="0">Free</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="30%" align="right"><font class="tabletext">Joined on:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-1" name="joinedon" size="27" value="<?=$_POST["joined"] ?>"><a id="f-calendar-trigger-1" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joinedonuntil" size="25" value="<?=$_POST["joineduntil"] ?>"><a id="f-calendar-trigger-2" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Send it from:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="sendfrom" id="sendfrom">
					<option value="01toygirl">01toygirl</option>
					<option value="16kady">16kady</option>
					<option value="19-4love">19-4love</option>
					<option value="1fungal">1fungal</option>
					<option value="1hutlover">1hutlover</option>
					<option value="1hotmomma4u">1hotmomma4u</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">How many emails:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="nr" id="nr">
					<option value="1">1</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500" selected="selected">500</option>
					<option value="1000">1000</option>
					<option value="1500">1500</option>
					<option value="2000">2000</option>
					<option value="5000">5000</option>
					<option value="10000">10000</option>
					<option value="60000">60000</option>
					<option value="125000">125000</option>
					<option value="">all</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Interval between emails(in seconds):</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="interval" id="interval">
					<option value="3">3</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="60" selected="selected">60</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td bgcolor="#FFFFE6" width="100%" style="padding:10px"><font class="tabletext" style="font-weight:bold"><font color="#990000">Note!</font> You can use: [%to_name%], [%fake_user%], [%location%], [%to_id%], [%image_link%], [%hidden_image%], [%login_link%] and [%to_password%].</font></td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Subject Extern:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="subjectext" id="subjectext" size="35" value="" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Message External:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><textarea class="tabletext" name="messageext" id="messageext" cols="62" rows="5"></textarea></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Subject Intern*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="subjectint" id="subjectint" size="35" value="" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Message Internal*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><textarea class="tabletext" name="messageint" id="messageint" cols="62" rows="5"></textarea></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Send only a test to this screen name<br /><font style="font-size:10px">(let it be blank if you don't wish to send a test message)</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="testscreen" id="testscreen" size="35" value="" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Send multi delay Staff Accountfrom <br /><font style="font-size:10px">(let it be blank if you don't wish to send this campaign as multi-delay fake)</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="multidelay" id="multidelay">
					<option value="">--is not an auto-fake--</option>
					<option value="1Girls_looking_guys">1Girls_looking_guys</option>
					<option value="girls2_looking_guys">girls2_looking_guys</option>
					</select></font></td>
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
					$verif="subjectint,messageint";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="color:#333333" name="insert" value="Send">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333" name="reset" value="Reset"></font></td>
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