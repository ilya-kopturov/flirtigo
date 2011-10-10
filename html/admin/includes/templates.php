<?
	if(!empty($_POST["action"]) && $_POST["action"]="del"){
		$qry="delete from tblTemplates where Id='".$_POST["id"]."'";
		$qry=mysql_query($qry);
		$msg="The template with Id='".$_POST["id"]."' was deleted!";
	}
?>
<script language="javascript" type="text/javascript">
					var tempx=0; 
					var tempy=0;
					function getmousepoz(e){
						var IE = document.all?true:false;
						if (!IE) document.captureEvents(Event.MOUSEMOVE); 
							if (IE) { 
							tempx = event.clientX + document.body.scrollLeft;
							tempy = event.clientY + document.body.scrollTop;
							
							} else {  
								tempx = e.pageX;
								tempy = e.pageY;
							}
						 tempy-=100;
							tempx-=200;
					}
					document.onmousemove=getmousepoz;
					</script>
<div id="divreply" align="center" style="position:absolute; visibility:hidden">
<table cellpadding="0" cellspacing="0" style="border:1px solid #000000; background-color:#006699">
<tr>
<td valign="middle" align="center">
<img id="theframe" src=""></td>
</tr>
<tr>
	<td style="height:50px; padding-left:20px" align="left"><input type="button" name="Close" value="Close" onclick="document.getElementById('divreply').style.visibility='hidden'" /></td>
</tr>
</table>
</div>
<form name="form2" action="index.php?content=templates" method="post">
<input type="hidden" name="action" value="" />
<input type="hidden" name="id" value="" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Templates List </font></td>
	</tr>
	<!-- Page content line -->
	
	<? 
		$qry="select * from tblTemplates";
		//echo "<tr><td>".$qry."</td></tr>";
		$qry=mysql_query($qry);
		$nr_found=mysql_num_rows($qry);
		
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><font color="#333333"><?=$nr_found ?></font> entries found in database</font></td>
			<td align="right" width="50%"></td>
			</tr>
		</table>
		</td>
	</tr>
	
	<tr>
	<td>
	<table style="vertical-align:top; width:500px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:150px"><font class="tablecateg">Name</font></td>
					<td align="center" style="width:150px"><font class="tablecateg">Used</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">View</font></td>
					<td align="center" style="width:100px"><font class="tablecateg">Action</font></td>
					
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=1; $i<=$nr_found; $i++){
				$theaccount=mysql_fetch_array($qry);
					if($tdcolor=="#f2f2f2"){
						$tdcolor="#FFFFFF";
					} else {
						$tdcolor="#f2f2f2";
					}
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["Name"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><font color="#990000"><?=mysql_num_rows(mysql_query("select * from tblCreateSite where Template='".$theaccount["Id"]."'")) ?></font> times</font>&nbsp;</td>
					<td align="center"><a href="#" onclick="/* document.getElementById('divreply').style.visibility='visible'; */ document.getElementById('divreply').style.right='100px'; document.getElementById('divreply').style.top=tempy; document.getElementById('theframe').scrolling='yes'; document.getElementById('theframe').src='../templates/<?=$theaccount["Name"] ?>/template/big.jpg'" style="color:#333333"><img alt="template_<?=$theaccount["Name"] ?>" src="../templates/<?=$theaccount["Name"] ?>/template/small.jpg" border="0" /><br />
				  <font class="tabletext" style="font-size:10px">[+]Enlarge</font></a></td>
					<td align="center"><a href="#ttf" style="color:#333333" onclick="if(confirm('Are you sure you want to delete this template?')){document.form2.action.value='del'; document.form2.id.value='<?=$theaccount["Id"] ?>'; document.form2.submit()}"<font class="tabletext">Delete</font></td>
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
					<td width="70%" align="left"></td>
					<td width="30%" align="right"></td>
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
	<?
	if($nr_found2>0){
	echo "<script>
			if(document.form2.page.value>".ceil($nr_found2/$limit)."){
				document.form2.page.value=".ceil($nr_found2/$limit).";
				document.form2.submit();
			}
			
		</script>";
		}
	?>
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