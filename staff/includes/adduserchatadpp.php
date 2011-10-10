<script language="javascript">
function valcheck()
{
   var msg = "";

  if (document.form2.username.value == "")
     msg += "Enter Username \n"
  if (document.form2.password.value == "")
     msg += "Enter Password \n"
  if (document.form2.isforchat.checked == false && document.form2.isforapprove.checked == false && document.form2.isforvideo.checked == false && document.form2.isforpicture.checked == false)
     msg += "Enter What is for Chat/Profiles Approval/Picture Approval/Video Approval \n"

  if (msg != "")
     {
	    alert(msg);
		return false;
	 }
 else
       document.form2.submit();
     
}
</script>
<? 
if($_POST['ispost'] == 1)
	{
		$is_there = @mysql_num_rows(mysql_query("SELECT `id` FROM `tblAdmin` WHERE `user` =  '" . $_POST['username'] ."'"));
	    
		if($_POST['username'] AND $_POST['password'] AND ($_POST['isforchat'] == 1 OR $_POST['isforapprove'] == 1 OR $_POST['isforpicture'] == 1 OR $_POST['isforvideo'] == 1) AND !$is_there)
		{
			mysql_query("INSERT INTO `tblAdmin` (`user`,`pass`,`activ`,`main`,`chat`,`isforchat`,`isforapproval`,`isforpicture`,`isforvideo`)
							             VALUES ('".$_POST['username']."','".$_POST['password']."',1,1,1,'". (int) $_POST['isforchat']."','". (int) $_POST['isforapprove']."','". (int) $_POST['isforpicture']."','". (int) $_POST['isforvideo']."')");
			if(mysql_affected_rows() > 0){
				$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>User Added Succesfully!</span>";
			}else{
				$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>Error:" . mysql_error() . "</span>";
			}
		} else {
			$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>ERROR: User ALLREADY in database!</span>";
		}
	}
?>
<form name="form2"  method="post">
<input type="hidden" name="ispost" value="1">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Add User </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table width="100%"  cellpadding="0" cellspacing="0" >
		<tr height="50">
			<td colspan="3" style="text-align:center "><?=$msg?></td>
		</tr>
		<tr>
			<td width="25%"  a style="padding-left:70px; padding-top:10px; text-align:center"><font style="color: black;" class="tablename">&nbsp;Username</font></td>
			<td width="26%"  align="left" style="padding-top:10px"><input type="text" name="username" style="width: 150px;"></td>
			<td width="49%"  align="left" style="padding-top:10px"><input type="checkbox" name="isforchat" value="1"><font style="color: black;" class="tablename">Is for chat</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename">&nbsp;Password</font></td>
			<td align="left" ><font class="filternameblack"><input type="text" name="password" style="width: 150px;"></font></td>
			<td width="49%"  align="left" style="padding-top:10px"><input type="checkbox" name="isforapprove" value="1"><font style="color: black;" class="tablename">Is for approve profiles</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename"></font></td>
			<td align="left"></td>
			<td width="49%" align="left" style="padding-top:10px"><input type="checkbox" name="isforpicture" value="1"><font style="color: black;" class="tablename">Is for approve pictures</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename"></font></td>
			<td align="left"></td>
			<td width="49%" align="left" style="padding-top:10px"><input type="checkbox" name="isforvideo" value="1"><font style="color: black;" class="tablename">Is for approve videos</font></td>
		</tr>
		<tr height="105px;">
			<td colspan="3"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input style="width: 200px; height: 35px;" type="button" value="Add User" onClick="javascript:valcheck();"></td>
		</tr>
		</table>
		</td>
	</tr>
	

</table>
</form>