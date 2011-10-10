<script language="javascript">
function valcheck()
{
   var msg = "";

  if (document.form2.servername.value == "")
     msg += "Enter ServerName \n"
  if (document.form2.domain.value == "")
     msg += "Enter Domain \n"
  
  if (msg != "")
     {
	    alert(msg);
		return false;
	 }
 else
       document.form2.submit();
     
}
</script>
<? 
if($_POST['ispost'] == 1)
	{
		if($_POST['servername'] AND $_POST['domain'] )
		{
			if (isset($_POST['syahoo'])) $ssyahoo=1; else $ssyahoo=0;
		    if (isset($_POST['shotmail'])) $sshotmail=1; else $sshotmail=0;
			if (isset($_POST['saol'])) $ssaol=1; else $ssaol=0;
			if (isset($_POST['sother'])) $ssother=1; else $ssother=0;
			if (isset($_POST['active'])) $active=1; else $active=0;
			
			$sqlsql="INSERT INTO `tblServers` (`servername`,
											   `serverlocation`,
											   `domain`,
											   `domainip`,
											   `from`,
											   `fromname`,
											   `returnpath`,
											   `for`,
											   `helo`,
											   `syahoo`,
											   `shotmail`,
											   `saol`,
											   `sother`,
											   `timeyahoo`,
											   `timehotmail`,
											   `timeaol`,
											   `timeother`,
											   `active`,
											   `obs`)
			VALUES ('".$_POST['servername']."',
					'".$_POST['serverlocation']."',
					'".$_POST['domain']."',
					'".$_POST['domainip']."',
					'".$_POST['from']."',
					'".$_POST['fromname']."',
					'".$_POST['returnpath']."',
					'".$_POST['for']."',
					'".$_POST['helo']."',
					'".$ssyahoo."',
					'".$sshotmail."',
					'".$ssaol."',
					'".$ssother."',
					'".$_POST['timeyahoo']."',
					'".$_POST['timehotmail']."',
					'".$_POST['timeaol']."',
					'".$_POST['timeother']."',
					'".$active."',
					'".$_POST['obs']."')";
			//echo $sqlsql;
			mysql_query($sqlsql);
			$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>Mailing Server Added Succesfully!</span>";
		} else {
			$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>ERROR: Server not added. Check values</span>";
		}
	}
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style7 {color: #FF0000}
-->
</style>

<form name="form2"  method="post">
<input type="hidden" name="ispost" value="1">
<table style="vertical-align:top" align="center" width="59%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Add MAILING SERVER </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table width="100%"  cellpadding="0" cellspacing="0" >
		<tr height="50">
			<td colspan="3" style="text-align:center "><?=$msg?></td>
		</tr>
		<tr>
		  <td ><div align="center"><span class="style6">Server</span></div></td>
		  <td colspan="2"  align="left"><input name="servername" type="text" id="servername" /></td>
		  </tr>
		<tr>
			<td width="40%"  align="center"><div align="center"><font class="tablename style1 style4" style="color: black;">&nbsp;Domain IP </font></div></td>
			<td width="60%" colspan="2"  align="left" ><input name="domainip" type="text" id="domainip" /></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Domain</span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="domain" type="text" id="domain" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">From </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="from" type="text" id="from" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">From Name </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="fromname" type="text" id="fromname" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Return Path </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="returnpath" type="text" id="returnpath" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">HELO</span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="helo" type="text" id="helo" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Used for </span></div></td>
		  <td colspan="2" align="left" ><label>
		    <select name="for" id="for">
		      <option value="0">Internal</option>
		      <option value="1" selected="selected">External</option>
		      </select>
		  </label></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Location</span></div></td>
		  <td colspan="2" align="left" ><select name="serverlocation" id="serverlocation">
            <option value="0">Local</option>
            <option value="1" selected="selected">Remote</option>
          </select></td>
		  </tr>
		<tr>
		  <td colspan="3" ><hr /></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td colspan="2" align="left" ><p class="style6 style7">Available to send for all campaigns
		    <input name="active" type="checkbox" id="active" value="checkbox" checked="checked" />
		  </p>		    </td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td align="left" ><div align="center"><span class="style6">Timing (seconds)</span></div></td>
		  <td align="left" ><div align="center"><span class="style6">Available to send to</span></div></td>
		  </tr>
		<tr>
		  <td rowspan="2" ><div align="center"><span class="style6">Yahoo</span></div></td>
		  <td align="left" >&nbsp;</td>
		  <td rowspan="2" align="left" ><label>
		    <div align="center">
		      <input name="syahoo" type="checkbox" id="syahoo" value="checkbox" checked="checked" />
		        </div>
		  </label></td>
		</tr>
		<tr>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeyahoo" type="text" id="timeyahoo" value="3" />
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Hotmail</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timehotmail" type="text" id="timehotmail" value="3" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="shotmail" type="checkbox" id="shotmail" value="checkbox" checked="checked" />
		    </div></td>
		</tr>
		<tr>
		  <td ><div align="center"><span class="style6">Aol</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeaol" type="text" id="timeaol" value="3" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="saol" type="checkbox" id="saol" value="checkbox" checked="checked" />
		    </div></td>
		</tr>
		<tr>
		  <td ><div align="center"><span class="style6">Others</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeother" type="text" id="timeother" value="2" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="sother" type="checkbox" id="sother" value="checkbox" checked="checked" />
		    </div></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3" ><div align="center"><span class="style6">Change domain after <span style="padding-top:10px">
		    <input name="maxemailsent" type="text" id="maxemailsent" value="1" />
		    </span> email sent trough this domain </span></div></td>
		  </tr>
		<tr>
		  <td ><div align="center"></div></td>
		  <td align="left" >&nbsp;</td>
		  <td align="left" ><div align="center"></div></td>
		</tr>
		<tr>
		  <td ><div align="center"><span class="style6">OBS </span></div></td>
		  <td colspan="2" align="left" ><label>
		    <textarea name="obs" rows="5" id="obs"></textarea>
		  </label></td>
		  </tr>
		<tr height="105px;">
			<td colspan="3"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input style="width: 200px; height: 35px;" type="button" value="Add Mailer Server" onClick="javascript:valcheck();"></td>
		</tr>
		</table>
		</td>
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