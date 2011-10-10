<?
	if(!empty($_POST["action"]) && $_POST["action"]=="add")
	{
		$looking_arr = array();
		$looking_arr = $_POST['looking'];
		
		$looking = 0;
	    foreach ($looking_arr as $param)
	    {
		 	$looking |= (1 << $param);
		}
		
		$sql = "INSERT INTO `tblCampaign` 
		                        (`title`, 
		                         `description`, 
		                         `sex`, 
		                         `looking`, 
		                         `joinedfrom`, 
		                         `joinedto`, 
		                         `lastloginfrom`, 
		                         `lastloginto`, 
		                         `mailreceived`, 
		                         `mailresponded`, 
		                         `mailopened`, 
		                         `payed`, 
		                         `cancelled`, 
		                         `howmany`, 
		                         `interval`, 
		                         `origin`,
		                         `originaccesslevel`,
		                         `emailstatus`,
		                         `subjectextern`, 
		                         `messageextern`, 
		                         `subjectintern`, 
		                         `messageintern`, 
		                         `sendid`, 
		                         `toscreenname`, 
		                         `toseed`, 
		                         `toevery`) 
		                  VALUES 
		                        ('" . addslashes(trim($_POST['title'])) . "', 
		                         '" . addslashes(trim($_POST['description'])) . "', 
		                         '" . (int) $_POST['sex'] . "', 
		                         '" . (int) $looking . "', 
		                         '" . $_POST['joinedfrom'] . "', 
		                         '" . $_POST['joinedto'] . "', 
		                         '" . $_POST['lastloginfrom'] . "', 
		                         '" . $_POST['lastloginto'] . "', 
		                         '" . $_POST['mailreceived'] . "', 
		                         '" . $_POST['mailresponded'] . "', 
		                         '" . $_POST['mailopened'] . "', 
		                         '" . $_POST['payed'] . "', 
		                         '" . $_POST['cancelled'] . "', 
		                         '" . (int) $_POST['howmany'] . "', 
		                         '" . (int) $_POST['interval'] . "', 
		                         '" . $_POST['origin'] . "', 
		                         '" . $_POST['originaccesslevel'] . "', 
		                         '" . $_POST['emailstatus'] . "', 
		                         '" . addslashes(trim($_POST['subjectextern'])) . "', 
		                         '" . addslashes(trim($_POST['messageextern'])) . "', 
		                         '" . addslashes(trim($_POST['subjectintern'])) . "', 
		                         '" . addslashes(trim($_POST['messageintern'])) . "', 
		                         '" . (int) $_POST['sendid'] . "', 
		                         '" . addslashes(trim($_POST['toscreenname'])) . "', 
		                         '" . addslashes(trim($_POST['seed_to'])) . "', 
		                         '" . (int) $_POST['seed_every'] . "')";
		
		if($looking > 0 OR trim($_POST['toscreenname']))
		{
			$query = mysql_query($sql);
		    
			if(mysql_affected_rows() > 0){
				$msg = "Campaign WAS SUCCESFULLY INSERT";
			} else {
				$msg = "<font color='red'> ERROR: Campaign WAS NOT INSERT!! Unknown Error!! <br> " . mysql_error() . "</font>";
			}
		} else {
			$msg = "<font color='red'> ERROR: Campaign WAS NOT INSERT!! <br> Select 'Looking For'!</font>";
		}
	} else {
		$msg = '';
	}
?>
<style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {
	font-size: 10px;
	color: #FF0000;
}
.style3 {font-size: 10px; color: #FF0000; font-family: Arial, Helvetica, sans-serif; }
-->
</style>

<form name="addform" method="post" action="index.php?content=addcampaign">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
			<td width="100%"><font class="pagetitle">Campaign Manager  </font></td>
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
				  <tr bgcolor="#CCCCCC">
                    <td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" align="left"><table border="0" width="100%" cellpadding="0" cellspacing="0">
                        				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr><tr>
                          <td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Profile Name  :</font></td>
                          <td width="75%" align="left">&nbsp;<font class="tabletext">
                            <label>
                            <input name="textfield2" type="text" value="Hotmail Only EV1" />
                            </label>
                          </font></td>
                        </tr>
                    </table></td>
			      </tr>
				</table>				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;<font class="tabletext"> Domains :</font></td>
					<td width="75%" align="top">&nbsp;<font class="tabletext">
					  <textarea name="title" cols="60" rows="4" wrap="off" class="tabletext" id="title">#hotmail only#
dirty-alert.com | 67.87.443.34 | FS
hookalerts.com | 20.34.11.334 | 20.34.11.344 | 20.34.11.345   RO
dirtyalerts.com | 162.55.443.33 | EV1</textarea>
					  <label>					 </label>
					  <input type="submit" name="Submit" value="Re-load Domain Attributes" />
				     <span class="style2"><br />
					 </span>
					 <label></label>
					</font></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Target Mail Domains :</font></td>
					<td width="75%" align="left"><span class="style1">&nbsp;<font class="tabletext">
					  <label>
					<select name="select4" size="4" multiple="multiple">
					  <option>Yahoo</option>
					  <option>Hotmail/MSN</option>
					  <option>AOL</option>
					  <option>Other</option>
				    </select>
					</label>
					<span class="style2">Select one or more </span></font></span></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Rotate Domain Attributes :</font></td>
					<td width="75%" align="left"><span class="style1">&nbsp;<font class="tabletext">
					  <select class="tabletext" name="mailreceived">
					    <option>No</option>
					    <option>In Order</option>
					    <option>Random</option>
				    </select> 
				      <span class="style2">Rotate domains according to Main From Domains import above </span></font></span></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Rotate Domain Interval  :</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <label>
					    <input name="textfield" type="text" value="1000" />
				    </label>
				    <span class="style2 style1">Domains will be rotated in accordance with the above order and Domain Import </span></font></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Rotate IPs within Domain </font></td>
					<td width="75%" align="left"><span class="style1">&nbsp;<font class="tabletext">
					  <select class="tabletext" name="mailopened">
					    <option>Yes</option>
					    <option>No</option>
				    </select> 
					  <span class="style2">If Yes, then domains will be rotated according to the ips in the  Domain import Line </span></font></span></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Watch QMail Log  :</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="cancelled" >
					  <option>Yes</option>
					  <option>No</option>
					</select> 
					  Action: 
					  <select class="tabletext" name="select" >
					    <option>Rotate</option>
					    <option>Stop</option>
                                            </select>
					Sub Action: 
					<select class="tabletext" name="select2" >
					  <option>3 Consecutive Defer/Post/Bounce</option>
					  <option>5 Consecutive Defer/Post/Bounce</option>
					  <option>10 Consecutive Defer/Post/Bounce</option>
					  <option>10 Defer/Post/Bounce Total</option>
					  <option>25 Defer/Post/Bounce Total</option>
					  <option>500 Defer/Post/Bounce Total</option>
                                                            </select>
					</font></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Alert when:</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					<? $qry_staffacc=mysql_query("SELECT `id`,`screenname` FROM `tblUsers` WHERE `typeusr` = 'Y' ORDER BY `screenname` ASC");?>
					<select class="tabletext" name="sendid" id="sendfrom">
					  <option>1</option>
					  <option>2</option>
					  <option>3</option>
					<? while($row_staffacc=mysql_fetch_array($qry_staffacc)){?>
					<? }?>
					</select> 
					Domain(s) from end of file 
					</font></td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="right">&nbsp;&nbsp;<font class="tabletext">Avoid Rogue Yahoo IPs :</font></td>
					<td width="75%" align="left">&nbsp;<font class="tabletext">
					  <select class="tabletext" name="select3">
					    <option>Yes</option>
					    <option>No</option>
                                            </select>
				    <span class="style3">Read from the  config file with rogue yahoo ips to avoid  </span>					</font></td>
				</tr>
				</table>				</td>
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
					$verif="subjectint,messageint";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="color:#333333; width: 200px; height: 35px;" name="insert" value="Save Profile">
					&nbsp;&nbsp;</font></td>
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