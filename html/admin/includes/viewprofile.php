<?php

	if($_POST["actiune"]=="approve")
	{
	mysql_query("UPDATE tblUsers SET Approved=1 WHERE Id='".$_POST["idu"]."'");
	$qry_first_time=mysql_query("SELECT * FROM tblUsers WHERE Id='".$_POST["idu"]."'");
	$row_first_time=mysql_fetch_array($qry_first_time);	
		if ($row_first_time["FirstTime"] == 1){
			mysql_query("UPDATE tblUsers SET FirstTime=0 WHERE Id='".$_POST["idu"]."'");
			}
	}
	
	if($_POST["actiune"]=="disapprove")
	{
	mysql_query("UPDATE tblUsers SET `Approved`=0,`Blocked`=1 WHERE Id='".$_POST["idu"]."'");
	}
?>
<script language="javascript" type="text/javascript">
					var tempx=0; 
					var tempy=0;
					function getmousepoz(e){
						var IE = document.all?true:false;
						if (!IE) document.captureEvents(Event.MOUSEMOVE); 
							if (IE) { 
							tempx = event.clientX + document.body.scrollLeft;
							tempy = event.clientY + document.body.scrollTop;
							
							} else {  
								tempx = e.pageX;
								tempy = e.pageY;
							}
						 tempy-=300;
							tempx-=200;
					}
					document.onmousemove=getmousepoz;
					</script>
<div id="divreply" align="center" style="position:absolute; visibility:hidden">
<?

?>
<table cellpadding="0" cellspacing="0" style="border:1px solid #000000; background-color:#006699">
<tr>
<td style="width:600px; height:340px" valign="middle" align="center">
<iframe style="background-color:#FFFFFF" id="theframe" src="" width="700" height="320" frameborder="0" scrolling="no"></iframe>
</td>
</tr>
<tr>
	<td style="width:700px; height:50px; padding-left:20px" align="left"><input type="button" name="Close" value="Close" onclick="document.getElementById('divreply').style.visibility='hidden'" /></td>
</tr>
</table>
</div>
<div id="divupload" align="center" style="position:absolute; visibility:hidden">
<table cellpadding="0" cellspacing="0" style="border:1px solid #000000; background-color:#FFFFFF">
<tr>
<td style="width:400px; height:200px" valign="top">
<iframe id="framesrc" src="includes/uploadpics.php?id=<?=$_GET["id"] ?>" width="400" height="200" frameborder="0" scrolling="no"></iframe>
</td>
</tr>
<tr>
	<td style="width:400px; height:50px; padding-left:20px" align="left"><input type="button" name="Close" value="Close" onclick="document.getElementById('divupload').style.visibility='hidden'; document.editform.submit()" /></td>
</tr>
</table>
</div>

<form name="editform" id="editform" method="post" action="index.php?content=viewprofile" target="_self">
	<input type="hidden" name="actiune" id="actiune" value="" />
	<input type="hidden" name="IsPost" value="1">
	<input type="hidden" name="idu" 	 id="idu" value="" />


<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Approve Profiles</font></td>
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
	   <?
			   $qry_user="select * from tblUsers where Id='".$_GET["id"]."' AND Approved=0";
				//echo "select * from tblUsers where Id='".$_GET["id"]."' AND Approved=0";
				$qry1=mysql_query($qry_user);
				//$tuser=mysql_fetch_array($qry);
				//$qry="select * from tblAproveProfile where Id_user='".$tuser["ScreenName"]."'";
				//$qry=mysql_query($qry);
				$theuser=mysql_fetch_array($qry1);
		?>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><a href="index.php?content=approveprofile_new"><font class="tablename">Profiles</font></a></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	
	<tr>
		<td height="10"></td>
	</tr>
		
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td valign="top">
		<?
			if($_GET["id"]!=""){
		?>
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
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["ScreenName"];?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Email"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Acc:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["typeusr"]==1){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">First Time:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? if($theuser["FirstTime"]==1){ echo "Yes"; }else{ echo "No";} ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Sex"] ?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Looking:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><strong>Looking Man:</strong>&nbsp;<? if($theuser["LookingMan"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Looking Woman:</strong>&nbsp;<? if($theuser["LookingWoman"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Looking Couple:</strong>&nbsp;<? if($theuser["LookingCouple"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Looking Group:</strong>&nbsp;<? if($theuser["LookingGroup"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Looking Lesbian Couple:</strong>&nbsp;<? if($theuser["LookingLesbian"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Looking Gay Couple:</strong>&nbsp;<? if($theuser["LookingGay"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					 </font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">For:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><strong>Erotic Chat or Email:</strong> <? if($theuser["ForEroticChat"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Discreet Relationship:</strong> <? if($theuser["ForEroticChat"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>1 -on- 1 sex:</strong> <? if($theuser["ForSex"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Group Sex (3 or more):</strong> <? if($theuser["ForGroupSex"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Bandage & Discipline:</strong> <? if($theuser["ForBondage"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Cross-Dressing:</strong> <? if($theuser["ForCross"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Erotic Chat or Email:</strong> <? if($theuser["ForEroticChat"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Miscellaneous Fetishes:</strong> <? if($theuser["ForFetishes"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Exhibition & Voyeurism:</strong> <? if($theuser["ForExhibition"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Sadism & Masochism:</strong> <? if($theuser["ForSadism"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					&nbsp;<strong>Other "Alternative" Activities:</strong> <? if($theuser["ForOther"]=="1"){ echo "Yes"; }else{ echo "No"; } ?><br />
					</font></td>
					
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><? $thedate=split("-",$theuser["BirthDate"]); ?><?=$thedate[1]." / ".$thedate[2]." / ".$thedate[0] ?></font></td>
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
						$cqry="select * from tblCountry where Id='".$theuser["Country"]."'";
						$cqry=mysql_query($cqry);
						$country=mysql_fetch_array($cqry);
						echo $country["Name"];
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
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?
						$cqry="select * from tblState where Id='".$theuser["State"]."'";
						$cqry=mysql_query($cqry);
						$country=mysql_fetch_array($cqry);
						echo $country["Name"];
					?></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">City:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["City"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Location:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["State"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Body type:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["BodyType"] ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Height:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Height"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Weight:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Weight"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Hair color:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["HairColor"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Body hair:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["BodyHair"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Cock/Breast size:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["CockBreast"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Ethnicity:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Ethnicity"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Drinking:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Drinking"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Smoking:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Smoking"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Safe Sex:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["SafeSex"]; ?></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#ffffff'" height="25" bgcolor="#ffffff" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Travel Arrangements:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><?=$theuser["Travel"]; ?></font></td>
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
					<td width="25%" align="center">&nbsp;&nbsp;<font class="tablecateg">
					<input type="button" name="approve" value="Approve" onclick="document.editform.actiune.value='approve';document.editform.idu.value='<?=$_GET["id"] ?>'; document.editform.submit()" />
					<input type="button" name="disapprove" value="Dissaprove" onclick="document.editform.actiune.value='disapprove';document.editform.idu.value='<?=$_GET["id"] ?>'; document.editform.submit()" /></font>
					</td>
				</tr>
				</table>				</td>
			</tr>
			</table>		<? } ?></td>
	</tr>
		
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>