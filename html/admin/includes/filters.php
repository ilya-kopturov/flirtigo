<?
$type_array = array("E" => "Email", "P" => "Profile", "B" => "Email and Profile");

if(isset($_POST['addword'])){
	@mysql_query("INSERT INTO `tblFilters` (`word`, `type`) VALUES ('" . addslashes(trim($_POST['word'])) . "', '" . $_POST['type'] . "')");
}

if(isset($_POST['submit_x'])){
	@mysql_query("UPDATE `tblFilters` SET `word` = '" . addslashes(trim($_POST['word'])) . "', `type` = '" . $_POST['type'] . "' 
	              WHERE `id` = '" . (int) $_POST['id'] . "'");
}

if(isset($_GET['action']) AND trim($_GET['action']) == "del" AND (int) $_GET['id'] > 0){
	@mysql_query("DELETE FROM `tblFilters` WHERE `id` = '" . (int) $_GET['id'] . "' LIMIT 1");
}
?>

<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Banned Words in Profiles and internal Emails!</font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<? 
		$ago = date("Y-m-d H:i:s", mktime( 0,0,0,date("m"),date("d")-60,date("Y")) );
		
		$qry = "SELECT * FROM `tblFilters`";
		
		$qry = mysql_query($qry);
		$nr_found=mysql_num_rows($qry);
	?>
	<tr>
	<td>
	<table style="vertical-align:top; width:1000px" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr height="25">
					<td align="center" style="width:250px"><font class="tablecateg">Add Word</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Banned in </font></td>
					<td align="center" style="width:150px"><font class="tablecateg"></font></td>
			</tr>
			<form method="post">
			<tr height="30">
					<td align="center">
					  <input type="text" name="word" value="" style="width: 240px;">
					</td>
					<td align="center">
					  <select name="type">
					   <option value="B">Email and Profile</option>
					   <option value="E">Email</option>
					   <option value="P" selected>Profile</option>
					  </select>
					</td>
					<td align="center">
					  <input type="submit" name="addword" value="Add Word">
					</td>
			</tr>
			</form>
			</table>		
			</td>
	</tr>
	
	<tr>
	  <td height="30"></td>
	</tr>
	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="3" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:250px"><img id="picScreenName" onclick="ordertabels('screenname')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Word</font></td>
					<td align="center" style="width:150px"><img id="picEmail" alt="arrows" onclick="ordertabels('email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Banned in </font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Operations</font></td>
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
			<form method="post">
			<input type="hidden" name="id" value="<?=$theaccount['id'];?>">
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="center">
					  <input type="text" name="word" value="<?=$theaccount['word'];?>" style="width: 240px;">
					</td>
					<td align="center">
					  <select name="type">
					   <option value="B" <? if($theaccount['type'] == "B") echo "selected";?> >Email and Profile</option>
					   <option value="E" <? if($theaccount['type'] == "E") echo "selected";?> >Email</option>
					   <option value="P" <? if($theaccount['type'] == "P") echo "selected";?> >Profile</option>
					  </select>
					</td>
					<td align="center">
					  <input type="image" name="submit" src="images/save_button.gif"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <a href="#"><img alt="Delete Word" border="0" src="images/button_drop.gif" width="16" height="16" onclick="this.style.cursor='hand'; this.style.cursor='pointer'; javascript: if(confirm('Are you sure you want to delete this word?')){ document.location.href='index.php?content=filters&action=del&id=<?=$theaccount[id];?>' }" /></a>
					</td>
			</tr>
			</form>
			<?
				}
			?>
			<tr>
				<td colspan="3" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
	
</table>

<script language="JavaScript">
	if(document.getElementById('filters1').style.display == 'none'){
		document.getElementById('filters1').style.display = '';
	}
	if(document.getElementById('filters2').style.display == 'none'){
		document.getElementById('filters2').style.display = '';
	}
</script>