<?
if(isset($_POST['addcode'])){
	@mysql_query("INSERT INTO `tblPromCode` (`code`,`ls_6`,`ls_3`,`ls_1`,`dr_1`) 
	                                 VALUES ('" . addslashes(trim($_POST['code'])) . "', 
	                                         '" . $_POST['ls_6'] . "', 
	                                         '" . $_POST['ls_3'] . "', 
	                                         '" . $_POST['ls_1'] . "', 
	                                         '" . $_POST['dr_1'] . "')");
}

if(isset($_POST['submit_x'])){
	@mysql_query("UPDATE `tblPromCode` SET `code` = '" . addslashes(trim($_POST['code'])) . "', 
	                                       `ls_6` = '" . $_POST['ls_6'] . "', 
	                                       `ls_3` = '" . $_POST['ls_3'] . "', 
	                                       `ls_1` = '" . $_POST['ls_1'] . "', 
	                                       `dr_1` = '" . $_POST['dr_1'] . "' 
	              WHERE `id` = '" . (int) $_POST['id'] . "'");
}

if(isset($_GET['action']) AND trim($_GET['action']) == "del" AND (int) $_GET['id'] > 0){
	@mysql_query("DELETE FROM `tblPromCode` WHERE `id` = '" . (int) $_GET['id'] . "' LIMIT 1");
}
?>

<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Promotional Codes</font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<? 
		$ago = date("Y-m-d H:i:s", mktime( 0,0,0,date("m"),date("d")-60,date("Y")) );
		
		$qry = "SELECT * FROM `tblPromCode`";
		
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
					<td align="center" style="width:110px; font-size: 10px; font-weight: bold;">Add Code</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(6 months)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(3 months)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(1 month)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Silver Member<br>(1 month)</td>
					<td align="center" style="width:100px; font-size: 10px; font-weight: bold;"></td>
			</tr>
			<form method="post">
			<tr height="30">
					<td align="center"><input type="text" name="code" value="" style="width: 110px;" maxlength="15"></td>
					<td align="center"><input type="text" name="ls_6" value="" style="width: 75px;" maxlength="5"></td>
					<td align="center"><input type="text" name="ls_3" value="" style="width: 75px;" maxlength="5"></td>
					<td align="center"><input type="text" name="ls_1" value="" style="width: 75px;" maxlength="5"></td>
					<td align="center"><input type="text" name="dr_1" value="" style="width: 75px;" maxlength="5"></td>
					<td align="center"><input type="submit" name="addcode" value="Add Code"></td>
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
				<td colspan="6" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:110px; font-size: 10px; font-weight: bold;">Code</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(6 months)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(3 months)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Gold Member<br>(1 month)</td>
					<td align="center" style="width:85px; font-size: 10px; font-weight: bold;">Silver Member<br>(1 month)</td>
					<td align="center" style="width:100px; font-size: 10px; font-weight: bold;"></td>
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
					<td align="center"><input type="text" name="code" value="<?=$theaccount['code'];?>" style="width: 110px;" maxlength="15"></td>
					<td align="center"><input type="text" name="ls_6" value="<?=$theaccount['ls_6'];?>" style="width:  75px;" maxlength="5" ></td>
					<td align="center"><input type="text" name="ls_3" value="<?=$theaccount['ls_3'];?>" style="width:  75px;" maxlength="5" ></td>
					<td align="center"><input type="text" name="ls_1" value="<?=$theaccount['ls_1'];?>" style="width:  75px;" maxlength="5" ></td>
					<td align="center"><input type="text" name="dr_1" value="<?=$theaccount['dr_1'];?>" style="width:  75px;" maxlength="5" ></td>
					<td align="center">
					  <input type="image" name="submit" src="images/save_button.gif"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <a href="#"><img alt="Delete Code" border="0" src="images/button_drop.gif" width="16" height="16" onclick="this.style.cursor='hand'; this.style.cursor='pointer'; javascript: if(confirm('Are you sure you want to delete this code?')){ document.location.href='index.php?content=promcode&action=del&id=<?=$theaccount[id];?>' }" /></a>
					</td>
			</tr>
			</form>
			<?
				}
			?>
			<tr>
				<td colspan="6" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
	
</table>

<script language="JavaScript">
	if(document.getElementById('promotion1').style.display == 'none'){
		document.getElementById('promotion1').style.display = '';
	}
	if(document.getElementById('promotion2').style.display == 'none'){
		document.getElementById('promotion2').style.display = '';
	}
</script>