<?
function showtransactionid($userid, $email, $type, $accesslevel){
	
	if((int) $accesslevel == 0) return "-";
	
	if($type == 'Y' and (int) $accesslevel > 0) return "n/a";
	
	
	$netbilling   = @mysql_fetch_array(mysql_query("SELECT `transid` FROM `tblPaymentsNB` WHERE `userid` = '" . $userid . "' AND 
	                                                                                   `status` like '%APPROVED%' 
	                                                                             ORDER BY `id` DESC 
	                                                                             LIMIT 1"));
	if($netbilling['transid'] > 0) return "nb - ".$netbilling['transid'];
	
	
	$segpay   = @mysql_fetch_array(mysql_query("SELECT `purchaseid` FROM `segpay` WHERE `memberID` = '" . $userid . "' AND  
	                                                                                   `approved` = 'yes' 
	                                                                             ORDER BY `id` DESC 
	                                                                             LIMIT 1"));
	if($segpay['purchaseid'] > 0) return "segpay - ".$segpay['purchaseid'];
	
	$vero   = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `tblPayments` WHERE `userid` = '" . $userid . "' AND 
	                                                                                   `status` like '%APPROVED' 
	                                                                             ORDER BY `id` DESC 
	                                                                             LIMIT 1"));
	if((int) $vero['userid'] > 0) return "vero - ".$email;
	
	$ccbill = @mysql_fetch_array(mysql_query("SELECT `subscription_id` FROM `ccbill_post` 
	                                                                             WHERE `email` = '" . $email . "' LIMIT 1"));
	if((int) $ccbill['subscription_id'] > 0) return "ccbill - ".$ccbill['subscription_id'];
	
	
	$p2000   = @mysql_fetch_array(mysql_query("SELECT `trans_num` FROM `tblPayments2000` WHERE `userid` = '" . $userid . "' AND 
	                                                                                   `status` = 'add' 
	                                                                             ORDER BY `id` DESC 
	                                                                             LIMIT 1"));
	if($p2000['trans_num'] > 0) return "2000 - ".$p2000['trans_num'];
	
	
	return " - ";
}

	if(!isset($_POST['joined'])){ 
		$_POST['joined'] = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),1996) );
	}
	if(!isset($_POST['joineduntil'])){ 
		$_POST['joineduntil'] = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")) );
	}
	
	
	if(!empty($_GET["action"]) && $_GET["action"]="del"){
		@mysql_query("delete from `tblUsers` where `id` = '".$_GET["id"]."'");
		if(mysql_affected_rows() > 0)
		{
			$msg="The account with id = '".$_GET["id"]."' was deleted!";
		} else {
			$msg="Unknown ERROR. The account with id = '".$_GET["id"]."' was NOT deleted!";
		}
		@mysql_query("delete from `tblMails` WHERE `user_id` = '" . $_GET["id"] . "'");
		@mysql_query("delete from `tblHotBlockList` WHERE `user_id` = '" . $_GET["id"] . "'");
		@mysql_query("delete from `tblRate` WHERE `user_id` = '" . $_GET["id"] . "'");
	}
	if(!empty($_POST["block"])){
		$query="select `disabled` from `tblUsers` where `id`='".$_POST["block"]."'";
		$query=mysql_query($query);
		$query=mysql_fetch_array($query);
		mysql_free_result($query);
		if($query["disabled"]=='N'){$block='Y';}else{$block='N';}
		
		$qu=mysql_query("update `tblUsers` set `disabled`='".$block."' where `id`='".$_POST["block"]."'");
	}
	if(!empty($_POST["upgrade"])){
		$qry=mysql_query("update `tblUsers` set `accesslevel`='".$_POST["accesslevel".$_POST["upgrade"]]."',`upgraded`=now() where `id`='".$_POST["upgrade"]."'");
	}
	if(!empty($_POST["mw"])){
		$qry=mysql_query("update `tblUsers` set `mostwanted` = '".$_POST["mostwanted".$_POST["mw"]]."' where `id`= '".$_POST["mw"]."' ");
	}
	if(!empty($_POST["hd"])){
		$qry=mysql_query("update `tblUsers` set `hide` = '".$_POST["hide".$_POST["hd"]]."' where `id`= '".$_POST["hd"]."' ");
	}
?>
 <form name="form2" action="index.php?content=users" method="post">
	<input type="hidden" name="block" value="" />
	<input type="hidden" name="upgrade" value="" />
	<input type="hidden" name="mw" value="" />
	<input type="hidden" name="hd" value="" />
	<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr><td height="20"></td></tr>
	<!-- Page title line -->
	<tr><td width="100%"><font class="pagetitle">Users List </font></td></tr>
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
						if(!empty($_POST["ord"])){$ord=$_POST["ord"];} else {$ord="id";}
						if(!empty($_POST["dir"])){$dir=$_POST["dir"];} else {$dir="desc";}
						if(!empty($_POST["limit"])){$limit=$_POST["limit"];} else {$limit=10;}
						if(!empty($_POST["page"])){$page=$_POST["page"];} else {$page=1;}
						?>
					<input type="hidden" name="ord" value="<?=$ord ?>" /><input type="hidden" name="dir" value="<?=$dir ?>" /><input type="hidden" name="page" value="<?=$page ?>" />
					<tr>
						<td width="20%" align="left">Screen name:</td>
						<td width="30%" align="left"><input type="text" class="tabletext" name="screenname" value="<?=$_POST["screenname"] ?>" size="27" /></td>
						<td width="5%" align="right">Email:</td>
						<td width="45%" align="left"><input type="text" class="tabletext" name="email" value="<?=$_POST["email"] ?>" size="25" /></td>
					</tr>
					<tr>
						<td width="20%" align="left">Sex:</td>
						<td width="30%" align="left"><select class="tabletext" name="sex">
						<option value="">-all-</option>
						<option value="0" <? if($_POST["sex"]=="0"){ echo "selected='selected'"; } ?>>Man</option>
						<option value="1" <? if($_POST["sex"]=="1"){ echo "selected='selected'"; } ?>>Woman</option>
						<option value="2" <? if($_POST["sex"]=="2"){ echo "selected='selected'"; } ?>>Couple</option>
						<option value="3" <? if($_POST["sex"]=="3"){ echo "selected='selected'"; } ?>>Group</option>
						</select></td>
						<td width="5%" align="right">Fake:</td>
						<td width="45%" align="left"><select class="tabletext" name="type">
						<option value="">-all-</option>
						<option value="Y" <? if($_POST["type"]=="Y"){ echo "selected='selected'"; } ?>>Yes</option>
						<option value="N" <? if($_POST["type"]=="N"){ echo "selected='selected'"; } ?>>No</option>
						</select>Type:<select class="tabletext" name="accesslevel" style="width: 68px;">
						<option value="">-all-</option>
						<option value="0" <? if($_POST["accesslevel"] == "0"){ echo "selected='selected'"; } ?>>Free</option>
						<option value="1" <? if($_POST["accesslevel"] == "1"){ echo "selected='selected'"; } ?>>Silver</option>
						<option value="4" <? if($_POST["accesslevel"] == "4"){ echo "selected='selected'"; } ?>>Silver+Gold</option>
						<option value="2" <? if($_POST["accesslevel"] == "2"){ echo "selected='selected'"; } ?>>Gold</option>
						<option value="3" <? if($_POST["accesslevel"] == "3"){ echo "selected='selected'"; } ?>>COMP</option>
						</select></td>
					</tr>
					<tr>
						<td width="20%" align="left">Joined on:</td>
						<td width="30%" align="left"><input class="tabletext" id="f-calendar-field-1" name="joined" size="27" value="<?=$_POST["joined"];?>"><a id="f-calendar-trigger-1" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-1","button":"f-calendar-trigger-1"});</script></td>
						<td width="5%" align="right">Until:</td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-2" name="joineduntil" size="25" value="<?=$_POST["joineduntil"];?>"><a id="f-calendar-trigger-2" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-2","button":"f-calendar-trigger-2"});</script></td>
					</tr>
					<tr>
						<td width="20%" align="left">Last login from:</td>
						<td width="30%" align="left"><input class="tabletext" id="f-calendar-field-3" name="login" size="27" value="<?=$_POST["login"];?>"><a id="f-calendar-trigger-3" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-3","button":"f-calendar-trigger-3"});</script></td>
						<td width="5%" align="right">Until:</td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-4" name="loginuntil" size="25" value="<?=$_POST["loginuntil"];?>"><a id="f-calendar-trigger-4" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-4","button":"f-calendar-trigger-4"});</script></td>
					</tr>
					<tr>
						<td width="20%" align="left">Upgraded on:</td>
						<td width="30%" align="left"><input class="tabletext" id="f-calendar-field-5" name="upgraded" size="27" value="<?=$_POST["upgraded"];?>"><a id="f-calendar-trigger-5" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-5","button":"f-calendar-trigger-5"});</script></td>
						<td width="5%" align="right">Until:</td>
						<td width="45%" align="left"><input class="tabletext" id="f-calendar-field-6" name="upgradeduntil" size="25" value="<?=$_POST["upgradeduntil"];?>"><a id="f-calendar-trigger-6" href="#"><img src="images/calendar.png" alt="" width="16" height="16" border="0" align="middle"></a>
						  <script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"f-calendar-field-6","button":"f-calendar-trigger-6"});</script></td>
					</tr>
					<tr>
						<td width="20%" align="left">Disabled:</td>
						<td width="30%" align="left"><select class="tabletext" name="disabled">
						<option value="">-all-</option>
						<option value="Y" <? if($_POST["disabled"]=="Y"){ echo "selected='selected'"; } ?>>Yes</option>
						<option value="N" <? if($_POST["disabled"]=="N"){ echo "selected='selected'"; } ?>>No</option>
						</select></td>
						<td width="5%" align="right"></td>
						<td width="45%" align="left"></td>
					</tr>
					<tr>
						<td colspan="4" align="center">
						  <p>
						    <input type="hidden" name="submitfilter" value="Filter" />
						    <input type="submit" name="thesubmit" value="Search" />						
					      </p>
						  <p>
						    <input type="button" onclick="document.getElementById('filterdiv').style.display='none'; document.getElementById('showdiv').style.display='block'" name="Hide2" value="Hide Search" />
				        </p></td>
					  </tr>
					
					</table>	
					
	  <input id="showdiv" type="button" onclick="document.getElementById('filterdiv').style.display='block'; document.getElementById('showdiv').style.display='none'" style="display:none" name="Show" value="Show Filter" /></td>
	</tr>
	<? 
		//if((!empty($_POST["submitfilter"]) && $_POST["submitfilter"]=="Filter") || (!empty($_GET["actions"])) && $_GET["actions"]=="list"){
		{
		$qry="select * from `tblUsers` ";
		if($_POST["screenname"]!="" || $_POST["email"]!="" || $_POST["sex"]!="" || $_POST["type"]!="" || $_POST["accesslevel"]!="" || $_POST["joined"]!="" || $_POST["joineduntil"]!="" || $_POST["login"]!="" || $_POST["loginuntil"]!="")
		{
			$qry.=" where";
			$filters=array();
			$nr_filters=0;
			if($_POST["screenname"]!=""){$nr_filters++;array_push($filters,"screenname");}
			if($_POST["email"]!=""){$nr_filters++;array_push($filters,"email");}
			if($_POST["sex"]!=""){$nr_filters++;array_push($filters,"sex");}
			if($_POST["type"]!=""){$nr_filters++;array_push($filters,"type");}
			if($_POST["disabled"]!=""){$nr_filters++;array_push($filters,"disabled");}
			if($_POST["accesslevel"]!=""){$nr_filters++;array_push($filters,"accesslevel");}
			if($_POST["joined"]!=""){$nr_filters++;array_push($filters,"joined");}
			if($_POST["joineduntil"]!=""){$nr_filters++;array_push($filters,"joineduntil");}
			if($_POST["login"]!=""){$nr_filters++;array_push($filters,"login");}
			if($_POST["loginuntil"]!=""){$nr_filters++;array_push($filters,"loginuntil");}
			if($_POST["upgraded"]!=""){$nr_filters++;array_push($filters,"upgraded");}
			if($_POST["upgradeduntil"]!=""){$nr_filters++;array_push($filters,"upgradeduntil");}
			for($i=0; $i<count($filters); $i++){
				if($filters[$i]=="screenname") $qry.=" `screenname` LIKE '%".$_POST["screenname"]."%'";
				if($filters[$i]=="email") $qry.=" `email` = '".$_POST["email"]."'";
				if($filters[$i]=="sex") $qry.=" `sex`='".$_POST["sex"]."'";
				if($filters[$i]=="type") $qry.=" `typeusr`='".$_POST["type"]."'";
				if($filters[$i]=="disabled") $qry.=" `disabled`='".$_POST["disabled"]."'";
				if($filters[$i]=="accesslevel" and $_POST["accesslevel"] == 0) $qry.=" `accesslevel`='".$_POST["accesslevel"]."'";
				if($filters[$i]=="accesslevel" and ($_POST["accesslevel"] == 1 OR $_POST["accesslevel"] == 2)) $qry.=" `accesslevel`='".$_POST["accesslevel"]."' and `upgraded`!='00-00-00 00:00:00'";
				if($filters[$i]=="accesslevel" and $_POST["accesslevel"] == 3) $qry.=" (`accesslevel` = '1' or `accesslevel` = '2') and `upgraded` ='00-00-00 00:00:00'";
				if($filters[$i]=="accesslevel" and $_POST["accesslevel"] == 4) $qry.=" (`accesslevel` = '1' or `accesslevel` = '2') and `upgraded`!='00-00-00 00:00:00'";
				if($filters[$i]=="joined") $qry.=" `joined` >='".$_POST["joined"]." 00:00:00"."'";
				if($filters[$i]=="joineduntil") $qry.=" `joined` <='".$_POST["joineduntil"]." 23:59:59"."'";
				if($filters[$i]=="login") $qry.=" `lastlogin` >='".$_POST["login"]." 00:00:00"."'";
				if($filters[$i]=="loginuntil") $qry.=" `lastlogin` <='".$_POST["loginuntil"]." 23:59:59"."'";
				if($filters[$i]=="upgraded") $qry.=" `upgraded` >='".$_POST["upgraded"]." 00:00:00"."'";
				if($filters[$i]=="upgradeduntil") $qry.=" `upgraded` <='".$_POST["upgradeduntil"]." 23:59:59"."'";
				if($i!=count($filters)-1) $qry.=" and";
			}
		}
		//echo $qry;
		$qry2=$qry." limit ".($page-1)*$limit.",".$limit;
		$qry_2=mysql_query("SELECT COUNT(*) " . substr($qry, strpos($qry, 'from')));
		$qry=mysql_query($qry2);
		$nr_found=mysql_num_rows($qry);
		$nr_found2= mysql_result($qry_2,0,0);
		
		
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><?=number_format($nr_found2,0,'',','); ?> entries found in database</font></td>
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
	<tr>
	<td>
	<table style="vertical-align:top; width:1000px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="12" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:110px"><font class="tablecateg">Main Image</font></td>
					<td align="center" style="width:113px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="picscreenname" onclick="ordertabels('screenname')" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Password</font></td>
					<td align="center" style="width:180px"><img id="picemail" alt="arrows" onclick="ordertabels('email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Email</font></td>
					<td align="center" style="width:90px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="piclastlogin" onclick="ordertabels('lastlogin')" /><font class="tablecateg">Last login</font></td>
					<td align="center" style="width:52px"><img src="images/sort/sort_off2.gif" alt="" width="13" height="14" id="pictypeusr" onclick="ordertabels('typeusr')" /><font class="tablecateg">Fake</font></td>
					<td align="center" style="width:50px"><font class="tablecateg">Hide</font></td>
					<td align="center" style="width:70px"><font class="tablecateg">MostWanted</font></td>
					<td align="center" style="width:110px"><font class="tablecateg">Member type</font></td>
					<td align="center" style="width:105px"><font class="tablecateg">Transaction ID</font></td>
					<td align="center" style="width:65px"><font class="tablecateg"></font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Operations</font></td>
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
					<td align="center"><img src="<?=$cfg['path']['url_site'] . "showphoto.php?id=".$theaccount['id']."&m=Y&t=s&p=1"?>" alt="Users Main Image" border="1" style="width: 30px; height: 30px;"/></td>
					<td align="left">&nbsp;<font class="tabletext">
					  <?=$theaccount["screenname"] ?>
					  </font>&nbsp;</td>
					<td align="center">&nbsp;<font class="tabletext"><?=$theaccount["pass"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext">
					  <?=$theaccount["email"] ?>
					  </font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					  <?=$theaccount["lastlogin"] ?>
					  </font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					  <? if($theaccount["typeusr"]=='N'){ echo "no"; }else{ echo "yes"; } ?>
					  </font></td>
					<td align="center">&nbsp;&nbsp; <font class="tabletext">
	          <select name="hide<?=$theaccount["id"] ?>" onchange="document.form2.hd.value='<?=$theaccount["id"] ?>'; document.form2.submit()">
					    <option value="Y">Yes</option>
					    <option value="N" <?if($theaccount["hide"]=='N'){ echo "selected"; } ?> >No</option>
				    </select>
					  </font></td>
					<td align="center">&nbsp;&nbsp; <font class="tabletext">
	          <select name="mostwanted<?=$theaccount["id"] ?>" onchange="document.form2.mw.value='<?=$theaccount["id"] ?>'; document.form2.submit()">
					    <option value="Y">Yes</option>
					    <option value="N" <?if($theaccount["mostwanted"]=="N"){ echo "selected";} ?> >No</option>
				    </select>
					  </font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					  <? if($theaccount["accesslevel"]==2 and $theaccount["upgraded"] != "0000-00-00 00:00:00"){ echo "Gold"; }elseif($theaccount["accesslevel"]==1 and $theaccount["upgraded"] != "0000-00-00 00:00:00"){echo "Silver";}elseif($theaccount["accesslevel"] == 0){ echo "Free"; }else{ echo "COMP"; } ?>
					  &nbsp;&nbsp;
	          <select name="accesslevel<?=$theaccount["id"] ?>" onchange="document.form2.upgrade.value='<?=$theaccount["id"] ?>'; document.form2.submit()">
					    <option value="">-change-</option>
					    <option value="0">Free</option>
					    <option value="1">Silver</option>
					    <option value="2">Gold</option>
				    </select>
					  </font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext">
					  <?=showtransactionid($theaccount["id"], $theaccount["email"], $theaccount["typeusr"], $theaccount["accesslevel"]);?>
					  </font></td>
					<td align="center"><? if($theaccount["disabled"]=='N'){?>
					  <a href="#" onclick="document.form2.block.value='<?=$theaccount["id"] ?>'; document.form2.submit()"><font class="tabletext"><img src="images/greensquare.gif" alt="" width="10" height="10" border="0" /> Block</font></a>
					  <? }else{ ?>
					  <a href="#" onclick="document.form2.block.value='<?=$theaccount["id"];?>'; document.form2.submit()"><font class="tabletext"><img src="images/redsquare.gif" alt="" width="10" height="10" border="0" /> Unblock</font></a>
					  <? } ?></td>
					<td align="center"><a href="index.php?content=viewuser&amp;id=<?=$theaccount["id"] ?>" target="_blank"><img border="0" title="View" alt="View" src="images/button_view.gif" width="16" height="16" /></a>&nbsp;&nbsp;<a href="index.php?content=edituser&amp;id=<?=$theaccount["id"] ?>" target="_blank"><img border="0" title="Edit" alt="Edit" src="images/button_edit.gif" width="16" height="16" /></a>&nbsp;&nbsp;<a href="#"><img title="Delete" alt="Delete" border="0" src="images/button_drop.gif" width="16" height="16" onclick="this.style.cursor='hand'; this.style.cursor='pointer'; javascript: if(confirm('Are you sure you want to delete this user?')){ document.location.href='index.php?content=users&amp;action=del&amp;id=<?=$theaccount["id"] ?>' }" /></a> <br/>
					  <a href="index.php?content=viewinbox&amp;id=<?php echo $theaccount["id"];?>" target="_blank"><img src="images/inbox.jpg" width="16" alt="Inbox" title="Inbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;<a href="index.php?content=viewoutbox&amp;id=<?php echo $theaccount["id"] ?>" target="_blank"><img src="images/outbox.jpg" width="16" alt="Outbox" title="Outbox" height="16" border="0" style="border:0" /></a>&nbsp;&nbsp;<a href="index.php?content=viewpayments&amp;id=<?php echo $theaccount["id"] ?>" target="_blank"><img src="images/dollar_button.gif" width="16" alt="View Payments"  height="16" border="0" style="border:0" /></a>&nbsp;&nbsp; </td>
				</tr>
			<?
				}
			?>
			<tr>
				<td colspan="12" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
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
						pages(<?=ceil($nr_found2/$limit) ?>);}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
				</tr>
				</table>			
				</td>
			</tr>
			<tr>
				<td colspan="12" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
	<!--<tr>
		<td height="3" bgcolor="#990000" width="100%">
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
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: document.location.href='index.php?content=adduser'" style="color:#333333" name="insert" value="Add user"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>	</td>
	</tr> -->
	<?php 
	mysql_free_result($qry);
	mysql_free_result($qry_2);
		}
	?>
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