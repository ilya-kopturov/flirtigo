<html>
<head>
<link rel="stylesheet" href="../default.css" type="text/css">
</head>
<body>
<form name="replyform" action="reply.php?id=<?=$_GET["id"] ?>" method="post">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Reply form </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<?
			require("cnn.php");
			//$qry="select * from tblTypeMails where Id='".$_GET["id"]."'";
				//$qry=mysql_query($qry);
				//$themail=mysql_fetch_array($qry);
			if($_POST["action"]=="add"){
			$thedate=date("Y-m-d");
			$thehour=date('h:i:s');
			$qry="insert into tblTypeMails (typeusr,SpecialId,`From`,`To`,Subject,Message,SentDate,Operator) values ('".$_POST["from"]."','".$_POST["from"].$_POST["to"]."','".$_POST["from"]."','".$_POST["to"]."','".$_POST["subject"]."','".$_POST["message"]."','".$thedate." ".$thehour."','".$_SESSION['admin']."')";
			$qry=mysql_query($qry);
			$qry="update tblTypeMails set Visualized='1' where Id='".$_GET["id"]."'";
			$qry=mysql_query($qry);
			$qry="select * from tblTypeMails where SpecialId='".$_POST["from"].$_POST["to"]."' order by Id Desc";
			$qry=mysql_query($qry);
			$qry=mysql_fetch_array($qry);
			$msg="Message with Id=".$qry["Id"]." sent!";
			?>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="center"><font class="tabletext"><?=$msg ?></font></td>
					
				</tr>
				</table>				
				</td>
			</tr>
				<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="center"><font class="tablecateg"><input type="submit" name="submit2" value="Submit" /></font></td>
				</tr>
				</table>				</td>
			</tr>
			<?
			}else{
			
				$qry="select * from tblTypeMails where Id='".$_GET["id"]."'";
				$qry=mysql_query($qry);
				$themail=mysql_fetch_array($qry);
			?>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">From:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<input type="hidden" name="from" value="<?=$themail["typeusr"] ?>" />
					<input type="hidden" name="to" value="<?=$themail["From"] ?>" />
					<input type="text" class="tabletext" name="fromi" disabled="disabled" size="35" value="<?=$themail["typeusr"] ?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">To:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="toi" size="35" disabled="disabled" value="<?=$themail["From"] ?>" /></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onMouseOver="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Subject:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="subject" size="65" value="<?="Re: ".$themail["Subject"] ?>" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onMouseOut="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Message:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><textarea class="tabletext" name="message" cols="62" rows="5"><?="\r\n\r\n\r\n\r\n"?>---- <?=$themail["From"] ?> wrote:<?="\r\n"?>><?=str_replace("\r\n","\r\n >",$themail["Message"]) ?></textarea></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(../pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" align="center"><font class="tablecateg"><input type="submit" name="submit" value="Submit" /></font></td>
				</tr>
				</table>				</td>
			</tr>
			<? } ?>
			</table>		</td>
	</tr>
</table>
</form>
</body>
</html>
  