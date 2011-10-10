<?
	if(isset($_POST["start"])){ 
		if($_POST["sserver"]!="all") $wsql .=" and servername='".$_POST["sserver"]."'";
		if($_POST["sdest"]=="all") $qry="UPDATE tblServers` set active='1' WHERE 1 ".$wsql;
							else $qry="UPDATE tblServers` set ".$_POST["sdest"]."='1' WHERE 1 ".$wsql;
		
		$qry=mysql_query($qry);
	}
	
	if(isset($_POST["stop"])){
		if($_POST["sserver"]!="all") $wsql .=" and servername='".$_POST["sserver"]."'";
		if($_POST["sdest"]=="all") $qry="UPDATE tblServers` set active='0' WHERE 1 ".$wsql;
							else $qry="UPDATE tblServers` set ".$_POST["sdest"]."='0' WHERE 1 ".$wsql;
		
		
		$qry=mysql_query($qry);
	}
	
	if(isset($_POST["tupdate"])){
		if($_POST["tserver"]!="all") $wsql .=" and servername='".$_POST["tserver"]."'";
		if($_POST["tdest"]=="1") {$destination="timeyahoo";$deststatus="syahoo";}
		if($_POST["tdest"]=="2") {$destination="timehotmail";$deststatus="shotmail";}
		if($_POST["tdest"]=="3") {$destination="timeaol";$deststatus="saol";}
		if($_POST["tdest"]=="4") {$destination="timeother";$deststatus="sother";}
		
			
		if($_POST["tstatus"]!="all") $wsql .=" and $deststatus='".$_POST["tstatus"]."'";
		 
		$qry="UPDATE tblServers set ".$destination."='".$_POST["time"]."' WHERE 1".$wsql;
		
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
.style4 {color: #FF0000; font-weight: bold; }
-->
</style>

<form name="form2"  method="post">
<input type="hidden" name="action" value="<? if($_POST["action"]!="") echo ""; ?>" />
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="0" border="0">
	<!-- Page title line -->
	<tr>
		<td colspan="3"><font class="pagetitle">Extra settings  for mailer </font></td>
	</tr>
	<tr>
	  <td height="60" colspan="3" style="text-align:left">&nbsp;</td>
    </tr>
	<tr>
		<td width="100%" colspan="3" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=addservers"></a></td>
	</tr>
	<!-- Page content line -->
					 <tr>
					   <td height="24" class="style1"><span class="style4">Timings:</span></td>
					   <td><span class="style1">HostServer
                       <select name="tserver" id="tserver">
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
					      Destination 
<select name="tdest" id="select4">
  <option value="1">Yahoo</option>
  <option value="2">Hotmail</option>
  <option value="3">Aol</option>
  <option value="4">Other</option>
</select>
<select name="tstatus" id="select5">
  <option value="all" selected="selected">All</option>
  <option value="1">Active</option>
  <option value="0">Inactive</option>
</select>
,time(s) </span><span class="style1">
<input name="time" type="text" id="time" size="5" maxlength="4" value="5"/>
</span><span class="style1">
<input name="tupdate" type="submit" id="tupdate" value="UPDATE" />
</span>
<label>				       </label></td>
					   <td>&nbsp;</td>
    </tr>
					 <tr>
					   <td height="24" colspan="2" class="style1"><hr /></td>
					   <td>&nbsp;</td>
    </tr>
					 <tr>
	                  <td height="24" class="style1"><span class="style4">Status:</span></td>
                      <td><label class="style1">
                        HostServer
                          <select name="sserver" id="sserver">
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
                           Destination status
<select name="sdest" id="sdest">
  <option value="all" selected="selected">All</option>
  <option value="syahoo">Yahoo</option>
  <option value="shotmail">Hotmail</option>
  <option value="saol">Aol</option>
  <option value="sother">Other</option>
</select>
<input name="stop" type="submit" id="stop" value="STOP" />
<input name="start" type="submit" id="start" value="START" />
                      </label></td>
                      <td>&nbsp;</td>
    </tr>
	<tr>
		<td width="100%" colspan="3" style="text-align:left"><a style="color:black; font-size: 13px;" href="index.php?content=addservers"></a></td>
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