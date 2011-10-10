<form name="editform" method="post" action="index.php?content=viewuser&id=<?=$_GET["id"] ?>">
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Show User</font></td>
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
<?php
$theuser = mysql_fetch_array(mysql_query("SELECT * FROM `tblUsers` WHERE `id` = '".$_GET["id"]."'"));
	
/**
 * Pictures SQL
 */
$pictures_sql = "SELECT   `id`, `photo_name`, `photo_description`, `gallery` 
                 FROM     `tblPhotos` 
                 WHERE    `user_id` = '" . $_GET['id'] . "' 
                 ORDER BY `id` ASC";
$pics_sql     = mysql_query($pictures_sql);

/**
 * Videos SQL
 */
$videos_sql   = "SELECT   `id`, `video_name`, `video_description`, `gallery` 
                 FROM     `tblVideos` 
                 WHERE    `user_id` = '" . $_GET['id'] . "' 
                 ORDER BY `id` ASC";
$videos_sql    = mysql_query($videos_sql);
?>
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
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="top">
					
						<table border="0" width="100%" cellpadding="1" cellspacing="1">
						  <tr>
						    <?php
						    $pic_i = 0; 
						    while($pics_obj = @mysql_fetch_object($pics_sql)){ ?>
					        <td align="center">
					          <table  <?php if($pics_obj->gallery == 0) echo "bgcolor='#F7B5B5'"; else  echo "bgcolor='#CCCCCC'";?> width="200" style="font-size:13px; font-face:Verdana;" border="0" cellpadding="1" cellspacing="1">
					            <tr>
					             <td width="105" align="center" valign="top">
					               <a href="javascript: window.open('<?php echo $cfg['path']['url_site']?>showphoto.php?photo_id=<?=$pics_obj->id;?>&t=b','picwindow','resizable=yes,scrollbars=yes,width=700, height=700'); void(0);"><img src="<?=$cfg['path']['url_site'] . "showphoto.php?id=" . $_GET['id'] . "&t=s&photo_id=" . $pics_obj->id; ?>" border="1">
					             </td>
					             <td valign="top" width="95">
					              <b><?php echo $pics_obj->photo_name;?></b><br>
					                 <?php echo $pics_obj->photo_description;?>
					             </td>
					            </tr>
					            <!--  <tr>
					              <td colspan="2" align="left">
					                <a href="deletecontent.php?type=pic&user_id=<?=$_GET['id'];?>&content_id=<?php echo $pics_obj->id;?>">Delete</a> | <a href="setgallery.php?type=pic&gallery=<?php echo $pics_obj->gallery;?>&content_id=<?php echo $pics_obj->id;?>"><?php if($pics_obj->gallery == 1) echo "Make Private"; else echo "Make Public"; ?></a>
					              </td>
					            </tr> -->
					          </table>
					          <br>
					        </td>
					        <?php
					        $pic_i++;
					        if($pic_i % 5 == 0 ){
					        	echo "</tr><tr>";
					        } 
						    } ?>
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
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="top">
					
						<table border="0" width="100%" cellpadding="1" cellspacing="1">
						  <tr>
						    <?php
						    $video_i = 0; 
						    while($videos_obj = @mysql_fetch_object($videos_sql)){ ?>
					        <td align="center">
					          <table <?php if($videos_obj->gallery == 0) echo "bgcolor='#F7B5B5'"; else  echo "bgcolor='#CCCCCC'";?> width="200" style="font-size:13px; font-face:Verdana;" border="0" cellpadding="1" cellspacing="1">
					            <tr>
					             <td width="105" align="center" valign="top">
					               <a href="javascript: window.open('video_player.php?vid=<?=$videos_obj->id;?>','videowindow','resizable=yes,scrollbars=yes,width=400, height=350'); void(0);"><img src="<?=$cfg['path']['url_site'] . "videothumb.php?user_id=" . $_GET['id'] . "&id=" . $videos_obj->id; ?>" border="1"></a>
					             </td>
					             <td valign="top" width="95">
					              <b><?php echo $videos_obj->video_name;?></b><br>
					                 <?php echo $videos_obj->video_description;?>
					             </td>
					            </tr>
					            <!-- <tr>
					              <td colspan="2" align="left">
					                <a href="deletecontent.php?type=video&user_id=<?=$_GET['id'];?>&content_id=<?php echo $videos_obj->id;?>">Delete</a> | <a href="setgallery.php?type=video&gallery=<?php echo $videos_obj->gallery;?>&content_id=<?php echo $videos_obj->id;?>"><?php if($videos_obj->gallery == 1) echo "Make Private"; else echo "Make Public"; ?></a>
					              </td>
					            </tr> -->
					          </table>
					          <br>
					        </td>
					        <?php
					        $video_i++;
					        if($video_i % 5 == 0 ){
					        	echo "</tr><tr>";
					        } 
						    } ?>
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
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">
					  <font class="tablecateg">
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="inbox" value="Inbox" onClick="javascript:document.location.href='index.php?content=viewinbox&id=<?=$_GET['id']?>'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="outbox" value="Outbox" onClick="javascript:document.location.href='index.php?content=viewoutbox&id=<?=$_GET['id']?>'">&nbsp;&nbsp;
					    <!--<input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="contact" value="Contact">&nbsp;&nbsp;-->
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="list" value="List" onclick="document.location.href='index.php?content=users'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="modify" value="Modify" onclick="document.location.href='index.php?content=edituser&id=<?=$_GET["id"] ?>'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="delete" value="Delete" onclick="javascript: if(confirm('Are you sure you want to delete this user?')){ document.location.href='index.php?content=users&action=del&actions=list&id=<?=$theuser["Id"] ?>' }">&nbsp;&nbsp;
					  </font>
					</td>
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
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Screen name:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["screenname"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Password:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["pass"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["email"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Acc:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["typeusr"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Last Login:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["lastlogin"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Payments:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["payments"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Account mail:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext" style="color:#990000"><strong>???</strong></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Transaction ID:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext" style="color:#990000"><strong>???</strong></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Account Location:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["typeloc"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["emailnotif"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Whisper Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["whispernotif"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Newsletter Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["newsletternotif"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Hide:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["hide"] == 1){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">First Time:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["firsttime"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Disabled:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["disabled"] == "Y"){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Access Level:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["accesslevel"]==1){ echo "Silver"; }elseif($theuser["accesslevel"]==2){ echo "Gold";}else{echo "Free";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email status:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?if($theuser["emailstatus"]=='G')echo "Good"; elseif($theuser["emailstatus"]=='I')echo "Invalid"; else echo "Bounced"; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$cfg['profile']['sex'][$theuser["sex"]];?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=looking($theuser["looking"]);?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">For:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=forr($theuser["for"]);?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Intro title:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["introtitle"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Intro text:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><?=$theuser["introtext"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Describe looking:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><?=$theuser["describe"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? $thedate=split("-",$theuser["birthdate"]); ?><?=$thedate[1]." / ".$thedate[2]." / ".$thedate[0] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Country:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<?
						list($country) = mysql_fetch_array(mysql_query("SELECT `name` FROM `tblCountries` WHERE `id` = '" . $theuser['country'] . "'"));
						echo $country;
					?>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">State:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<?
						list($state) = mysql_fetch_array(mysql_query("SELECT `name` FROM `tblStates` WHERE `id` = '" . $theuser['state'] . "'"));
						echo $state;
					?>
					</font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">City:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["city"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Zip:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["zip"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Staff Account Mails:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><strong>Sent Staff Account mail: </strong><?
						$qry="SELECT * FROM `tblTypeMails` WHERE `folder` = 1 AND `user_from` = '".$theuser["id"]."'";
						$qry1=mysql_query($qry);
						echo mysql_num_rows($qry1);
						$qry=mysql_fetch_array($qry1);
						mysql_free_result($qry1);
						echo " ".$qry["date_sent"];
					?><br /><strong>&nbsp;Not readed Staff Account mails (max 50): </strong><br /><ul>
					<?
						$qry="SELECT * FROM `tblTypeMails` WHERE `folder` = 1 AND `user_from` = '".$theuser["id"]."' ORDER BY `date_sent` DESC";
						$qry=mysql_query($qry);
						$nr=mysql_num_rows($qry);
						if($nr>0){
							for($i=0;$i<$nr;$i++){
								$themail=mysql_fetch_array($qry);
								echo "<li>";
								echo "<strong>From:</strong> ".id_to_screenname($themail["user_from"])." ** <strong>To:</strong> ".id_to_screenname($themail["user_to"])." ** <a href=\"javascript: window.open('includes/viewmail.php?id=".$themail['id']."','mailwindow','resizable=yes,scrollbars=yes,width=500, height=500'); void(0);\"><font style='color:#990000'>".$themail["subject"]."</font></a>";
								echo "</li>";
							}
							mysql_free_result($qry);
						}else{
							echo "<li>Nothing here</li>";
						}
					?></ul>
					<br /><strong>&nbsp;Responded Staff Account mails (max 50): </strong><br /><ul>
					<?
						$qry="SELECT * FROM `tblTypeMails` WHERE `folder` = 2 AND `user_from` = '".$theuser["id"]."' ORDER BY `date_sent` DESC";
						$qry=mysql_query($qry);
						$nr=mysql_num_rows($qry);
						if($nr>0){
							for($i=0;$i<$nr;$i++){
								$themail=mysql_fetch_array($qry);
								echo "<li>";
								echo "<strong>From:</strong> ".id_to_screenname($themail["user_id"])." ** <strong>To:</strong> ".id_to_screenname($themail["user_from"])." ** <a href=\"javascript: window.open('includes/viewmail.php?id=".$themail['id']."','mailwindow','resizable=yes,scrollbars=yes,width=500, height=500'); void(0);\"><font style='color:#990000'>".$themail["subject"]."</font></a>";
								echo "</li>";
							}
							mysql_free_result($qry);
						}else{
							echo "<li>Nothing here</li>";
						}
					?></ul>
					</font></td>
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
					<td align="center" width="100%">
					  <font class="tablecateg">
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="inbox" value="Inbox" onClick="javascript:document.location.href='index.php?content=viewinbox&id=<?=$_GET['id']?>'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="outbox" value="Outbox" onClick="javascript:document.location.href='index.php?content=viewoutbox&id=<?=$_GET['id']?>'">&nbsp;&nbsp;
					    <!--<input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="contact" value="Contact">&nbsp;&nbsp;-->
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="list" value="List" onclick="document.location.href='index.php?content=users'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="modify" value="Modify" onclick="document.location.href='index.php?content=edituser&id=<?=$_GET["id"] ?>'">&nbsp;&nbsp;
					    <input style="width: 70px; height: 30px;" class="tablecateg" type="button" style="color:#333333" name="delete" value="Delete" onclick="javascript: if(confirm('Are you sure you want to delete this user?')){ document.location.href='index.php?content=users&action=del&actions=list&id=<?=$theuser["Id"] ?>' }">&nbsp;&nbsp;
					  </font>
					</td>
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