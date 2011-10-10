<?
if(isset($_POST['update'])){
	$query = "UPDATE `tblCampaignFields` SET
											 `id` = '" . $_POST['id'] . "', `title` = '" . $_POST['title'] . "', 
											 `description` = '" . $_POST['description'] . "', `createdOn` = '" . $_POST['createdOn'] . "', 
											 `finishedon` = '" . $_POST['finishedon'] . "', 
											 `from` = '" . $_POST['from'] . "', 
											 `testCampaign` = '" . $_POST['testCampaign'] . "', 
											 `routed` = '" . $_POST['routed'] . "', 
											 `subjectintern` = '" . $_POST['subjectintern'] . "', 
											 `subjectextern` = '" . $_POST['subjectextern'] . "', 
											 `joinedfrom` = '" . $_POST['joinedfrom'] . "', 
											 `joinedto` = '" . $_POST['joinedto'] . "', 
											 `ageRange` = '" . $_POST['ageRange'] . "', 
											 `delay` = '" . $_POST['delay'] . "', 
											 `finished` = '" . $_POST['finished'] . "', 
											 `running` = '" . $_POST['running'] . "', `recipients` = '" . $_POST['recipients'] . "', 
											 `sent` = '" . $_POST['sent'] . "', `readed` = '" . $_POST['readed'] . "', 
											 `bounced` = '" . $_POST['bounced'] . "', `defered` = '" . $_POST['defered'] . "', 
											 `login` = '" . $_POST['login'] . "', `upgraded` = '" . $_POST['upgraded'] . "'";
	mysql_query($query);
}

$col_array = mysql_fetch_array(mysql_query("SELECT `id`,`createdOn`,`title`,`description`,`finishedon`,`from`,`testCampaign`,
                                                   `routed`,`subjectintern`,`subjectextern`,`joinedfrom`,`joinedto`, `ageRange`,
                                                   `delay`,`finished`,`running`,`recipients`,`sent`,`readed`,`bounced`,`defered`,`login`,
                                                   `upgraded` FROM `tblCampaignFields`"));
?>
<form name="form2" action="index.php?content=campaignfields" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Campaigns - Show/Hide Columns</font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<tr>
	<td>
	<table style="vertical-align:top; width:290px" align="left" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="8" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
			  <td align="center" style="width:170px"><font class="tablecateg">Column</font></td>
			  <td align="center" style="width:120px"><font class="tablecateg">Show/Hide</font></td>
			</tr>
			<tr>
				<td colspan="2" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<? foreach($col_array as $key => $value){ ?>
			<? if(strlen($key) >= 2 and (int) $key == 0){?>
			<tr bgcolor="#FFFFFF">
			  <td align="center" style="width:170px"><font class="tabletext"><b><?=ucfirst($key);?></b></font></td>
			  <td align="center" style="width:120px"><font class="tabletext"><input type="radio" name="<?=$key?>" value="Y" <?if($value ==  'Y')echo "checked";?> > <b>Y</b> &nbsp; <input type="radio" name="<?=$key?>" value="N" <?if($value ==  'N')echo "checked";?>> <b>N</b></font></td>
			</tr>
			<?}?>
			<?}?>
			<tr height="40" bgcolor="#FFFFFF">
			  <td align="center" style="width:170px"></td>
			  <td align="center" style="width:120px"><input type="submit" name="update" value="  Update  "></td>
			</tr>
			<tr>
				<td colspan="2" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
	
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('campaign1').style.display == 'none'){
		document.getElementById('campaign1').style.display = '';
	}
	if(document.getElementById('campaign2').style.display == 'none'){
		document.getElementById('campaign2').style.display = '';
	}
	if(document.getElementById('campaign3').style.display == 'none'){
		document.getElementById('campaign3').style.display = '';
	}
	if(document.getElementById('campaign4').style.display == 'none'){
		document.getElementById('campaign4').style.display = '';
	}
</script>