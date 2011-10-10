<form name="form2" action="index.php?content=statsmailer" method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Curent Mailer Stats </font></td>
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
					</script>
						Select the last:<input type="text" class="tabletext" name="thelast" value="<?=$thelast ?>" size="1" /> campaigns
                       <input type="hidden" name="submitfilter" value="Filter" />
						<input type="submit" name="thesubmit" value="Select" /></td>
					</tr>
					
					</table>	
		
		  </td>
	</tr>
	<? 
		$qry="select * from tblCampaign";
		if($_POST["search"]!="")
		{
			$qry.=" where";
			
			//echo "<tr><td>fillltre=".count($filters)."</td></tr>";
			
				//echo "<tr><td>filtru $i=".$filters[$i]."</td></tr>";
				if($_POST["from"]=="SendFrom") $qry.=" SendFrom like '%".$_POST["search"]."%'";
				if($_POST["from"]=="SubjectIntern") $qry.=" SubjectIntern like '%".$_POST["search"]."%'";
				if($_POST["from"]=="JoinedOn") $qry.=" JoinedOn like '%".$_POST["search"]."%'";
				if($_POST["from"]=="JoinedOnUntil") $qry.=" JoinedOnUntil like '%".$_POST["search"]."%'";
				if($_POST["from"]=="Finished") $qry.=" Finished like '%".$_POST["search"]."%'";
				if($_POST["from"]=="Running") $qry.=" Running like '%".$_POST["search"]."%'";
				if($_POST["from"]=="`Interval`" || $_POST["from"]=="Nr" || $_POST["from"]=="Sent" || $_POST["from"]=="Readed" || $_POST["from"]=="Bounced" || $_POST["from"]=="Login"){
					$operator="";
					$from=0;
					$thesplited=str_split($_POST["search"]);
					if($thesplited[0]==">" || $thesplited[0]=="<" || $thesplited[0]=="="){
						$operator.=$thesplited[0];
						$from++;
					}
					if($thesplited[1]==">" || $thesplited[1]=="<" || $thesplited[1]=="="){
						$operator.=$thesplited[1];
						$from++;
					}
					if($operator==""){
						$operator="=";
					}
					$thesearch="";
					for($i=$from;$i<count($thesplited);$i++){
						$thesearch.=$thesplited[$i];
					}
					//$qry.=$thesplited[0]." ";
					//$qry.=count($thesplited);
					$qry.=" ".$_POST["from"].$operator.$thesearch;
				}
				
		}
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
	<table style="vertical-align:top; width:750px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="14" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td align="center" style="width:120px"><img id="picSendFrom" onclick="ordertabels('SendFrom')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">From</font></td>
					<td align="center" style="width:150px"><img id="picJoinedOn" onclick="ordertabels('JoinedOn')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Date</font></td>
					<td align="center" style="width:120px"><img id="picNr" onclick="ordertabels('Nr')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Target users</font></td>
					<td align="center" style="width:90px"><img id="picSent" onclick="ordertabels('Sent')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Sent mail</font></td>
					<td align="center" style="width:90px"><img id="picReaded" onclick="ordertabels('Readed')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Readed</font></td>
					<td align="center" style="width:90px"><img id="picBounced" onclick="ordertabels('Bounced')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Bounced</font></td>
					<td align="center" style="width:90px"><img id="picLogin" onclick="ordertabels('Login')" src="images/sort/sort_off2.gif" width="13" height="14" /><font class="tablecateg">Logged-in</font></td>
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
					<td align="left">&nbsp;<font class="tabletext"><?=$theaccount["SendFrom"] ?></font>&nbsp;</td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["JoinedOn"] ?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Nr"]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Sent"]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Readed"]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Bounced"]?></font></td>
					<td align="center">&nbsp;&nbsp;<font class="tabletext"><?=$theaccount["Login"]?></font></td>
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
				
				<?php
					if ($nr_found >= $limit)
					{
				?>
				<tr>
					<td width="50%" align="left">&nbsp;&nbsp;<font class="tablecateg" style="text-decoration:none">
					
					
					<a href='#' style='text-decoration:none' onmouseover='this.style.color="#999999"' onmouseout='this.style.color="#333333"' onclick='javascript: pages("1")' class='tablecateg'>First</a> <a href='#' style='text-decoration:none' onmouseover='this.style.color="#999999"' onmouseout='this.style.color="#333333"' onclick='javascript: pages(document.form2.page.value-1)' class='tablecateg'>Prev</a>
					
					
					
					 <?
							//find how many numbers are before and after the page
							$left=$page-1;
							$right=ceil($nr_found2/$limit)-$page;
							//don't allow more than 9
							if($left>4){
								$left=4;
							}
							if($right>8-$left){
								$right=8-$left;
							}
							//find out from what page to what page
							$startpage=$page-$left;
							$endpage=$page+$right;
							for($i=$startpage; $i<=$endpage; $i++){
								if($page==$i){
									echo " <font style='color:#990000'>".$i."</font> ";
								} else {
									echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
								}
							}
						
					?> 
					
					
					
					
					<a href='#' style='text-decoration:none' onmouseover='this.style.color="#999999"' onmouseout='this.style.color="#333333"' onclick='javascript: pages(<?=$page+1 ?>)' class='tablecateg'>Next</a> <a href='#' style='text-decoration:none' onmouseover='this.style.color="#999999"' onmouseout='this.style.color="#333333"' onclick='javascript: pages(<?=ceil($nr_found2/$limit) ?>)' class='tablecateg'>Last</a>
								
					
					
					
					
					<?
						/*for($i=1; $i<ceil($nr_found2/$limit); $i++){
							if($page==$i){
								echo " <font style='color:#990000'>".$i."</font> ";
							} else {
								echo "[<a href='#' style='text-decoration:none' onmouseover='this.style.color=\"#999999\"' onmouseout='this.style.color=\"#333333\"' onclick='javascript: pages(\"".$i."\")' class='tablecateg'> ".$i." </a>] ";
							}
						}*/
					?></font></td>
					<td width="50%" align="right">
					<script language="javascript" type="text/javascript">
						if(document.form2.page.value><?=ceil($nr_found2/$limit) ?> && <? $nr_found2 ?>!=0){
						pages(<?=ceil($nr_found2/$limit) ?>);
						}
					</script>
					<font class="tablecateg" style="text-decoration:none">Go to page: <input id="gotopage" type="text" name="gotopage" value="" size="1" class="tabletext" /><input type="button" name="Go" value="Go" onclick="javascript: if(document.form2.gotopage.value>=<?=ceil($nr_found2/$limit) ?>){pages(<?=ceil($nr_found2/$limit) ?>)}else {pages(document.form2.gotopage.value)}" /></font>&nbsp;&nbsp;</td>
				</tr>
				
				<?php
					}
				?>
				
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