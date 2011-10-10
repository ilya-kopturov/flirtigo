<?
/* $Id$ */

	if(!empty($_POST["action"]) && $_POST["action"]=="add")
	{
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
		
		$sql = "INSERT INTO `tblMassRequest` 
		                        (`title`, 
		                         `description`, 
		                         `age_from`,
		                         `age_to`,
		                         `sex`, 
		                         `looking`, 
		                         `joinedfrom`, 
		                         `joinedto`, 
		                         `lastloginfrom`, 
		                         `lastloginto`, 
		                         `mailreceived`, 
		                         `mailresponded`, 
		                         `mailopened`, 
		                         `loggedin`,
		                         `payed`, 
		                         `cancelled`, 
		                         `sendexternal`, 
		                         `howmany`, 
		                         `emailserver`,
		                         `interval`, 
		                         `origin`,
		                         `originaccesslevel`,
		                         `emailstatus`,
		                         `sendid`, 
		                         `toscreenname`, 
		                         `toseed`, 
		                         `toevery`, 
		                         `date`) 
		                  VALUES 
		                        ('" . addslashes(trim($_POST['title'])) . "', 
		                         '" . addslashes(trim($_POST['description'])) . "', 
		                         '" . (int) $_POST['age_from'] . "', 
		                         '" . (int) $_POST['age_to'] . "', 
		                         '" . (int) $_POST['sex'] . "', 
		                         '" . (int) $looking . "', 
		                         '" . $_POST['joinedfrom'] . "', 
		                         '" . $_POST['joinedto'] . "', 
		                         '" . $_POST['lastloginfrom'] . "', 
		                         '" . $_POST['lastloginto'] . "', 
		                         '" . $_POST['mailreceived'] . "', 
		                         '" . $_POST['mailresponded'] . "', 
		                         '" . $_POST['mailopened'] . "', 
		                         '" . $_POST['loggedin'] . "', 
		                         '" . $_POST['payed'] . "', 
		                         '" . $_POST['cancelled'] . "', 
		                         '" . $_POST['sendexternal'] . "', 
		                         '" . (int) $_POST['howmany'] . "', 
		                         '" . (int) $emailserver . "', 
		                         '" . (int) $_POST['interval'] . "', 
		                         '" . $_POST['origin'] . "', 
		                         '" . $_POST['originaccesslevel'] . "', 
		                         '" . $_POST['emailstatus'] . "', 
		                         '" . (int) $_POST['sendid'] . "', 
		                         '" . addslashes(trim($_POST['toscreenname'])) . "', 
		                         '" . addslashes(trim($_POST['seed_to'])) . "', 
		                         '" . (int) $_POST['seed_every'] . "', 
		                         NOW())";
		
		if(($emailserver > 0 AND $looking > 0) OR trim($_POST['toscreenname']))
		{
			$query = mysql_query($sql);
		    
			if(mysql_affected_rows() > 0){
				$msg = "MassRequest SUCCESFULLY INSERT";
				echo "<script language='javascript'>window.location = 'index.php?content=gallery_listmass'</script>";
				exit;
			} else {
				$msg = "<font color='red'> ERROR: MassRequest WAS NOT INSERT!! Unknown Error!! <br> " . mysql_error() . "</font>";
			}
		} else {
			$msg = "<font color='red'> ERROR: MassRequest WAS NOT INSERT!! <br> Select 'Looking For' AND 'Email Server'!</font>";
		}
	} else {
		$msg = '';
	}
?>
<form name="addform" method="post" action="index.php?content=gallery_addmass">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
			<td width="100%"><font class="pagetitle">Create MassRequest Gallery Password Campaign </font></td>
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
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="100" type="text" class="tabletext" name="title" id="title" size="35" value="" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Description:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="150" type="text" class="tabletext" name="description" id="description" size="35" value="" /></font></td>
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
					      	echo "<option value='". $s_i ."'>" . $s_i . "</option>";
					      }
					    ?>
					  </select> 
					  - 
					  <select class="tabletext" name="age_to" id="age_to">
					    <?for($s_i = 18; $s_i < 99; $s_i++)
					      {
					      	echo "<option value='". $s_i ."'>" . $s_i . "</option>";
					      }
					        echo "<option value='99' selected>99</option>";
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
					      	echo "<option value='". $s_i ."'>" . $cfg['profile']['sex'][$s_i] . "</option>";
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
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-1" name="joinedfrom" size="27" value="<?=$_POST["joined"] ?>"><a id="f-calendar-trigger-1" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joinedto" size="25" value="<?=$_POST["joineduntil"] ?>"><a id="f-calendar-trigger-2" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td width="25%" align="right"><font class="tabletext">Last login from:</font></td>
						<td width="25%" align="left">&nbsp;<input class="tabletext" id="f-calendar-field-3" name="lastloginfrom" size="27" value="<?=$_POST["login"] ?>"><a id="f-calendar-trigger-3" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="10%" align="right"><font class="tabletext">until:</font></td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="lastloginto" size="25" value="<?=$_POST["loginuntil"] ?>"><a id="f-calendar-trigger-4" href="#"><img alt="" src="images/calendar.png" align="middle" border="0"></a><script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
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
					<option value="A">--All--</option>
					<option value="Y">Yes</option>
					<option value="N">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send external emails:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="sendexternal" >
					<option value="Y">Yes</option>
					<option value="N">No</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send it from:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<? $qry_staffacc=mysql_query("SELECT `id`,`screenname` FROM `tblUsers` WHERE `typeusr` = 'Y' ORDER BY `screenname` ASC");?>
					<select class="tabletext" name="sendid" id="sendfrom">
					<? while($row_staffacc=mysql_fetch_array($qry_staffacc)){?>
					<option value="<?=$row_staffacc['id']?>"><?=$row_staffacc['screenname']?></option>
					<? }?>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">How many requests:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="howmany" id="nr">
					<option value="1">1</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500" selected>500</option>
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
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Email server<font color="red">*</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					    <?for($s_i = 0; $s_i < count($cfg['option']['emailserver']); $s_i++)
					      {
					      	echo "<input type='checkbox' name='emailserver[". $s_i ."]' value='". $s_i ."'>" . $cfg['option']['emailserver'][$s_i] . "&nbsp;&nbsp;&nbsp;";
					      }
					    ?>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Interval between emails(in seconds):</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="interval" id="interval">
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
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Origin:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<? $qry_origin=mysql_query("SELECT DISTINCT `origin` FROM `tblUsers` WHERE `origin` != ''");?>
					<select class="tabletext" name="origin">
					<option value="A">--All--</option>
					<? while($row_staffacc=mysql_fetch_array($qry_origin)){?>
					<option value="<?=$row_staffacc['origin'];?>"><?=ucfirst($row_staffacc['origin']);?></option>
					<? }?>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Origin access level:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="originaccesslevel">
					<option value="A">--All--</option>
					<option value="F">Free</option>
					<option value="P">Paid</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Status:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailstatus">
					<option value="A">--All--</option>
					<option value="G">Good</option>
					<option value="GD">Good+Defered</option>
					<option value="B">Bounced</option>
					<option value="I">Invalid</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Send only a test to this screen name<br /><font style="font-size:10px">(let it be blank if you don't wish to send a test message)</font>:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><input maxlength="15" type="text" class="tabletext" name="toscreenname" id="testscreen" size="100" value="" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Add Seed:</font></td>
					<td width="75%" align="left" class="tabletext">&nbsp;
					  <input type="text" name="seed_to" size="100" value="" class="tabletext" maxlength="250" /> &nbsp; every &nbsp; 
					  <select name="seed_every">
					    <option value="0" >-none-</option>
					    <option value="1">1.000th</option>
					    <option value="2">2.000th</option>
					    <option value="10">10.000th</option>
					    <option value="25">25.000th</option>
					    <option value="50">50.000th</option>
					    <option value="75">75.000th</option>
					    <option value="100">100.000th</option>
					    <option value="150">150.000th</option>
					    <option value="200">200.000th</option>
					    <option value="250">250.000th</option>
					    <option value="300">300.000th</option>
					    <option value="400">400.000th</option>
					    <option value="500">500.000th</option>
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
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="submit" style="color:#333333; width: 200px; height: 35px;" name="insert" value="Insert">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333; width: 200px; height: 35px;" name="reset" value="Reset"></font></td>
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