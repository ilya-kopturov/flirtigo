<?php
	if((int) $_GET['ifp'] > 0)
	{
		@mysql_query("UPDATE `tblUsers` SET `featured` = 'N' WHERE `id`  = '". (int) $_GET['ifp'] . "' ");
	}
$sqlCountries=	mysql_query("SELECT * FROM `geo_country` WHERE `country_id`>0");
while($rowCountry = mysql_fetch_assoc($sqlCountries)){
	$countriesAll[$rowCountry['country_id']]=$rowCountry['country_title'];

}
?>
<script language="JavaScript">
	

</script>
<form name="form2" action="index.php?content=currentfeatured" method="post">
<input type="hidden" name="block" value="" />
<input type="hidden" name="upgrade" value="" />

					<?php
						if(!empty($_POST["ord"])){
							$ord=$_POST["ord"];
						} else {
							$ord="id";
						}
						if(!empty($_POST["dir"])){
							$dir=$_POST["dir"];
						} else {
							$dir="Desc";
						}
						if(!empty($_POST["limit"])){
							$limit=$_POST["limit"];
						} else {
							$limit="50";
						}
						if(!empty($_POST["page"])){
							$page=$_POST["page"];
						} else {
							$page="1";
						}
						?>
						
<input type="hidden" name="ord" value="<?=$ord ?>" />
<input type="hidden" name="dir" value="<?=$dir ?>" />
<input type="hidden" name="page" value="<?=$page ?>" />
<input type="hidden" id="usersChecked" name="usersChecked" value="0" />
					
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Current Featured Profiles</font></td>
	</tr>
	<? 
		//if((!empty($_POST["submitfilter"]) && $_POST["submitfilter"]=="Filter") || (!empty($_GET["actions"])) && $_GET["actions"]=="list"){
		{
		$qry="select * from tblUsers WHERE `withpicture` = 'Y' AND `featured` = 'Y'";
		$qry.=" order by ".$ord." ".$dir;
		$qry2=$qry." limit ".($page-1)*$limit.",".$limit;
		$qry_2=mysql_query("SELECT COUNT(*) " . substr($qry, strpos($qry, 'from')));
		$qry=mysql_query($qry2);
		$nr_found=mysql_num_rows($qry);
		$nr_found2=mysql_result($qry_2,0,0);
	?>
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left" width="50%"><font class="tablename"><?=number_format($nr_found2,0,'',','); ?> featured profiles</font></td>
			<td align="right" width="50%"><font class="filternameblack">Entries per page:<select class="tabletext" name="limit" onchange="document.form2.submit()">
			<option class="5" <? if($limit==5) echo "selected='selected'"; ?>>5</option>
			<option class="10" <? if($limit==10) echo "selected='selected'"; ?>>10</option>
			<option class="20" <? if($limit==20) echo "selected='selected'"; ?>>20</option>
			<option class="50" <? if($limit==50) echo "selected='selected'"; ?>>50</option>
			</select></font></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="right">
			<button type="button" onclick="deleteFeaturedUsers();return false;">Remove</button>
		</td>
	</tr>
	<tr>
	<td>
	<table style="vertical-align:top; width:1050px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1" width="100%">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:300px"><img id="picScreenName" onclick="ordertabels('ScreenName')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Screen Name</font></td>
					<td align="center" style="width:300px"><font class="tablecateg">Profile Country</font></td>
					<td align="center" style="width:250px"><img id="picEmail" alt="arrows" onclick="ordertabels('Email')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Email</font></td>
					<td align="center" style="width:200px"><font class="tablecateg">Featured Profile</font></td>
					<? if($ord!="id"){ ?>

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
				$aaaa=0;
				for($i=1; $i<=$nr_found; $i++){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
				$theaccount=mysql_fetch_array($qry);
			?>
			<tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp; <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$theaccount['id'];?>&t=r&f=Y" border="1"> &nbsp;<font class="tabletext"><a href="javascript:window.open('viewprofile.php?id=<?=$theaccount['id']?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600');void(0);"><?=$theaccount["screenname"] ?></a></font>&nbsp;</td>
					<td><font class="tabletext"><?php if($theaccount["country"]){echo $countriesAll[$theaccount["country"]];}else{echo"not choosen country";}?></font></td>
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["email"] ?></font>&nbsp;</td>
					<!--  <td align="center">&nbsp;<input type="checkbox" class="feturedUsersChecked" id="feturedUsersChecked_<?php echo $aaaa;?>" name="ifp" value="<?=$theaccount["id"] ?>"<? if($theaccount["featured"] == 'Y'){ echo "checked";}?> onClick="javascript:document.location.href='index.php?content=currentfeatured&ifp=<?=$theaccount["id"];?>';">&nbsp; -->
					<td align="center">&nbsp;<input type="checkbox" class="feturedUsersChecked" id="feturedUsersChecked_<?php echo $aaaa;?>" name="ifp" value="<?=$theaccount["id"] ?>" onchange="changeUserChecked(this.value,(this.checked ? 1 : 0));">&nbsp;
					</td>
			</tr>
			<?
				$aaaa++;
				}
			?>
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="10" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none"><?
						if($page==1){
							echo "<font style='color:#990000'><<&nbsp;&nbsp;<</font>&nbsp;&nbsp;";
						} else {
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(1)' class='tablecateg'><<</a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page-1)."\")' class='tablecateg'><</a>&nbsp;&nbsp;";
						}
						
						for($i=$page-2; $i<=ceil($nr_found2/$limit), $j<=4; $i++)
						{
							if($page==$i)
							{
								echo " <font style='color:#990000'>".$i."</font> ";
							} 
							elseif($i>=1 and $i<=ceil($nr_found2/$limit))
							{ 
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
							
							$j++;
						}
						
						if($page>=ceil($nr_found2/$limit)){
							echo "<font style='color:#990000'>>&nbsp;&nbsp;>></font>&nbsp;&nbsp;";
						} else {
							echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".($page+1)."\")' class='tablecateg'>></a>&nbsp;&nbsp;";
							echo "<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".(ceil($nr_found2/$limit))."\")' class='tablecateg'>>></a>";
						}
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?php echo ceil($nr_found2/$limit) ?> && <? echo $nr_found2; ?>!=0){
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
	<tr>
		<td align="right">
			<button type="button" onclick="deleteFeaturedUsers();return false;">Remove</button>
		</td>
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
					$verif="screenname,pass,email,sex,birthmonth,birthday,birthyear,country,city";
					
				?>
								</td>
			</tr>
			</table>		</td>
	</tr>
	<?
		}
	?>
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('featured1').style.display == 'none'){
		document.getElementById('featured1').style.display = '';
	}
	if(document.getElementById('featured2').style.display == 'none'){
		document.getElementById('featured2').style.display = '';
	}
	if(document.getElementById('featured3').style.display == 'none'){
		document.getElementById('featured3').style.display = '';
	}
</script>