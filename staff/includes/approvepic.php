<?
	if($_POST["action"]=="approve")
	{
		foreach($_POST['approve'] as $key=>$value)
		{
			if($_POST['photo_featured'][$key] == 'Y'){ 
				@mysql_query("UPDATE `tblPhotos` SET `photo_featured` = 'N' WHERE `user_id` = '" . $_POST['user_id'][$key] . "'");
				$featured = 'Y';
			} else {
				$featured = 'N';
			}
			
			@mysql_query("UPDATE `tblPhotos` SET `photo_name` = '".addslashes($_POST['photo_name'][$key])."', 
												 `photo_description` = '".addslashes($_POST['photo_description'][$key])."',
												 `photo_featured` = '".$_POST['photo_featured'][$key]."', 
												 `approvedby` = '" . $_SESSION['admin'] . "', 
												 `approveddate` = NOW(), 
			 									 `approved` = 'Y' 
			 							     WHERE `id` = '".$value."'");
			
		    @mysql_query("UPDATE `tblUsers` SET `withpicture` = 'Y', `featured` = '" . $featured . "' 
		                                    WHERE `id` = '".$_POST['user_id'][$key]."' LIMIT 1");
		}
	}
	if($_POST["action"]=="disapprove")
	{
		foreach($_POST['approve'] as $key=>$value)
		{
			@mysql_query("DELETE FROM `tblPhotos` WHERE `id` = '".$value."'");
			$nr_pic = @mysql_num_rows(mysql_query("SELECT * FROM `tblPhotos` WHERE `approved` = 'Y' AND `id` = '".$value."'"));
			if($nr_pic > 0){
		        @mysql_query("UPDATE `tblUsers` SET `withpicture` = 'Y' WHERE `id` = '".$_POST['user_id'][$key]."'");
		    } else {
		    	@mysql_query("UPDATE `tblUsers` SET `withpicture` = 'N' WHERE `id` = '".$_POST['user_id'][$key]."'");
		    }
		    
			$sFile_ = $cfg['path']['dir_photos'] . $_POST['user_id'][$key] . "_" . $value . "_";
			@unlink($sFile_ . "b.jpg");
			@unlink($sFile_ . "m.jpg");
			@unlink($sFile_ . "s.jpg");
			
			admin_send_mail($db,'Y','pic_disapproved','internal',$_POST['user_id'][$key],'4042687');
		}
	}
	
	$sql_countries = mysql_query("SELECT * FROM `tblCountries`");
	while($obj_countries = mysql_fetch_object($sql_countries))
	{
		$country[$obj_countries->id] = $obj_countries->name;
	}
?>
<script language="javascript" type="text/javascript">
function checkAll()
{
	var cbs = document.forms["approvepicture"].elements;
	if(cbs)
	{
		if(cbs.length)
		{
			for (var i=0; i<cbs.length; i++)
			{   
				if( (cbs[i].type == 'checkbox') && (cbs[i].name != 'selectAll') ){
					cbs[i].checked = document.forms["approvepicture"].elements["selectAll"].checked;
				}
			}
		}
		else 
		{
			cbs.checked = document.forms["approvepicture"].elements["selectAll"].checked;
		}
	}
}
</script>

<form name="approvepicture" method="post" action="index.php?content=approvepic">
<input type="hidden" name="action" value="">
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Approve Pictures</font></td>
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
		<td><font class="tablename">Pictures</font></td>
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
					<td style="font-size: 12px; font-face: Verdana;" width="25%">&nbsp;&nbsp;<input onclick="javascript: checkAll();" type="checkbox" name="selectAll"> Select All Pictures<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<?php $qry=mysql_query("SELECT * FROM `tblPhotos` WHERE `approved` = 'N' LIMIT 50");
				      if(mysql_affected_rows()>0)
				      {
			    ?>
						<table border="0" width="100%" cellpadding="2" cellspacing="2">
						  <tr>
						  <?$pp=1; $i=0;
						    while($obj = mysql_fetch_object($qry))
						    {
						    	list($screenname, $country_id) = mysql_fetch_array(mysql_query("SELECT `screenname`,`country` FROM `tblUsers` WHERE `id` = '".$obj->user_id."' LIMIT 1"));
						  ?>
						    <input type="hidden" name="user_id[<?=$i;?>]" value="<?=$obj->user_id;?>">
					        <td align="center">
					          <table bgcolor="#CCCCCC" width="500" style="font-size:13px; font-face:Verdana;" border="0" cellpadding="1" cellspacing="1">
					            <tr>
					             <td width="20"><input type="checkbox" name="approve[<?=$i;?>]"  value="<?=$obj->id;?>"></td>
					             <td width="250" align="center" valign="center">
					               <img src="<?=$cfg['path']['url_photos'] . $obj->user_id . "_" . $obj->id . "_s.jpg";?>" border="1">
					             </td>
					             <td width="230">
					              <a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=$screenname;?></a>, <?=$country[$country_id];?><br>
					              <?=$obj->upload_ip;?>, <?=strtoupper(ip2country($obj->upload_ip));?> <br><br>
					              Name: <br>
					              <input type="text" name="photo_name[<?=$i;?>]" value="<?=$obj->photo_name;?>"><br>
					              Description: <br>
					              <textarea rows="5" name="photo_description[<?=$i;?>]"><?=trim($obj->photo_description);?></textarea> <br>
					              Featured Image: <input type="radio" name="photo_featured[<?=$i;?>]" value="Y"> Y <input checked type="radio" name="photo_featured[<?=$i;?>]" value="N"> N
					             </td>
					            </tr>
					          </table>
					          <br>
					        </td>
					        <?if($pp%2==0){?></tr><tr><?}?>
				          <?
				            $pp++;$i++;}?>
				          </tr>
				        </table>		
				  <?php } else { ?>
				          <div align="center"><b>All picture are approved for now!</b></div>
				  <?php } ?>
				</td>
			</tr>
			 <tr>
			   <td height="3" bgcolor="#990000" width="100%"></td></tr>
			 <tr>
			 <tr>
			   <td height="30" bgcolor="#FFFFFF" width="100%"></td></tr>
			 <tr>
			 <td height="50" align="center">
			   <input style="width: 200px; height: 35px;" type="submit" name="approve_pictures" value="Approve Pictures" onclick="document.approvepicture.action.value='approve'; document.approvepicture.submit()">&nbsp;&nbsp;
			   <input style="width: 200px; height: 35px;" type="submit" name="disapprove_pictures" value="Disapprove Pictures" onclick="document.approvepicture.action.value='disapprove'; document.approvepicture.submit()">
			   </td>
			 </tr>
			</table>
			</td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>