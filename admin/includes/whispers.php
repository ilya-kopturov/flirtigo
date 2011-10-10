<?php
		
	function get_whispers()
	{
		$sql = "SELECT * FROM `tblWhispers` ORDER BY `id` ASC";
		$query = mysql_query($sql) or die(mysql_error());
		$found = array();
		while ($result = mysql_fetch_array($query))
			$found[] = $result;
		return $found;		
	}
	function add_whisper($text, $picture)
	{
		if(is_uploaded_file($picture) and isset($picture))
		{
			$sql = "INSERT INTO `tblWhispers`(`whisper`) VALUES('".addslashes($text)."')";
			$query = mysql_query($sql) or die(mysql_error());
			$pic = mysql_insert_id();
			move_uploaded_file($picture,"/home/httpd/vhosts/flirtigo.com/html/images/" . $pic . ".gif");
		}
	}
	
	
	function delete_whisper($whisper)
	{
		$sql = "DELETE FROM `tblWhispers` WHERE `id`=".$whisper;
		$query = mysql_query($sql) or die(mysql_error());					
	}
	
	
	function update_whisper($whisper, $text)
	{
		$sql = "UPDATE `tblWhispers` SET `whisper`='".addslashes($text)."' WHERE `id`=".$whisper;
		$query = mysql_query($sql) or die(mysql_error());				
	}
	
	
	if (isset($_POST['action']))	
	{
		switch ($_POST['action'])
		{	
			case 'add':		add_whisper($_POST['whisper'], $_FILES['whisper_picture']['tmp_name']);	break;
			case 'delete':	delete_whisper($_POST['id']);				break;			
			case 'edit':	update_whisper($_POST['id'], $_POST['ut']);	break;
			default:	break;
				
		}	
	}
		
	$whispers = get_whispers();
	$nr_whispers = sizeof($whispers);
			
?>



<script type="text/javascript" language="javascript">
<!--
	function verifica()
	{
		if (document.getElementById("whisper").value != "")
		{
			document.getElementById("action").value = "add";
			document.getElementById("formular").submit();
		}
		else
		{
			alert("Please type a text for this whisper");
			document.getElementById("whisper").focus();			
		}
	}		
	
	function delete_whisper(whisper)
	{
		if (confirm("Are you sure you want to delete this whisper?"))
		{
			document.getElementById("action").value = "delete";
			document.getElementById("id").value = whisper;
			document.getElementById("formular").submit();
		}	
	}
	
	function update_whisper(whisper)
	{
		var temp = "whisper_" + whisper;
						
		if (document.getElementById(temp).value != "")
		{
			document.getElementById("action").value = "edit";
			document.getElementById("id").value = whisper;
			document.getElementById("ut").value = document.getElementById(temp).value;
			document.getElementById("formular").submit();
		}
		else
		{
			alert("Please type a text for this whisper");
			document.getElementById(temp).focus();			
		}			
	}
-->
</script>

<form enctype="multipart/form-data" name="formular" id="formular" method="post" action="index.php?content=whispers">
<input type="hidden" name="action" id="action" value="add" />
<input type="hidden" name="id" id="id" value="" />
<input type="hidden" name="ut" id="ut" value="" />

<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Manage whispers </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>

<?php
	if ($nr_whispers > 0)
	{
?>
	<tr>
		<td><font class="tablename"><?php echo $nr_whispers; ?> whisper<?php echo ($nr_whispers > 1)?'s':''; ?> found</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:800px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:550px"><font class="tablecateg">Whisper</font></td>
					<td align="center" style="width:250px"><font class="tablecateg">Action</font></td>
					
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=0; $i<$nr_whispers; $i++)
				{									
					if($tdcolor=="#f2f2f2")
					{
						$tdcolor="#FFFFFF";
					} 
					else 
					{
						$tdcolor="#f2f2f2";
					}
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?php echo $tdcolor ?>'" style="background-color:<?php echo $tdcolor ?>">
					<td align="center" style="padding: 1px 1px 1px 1px;">
					<img src="/images/<?php echo $whispers[$i]["id"];?>.gif">&nbsp;
					<font class="tabletext">
					<input type="text" class="tabletext" name="whisper[<?php echo $whispers[$i]["id"] ?>]" id="whisper_<?php echo $whispers[$i]["id"] ?>" size="95" value="<?php echo $whispers[$i]["whisper"] ?>" /></font></td>
					<td align="center"><font class="tabletext">
					<input type="button" name="Delete" value="Delete" onclick="javascript: delete_whisper('<?=$whispers[$i]["id"];?>')">
					<input type="button" name="Update" value="Update" onclick="javascript: update_whisper('<?=$whispers[$i]["id"];?>')">
					</font></td>
			</tr>
			
			<?
				}
			?>
			<tr>
				<td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
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

<?php
	}
?>	
	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">Add whisper</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext">Whisper:</font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="whisper" id="whisper" size="95" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#F2F2F2'" height="25" bgcolor="#F2F2F2" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="right">&nbsp;&nbsp;<font class="tabletext">Picture:</font></td>
					<td width="85%" align="left">&nbsp;<font class="tabletext"><input type="file" class="tabletext" name="whisper_picture" id="whisper_picture" size="95" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>
	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg">
						<input class="tablecateg" type="button" onclick="javascript: verifica()" style="color:#333333" name="insert" value="Add whisper">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333" name="reset" value="Reset"></font></td>
					</tr>
					</table>				
				</td>
			</tr>
			</table>		</td>
	</tr>	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('whispers1').style.display == 'none'){
		document.getElementById('whispers1').style.display = '';
	}
	if(document.getElementById('whispers2').style.display == 'none'){
		document.getElementById('whispers2').style.display = '';
	}
	if(document.getElementById('whispers3').style.display == 'none'){
		document.getElementById('whispers3').style.display = '';
	}
	if(document.getElementById('whispers4').style.display == 'none'){
		document.getElementById('whispers4').style.display = '';
	}
	if(document.getElementById('whispers5').style.display == 'none'){
		document.getElementById('whispers5').style.display = '';
	}
	if(document.getElementById('whispers6').style.display == 'none'){
		document.getElementById('whispers6').style.display = '';
	}
</script>