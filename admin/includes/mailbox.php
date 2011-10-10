<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
<link rel="stylesheet" href="../default.css" type="text/css">
<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
	<tr>
			<td height="100%" valign="top" bgcolor="#FFFFFF">
				<table width="770" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td  style="padding-left:10px;">
						
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                    <td height="24"><strong>Mail Box</strong></td>
                </tr>
                 <tr>
                     <td height="20"></td>
                 </tr>
                <tr>
		            <td valign="top">
                    
			           
<?php	
	if (isset($_POST) && (sizeof($_POST) > 0))		trash_emails($_POST);
############################# GET MAILS ################################
	//if ($_GET['goto'] == 'inbox')
	$sn = get_screen_name($_GET["to"]);
	$qry="(select * from `tblTypeMails` where `To`='".$sn."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00') union 
	(select * from `tblMails` where `To`='".$sn."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00') order by `SentDate` Desc";	
	if ($_GET['goto'] == 'sent')
	$qry="(select * from `tblTypeMails` where `From`='".$sn."') union 
	(select * from `tblMails` where `From`='".$sn."') order by `SentDate` Desc";	
	echo $qry;
	$qry=mysql_query($qry);
	$nrmails=mysql_num_rows($qry);
########################################################################			
?>
 <script language="JavaScript">
			            <!--
			function checkAll()	{
				var cbs = document.forms["mailbox"].elements;
    			if(cbs) {
			        if(cbs.length) {
			            for (var i=0; i<cbs.length; i++) {       
			                cbs[i].checked = document.forms["mailbox"].elements["selectAll"].checked;
			            }
			        }
			        else {
			           cbs.checked = document.forms["mailbox"].elements["selectAll"].checked;
			        }
			    }
			}
			//-->
			</script>
 <form action="index.php?content=mailbox&goto=trash" method="post" name="mailbox" id="mailbox">
 	<input type="hidden" name="id_user" id="id_user" value="<?php echo isset($_POST['id_user'])?$_POST['id_user']:$_GET['to']; ?>" />
	
	
	
	
   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        		<tr>
        		  <td>
        		    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        		      	<tr>
        		        	<td><img src="images/small_mail.gif" alt="" width="16" height="15" border="0">&nbsp;<?php $user = isset($_POST['id_user'])?$_POST['id_user']:$_GET["to"]; echo get_screen_name($user); ?></td>
						</tr>
        		      	<tr>
        		        	<td>&nbsp;&nbsp;<a href="index.php?content=mailbox&goto=inbox&to=<?php echo $_GET["to"]; ?>" class="middle-column-line2"><img src="images/small_inbox.gif" alt="" width="22" height="20" border="0">&nbsp;<?php echo (($_GET['goto']=='inbox') || (!isset($_GET)))?'<strong style="color:#000000">Inbox</font></strong>':'<font style="color:#000000"> Inbox'; ?>&nbsp;</a></td>
                        </tr>
        		      	<tr>
        		        	<td>&nbsp;&nbsp;<a href="index.php?content=mailbox&goto=sent&to=<?php echo $_GET["to"]; ?>" class="middle-column-line2"><img src="images/small_sent.gif" alt="" width="22" height="20" border="0">&nbsp;<span class="style1"><?php echo $_GET['goto']=='sent'?'<strong>Sent</strong>':'Sent'; ?></span></a></td>
                        </tr>
        		      	</table>                    
					</td>
					<td colspan="4" valign="baseline">&nbsp;</td>
      		  </tr> 
                <tr>
                  <td colspan="5" height="10"></td>
                </tr>       
								<tr>
								  <td colspan="5" height="24" background="images/mailtop.gif">
										<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#000000" class="tablecateg">
										  <tr bgcolor="#CCCCCC">
												<td width="36" align="center"></td>
												<td width="278" align="center">Sender</td>
												<td width="166" align="center">Date</td>
												<td width="275" align="center">Subject</td>
												<td></td>
										  </tr>
											<? for($m=0;$m<$nrmails;$m++){$mail=mysql_fetch_array($qry);?>
											<tr>
												<td bgcolor="#FFFFFF" align="center"><input type="checkbox" name="tblTypeMailsId"></td>
												<td bgcolor="#FFFFFF" width="278" align="center">
													<a href="index.php?content=viewuser&id=<?php echo get_user_id($mail["From"]); ?>" class="middle-column-line2">
													<font style="color:#000000"><?=$mail["From"] ?></font></a></td>
													<? $sentdate=str_replace("-","/",$mail["SentDate"]);$sentdate=explode(" ",$sentdate);
													$time=explode(":",$sentdate[1]);$tc=($time[0]>=0 && $time[0]<12)?("AM"):("PM");?>
												<td width="166" align="center" bgcolor="#FFFFFF"><? echo $sentdate[0]." "; echo ($time[0]>12)?($time[0]-12):($time[0]); echo ":".$time[1]." ".$tc; ?></td>
												<td align="center" bgcolor="#FFFFFF" ><a href="index.php?content=readmail&id=<?=$mail["Id"] ?><?=($mail["typeusr"]=="")?("&t=0"):("&t=1") ?>" class="middle-column-line2"><font style="color:#000000"> <?=$mail["Subject"] ?></font></a></td>
												<td align="center" bgcolor="#FFFFFF" ><a href="index.php?content=processMessages&id=<?=$mail["Id"] ?>" >reply</a></td>
											</tr> 
											<? } ?>                
										</table>
										<p>&nbsp;</p>
										<?php
										if($_GET['goto']=='inbox')
										{
										?>
										Action: 
										<select name="MailAction" onChange="JavaScript:document.location.href='index.php?content=processMessages&id=1'">
											<option value="">-nothing-</option>
											<option value="Reply">Reply</option>
											<option value="Delete">Delete</option>
											<option value="View">View</option>
										</select>
										<?php 
										}
										?>
								  </td>
                                </tr>
			</table>
	</form>		</td>
	</tr>
	
    <tr>
      <td height="20"></td>
    </tr>
    <tr>
      <td height="6" background="images/bottomw2.gif"></td>
    </tr>
</table>
</td>
				</tr>

			</table>
		</td>
	</tr>
</table>





