<?
	$qry="select * from tblCreateSite where Id='".$_GET["id"]."'";
	$qry=mysql_query($qry);
	$thesite=mysql_fetch_array($qry);
	
	
	if (!empty($thesite["Rules"]))
	{
		$qusersq=str_replace("\'","'",$thesite["Rules"]);
		$qusers=mysql_query($qusersq);
		$nrusers=mysql_num_rows($qusers);
	}
?>
<form name="addform" method="post" action="index.php?content=editsitef&id=<?=$_GET["id"] ?>">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="thequery" value="<?=$where ?>" />
<input type="hidden" name="thelimit" value="<?=$limit ?>" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Create New Site -<font color="#990000"> Step 2 </font></font></td>
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
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="tablename">Please select wich users will be exported and the method that they'll be selected!</font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><?=$nrusers ?> entries found in database</font></td>
			<td align="right" width="50%"></td>
		</tr>
		</table>
		</td>
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
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Export Clients:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?
					$nr=0;
					for($i=0;$i<$nrusers;$i++){
						$theuser=mysql_fetch_array($qusers);
						if($theuser["typeusr"]==0){
							$nr++;
						}
					}
					echo $nr;
					?> found <input checked="checked" type="checkbox" class="tabletext" name="clients" id="clients" value="1" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Export Staff Accountusers:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?
					$nr=0;
					mysql_data_seek($qusers,0);
					for($i=0;$i<$nrusers;$i++){
						$theuser=mysql_fetch_array($qusers);
						if($theuser["typeusr"]==1){
							$nr++;
						}
					}
					echo $nr;
					?> found <input checked="checked" type="checkbox" class="tabletext" name="typeusrs" id="typeusrs" value="1" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td bgcolor="#FFFFE6" width="100%" style="padding:10px"><font class="tabletext" style="font-weight:bold"><font color="#990000">Note!</font> Please select which method you want to use for the creation of the new site:<br /><font color="#990000">&nbsp;&nbsp;&nbsp;&nbsp;- donwload:</font> you will download a zip file containing the required files then u will copy the files in the desired website after unpacking them;<br /><font color="#990000">&nbsp;&nbsp;&nbsp;&nbsp;- on-line:</font> for this you have to complete the ftp data and the files will be copyied automaticaly in the desired site;<br />Any other options will be found in the site after instalation.</font></td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Select method*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"> <input type="radio" class="tabletext" name="method" id="method" value="download" onclick="document.getElementById('download').style.display='block'; document.getElementById('online').style.display='none'" />download<input type="radio" class="tabletext" name="method" id="method" value="online" onclick="document.getElementById('download').style.display='none'; document.getElementById('online').style.display='block'" />on-line</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#FFFFE6'" onmouseout="this.style.backgroundColor='#99CC00'" height="25" bgcolor="#99CC00" width="100%">
				<div id="download" style="display:none">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" colspan="2" align="center"><font class="tabletext"><input type="button" name="Download" value="Download" onclick="checkform()" /></font></td>
				</tr>
				</table>
				</div>	
				<div id="online" style="display:none">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Ftp server*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="ftpserver" id="ftpserver" value="<?=$thesite["Url"] ?>" size="35" /></font></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Folder:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="ftpfolder" id="ftpfolder" value="" size="35" />(leave blanck if root)</font></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">User*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="ftpuser" id="ftpuser" value="" size="35" /></font></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Password*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="password" class="tabletext" name="ftppass" id="ftppass" value="" size="35" /></font></td>
				</tr>
				<tr>
					<td colspan="2" width="100%" align="center">&nbsp;<font class="tabletext"><input type="button" class="tabletext" onclick="checkform()" name="upload" id="upload" value="Upload" size="35" /></font></td>
				</tr>
				</table>
				</div>			
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
		<td height="10">
		<script language="javascript" type="text/javascript">
		function checkform(){
			t=document.addform;
			if(t.method[1].checked){
				if(t.ftpserver.value==""){
					alert("Please fill the Ftp server!");
					return false;
				}
				if(t.ftpuser.value==""){
					alert("Please fill the Ftp user!");
					return false;
				}
				if(t.ftppass.value==""){
					alert("Please fill the Ftp password!");
					return false;
				}
			}
			if(!t.clients.checked && !t.typeusrs.checked){
				if(confirm("CAUTION! You have no user selected for export!\r\n If you wish to continue without exporting any users please press OK!\r\n Otherwise press Cancel and select at least one type of users tu be exported.")){
					t.submit();
				}
			}else{
				t.submit();
			}
		}
		</script>
		</td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>