<?php


if (isset($_POST['submit'])) {
	mysql_query(
		"UPDATE
			`tblsettings`
		SET
			`value` = '" . addslashes($_POST['value']) . "'
		WHERE
			`key` = '" . addslashes($_POST['key']) . "'"
	);
}


$result = mysql_query(
	"SELECT
		*
	FROM
		tblsettings"
);


$settings = array();
while ($row = mysql_fetch_assoc($result)) {
	$settings[$row['key']] = stripslashes($row['value']);
}


?>

<table style="vertical-align:top" align="center" height="20" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td><font class="pagetitle">Base settings</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top;" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="1">
				<tr>
					<td width="100%" align="right"></td>
				</tr>
				</table>			
				</td>
			</tr>
			<form action="" method="post">
			<tr bgcolor="#FFFFFF">
				<td width="200">
					&nbsp;<font class="tabletext">Admin area start page:</font>
				</td>
				<td width="250">
					<input type="hidden" name="key" value="admin_start_page" />
					<input type="text" name="value" style="width: 250px;" value="<?=  htmlentities($settings['admin_start_page']) ?>" />
				</td>
				<td width="70">
					<input type="submit" name="submit" value="Save">
				</td>
			</tr>
			</form>
			<tr>
				<td colspan="99" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="right"></td>
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
	<tr>
		<td height="10"></td>
	</tr>
</table>


<script language="JavaScript">
	if(document.getElementById('settings1').style.display == 'none'){
		document.getElementById('settings1').style.display = '';
	}
</script>