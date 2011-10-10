<?
	if($_GET["action"]=="del"){
		echo $query="delete from tblCreateSite where Id='".$_GET["id"]."'";
		$query=mysql_query($query);
		echo $msg="The website with the Id=".$_GET["id"]." was deleted from the database";
		echo "<script>document.location.href='index.php?content=websites&msg=".$msg."';</script>";
	}
?>
<form name="form2" action="index.php?content=websites" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Websites List </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td align="left" valign="middle" bgcolor="#EEEEEE" style="border:1px solid #CCCCCC">
		
					<table id="filterdiv" bgcolor="#EEEEEE" style="vertical-align:middle" align="left" border="0" cellpadding="0" cellspacing="4" class="filternameblack" width="100%">
					<? if($_POST["ord"]!="Id" && $_POST["ord"]!=""){ ?>
					<tr style="background-color:#FFFFFF">
						<td align="left" style="font-size:12px; color:#990000; font-weight:normal">Sorting pattern: <?=$_POST["ord"] ?>(<?=$_POST["dir"] ?>);</td>
						<td align="right"><a href="#" onclick="javascript: ordertabels('Id')" style="text-decoration:none"><font class="filternameblack" style="font-size:12px; text-decoration:underline">reset sorting pattern</font></a></td>
					</tr>
					<? } 
						if(!empty($_POST["ord"])){
							$ord=$_POST["ord"];
						} else {
							$ord="Id";
						}
						if(!empty($_POST["dir"])){
							$dir=$_POST["dir"];
						} else {
							$dir="Asc";
						}
						if(!empty($_POST["limit"])){
							$limit=$_POST["limit"];
						} else {
							$limit="5";
						}
						if(!empty($_POST["page"])){
							$page=$_POST["page"];
						} else {
							$page="1";
						}
						if(!empty($_POST["thelast"])){
							$thelast=$_POST["thelast"];
						} else {
							$thelast="5";
						}
					?>
					
					<tr>
						<td colspan="2" width="100%" align="left">
						<input type="hidden" name="ord" value="<?=$ord ?>" />
					<input type="hidden" name="dir" value="<?=$dir ?>" />
					<!-- <input type="hidden" name="limit" value="<? //$limit ?>" />-->
					<input type="hidden" name="page" value="<?=$page ?>" />
					<script language="javascript" type="text/javascript">
					function searchtip(){
						sel=document.form2.from;
						document.getElementById('calendarimg').style.visibility="hidden";
						document.getElementById('textexplain').innerHTML="";
						if(sel.value=="JoinedOn" || sel.value=="JoinedOnUntil"){
							document.getElementById('calendarimg').style.visibility="visible";
						}
						if(sel.value=="Nr" || sel.value=="Sent" || sel.value=="Readed"  || sel.value=="Bounced"  || sel.value=="`Interval`" || sel.value=="Login"){
							document.getElementById('textexplain').innerHTML="(can use >,<, <=, >=)";
						}
					}
					</script><?=$_GET["msg"] ?></td>
					</tr>
					
					</table>	
		
		  </td>
	</tr>
	<? 
		$qry="select * from tblCreateSite";
		
		$qry.=" order by ".$ord." ".$dir;
		$qry2=$qry." limit ".($page-1)*$limit.",".$thelast;
		//echo "<tr><td>".$qry."</td></tr>";
		$qry_2=mysql_query($qry);
		$qry=mysql_query($qry2);
		$nr_found=mysql_num_rows($qry);
		$nr_found2=mysql_num_rows($qry_2);
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"></font></td>
			<td align="right" width="50%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			</select></font></td>
		</table>
		</td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:950px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:120px"><img id="picName" onclick="ordertabels('Name')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Name</font></td>
					<td align="center" style="width:150px"><img id="picUrl" onclick="ordertabels('Url')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Url</font></td>
					<td align="center" style="width:120px"><img id="picTemplate" onclick="ordertabels('Template')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Template</font></td>
					<td align="center" style="width:200px"><img id="picNrUsers" onclick="ordertabels('NrUsers')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Users found / Max users</font></td>
					<td align="center" style="width:90px"><img id="picCompleted" onclick="ordertabels('Completed')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Completed</font></td>
					<td align="center" style="width:200px"><font class="tablecateg">Action</font></td>
					<? if($ord!="Id"){ ?>
					<script>
						obj=document.getElementById('pic<?=$ord ?>');
						<? if($dir=="Asc"){ ?>
						obj.src='images/sort/sort_ascending2.gif';
						<? } else { ?>
						obj.src='images/sort/sort_descending2.gif';
						<? } ?>
					</script>
					<? } ?>
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
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["Name"] ?></font>&nbsp;</td>
					<td align="left ">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Url"] ?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><? $query=mysql_fetch_array(mysql_query("select * from tblTemplates where Id='".$theaccount["Template"]."'")); echo $query["Name"];?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?="<strong>".count(explode(",",$theaccount["Users"]))."</strong> / ".$theaccount["NrUsers"]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=($theaccount["Completed"]==0)?("no"):("yes")?></font></td>
					<td align="center"><font class="tabletext"><? if($theaccount["Completed"]==0){?><input type="button" name="complete" value="Complete" onclick="document.location.href='index.php?content=editsite&id=<?=$theaccount["Id"] ?>'" /><? } ?>&nbsp;<input type="button" name="delete" value="Delete" onclick="document.location.href='index.php?content=websites&id=<?=$theaccount["Id"] ?>&action=del'" /></font></td>
			</tr>
			<?
				}
			?>
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td colspan="14" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"><?
						for($i=1; $i<=ceil($nr_found2/$limit); $i++){
							if($page==$i){
								echo " <font style='color:#990000'>".$i."</font> ";
							} else {
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
						}
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?=ceil($nr_found2/$limit) ?> && <? $nr_found2 ?>!=0){
						pages(<?=ceil($nr_found2/$limit) ?>);
						}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
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

<script language="JavaScript">
	if(document.getElementById('websites1').style.display == 'none'){
		document.getElementById('websites1').style.display = '';
	}
	if(document.getElementById('websites2').style.display == 'none'){
		document.getElementById('websites2').style.display = '';
	}
	if(document.getElementById('websites3').style.display == 'none'){
		document.getElementById('websites3').style.display = '';
	}
</script>