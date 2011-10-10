<script language="JavaScript">
function showhide(trid){
	if(document.getElementById(trid).style.display == 'none'){
		document.getElementById(trid).style.display = '';
	}else{
		document.getElementById(trid).style.display = 'none';
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
					
          <tr>
              <td width="100%" height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('users1');showhide('users2');showhide('users3');showhide('users4');showhide('users5');showhide('users6');showhide('users7');showhide('users8');showhide('users9');showhide('users10');showhide('users11');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Users</font></td>
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
            <tr id="users1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=users'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('Users','#FFFFFF'); javascript:changeimg('Userspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('Users','#000000'); javascript:changeimg('Userspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="Userspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="Users" class="subcatmenu">&nbsp;&nbsp;Users</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="users2" style="display: none; padding-top: 5px;">
              <td align="center"><table onclick="document.location.href='index.php?content=adduser'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('adduser','#FFFFFF'); javascript:changeimg('adduserpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('adduser','#000000'); javascript:changeimg('adduserpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="adduserpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="adduser" class="subcatmenu">&nbsp;&nbsp;Add user</font></td>
                  </tr>
              </table></td>
            </tr>
			 <tr id="users3" style="display: none; padding-top: 5px;">
              <td align="center"><table onclick="document.location.href='index.php?content=approveprofile'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approveprofile','#FFFFFF'); javascript:changeimg('approveprofilepic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approveprofile','#000000'); javascript:changeimg('approveprofilepic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="approveprofilepic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="approveprofile" class="subcatmenu">&nbsp;&nbsp;Approve profile</font></td>
                  </tr>
              </table></td>
            </tr> 
			<tr id="users4" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=approvepic'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approvepic','#FFFFFF'); javascript:changeimg('approvepicpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approvepic','#000000'); javascript:changeimg('approvepicpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center"><img id="approvepicpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left"><font id="approvepic" class="subcatmenu">&nbsp;Approve pictures</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="users5" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=approvevideo'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('approvevideo','#FFFFFF'); javascript:changeimg('approvevideovideo','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('approvevideo','#000000'); javascript:changeimg('approvevideovideo','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center"><img id="approvevideovideo" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left"><font id="approvevideo" class="subcatmenu">&nbsp;Approve videos</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="users7" style="display: none; padding-top: 5px;">
              <td align="center"><table onclick="document.location.href='index.php?content=mostemails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('mostemails','#FFFFFF'); javascript:changeimg('mostemailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('mostemails','#000000'); javascript:changeimg('mostemailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="mostemailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="mostemails" class="subcatmenu">&nbsp;&nbsp;Accounts with Most<br>&nbsp;&nbsp;Emails</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="users6" style="display: none; padding-top: 5px;">
              <td align="center"><table onclick="document.location.href='index.php?content=massregistration'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('Upload mass','#FFFFFF'); javascript:changeimg('Upload masspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('Upload mass','#000000'); javascript:changeimg('Upload masspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="Upload masspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="Upload mass" class="subcatmenu">&nbsp;&nbsp;Mass Registration</font></td>
                  </tr>
              </table></td>
            </tr>
            
            <tr id="users9" style="display: none; padding-top: 5px;">
              <td align="center"><table onclick="document.location.href='index.php?content=thisweekprofiles'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('twprofiles','#FFFFFF'); javascript:changeimg('twprofilespic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('twprofiles','#000000'); javascript:changeimg('twprofilespic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="twprofilespic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="twprofiles" class="subcatmenu">&nbsp;&nbsp;Profiles Approved</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="users10" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=thisweekpictures'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('twpictures','#FFFFFF'); javascript:changeimg('twpicturespic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('twpictures','#000000'); javascript:changeimg('twpicturespic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="twpicturespic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="twpictures" class="subcatmenu">&nbsp;&nbsp;Pictures Approved</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="users11" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=thisweekvideos'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('twvideos','#FFFFFF'); javascript:changeimg('twvideospic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('twvideos','#000000'); javascript:changeimg('twvideospic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="twvideospic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="twvideos" class="subcatmenu">&nbsp;&nbsp;Videos Approved</font></td>
                  </tr>
              </table></td>
            </tr>
            
            <tr id="users8" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('featured1');showhide('featured2');showhide('featured3');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Featured Profiles</font></td>
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
			<tr id="featured1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=currentfeatured'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('curentfeatured','#FFFFFF'); javascript:changeimg('curentfeaturedpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('curentfeatured','#000000'); javascript:changeimg('curentfeaturedpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="curentfeaturedpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="curentfeatured" class="subcatmenu">&nbsp;&nbsp;Current Profiles</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="featured2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=featuredprofiles'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('curentmailer','#FFFFFF'); javascript:changeimg('curentmailerpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('curentmailer','#000000'); javascript:changeimg('curentmailerpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="curentmailerpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="curentmailer" class="subcatmenu">&nbsp;&nbsp;Add/Remove Profiles</font></td>
                  </tr>
              </table></td>
            </tr>
            <!-- Sfarsit categorie meniu -->
            
            
            <!-- Inceput subcategorie meniu -->
            <tr id="featured3" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr style="cursor: hand;" onclick="showhide('campaign1');showhide('campaign2');showhide('campaign3');showhide('campaign4');showhide('campaign5');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Campaigns</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
            <tr id="campaign1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=addcampaign'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('createcampaign','#FFFFFF'); javascript:changeimg('createcampaignpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('createcampaign','#000000'); javascript:changeimg('createcampaignpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="createcampaignpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="createcampaign" class="subcatmenu">&nbsp;&nbsp;Create campaign</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="campaign2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=campaign'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('campaignlist','#FFFFFF'); javascript:changeimg('campaignlistpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('campaignlist','#000000'); javascript:changeimg('campaignlistpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="campaignlistpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="campaignlist" class="subcatmenu">&nbsp;&nbsp;Campaigns List</font></td>
                  </tr>
              </table></td>
            </tr>
            
            
           <tr id="campaign3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=campaignquick'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('campaignlistquick','#FFFFFF'); javascript:changeimg('campaignlistquickpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('campaignlistquick','#000000'); javascript:changeimg('campaignlistquickpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="campaignlistquickpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="campaignlistquick" class="subcatmenu">&nbsp;&nbsp;Quick Campaigns List</font></td>
                  </tr>
              </table></td>
            </tr>
                                                                                                                                
            
            
            <tr id="campaign4" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=campaignfields'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('campaignfields','#FFFFFF'); javascript:changeimg('campaignfieldspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('campaignfields','#000000'); javascript:changeimg('campaignfieldspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="campaignfieldspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="campaignfields" class="subcatmenu">&nbsp;&nbsp;Show/Hide Columns</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="campaign5" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr style="cursor: hand;" onclick="showhide('whispers1');showhide('whispers2');showhide('whispers3');showhide('whispers4');showhide('whispers5');showhide('whispers6');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Whispers</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
            <tr id="whispers1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=whispers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('whispers','#FFFFFF'); javascript:changeimg('whisperspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('whispers','#000000'); javascript:changeimg('whisperspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="whisperspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="whispers" class="subcatmenu">&nbsp;&nbsp;Manage whispers</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="whispers2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=autoreply'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('autoreply','#FFFFFF'); javascript:changeimg('autoreplypic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('autoreply','#000000'); javascript:changeimg('autoreplypic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="autoreplypic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="autoreply" class="subcatmenu">&nbsp;&nbsp;Auto-reply</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="whispers3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=mostflirts'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('mostflirts','#FFFFFF'); javascript:changeimg('mostflirtspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('mostflirts','#000000'); javascript:changeimg('mostflirtspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="mostflirtspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="mostflirts" class="subcatmenu">&nbsp;&nbsp;Accounts with Most<br>&nbsp;&nbsp;Whispers</font></td>
                  </tr>
              </table></td>
            </tr>
            
			<tr id="whispers4" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=addmasswhispers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('addmasswhispers','#FFFFFF'); javascript:changeimg('addmasswhisperspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('addmasswhispers','#000000'); javascript:changeimg('addmasswhisperspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="addmasswhisperspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="addmasswhispers" class="subcatmenu">&nbsp;&nbsp;Create MassWhispers<br>&nbsp;&nbsp;Campaign</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="whispers5" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=masswhispers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('masswhispers','#FFFFFF'); javascript:changeimg('masswhisperspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('masswhispers','#000000'); javascript:changeimg('masswhisperspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="masswhisperspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="masswhispers" class="subcatmenu">&nbsp;&nbsp;MassWhispers List</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="whispers6" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            
            <tr style="cursor: hand;" onclick="showhide('gallerypass1');showhide('gallerypass2');showhide('gallerypass3');showhide('gallerypass4');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Media Password</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
            
            <tr id="gallerypass1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=gallery_autoreply'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('gallery_autoreply','#FFFFFF'); javascript:changeimg('gallery_autoreplypic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('gallery_autoreply','#000000'); javascript:changeimg('gallery_autoreplypic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="gallery_autoreplypic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="gallery_autoreply" class="subcatmenu">&nbsp;&nbsp;Request<br>&nbsp;&nbsp;Auto-reply</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="gallerypass2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=gallery_addmass'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('addmassgallerypass','#FFFFFF'); javascript:changeimg('addmassgallerypasspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('addmassgallerypass','#000000'); javascript:changeimg('addmassgallerypasspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="addmassgallerypasspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="addmassgallerypass" class="subcatmenu">&nbsp;&nbsp;Create MassRequest<br>&nbsp;&nbsp;Campaign</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="gallerypass3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=gallery_listmass'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('massgallery','#FFFFFF'); javascript:changeimg('massgallerypic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('massgallery','#000000'); javascript:changeimg('massgallerypic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="massgallerypic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="massgallery" class="subcatmenu">&nbsp;&nbsp;MassRequest List</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="gallerypass4" style="display: none;">
              <td height="5"></td>
            </tr>
            
            
            
            
            
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr style="cursor: hand;" onclick="showhide('chatinterface1');showhide('chatinterface2');showhide('chatinterface3');showhide('chatinterface4');showhide('chatinterface5');showhide('chatinterface6');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Chat Interface</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
            <tr id="chatinterface1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=listuserschatapproval'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('adduserchatadpp','#FFFFFF'); javascript:changeimg('adduserchatadpppic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('adduserchatadpp','#000000'); javascript:changeimg('adduserchatadpppic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="adduserchatadpppic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="adduserchatadpp" class="subcatmenu">&nbsp;&nbsp;Chat Users</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="chatinterface2" style="display:none;">
              <td align="center"><table onclick="document.location.href='index.php?content=purpleautoreply'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('purpleautoreply','#FFFFFF'); javascript:changeimg('purpleautoreplypic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('purpleautoreply','#000000'); javascript:changeimg('purpleautoreplypic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="purpleautoreplyinterfacestats" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="purpleautoreply" class="subcatmenu">&nbsp;&nbsp;Purple autoreply</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="chatinterface3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=interfacestats'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('interfacestats','#FFFFFF'); javascript:changeimg('interfacestatspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('interfacestats','#000000'); javascript:changeimg('interfacestatspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="interfacestatspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="interfacestats" class="subcatmenu">&nbsp;&nbsp;Interface Stats</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="chatinterface4" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=chatmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('ChatMails','#FFFFFF'); javascript:changeimg('ChatMailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('ChatMails','#000000'); javascript:changeimg('ChatMailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="ChatMailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="ChatMails" class="subcatmenu">&nbsp;&nbsp;Email by Staff AccountUser</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="chatinterface5" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=chatallmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('allmails','#FFFFFF'); javascript:changeimg('allmailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('allmails','#000000'); javascript:changeimg('allmailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="allmailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="allmails" class="subcatmenu">&nbsp;&nbsp;All email</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="chatinterface6" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=chaturgentmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('urgenresponse','#FFFFFF'); javascript:changeimg('urgenresponsepic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('urgenresponse','#000000'); javascript:changeimg('urgenresponsepic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="urgenresponsepic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="urgenresponse" class="subcatmenu">&nbsp;&nbsp;Urgent Response</font></td>
                  </tr>
              </table></td>
            </tr>
	<tr id="chatinterface7" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=assignement'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('assignement','#FFFFFF'); javascript:changeimg('assignementpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('assignement','#000000'); javascript:changeimg('assignementpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="assignement" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="assignement" class="subcatmenu">&nbsp;&nbsp;Assignement</font></td>
                  </tr>
              </table></td>
            </tr>

            <!-- Sfarsit categorie meniu -->
			<tr id="chatinterface6" style="display: none;">
              <td width="100%" height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
			<tr style="cursor: hand;" onclick="showhide('mailermachine1');showhide('mailermachine2');showhide('mailermachine3');showhide('mailermachine4');showhide('mailermachine5');showhide('mailermachine6');showhide('mailermachine7');showhide('mailermachine8');showhide('mailermachine9');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Mailer machine</font></td>
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

            <tr id="mailermachine1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=internalmails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('internalemails','#FFFFFF'); javascript:changeimg('internalemailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('internalemails','#000000'); javascript:changeimg('internalemailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="internalemailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="internalemails" class="subcatmenu">&nbsp;&nbsp;Internal emails</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="mailermachine2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=externalemails'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('externalemails','#FFFFFF'); javascript:changeimg('externalemailspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('externalemails','#000000'); javascript:changeimg('externalemailspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="externalemailspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="externalemails" class="subcatmenu">&nbsp;&nbsp;External emails</font></td>
                  </tr>
              </table></td>
            </tr>
	        <tr id="mailermachine3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=addservers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('servers','#FFFFFF'); javascript:changeimg('serverspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('servers','#000000'); javascript:changeimg('serverspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="serverspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="servers" class="subcatmenu">&nbsp;&nbsp;Add mailing server</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="mailermachine4" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=servers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('serverss','#FFFFFF'); javascript:changeimg('serverslist','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('serverss','#000000'); javascript:changeimg('serverslist','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="serverslist" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="serverss" class="subcatmenu">&nbsp;&nbsp;Mailing server list</font></td>
                  </tr>
              </table></td>
            </tr>
	        <tr id="mailermachine5" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=testmailserver'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('testserverss','#FFFFFF'); javascript:changeimg('testserverslist','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('testserverss','#000000'); javascript:changeimg('testserverslist','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="testserverslist" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="testserverss" class="subcatmenu">&nbsp;&nbsp;Test mailing server</font></td>
                  </tr>
              </table></td>
            </tr>
	    <tr>
	     <tr id="mailermachine6" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=mailersettings'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('extrasettings','#FFFFFF'); javascript:changeimg('extrasettingslist','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('extrasettings','#000000'); javascript:changeimg('extrasettingslist','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="extrasettingslist" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="extrasettings" class="subcatmenu">&nbsp;&nbsp;Extra settings</font></td>
                  </tr>
              </table></td>
            </tr>
	    <tr id="mailermachine7" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=mailinglist'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('testserverss','#FFFFFF'); javascript:changeimg('testserverslist','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('mailinglist','#000000'); javascript:changeimg('mailinglist','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="mailinglist" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="mailinglist" class="subcatmenu">&nbsp;&nbsp;Mailing Lists</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="mailermachine8" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>


            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('content2');showhide('content1');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Content</font></td>
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
            <tr id="content2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=membersclub'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('membersclub','#FFFFFF'); javascript:changeimg('membersclubpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('membersclub','#000000'); javascript:changeimg('membersclubpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="membersclubpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="membersclub" class="subcatmenu">&nbsp;&nbsp;Members Club</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="content1" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr> 
            
            <!-- Inceput categorie meniu -->

            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('filters2');showhide('filters1');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Filters</font></td>
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
            <tr id="filters2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=filters'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('filters','#FFFFFF'); javascript:changeimg('filterspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('filters','#000000'); javascript:changeimg('filterspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="filterspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="filters" class="subcatmenu">&nbsp;&nbsp;Banned Words</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="filters1" style="display: none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr> 
            
            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('newsletter3');showhide('newsletter2');showhide('newsletter1');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Newsletter</font></td>
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
            <tr id="newsletter3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=addnewsletter'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('StartNews','#FFFFFF'); javascript:changeimg('StartNewspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('StartNews','#000000'); javascript:changeimg('StartNewspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="StartNewspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="StartNews" class="subcatmenu">&nbsp;&nbsp;Create Newsletter</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="newsletter2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=newsletters'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('newslist','#FFFFFF'); javascript:changeimg('newslistpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('newslist','#000000'); javascript:changeimg('newslistpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="newslistpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="newslist" class="subcatmenu">&nbsp;&nbsp;Newsletters list</font></td>
                  </tr>
              </table></td>
            </tr>
			<tr id="newsletter1" style="display: none;">
              <td height="5"></td>
            </tr>

            <!-- Inceput categorie meniu -->
            <?php #############################################################################?>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr> 

            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('promotion1');showhide('promotion2');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Promotions</font></td>
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
            <tr id="promotion1" style="display:none;">
              <td align="center"><table onclick="document.location.href='index.php?content=promcode'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('promcode','#FFFFFF'); javascript:changeimg('promcodepic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('promcode','#000000'); javascript:changeimg('promcodepic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="promcodepic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="promcode" class="subcatmenu">&nbsp;&nbsp;Promotional Codes</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr id="promotion2" style="display:none;">
              <td height="5"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>



            <tr style="cursor: hand;" onclick="showhide('settings1');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Settings</font></td>
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
            <tr id="settings1" style="display:none;">
              <td align="center"><table onclick="document.location.href='index.php?content=base_settings'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('base_settings','#FFFFFF'); javascript:changeimg('base_settingspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('base_settings','#000000'); javascript:changeimg('base_settingspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="base_settingspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="base_settings" class="subcatmenu">&nbsp;&nbsp;Base settings</font></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="100%" height="1" bgcolor="#FFFFFF"></td>
            </tr>
            
            
			
            <!-- Inceput categorie meniu -->
            <tr style="cursor: hand;" onclick="showhide('statistics1');showhide('statistics2');showhide('statistics3');">
              <td><table cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC">
                  <tr>
                    <td valign="middle" align="center" width="13"><img src="pics/menu/arrow_cat_menu.jpg" width="13" height="10" /></td>
                    <td align="left" width="100%"><font class="catmenu">&nbsp;&nbsp;Statistics</font></td>
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
              <td align="center"><table onclick="document.location.href='index.php'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('newmembers','#FFFFFF'); javascript:changeimg('newmemberspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('newmembers','#000000'); javascript:changeimg('newmemberspic','pics/menu/arrow_subcat_menu_out.jpg')">                  
              </table></td>
            </tr>
            <!-- <tr>
              <td align="center"><table onclick="document.location.href='index.php?content=statsmailer'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('curentmailer','#FFFFFF'); javascript:changeimg('curentmailerpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('curentmailer','#000000'); javascript:changeimg('curentmailerpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="curentmailerpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="curentmailer" class="subcatmenu">&nbsp;&nbsp;Curent Mailer</font></td>
                  </tr>
              </table></td>
            </tr> -->
			 <tr id="statistics1" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=statspayment'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('paymentrecord','#FFFFFF'); javascript:changeimg('paymentrecordpic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('paymentrecord','#000000'); javascript:changeimg('paymentrecordpic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="paymentrecordpic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="paymentrecord" class="subcatmenu">&nbsp;&nbsp;Payment Record</font></td>
                  </tr>
              </table></td>
            </tr>
			 <tr id="statistics2" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=statsmembers'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('statsmembers','#FFFFFF'); javascript:changeimg('statsmemberspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('statsmembers','#000000'); javascript:changeimg('statsmemberspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="statsmemberspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="statsmembers" class="subcatmenu">&nbsp;&nbsp;Members Stats</font></td>
                  </tr>
              </table></td>
            </tr>
			 <tr id="statistics3" style="display: none;">
              <td align="center"><table onclick="document.location.href='index.php?content=statslogins'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('statslogins','#FFFFFF'); javascript:changeimg('statsloginspic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('statslogins','#000000'); javascript:changeimg('statsloginspic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="statsloginspic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="statslogins" class="subcatmenu">&nbsp;&nbsp;Logins Statistics</font></td>
                  </tr>
              </table></td>
            </tr>
            <!--<tr>
              <td align="center"><table onclick="document.location.href='index.php?content=statsupgrade'" cellpadding="0" height="18" cellspacing="0" width="90%" onmouseover="this.style.backgroundColor='#333333'; this.style.cursor='pointer'; javascript:changecolor('statsupgrade','#FFFFFF'); javascript:changeimg('statsupgradespic','pics/menu/arrow_subcat_menu_on.jpg')"  onmouseout="this.style.backgroundColor='#CCCCCC'; javascript:changecolor('statsupgrade','#000000'); javascript:changeimg('statsupgradepic','pics/menu/arrow_subcat_menu_out.jpg')">
                  <tr>
                    <td valign="middle" align="center" width="10"><img id="statsupgradepic" src="pics/menu/arrow_subcat_menu_out.jpg" width="10" height="13" /></td>
                    <td align="left" width="100%"><font id="statsupgrade" class="subcatmenu">&nbsp;&nbsp;Upgrade Stats</font></td>
                  </tr>
              </table></td>
            </tr>-->
            <tr  id="statistics3" style="display: none;">
              <td height="5"></td>
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
							} else {
								include("includes/campaign.php");
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
