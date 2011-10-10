<?php 
$operators=$db->get_results("SELECT * FROM `tblAdmin` WHERE `id`=".$_GET['id']);
$operator=$operators[0];
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
	if(!empty($_POST["period"])){
		$period=$_POST["period"];
	} else {
		$period="";
	}
	$profiles = $db->get_results("SELECT tTM.`user_id`, count(tTM.`user_id`) as count,
                                                (SELECT `joined`
                                                 FROM   `tblUsers`
                                                 WHERE  `id` = tTM.`user_id`
                                                 LIMIT 1) as joined,
                                                 (SELECT `redirect`
                                                 FROM   `tblUsers`
                                                 WHERE  `id` = tTM.`user_id`
                                                 LIMIT 1) as redirect
                                         FROM   `tblTypeMails` as tTM, `tblfakeaccess` as tfa
                                         WHERE tTM.`new` = 'Y' AND tTM.`folder` = '1' and tTM.user_id = tfa.fake and tfa.operator=".$_GET['id']."
                                         GROUP BY tTM.`user_id`
                                         ORDER BY joined DESC");
	if(!empty($profiles)){
		foreach($profiles as $keyprofile=>$profile){
			$profileids[]=$profile['user_id'];
		}
		$profileidsString="(".implode(",",$profileids).")";
		$i=0;
		$nr_found2=count($db->get_results("SELECT u.*, r.`fake_id` FROM `tblUsers` AS u INNER JOIN `tblRepliedMailsToFakeUsers` AS r ON (u.`id`=r.`user_id`) WHERE u.`upgraded`>(SELECT DATE((PERIOD_ADD(EXTRACT(YEAR_MONTH FROM CURDATE())".$period.",0)*100)+1)) AND u.`upgraded`<(SELECT LAST_DAY(DATE((PERIOD_ADD(EXTRACT(YEAR_MONTH FROM CURDATE())".$period.",0)*100)+1))) AND r.`fake_id` IN ".$profileidsString." GROUP BY r.`user_id`"));
		$usersUpdateToFakemails=$db->get_results("SELECT u.*, r.`fake_id` FROM `tblUsers` AS u INNER JOIN `tblRepliedMailsToFakeUsers` AS r ON (u.`id`=r.`user_id`) WHERE u.`upgraded`>(SELECT DATE((PERIOD_ADD(EXTRACT(YEAR_MONTH FROM CURDATE())".$period.",0)*100)+1)) AND u.`upgraded`<(SELECT LAST_DAY(DATE((PERIOD_ADD(EXTRACT(YEAR_MONTH FROM CURDATE())".$period.",0)*100)+1))) AND r.`fake_id` IN ".$profileidsString." GROUP BY r.`user_id`"." ORDER BY `".$ord."` ".$dir." limit ".($page-1)*$limit.",".$limit);
		if(!empty($usersUpdateToFakemails)){
			foreach($usersUpdateToFakemails as $userUpdateToFakemails){
				//$fakes[$i]=$userUpdateToFakemails['fake_id'];
				$usersUpdatedByRepling[$i]=$userUpdateToFakemails;
				$i++;
			}
		}
		//var_dump($fakes);
	}
?>
<form name="form2" action="index.php?content=showusersupgraded&id=<?php echo$_GET['id'];?>" method="post">
<input type="hidden" name="ord" value="<?=$ord ?>" /><input type="hidden" name="dir" value="<?=$dir ?>" /><input type="hidden" name="page" value="<?=$page ?>" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<tr>
		<td width="100%"><font class="pagetitle">Users Upgraded from reading a mail from the operator <span style="color:green"><?php echo$operator['user'];?></span> </font></td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="30%"><font class="tablename"><?=number_format($nr_found2,0,'',','); ?> entries found in database</font></td>
			<td align="center" width="40%"><font class="filternameblack">Period:</font>
				<select class="tabletext" name="period" onchange="document.form2.submit()">
					<option value="" <?php if($period=="") echo "selected='selected'";?>>this month</option>
					<option value="-1" <?php if($period==-1) echo "selected='selected'";?>>last month</option>
					<option value="-2" <?php if($period==-2) echo "selected='selected'";?>>two months ago</option>
					<option value="-3" <?php if($period==-3) echo "selected='selected'";?>>three months ago</option>
				</select>
			</td>
			<td align="right" width="30%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit()">
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
	<tr>
		<td valign="top">
			<table style="vertical-align:top; width:95%" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="6" height="3" bgcolor="#990000"></td>
				</tr>
				
				<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:200px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="picscreenname" onclick="ordertabels('screenname')" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:200px"><font class="tablecateg">Password</font></td>
					<td align="center" style="width:300px"><img id="picemail" alt="arrows" onclick="ordertabels('email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Email</font></td>
					<td align="center" style="width:200px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="piclastlogin" onclick="ordertabels('lastlogin')" /><font class="tablecateg">Last login</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Member type</font></td>
					<td align="center" style="width:300px"><font class="tablecateg">Operations</font></td>
					<? if($ord!="Id"){ ?>
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
					$color1="#f2f2f2";
					$color2="#FFFFFF";
					$colorOver="#CCCCCC";
					//$nr=count($usersUpdatedByRepling);
					$nr=0;
					foreach($usersUpdatedByRepling as $userUpdatedByRepling){
				?>
				<tr height="25px" style="background-color:<?php if($nr%2==0){echo$color1;}else{echo$color2;}?>;font-size:14px;" onmouseover="this.style.backgroundColor='<?php echo$colorOver;?>'" onmouseout="this.style.backgroundColor='<?php if($nr%2==0){echo$color1;}else{echo$color2;}?>'">
					<td align="center" "><font class="tabletext"><?php echo$userUpdatedByRepling['screenname']?></font></td>
					<td align="center"><font class="tabletext"><?php echo$userUpdatedByRepling['pass']?></font></td>
					<td align="center"><font class="tabletext"><?php echo$userUpdatedByRepling['email']?></font></td>
					<td align="center"><font class="tabletext"><?php echo$userUpdatedByRepling['lastlogin']?></font></td>
					<td align="center"><font class="tabletext"><? if($userUpdatedByRepling["accesslevel"]==2 and $userUpdatedByRepling["upgraded"] != "0000-00-00 00:00:00"){ echo "Gold"; }elseif($userUpdatedByRepling["accesslevel"]==1 and $userUpdatedByRepling["upgraded"] != "0000-00-00 00:00:00"){echo "Silver";}elseif($userUpdatedByRepling["accesslevel"] == 0){ echo "Free"; }else{ echo "COMP"; } ?></font></td>
					<td align="center">
						<a href="index.php?content=viewuser&amp;id=<?=$userUpdatedByRepling["id"] ?>" target="_blank"><img border="0" title="View" alt="View" src="images/button_view.gif" width="16" height="16" /></a>&nbsp;&nbsp;
					  	<a href="index.php?content=viewinbox&amp;id=<?php echo $userUpdatedByRepling["id"];?>" target="_blank"><img src="images/inbox.jpg" width="16" alt="Inbox" title="Inbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;
					  	<a href="index.php?content=viewoutbox&amp;id=<?php echo $userUpdatedByRepling["id"] ?>" target="_blank"><img src="images/outbox.jpg" width="16" alt="Outbox" title="Outbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;
					  	<a href="index.php?content=viewpayments&amp;id=<?php echo $userUpdatedByRepling["id"] ?>" target="_blank"><img src="images/dollar_button.gif" width="16" alt="View Payments"  height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php $nr++;}?>
				<tr>
					<td colspan="6" height="3" bgcolor="#990000"></td>
				</tr>
				<tr>
					<td colspan="12" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="50%" align="left">&nbsp;&nbsp;
									<font class="tablecateg" style="text-decoration:none"><?
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
									?></font>
								</td>
								<td width="50%" align="right">
									<script language="javascript" type="text/javascript">
										if(document.form2.page.value><?php echo ceil($nr_found2/$limit) ?> && <? echo $nr_found2; ?>!=0){
											pages(<?=ceil($nr_found2/$limit) ?>);}
									</script>
									<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;
								</td>
							</table>			
					</td>
				</tr>
				<tr>
					<td colspan="6" height="3" bgcolor="#990000" width="100%"></td>
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