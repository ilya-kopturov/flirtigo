<?php
if($_POST["ifp_tochange"]!=""){
		@mysql_query("UPDATE `tblUsers` SET `featured` = 'Y' WHERE `featured` = 'N' AND `id`  = '".$_POST['ifp_tochange']."'");
		echo "UPDATE `tblUsers` SET `featured` = 'Y' WHERE `featured` = 'N' AND `id`  = '".$_POST['ifp_tochange']."'";
	if((int) mysql_affected_rows() == 0){
		@mysql_query("UPDATE `tblUsers` SET `featured` = 'N' WHERE `featured` = 'Y' AND `id`  = '".$_POST['ifp_tochange']."'");
		echo "UPDATE `tblUsers` SET `featured` = 'N' WHERE `featured` = 'Y' AND `id`  = '".$_POST['ifp_tochange']."'";
	}
}
	
?>
<script language="JavaScript">
	
</script>
 <form name="form2" action="index.php?content=featuredprofiles" method="post">
<input type="hidden" name="block"        value="" />
<input type="hidden" name="upgrade"      value="" />
<input type="hidden" name="ifp_tochange" value="" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Add/Remove Featured Profiles </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="center" valign="middle" bgcolor="#EEEEEE" style="border:1px solid #CCCCCC">
		
					<table id="filterdiv" bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" cellspacing="4" class="filternameblack">
					<? if($_POST["ord"]!="id" && $_POST["ord"]!=""){ ?>
					<tr style="background-color:#FFFFFF">
						<td colspan="2" align="left" style="font-size:12px; color:#990000; font-weight:normal">Sorting pattern: <?=$_POST["ord"] ?>(<?=$_POST["dir"] ?>);</td>
						<td colspan="2" align="right"><a href="#" onclick="javascript: ordertabels('Id')" style="text-decoration:none"><font class="filternameblack" style="font-size:12px; text-decoration:underline">reset sorting pattern</font></a></td>
					</tr>
					<? } ?>
					<tr>
						<td colspan="4" align="left">Filter on:</td>
					</tr>
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
						
					<input type="hidden" name="ord" value="<?=$ord ?>" />
					<input type="hidden" name="dir" value="<?=$dir ?>" />
					<input type="hidden" name="page" value="<?=$page ?>" />
					<tr>
						<td width="20%" align="left">Screen name:</td>
						<td width="30%" align="left"><input type="text" class="tabletext" name="screenname" value="<?=$_POST["screenname"] ?>" size="27" /></td>
						<td width="5%" align="right">Email:</td>
						<td width="45%" align="left"><input type="text" class="tabletext" name="email" value="<?=$_POST["email"] ?>" size="25" /></td>
					</tr>
					<tr>
						<td width="20%" align="left">Sex:</td>
						<td width="30%" align="left"><select class="tabletext" name="sex">
						<option value="">--Select--</option>
						<option value="0" <? if($_POST["sex"]=="0"){ echo "selected='selected'"; } ?>>Man</option>
						<option value="1" <? if($_POST["sex"]=="1"){ echo "selected='selected'"; } ?>>Woman</option>
						<option value="2" <? if($_POST["sex"]=="2"){ echo "selected='selected'"; } ?>>Couple (man and woman)</option>
				    <!--<option value="3" <? if($_POST["sex"]=="3"){ echo "selected='selected'"; } ?>>Group</option>
						<option value="4" <? if($_POST["sex"]=="4"){ echo "selected='selected'"; } ?>>Lesbian Couple (two women)</option>
						<option value="5" <? if($_POST["sex"]=="5"){ echo "selected='selected'"; } ?>>Gay Coople (who men)</option>-->
						</select></td>
						<td width="5%" align="right">Staff Acc:</td>
						<td width="45%" align="left"><select class="tabletext" name="fake">
						<option value="">--Select--</option>
						<option value="Y" <? if($_POST["fake"]=="Y"){ echo "selected='selected'"; } ?>>Yes</option>
						<option value="N" <? if($_POST["fake"]=="N"){ echo "selected='selected'"; } ?>>No</option>
						</select>
						</td>
					</tr>
					<tr>
						<td width="20%" align="left">Joined on:</td>
						<td width="30%" align="left"><input class="tabletext" id="f-calendar-field-1" name="joined" size="27" value="<?=$_POST["joined"] ?>"><a id="f-calendar-trigger-1" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="5%" align="right">Until:</td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joineduntil" size="25" value="<?=$_POST["joineduntil"] ?>"><a id="f-calendar-trigger-2" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
					<tr>
						<td width="20%" align="left">Last login from:</td>
						<td width="30%" align="left"><input class="tabletext" id="f-calendar-field-3" name="login" size="27" value="<?=$_POST["login"] ?>"><a id="f-calendar-trigger-3" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="5%" align="right">Until:</td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="loginuntil" size="25" value="<?=$_POST["loginuntil"] ?>"><a id="f-calendar-trigger-4" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
					</tr>
					<tr>
					  <td>Featured:</td>
					  <td><select class="tabletext" name="featured">
						<option value="">--Select--</option>
						<option value="Y" <? if($_POST["featured"]=="Y"){ echo "selected='selected'"; } ?>>Yes</option>
						<option value="N" <? if($_POST["featured"]=="N"){ echo "selected='selected'"; } ?>>No</option>
						</select></td>
					  <td>Country</td>
					  <td>
					    <select class="tabletext" name="country">
					      <option value="0">-All-</option>
					     <?php
					     	foreach ($cfg['countries'] as $key => $val){
					     		echo "<option value=\"{$key}\"" . ($_POST['country']==$key?" selected":"") . ">{$val}</option>";
					     	}
					      ?>
					    </select>
					  </td>
					</tr>
			           <tr>
					 <td>Has a main image: </td>
					<td>  <select class="tabletext" name="mainimg">
						<option value="">--Select--</option>
						<option value="Y"  <? if($_POST["mainimg"]=="Y") { echo "selected='selected'"; } ?>>Yes</option>
						<option value="N"  <? if($_POST["mainimg"]=="N") { echo "selected='selected'"; } ?>>No</option>	
					    </select></td>
					</tr>	
						
	

					<tr>
						<td colspan="2" align="left">
						<input type="hidden" name="submitfilter" value="Filter" />
						<input type="submit" name="thesubmit" value="Filter" /> (press filter)</td>
 						<td colspan="2" align="center"><input type="button" onclick="document.getElementById('filterdiv').style.display='none'; document.getElementById('showdiv').style.display='block'" name="Hide" value="Hide Filter" /></td>  
						
					</tr>
					
					</table>	
					
					<input id="showdiv" type="button" onclick="document.getElementById('filterdiv').style.display='block'; document.getElementById('showdiv').style.display='none'" style="display:none" name="Show" value="Show Filter" /></td>
	</tr>
	<? 
		//if((!empty($_POST["submitfilter"]) && $_POST["submitfilter"]=="Filter") || (!empty($_GET["actions"])) && $_GET["actions"]=="list"){
		{
		$qry="select * from tblUsers WHERE `withpicture` = 'Y'";
		if($_POST["screenname"]!="" || $_POST["email"]!="" || $_POST["sex"]!="" || $_POST["fake"]!="" || $_POST["featured"]!="" || $_POST["joined"]!="" || $_POST["joineduntil"]!="" || $_POST["login"]!="" || $_POST["loginuntil"]!="" || $_POST["country"]!="0" || $_POST["mainimg"]!="")
		{
			$_SESSION["screenname"]=$_POST["screenname"];$_SESSION["email"]=$_POST["email"];
			$_SESSION["sex"]=$_POST["sex"];$_SESSION["fake"]=$_POST["fake"];
			$_SESSION["joined"]=$_POST["joined"];$_SESSION["joineduntil"]=$_POST["joineduntil"];
			$_SESSION["login"]=$_POST["login"];$_SESSION["loginuntil"]=$_POST["loginuntil"];
			$qry.=" AND ";
			$filters=array();
			$nr_filters=0;
			if($_POST["screenname"]!=""){
				$nr_filters++;
				array_push($filters,"screenname");
			}
			if($_POST["email"]!=""){
				$nr_filters++;
				array_push($filters,"email");
			}
			if($_POST["sex"]!=""){
				$nr_filters++;
				array_push($filters,"sex");
			}
			if($_POST["fake"]!=""){
				$nr_filters++;
				array_push($filters,"fake");
			}
			if($_POST["joined"]!=""){
				$nr_filters++;
				array_push($filters,"joined");
			}
			if($_POST["joineduntil"]!=""){
				$nr_filters++;
				array_push($filters,"joineduntil");
			}
			if($_POST["login"]!=""){
				$nr_filters++;
				array_push($filters,"login");
			}
			if($_POST["loginuntil"]!=""){
				$nr_filters++;
				array_push($filters,"loginuntil");
			}
			if($_POST["featured"]!=""){
				$nr_filters++;
				array_push($filters,"featured");
			}
			if($_POST["country"]!="0"){
				$nr_filters++;
				array_push($filters,"country");
			}

                        if($_POST["mainimg"]!=""){
                                $nr_filters++;
                                array_push($filters,"mainimg");
                        }


			//echo "<tr><td>fillltre=".count($filters)."</td></tr>";
			for($i=0; $i<count($filters); $i++){
				//echo "<tr><td>filtru $i=".$filters[$i]."</td></tr>";
				if($filters[$i]=="screenname") $qry.=" `screenname` like '%".$_POST["screenname"]."%'";
				if($filters[$i]=="email") $qry.=" `email` like '%".$_POST["email"]."%'";
				if($filters[$i]=="sex") $qry.=" `sex` = '".$_POST["sex"]."'";
				if($filters[$i]=="fake") $qry.=" `typeusr` = '".$_POST["fake"]."'";
				if($filters[$i]=="joined") $qry.=" `joined` >= '".$_POST["joined"]." 00:00:00"."'";
				if($filters[$i]=="joineduntil") $qry.=" `joined` <= '".$_POST["joineduntil"]." 23:59:59"."'";
				if($filters[$i]=="login") $qry.=" `lastlogin` >= '".$_POST["login"]." 00:00:00"."'";
				if($filters[$i]=="loginuntil") $qry.=" `lastlogin` <= '".$_POST["loginuntil"]." 23:59:59"."'";
				if($filters[$i]=="country") $qry.=" `country` = '".$_POST["country"] . "'";
				if($filters[$i]=="featured") $qry.=" `featured` = '".$_POST["featured"]."'";
			        if($filters[$i]=="mainimg") $qry.="(id) in (select distinct user_id from tblPhotos where photo_main='Y')";
				if($i!=count($filters)-1) $qry.=" and";
			}
		}
		$qry.=" order by ".$ord." ".$dir;
		$qry2=$qry." limit ".($page-1)*$limit.",".$limit;
		$conga="SELECT COUNT(*) " . substr($qry, strpos($qry, 'from'));
		$qry_2=mysql_query("SELECT COUNT(*) " . substr($qry, strpos($qry, 'from')));
		$qry=mysql_query($qry2);
		$nr_found=mysql_num_rows($qry);
		$nr_found2=mysql_result($qry_2,0,0);
//		syslog(LOG_INFO, var_export( $conga, true));
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><?=number_format($nr_found2,0,'',','); ?> entries found in database with a main image available</font></td>
			<td align="right" width="50%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit();">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			</select></font></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:1050px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1" width="100%">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:300px"><img id="picScreenName" onclick="ordertabels('ScreenName')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:550px"><img id="picEmail" alt="arrows" onclick="ordertabels('Email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Email</font></td>
					<td align="center" style="width:200px"><font class="tablecateg">Featured Profile</font></td>
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
				for($i=1; $i<=$nr_found; $i++){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				$theaccount=mysql_fetch_array($qry);
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp; <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$theaccount['id'];?>&t=r&f=Y" border="1"> &nbsp;<font class="tabletext"><a href="javascript:window.open('viewprofile.php?id=<?=$theaccount['id']?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600');void(0);"><?=$theaccount["screenname"] ?></a></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["email"] ?></font>&nbsp;</td>
					<!--  <td align="center">&nbsp;<input type="checkbox" name="ifp" value="<?=$theaccount["id"];?>"<? if($theaccount["featured"] == 'Y'){ echo "checked";}?> onClick="$('#ifp_tochange').val('<?=$theaccount["id"];?>');document.form2.submit();">&nbsp; -->
					<td align="center">&nbsp;<input type="checkbox" name="ifp" value="<?=$theaccount["id"];?>"<? if($theaccount["featured"] == 'Y'){ echo "checked";}?> onchange="change_featured_profile(<?php echo $theaccount["id"];?>,(this.checked ? 1 : 0))">&nbsp;
					</td>
			</tr>
			<?
				}
			?>
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="10" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"><?
						if($page==1){
							echo "<font style='color:#990000'><<&nbsp;&nbsp;<</font>&nbsp;&nbsp;";
						} else {
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(1)' class='tablecateg'><<</a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page-1)."\")' class='tablecateg'><</a>&nbsp;&nbsp;";
						}
						
						for($i=$page-2; $i<=ceil($nr_found2/$limit), $j<=4; $i++)
						{
							if($page==$i)
							{
								echo " <font style='color:#990000'>".$i."</font> ";
							} 
							elseif($i>=1 and $i<=ceil($nr_found2/$limit))
							{ 
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
							
							$j++;
						}
						
						if($page>=ceil($nr_found2/$limit)){
							echo "<font style='color:#990000'>>&nbsp;&nbsp;>></font>&nbsp;&nbsp;";
						} else {
							echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page+1)."\")' class='tablecateg'>></a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".(ceil($nr_found2/$limit))."\")' class='tablecateg'>>></a>";
						}
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?php echo ceil($nr_found2/$limit) ?> && <? echo $nr_found2; ?>!=0){
						pages(<?=ceil($nr_found2/$limit) ?>);
						}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
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
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<?
					//create the list of fields that have to ve verified
					$verif="screenname,pass,email,sex,birthmonth,birthday,birthyear,country,city";
					
				?>
								</td>
			</tr>
			</table>		</td>
	</tr>
	<?
		}
	?>
</table>
</form>

<script language="JavaScript">
	
	if(document.getElementById('featured1').style.display == 'none'){
		document.getElementById('featured1').style.display = '';
	}
	if(document.getElementById('featured2').style.display == 'none'){
		document.getElementById('featured2').style.display = '';
	}
	if(document.getElementById('featured3').style.display == 'none'){
		document.getElementById('featured3').style.display = '';
	}
</script>
