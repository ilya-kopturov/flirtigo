<?
if(!empty($_GET["action"]) && $_GET["action"]=="ready")
{
	$update = @mysql_query("UPDATE `tblCampaign` SET `ready` = 'Y' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "WE now ADD mails to Campaign!";
	} elseif(mysql_error()) {
		$msg = "Campaign WAS NOT Started! ERROR: " . mysql_error();
	} else {
		$msg = "WE now ADD mails to Campaign!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="start")
{
	$update = @mysql_query("UPDATE `tblCampaign` SET `running` = 'Y' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Started Succesfully!";
	} else {
		$msg = "Campaign WAS NOT Started!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="pause")
{
	$update = @mysql_query("UPDATE `tblCampaign` SET `running` = 'N' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Paused Succesfully!";
	} elseif(mysql_error()) {
		$msg = "Campaign WAS NOT Paused!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="stop")
{
	$up     = @mysql_query("UPDATE `tblCampaignMails` SET `sent` = 'N', `readed` = 'N', `login` = 'N' WHERE `campaignid` = '" . $_GET['id'] . "'");
	$update = @mysql_query("UPDATE `tblCampaign` SET `finished` = 'N', `running` = 'N', `sent` = 0, `readed` = 0, `bounced` = 0, `login` = 0, `upgraded` = 0 WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Stopped Succesfully!";
	} else {
		$msg = "Campaign WAS NOT Stopped!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="del")
{
	$del_campaign = @mysql_query("DELETE FROM `tblCampaign`      WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	$del_mails    = @mysql_query("DELETE FROM `tblCampaignMails` WHERE `campaignid` = '". $_GET['id'] ."'");
	
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Deleted Succesfully!";
	} elseif(mysql_error()) {
		$msg = "Campaign WAS NOT Deleted!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="dup")
{
	$dup_campaign = "INSERT INTO `tblCampaign` (`title`, `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `joinedto`, 
		                         				`lastloginfrom`, `lastloginto`, `mailreceived`, `mailresponded`, `mailopened`, `loggedin`, `payed`, 
		                         				`cancelled`, `sendexternal`, `sendinternal`, `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		                         				`subjectextern`, `messageextern`, `subjectintern`, `messageintern`, `sendid`, `toscreenname`, 
		                         				`toseed`, `toevery`, `routed`, `date`) 
		                          select        `title`, `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `joinedto`, 
		                         				`lastloginfrom`, `lastloginto`, `mailreceived`, `mailresponded`, `mailopened`, `loggedin`, `payed`, 
		                         				`cancelled`, `sendexternal`, `sendinternal`, `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		                         				`subjectextern`, `messageextern`, `subjectintern`, `messageintern`, `sendid`, `toscreenname`, 
		                         				`toseed`, `toevery`, `routed`, `date`  
		                          FROM `tblCampaign` 
		                          WHERE `id` = '". $_GET['id'] ."' 
		                          LIMIT 1";
	
	@mysql_query($dup_campaign);
	
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Succesfully Duplicated!";
		@mysql_query("UPDATE `tblCampaign` SET `date` = NOW() WHERE `id` = " . mysql_insert_id());
	} else {
		$msg = "Campaign WAS NOT Duplicate!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="resend")
{
	$dup_campaign = "INSERT INTO `tblCampaign` (`title`, `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `joinedto`, 
		                         				`lastloginfrom`, `lastloginto`, `mailreceived`, `mailresponded`, `mailopened`, `loggedin`, `payed`, 
		                         				`cancelled`, `sendexternal`, `sendinternal`, `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		                         				`subjectextern`, `messageextern`, `subjectintern`, `messageintern`, `sendid`, `toscreenname`, 
		                         				`toseed`, `toevery`, `routed`, `date`) 
		                          select        CONCAT('DEFERED: ', `title`), `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `date`, 
		                         				`lastloginfrom`, `date`, `mailreceived`, `mailresponded`, `mailopened`, `loggedin`, `payed`, 
		                         				`cancelled`, `sendexternal`, 'N', `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		                         				`subjectextern`, `messageextern`, `subjectintern`, `messageintern`, `sendid`, `toscreenname`, 
		                         				`toseed`, `toevery`, `routed`, `date`  
		                          FROM `tblCampaign` 
		                          WHERE `id` = '". $_GET['id'] ."' 
		                          LIMIT 1";
	
	@mysql_query($dup_campaign);
	
	if(mysql_affected_rows() > 0){
		$msg = "Campaign Succesfully Added!";
		@mysql_query("UPDATE `tblCampaign` SET `emailstatus` = 'D', `date` = NOW() WHERE `id` = " . mysql_insert_id());
	} else {
		$msg = "Campaign WAS NOT Added!";
	}
}

$col_array = mysql_fetch_array(mysql_query("SELECT `id`,`createdOn`,`title`,`description`,`finishedon`,`from`,`testCampaign`,
                                                   `routed`,`subjectintern`,`subjectextern`,`joinedfrom`,`joinedto`, `ageRange`,
                                                   `delay`,`finished`,`running`,`recipients`,`sent`,`readed`,`bounced`,`defered`,`login`,
                                                   `upgraded` FROM `tblCampaignFields`"));
?>
<form name="form2" action="index.php?content=campaign" method="post">
<table style="vertical-align:top" align="center" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Campaigns List </font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="left" valign="middle" bgcolor="#EEEEEE" style="border:1px solid #CCCCCC">
		
					<table id="filterdiv" bgcolor="#EEEEEE" style="vertical-align:middle" align="left" border="0" cellpadding="0" cellspacing="4" class="filternameblack" width="100%">
					<? if($_POST["ord"]!="id" && $_POST["ord"]!=""){ ?>
					<tr style="background-color:#FFFFFF">
						<td align="left" style="font-size:12px; color:#990000; font-weight:normal">Sorting pattern: <?=$_POST["ord"] ?>(<?=$_POST["dir"] ?>);</td>
						<td align="right"><a href="#" onclick="javascript: ordertabels('Id')" style="text-decoration:none"><font class="filternameblack" style="font-size:12px; text-decoration:underline">reset sorting pattern</font></a></td>
					</tr>
					<? } 
						if(!empty($_POST["ord"])){
							$ord=$_POST["ord"];
						} else {
							$ord="id";
						}
						if(!empty($_POST["dir"])){
							$dir=$_POST["dir"];
						} else {
							$dir="DESC";
						}
						if(!empty($_POST["limit"])){
							$limit=$_POST["limit"];
						} else {
							$limit="50";
						}
						if(!empty($_POST["page"])){
							$page=$_POST["page"];
						} else {
							$page="1";
						}
					?>
					
					<tr>
						<td colspan="2" width="100%" align="left">
						<input type="hidden" name="ord" value="<?=$ord ?>" />
					<input type="hidden" name="dir" value="<?=$dir ?>" />
					<!-- <input type="hidden" name="limit" value="<? //$limit ?>" />-->
					<input type="hidden" name="page" value="<?=$page ?>" />
					<script language="javascript" type="text/javascript">
					function searchtip(){
						sel=document.form2.from;
						document.getElementById('calendarimg').style.visibility="hidden";
						document.getElementById('textexplain').innerHTML="";
						if(sel.value=="JoinedOn" || sel.value=="JoinedOnUntil"){
							document.getElementById('calendarimg').style.visibility="visible";
						}
						if(sel.value=="Nr" || sel.value=="Sent" || sel.value=="Readed"  || sel.value=="Bounced"  || sel.value=="`Interval`" || sel.value=="Login" || sel.value=="Upgraded"){
							document.getElementById('textexplain').innerHTML="(can use >,<, <=, >=)";
						}
					}
					</script>
						Search for:<input type="text" class="tabletext" name="search" id="search" value="<?=$_POST["search"] ?>" size="27" /> 
						<font id="textexplain" style="font-size:12px"><? if($_POST["from"]=="Recipients" || $_POST["from"]=="Sended") echo "(u can use &lt;,&gt;,&lt;=,&gt;=)"; ?></font><img alt="Calendar" <? if($_POST["from"]!="Date") echo "style='visibility:hidden'"; ?> id="calendarimg" src="images/calendar.png" align="middle" border="0" onmouseover="this.style.cursor='hand'; this.style.cursor='pointer'">
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","daFormat":"%Y/%m/%d","firstDate":1,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"search","button":"calendarimg"});</script> in <select class="tabletext" name="from" onchange="javascript: searchtip()">
                          <option value="SendFrom" <? if($_POST["from"]=="SendFrom"){ echo "selected='selected'"; } ?>>From</option>
                          <option value="SubjectIntern" <? if($_POST["from"]=="SubjectIntern"){ echo "selected='selected'"; } ?>>Subject</option>
						  <option value="JoinedOn" <? if($_POST["from"]=="JoinedOn"){ echo "selected='selected'"; } ?>>Date</option>
						  <option value="JoinedOnUntil" <? if($_POST["from"]=="JoinedOnUntil"){ echo "selected='selected'"; } ?>>End Date</option>
						  <option value="`Interval`" <? if($_POST["from"]=="`Interval`"){ echo "selected='selected'"; } ?>>Delay</option>
						  <option value="Finished" <? if($_POST["from"]=="Finished"){ echo "selected='selected'"; } ?>>Finished</option>
						  <option value="Running" <? if($_POST["from"]=="Running"){ echo "selected='selected'"; } ?>>Running</option>
						  <option value="Nr" <? if($_POST["from"]=="Nr"){ echo "selected='selected'"; } ?>>Recipients#</option>
						  <option value="Sent" <? if($_POST["from"]=="Sent"){ echo "selected='selected'"; } ?>>Sent#</option>
						  <option value="Readed" <? if($_POST["from"]=="Readed"){ echo "selected='selected'"; } ?>>Readed#</option>
						  <option value="Bounced" <? if($_POST["from"]=="Bounced"){ echo "selected='selected'"; } ?>>Bounced#</option>
						  <option value="Defeded" <? if($_POST["from"]=="Defeded"){ echo "selected='selected'"; } ?>>Defered#</option>
						  <option value="Login" <? if($_POST["from"]=="Login"){ echo "selected='selected'"; } ?>>Log-in#</option>
						  <option value="Upgraded" <? if($_POST["from"]=="Upgraded"){ echo "selected='selected'"; } ?>>Upgraded#</option>
                        </select><input type="hidden" name="submitfilter" value="Filter" />
						<input type="submit" name="thesubmit" value="Filter" /></td>
					</tr>
					
					</table>	
		
		  </td>
	</tr>
	<? 
		$qry = "SELECT * FROM `tblCampaign` where readyq='N'";
		$qry.=" order by ".$ord." ".$dir;
		$qry2=$qry." limit ".($page-1)*$limit.",".$limit;
		$qry_2=mysql_query($qry);
		$qry=mysql_query($qry2);
		$nr_found=mysql_num_rows($qry);
		$nr_found2=mysql_num_rows($qry_2);
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><?=number_format($nr_found2,0,',',','); ?> entries found in database</font></td>
			<td align="right" width="50%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="100" <? if($limit==100) echo "selected='selected'"; ?>>100</option>
			<option class="500" <? if($limit==500) echo "selected='selected'"; ?>>500</option>
			</select></font></td>
		</table>
		</td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:100%;" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)"> <? $columns = 1;?>
			        <td align="center" style="padding: 0px 5px 0px 5px; width:25px"></td>
			        <?if($col_array['id'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:25px"><font class="tablecateg">ID</font></td> <? $columns++; } ?>
			        <?if($col_array['createdOn'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:100px"><font class="tablecateg">CreatedOn</font></td> <? $columns++; } ?>
			        <?if($col_array['finishedon'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:100px"><font class="tablecateg">FinishedOn</font></td> <? $columns++; } ?>
					<?if($col_array['from'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:120px"><font class="tablecateg">From</font></td> <? $columns++; } ?>
					<?if($col_array['testCampaign'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:120px"><font class="tablecateg">Test<br>Campaign</font></td> <? $columns++; } ?>
					<?if($col_array['routed'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:50px"><font class="tablecateg">Routed</font></td> <? $columns++; } ?>
					<?if($col_array['title'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:120px"><font class="tablecateg">Title</font></td> <? $columns++; } ?>
					<?if($col_array['description'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:150px"><font class="tablecateg">Description</font></td> <? $columns++; } ?>
					<?if($col_array['subjectinternal'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:200px"><font class="tablecateg">InternalSubject</font></td> <? $columns++; } ?>
					<?if($col_array['subjectexternal'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:200px"><font class="tablecateg">ExternalSubject</font></td> <? $columns++; } ?>
					<?if($col_array['joinedfrom'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:140px"><font class="tablecateg">JoinedFrom</font></td> <? $columns++; } ?>
					<?if($col_array['joinedto'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:140px"><font class="tablecateg">JoinedUntil</font></td> <? $columns++; } ?>
					<?if($col_array['ageRange'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:120px"><font class="tablecateg">AgeRange</font></td> <? $columns++; } ?>
					<?if($col_array['delay'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:70px"><font class="tablecateg">Delay</font></td> <? $columns++; } ?>
					<?if($col_array['finished'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:70px"><font class="tablecateg">Finished</font></td> <? $columns++; } ?>
					<?if($col_array['running'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:70px"><font class="tablecateg">Running</font></td> <? $columns++; } ?>
					<?if($col_array['recipients'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:120px"><font class="tablecateg">Recipients#</font></td> <? $columns++; } ?>
					<?if($col_array['sent'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:70px"><font class="tablecateg">Sent#</font></td> <? $columns++; } ?>
					<?if($col_array['readed'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:90px"><font class="tablecateg">Read#</font></td> <? $columns++; } ?>
					<?if($col_array['bounced'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:90px"><font class="tablecateg">Bounced#</font></td> <? $columns++; } ?>
					<?if($col_array['defered'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:90px"><font class="tablecateg">Defered#</font></td> <? $columns++; } ?>
					<?if($col_array['login'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:90px"><font class="tablecateg">Log-in#</font></td> <? $columns++; } ?>
					<?if($col_array['upgraded'] == 'Y'){?> <td align="center" style="padding: 0px 5px 0px 5px; width:70px"><font class="tablecateg">Upgraded#</font></td> <? $columns++; } ?>
					<td align="center" style="padding: 0px 5px 0px 5px; width:200px"><font class="tablecateg">Operations</font></td> <? $columns++; ?>
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
			        <td align="center"><img src="<?=$cfg['path']['url_site'] . "showphoto.php?id=".$theaccount['sendid']."&m=Y&t=s&p=1"?>" style="width: 30px; height: 30px;" border="1"/></td>
			        <?if($col_array['id'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["id"]; ?></font></td> <?}?>
			        <?if($col_array['createdOn'] == 'Y'){?> <td align="center">&nbsp;<font class="tabletext"><?=$theaccount["date"]; ?></font></td> <?}?>
			        <?if($col_array['finishedon'] == 'Y'){?> <td align="center">&nbsp;<font class="tabletext"><?if($theaccount["finishedon"]){echo $theaccount["finishedon"];}else{echo "-";}?></font></td> <?}?>
					<?if($col_array['from'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><a href="viewprofile.php?id=<?=$theaccount["sendid"]?>" target="_blank"><?=id_to_screenname($theaccount["sendid"]); ?></a></font></td> <?}?>
					<?if($col_array['testCampaign'] == 'Y'){?> <td align="center"><font class="tabletext"><? if($theaccount["toscreenname"] != ""){echo $theaccount["toscreenname"];} else {echo "-no-";} ?></font></td> <?}?>
					<?if($col_array['routed'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><? if($servers = $db->get_var("SELECT `servername` FROM `tblServers`, `tblServersRoute` WHERE `tblServers`.`id` = `tblServersRoute`.`domainid` AND `tblServersRoute`.`campaignid` = '" . $theaccount['id'] . "' GROUP BY `tblServersRoute`.`domainid` LIMIT 1")){echo $servers;} else { echo "-";} ?></font></td> <?}?>
					<?if($col_array['title'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><?=$theaccount["title"]; ?></font></td> <?}?>
					<?if($col_array['description'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><?=$theaccount["description"]; ?></font></td> <?}?>
					<?if($col_array['subjectinternal'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><?=$theaccount["subjectintern"]; ?></font></td> <?}?>
					<?if($col_array['subjectexternal'] == 'Y'){?> <td align="left">&nbsp;<font class="tabletext"><?=$theaccount["subjectextern"]; ?></font></td> <?}?>
					<?if($col_array['joinedfrom'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["joinedfrom"]; ?></font></td> <?}?>
					<?if($col_array['joinedto'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["joinedto"]; ?></font></td> <?}?>
					<?if($col_array['ageRange'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["age_from"]; ?> - <?=$theaccount["age_to"]; ?></font></td> <?}?>
					<?if($col_array['delay'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["interval"]; ?></font></td> <?}?>
					<?if($col_array['finished'] == 'Y'){?> <td align="center"><font class="tabletext"><? if($theaccount["finished"] == "Y"){echo "Yes";}else{echo "No";}?></font></td> <?}?>
					<?if($col_array['running'] == 'Y'){?> <td align="center"><font class="tabletext"><? if($theaccount["running"] == "Y"){echo "Yes";}else{echo "No";}?></font></td> <?}?>
					<?if($col_array['recipients'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["recipients"];?></font></td> <?}?>
					<?if($col_array['sent'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["sent"];?></font></td> <?}?>
					<?if($col_array['readed'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["readed"];?></font></td> <?}?>
					<?if($col_array['bounced'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["bounced"];?></font></td> <?}?>
					<?if($col_array['defered'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["defered"];?></font></td> <?}?>
					<?if($col_array['login'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["login"];?></font></td> <?}?>
					<?if($col_array['upgraded'] == 'Y'){?> <td align="center"><font class="tabletext"><?=$theaccount["upgraded"];?></font></td> <?}?>
					<td align="center">
					  <table width="150" border="0" cellpadding="0" cellspacing="0">
					    <tr>
					      <td align="left" style="padding-left: 2px;">
					        <?if($theaccount["finishedaddmails"] == "Y"){?>
					        <?if($theaccount["running"] == "Y" AND $theaccount["finished"] == "N"){?>
					          <a href="javascript: if(confirm('Are you sure you want to pause this campaign?')){ document.location.href='index.php?content=campaign&action=pause&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Pause campaign" src="images/pause_button.jpg" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to stop this campaign?')){ document.location.href='index.php?content=campaign&action=stop&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Stop campaign" src="images/stop_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to delete this campaign?')){ document.location.href='index.php?content=campaign&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to duplicate this campaign?')){ document.location.href='index.php?content=campaign&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate campaign" src="images/dup_button.gif" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: document.location.href='index.php?content=editcampaign&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit Campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?}elseif($theaccount["finished"] == "N"){?>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to start this campaign?')){ document.location.href='index.php?content=campaign&action=start&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Start campaign" src="images/start_button.jpg" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to delete this campaign?')){ document.location.href='index.php?content=campaign&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to duplicate this campaign?')){ document.location.href='index.php?content=campaign&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate campaign" src="images/dup_button.gif" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: document.location.href='index.php?content=editcampaign&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit Campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?} else {?>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					  	      <a href="javascript: if(confirm('Are you sure you want to delete this campaign?')){ document.location.href='index.php?content=campaign&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to duplicate this campaign?')){ document.location.href='index.php?content=campaign&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate campaign" src="images/dup_button.gif" width="16" height="16"></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to re-send defered mails?')){ document.location.href='index.php?content=campaign&action=resend&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Re-send defered mails" src="images/resend_button.gif" width="16" height="16"></a>
					  	      <a href="javascript: document.location.href='index.php?content=editcampaign&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit Campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?}
					          } elseif($theaccount["ready"] == "N"){?>
					  	      <a href="javascript: if(confirm('Are you sure you want to ADD MAILS to this campaign?')){ document.location.href='index.php?content=campaign&action=ready&id=<?=$theaccount["id"] ?>' }; void(0);" style="font-size: 10px; font-face: Verdana;"><u>ADD MAILS</u></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to delete this campaign?')){ document.location.href='index.php?content=campaign&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to duplicate this campaign?')){ document.location.href='index.php?content=campaign&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate campaign" src="images/dup_button.gif" width="16" height="16"></a>
					  	      <img border="0" src="images/trans_button.gif" width="16" height="16">
					  	      <a href="javascript: document.location.href='index.php?content=editcampaign&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit Campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?} else {?>
					          <span style="font-size:12px; font-face: Verdana;" align="center">-adding mails-</span>
					        <?}?>
					      </td>
					    </tr>
					  </table>
					</td>
			</tr>
			<?
				}
			?>
			<tr>
				<td colspan="<?=$columns?>" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="<?=$columns?>" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
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
						if(document.form2.page.value><?=ceil($nr_found2/$limit) ?> && <? $nr_found2 ?>!=0){
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
	
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('campaign1').style.display == 'none'){
		document.getElementById('campaign1').style.display = '';
	}
	if(document.getElementById('campaign2').style.display == 'none'){
		document.getElementById('campaign2').style.display = '';
	}
	if(document.getElementById('campaign3').style.display == 'none'){
		document.getElementById('campaign3').style.display = '';
	}
	if(document.getElementById('campaign4').style.display == 'none'){
		document.getElementById('campaign4').style.display = '';
	}
</script>