<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Display picture:<?=$_GET['id']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0">
	<?php 
	if($_GET['app']='pic'){
	?>
	<tr>
		<td align="center" valign="middle"><img src="../pictures/userss/<?=$_GET['id']?>" border="0"></td>
	</tr>
	<? } else {?>
	<tr>
		<td align="center" valign="middle"><img src="../pictures/galleries/<?=$_GET['id']?>" border="0"></td>
	</tr>
	<? }?>
</table>
</body>
</html>
