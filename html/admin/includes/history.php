<html>
<head>
<link rel="stylesheet" href="../default.css" type="text/css">
</head>
<body>
<?
	require("cnn.php");
	$qry="select * from tblTypeMails where SpecialId='".$_GET["specialid"]."' order by Id Desc";
	$qry.=($_GET["limit"])?(" limit ".($_GET["limit"]+1)):("");
	$qry=mysql_query($qry);
	$nrmails=mysql_num_rows($qry);
	$themail=mysql_fetch_array($qry);
?>
<form name="replyform" action="reply.php" method="post">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0" bgcolor="#FFFFFF">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Mail history </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
	<td>
	<table style="vertical-align:top; width:610px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:120px"><font class="tablecateg">From</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">To</font></td>
					<td align="center" style="width:120px"><font class="tablecateg">Subject</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Mesage</font></td>
					<td align="center" style="width:50px"><font class="tablecateg">Date</font></td>
					<td align="center" style="width:50px"><font class="tablecateg">Operator</font></td>	
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=1; $i<$nrmails; $i++){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				$theaccount=mysql_fetch_array($qry);
			?>
			<tr onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["From"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["To"] ?></font>&nbsp;</td>
					<td align="left"><font class="tabletext"><textarea disabled="disabled" cols="15" rows="5" class="tabletext"><?=$theaccount["Subject"] ?></textarea></font></td>
					<td align="center"><font class="tabletext"><?=$theaccount["SentDate"] ?></font></td>
					<td align="center" valign="middle"><font class="tabletext"><textarea disabled="disabled" cols="35" rows="5" class="tabletext"><?=$theaccount["Message"] ?></textarea></font></td>
					<td align="center"><font class="tabletext"><? $theoperator=mysql_fetch_array(mysql_query("select * from tblAdmin where Id='".$theaccount["Operator"]."'")); echo $theoperator["User"]; ?></font></td>
			</tr>
			
			<?
				}
			?>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="9" height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="left"></td>
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
</table>
</form>
</body>
</html>
  