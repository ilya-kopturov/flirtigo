<?
/* DIRTYFLIRTING.COM

*/
set_time_limit(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

include_once( "/home/httpd/vhosts/flirtigo.com/html/includes/config/db.php" );
include_once( "/home/httpd/vhosts/flirtigo.com/html/includes/class/db.php" );
//include_once( "/home/httpd/vhosts/flirtigo.com/html/cron/phpmailer/class.phpmailer.php" );

/* end INCLUDES */                                         


if(isset($_POST['loadsetting']))
	{
			$sqlsql="Select * from `tblServers` where id='".$_POST['servername']."'";
			$obj=mysql_fetch_object(mysql_query($sqlsql));
			
			unset($_POST['domainip']);
			unset($_POST['domain']);
			unset($_POST['from']);
			unset($_POST['fromname']);
			unset($_POST['helo']);
			unset($_POST['returnpath']);
			unset($_POST['sname']);
			
			
	}
	


if(isset($_POST['send']))
	{
	
	/*          mailer and set headers                */
	$mail = new PHPMailer();
	/*          end mailer set                       */



                                $mail->FromName =$_POST['fromname'];
                                $mail->From = $_POST['from'];

                                $mail->Hostname = $_POST['domain'];
                                $mail->Host     = $_POST['domainip'];
                                $mail->Sender   = $_POST['from'];
                                $mail->Helo     = $_POST['helo'];

                                $mail->Subject = $_POST['subject'];
                                $mail->Body    = $_POST['message'];
                                $mail->AddAddress($_POST['to'],$_POST['toname']);

                                if($_POST['emailformat']=='1')	$mail->IsHTML(true); else $mail->IsHTML(false);
				
                                if($_POST['serverlocation']=='0') 
					{
					$mail->IsQmail();
                            		$mail->send();
					}
					else
					{
                            @mysql_query("INSERT INTO `tblTempCampaignMails` (`origin`,`fromname`,`from`,`to`,`toname`,`domain`,`domainip`,`helo`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`)
                                        values ('tester','".$_POST['fromname']."','".$_POST['from']."','".$_POST['to']."','".$_POST['toname']."','".$_POST['domain']."','".$_POST['domain']."',
					'".$_POST['helo']."','".$_POST['subject']."','".$_POST['message']."','".$_POST['message2']."','".$_POST['sname']."','1','')");
																	    
					}

                                $mail->ClearAddresses();
                                $msg="<span style='color: red; font-size: 14px; font-face: Verdana'>Email sent succesfuly</span>";

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
          $sql = "SELECT * FROM `tblServers` order by domainip ASC";
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
		  <td ><div align="center"><span class="style6">Server Location</span></div></td>
		  <td align="left" ><select name="serverlocation" id="serverlocation">
		  
            <option value="0" <?if($obj->serverlocation==0) echo selected?>>local</option>
            <option value="1" <?if($obj->serverlocation==1) echo selected?>>remote</option>
          </select></td>
		  </tr>
		  
		<tr>
		  <td ><div align="center"><span class="style6">Format of email</span></div></td>
		  <td align="left" ><select name="emailformat" id="emailformat">
            <option value="0">text(plain)</option>
            <option value="1" selected="selected">html</option>
          </select></td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
		  <td align="left" >&nbsp;</td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">Subject </span></div></td>
		  <td align="left" ><label><span style="padding-top:10px">
		    <input name="subject" type="text" id="subject" value="<?if(isset($_POST['subject'])) echo $_POST['subject'];else echo "macman, dirtybird has sent you a message" ?>"/>
		  </span></label></td>
		  </tr>
		<tr>
		  <td ><div align="center"><span class="style6">MESSAGE HTML</span></div></td>
		  <td align="left" ><label>
		    <textarea name="message" cols="60" rows="10" id="message" >
		    Hi macman,<p>
		    
		    You have been sent an email by a FlirtiGo.com member<p>
		    
		    <b>MESSAGE DETAILS</b><br>
		    Username: dirtybird<br>
		    Location: london,england<p>
		    <b>Users Own Uploaded Image & Video Previews:</b><br>
		    <img src="http://dev.flirtigo.com/showphoto.php?id=4042679&t=s">  <img src="http://dev.flirtigo.com/showvideo.php?id=4042679"><br><br>
		    <i>(You may need to enable images in your email client to see the image previews above)</i><p>
		     
		     
		    To reply, simply login to your <a href="http://dev.flirtigo.com">FlirtiGo.com</a> account and go to "Mail & Messages".<p>
		    
		    You can login directly <a href="http://dev.flirtigo.com/emaillogin.php?e_id%3d376172%26c_id%3d73%26redirect%3dmem_mail.php%26login%3dc310c9d2a87edb8964e042c7fb53b8a2">by clicking here</a> to check your email if your browser supports it.<br>
		    A reminder of your username and password are:<br>
		    <b>Username: macman</b><br>
		    <b>Password: asdkj8734</b><p>
		    
		    <b>NOTE: Please ensure you select "not bulk/spam" to ensure you continue to receive future email notifications<b><p>
		    
		    To Adjust how and when you receive email, log in and click on "Mail & Messages -> Email Settings"<br>
		    Alternatively, you can unsubscribe from any notifications at all <a href="http://dev.flirtigo.com/emaillogin.php?e_id%3d376172%26c_id%3d73%26redirect%3dmem_emailoptions.php%26login%3dc310c9d2a87edb8964e042c7fb53b8a2%26u_id%3dY">by clicking here</a><p>
		    
		    This is an automatic notification. <b>Do not reply to this email. It will not reach the member above. </b>
		    </textarea>
		  </label></td>
		  </tr>
		  
		  
		  <tr>
		  <td ><div align="center"><span class="style6">MESSAGE PLAIN </span></div></td>
		  <td align="left" ><label>
		    <textarea name="message2" cols="60" rows="10" id="message2" >
		    Hi macman,
		    
		    You have been sent an email by a FlirtiGo.com member
		    
		    <b>MESSAGE DETAILS
		    Username: dirtybird
		    Location: london,england
		    <b>Users Own Uploaded Image & Video Previews:
		    <img src="http://dev.flirtigo.com/showphoto.php?id=4042679&t=s">  <img src="http://dev.flirtigo.com/showvideo.php?id=4042679"><br><br>
		    <i>(You may need to enable images in your email client to see the image previews above)</i><p>
		     
		     
		    To reply, simply login to your <a href="http://dev.flirtigo.com">FlirtiGo.com</a> account and go to "Mail & Messages".<p>
		    
		    You can login directly <a href="http://dev.flirtigo.com/emaillogin.php?e_id%3d376172%26c_id%3d73%26redirect%3dmem_mail.php%26login%3dc310c9d2a87edb8964e042c7fb53b8a2">by clicking here</a> to check your email if your browser supports it.<br>
		    A reminder of your username and password are:<br>
		    <b>Username: macman</b><br>
		    <b>Password: asdkj8734</b><p>
		    
		    <b>NOTE: Please ensure you select "not bulk/spam" to ensure you continue to receive future email notifications<b><p>
		    
		    To Adjust how and when you receive email, log in and click on "Mail & Messages -> Email Settings"<br>
		    Alternatively, you can unsubscribe from any notifications at all <a href="http://dev.flirtigo.com/emaillogin.php?e_id%3d376172%26c_id%3d73%26redirect%3dmem_emailoptions.php%26login%3dc310c9d2a87edb8964e042c7fb53b8a2%26u_id%3dY">by clicking here</a><p>
		    
		    This is an automatic notification. <b>Do not reply to this email. It will not reach the member above. </b>
		    </textarea>
		  </label></td>
		  </tr>
		  
		<tr height="105px;">
			<td colspan="2"  style="text-align:center; padding-top:50px; padding-bottom:20px;"><input name="send" type="submit" id="send" style="width: 200px; height: 35px;" value="Send Test Mail"></td>
		</tr>
		</table>
		</td>
	</tr>
	

</table>
</form>