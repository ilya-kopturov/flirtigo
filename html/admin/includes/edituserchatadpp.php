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
if($_POST['ispost']==1)
	{
		mysql_query("UPDATE tblAdmin SET `user`='".$_POST['username']."',`pass`='".$_POST['password']."',
		 								`isforchat`='".$_POST['isforchat']."',`isforapproval`='".$_POST['isforapprove']."',`isforpicture`='".$_POST['isforpicture']."',`isforvideo`='".$_POST['isforvideo']."' 
										WHERE `id` = '".$_GET['id']."'");
		if(mysql_affected_rows() >= 0){
			$msg="Edited Succesfully!";
		}else{
			$msg="ERROR: " . mysql_error();
		}
	}

$qry_sel=mysql_query("SELECT * FROM tblAdmin WHERE `id` = ".$_GET['id']."");
$row_sel=mysql_fetch_array($qry_sel);

?>
<form name="form2"  method="post">
<input type="hidden" name="ispost" value="1">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Edit User </font></td>
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
			<td width="26%"  align="left" style="padding-top:10px"><input type="text" name="username" style="width: 150px;" value="<?=$row_sel['user']?>"></td>
			<td width="49%"  align="left" style="padding-top:10px"><input type="checkbox" name="isforchat" value="1" <?if($row_sel['isforchat']==1) echo "checked";?>><font style="color: black;" class="tablename">Is for chat</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename">&nbsp;Password</font></td>
			<td align="left" ><font class="filternameblack"><input type="text" name="password" style="width: 150px;" value="<?=$row_sel['pass']?>"></font></td>
			<td width="49%"  align="left" style="padding-top:10px"><input type="checkbox" name="isforapprove" value="1"  <?if($row_sel['isforapproval']==1) echo "checked";?>><font style="color: black;" class="tablename">Is for approve profiles</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename"></font></td>
			<td align="left"></td>
			<td width="49%" align="left" style="padding-top:10px"><input type="checkbox" name="isforpicture" value="1"  <?if($row_sel['isforpicture']==1) echo "checked";?>><font style="color: black;" class="tablename">Is for approve pictures</font></td>
		</tr>
		<tr>
			<td style="padding-left:70px;text-align:center"><font style="color: black;" class="tablename"></font></td>
			<td align="left"></td>
			<td width="49%" align="left" style="padding-top:10px"><input type="checkbox" name="isforvideo" value="1"  <?if($row_sel['isforvideo']==1) echo "checked";?>><font style="color: black;" class="tablename">Is for approve videos</font></td>
		</tr>
		<tr height="105px;">
			<td colspan="3"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input style="width: 200px; height: 35px;" type="button" value="Edit User" onClick="javascript:valcheck();"></td>
		</tr>
		</table>
		</td>
	</tr>
	

</table>
  </form>