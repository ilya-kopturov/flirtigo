<?
/* $Id$ */

if(!empty($_GET["action"]) && $_GET["action"]=="ready")
{
	$update = @mysql_query("UPDATE `tblMassRequest` SET `ready` = 'Y' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "ADD mails to MassRequest Campaign has started!";
	} elseif(mysql_error()) {
		$msg = "MassRequest Campaign WAS NOT Started! ERROR: " . mysql_error();
	} else {
		$msg = "ADD mails to MassRequest Campaign has started!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="start")
{
	$update = @mysql_query("UPDATE `tblMassRequest` SET `running` = 'Y' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "MassRequest campaign Started Succesfully!";
	} else {
		$msg = "MassRequest campaign WAS NOT Started!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="pause")
{
	$update = @mysql_query("UPDATE `tblMassRequest` SET `running` = 'N' WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "MassRequest campaign Paused Succesfully!";
	} else {
		$msg = "MassRequest campaign WAS NOT Paused!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="stop")
{
	$up     = @mysql_query("UPDATE `tblMassRequestMails` SET `sent` = 'N', `readed` = 'N', `login` = 'N' WHERE `campaignid` = '" . $_GET['id'] . "'");
	$update = @mysql_query("UPDATE `tblMassRequest` SET `finished` = 'N', `running` = 'N', `sent` = 0, `readed` = 0, `bounced` = 0, `login` = 0, `upgraded` = 0 WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	if(mysql_affected_rows() > 0){
		$msg = "MassRequest Stopped Succesfully!";
	} else {
		$msg = "MassRequest WAS NOT Stopped!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="del")
{
	$del_mails    = @mysql_query("DELETE FROM `tblMassRequestMails` WHERE `campaignid` = '". $_GET['id'] ."'");
	$del_campaign = @mysql_query("DELETE FROM `tblMassRequest` WHERE `id` = '". $_GET['id'] ."' LIMIT 1");
	
	if(mysql_affected_rows() > 0){
		$msg = "MassRequest Deleted Succesfully!";
	} else {
		$msg = "MassRequest WAS NOT Deleted!";
	}
}

if(!empty($_GET["action"]) && $_GET["action"]=="dup")
{
	$dup_campaign = "INSERT INTO `tblMassRequest` (`title`, `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `joinedto`, 
			                         				`lastloginfrom`, `lastloginto`, `mailreceived`, `mailresponded`, `mailopened`, `payed`, 
			                         				`cancelled`, `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		    	                     				`sendid`, `toscreenname`, `toseed`, `toevery`) 
		            	              select        `title`, `description`, `age_from`, `age_to`, `sex`, `looking`, `joinedfrom`, `joinedto`, 
		                	         				`lastloginfrom`, `lastloginto`, `mailreceived`, `mailresponded`, `mailopened`, `payed`, 
		                    	     				`cancelled`, `howmany`, `emailserver`,`interval`, `origin`,`originaccesslevel`,`emailstatus`,
		                        	 				`sendid`, `toscreenname`, `toseed`, `toevery`  
		                          	FROM `tblMassRequest` 
		                          	WHERE `id` = '". $_GET['id'] ."' 
		                          	LIMIT 1";
	
	@mysql_query($dup_campaign);
	
	if(mysql_affected_rows() > 0){
		$msg = "MassRequest Campaign Succesfully Duplicated!";
		@mysql_query("UPDATE `tblMassRequest` SET `date` = NOW() WHERE `id` = " . mysql_insert_id());
	} else {
		$msg = "MassRequest Campaign WAS NOT Duplicate!";
	}
}
?>
<form name="form2" action="index.php?content=gallery_listmass" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">MassRequests List </font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="left" valign="middle" bgcolor="#EEEEEE" style="border:1px solid #CCCCCC">
		
					<table id="filterdiv" bgcolor="#EEEEEE" style="vertical-align:middle" align="left" border="0" cellpadding="0" cellspacing="4" width="100%">
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
							$limit="20";
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
						<!--Search for:<input type="text" class="tabletext" name="search" id="search" value="<?=$_POST["search"] ?>" size="27" /> 
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
						  <option value="Login" <? if($_POST["from"]=="Login"){ echo "selected='selected'"; } ?>>Log-in#</option>
						  <option value="Upgraded" <? if($_POST["from"]=="Upgraded"){ echo "selected='selected'"; } ?>>Upgraded#</option>
                        </select><input type="hidden" name="submitfilter" value="Filter" />
						<input type="submit" name="thesubmit" value="Filter" />--></td>
					</tr>
					
					</table>	
		
		  </td>
	</tr>
	<? 
		$qry = "SELECT * FROM `tblMassRequest` ";
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
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			</select></font></td>
		</table>
		</td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:2020px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="20" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
			        <td align="center" style="width:100px"><font class="tablecateg">Created on</font></td>
					<td align="center" style="width:120px"><img id="picSendFrom" onclick="ordertabels('sendid')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">From</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Test<br>Campaign</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Title</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Description</font></td>
					<td align="center" style="width:140px"><img id="picJoinedOn" onclick="ordertabels('joinedfrom')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Joined From</font></td>
					<td align="center" style="width:140px"><font class="tablecateg"><img id="picJoinedOnUntil" alt="arrows" onclick="ordertabels('joinedto')" src="images/sort/sort_off2.gif" width="13" height="14" />Joined Until</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Age Range</font></td>
					<td align="center" style="width:70px"><img id="pic`Interval`" alt="arrows" onclick="ordertabels('`interval`')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Delay</font></td>
					<td align="center" style="width:70px"><img id="picFinished" onclick="ordertabels('finished')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Finished</font></td>
					<td align="center" style="width:70px"><img id="picRunning" onclick="ordertabels('running')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Running</font></td>
					<td align="center" style="width:120px"><img id="picNr" onclick="ordertabels('recipients')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Recipients#</font></td>
					<td align="center" style="width:70px"><img id="picSent" onclick="ordertabels('sent')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Sent#</font></td>
					<td align="center" style="width:90px"><img id="picReaded" onclick="ordertabels('readed')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Read#</font></td>
					<td align="center" style="width:90px"><img id="picBounced" onclick="ordertabels('bounced')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Bounced#</font></td>
					<td align="center" style="width:90px"><img id="picLogin" onclick="ordertabels('login')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Log-in#</font></td>
					<td align="center" style="width:70px"><img id="picLogin" onclick="ordertabels('upgraded')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Upgraded#</font></td>
					<td align="center" style="width:180px"><font class="tablecateg">Operations</font></td>
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
			        <td align="left">&nbsp;<font class="tabletext"><?=$theaccount["date"]; ?></font></td>
					<td align="left">&nbsp;<font class="tabletext"><?=id_to_screenname($theaccount["sendid"]); ?></font></td>
					<td align="center"><font class="tabletext"><? if($theaccount["toscreenname"] != ""){echo $theaccount["toscreenname"];} else {echo "-no-";} ?></font></td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["title"]; ?></font></td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["description"]; ?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["joinedfrom"]; ?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["joinedto"]; ?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["age_from"]; ?> - <?=$theaccount["age_to"]; ?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["interval"]; ?></font></td>
					<td align="center"><font class="tabletext"><? if($theaccount["finished"] == "Y"){echo "Yes";}else{echo "No";}?></font></td>
					<td align="center"><font class="tabletext"><? if($theaccount["running"] == "Y"){echo "Yes";}else{echo "No";}?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["recipients"];?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["sent"];?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["readed"];?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["bounced"];?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["login"];?></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["upgraded"];?></font></td>
					<td align="center">
					  <table border="0" cellpadding="0" cellspacing="0">
					    <tr>
					      <td align="left" style="padding-left: 2px;">
					        <?if($theaccount["finishedaddmails"] == "Y"){?>
					        <?if($theaccount["running"] == "Y" AND $theaccount["finished"] == "N"){?>
					          <a href="javascript: if(confirm('Are you sure you want to pause this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=pause&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Pause MassRequest campaign" src="images/pause_button.jpg" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to stop this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=stop&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Stop MassRequest campaign" src="images/stop_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to delete this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete MassRequest campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to duplicate this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate MassRequest campaign" src="images/dup_button.gif" width="16" height="16"></a>
					          <a href="javascript: document.location.href='index.php?content=gallery_editmass&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit MassRequest campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?}elseif($theaccount["finished"] == "N"){?>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to start this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=start&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Start MassRequest campaign" src="images/start_button.jpg" width="16" height="16"></a>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <a href="javascript: if(confirm('Are you sure you want to delete this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete MassRequest campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					          <a href="javascript: if(confirm('Are you sure you want to duplicate this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate MassRequest campaign" src="images/dup_button.gif" width="16" height="16"></a>
					          <a href="javascript: document.location.href='index.php?content=gallery_editmass&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit MassRequest campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?} else {?>
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					          <img border="0" src="images/trans_button.gif" width="16" height="16">
					  	      <a href="javascript: if(confirm('Are you sure you want to delete this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete MassRequest campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to duplicate this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate MassRequest campaign" src="images/dup_button.gif" width="16" height="16"></a>
					  	      <a href="javascript: document.location.href='index.php?content=gallery_editmass&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit MassRequest campaign" src="images/button_edit.gif" width="16" height="16"></a>
					        <?}
					          } elseif($theaccount["ready"] == "N"){?>
					  	      <a href="javascript: if(confirm('Are you sure you want to ADD MAILS to this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=ready&id=<?=$theaccount["id"] ?>' }; void(0);" style="font-size: 10px; font-face: Verdana;"><u>ADD MAILS</u></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to delete this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=del&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Delete MassRequest campaign" src="images/delete_button.jpg" width="16" height="16"></a>
					  	      <a href="javascript: if(confirm('Are you sure you want to duplicate this MassRequest campaign?')){ document.location.href='index.php?content=gallery_listmass&action=dup&id=<?=$theaccount["id"] ?>' }; void(0);"><img border="0" alt="Duplicate MassRequest campaign" src="images/dup_button.gif" width="16" height="16"></a>
					  	      <a href="javascript: document.location.href='index.php?content=gallery_editmass&id=<?=$theaccount["id"] ?>'; void(0);"><img border="0" alt="View & Edit MassRequest campaign" src="images/button_edit.gif" width="16" height="16"></a>
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
				<td colspan="20" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="20" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
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
					<!--<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;--></td>
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
	if(document.getElementById('gallerypass1').style.display == 'none'){
		document.getElementById('gallerypass1').style.display = '';
	}
	if(document.getElementById('gallerypass2').style.display == 'none'){
		document.getElementById('gallerypass2').style.display = '';
	}
	if(document.getElementById('gallerypass3').style.display == 'none'){
		document.getElementById('gallerypass3').style.display = '';
	}
	if(document.getElementById('gallerypass4').style.display == 'none'){
		document.getElementById('gallerypass4').style.display = '';
	}
</script>