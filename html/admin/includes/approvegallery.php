<script language="javascript" type="text/javascript">
function doCheckAll(ObjName)
{
  with (document.editform) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == ObjName)
           elements[i].checked = true;
    }
  }
}


function doUnCheckAll(ObjName)
{
  with (document.editform) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == ObjName)
           elements[i].checked = false;
    }
  }
}
</script>
<?
function get_user_gallery_photos($id_user, $gal)
				{
					if ($gal == 0)
						$sql = "SELECT `Pic3`, `Pic4`, `Pic5`, `Pic3Name`, `Pic4Name`, `Pic5Name` FROM `tblUsers` WHERE `Id`=".$id_user;
					else
						$sql = "SELECT `Pic6`, `Pic7`, `Pic8`, `Pic6Name`, `Pic7Name`, `Pic8Name` FROM `tblUsers` WHERE `Id`=".$id_user;
						
					$query = mysql_query($sql) or die(mysql_error());
					$result = mysql_fetch_array($query);
					
					$temp = array();
					
					if ($gal == 0)
					{
						if (!empty($result["Pic3"])) array_push($temp, array("name" => $result["Pic3"], "caption" => $result["Pic3Name"]));
						if (!empty($result["Pic4"])) array_push($temp, array("name" => $result["Pic4"], "caption" => $result["Pic4Name"]));
						if (!empty($result["Pic5"])) array_push($temp, array("name" => $result["Pic5"], "caption" => $result["Pic5Name"]));
					}
					else
					{
						if (!empty($result["Pic6"])) array_push($temp, array("name" => $result["Pic6"], "caption" => $result["Pic6Name"]));
						if (!empty($result["Pic7"])) array_push($temp, array("name" => $result["Pic7"], "caption" => $result["Pic7Name"]));
						if (!empty($result["Pic8"])) array_push($temp, array("name" => $result["Pic8"], "caption" => $result["Pic8Name"]));					
					}			
					
					return $temp;							
				}

	function update_gallery_status($user, $nr, $status)
	{	
		$sql = "SELECT `GalleryStat` FROM `tblUsers` WHERE `Id`=".$user;
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_array($query);	
		
		if (strpos($result["GalleryStat"], "|"))
		{
			$temp = explode("|", $result["GalleryStat"]);			
			$temp[$nr] = $status;
			$temp = implode("|", $temp);
			
			$sql = "UPDATE `tblUsers` SET `GalleryStat`='".$temp."' WHERE `Id`=".$user;
			$query = mysql_query($sql) or die(mysql_error());
		}
		else
		{
			$sql = "UPDATE `tblUsers` SET `GalleryStat`='".$status."' WHERE `Id`=".$user;
			$query = mysql_query($sql) or die(mysql_error());
		}
	}


	if($_POST["actiune"]=="approve")
		{
			foreach($_POST['approve'] as $key=>$value)
				{
					$br=explode('_',$value);
					update_gallery_status($br[0], $br[1], 1);
				}
		}
	
	if($_POST["actiune"]=="disapprove")
		{
			foreach($_POST['approve'] as $key=>$value){
			$br=explode('_',$value);
			update_gallery_status($br[0], $br[1],	 -1);
			}
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
<form name="editform" method="post" action="index.php?content=approvegallery_new" target="_self">
<input type="hidden" name="actiune" value="" />
<input type="hidden" name="idusr" value="" />
<input type="hidden" name="idgal" value="" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Approve Gallery </font></td>
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
		<td><font class="tablename">Galleries</font></td>
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
				<td>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="18%" style="padding-bottom:10px "><strong>Username</strong></td>
							<td width="66%" style="padding-bottom:10px;padding-left:5px;text-align:center "><strong>Galleries</strong></td>
							<td width="16%" style="padding-bottom:10px;text-align:center "><strong>Action</strong></td>
						</tr>
						<? 
						$qry_user="select * from tblUsers WHERE (GalleryStat LIKE '%0%')";
						//echo "select * from tblUsers where GalleryStat='0|1' OR GalleryStat='0|0' OR GalleryStat='1|0'";
						$qry1=mysql_query($qry_user);
						while($theuser=mysql_fetch_array($qry1)){
						
						?>
						<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'">
							<td style="padding-bottom:5px; padding-left:10px " valign="middle"><?=$theuser["ScreenName"];?></td>
							<td style="padding-bottom:5px ">
								<table width="100%" cellpadding="0" cellspacing="0">
							<? if (strpos($theuser['GalleryStat'], "|"))
							{
								$temp_g = explode("|", $theuser['Gallery']);
								$temp_s = explode("|", $theuser['GalleryStat']);								
								
								if ($temp_s[0] == 0)
									{?>
									<tr><td width="11%">
									<? $gal_photos1 = get_user_gallery_photos($theuser['Id'], 0);
									echo '<input type="checkbox" name="approve[]"  value="'.$theuser["Id"].'_0">'.$temp_g[0];?>
									</td>
									
									<td width="89%" style=" padding-top:10px; ">
									<?php
										for ($i=0; $i < sizeof($gal_photos1); $i++)
										{?>
									<table width="30%" height="200"  cellpadding="0" cellspacing="0" align="left">
									<tr><td align="center" valign="middle">
									<a href="picture.php?id=<?php echo $gal_photos1[$i]['name']; ?>" target="_blank"><img src="../pictures/galleries/<?php echo $gal_photos1[$i]['name']; ?>"  alt="<?php echo $gal_photos1[$i]['caption']; ?>" border="0" title="<?php echo $gal_photos1[$i]['caption']; ?>" align="left" /></a>&nbsp;&nbsp;&nbsp;
									</td></tr>
									</table>
									<? }?>
									</td></tr>
									<? }?>
								<? if ($temp_s[1] == 0){ ?>
									<tr><td>
									<? $gal_photos2 = get_user_gallery_photos($theuser['Id'], 1);
									echo '<input type="checkbox" name="approve[]"  value="'.$theuser["Id"].'_1">'.$temp_g[1];?>
									</td>
									<td style=" padding-top:10px; ">
									<?php
										for ($i=0; $i < sizeof($gal_photos2); $i++)
										{?>
									<table width="30%" height="200" cellpadding="0" cellspacing="0" align="left">
									<tr><td align="center" valign="middle">
									<a href="picture.php?id=<?php echo $gal_photos2[$i]['name']; ?>" target="_blank"><img src="../pictures/galleries/<?php echo $gal_photos2[$i]['name']; ?>" alt="<?php echo $gal_photos2[$i]['caption']; ?>" title="<?php echo $gal_photos2[$i]['caption']; ?>" align="left" /></a>&nbsp;&nbsp;&nbsp;
									</td></tr>
									</table>
									<? }?>
									</td></tr>
									<? }																																					
							}
							else
							{
								if ($theuser['GalleryStat'] == 0)
									{
									//$gal_photos = get_user_gallery_photos($theuser['Id'], 0);
									echo '<input type="checkbox" name="approve[]"  value="'.$theuser["Id"].'_0;">'.$theuser['Gallery'];
									}																																					
							}
							//$gal_photos = get_user_gallery_photos($theuser['Id'], $_GET["idgal"]);
							?>
							</table>
							</td>
							
							<td style="padding-bottom:5px;text-align:center " valign="middle"><a href="index.php?content=viewprofile&id=<?=$theuser["Id"];?>"><font color="#000000">view</font></a></td>
						</tr>
						<? }?>
						<tr>
							<td colspan="7" style="text-align:center; padding-top:10px ">
							<input type="button" class="btext" onClick="javascript:doCheckAll('approve[]')" value="Check All">
							<input type="button" class="blacktext" onClick="javascript:doUnCheckAll('approve[]');" value="UnCheck All">
							<br><br>
							<input type="button" name="approve" value="Approve" onclick="document.editform.actiune.value='approve'; document.editform.submit()" />
							<input type="button" name="disapprove" value="Dissaprove" onclick="document.editform.actiune.value='disapprove'; document.editform.submit()" />
							</td>
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
		<td height="10"></td>
	</tr>
	<tr>
		<td valign="top">
		<? 
			if($_GET["idusr"]!="")
			{ 
				$gal_photos = get_user_gallery_photos($_GET["idusr"], $_GET["idgal"]);			
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
						
						<?php
							for ($i=0; $i < sizeof($gal_photos); $i++)
							{
						?>						
							<td align="center" valign="middle">
								<table cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td align="center" valiign="middle">
											<img src="../pictures/galleries/<?php echo $gal_photos[$i]['name']; ?>" alt="<?php echo $gal_photos[$i]['caption']; ?>" title="<?php echo $gal_photos[$i]['caption']; ?>" />											
										</td>
									</tr>
									<tr><td style="height:10px" />
									<tr>
										<td align="center" valign="middle">
											<?php echo $gal_photos[$i]['caption']; ?>
										</td>									
									</tr>								
								</table>
							</td>
							<td style="width:10px" />														
							<?php
								}
							?>
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
						<input type="button" name="approve" value="Approve" onclick="document.editform.actiune.value='approve'; document.editform.idusr.value='<?=$_GET["idusr"] ?>'; document.editform.idgal.value='<?=$_GET["idgal"] ?>'; document.editform.submit()" /><input type="button" name="disapprove" value="Dissaprove" onclick="document.editform.actiune.value='disapprove'; document.editform.idusr.value='<?=$_GET["idusr"] ?>'; document.editform.idgal.value='<?=$_GET["idpic"] ?>'; document.editform.submit()" /></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>	<? } ?>	</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>