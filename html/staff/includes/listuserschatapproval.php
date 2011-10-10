<?
	if(!empty($_POST["action"]) && $_POST["action"]="del"){ 
		$qry="DELETE FROM `tblAdmin` WHERE `id` = '".$_POST["id"]."'";
		$qry=mysql_query($qry);
	}
?>
<form name="form2"  method="post">
<input type="hidden" name="ispost" value="1">
<input type="hidden" name="id" value="" />
<input type="hidden" name="ord" value="<?=$ord ?>" />
<input type="hidden" name="action" value="<? if($_POST["action"]!="") echo ""; ?>" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Users for Chat & Approval </font></td>
	</tr>
	<tr>
		<td width="100%" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=adduserchatadpp"><u>Add new user</u></a></td>
	</tr>
	<!-- Page content line -->
					<?  
						if(!empty($_POST["ord"])){
							$ord=$_POST["ord"];
						} else {
							$ord="id";
						}
						if(!empty($_POST["dir"])){
							$dir=$_POST["dir"];
						} else {
							$dir="Desc";
						}
						if(!empty($_POST["limit"])){
							$limit=$_POST["limit"];
						} else {
							$limit="10";
						}
						if(!empty($_POST["page"])){
							$page=$_POST["page"];
						} else {
							$page="1";
						}
					?>
	<tr>
	<td>
	<table style="vertical-align:top; width:760px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td width="15%" align="center" ><img id="pic`User`" onclick="ordertabels('`user`')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Username</font></td>
					<td width="15%" align="center" ><img id="Pass" alt="arrows" onclick="ordertabels('pass')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Password</font></td>
					<td width="10%" align="center" ><img id="IsForChat" onclick="ordertabels('isforchat')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Chat</font></td>
					<td width="15%" align="center" ><img id="IsForApproval" onclick="ordertabels('isforapproval')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Profiles</font></td>
					<td width="15%" align="center" ><img id="IsForPicture" onclick="ordertabels('isforpicture')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Pictures</font></td>
					<td width="15%" align="center" ><img id="IsForVideo" onclick="ordertabels('isforavideo')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Videos</font></td>
					<td width="15%" align="center" ><font class="tablecateg">Action</font></td>
					<? if($ord!="id"){ ?>
					<script>
						obj=document.getElementById('pic<?=$ord ?>');
						<? if($dir=="Asc"){ ?>
						obj.src='images/sort/sort_ascending2.gif';
						<? } else { ?>
						obj.src='images/sort/sort_descending2.gif';
						<? } ?>
					</script>
					<? } ?>
			</tr>
			
			<?
				$tdcolor="#f2f2f2";


			$qry_usrs=mysql_query("SELECT * FROM `tblAdmin` WHERE `chat` = '1'");
			while($row_user=mysql_fetch_array($qry_usrs)){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
			?>
			<tr height="40" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$row_user["user"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><?=$row_user["pass"] ?></font>&nbsp;</td>
					<td align="center"><font class="tabletext"><? if($row_user["isforchat"] == 1){ echo "Yes";} else{ echo "No";}?></font></td>
					<td align="center"><font class="tabletext"><? if($row_user["isforapproval"] == 1){ echo "Yes";} else{ echo "No";}?></font></td>
					<td align="center"><font class="tabletext"><? if($row_user["isforpicture"] == 1){ echo "Yes";} else{ echo "No";}?></font></td>
					<td align="center"><font class="tabletext"><? if($row_user["isforvideo"] == 1){ echo "Yes";} else{ echo "No";}?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					  <input style="width: 50px; height: 25px;" type="button" name="Edit" value="Edit" onClick="javascript:document.location.href='index.php?content=edituserchatadpp&id=<?=$row_user["id"] ?>'"/>&nbsp;&nbsp;
					  <input style="width: 50px; height: 25px;" type="button" name="delete" value="Delete" onClick="if(confirm('Are you sure you want to delete this user?')){document.form2.action.value='del'; document.form2.id.value='<?=$row_user["id"] ?>'; document.form2.submit()}" />&nbsp;&nbsp;
					</font></td>

			</tr>
			<? }?>

			<tr>
				<td colspan="7" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="7" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					
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
		<td width="100%" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=adduserchatadpp"><u>Add new user</u></a></td>
	</tr>	

</table>
</form>

<script language="JavaScript">
	if(document.getElementById('chatinterface1').style.display == 'none'){
		document.getElementById('chatinterface1').style.display = '';
	}
	if(document.getElementById('chatinterface2').style.display == 'none'){
		document.getElementById('chatinterface2').style.display = '';
	}
	if(document.getElementById('chatinterface3').style.display == 'none'){
		document.getElementById('chatinterface3').style.display = '';
	}
	if(document.getElementById('chatinterface4').style.display == 'none'){
		document.getElementById('chatinterface4').style.display = '';
	}
	if(document.getElementById('chatinterface5').style.display == 'none'){
		document.getElementById('chatinterface5').style.display = '';
	}
	if(document.getElementById('chatinterface6').style.display == 'none'){
		document.getElementById('chatinterface6').style.display = '';
	}
</script>