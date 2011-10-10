<script language="JavaScript">
function showhide(trid){
	if(document.getElementById(trid).style.display == 'none'){
		document.getElementById(trid).style.display = '';
	}else{
		document.getElementById(trid).style.display = 'none';
	}
}
function showhide1(trid){
	if(document.getElementById(trid).style.display == 'none'){
		document.getElementById(trid).style.display = '';
		document.getElementById('div_'+trid).innerText = '-';
	}else{
		document.getElementById(trid).style.display = 'none';
		document.getElementById('div_'+trid).innerText = '+';
	}
}
function showhide2(trid, id, txt){
	if(document.getElementById(trid).style.display == 'none'){
		document.getElementById(trid).style.display = '';
		document.getElementById(txt+id).innerText = 'close';
	}else{
		document.getElementById(trid).style.display = 'none';
		document.getElementById(txt+id).innerText = txt;
	}
}
</script>
<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%">
<tr>
	<td height="100%">
	<!-- Inceput meniu -->
	<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%">
      <tr>
        <td style="background:url(pics/header/shadow_header_grey.jpg)" height="3" width="100%"></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC" height="100%" width="100%"><table cellpadding="0" cellspacing="0" height="100%" width="180" style="border-right:1px; border-color:#999999; border-left:0px; border-top:0px; border-bottom:0px; border-style:solid">
<?php
if ($_SESSION['is4chat'] == 1)
	{

?>
 <?
 if($_SESSION['isforchat']==1){
 ?>
            <tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
			<tr>
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Chat Interface</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
			<tr>
              <td align="center"><table onclick="document.location.href='index.php?content=chatmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('ChatMails','#FFFFFF'); javascript:changeimg('ChatMailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('ChatMails','#000000'); javascript:changeimg('ChatMailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="ChatMailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="ChatMails" class="subcatmenu">&nbsp;&nbsp;Mail (per profile)</font></td>
                  </tr>
              </table></td>
            </tr>
	<?
            $sqlop=mysql_query("select * from tblfakeaccess where operator=".$_SESSION['admin']." and fake=1");
            if(mysql_num_rows($sqlop))
            {?>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=chatallmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('allmails','#FFFFFF'); javascript:changeimg('allmailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('allmails','#000000'); javascript:changeimg('allmailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="allmailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;All Mail</font></td>
                  </tr>
              </table></td>
            </tr>
            <?}?>
            <?
            $sqlop=mysql_query("select * from tblfakeaccess where operator=".$_SESSION['admin']." and fake=3");
            if(mysql_num_rows($sqlop))
            {?>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=assignement'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('assignment','#FFFFFF'); javascript:changeimg('assignmentpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('assignment','#000000'); javascript:changeimg('assignmentpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="assignment" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;Assignment</font></td>
                  </tr>
              </table></td>
            </tr>
<tr>
              <td align="center"><table onclick="document.location.href='index.php?content=interfacestats'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('interfacestats','#FFFFFF'); javascript:changeimg('interfacestatspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('interfacestats','#000000'); javascript:changeimg('interfacestastspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="interfacestats" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;Interface Stats</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=listuserschatapproval'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('listuserschatapproval','#FFFFFF'); javascript:changeimg('listuserschatapprovalpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('listuserschatapproval','#000000'); javascript:changeimg('listuserschatapprovalpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="listuserschatapproval" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;Chat Users</font></td>
                  </tr>
              </table></td>
            </tr>
	    <tr>
	                  <td align="center"><table onclick="document.location.href='index.php?content=last100'" cellpadding="0" height="18" cellspacing="0" width="90%"
	                                    <tr>
	                                                        <td valign="middle" align="center" width="10"><img id="last100" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
	                                                                            <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;Last 100 emails</font></td>
	                                                                                              </tr>
	                                                                                                            </table></td>
	                                                                                                                        </tr>
	                                                                                                                        
            <?}?>
	<tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
<? }?>
<? }?>
            <!-- Sfarsit categorie meniu -->
            <!-- Inceput subcategorie meniu -->

<? #####################################################################?>
<?php
if ($_SESSION['is4chat'] == 1)
	{
?>
 <?
 if($_SESSION['isforapproval']==1){
 ?>
            <tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
			<tr>
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Approve Interface</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>



            <!-- Sfarsit categorie meniu -->
            <!-- Inceput subcategorie meniu -->

			<tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=approveprofile'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approveprofile','#FFFFFF'); javascript:changeimg('approveprofilepic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approveprofile','#000000'); javascript:changeimg('approveprofilepic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="approveprofilepic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="approveprofile" class="subcatmenu">&nbsp;&nbsp;Approve profile</font></td>
                  </tr>
              </table></td>
            </tr>

            <? if($_SESSION['isforpicture']==1){?>
			<tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=approvepic'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approvepic','#FFFFFF'); javascript:changeimg('approvepicpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approvepic','#000000'); javascript:changeimg('approvepicpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="approvepicpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="approvepic" class="subcatmenu">&nbsp;&nbsp;Approve pictures</font></td>
                  </tr>
              </table></td>
            </tr>
            <?}?>

            <? if($_SESSION['isforvideo']==1){?>
			<tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=approvevideo'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approvevideo','#FFFFFF'); javascript:changeimg('approvevideopic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approvevideo','#000000'); javascript:changeimg('approvevideopic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="approvevideopic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="approvevideo" class="subcatmenu">&nbsp;&nbsp;Approve videos</font></td>
                  </tr>
              </table></td>
            </tr>
            <?}?>


			<tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
<? }?>
<? }?>
<? #######################################################################?>

            <tr>
              <td align="center"><table onclick="document.location.href='includes/login_action.php?action=logout'"  onmousemove="this.style.cursor='pointer'" cellpadding="0" cellspacing="0" height="30" width="80%" bgcolor="#333333">
                  <tr>
                    <td align="center" width="100%"><font class="catmenu" style="color:#FFFFFF">Logout</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <!-- Sfarsit categorie meniu -->
            <tr>
              <td height="100%" width="100%"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td style="background:url(pics/footer/shadow_footer_grey.jpg)" height="4" width="100%"></td>
      </tr>
    </table>
	<!-- Sfarsit meniu -->	</td>
	<td height="100%" width="100%">
	<!-- inceput body -->
	<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%">
      <tr valign="top">
        <td style="background:url(pics/header/shadow_header_white.jpg)" height="3" width="100%"></td>
      </tr>
      <tr>
        <td height="100%" width="100%" valign="top"><?
							if(!empty($_GET["content"])){
								include("includes/".$_GET["content"].".php");

							}
						?>        </td>
      </tr>
      <tr valign="bottom">
        <td style="background:url(pics/footer/shadow_footer_white.jpg)" height="4" width="100%"></td>
      </tr>
    </table>
	<!-- Sfarsit body --></td>
</tr>
</table>
