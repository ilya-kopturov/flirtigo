<?
	
	if($_POST["action"]=="add" && (int)$_GET["id"] >= 0){
		$qry="insert into `tblAutoPurple` (`user_id`,`subject`,`message`) values('".(int)$_GET["id"]."','".addslashes($_POST["subject"])."','".addslashes($_POST["message"])."')";
		$qry=mysql_query($qry);
		$msg="Auto-reply was inserted into the database";
		echo "<script>document.location.href='index.php?content=purpleautoreply&id=".(int)$_GET["id"]."&msg=".$msg."'</script>";
	}
	if($_POST["action"]=="del" && (int)$_GET["id"] >= 0){
		$qry="delete from `tblAutoPurple` where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="Auto-reply was deleted from the database";
		echo "<script>document.location.href='index.php?content=purpleautoreply&id=".(int)$_GET["id"]."&msg=".$msg."'</script>";
	}
	if($_POST["action"]=="update" && (int)$_GET["id"] >= 0){
		$qry="update `tblAutoPurple` set `subject` = '".addslashes($_POST["subject".$_POST["id"]])."', `message` = '".addslashes($_POST["message".$_POST["id"]])."' where `id` = '".(int)$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="Auto-reply updated";
		echo "<script>document.location.href='index.php?content=purpleautoreply&id=".$_GET["id"]."&msg=".$msg."'</script>";
	}
?> 
<script language="JavaScript">
//function changeActivatioPurpleAutoreply(location,id,checkAction){
	//$.post("http://"+location+"/admin/ajax/activate_purple_auto.php",{id: id, checkAction: checkAction});
//}
</script>
<form name="addform" method="post" action="index.php?content=purpleautoreply<?=($_GET["id"]!="")?("&id=".$_GET["id"]):("") ?>">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="id" value="" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td colspan='2' height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td colspan='2' width="100%"><font class="pagetitle">Purple Auto Reply</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td colspan='2' height="10"></td>
	</tr>
	<tr>
		<td colspan='2' align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	
	<tr>
		<td colspan='2' height="10"></td>
	</tr>
	<tr>
		<td colspan='2'><font class="tablename">Select fake users</font></td>
	</tr>
	<tr>
		<td colspan='2' height="4"></td>
	</tr>
	<tr>
		<td colspan='2' valign="top">
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
					<td width="100%" align="center">&nbsp;<font class="tabletext">Select fake user: <select name="typeusr" onchange="document.location.href='index.php?content=purpleautoreply&id='+document.addform.typeusr.value">
					<option value="">--Select fake user--</option>
					<?
					$qry="select * from `tblUsers` where `typeusr` = 'Y' order by `screenname` ASC";
					$qry=mysql_query($qry);
					$nrusers=mysql_num_rows($qry);
					for($i=0;$i<$nrusers;$i++){
						$user=mysql_fetch_array($qry);
						$selected=($_GET["id"]==$user["id"])?("selected='selected'"):("");
						echo "<option value='".$user["id"]."' ".$selected.">".$user["screenname"]."</option>";
					}
					 ?></select></font></td>
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
		<td colspan='2' height="10"></td>
	</tr>
<?php if(isset($_GET['id']) && $_GET['id']>0){
		$qry="select * from `tblAutoPurple` where `user_id` = '". (int) $_GET["id"]."' order by id desc limit 1";
		$qry=mysql_query($qry);
		$nrreply=mysql_num_rows($qry);
		$i=0;
		if($nrreply>0){
		$reply=mysql_fetch_array($qry);
?>
	<tr>
		<td colspan='2'><font class="tablename">Auto-replyes for purple messages</font></td>
	</tr>
	<tr>
		<td colspan='2' height="4"></td>
	</tr>

	<tr>
<!--  		<td>Active: <input type="checkbox" name="active" onchange="changeActivatioPurpleAutoreply('<?php echo $_SERVER['HTTP_HOST'];?>',<?php echo$reply['id']?>,(this.checked ? 1 : 0));" <?php if($reply['active']==1){?>checked="checked"<?php }?>/></td>  -->
		<td colspan='2'>
			<table style="vertical-align:top; width:800px" align="center" cellpadding="0" cellspacing="0" border="0">	
				<tr>
					<td valign="top">
						<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
							</tr>
							<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
								<td align="center" style="width:600px"><font class="tablecateg">Auto-reply </font></td>
								<td align="center" style="width:200px"><font class="tablecateg">Action</font></td>
					
							</tr>
			<?
				$tdcolor="#f2f2f2";		
				for($i=0; $i<$nrreply; $i++){
					
					if($tdcolor=="#f2f2f2"){
						$tdcolor="#FFFFFF";
					} else {
						$tdcolor="#f2f2f2";
					}
			?>
							<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
								<td align="left" valign="top" style="padding-left: 10px;">
									<font class="tabletext">
										<b>Subject:</b> <br /><input type="text" maxlength="35" name="subject<?=$reply["id"] ?>" value="<?=$reply["subject"] ?>" style="width: 350px;" /><br />
										<b>Message:</b><br /><textarea name="message<?=$reply["id"] ?>" style="height: 100px; width: 350px;" ><?=$reply["message"] ?></textarea><br />
									</font>
								</td>
								<td align="center">
									<font class="tabletext">
										<input type="button" name="Delete" value="Delete" onclick="document.addform.action.value='del'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.submit()" />
										<input type="button" name="Update" value="Update" onclick="document.addform.action.value='update'; document.addform.id.value='<?=$reply["id"] ?>'; document.addform.submit()" />
									</font>
								</td>
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
<?php }?>
	<tr>
		<td colspan='2' height="10"></td>
	</tr>
	<? if($i == 0){?>
	<tr>
		<td colspan='2'><font class="tablename">Add auto-reply</font></td>
	</tr>
	<tr>
		<td colspan='2' height="4"></td>
	</tr>
	<tr>
	<td colspan='2'>
	<table style="vertical-align:top; width:800px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td colspan="2" align="center" style="width:800px"><font class="tablecateg"> </font></td>
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" style="background-color:#f2f2f2">
					<td align="right" valign="top"><font class="tabletext">
					<b>Subject:</b> &nbsp;&nbsp;</font></td>
					<td align="left" valign="top" width="65%"><input type="text" maxlength="35" name="subject" value="" style="width: 350px;" />
					</font></td>
					
			</tr>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
					<td align="right" valign="top"><font class="tabletext">
					<b>Message:</b> &nbsp;&nbsp;</font></td>
					<td align="left" valign="top" width="65%"><textarea name="message" style="width: 350px; height: 200px;"></textarea></font></td>
					
			</tr>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<?
					//create the list of fields that have to ve verified
					$verif="subject,message";
					
				?>
				<tr style="padding: 5px 5px 5px 5px;">
					<td width="100%" align="center"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="width: 150px; height: 30px; color:#333333" name="insert" value="Set">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="width: 150px; height: 30px; color:#333333" name="reset" value="Reset"></td>
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
		<td colspan='2' height="10"></td>
	</tr>
	<? }}?>
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
	if(document.getElementById('chatinterface7').style.display == 'none'){
		document.getElementById('chatinterface7').style.display = '';
	}
	if(document.getElementById('chatinterface8').style.display == 'none'){
		document.getElementById('chatinterface8').style.display = '';
	}
	if(document.getElementById('chatinterface9').style.display == 'none'){
		document.getElementById('chatinterface9').style.display = '';
	}
</script>
