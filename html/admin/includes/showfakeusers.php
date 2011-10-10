<?
	if(isset($_GET["action"])){
		if($_GET["action"]=="del"){
			//@$qry="DELETE FROM `tblfakeaccess` WHERE `fake` = '".$_GET["fakeid"]."' AND `operator`='".$_GET['id']."'";
			//@$qry=mysql_query($qry);
			@$db->query("DELETE FROM `tblfakeaccess` WHERE `fake` = '".$_GET["fakeid"]."' AND `operator`='".$_GET['id']."'");
		}
	}
	if(!empty($_POST["action"]) && $_POST["action"]=="add"){
		if($_POST['fieldsAdded']!=""){
			$fakeIDS=explode(",",$_POST['fieldsAdded']);
			if(!empty($fakeIDS)){
				foreach($fakeIDS as $fakeID){
					$db->query("INSERT INTO `tblfakeaccess` (`fake`,`operator`) VALUES ('".$fakeID."','".$_GET['id']."')");
				}
			}
		}
	}
	
	$operator=$db->get_row("SELECT * FROM `tblAdmin` WHERE `chat` = '1' AND `id`=".$_GET['id']);
	$fakeUsersIds=$db->get_results("SELECT `fake` FROM `tblfakeaccess`");
	foreach($fakeUsersIds as $fakeUsersId){
		$usersIds[]=$fakeUsersId['fake'];
	}
	$usersIdsstring="(".implode(", ",$usersIds).")";
	$staffUsers=$db->get_results("SELECT * FROM `tblUsers` WHERE `typeusr`='Y' AND `id` NOT IN ".$usersIdsstring);
	//var_dump($staffUsers);
	$totalFakeUsers=count($db->get_results("SELECT u.*,f.`operator` FROM `tblfakeaccess` AS f JOIN `tblUsers` AS u ON (u.`id`=f.`fake`) WHERE f.`operator`=".$_GET['id']));
	$fakeUsersSql="SELECT u.*,f.`operator` FROM `tblfakeaccess` AS f JOIN `tblUsers` AS u ON (u.`id`=f.`fake`) WHERE f.`operator`=".$_GET['id'];
?>
<form name="form2"  method="post" action="index.php?content=showfakeusers&id=<?php echo $_GET['id'];?>">
<input type="hidden" name="ispost" value="1">
<input type="hidden" name="id" value="" />
<input type="hidden" id="actionType" name="action" value="" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Staff Users for Chat & Approval of Operator <span style="color:green"><?php echo$operator['user']?></span> </font></td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>Select fake User to add:
						
						<select name="fakeUserToAdd" onchange="add_staff_user(this.value);">
							<option value="">-choose-</option>
							<?php if(!empty($staffUsers)){
								foreach($staffUsers as $staffUser){
							?>
							<option value="<?php echo$staffUser['id']."-".$staffUser['screenname']?>"><?php echo$staffUser['screenname']?></option>
							<?php }}?>
						</select>
					</td>
					<td height="100px" width="300px" style="background-color:#f2f2f2">
						<input type="hidden" value="" name="fieldsAdded" class="fieldsAdded">
						<div class="fields_area" id="fields_choosen" style=" height:100px;overflow:auto;">
							<div class="nr_fields"></div>
						</div>
					</td>
					<td>
						 <button onclick="$('#actionType').val('add')">add</button> 
						<!-- <span onclick="document.location.href='index.php?content=showfakeusers&amp;id=<?php echo$_GET['id']?>&amp;action=add'">add</span> -->
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<!-- Page content line -->
					<?
						if(!empty($_POST["ord"])){$ord=$_POST["ord"];} else {$ord="u.`id`";}
						if(!empty($_POST["dir"])){$dir=$_POST["dir"];} else {$dir="desc";}
						if(!empty($_POST["limit"])){$limit=$_POST["limit"];} else {$limit=10;}
						if(!empty($_POST["page"])){$page=$_POST["page"];} else {$page=1;}
						?>
					<input type="hidden" name="ord" value="<?=$ord ?>" /><input type="hidden" name="dir" value="<?=$dir ?>" /><input type="hidden" name="page" value="<?=$page ?>" />
	<tr>
	<td>
	<table style="vertical-align:top; width:700px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="12" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td style="background-color:#EEEEEE; border:1px solid #CCCCCC" colspan="12">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td align="left" width="50%"><font class="tablename">
								<?=number_format($totalFakeUsers,0,'',','); ?> entries found in database</font></td>
			<td align="right" width="50%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			<option class="100" <? if($limit==100) echo "selected='selected'"; ?>>100</option>
			<option class="200" <? if($limit==200) echo "selected='selected'"; ?>>200</option>
			<option class="2000" <? if($limit==2000) echo "selected='selected'"; ?>>2000</option>

			</select></font></td>
		</tr>
		</table>
		</td>
	</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:110px"><font class="tablecateg">Main Image</font></td>
					<td align="center" style="width:200px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="picu.`screenname`" onclick="ordertabels('u.`screenname`')" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Password</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Hide</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">MostWanted</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Operations</font></td>
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
			<?php
				$tdcolor="#f2f2f2";
				$color1="#f2f2f2";
				$color2="#FFFFFF";
				$colorOver="#CCCCCC";
				//$nr=0;
				$fakeUsersSql.=" ORDER BY ".$ord." ".$dir;
				$fakeUsersSql.=$qry." limit ".($page-1)*$limit.",".$limit;
				$fakeUsers=mysql_query($fakeUsersSql);
				//var_dump($fakeUsersSql);
				if($totalFakeUsers>0){
					//foreach($fakeUsers as $fakeUser){
					while($fakeUser=mysql_fetch_array($fakeUsers)){

						if($tdcolor=="#f2f2f2"){
							$tdcolor="#FFFFFF";
						} else {
							$tdcolor="#f2f2f2";
						}
			?>
			<tr height="40" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="center" "><font class="tabletext"><img src="<?=$cfg['path']['url_site'] . "showphoto.php?id=".$fakeUser['id']."&m=Y&t=s&p=1"?>" alt="Users Main Image" border="1" style="width: 30px; height: 30px;"/></font></td>
					<td align="center" "><font class="tabletext"><?php echo$fakeUser['screenname']?></font></td>
					<td align="center"><font class="tabletext"><?php echo$fakeUser['pass']?></font></td>
					<td align="center"><font class="tabletext"><?php if($fakeUser['hide']=='N'){echo"No";}else{echo"Yes";}?></font></td>
					<td align="center"><font class="tabletext"><?php if($fakeUser['mostwanted']=='N'){echo"No";}else{echo"Yes";}?></font></td>
					<td align="center">
						<a href="index.php?content=viewuser&amp;id=<?=$fakeUser["id"] ?>" target="_blank"><img border="0" title="View" alt="View" src="images/button_view.gif" width="16" height="16" /></a>&nbsp;&nbsp;
					  	<a href="index.php?content=viewinbox&amp;id=<?php echo $fakeUser["id"];?>" target="_blank"><img src="images/inbox.jpg" width="16" alt="Inbox" title="Inbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;
					  	<a href="index.php?content=viewoutbox&amp;id=<?php echo $fakeUser["id"] ?>" target="_blank"><img src="images/outbox.jpg" width="16" alt="Outbox" title="Outbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;
					  	<img title="Remove" alt="Remove" border="0" src="images/button_drop.gif" width="16" height="16" onclick="this.style.cursor='hand'; this.style.cursor='pointer'; javascript: if(confirm('Are you sure you want to remove this user from this operator?')){ document.location.href='index.php?content=showfakeusers&amp;id=<?php echo$_GET['id']?>&amp;action=del&amp;fakeid=<?=$fakeUser["id"] ?>' }" /></a> 
					  	<!-- <button style="background-image:url(images/button_drop.gif);background-color:transparent;height:21px;width:20px;" onclick="$('#actionType').val('del')">&nbsp;</button> -->
					</td>
				</tr>
			<?php }}?>
			<tr>
				<td colspan="12" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"><?
						if($page==1){
							echo "<font style='color:#990000'><<&nbsp;&nbsp;<</font>&nbsp;&nbsp;";
						} else {
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(1)' class='tablecateg'><<</a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page-1)."\")' class='tablecateg'><</a>&nbsp;&nbsp;";
						}
						
						for($i=$page-2; $i<=ceil($totalFakeUsers/$limit), $j<=4; $i++)
						{
							if($page==$i)
							{
								echo " <font style='color:#990000'>".$i."</font> ";
							} 
							elseif($i>=1 and $i<=ceil($totalFakeUsers/$limit))
							{ 
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
							
							$j++;
						}
						
						if($page>=ceil($totalFakeUsers/$limit)){
							echo "<font style='color:#990000'>>&nbsp;&nbsp;>></font>&nbsp;&nbsp;";
						} else {
							echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page+1)."\")' class='tablecateg'>></a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".(ceil($totalFakeUsers/$limit))."\")' class='tablecateg'>>></a>";
						}
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?php echo ceil($totalFakeUsers/$limit) ?> && <? echo $totalFakeUsers; ?>!=0){
						pages(<?=ceil($totalFakeUsers/$limit) ?>);}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($totalFakeUsers/$limit) ?>){pages(<?=ceil($totalFakeUsers/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
				</tr>
				</table>			
				</td>
			</tr>
			<tr>
				<td colspan="12" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="12" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					
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
	<tr><td height="20"></td></tr>
	<tr><td align="center"><a href="index.php?content=listuserschatapproval">back to Users for Chat & Approval </a></td></tr>
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
</script>