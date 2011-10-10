<?
set_time_limit(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

include_once( "/home/httpd/vhosts/flirtigo.com/html/includes/config/db.php" );
include_once( "/home/httpd/vhosts/flirtigo.com/html/includes/class/db.php" );
//include_once( "/home/httpd/vhosts/hookuphotel.com/html/cron/phpmailer/class.phpmailer.php" );

/* end INCLUDES */                                         


if(isset($_POST['loadsetting']))
	{
			$sqlsql="Select * from `tblServers` where id='".$_POST['servername']."'";
			$obj=mysql_fetch_object(mysql_query($sqlsql));
			
			$sqltext="Select * from `tblServersTest` where id='1'";
			$objtext=mysql_fetch_object(mysql_query($sqltext));
			
			unset($_POST['domainip']);
			unset($_POST['domain']);
			unset($_POST['from']);
			unset($_POST['fromname']);
			unset($_POST['helo']);
			unset($_POST['returnpath']);
			unset($_POST['sname']);
			unset($_POST['subject']);
			unset($_POST['message']);
			unset($_POST['message2']);
			
			
	}
	


if(isset($_POST['send']))
	{


 if($_POST['sname']=="Q9")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','Q9','1','0')";

    }
elseif($_POST['sname']=="DFQ1")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','DFQ1','1','0')";

    }

elseif($_POST['sname']=="DFQ2")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','DFQ2','1','0')";

    }

elseif($_POST['sname']=="Q7")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','Q7','1','0')";

    }

elseif($_POST['sname']=="Q10")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','Q10','1','0')";

    }


elseif($_POST['sname']=="Q8")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','Q8','1','0')";

    }

elseif($_POST['sname']=="DFQ0")
    {
    $query="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
            values ('1','".$_POST['to']."','".$_POST['toname']."','".addslashes($_POST['subject'])."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','DFQ0','1','0')";

    }




else
	{

	
				
$query="INSERT INTO `tblTempCampaignMails` (`origin`,`fromname`,`from`,`to`,`toname`,`domain`,`domainip`,`helo`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
     values ('tester','".$_POST['fromname']."','".$_POST['from']."','".$_POST['to']."','".$_POST['toname']."','".$_POST['domain']."','".$_POST['domain']."',
     '".$_POST['helo']."','".$_POST['subject']."','".addslashes($_POST['message'])."','".addslashes($_POST['message2'])."','".$_POST['sname']."','1','')";
	}

                                        //echo $query;

                                        mysql_query($query);

                                $msg="<span style='color: red; font-size: 14px; font-face: Verdana'>Email sent succesfuly</span>";

					
}	
if(isset($_POST['savetext']))
	{
	
				
$query="UPDATE `tblServersTest` SET `subtext`='".$_POST['subject']."',`html`='".addslashes($_POST['message'])."',`plain`='".addslashes($_POST['message2'])."' where id=1";
					
					//echo $query;
					
				mysql_query($query);

                                $msg="<span style='color: red; font-size: 14px; font-face: Verdana'>SUBJECT , HTML AND PLAIN FORMAT saved succesfuly</span>";

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
		<td width="100%"><font class="pagetitle">TEST MAILING SERVER </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table width="100%"  cellpadding="0" cellspacing="0" >
		<tr height="50">
			<td colspan="2" style="text-align:center "><?=$msg?></td>
		</tr>
		<tr>
		  <td ><div align="center"><span class="style6">Server</span></div></td>
		  <td  align="left">
		  <select name="servername">
      <option value="0">Click to Select</option>
       <?
          $sql = "SELECT * FROM `tblServers` order by servername ASC";
          @$rez = mysql_query($sql);
          if(!is_resource($rez) || mysql_num_rows($rez) < 1) return false;
          $matr = array();
          while((@$data=mysql_fetch_object($rez)) != false)
           array_push($matr,$data);
           $angajati = $matr;
           if(is_array($angajati))           
           while(($data = each($angajati)) != false)
             {
             	echo "<option value=\"" .$data['value']->id ."\">" .$data['value']->domain." on ".$data['value']->servername."</option>";
             }
         ?>
    </select> 
		  
		  
		    <label>
		    <input name="loadsetting" type="submit" id="loadsetting" value="Load Server Settings" />
		    </label></td>
		  </tr>
		 <tr>
			<td width="40%"   text-align:center"><div align="center"><font class="tablename style1 style4" style="color: black;">&nbsp;ServerName </font></div></td>
			<td width="60%"  align="left" ><input name="sname" type="text" id="sname" value="<?if(isset($_POST['sname'])) echo $_POST['sname']; else echo $obj->servername;?>"/></td>
		  </tr> 
		<tr>
			<td width="40%"   text-align:center"><div align="center"><font class="tablename style1 style4" style="color: black;">&nbsp;Domain IP </font></div></td>
			<td width="60%"  align="left" ><input name="domainip" type="text" id="domainip" value="<?if(isset($_POST['domainip'])) echo $_POST['domainip']; else echo $obj->domainip;?>"/></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Domain</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="domain" type="text" id="domain" value="<?if(isset($_POST['domain'])) echo $_POST['domain']; else echo $obj->domain;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">From </span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="from" type="text" id="from" value="<?if(isset($_POST['from'])) echo $_POST['from']; else echo $obj->from;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">From Name </span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="fromname" type="text" id="fromname" value="<?if(isset($_POST['fromname'])) echo $_POST['fromname']; else echo $obj->fromname;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center" class="style7"><span class="style6">To EMAIL ADDRESS (x@y.com)</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="to" type="text" id="to" value="<?if(isset($_POST['to'])) echo $_POST['to'];?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center" class="style7"><span class="style6">To NAME (Justin)</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="toname" type="text" id="toname" value="<?if(isset($_POST['toname'])) echo $_POST['toname'];?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Return Path </span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="returnpath" type="text" id="returnpath" value="<?if(isset($_POST['returnpath'])) echo $_POST['returnpath']; else echo $obj->returnpath;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">HELO</span></div></td>
		  <td align="left" ><span style="padding-top:10px">
		    <input name="helo" type="text" id="helo" value="<?if(isset($_POST['helo'])) echo $_POST['helo']; else echo $obj->domain;?>"/>
		  </span></td>
		  </tr>
		<tr>
		  <td colspan="2" ><hr /></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Format of email</span></div></td>
		  <td align="left" ><select name="emailformat" id="emailformat">
            <option value="0">text(plain)</option>
            <option value="1">html</option>
	    <option value="2" selected="selected">multipart</option>
          </select></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Subject </span></div></td>
		  <td align="left" ><label><span style="padding-top:10px">
		    <input name="subject" type="text" id="subject" value="<?if(isset($_POST['subject'])) echo $_POST['subject'];else echo $objtext->subtext;?>"/>
		  </span></label></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">MESSAGE HTML</span></div></td>
		  <td align="left" ><label>
		    <textarea name="message" cols="60" rows="10" id="message" ><?if(isset($_POST['message'])) echo $_POST['message']; else echo $objtext->html;?></textarea>
		</label></td></tr>
		<tr>    
		 <td ><div align="center"><span class="style6">MESSAGE PLAIN</span></div></td>
		  <td align="left" ><label>
		    <textarea name="message2" cols="60" rows="10" id="message2"><?if(isset($_POST['message2'])) echo $_POST['message2']; else echo $objtext->plain;?></textarea>
		  </label></td>
		  </tr>
		  <tr>
			<td><input name="savetext" type="submit" id="savetext" value="Save Mail Contentl"></td>
		</tr>
		  
		<tr height="105px;">
			<td colspan="2"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input name="send" type="submit" id="send" style="width: 200px; height: 35px;" value="Send Test Mail"></td>
		</tr>
		</table>
		</td>
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
