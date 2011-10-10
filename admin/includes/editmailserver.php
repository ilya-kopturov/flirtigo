<?
if(isset($_GET['id']))
{
	$sql1="Select * from `tblServers` where id='".$_GET['id']."'";
	$obj=mysql_fetch_object(mysql_query($sql1));
}

if(isset($_POST['delcmp']))
{
	if($_POST['cmpdest']!="all") $dquery="delete from tblServersRoute where campaignid='".$_POST['cmp']."' and domainid='".$_GET['id']."' and dest='".$_POST['cmpdest']."'";
		else 
		{
			$dquery="delete from tblServersRoute where campaignid='".$_POST['cmp']."' and domainid='".$_GET['id']."'";
		}
	//echo $dquery;
	@mysql_query($dquery);
}

if(isset($_POST['addcmp']))
{	
	$sqladd="Select * from `tblServersRoute` where campaignid='".$_POST['cmp']."' and domainid='".$_GET['id']."' and dest='".$_POST['cmpdest']."'";
	
	if(mysql_num_rows(mysql_query($sqladd))>0)
	{
		$msg="This campaign its already assigned for this server on requested destination";
	}
	else
	{
	if($_POST['cmpdest']!="all") $dquery="Insert into tblServersRoute (campaignid,domainid,dest) Values('".$_POST['cmp']."','".$_GET['id']."','".$_POST['cmpdest']."')";
		else 
		{
			mysql_query("Insert into tblServersRoute (campaignid,domainid,dest) Values('".$_POST['cmp']."','".$_GET['id']."','yahoo')");
			mysql_query("Insert into tblServersRoute (campaignid,domainid,dest) Values('".$_POST['cmp']."','".$_GET['id']."','hotmail')");
			mysql_query("Insert into tblServersRoute (campaignid,domainid,dest) Values('".$_POST['cmp']."','".$_GET['id']."','aol')");
			mysql_query("Insert into tblServersRoute (campaignid,domainid,dest) Values('".$_POST['cmp']."','".$_GET['id']."','other')");
		}
	//echo $dquery;
	@mysql_query($dquery);
	}
	
}

if(isset($_POST['update']))
	{
		if (isset($_POST['syahoo'])) $ssyahoo=1; else $ssyahoo=0;
		if (isset($_POST['shotmail'])) $sshotmail=1; else $sshotmail=0;
		if (isset($_POST['saol'])) $ssaol=1; else $ssaol=0;
		if (isset($_POST['sother'])) $ssother=1; else $ssother=0;
		if (isset($_POST['active'])) $active=1; else $active=0;
		if (isset($_POST['sroute'])) $sroute=1; else $sroute=0;
		
			  $sqlsql="Update `tblServers` set `servername`='".$_POST['servername']."',
											   `serverlocation`='".$_POST['serverlocation']."',
											   `domain`='".$_POST['domain']."',
											   `domainip`='".$_POST['domainip']."',
											   `from`='".$_POST['from']."',
											   `fromname`='".$_POST['fromname']."',
											   `returnpath`='".$_POST['returnpath']."',
											   `for`='".$_POST['for']."',
											   `helo`='".$_POST['helo']."',
											   `syahoo`='".$ssyahoo."',
											   `shotmail`='".$sshotmail."',
											   `saol`='".$ssaol."',
											   `sother`='".$ssother."',
											   `timeyahoo`='".$_POST['timeyahoo']."',
											   `timehotmail`='".$_POST['timehotmail']."',
											   `timeaol`='".$_POST['timeaol']."',
											   `timeother`='".$_POST['timeother']."',
											   `sroute`='".$sroute."',
											   `active`='".$active."',
											   `obs`='".$_POST['obs']."' where id='".$_GET['id']."'";
			//echo $sqlsql;
			mysql_query($sqlsql);
			$msg="<span style='color: red; font-size: 14px; font-face: Verdana'>Mailing Server Updated Succesfully!</span>";
		
	}
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style7 {color: #FF0000}
-->
</style>

<form name="form2"  method="post">
<input type="hidden" name="ispost" value="1">
<table style="vertical-align:top" align="center" width="59%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">EDIT MAILING SERVER </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table width="100%"  cellpadding="0" cellspacing="0" >
		<tr height="50">
			<td colspan="4" style="text-align:center "><?=$msg?></td>
		</tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Server</span></div></td>
		  <td colspan="2"  align="left"><input name="servername" type="text" id="servername" value="<?if(isset($_POST['servername'])) echo $_POST['servername']; else echo $obj->servername;?>"/></td>
		  </tr>
		<tr>
			<td colspan="2"   text-align:center"><div align="center"><font class="tablename style1 style4" style="color: black;">&nbsp;Domain IP </font></div></td>
			<td colspan="2"  align="left" ><input name="domainip" type="text" id="domainip" value="<?if(isset($_POST['domainip'])) echo $_POST['domainip']; else echo $obj->domainip;?>"/></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Domain</span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="domain" type="text" id="domain" value="<?if(isset($_POST['domain'])) echo $_POST['domain']; else echo $obj->domain;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">From </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="from" type="text" id="from" value="<?if(isset($_POST['from'])) echo $_POST['from']; else echo $obj->from;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">From Name </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="fromname" type="text" id="fromname" value="<?if(isset($_POST['fromname'])) echo $_POST['fromname']; else echo $obj->fromname;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Return Path </span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="returnpath" type="text" id="returnpath" value="<?if(isset($_POST['returnpath'])) echo $_POST['returnpath']; else echo $obj->returnpath;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">HELO</span></div></td>
		  <td colspan="2" align="left" ><span style="padding-top:10px">
		    <input name="helo" type="text" id="helo" value="<?if(isset($_POST['helo'])) echo $_POST['helo']; else echo $obj->helo;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Used for </span></div></td>
		  <td colspan="2" align="left" ><label>
		    <select name="for" id="for">
		      <option value="0" <?if($obj->for==0) echo "selected"?>>Internal</option>
		      <option value="1" <?if($obj->for==1) echo "selected"?>>External</option>
		      </select>
		  </label></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Location</span></div></td>
		  <td colspan="2" align="left" ><select name="serverlocation" id="serverlocation">
            <option value="0" <?if($obj->serverlocation==0) echo "selected"?>>Local</option>
            <option value="1" <?if($obj->serverlocation==1) echo "selected"?>>Remote</option>
          </select></td>
		  </tr>
		<tr>
		  <td colspan="4" ><hr /></td>
		  </tr>
		<tr>
		  <td colspan="2" >&nbsp;</td>
		  <td colspan="2" align="left" ><span class="style6 style7">Available to send for all campaigns
              <input name="active" type="checkbox" id="active" value="checkbox" <?if(isset($_POST['active']) or $obj->active==1) {?>checked="checked"<?}?> />
          </span></td>
		  </tr>
		<tr>
		  <td colspan="2" >&nbsp;</td>
		  <td width="34%" align="left" >&nbsp;</td>
		  <td width="26%" align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="2" >&nbsp;</td>
		  <td align="left" ><div align="center"><span class="style6">Timing (seconds)</span></div></td>
		  <td align="left" ><div align="center"><span class="style6">Available to send to</span></div></td>
		  </tr>
		<tr>
		  <td colspan="2" rowspan="2" ><div align="center"><span class="style6">Yahoo</span></div></td>
		  <td align="left" >&nbsp;</td>
		  <td rowspan="2" align="left" ><label>
		    <div align="center">
		      <input name="syahoo" type="checkbox" id="syahoo" value="checkbox" <?if(isset($_POST['syahoo']) or $obj->syahoo==1) {?>checked="checked"<?}?> />
		        </div>
		  </label></td>
		</tr>
		<tr>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeyahoo" type="text" id="timeyahoo" value="<?if(isset($_POST['timeyahoo'])) echo $_POST['timeyahoo']; else echo $obj->timeyahoo;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Hotmail</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timehotmail" type="text" id="timehotmail" value="<?if(isset($_POST['timehotmail'])) echo $_POST['timehotmail']; else echo $obj->timehotmail;?>" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="shotmail" type="checkbox" id="shotmail" value="checkbox" <?if(isset($_POST['shotmail']) or $obj->shotmail==1) {?>checked="checked"<?}?> />
		    </div></td>
		</tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Aol</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeaol" type="text" id="timeaol" value="<?if(isset($_POST['timeaol'])) echo $_POST['timeaol']; else echo $obj->timeaol;?>" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="saol" type="checkbox" id="saol" value="checkbox" <?if(isset($_POST['saol']) or $obj->saol==1) {?>checked="checked"<?}?> />
		    </div></td>
		</tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">Others</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="timeother" type="text" id="timeother" value="<?if(isset($_POST['timeother'])) echo $_POST['timeother']; else echo $obj->timeother;?>" />
		  </span></td>
		  <td align="left" ><div align="center">
		    <input name="sother" type="checkbox" id="sother" value="checkbox" <?if(isset($_POST['sother']) or $obj->sother==1) {?>checked="checked"<?}?>/>
		    </div></td>
		  </tr>
		<tr>
		  <td colspan="2" >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4" ><div align="center">
		    <hr />
		  </div></td>
		  </tr>
		<tr>
		  <td colspan="2" >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  <td align="left" ><div align="center"><span class="style6 style7">Send to Routes</span></div></td>
		  </tr>
		<tr>
		  <td colspan="3" ><div align="center" class="style7"><span class="style6">Destination
                <select name="cmpdest" id="cmpdest">
                  <option value="yahoo">Yahoo</option>
                  <option value="hotmail">Hotmail</option>
                  <option value="aol">Aol</option>
                  <option value="other">Other</option>
                  <option value="all" selected="selected">All</option>
                  </select>
Campaign
		      </span>
		    <select name="cmp" id="cmp">
		<?
          $sql = "SELECT * FROM `tblCampaign` order by id ASC";
          @$rez = mysql_query($sql);
          if(!is_resource($rez) || mysql_num_rows($rez) < 1) return false;
          $matr = array();
          while((@$data=mysql_fetch_object($rez)) != false)
           array_push($matr,$data);
           $angajati = $matr;
           if(is_array($angajati))           
           while(($data = each($angajati)) != false)
             {
             	echo "<option value=\"" .$data['value']->id ."\">" .$data['value']->id." - ".$data['value']->title."</option>";
             }
         ?>
	              </select>
	          <label>
	          <input name="addcmp" type="submit" id="addcmp" value="ADD" />
	          </label>
		      <input name="delcmp" type="submit" id="delcmp" value="DEL" />
		  </div></td>
		  <td ><div align="center">
		    <input name="sroute" type="checkbox" id="sroute" value="checkbox" checked="checked" <?if(isset($_POST['sother']) or $obj->sother==1) {?>checked="checked"<?}?>/>
		    </div></td>
		</tr>
		<tr>
		  <td >&nbsp;</td>
		  <td colspan="3" class="style6" >&nbsp;</td>
		  </tr>
		<tr>
		  <td width="19%" ><div align="right"><span class="style6">Allow Yahoo Cmp:</span></div></td>
		  <td colspan="3" class="style6" ><div align="left" class="style7">
		  <?$sql = "SELECT * FROM `tblServersRoute` where dest='yahoo' and domainid='".$_GET['id']."' order by campaignid ASC";
          @$rez = mysql_query($sql);
          while((@$data=mysql_fetch_object($rez)) != false)
          {
          	echo $data->campaignid." / ";
          }
          ?></div></td>
		  </tr>
		
		<tr>
		  <td >&nbsp;</td>
		  <td colspan="3" class="style6" >&nbsp;</td>
		  </tr>
		<tr>
		  <td ><div align="right"><span class="style6">Allowed Hotmail Cmp: </span></div></td>
		  <td colspan="3" class="style6" ><div align="left" class="style7">
		  <?$sql = "SELECT * FROM `tblServersRoute` where dest='hotmail' and domainid='".$_GET['id']."' order by campaignid ASC";
          @$rez = mysql_query($sql);
          while((@$data=mysql_fetch_object($rez)) != false)
          {
          	echo $data->campaignid." / ";
          }
          ?></div></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td colspan="3" class="style6" >&nbsp;</td>
		  </tr>
		<tr>
		  <td ><div align="right"><span class="style6">Allowed Aol Cmp:</span></div></td>
		  <td colspan="3" class="style6" ><div align="left" class="style7">
		  <?$sql = "SELECT * FROM `tblServersRoute` where dest='aol' and domainid='".$_GET['id']."' order by campaignid ASC";
          @$rez = mysql_query($sql);
          while((@$data=mysql_fetch_object($rez)) != false)
          {
          	echo $data->campaignid." / ";
          }
          ?></div></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td colspan="3" class="style6" >&nbsp;</td>
		  </tr>
		<tr>
		  <td ><div align="right"><span class="style6">Allowed Others Cmp: </span></div></td>
		  <td colspan="3" class="style6" ><div align="left" class="style7">
		  <?
		  $sql = "SELECT * FROM `tblServersRoute` where dest='other' and domainid='".$_GET['id']."' order by campaignid ASC";
          @$rez = mysql_query($sql);
          while((@$data=mysql_fetch_object($rez)) != false)
          {
          	echo $data->campaignid." / ";
          }
          ?>
          </div></td>
		  </tr>
		<tr>
		  <td colspan="4" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4" ><hr /></td>
		  </tr>
		<tr>
		  <td colspan="2" ><div align="center"><span class="style6">OBS </span></div></td>
		  <td colspan="2" align="left" ><label>
		    <textarea name="obs" rows="5" id="obs" ><?if(isset($_POST['obs'])) echo $_POST['obs']; else echo $obj->obs;?></textarea>
		  </label></td>
		  </tr>
		<tr height="105px;">
			<td colspan="4"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input style="width: 200px; height: 35px;" type="submit" name="update" id="update" value="Update Mailer Server" ></td>
		</tr>
		</table>
		</td>
	</tr>
	

</table>
</form>