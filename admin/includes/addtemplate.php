<?
	if(!empty($_POST["action"]) && $_POST["action"]=="add"){
		$anr=rand(0, 200);
		$qry="insert into tblTemplates (Name) values ('".$_POST["name"]."')";
		$qry=mysql_query($qry);
		$msg="The template ".$_POST["name"]." was inserted into the database!";
	}
	
	
	
	function get_templates()
	{
		$sql = "SELECT * FROM tblTemplates";
		$query = mysql_query($sql) or die(mysql_error());
		
		$found = array();
		
		while ($result = mysql_fetch_array($query))
			$found[] = $result;
			
		return $found;	
	}
		
	$templates = get_templates();
		
?>


<script language="javascript">
<!--
	function verifica()
	{
		var templates = new Array();
		
		<?php
			$nr_templates = sizeof($templates);
			for ($i=0; $i < $nr_templates; $i++)
			{
		?>
		templates['<?php echo strtolower($templates[$i]['Name']); ?>'] = 1;								
		<?php
			}
		?>
		
		
		if (document.getElementById('name').value != "")
		{
			if (templates[document.getElementById('name').value])
			{
				alert('This template name already exists.Choose another!');
				document.getElementById('name').select();
				document.getElementById('name').focus();			
			}
			else
				return true;				
		}
		else
		{	
			alert("Please type the template's name!");
			document.getElementById('name').focus();		
		}
		
		return false;
	}
-->
</script>


<form name="addform" method="post" action="index.php?content=addtemplate" onsubmit="return verifica();">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Add Template</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$msg ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">* - required fields</font></td>
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
				<td align="center" bgcolor="#FFFFE6" width="100%" style="padding:10px"><font class="tabletext" style="font-weight:bold"><font color="#990000">Note!</font> The name of the template is the same as the name of the folder that contaigns the template!</font></td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%" align="left">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Name*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="name" id="name" size="35" value="" /></font></td>
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
				<?
					//create the list of fields that have to ve verified
					$verif="name";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="submit" style="color:#333333" name="insert" value="Add">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333" name="reset" value="Reset"></font></td>
				</tr>
				</table>				</td>
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
	if(document.getElementById('templates1').style.display == 'none'){
		document.getElementById('templates1').style.display = '';
	}
	if(document.getElementById('templates2').style.display == 'none'){
		document.getElementById('templates2').style.display = '';
	}
	if(document.getElementById('templates3').style.display == 'none'){
		document.getElementById('templates3').style.display = '';
	}
	if(document.getElementById('templates4').style.display == 'none'){
		document.getElementById('templates4').style.display = '';
	}
</script>