<?
	$sql_countries = mysql_query("SELECT * FROM `tblCountries`");
	while($obj_countries = mysql_fetch_object($sql_countries))
	{
		$country[$obj_countries->id] = $obj_countries->name;
	}
?>

<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Last Week Approved Videos</font></td>
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
		<td><font class="tablename">Videos</font></td>
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
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<?php $qry=mysql_query("SELECT * FROM `tblVideos` WHERE `approved` = 'Y' AND `approveddate` >= '" . date("Y-m-d", mktime(0,0,0,date("m"),date("d")-7,date("Y")))  . "'");
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
					              <td colspan="2">Approved by: <b><?=idtooperator($obj->approvedby);?></b></td>
					            </tr>
					            <tr>
					             <td width="20"></td>
					             <td width="250" align="center" valign="center">
					               <a href="javascript: window.open('../ajax_video_player.php?vid=<?=$obj->id;?>','videowindow','resizable=yes,scrollbars=yes,width=500, height=450'); void(0);"><img src="<?=$cfg['path']['url_site'] . "videothumb.php?id=" . $obj->id;?>" border="1"></a>
					             </td>
					             <td width="230">
					              <a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=$screenname;?></a>, <?=$country[$country_id];?><br>
					              <?=$obj->upload_ip;?>, <?=strtoupper(ip2country($obj->upload_ip));?> <br><br>
					              Name: <br>
					              <input type="text" name="video_name[<?=$i;?>]" value="<?=$obj->video_name;?>"><br>
					              Description: <br>
					              <textarea rows="5" name="video_description[<?=$i;?>]"><?=trim($obj->video_description);?></textarea>
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
				          <div align="center"><b>No video approved last week!</b></div>
				  <?php } ?>
				</td>
			</tr>
			 <tr>
			   <td height="3" bgcolor="#990000" width="100%"></td>
			 </tr>
			 <tr>
			   <td height="30" bgcolor="#FFFFFF" width="100%"></td>
			 </tr>
			</table>
			</td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>

<script language="JavaScript">
	if(document.getElementById('users1').style.display == 'none'){
		document.getElementById('users1').style.display = '';
	}
	if(document.getElementById('users2').style.display == 'none'){
		document.getElementById('users2').style.display = '';
	}
	if(document.getElementById('users3').style.display == 'none'){
		document.getElementById('users3').style.display = '';
	}
	if(document.getElementById('users4').style.display == 'none'){
		document.getElementById('users4').style.display = '';
	}
	if(document.getElementById('users5').style.display == 'none'){
		document.getElementById('users5').style.display = '';
	}
	if(document.getElementById('users6').style.display == 'none'){
		document.getElementById('users6').style.display = '';
	}
	if(document.getElementById('users7').style.display == 'none'){
		document.getElementById('users7').style.display = '';
	}
	if(document.getElementById('users8').style.display == 'none'){
		document.getElementById('users8').style.display = '';
	}
	if(document.getElementById('users9').style.display == 'none'){
		document.getElementById('users9').style.display = '';
	}
	if(document.getElementById('users10').style.display == 'none'){
		document.getElementById('users10').style.display = '';
	}
	if(document.getElementById('users11').style.display == 'none'){
		document.getElementById('users11').style.display = '';
	}
</script>