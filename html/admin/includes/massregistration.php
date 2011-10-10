<?
	if($_FILES["uploadfile"]['name']!=""){
		$name=explode(".",$_FILES["uploadfile"]['name']);
		if($name[1]=="txt"){
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], "massupload/" .$name[0].".".$name[1])) {
				$msg="The file '".$name[0].".".$name[1]."' was uploaded!";
				echo "<script>document.location.href='index.php?content=massregistration'</script>";
			}else{
				$msg="File not uploaded! Please try again!";
			}
		}else{
			$msg="The file must be txt";
		}
	}
	if($_GET["file"]!=""){
		$c=file("massupload/".$_GET["file"]);
		for($i=0;$i<count($c);$i++){
			//echo str_replace("\r\n","",$c[$i])."<br />";
			$qry="insert into tblUsers (Email) values ('".str_replace("\r\n","",$c[$i])."')";
			//$qry=mysql_query($qry);
		}
		echo "<script>document.location.href='index.php?content=massregistration'</script>";
	}
	if($_GET["del"]!=""){
		$del=unlink("massupload/".str_replace(" ","%20",$_GET["del"]));
		echo "<script>document.location.href='index.php?content=massregistration'</script>";
	}
	//$alluserssql="SELECT `email` FROM tblUsers";
	//$allmails=mysql_query($alluserssql);
	//while($allmail=mysql_fetch_array($allmails, MYSQL_ASSOC) ){
		//$allemails[]=$allmail['email'];
	//}
	//var_dump($allemails);
	//if(isset($_POST)){
		//var_dump($_POST);
	//}
	if(isset($_POST['action']) && $_POST['action']=='addUsers'){
		
		$allowed_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$c=file("massupload/".$_POST["uploadedFile"].".txt");
		for($i=0;$i<count($c);$i++){
			//if(in_array($c[$i],$allemails)){
				//$msg .="User is already in our database!";
			//}
			//echo"<br/>";
			//var_dump("SELECT * FROM `tblUsers` WHERE `email`='".mysql_real_escape_string(trim($c[$i],"\n"))."'");
			$verifyEmailExistSql[$i]=mysql_query("SELECT * FROM `tblUsers` WHERE `email`='".mysql_real_escape_string(trim($c[$i]))."'");
			if($verifyEmailExistSql[$i]){
				$numRowsFoundedEmails=mysql_num_rows($verifyEmailExistSql[$i]);
				//echo"<br/>";
				//var_dump($numRowsFoundedEmails);
				if($numRowsFoundedEmails>0){
					
					$msg .="User with email <b>".trim($c[$i])."</b> is already in our database!<br/>";
				}
			}else{
				$msg .='Could not run query: ' . mysql_error();
			}
			$username[$i]=split('@',$c[$i]);
			for ($x = 0; $x < 10; $x++) {
				$password[$i]= substr($allowed_characters, mt_rand(0, strlen($allowed_characters) - 1), 1);
			}
			if(isset($_POST['looking'])){
				$looking_arr = array();
				$looking_arr = $_POST['looking'];
		
				$looking = 0;
				foreach ($looking_arr as $param)
				{
					$looking |= (1 << $param);
				}
			}
			else
			{
				$msg .= "SEEKING fields are all empty. <br/>";
			}
	
			if(isset($_POST['for']))
			{
				$for_arr = array();
				$for_arr = $_POST['for'];
		
				$for = 0;
				foreach ($for_arr as $param)
				{
					$for |= (1 << $param);
				}
			}
			else
			{
				$msg .= "FOR fields are all empty. <br/>";
			}
	
   			if(!checkdate($_POST['month'],$_POST['day'],$_POST['year'])){
				$msg .= "Invalid Birth Date. <br/>";
			}
			else
			{
				$_POST['birthdate'] = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
			}
	
			if($_POST['sex'] == 2){
    			if(!checkdate($_POST['p_month'],$_POST['p_day'],$_POST['p_year'])){
					$msg .= "Invalid <b>Partener</b> Birth Date. <br/>";
				}
				else
				{
					$_POST['p_birthdate'] = $_POST['p_year'] . "-" . $_POST['p_month'] . "-" . $_POST['p_day'];
				}
			}
	
			if(empty($_POST['redirect'])){
				$_POST['redirect'] = "N";
			}
			//echo"<br/>";
			//var_dump($msg);
			if(!isset($msg))
			{
				$sql = "INSERT INTO `tblUsers` (`origin`,`screenname`, 
		                                `pass`, 
		                                `email`,
		                                `sex`,
		                                `looking`, 
		                                `for`, 
		                                `introtitle`, 
		                                `introtext`, 
		                                `describe`, 
		                                `birthdate`,
		                                `p_birthdate`, 
		                                `country`, 
		                                `state`, 
		                                `city`, 
		                                `zip`, 
		                                `hide`, 
		                                `emailstatus`, 
		                                `emailnotif`, 
		                                `whispernotif`, 
		                                `newsletternotif`, 
		                                `typeusr`, 
		                                `typeloc`, 
		                                `redirect`, 
		                                `approved`, 
		                                `firsttime`, 
		                                `disabled`, 
		                                `accesslevel`,
		                                `height`,
		                                `p_height`, 
		                                `weight`,
		                                `p_weight`,
		                                `bodytype`,
		                                `p_bodytype`,
		                                `haircolor`,
		                                `p_haircolor`,
		                                `eyecolor`,
		                                `p_eyecolor`,
		                                `smoking`,
		                                `p_smoking`,
		                                `drinking`,
		                                `p_drinking`,
		                                `ethnicity`,
		                                `p_ethnicity`,
		                                `sexualactivities`,
		                                `joined` 
		                               ) 
		                               VALUES 
		                               (
		                                '" . $_POST['origin'] . "', 
		                                '" . addslashes(trim($username[$key][0].rand(100,999))) . "', 
		                                '" . addslashes(trim($password[$i])) . "', 
		                                '" . addslashes(trim($c[$i])) . "', 
		                                '" . (int) $_POST['sex'] . "', 
		                                '" . (int) $looking . "', 
		                                '" . (int) $for . "', 
		                                '" . addslashes($_POST['introtitle']) . "', 
		                                '" . addslashes($_POST['introtext']) . "', 
		                                '" . addslashes($_POST['describe']) . "', 
		                                '" . $_POST['birthdate'] . "', 
		                                '" . $_POST['p_birthdate'] . "',
		                                '" . $_POST['country'] . "', 
		                                '" . $_POST['state'] . "', 
		                                '" . $_POST['city'] . "', 
		                                '" . $_POST['zip'] . "', 
		                                '" . $_POST['hide'] . "', 
		                                '" . $_POST['emailstatus'] . "', 
		                                '" . $_POST['emailnotif'] . "', 
		                                '" . $_POST['whispernotif'] . "', 
		                                '" . $_POST['newsletternotif'] . "', 
		                                '" . $_POST['typeusr'] . "', 
		                                '" . $_POST['typeloc'] . "', 
		                                '" . $_POST['redirect'] . "',
		                                'Y', 
		                                '" . $_POST['firsttime'] . "', 
		                                '" . $_POST['disabled'] . "', 
		                                '" . $_POST['accesslevel'] . "',
		                                '" . $_POST['height'] . "', 
		                                '" . $_POST['p_height'] . "',
		                                '" . $_POST['weight'] . "', 
		                                '" . $_POST['p_weight'] . "',
		                                '" . $_POST['bodytype'] . "', 
		                                '" . $_POST['p_bodytype'] . "',
		                                '" . $_POST['haircolor'] . "', 
		                                '" . $_POST['p_haircolor'] . "',
		                                '" . $_POST['eyecolor'] . "', 
		                                '" . $_POST['p_eyecolor'] . "',
		                                '" . $_POST['smoking'] . "', 
		                                '" . $_POST['p_smoking'] . "',
		                                '" . $_POST['drinking'] . "', 
		                                '" . $_POST['p_drinking'] . "',
		                                '" . $_POST['ethnicity'] . "', 
		                                '" . $_POST['p_ethnicity'] . "',
		                                '" . $_POST['sexualactivities'] . "',
		                                NOW() 
		                               )";
				
				//$query = mysql_query($sql);
			}else{
				//echo "<script> alert(".$msg.");</script>";
			}
			
		}
		//die();
		unlink("massupload/".$_POST["uploadedFile"].".txt");
		echo "<script>document.location.href='index.php?content=massregistration'</script>";
		
	}
	
	
?>
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Mass Registration </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"><?=$msg ?></td>
	</tr>
	<tr>
		<td><font class="tablename">Upload a list</font></td>
	</tr>
	<tr>
		<td align="left" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
			<table bgcolor="#EEEEEE" style="vertical-align:middle; padding-left:10px; padding-top:10px" align="left" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22" align="left"><font class="filternameblack">
						<form action="index.php?content=massregistration" method="post" enctype="multipart/form-data">
						<input type="file" size="35" class="tabletext" name="uploadfile" /><br />
						<input type="submit" name="submit" value="Upload" />
						</form>
						</font></td>
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">Uploaded Emails Files</font></td>
	</tr>
	<tr>
		<td align="left" valign="middle" width="100%"  style="border-style:solid; border-color:#000000; border-width:0px">
			<form name="addform" method="post" action="index.php?content=massregistration" enctype="multipart/form-data">
			<input type="hidden" name="action" value="addUsers" />
			<table bgcolor="#EEEEEE" style="vertical-align:middle; padding:10px" align="left" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22" align="left"><font class="filternameblack">Please select the file that will be imported:<br />
						<ul style="list-style-type:none;">
						<?
						$handle = opendir("massupload");
						while(false !== ($file = readdir($handle))){
						
						if($file != '.' && $file != '..'){
						?>
						<li><input type="radio" name="uploadedFile" value="<?php echo str_replace(".txt","",$file);?>" /><?=str_replace(".txt","",$file) ?>&nbsp;&nbsp;&nbsp;&nbsp; <!--  <a href="index.php?content=massregistration&file=<?=$file ?>" style="color:#990000">Process</a> | --> <a href="index.php?content=massregistration&del=<?=$file ?>" style="color:#990000">Delete</a></li>
						<? }} ?>
						</ul></font></td>
					</tr>
			</table><br/>
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="10"></td>
	</tr>
	<!-- Page title line -->
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">* - required fields</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<!-- 
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Screen name<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="screenname" id="screenname" maxlength="12" size="35" value="<?=$_POST["screenname"]?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Password<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="pass" id="pass" size="35"  maxlength="12" value="<?=$_POST["pass"]?>" /> &nbsp; &nbsp; Default: <b>dfstaff</b></font>
				  </td>
				</tr>
				
				<tr>
					<td width="30%" align="right"></td>
					<td width="70%" align="left" style="padding-left: 5px;">
					  <font size="1" color="Red">Leave empty for default password</font>
				  </td>
				</tr>
				
				</table>		
				</td>
			</tr>
			 -->
			 
			 <tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Origin<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="origin" id="origin" size="35" value="<?=$_POST["origin"]?>" /></b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="right"></td>
					<td width="70%" align="left" style="padding-left: 5px;">
					  <font size="1" color="Red">Select Origin for Mailer</font>
				  </td>
				</tr>
				</table>				
				</td>
			</tr>
			 
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="email" id="email" size="35" value="<?=$_POST["email"]?>" /> &nbsp; &nbsp; Default: <b>dfstaff@flirtigo.com</b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="right"></td>
					<td width="70%" align="left" style="padding-left: 5px;">
					  <font size="1" color="Red">Leave empty for default email</font>
				  </td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Acc:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="typeusr">
					  <option value="N" <? if($_POST['typeusr'] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y"<? if($_POST['typeusr'] == "Y"){ echo "selected"; }?>>Yes</option>
					</select>
					&nbsp; <input type="checkbox" name="redirect" value="Y" <?if($_POST['redirect'] == 'Y') echo "checked";?> > - redirect mails to chatinterface
					</font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Staff Account Location:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="typeloc" id="typeloc">
					  <option value="N" <? if($_POST["typeloc"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($_POST["typeloc"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailnotif">
					<option value="N" <? if($_POST["emailnotif"] == "N"){ echo "selected"; }?>>No</option>
					<option value="Y" <? if($_POST["emailnotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Whisper Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="whispernotif" id="whispernotif">
					  <option value="N" <? if($_POST["whispernotif"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($_POST["whispernotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Newsletter Notification:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="newsletternotif">
					<option value="N" <? if($_POST["newsletternotif"] == "N"){ echo "selected"; }?>>No</option>
					<option value="Y" <? if($_POST["newsletternotif"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Hide:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="hide">
					  <option value="N" <? if($_POST["hide"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($_POST["hide"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">First Time:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="firsttime">
					  <option value="N" <? if($_POST["firsttime"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($_POST["firsttime"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Disabled:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="disabled" id="disabled">
					  <option value="N" <? if($_POST["disabled"] == "N"){ echo "selected"; }?>>No</option>
					  <option value="Y" <? if($_POST["disabled"] == "Y"){ echo "selected"; }?>>Yes</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Access Level:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="accesslevel">
					  <option value="0" <? if($_POST["accesslevel"] == 0){ echo "selected"; }?>>Free</option>
					  <option value="1" <? if($_POST["accesslevel"] == 1){ echo "selected"; }?>>Silver</option>
					  <option value="2" <? if($_POST["accesslevel"] == 2){ echo "selected"; }?>>Gold</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Email status:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="emailstatus">
					  <option value="G" <? if($_POST["emailstatus"] == "G"){ echo "selected"; }?>>Good</option>
					  <option value="I" <? if($_POST["emailstatus"] == "I"){ echo "selected"; }?>>Invalid</option>
					  <option value="B" <? if($_POST["emailstatus"] == "B"){ echo "selected"; }?>>Bounced</option>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Sex<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="sex" onchange="javascript: if(this.value == 2) document.getElementById('partener_profile').style.display = ''; else document.getElementById('partener_profile').style.display = 'none';">
					  <option value="0" <? if($_POST['sex'] == 0) echo "selected";?> >Man</option>
					  <option value="1" <? if($_POST['sex'] == 1) echo "selected";?> >Woman</option>
					  <option value="2" <? if($_POST['sex'] == 2) echo "selected";?> >Couple</option>
					  <option value="3" <? if($_POST['sex'] == 3) echo "selected";?> >Group</option>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Seeking<font color="red">*</font>:</font></td>
					<td width="70%" align="left" style="padding-left: 10px;">
					<font class="tabletext">
					  <input class="tabletext" name="looking[0]" value="0" type="checkbox" <? if($_POST['looking'][0] == 0 and $_POST['looking'][0] != ''){ echo "checked";} ?> > Man 
					  <input class="tabletext" name="looking[1]" value="1" type="checkbox" <? if($_POST['looking'][1] == 1){ echo "checked";} ?> > Woman 
					  <input class="tabletext" name="looking[2]" value="2" type="checkbox" <? if($_POST['looking'][2] == 2){ echo "checked";} ?> > Couple 
					  <input class="tabletext" name="looking[3]" value="3" type="checkbox" <? if($_POST['looking'][3] == 3){ echo "checked";} ?> > Group 
					</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">For<font color="red">*</font>:</font></td>
					<td width="35%" valign="top" align="left" style="padding-left: 10px;">
					<font class="tabletext">
					  <input class="tabletext" name="for[0]" value="0" type="checkbox" <? if($_POST['for'][0] == 0 and $_POST['for'][0] != ''){ echo "checked";} ?> > <?=$cfg['profile']['for'][0];?> <br>
					  <input class="tabletext" name="for[1]" value="1" type="checkbox" <? if($_POST['for'][1] == 1){ echo "checked";} ?> > <?=$cfg['profile']['for'][1];?> <br>
					  <input class="tabletext" name="for[2]" value="2" type="checkbox" <? if($_POST['for'][2] == 2){ echo "checked";} ?> > <?=$cfg['profile']['for'][2];?> <br>
					</font>
					<td width="35%" align="left">
					<font class="tabletext">
					  <input class="tabletext" name="for[3]" value="3" type="checkbox" <? if($_POST['for'][3] == 3){ echo "checked";} ?> > <?=$cfg['profile']['for'][3];?> <br> 
					  <input class="tabletext" name="for[4]" value="4" type="checkbox" <? if($_POST['for'][4] == 4){ echo "checked";} ?> > <?=$cfg['profile']['for'][4];?> <br> 
					  <input class="tabletext" name="for[5]" value="5" type="checkbox" <? if($_POST['for'][5] == 5){ echo "checked";} ?> > <?=$cfg['profile']['for'][5];?> <br> 
					  <input class="tabletext" name="for[6]" value="6" type="checkbox" <? if($_POST['for'][6] == 6){ echo "checked";} ?> > <?=$cfg['profile']['for'][6];?> <br> 
					</font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Fetishes<font color="red">*</font>:</font></td>
					<td width="70%" valign="top" align="left" style="padding-left: 10px;">
					  <table width="100%">
					    <tr>
						<?php for($i=1; $i<=count($cfg['profile']['sexualactivities']); $i++){?>
							<td width="20%"><input type="checkbox" name="fetishes[<?=$i-1;?>]" value="<?=$i-1;?>" <? if(isset($_POST['fetishes'][$i-1])) echo "checked";?> /> <font class="tabletext"><?=$cfg['profile']['sexualactivities'][$i-1]?></font></td>
						<? if($i%5 == 0) echo "</tr><tr>";?>	
						<?}?>
						</tr>
					  </table>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Intro title:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="introtitle" id="introtitle" size="65" value="<?=$_POST["introtitle"];?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Intro text:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><textarea class="tabletext" name="introtext" id="introtext" cols="62" rows="5"><?=$_POST["introtext"];?></textarea></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right" valign="top">&nbsp;&nbsp;<font class="tabletext">Describe looking:</font></td>
					<td width="70%" align="left" valign="top">&nbsp;<font class="tabletext"><textarea class="tabletext" name="describe" id="describe" cols="62" rows="5"><?=$_POST["describe"];?></textarea></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date<font color="red">*</font>:</font></td>
					<td width="20%" align="left">&nbsp;<font class="tabletext"> <select class="tabletext" name="month">
					<option value="">Month</option>
					<?
						for($i=1;$i<=12; $i++){
							if($_POST["month"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="day">
					<option value="">Day</option>
					<?
						for($i=1;$i<=31; $i++){
							if($_POST["day"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="year">
					<option value="">Year</option>
					<?
						for($i=1989;$i>=1920; $i--){
							if($_POST["year"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select></font></td>
					<td width="10%" align="right"><font class="tabletext">Height:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="height">
							<?php for($i=0; $i<count($cfg['profile']['height']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['height'] == $i) echo "selected";?> ><?=$cfg['profile']['height'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Weight:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="weight">
							<?php for($i=0; $i<count($cfg['profile']['weight']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['weight'] == $i) echo "selected";?> ><?=$cfg['profile']['weight'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Body shape:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="bodytype">
							<?php for($i=0; $i<count($cfg['profile']['bodytype']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['bodytype'] == $i) echo "selected";?> ><?=$cfg['profile']['bodytype'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Hair Color:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="haircolor">
							<?php for($i=0; $i<count($cfg['profile']['haircolor']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['haircolor'] == $i) echo "selected";?> ><?=$cfg['profile']['haircolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Eye color:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="eyecolor">
							<?php for($i=0; $i<count($cfg['profile']['eyecolor']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['eyecolor'] == $i) echo "selected";?> ><?=$cfg['profile']['eyecolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Smoker:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="smoking">
							<?php for($i=0; $i<count($cfg['profile']['smoking']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['smoking'] == $i) echo "selected";?> ><?=$cfg['profile']['smoking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Drinker:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="drinking">
							<?php for($i=0; $i<count($cfg['profile']['drinking']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['drinking'] == $i) echo "selected";?> ><?=$cfg['profile']['drinking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Ethnicity:</font></td>
					<td width="70%" align="left" colspan="3">
						&nbsp;<font class="tabletext">
							<select name="ethnicity">
							<?php for($i=0; $i<count($cfg['profile']['ethnicity']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['ethnicity'] == $i) echo "selected";?> ><?=$cfg['profile']['ethnicity'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>

<!-- Partener -->
			<tr id="partener_profile" <?if($_POST['sex'] == 2){?> style="display: block;" <?}else{?> style="display: none;" <?}?> >
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext"><b>Partener</b></font></td>
					<td width="70%" align="right" colspan="3"></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Birth date<font color="red">*</font>:</font></td>
					<td width="20%" align="left">&nbsp;<font class="tabletext"> <select class="tabletext" name="p_month">
					<option value="">Month</option>
					<?
						for($i=1;$i<=12; $i++){
							if($_POST["p_month"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="p_day">
					<option value="">Day</option>
					<?
						for($i=1;$i<=31; $i++){
							if($_POST["p_day"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select> / <select class="tabletext" name="p_year">
					<option value="">Year</option>
					<?
						for($i=1989;$i>=1920; $i--){
							if($_POST["p_year"]==$i){
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							} else{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
					</select></font></td>
					<td width="10%" align="right"><font class="tabletext">Height:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_height">
							<?php for($i=0; $i<count($cfg['profile']['height']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_height'] == $i) echo "selected";?> ><?=$cfg['profile']['height'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Weight:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_weight">
							<?php for($i=0; $i<count($cfg['profile']['weight']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_weight'] == $i) echo "selected";?> ><?=$cfg['profile']['weight'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Body shape:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_bodytype">
							<?php for($i=0; $i<count($cfg['profile']['bodytype']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_bodytype'] == $i) echo "selected";?> ><?=$cfg['profile']['bodytype'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Hair Color:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_haircolor">
							<?php for($i=0; $i<count($cfg['profile']['haircolor']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_haircolor'] == $i) echo "selected";?> ><?=$cfg['profile']['haircolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Eye color:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_eyecolor">
							<?php for($i=0; $i<count($cfg['profile']['eyecolor']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_eyecolor'] == $i) echo "selected";?> ><?=$cfg['profile']['eyecolor'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Smoker:</font></td>
					<td width="20%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_smoking">
							<?php for($i=0; $i<count($cfg['profile']['smoking']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_smoking'] == $i) echo "selected";?> ><?=$cfg['profile']['smoking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
					<td width="10%" align="right"><font class="tabletext">Drinker:</font></td>
					<td width="40%" align="left">
						&nbsp;<font class="tabletext">
							<select name="p_drinking">
							<?php for($i=0; $i<count($cfg['profile']['drinking']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_drinking'] == $i) echo "selected";?> ><?=$cfg['profile']['drinking'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
			    <tr>
					<td width="30%" align="right"><font class="tabletext">Ethnicity:</font></td>
					<td width="70%" align="left" colspan="3">
						&nbsp;<font class="tabletext">
							<select name="p_ethnicity">
							<?php for($i=0; $i<count($cfg['profile']['ethnicity']); $i++){?>
								<option value="<?=$i;?>" <?if($_POST['p_ethnicity'] == $i) echo "selected";?> ><?=$cfg['profile']['ethnicity'][$i]?></option>
							<?}?>
							</select>
						</font>
					</td>
				</tr>
				</table>				
				</td>
			</tr>
<!-- END PARTENER -->
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Country<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext">
					<select class="tabletext" name="country">
					<?
						$cqry="select * from `tblCountries` order by `id` ASC";
						$cqry=mysql_query($cqry);
						$nrc=mysql_num_rows($cqry);
						$sel="";
						for($i=0;$i<$nrc;$i++){
							$country=mysql_fetch_array($cqry);
							if($_POST["country"]==$country["id"]){
								$sel=" selected='selected'";
							} else {
								$sel="";
							}
							echo "<option".$sel." value='".$country["id"]."' class='forms'>".$country["name"]."</option>";
						}
					?>
					</select>
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
				
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">State:</font></td>
					<td width="70%" align="left"><font class="tabletext">
					<div id="country1" style="padding-left:5px">
					<select class="tabletext" name="state" id="state1" style="width:170px">
					<option value="" class="forms">--Select--</option>
					<?
						$cqry="SELECT * FROM `tblStates` ORDER BY `id` ASC";
						$cqry=mysql_query($cqry);
						$nrc=mysql_num_rows($cqry);
						$sel="";
						for($i=0;$i<$nrc;$i++){
							$country=mysql_fetch_array($cqry);
							if($_POST["state"]==$country["id"]){
								$sel=" selected='selected'";
							} else {
								$sel="";
							}
							echo "<option".$sel." value='".$country["id"]."' class='forms'>".$country["name"]."</option>";
						}
					?>
					</select></div>
					</font>
					</td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">City<font color="red">*</font>:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="city" id="city" size="35" value="<?=$_POST["city"]?>" />
					</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Zip:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="zip" id="zip" size="35" value="<?=$_POST["zip"]?>" />
					</font></td>
				</tr>
				</table>		
				</td>
			</tr>
			
			 <tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			 
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<?
					//create the list of fields that have to ve verified
					$verif="uploadedFile,sex,month,day,year,country,city,origin";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg">
					<input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="width: 150px; height: 30px; color:#333333" name="insert" value="Process">
					&nbsp;&nbsp;
					<input class="tablecateg" type="reset" style="width: 150px; height: 30px; color:#333333" name="reset" value="Reset"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>
		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%">
			
		</td>
	</tr>
</table>

<script language="JavaScript">
	if(document.getElementById('users1').style.display == 'none'){
		document.getElementById('users1').style.display = '';
	}
	if(document.getElementById('users2').style.display == 'none'){
		document.getElementById('users2').style.display = '';
	}
	if(document.getElementById('users3').style.display == 'none'){
		document.getElementById('users3').style.display = '';
	}
	if(document.getElementById('users4').style.display == 'none'){
		document.getElementById('users4').style.display = '';
	}
	if(document.getElementById('users5').style.display == 'none'){
		document.getElementById('users5').style.display = '';
	}
	if(document.getElementById('users6').style.display == 'none'){
		document.getElementById('users6').style.display = '';
	}
	if(document.getElementById('users7').style.display == 'none'){
		document.getElementById('users7').style.display = '';
	}
	if(document.getElementById('users8').style.display == 'none'){
		document.getElementById('users8').style.display = '';
	}
	if(document.getElementById('users9').style.display == 'none'){
		document.getElementById('users9').style.display = '';
	}
	if(document.getElementById('users10').style.display == 'none'){
		document.getElementById('users10').style.display = '';
	}
	if(document.getElementById('users11').style.display == 'none'){
		document.getElementById('users11').style.display = '';
	}
</script>