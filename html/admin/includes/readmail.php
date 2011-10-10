<?php
if($_GET['back']=='out')
	{
	$back='viewoutbox';
	$userid=get_id_sender($email["From"]);
	} else {
			if($_GET['back']=='in')
				{
				$back='viewinbox';
				}
			}
$email = get_email($_GET["id"]);
$sender = get_id_sender($email["From"]);
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
<form name="editform" method="post" action="index.php?content=viewuser&id=<?=$_GET["id"] ?>">
<input type="hidden" name="action" value="" />
<input type="hidden" name="id" value="<?=$_GET["id"] ?>" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td width="100%"><font class="pagetitle">Read Mail</font></td>
	</tr>
	<!-- Page title line -->
	<!-- Page content line -->
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
			<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
				<tr valign="middle">
					<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
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
				<tr>
					<td height="3" bgcolor="#990000" width="100%"></td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">
						<table width="565" border="0" cellpadding="4" cellspacing="1" align="center" class="middle-column" bgcolor="#000000">
							<tr class="middle-column"> 
								<td width="100" bgcolor="#FFFFFF"><strong>From:</strong></td>
								<td align="left" bgcolor="#FFFFFF"><a href="index.php?content=viewuser&id=<?php echo $sender; ?>" class="middle-column"><font class="tabletext"><?php echo $email["From"];?></font></a></td>
							</tr>
							<tr  class="middle-column"> 
								<td bgcolor="#FFFFFF"><strong>Date:</strong></td>
								<td colspan="3" bgcolor="#FFFFFF"><font class="tabletext"><?php echo $email["SentDate"];?></font></td>
							</tr>
							<tr  class="middle-column"> 
								<td bgcolor="#FFFFFF"><strong>Subject:</strong></td>
								<td  bgcolor="#FFFFFF" colspan="3"><font class="tabletext"><?php echo $email["Subject"];?></font></td>
							</tr>
							<tr class="middle-column">
								<td bgcolor="#FFFFFF" height="100" colspan="4" valign="top"><strong>Message:</strong><br><br>
								<font class="tabletext"><?php echo $email["Message"]; ?></font><br/><br/>
								</td>
							</tr>
							<tr>
				  				<td bgcolor="#FFFFFF" colspan="4" valign="top"><input type="button" class="admin_button1" onClick="JavaScript:document.location.href='index.php?content=<?php echo $back;?>&id=<?php echo $sender;?>'" value="Back"></td>
				  			</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>