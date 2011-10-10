<?php
	/* $Id$ */
	
	if($_POST["action"]=="del" && (int)$_GET["id"] >= 0){
		$qry="delete from `tblAutoGalleryReply` where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="Gallery auto-reply was deleted from the database";
	}
	if($_POST["action"]=="update" && (int)$_GET["id"] >= 0){
		if((int) $_POST['id'] > 0){
		$qry="update `tblAutoGalleryReply` set `minutes` = '".(int)$_POST["minutes".$_POST["user_id"]]."' where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		}else{
			@mysql_query("Insert into `tblAutoGalleryReply` (`user_id`, `minutes`) values ('" .(int)$_POST['user_id']. "','" .(int) $_POST["minutes".$_POST["user_id"]]. "')");	
		}
		@mysql_query("Update `tblUsers` SET `gallery_pass` = '" . trim($_POST["password".$_POST["user_id"]]). "' WHERE
		              `id` = '" . (int) $_POST["user_id"] . "' LIMIT 1");
		$msg="Gallery auto-reply updated succesfully!";
	}
?> 
<form name="addform" method="post">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="user_id" value="" />
<table style="vertical-align:top" align="center" width="95%" height="20" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Manage Gallery Password Reply</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$msg ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td width="1000px" align="center"><font class="tablename">Auto-replyes for gallery password request</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:1000px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:750px"><font class="tablecateg">Auto-reply</font></td>
					<td align="center" style="width:250px"><font class="tablecateg">Action</font></td>
					
			</tr>
			<?
				$tdcolor = "#f2f2f2";
				$sql = "select t1.id as user_id, t2.id, t1.gallery_pass, t2.minutes from `tblUsers` t1
				      left join `tblAutoGalleryReply` t2 ON t1.id = t2.user_id  
				      where t1.`typeusr` = 'Y' 
				      order by t1.`screenname` ASC";
				$result = mysql_query($sql);
				$nrreply=mysql_num_rows($result);
				for($i=0; $i<$nrreply; $i++){
					$reply=mysql_fetch_array($result);
					if($tdcolor=="#f2f2f2"){
						$tdcolor="#FFFFFF";
					} else {
						$tdcolor="#f2f2f2";
					}
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left" valign="top" style="padding-left: 10px;">
					  <table cellpadding="2" cellspacing="2" border="0" class="tabletext">
					    <td width="200"><a name="<?=id_to_screenname($reply["user_id"]);?>"></a>Screenname: <b><?=id_to_screenname($reply["user_id"]);?></b></td>
					    <td width="200">Password: &nbsp; <input type="text" maxlength="10" name="password<?=$reply["user_id"] ?>" value="<?=$reply["gallery_pass"];?>" style="width: 100px;" /></td>
					    <td  width="200" <?if($reply['minutes'] == ""){ echo "style=\"color:red;\"";}?>><b>Reply after:</b>&nbsp;<input type="text" name="minutes<?=$reply["user_id"] ?>" value="<?=$reply['minutes']?>"  style="width: 50px;" /> min(s)</td>
					  </table>
					</td>
					<td align="center"><font class="tabletext"><input type="button" name="Delete" value="Delete" onclick="document.addform.action.value='del'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.submit()" /><input type="button" name="Update" value="Update" onclick="document.addform.action.value='update'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.user_id.value='<?=$reply["user_id"] ?>'; document.addform.submit()" /></font></td>
			</tr>
			
			<?
				}
			?>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="right"></td>
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
</table>
</form>
<?php
/*
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
*/
?>