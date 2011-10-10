<?php

list($type) = @mysql_fetch_array(mysql_query( "SELECT `typeusr` FROM `tblUsers` WHERE `id` = '" . $_GET['id'] . "' LIMIT 1" ));

if($type == 'Y'){ $tblmails = 'tblTypeMails'; } else { $tblmails = 'tblMails'; }

if(!empty($_POST["limit"])){$limit=$_POST["limit"];} else {$limit=10;}
if(!empty($_POST["page"])){$page=$_POST["page"];} else {$page=1;}

if($_POST['actionn']=='del')
{
	foreach($_POST['msg'] as $key=>$value)
		{
			@mysql_query("DELETE FROM `" . $tblmails . "` WHERE `id`='".$value."'");
		}
}

if($_POST['aaa']==1)
{ 
	foreach($_POST['msg'] as $key=>$value)
		{
			$email = get_email($value, $tblmails);
			
			$email['subject'] = str_replace("RE:", "", $email['subject']);
			
			$subject = htmlentities(strip_tags(trim($email['subject'])))?"RE: ".htmlentities(strip_tags(trim($email['subject']))):'(no subject)';
			$to      = id_to_screenname(trim($email['user_from']));
			$message = htmlentities(strip_tags(trim(urldecode($_POST['messg']))));
			$savemail= 1;
			$redirect_to = "mem_mail.php?folder=inbox";
	 		
//	 		if(!in_array($email['user_from'], $arr)){
				$error = box_sent_message($db, $to, $_GET['id'], $subject, $message, $savemail);
//			}
			
			if(!$error){
				@mysql_query("UPDATE `" . $tblmails . "` SET `new` = 'N' WHERE `id` = '" . $value . "'");
				$arr[] = $email['user_from'];
			}
		}
}
?>
<script language="javascript">
function valcheck()
{
   var msg = "";

  if (document.massmsg.messg.value == "")
     msg += "Please type a message \n"
	 
  if (msg != "")
     {
	    alert(msg);
		return false;
	 }
 else
       document.massmsg.submit();
     
}
</script>
 <script language="JavaScript">
			            <!--
			function checkAll()	{
				var cbs = document.forms["editform"].elements;
    			if(cbs) {
			        if(cbs.length) {
			            for (var i=0; i<cbs.length; i++) {       
			                cbs[i].checked = document.forms["editform"].elements["selectAll"].checked;
			            }
			        }
			        else {
			           cbs.checked = document.forms["editform"].elements["selectAll"].checked;
			        }
			    }
			}
			//-->
			</script>
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

<form name="form2" method="post">
<input type="hidden" name="ord" value="<?=$ord ?>" /><input type="hidden" name="dir" value="<?=$dir ?>" /><input type="hidden" name="page" value="<?=$page ?>" />
<table cellpadding="0" cellspacing="0" style="width:100%">
	<tr>
		<td align="left" width="50%"><font class="tablename"></font></td>
		<td align="right" width="50%"><font class="filternameblack">Entries per page:
		<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			<option class="100" <? if($limit==100) echo "selected='selected'"; ?>>100</option>
			<option class="200" <? if($limit==200) echo "selected='selected'"; ?>>200</option>
		</select></font></td>
	</tr>
</table>
</form>
<form name="editform" method="post" action="index.php?content=viewinbox&id=<?=$_GET["id"] ?>">
<input type="hidden" name="action" value="" />
<input type="hidden" name="id" value="<?=$_GET["id"] ?>" />
<input type="hidden" name="mesajview" value="" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	

	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Inbox for <?=id_to_screenname($_GET['id']);?></font></td>
	</tr>
	<tr>
		<td width="100%">
		  <input type="button" name="outbox" value="View Outbox" onClick="javascript:document.location.href='index.php?content=viewoutbox&id=<?=$_GET['id']?>'">
		</td>
	</tr>
	<?php
	list($nrOfMails)  = mysql_fetch_row(mysql_query("(SELECT COUNT(*) AS HOWMANY FROM `tblMails` WHERE `user_id`='".$_GET['id']."' and `folder` = '1')"));
	list($nrOfMails2) = mysql_fetch_row(mysql_query("(SELECT COUNT(*) AS HOWMANY FROM `tblTypeMails` WHERE `user_id`='".$_GET['id']."' and `folder` = '1')"));
	$nrOfMails += $nrOfMails2;
	?>
	<tr>
		<td width="100%"><font class="pagetitle">Messages in <b>Inbox</b>:&nbsp;&nbsp;<?=$nrOfMails?$nrOfMails:0;?></font></td>
	</tr>
	<!-- Page content line -->


	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" width="100%">
					
					<table bgcolor="#FFFFFF" width="100%" cellpadding="1" cellspacing="1">
						<tr>
                              <td width="30" height="24" align="center"><input type="checkbox" name="selectAll" onclick="checkAll()"></td>
					          <td width="150" align="center" class="middle-column-b"><strong>To</strong></td>
					          <td width="150" align="center" class="middle-column-b"><strong>From</strong></td>
					          <td width="150" align="center" class="middle-column-b"><strong>Date</strong></td>
					          <td width="100" align="center" class="middle-column-b"><strong>Type</strong></td>
					          <td align="center" class="middle-column-b"><strong>Subject</strong></td>
                           </tr>
						   <?php 																													
						   $qry_in=mysql_query("(SELECT `id`,`user_id`,`user_to`,`user_from`, `subject`, `message`, `folder`, `new`, `type`, `date_sent`, `operator_id`  FROM `tblMails` WHERE `user_id`='".$_GET['id']."' and `folder` = '1') UNION ALL (SELECT `id`,`user_id`,`user_to`,`user_from`, `subject`, `message`, `folder`, `new`, `type`, `date_sent`, `operator_id` FROM `tblTypeMails` WHERE `user_id`='".$_GET['id']."' and `folder` = '1') ORDER BY `date_sent` DESC LIMIT ".($page-1)*$limit.",".$limit);
						   while($row_in=mysql_fetch_array($qry_in))
						   {
						   		list($user_to_accesslevel)   = mysql_fetch_array(mysql_query("SELECT `accesslevel` FROM `tblUsers` WHERE `id` = '" . $row_in['user_to'] . "' LIMIT 1"));
						   		list($user_from_accesslevel) = mysql_fetch_array(mysql_query("SELECT `accesslevel` FROM `tblUsers` WHERE `id` = '" . $row_in['user_from'] . "' LIMIT 1"));
						   ?>
						   <tr bgcolor="<?=$color=$color=='#FFFFFF'?'#F2F2F2':'#FFFFFF';?>" style="font-size: 13px; font-face: Verdana;">
                                 <td width="30" height="24" align="center"><input type="checkbox" id="msg[<?=$m?>]" name="msg[<?=$m ?>]" value="<?=$row_in["id"] ?>"></td>

                                 <td width="150" align="center">
                                   <div align="center">
                                     <a href="javascript: window.open('viewprofile.php?id=<?=$row_in[user_to];?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($row_in["user_to"]);?></a> (<? if($user_to_accesslevel == 2){ echo "Gold"; }elseif($user_to_accesslevel == 1){ echo "Silver"; }else{ echo "Free"; } ?>)
                                   </div>
                                 </td>

								 
                                 <td width="150" align="center">
                                   <div align="center">
                                     <a href="javascript: window.open('viewprofile.php?id=<?=$row_in[user_from];?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($row_in["user_from"]);?></a> (<? if($user_from_accesslevel == 2){ echo "Gold"; }elseif($user_from_accesslevel == 1){ echo "Silver"; }else{ echo "Free"; } ?>)
                                   </div>
                                 </td>
									<?
										$sentdate=str_replace("-","/",$row_in["date_sent"]);
										$sentdate=explode(" ",$sentdate);
										$time=explode(":",$sentdate[1]);
										$tc=($time[0]>=0 && $time[0]<12)?("AM"):("PM");
									?>
                                 <td width="150" align="center"><font class="tabletext"><? echo $sentdate[0]." "; echo ($time[0]>12)?($time[0]-12):($time[0]); echo ":".$time[1]." ".$tc; ?></font></td>
                                 <td width="100" align="center"><font class="tabletext"><? if($row_in['type'] == 'F') echo 'Flirt'; else echo 'Email'; ?></font></td>
                                 <td align="center"><span onclick="document.editform.actionn.value='vw'; document.editform.mesajview.value=<?=$row_in['id']?>; document.editform.submit();" style="cursor: hand; color: blue;"><?=$row_in["subject"] ?></span></td>
                            </tr> 
							<? }?>
					</table>
				</td>
			</tr>
			</table>
			</td>
	</tr>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
				<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"><?
						if($page==1){
							echo "<font style='color:#990000'><<&nbsp;&nbsp;<</font>&nbsp;&nbsp;";
						} else {
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(1)' class='tablecateg'><<</a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page-1)."\")' class='tablecateg'><</a>&nbsp;&nbsp;";
						}
						
						for($i=$page-2; $i<=ceil($nrOfMails/$limit), $j<=4; $i++)
						{
							if($page==$i)
							{
								echo " <font style='color:#990000'>".$i."</font> ";
							} 
							elseif($i>=1 and $i<=ceil($nrOfMails/$limit))
							{ 
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
							
							$j++;
						}
						
						if($page>=ceil($nrOfMails/$limit)){
							echo "<font style='color:#990000'>>&nbsp;&nbsp;>></font>&nbsp;&nbsp;";
						} else {
							echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page+1)."\")' class='tablecateg'>></a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".(ceil($row_inbox[HOWMANY]/$limit))."\")' class='tablecateg'>>></a>";
						}
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?php echo ceil($row_inbox[HOWMANY]/$limit) ?> && <? echo $row_inbox[HOWMANY]; ?>!=0){
						pages(<?=ceil($row_inbox[HOWMANY]/$limit) ?>);}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($row_inbox[HOWMANY]/$limit) ?>){pages(<?=ceil($row_inbox[HOWMANY]/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
				</tr>
				</table>			
				</td>
			</tr>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
	<tr>
		<td valign="middle" height="22" style="padding-top:10px; "><font class="filternameblack">
		Action:
		<select name="actionn" onChange="javascript:document.editform.submit();">
			<option>-nothing-</option>
			<option value="del">Delete</option>
			<option value="rep">Reply</option>
			<option value="vw">View</option>
		</select>
		</font></td>
	</tr>
	<?
	if($_POST['actionn']=='vw')
		{
			if(isset($_POST['mesajview'])) $_POST['msg'][0] = $_POST['mesajview'];
			
			foreach($_POST['msg'] as $key=>$value)
				{
				$email = get_email($value, $tblmails);
	?>
	<tr>
		<td>
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" width="100%">
					<table width="665" border="0" cellpadding="4" cellspacing="1" align="center" class="middle-column">
                <tr><td height="5" colspan="4"></td></tr>
				<tr  class="middle-column"> 
					<td width="170"><font size="-1"><strong>Owner & Date:</strong></font></td>
					<td width="476" colspan="3"><font class="tabletext"><?php echo id_to_screenname($email["user_from"]).', '.$email["date_sent"];?></font></td>
				</tr>
                <tr><td height="5" colspan="4"></td></tr>

				<tr  class="middle-column"> 
					<td><font size="-1"><strong>Subject:</strong></font></td>
					<td colspan="3"><font class="tabletext"><?php echo $email["subject"];?></font></td>
				</tr>
                <tr><td height="5" colspan="4"></td></tr>
				<tr class="middle-column">
					<td><font size="-1"><strong>Message:</strong></font></td>
					<td><font class="tabletext"><?php echo $email["message"]; ?></font><br/><br/>
					</td>
				</tr>
			</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<?
		}
	}
	?>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>
<?php 
if($_POST['actionn']=='rep')
{
?>
<tr>
<td>
<form name="massmsg" method="post">
<input type="hidden" name="aaa" value="1">
<?php
foreach($_POST['msg'] as $key=>$value)
	{?>
<input type="hidden" name="msg[]" value="<?=$value?>">
<?php	
	}
?>
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center" class="middle-column" bgcolor="#CCCCCC" >
<!--<tr>
		<td align="center">
		<strong>Subject:</strong><br>
		<input type="text" name="subject" style="width: 350px;" />
		</td>
	</tr> -->
	<tr>
		<td align="center">
		<strong>Message:</strong><br>
		<textarea name="messg" rows="10" style="width: 350px;"></textarea>
		</td>
	</tr>
	<tr>
		<td height="10" colspan="4" align="center">
		<input type="button" value="Send" onClick="javascript:valcheck();">	
		</td>
	</tr>
</table>
</form>
<?php foreach($_POST['msg'] as $key=>$value)
				{
				$email = get_email($value, $tblmails);
	?>
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" width="100%">
					<table width="665" border="0" cellpadding="0" cellspacing="0" align="center" class="middle-column">
				<tr  class="middle-column"> 
					<td width="170" style="padding-bottom:5px "><font size="-1"><strong>Owner & Date:</strong></font></td>
					<td width="476" colspan="3" style="padding-bottom:5px "><font class="tabletext"><?php echo id_to_screenname($email["user_from"]).','.$email["date_sent"];?></font></td>
				</tr>
				<tr  class="middle-column"> 
					<td style="padding-bottom:5px "><font size="-1"><strong>Subject:</strong></font></td>
					<td colspan="3" style="padding-bottom:5px "><font class="tabletext"><?php echo $email["subject"];?></font></td>
				</tr>
				<tr class="middle-column">
					<td valign="top" style="padding-bottom:5px "><font size="-1"><strong>Message:</strong></font></td>
					<td><font class="tabletext" style="padding-bottom:5px "><?php echo $email["message"]; ?></font><br><br>
					</td>
				</tr>
			</table>
				</td>
			</tr>
			</table>
<?php
	}
 }
?>

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