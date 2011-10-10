<link rel="stylesheet" href="../default.css" type="text/css">
<?
		function get_id_sender($sender)
	{
		$sql = "SELECT `Id` FROM `tblUsers` WHERE `ScreenName`='".$sender."'";
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_array($query);
		
		return $result["Id"];
	
	}
		function get_emails()
	{
		$sql = "(select `Id` from `tblTypeMails` where `To`='".$_SESSION['name']."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00') union (select `Id` from `tblMails` where `To`='".$_SESSION['name']."' and `Visualized`='0' and `Trash` = '0000-00-00 00:00:00') ";
		$query = mysql_query($sql) or die(mysql_error());
		
		$emails = array();
		
		while ($result = mysql_fetch_array($query))
			array_push($emails, $result["Id"]);
			
		return $emails;						
	}
		function get_email($id)
	{
		$sql = "(select * from `tblTypeMails` where `Id`=".$id.") union (select * from `tblMails` where `Id`=".$id.")";
		$query = mysql_query($sql) or die(mysql_error());
		return mysql_fetch_array($query);					
	}
$email = get_email($_GET["id"]);
$sender = get_id_sender($email["From"]);
?>
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
<form name="editform" method="post" action="#">
<input type="hidden" name="id" value="<?=$_GET["id"] ?>" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td width="100%"><font class="pagetitle">Reply Mail</font></td>
	</tr>
	<!-- Page title line -->
	<!-- Page content line -->
	<tr>
		<td></td>
	</tr>
	<tr>
		<td valign="top">
		<p class="tabletext">
		<strong>Message</strong>:<br>
		<textarea name="RMessage" rows="10" cols="70"></textarea>
		</p>
				<p class="tabletext"><strong>Owner & Date</strong>:	<?php echo $email["From"];?> <?php echo $email["SentDate"];?><br>
				<strong>Subject</strong>:	<?php echo $email["Subject"];?><br>
				<strong>Message</strong>:	<?php echo $email["Message"]; ?></p>
		<input type="button" class="admin_button1" onClick="JavaScript:document.location.href='index.php?content=mailbox&goto=inbox&to=<?php echo $_GET['id']?>'" value="Back">
		</td>
	</tr>	

	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>