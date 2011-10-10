<?php

	function get_sites()
	{
		$sql = "SELECT Id, Name, Url FROM tblCreateSite ORDER BY Name ASC";
		$query = mysql_query($sql) or die(mysql_error());

		while ($result = mysql_fetch_array($query))
			$found[] = $result;
		
		return $found;	
	}

	
	$sites = get_sites();
	$nr_sites = sizeof($sites);
	
	
	echo '<pre>'; print_r($sites); echo '</pre>';

	echo '<pre>'; print_r($_POST); echo '</pre>';

?>


<script language="javascript">
<!--
	function next_step(step)
	{
		document.getElementById("step").value = step;
		document.getElementById("formular").submit();	
	}
-->
</script>


<form name="formular" id="formular" method="post" action="index.php?content=edittemplate" target="_self">	
	<input type="hidden" name="step" id="step" value="<?php echo (isset($_POST['step']))?$_POST['step']:1; ?>" />
		
	
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Edit  Template</font></td>
	</tr>
	<!-- Page content line -->	
	<tr>
		<td height="20"></td>
	</tr>

<?php
	if ($nr_sites > 0)
	{
?>
	<tr>
		<td align="left" valign="top">
			<table cellspacing="3" cellpadding="0" border="0">
				<tr>
					<td align="right">
						Site:
					</td>
					<td align="left" valign="middle">
						<select name="site" id="site">						
					<?php						
						for ($i=0; $i < $nr_sites; $i++)					
						{
					?>
						<option value="<?php echo $sites[$i]['Id']; ?>" id="site_<?php echo $i; ?>"><?php echo $sites[$i]['Name']; ?></option>						
					<?php
						}
					?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="height:10px" />				
				</tr>				
				<tr>
					<td align="right" valign="middle" colspan="2">
						<button onClick="next_step(<?php echo (isset($_POST['step']))?($_POST['step']+1):2; ?>);">Next Step</button>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php
	}
	else
	{
?>	
	<tr>
		<td align="left" valign="middle">
			No sites were defined. Click <a style="color: #000000;" href="index.php?content=addsite" target="_self">here</a> to add a site.
		</td>	
	</tr>
<?php
	}
?>	
	
	<!-- Page content line -->	
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