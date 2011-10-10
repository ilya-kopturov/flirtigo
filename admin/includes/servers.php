<?php
	if(!empty($_POST["action"]) && $_POST["action"]="del"){ 
		$qry="DELETE FROM `tblServers` WHERE `id` = '".$_POST["id"]."'";
		$qry=mysql_query($qry);
	}
	
	
?>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
-->
</style>

<form name="form2"  method="post">
<input type="hidden" name="action" value="<? if($_POST["action"]!="") echo ""; ?>" />
<input type="hidden" name="id" value="" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td colspan="3"><font class="pagetitle">Servers for mailer </font></td>
	</tr>
	<tr>
		<td width="100%" colspan="3" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=addservers"><u>Add new server</u></a></td>
	</tr>
	<!-- Page content line -->
					 <tr>
	                  <td>&nbsp;</td>
                      <td><label>
                        <div align="center" class="style1">HostServer
                          <select name="server" id="server">
                            <option value="all" selected="selected">All</option>                            
       <?
          $sql = "SELECT distinct(servername) FROM `tblServers` order by servername ASC";
          @$rez = mysql_query($sql);
          if(!is_resource($rez) || mysql_num_rows($rez) < 1) return false;
          $matr = array();
          while((@$data=mysql_fetch_object($rez)) != false)
           array_push($matr,$data);
           $angajati = $matr;
           if(is_array($angajati))
            while(($data = each($angajati)) != false)
             {
             	echo "<option value=\"" .$data['value']->servername."\">" .$data['value']->servername."</option>";
             }
         ?>
    </select> 
                          , 
                          Server status
                          <select name="status" id="status">
                          <option value="all" selected="selected">All</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                          </select>
                        , Server Type 
                        <select name="type" id="type">
                          <option value="all" selected="selected">All</option>
                          <option value="1">Extern</option>
                          <option value="0">Intern</option>
                        </select>
                        , Destination status 
                        <select name="sdest" id="sdest">
                          <option value="all" selected="selected">All</option>
                          <option value="syahoo">Yahoo</option>
                          <option value="shotmail">Hotmail</option>
                          <option value="saol">Aol</option>
                          <option value="sother">Other</option>
                        </select>
                        <select name="sstatus" id="sstatus">
                          <option value="all" selected="selected">All</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                        <input name="sort" type="submit" id="sort" value="SORT" />
                        </div>
                      </label></td>
                      <td>&nbsp;</td>
    </tr>
    <tr>
	<td colspan="3">
	<table style="vertical-align:top; width:1200px" align="center" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)">
					<td width="10%" /><font class="tablecateg">ServerName</font></td>
					<td width="10%"/><font class="tablecateg">Domain</font></td>
					<td width="15%"/><font class="tablecateg">Host</font></td>
					<td width="15%"/><font class="tablecateg">From</font></td>
					<td width="15%"/><font class="tablecateg">ReturnPath</font></td>
					<td width="10%" /><font class="tablecateg">EmailSent</font></td>
					<td width="10%" /><font class="tablecateg">Campaigns</font></td>
					<td width="5%" align="center"><font class="tablecateg">Status (Act-Y/H/A/Oth)</font></td>
					<td width="5%" align="center"></td>
					<td width="5%" align="center"></td>
					
			</tr>
			
			<?
			 $tdcolor="#f2f2f2";
			
			$wheresql="1";
			if(isset($_POST['sort']))
			{	
				if($_POST['server']!='all') $wheresql .=" and servername='".$_POST['server']."'";
				if($_POST['status']!='all') $wheresql .=" and active='".$_POST['status']."'";
				if($_POST['type']!='all') $wheresql .=" and serverlocation='".$_POST['type']."'";
				if($_POST['sdest']!='all' and $_POST['sstatus']!='all') $wheresql .=" and ".$_POST['sdest']."='".$_POST['sstatus']."'";
			}
			
			$sql23="SELECT * FROM `tblServers` where ".$wheresql." order by domainip ASC";
			//echo $sql23;
			$qry_usrs=mysql_query($sql23);
			
			
			while($row_user=mysql_fetch_array($qry_usrs)){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}
			?>
			<tr height="40" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
					<td align="left">&nbsp;<font class="tabletext"><?=$row_user["servername"] ?></font>&nbsp;</td>
					<td align="left">&nbsp;<font class="tabletext"><?=$row_user["domain"] ?></font>&nbsp;</td>
					<td align="left"><font class="tabletext">
					  <?=$row_user["domainip"] ?>
					</font></td>
					<td align="left"><font class="tabletext">
					  <?=$row_user["from"] ?>
					</font></td>
					<td align="left"><font class="tabletext">
					  <?=$row_user["returnpath"] ?>
					</font></td>
					<td align="left"><font class="tabletext">
					  <?=$row_user["emailno"] ?>
					</font></td>
					
					<td align="left">
					  <font class="tabletext">
						<?
						  $sql = "SELECT `campaignid` FROM `tblServersRoute` where domainid='".$row_user["id"]."' GROUP BY `campaignid` order by campaignid ASC";
          				  @$rez = mysql_query($sql); $sshow = 0;
          				  while((@$data=mysql_fetch_object($rez)) != false)
          				  {
          				  	if((int) $sshow <= 0){
          				  		echo $data->campaignid; $sshow = 1;
          				  	}else{
          				  		echo ", " . $data->campaignid;
          				  	}
          				  }
          				?>
					  </font>
					</td>
					
					<td align="left"><font class="tabletext">
					  <?=$row_user["active"]." - ".$row_user["syahoo"]."/".$row_user["shotmail"]."/".$row_user["saol"]."/".$row_user["sother"] ?>
					</font></td>
					<td align="center"><font class="tabletext">
					  <input name="edit" type="button" id="edit" style="width: 50px; height: 25px;" onClick="javascript:document.location.href='index.php?content=editmailserver&id=<?=$row_user["id"]?>'" value="Edit"/>				 
					</font></td>
					<td align="center"><font class="tabletext">
					  <input style="width: 50px; height: 25px;" type="button" name="delete" value="Delete" onClick="if(confirm('Are you sure you want to delete this server?')){document.form2.action.value='del'; document.form2.id.value='<?=$row_user["id"] ?>'; document.form2.submit()}" />
					</font></td>
			</tr>
			<? }?>

			<tr>
				<td colspan="10" height="3" bgcolor="#990000"></td>
			</tr>
			<tr>
				<td colspan="10" height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" >
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>				</tr>
				</table>				</td>
			</tr>
			</table>			</td>
	</tr>
	</table>	</td>
	</tr>
	<tr>
		<td width="100%" colspan="3" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=addservers"><u>Add new server </u></a></td>
	</tr>	
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('mailermachine1').style.display == 'none'){
		document.getElementById('mailermachine1').style.display = '';
	}
	if(document.getElementById('mailermachine2').style.display == 'none'){
		document.getElementById('mailermachine2').style.display = '';
	}
	if(document.getElementById('mailermachine3').style.display == 'none'){
		document.getElementById('mailermachine3').style.display = '';
	}
	if(document.getElementById('mailermachine4').style.display == 'none'){
		document.getElementById('mailermachine4').style.display = '';
	}
	if(document.getElementById('mailermachine5').style.display == 'none'){
		document.getElementById('mailermachine5').style.display = '';
	}
	if(document.getElementById('mailermachine6').style.display == 'none'){
		document.getElementById('mailermachine6').style.display = '';
	}
	if(document.getElementById('mailermachine7').style.display == 'none'){
		document.getElementById('mailermachine7').style.display = '';
	}
	if(document.getElementById('mailermachine8').style.display == 'none'){
		document.getElementById('mailermachine8').style.display = '';
	}
	if(document.getElementById('mailermachine9').style.display == 'none'){
		document.getElementById('mailermachine9').style.display = '';
	}
</script>