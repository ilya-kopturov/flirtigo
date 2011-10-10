<?php
if (intval($_SESSION['limit'])==0)
	{
	$_SESSION['limit']=5;
	} else 
		{
		$_SESSION['limit']=$_POST['limit'];
		}
$qry="select `ScreenName` from `tblUsers` where `Id`='".$_GET["id"]."'";
$qry=mysql_query($qry);
$theuser=mysql_fetch_array($qry);
mysql_free_result($qry);
$sender = get_id_sender($email["From"]);
if($_POST['actionn']=='del')
	{
	foreach($_POST['msg'] as $key=>$value)
		{
			mysql_query("DELETE FROM `tblTypeMails` WHERE `Id`='".$value."'");
			mysql_query("DELETE FROM `tblMails` WHERE `Id`='".$value."'");
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
<form name="form2" method="post">
<table cellpadding="0" cellspacing="0" style="width:100%">
	<tr>
		<td align="left" width="50%"><font class="tablename"></td>
		<td align="right" width="50%"><font class="filternameblack">Entries per page:
		<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
		</select></font></td>
	</tr>
</table>
</form>
<form name="editform" method="post" action="index.php?content=viewoutbox&id=<?php echo $_GET["id"] ?>">
<input type="hidden" name="action" value="" />
<input type="hidden" name="id" value="<?php echo $_GET["id"] ?>" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	

	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Outbox for <?=$theuser['ScreenName']?></font></td>
	</tr>
	<tr>
		<td width="100%"><font class="pagetitle"><input type="button" name="view" value="User Profile" onClick="javascript:document.location.href='index.php?content=viewuser&id=<?=$_GET['id']?>'">&nbsp;&nbsp;
		<input type="button" name="inbox" value="View Inbox" onClick="javascript:document.location.href='index.php?content=viewinbox&id=<?=$_GET['id']?>'"></font></td>
	</tr>
	<?php
	$qry_inbox=mysql_query("SELECT max( `SentDate` ) AS `wee` , `tblMails`. * FROM `tblMails` WHERE `From`='".$theuser['ScreenName']."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00' GROUP BY `To` ORDER BY `wee` DESC");
	$x=mysql_affected_rows();
	$row_inbox=mysql_fetch_array($qry_inbox);
	mysql_free_result($qry_inbox);
	?>
	<tr>
		<td width="100%"><font class="pagetitle">Messages in <b>Outbox</b>:&nbsp;&nbsp;<?=$x?></font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
			<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
				<tr valign="middle">
					<td valign="middle" height="22"><font class="filternameblack"><?php echo $_GET["msg"] ?></font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
<!-- 				<tr>
					<td height="3" bgcolor="#990000" width="100%"></td>
				</tr> -->
				<tr>
					<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								  <td width="30" height="24" align="center"><input type="checkbox" name="selectAll" onclick="checkAll()"></td>
								  <td width="30" align="center" class="middle-column-b"><strong>Read</strong></td>
								  <td width="120" align="center" class="middle-column-b"><strong>Sent To</strong></td>
								  <td width="120" align="center" class="middle-column-b"><strong>Date</strong></td>
								  <td align="center" class="middle-column-b"><strong>Subject</strong></td>
							   </tr>
							   <?php
							   $qry_in=mysql_query("SELECT max( `SentDate` ) AS `wee` , `tblMails`. * FROM `tblMails` WHERE `From`='".$theuser['ScreenName']."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00' GROUP BY `To` ORDER BY `wee` DESC limit ".intval($_SESSION['limit'])."");
							   while($row_in=mysql_fetch_array($qry_in)){
							   ?>
							   <tr>
									 <td width="30" height="24" align="center"><input type="checkbox" name="msg[<?=$m?>]" value="<?=$row_in["Id"] ?>"></td>
									 <td width="30" align="center"><div align="center"><a href="index.php?back=out&content=readmail&id=<?=$row_in["Id"] ?><?=($row_in["typeusr"]=="")?("&t=0"):("&t=1") ?>" class="middle-column-line2"><img src="../Site1/images/readmail.gif" align="absmiddle" border="0"></a></div></td>
									 <td width="120" align="center"><div align="center"><a href="index.php?content=viewuser&id=<?php echo get_user_id($row_in["To"]); ?>" class="middle-column-line2">
									   <font class="tabletext"><?=$row_in["To"] ?></font>
									   </a></div>
									 </td>
										<?php
											$sentdate=str_replace("-","/",$row_in["SentDate"]);
											$sentdate=explode(" ",$sentdate);
											$time=explode(":",$sentdate[1]);
											$tc=($time[0]>=0 && $time[0]<12)?("AM"):("PM");
										?>
									 <td width="120" align="center"><div align="center"><font class="tabletext"><? echo $sentdate[0]." "; echo ($time[0]>12)?($time[0]-12):($time[0]); echo ":".$time[1]." ".$tc; ?></font></div></td>
									 <td align="center"><div align="center"><a href="index.php?back=out&content=readmail&id=<?=$row_in["Id"] ?><?=($row_in["typeusr"]=="")?("&t=0"):("&t=1") ?>" target="_blank" class="middle-column-line2">
									   <!-- <a href="index.php?content=readmail&id=<?php echo $row_in["Id"]; ?>"> -->
									   <font class="tabletext">	<?=$row_in["Subject"] ?></font>
									   </a>
									 </div>
									 </td>
								</tr> 
							<? 
							}
							mysql_free_result($qry_in);
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	
	<?php
	if($_POST['actionn']=='vw')
		{
			foreach($_POST['msg'] as $key=>$value)
				{
				$email = get_email($value);
	?>
	<tr>
		<td>
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25"  width="100%">
					<table width="665" border="0" cellpadding="4" cellspacing="1" align="center" class="middle-column">
				<tr  class="middle-column"> 
					<td width="135"><font size="-1"><strong>Owner & Date:</strong></font></td>
					<td width="511" colspan="3"><font class="tabletext"><?php echo $email["From"].','.$email["SentDate"];?></font></td>
				</tr>
				<tr  class="middle-column"> 
					<td><font size="-1"><strong>Subject:</strong></font></td>
					<td colspan="3"><font class="tabletext"><?php echo $email["Subject"];?></font></td>
				</tr>
				<tr class="middle-column">
					<td valign="top"><font size="-1"><strong>Message:</strong></font></td>
					<td><font class="tabletext"><?php echo $email["Message"]; ?></font><br/><br/>
					</td>
				</tr>
			</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<?php
		}
	}
	?>
</table>
</form>
<?php 
if($_POST['actionn']=='rep')
		{
?>
<form name="massmsg" method="post">
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center" class="middle-column" bgcolor="#CCCCCC" >
	<tr>
		<td align="center">
		<strong>Message:</strong><br>
		<textarea name="messg" cols="80" rows="10"></textarea>
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
				$email = get_email($value);
	?>
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25"  width="100%">
					<table width="665" border="0" cellpadding="0" cellspacing="0" align="center" class="middle-column">
				<tr  class="middle-column"> 
					<td width="135" style="padding-bottom:5px; "><font size="-1"><strong>Owner & Date:</strong></font></td>
					<td width="511" colspan="3" style="padding-bottom:5px; "><font class="tabletext"><?php echo $email["From"].','.$email["SentDate"];?></font></td>
				</tr>
				<tr  class="middle-column"> 
					<td style="padding-bottom:5px; "><font size="-1"><strong>Subject:</strong></font></td>
					<td colspan="3" style="padding-bottom:5px; "><font class="tabletext"><?php echo $email["Subject"];?></font></td>
				</tr>
				<tr class="middle-column">
					<td valign="top" style="padding-bottom:5px; "><font size="-1"><strong>Message:</strong></font></td>
					<td><font class="tabletext" style="padding-bottom:5px; "><?php echo $email["Message"]; ?></font><br/><br/>
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