<?php
//connect to db
function connect_db(){
	$db = mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error: Couldn't connect to database");
	mysql_select_db(DBNAME, $db) or die("Error: Couldn't select database.");
}

function forgot_pass($mail, $pass){
 /* subject */
	 $subject = "Your Password";
 /* message */
	$message = '<html><head></head><body><font face=arial size=2>
	<br><br>
	This is your Password: '.$pass.'<br><br>
	Thanks,<br>
	'.SITEURL.'<br><br>
	Please do not reply to this email. Emails sent to this address will not be answered.
	<br><br></font></body></html>';
	// To send HTML mail, the Content-type header must be set
		$headers  =  "MIME-Version: 1.0\n" .
		 "Content-type: text/html; charset=iso-8859-1\n" .
		 "From: ".SITEEMAIL." <".SITEEMAIL."> \n";
	// Mail it
	if(mail($mail, $subject, $message, $headers)){
		return true;
	}else{
		return false;
	}
}

function reply_email($mail, $id='', $username=''){
 /* subject */
	 $subject = "Request Received - Incident ID ".$id;
 /* message */
	$message = '<html><head></head><body><font face=arial size=2>
	Your question has been received. You should expect a response within 24 hours.<br><br>
	This is your Incident ID: '.$id.'<br><br>
	Thanks,<br>
	'.SITEURL.'<br><br>
	Please do not reply to this email. Emails sent to this address will not be answered.
	<br><br></font></body></html>';
	// To send HTML mail, the Content-type header must be set
		$headers  =  "MIME-Version: 1.0\n" .
		 "Content-type: text/html; charset=iso-8859-1\n" .
		 "From: ".SITEEMAIL." <".SITEEMAIL."> \n";
	// Mail it
	if(mail($mail, $subject, $message, $headers)){
		return true;
	}else{
		return false;
	}
}

function email_admin($id='',$content,$extra=''){
	//select admin details from db
	$admin = mysql_fetch_array(mysql_query("select * from `tblAdmin` Where `AdminID`='1'"));
	$admin_user = md5($admin["AdminUser"]);
	$admin_pass = md5($admin["AdminPass"]);
	if($extra != "") $extra .= ": ";
 /* subject */
	 $subject = $extra."New Icident - Incident ID ".$id;
 /* message */
	$message = '<html><head></head><body><font face=arial size=2>
	This is your new Incident ID: '.$id.'<br><br>
	'.stripslashes($content).'<br><br>
	Click here to reply&nbsp;&nbsp;<a href="'.SITEURL.'admin/edit_ticket.php?idticket='.$id.'&user='.$admin_user.'&pass='.$admin_pass.'">'.SITEURL.'admin/edit_ticket.php?idticket='.$id.'</a>
	<br><br></font></body></html>';
	// To send HTML mail, the Content-type header must be set
		$headers  =  "MIME-Version: 1.0\n" .
		 "Content-type: text/html; charset=iso-8859-1\n" .
		 "From: ".SITEEMAIL." <".SITEEMAIL."> \n";
	// Mail it
	if(mail(ADMINEMAIL, $subject, $message, $headers)){
		return true;
	}else{
		return false;
	}
}

function send_reply_email($id, $subject='', $content=''){

	//get email address
	$msg_details = mysql_fetch_array(mysql_query("select * from `tblMessages` where `MessagesID`='".$id."'"));
	$mail_details = mysql_fetch_array(mysql_query("select * from `tblClients` where `ClientsID`='".$msg_details["ClientsID"]."'"));
	$mail = $mail_details["ClientsEmail"];

	/* message */
	$message = '<html><head></head><body><font face=arial size=2>
	'.stripslashes($content).'<br><br>
	Click here to see conversation and post a reply&nbsp;&nbsp;<a href="'.SITEURL.'viewticket.php?MessagesID='.$id.'&email='.md5($mail).'&ClientsID='.$mail_details["ClientsID"].'">'.SITEURL.'viewticket.php?MessagesID='.$id.'</a><br><br>
	</font></body></html>';

	// To send HTML mail, the Content-type header must be set
	$headers  =  "MIME-Version: 1.0\n" .
	"Content-type: text/html; charset=iso-8859-1\n" .
	"From: ".SITEEMAIL." <".SITEEMAIL."> \n";

	// Mail it
	if(mail($mail, $subject, $message, $headers)){
		return true;
	}else{
		return false;
	}
}

//display date in php page
function DateToPage($date,$format="Y-m-d")
{
	if ( $format=="Y-m-d" && $date!="") {
		list($year,$month,$day) = explode( "-", $date);
		return $month."/".$day."/".$year;
	}
		if ( $format=="Y-d-m" && $date!="") {
			list($year,$day,$month) = explode( "-", $date);
			return $month."/".$day."/".$year;
		}
	return $date;
}

//vertify admin login come from email
function verify_admin($user, $pass){
	$admin = mysql_fetch_array(mysql_query("select * from `tblAdmin` Where `AdminID`='1'"));
	$admin_user = md5($admin["AdminUser"]);
	$admin_pass = md5($admin["AdminPass"]);

	if($admin_user == $user && $admin_pass == $pass){
		$AccountID = $admin["AdminID"];
		$_SESSION["AccountID"] = $AccountID;
		return true;
	}else{
		echo "<script>document.location.href='index.php'</script>"; exit;
	}
}

//vertify admin login come from email
function verify_user($id, $email){
	$user = mysql_fetch_array(mysql_query("select * from `tblClients` Where `ClientsID`='".$id."'"));
	$user_mail = md5($user["ClientsEmail"]);

	if($user_mail == $email){
		$ClientsID = $user["ClientsID"];
		$_SESSION["ClientsID"] = $ClientsID;
		return true;
	}else{
		echo "<script>document.location.href='login.php'</script>"; exit;
	}
}
//verify user on login and create session values
function verify_login($email, $pass)
{
	//if email field is not empty
	if(trim($email) != '' && trim($pass) != ''){
		//verify query
		$query_login = ("select * from `tblAdmin` where `Name` = '".$email."' and `Password` = '".$pass."'");
		$qlogin = mysql_query($query_login);
		if($row_login = mysql_fetch_array($qlogin)){
			//register user to session
			$admin = $row_login["Name"];
			$p_admin = $row_login["Password"];
			$_SESSION['admin'] = $admin;
			$_SESSION['p_admin'] = $p_admin;
			$_SESSION['sid'] = session_id();
			return true;
		}else{
			//incorect login
			$result = "Your Admin USERNAME or PASSWORD are invalid!";
			return $result;
		}//end verify if user is active
	}else{
		//Email & pin empty
		$result = "All fields are required";
		return $result;
	}//end if email field is not empty
}


function db_res( $query, $error_checking = 1 )
{

	$res = mysql_query( $query);
	if ( $error_checking && !$res )
	{echo  $query;
	    echo PrintErr( "Database access error" );
	    exit;
	}
    return $res;
}

function db_arr( $query, $error_checking = 1  )
{

   	$res = mysql_query( $query);
   	if ( $error_checking && !$res )
   	{echo  $query;
	    echo PrintErr( "Database access error" );
	    exit;
	}
   	$arr = mysql_fetch_array( $res );
   	return $arr;
}


function getParam( $param_name )
{
	if ( !$line = db_arr( "SELECT VALUE FROM GlParams WHERE Name = '$param_name'" ) )
	    return false;
	return $line[VALUE];
}

function getParamDesc( $param_name )
{
    if ( !$line = db_arr( "SELECT `desc` FROM GlParams WHERE Name = '$param_name'" ) )
        return false;
    return $line[desc];
}


function setParam( $param_name, $param_val )
{
	if ( !get_magic_quotes_gpc() )
		$param_val = addslashes( $param_val );
	if ( !$res = db_res( "UPDATE GlParams SET VALUE = '$param_val' WHERE Name = '$param_name'" ) )
		return false;
    return true;
}

function PrintErr($out)
{
	$ret  = "<table cellspacing=2 cellpadding=2 align=center style=\"border: 1px solid red\"><tr><td bgcolor=red>";
	$ret .= "<font color=white><b>Error</b></font>";
	$ret .= "</td></tr>";
	$ret .= "<tr><td>";
	$ret .= $out;
	$ret .= "</td></tr></table>";
	return $ret;
}

function get_field_name (  $arr )
{
    $vals = split (",", $arr['name']);
    return $vals[0];
}


if (!function_exists('age')) {
	function age( $birth_date )
	{
		if ( $birth_date == "0000-00-00" )
			return _t("_uknown");
	
		$bd = explode( "-", $birth_date );
		$age = date("Y") - $bd[0] - 1;
	
		$arr[1] = "m";
		$arr[2] = "d";
	
		for ( $i = 1; $arr[$i]; $i++ )
		{
			$n = date( $arr[$i] );
			if ( $n < $bd[$i] )
				break;
			if ( $n > $bd[$i] )
			{
				++$age;
				break;
			}
		}
	
		return $age;
	}
}


function process_db_input( $text, $strip_tags = 0, $force_addslashes = 0 )
{
	if ( $strip_tags )
		$text = strip_tags($text);

	if ( !get_magic_quotes_gpc() || $force_addslashes )
		return addslashes($text);
	else
		return $text;
}

function html2txt($content, $tags = "")
{
	while($content != strip_tags($content, $tags))
	{
		$content = strip_tags($content, $tags);
	}

	return $content;
}

function match_prifiles ( $Member, $Profile )
{

	$fields = array();
	$extras = array();
	$match_fields = array();
	$match_types = array();
	$match_extras = array();
	$i = 0;

	$res = db_res("SELECT name, match_field, extra, match_type, match_extra FROM ProfilesDesc WHERE match_type <> '' AND  match_type <> 'none'");
	while ($arr = mysql_fetch_array($res))
	{
		$fields[$i] = get_field_name($arr);
		$extras[$i] = $arr['extra'];
		$match_fields[$i] = $arr['match_field'];
		$match_types[$i] = $arr['match_type'];
		$match_extras[$i] = $arr['match_extra'];
		$i++;
	}

	foreach ( $match_fields as $n => $m_field )
	{
        $m_field = trim($m_field);
        if (!strlen($m_field)) continue;

		if ( !$n ) {
			$sql_add_m .= " $m_field";
			$sql_add_p .= " $fields[$n]";
		} else {
			$sql_add_m .= ", $m_field";
			$sql_add_p .= ", $fields[$n]";
		}
	}

	$arr_m = db_arr("SELECT $sql_add_p FROM Profiles WHERE ID = $Member");
	$arr_p = db_arr("SELECT $sql_add_m FROM Profiles WHERE ID = $Profile");

	if ( !$arr_m || !$arr_p )
		return 0;

	$ret = 0;

	foreach ( $match_fields as $n => $m_field )
	{
		switch ( $match_types[$n] )
		{
			case "enum":
			case "enum_ref":
				if ( $arr_m[$fields[$n]] == $arr_p[$match_fields[$n]] )
					$ret +=  $match_extras[$n];
				break;
			case "set":
				$vals = preg_split ("/[,\']+/", $extras[$n], -1, PREG_SPLIT_NO_EMPTY);
				$vals_m = preg_split ("/[,\']+/", $arr_m[$fields[$n]], -1, PREG_SPLIT_NO_EMPTY);
				$vals_p = preg_split ("/[,\']+/", $arr_p[$match_fields[$n]], -1, PREG_SPLIT_NO_EMPTY);

				$count = count($vals);
				$count_m = count($vals_m);
				$count_p = count($vals_p);

				if ( $count_p + $count_m > 0 )
				{
					$per = $match_extras[$n] / max($count_p,$count_m);
					foreach ( $vals as $key => $val )
					{
						if (
							 strlen(strstr($arr_m[$fields[$n]],$val)) > 0 &&
							 strlen(strstr($arr_p[$match_fields[$n]],$val)) > 0
							)
							$ret += $per;
					}
				}

				break;
			case "daterange":
				$rg = split ( "-", $arr_m[$fields[$n]] );
				$age = age($arr_p[$match_fields[$n]]);
				if ( $age >= $rg[0] && $age <= $rg[1] )
					$ret += $match_extras[$n];
				break;
		}
	}

	return (int)$ret;
}

function cupid_email( $profile )
{
	global $ret;
	global $data;
	global $siteurl;
	global $sitetitle;
	global $site_email_notify;

    $profile  = (int)$profile;
	$match_min = (int)getParam("match_percent");

    $prof_arr = db_arr("SELECT ID, NickName, Email, LookingFor, Sex FROM Profiles WHERE ID = $profile AND Status='Active'");

    if ( ((int)$prof_arr['ID']) <= 0 )
        return false;

	$add = '';
	if ( 'both' != $prof_arr['LookingFor'] ) $add = ' and Sex =\''.$prof_arr['LookingFor'].'\'';
	$add .= ' and ( LookingFor = \''.$prof_arr['Sex'].'\' or LookingFor = \'both\')';
	$memb_res = db_res("SELECT ID, NickName, Email, EmailFlag
				FROM Profiles
				WHERE EmailNotify='NotifyMe' AND Status='Active' AND ID <> $profile $add");
    if ( mysql_num_rows($memb_res) < 1 )
        return false;

	while ( $memb_arr = mysql_fetch_array($memb_res) )
	{
	    $match = match_prifiles( $memb_arr['ID'], $profile );
		if ( $match < $match_min )
		{
			// If the profile matches less then predefined
			// percent then go to next iteration (i.e. next profile)
			continue;
		}


		$message = getParam( "t_CupidMail" );
		$subject = getParam('t_CupidMail_subject');
		$subject = process_db_input($subject);
		$subject	= str_replace( "<your subject here>", "Profile that match to you", $subject );

		$recipient	= $memb_arr['Email'];
		$headers	= "From: ".$sitetitle." <".$site_email_notify.">";
		$headers2	= "-f ".$site_email_notify."";

		$message	= str_replace( "<SiteName>", $sitetitle, $message );
		$message	= str_replace( "<Domain>", $siteurl, $message );
		$message	= str_replace( "<RealName>", $memb_arr['NickName'], $message );
		$message	= str_replace( "<StrID>", $memb_arr['ID'], $message );
		$message	= str_replace( "<MatchProfileLink>", " ".$siteurl."profile.php?ID={$prof_arr['ID']}", $message );
		$message	= process_db_input($message);

		if ('Text' == $memb_arr['EmailFlag']){
			$message = html2txt($message);
		}

		if ('HTML' == $memb_arr['EmailFlag']){
			$headers = "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=iso-8859-1\r\n" . $headers;
		}

		$sql = "INSERT INTO `NotifyQueue` SET `Email` = {$memb_arr['ID']}, Msg = 0, `From` = 'ProfilesMsgText', Creation = NOW(), MsgText = '$message', MsgSubj = '$subject'";

		//$res = db_res($sql);

		//send mail
		mail($recipient, $subject, $message, $headers);
	}

	return true;
}

function CopyFiles($source,$dest)
{
   $folder = opendir($source);
   while($file = readdir($folder))
   {
   	if ($file == '.' || $file == '..') {
           continue;
       }

       if(is_dir($source.'/'.$file))
       {
           mkdir($dest.'/'.$file,0777);
           CopySourceFiles($source.'/'.$file,$dest.'/'.$file);
       }
       else
       {
           copy($source.'/'.$file,$dest.'/'.$file);
           chmod($dest.'/'.$file, 0777);
       }

   }
   closedir($folder);
   return 1;
}

function Date_Month($source){
	switch ($source){
		case '1':return 'January';
		case '01':return 'January';
		case '2':return 'February';
		case '02':return 'February';
		case '3':return 'March';
		case '03':return 'March';
		case '4':return 'April';
		case '04':return 'April';
		case '5':return 'May';
		case '05':return 'May';
		case '6':return 'June';
		case '06':return 'June';
		case '7':return 'July';
		case '07':return 'July';
		case '8':return 'August';
		case '08':return 'August';
		case '9':return 'September';
		case '09':return 'September';
		case '10':return 'Octomber';
		case '11':return 'November';
		case '12':return 'December';
		default:return $source;
	}
}
	function get_user_id($name)
	{
		$sql = "SELECT `Id` FROM `tblUsers` WHERE `ScreenName`='".$name."'";
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_array($query);

		return $result['Id'];
	}
	function get_screen_name($id)
	{
		$sql = "SELECT `ScreenName` FROM `tblUsers` WHERE `Id`='".$id."'";
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_array($query);

		return $result['ScreenName'];
	}
	function trash_emails($emails)
	{
		foreach ($emails as $nume => $id)
		{
			if ($nume != 'selectAll')
			{
				$sql = "UPDATE tblTypeMails SET Trash = NOW() WHERE Id=".$id;
				$query = mysql_query($sql) or die(mysql_error());

				$sql = "UPDATE tblMails SET Trash = NOW() WHERE Id=".$id;
				$query = mysql_query($sql) or die(mysql_error());
			}
		}
	}
	function get_emails()
		{
		$sql = "(select Id from tblTypeMails where `To`='".$_SESSION['name']."' and Visualized='0' and Trash = '0000-00-00 00:00:00') union (select Id from tblMails where `To`='".$_SESSION['name']."' and Visualized='0' and Trash = '0000-00-00 00:00:00') ";
		$query = mysql_query($sql) or die(mysql_error());
		$emails = array();
		while ($result = mysql_fetch_array($query))
			array_push($emails, $result["Id"]);
		return $emails;
		}
	function get_email($id, $tblmails)
		{
			$sql   = "SELECT * FROM `" . $tblmails . "` where `id` = '".$id."'";
			$query = mysql_query($sql) or die(mysql_error());
			return mysql_fetch_array($query);
		}
	function get_id_sender($sender)
		{
			$sql = "SELECT Id FROM tblUsers WHERE ScreenName='".$sender."'";
			$query = mysql_query($sql) or die(mysql_error());
			$result = mysql_fetch_array($query);
			return $result["Id"];
		}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('replace_before_send')) {
	function replace_before_send($replacestring, $to_array, $from_array)
	{
		global $cfg, $campaignmail_id, $redirect_to;
	
		$to_name   = ucfirst($to_array['screenname']);
		$to_user_email=$to_array['email'];
		$from_name = ucfirst($from_array['screenname']);
	
		$to_countryname = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tblCountries` WHERE `id` = '" . $to_array['country'] . "'"));
		$to_statename   = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tblStates` WHERE `id` = '" . $to_array['state'] . "'"));
	
		if($to_countryname['name'] != '') $to_location = $to_countryname['name'];
		if($to_statename['name'] != '' and $to_location != '') {$to_location .= ", " . $to_statename['name'];}
		elseif($to_statename['name'] != ''){ $to_location = $to_statename['name']; }
	
	
		$fake_usr_loc = @mysql_num_rows(mysql_query("SELECT `id` FROM `tblUsers` WHERE `id` = '" . $from_array['id'] . "' AND `typeusr` = 'Y' AND `typeloc` = 'Y' LIMIT 1"));
	
		if((int) $fake_usr_loc > 0)
		{	
			list($joined) = @mysql_fetch_array(mysql_query("SELECT `joined` 
			                                                FROM `tblUsers` 
			                                                WHERE `id` = '" . $from_array['id'] . "'
			                                                LIMIT 1"));
			
			list($ret['sess_country'],
			     $ret['sess_state'],
			     $ret['sess_city']) = @mysql_fetch_array
			     					(
			                           mysql_query("SELECT `country`,`state`,`city` 
			                    				    FROM `tblLocations` 
			                                        WHERE  `user_id`   = '".$to_array['id']."' AND 
			                                               `fromdate` <= '".$joined."'         AND 
			                                               `todate`   >  '".$joined."'
			                                        LIMIT 1"
			                                      )
			                         );
			                         
			if(!$ret['sess_country']) $ret['sess_country'] = $to_array['country'];
			if($ret['sess_country'] != 1) $ret['sess_state'] = 0;
			
			if((int) $ret['sess_country'] > 0){
				$from_countryname = @mysql_fetch_array
				                        (
				                          mysql_query("SELECT `name` 
				                                       FROM `tblCountries` 
				                                       WHERE `id` = '" . $ret['sess_country'] . "'"
				                                      )
				                        );
				                        
				$from_statename   = @mysql_fetch_array
				                        (
				                          mysql_query("SELECT `name` 
				                                       FROM `tblStates` 
				                                       WHERE `id` = '" . $ret['sess_state'] . "'"
				                                     )
				                        );
			
				if($from_countryname['name'] != '') $from_location = $from_countryname['name'];
				if($from_statename['name'] != '' and $from_location != '') {$from_location .= ", " . $from_statename['name'];}
				elseif($from_statename['name'] != ''){ $from_location = $from_statename['name']; }		
			}else{
				$from_location = $to_location;
			}			
			
		} else {
			$from_countryname = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tblCountries` WHERE `id` = '" . $from_array['country'] . "'"));
			$from_statename   = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tblStates` WHERE `id` = '" . $from_array['state'] . "'"));
	
			if($from_countryname['name'] != '') $from_location = $from_countryname['name'];
			if($from_statename['name'] != '' and $from_location != '') {$from_location .= ", " . $from_statename['name'];}
			elseif($from_statename['name'] != ''){ $from_location = $from_statename['name']; }
		}
	
		$to_imagelink   = "<img src='" . $cfg['path']['url_site'] . "showphoto.php?id=" . $to_array['id'] . "&t=s&p=1&a=Y'>";
		$from_imagelink = "<img src='" . $cfg['path']['url_site'] . "showphoto.php?id=" . $from_array['id'] . "&t=s&p=1&a=Y'>";
	
		$to_videolink   = "<img src='" . $cfg['path']['url_site'] . "showvideo.php?id=" . $to_array['id'] . "&t=s&p=1&a=Y'>";
		$from_videolink = "<img src='" . $cfg['path']['url_site'] . "showvideo.php?id=" . $from_array['id'] . "&t=s&p=1&a=Y'>";
	
		$hidden_image   = "<img height='0' witdh='0' src='" . $cfg['path']['url_site'] . "hiddenimage.php?email=" . urlencode($to_array['email']) . "&c_id=" . $campaignmail_id . "'>";
	
		$to_pass = @mysql_fetch_array(mysql_query("SELECT `pass` FROM `tblUsers` WHERE `id` = '" . $to_array['id'] . "' LIMIT 1"));
		$to_password = trim($to_pass['pass']);
	
		list($gallery_password) = @mysql_fetch_array(mysql_query("SELECT `gallery_pass` FROM `tblUsers` WHERE `id` = '" . $to_array['id'] . "' LIMIT 1"));
		$gallery_password = trim($gallery_password);
	
		$login = trim($to_array['screenname']) . "|" . trim($to_array['pass']);
		$login = md5($login);
	
		$login_link = $cfg['path']['url_site'] . "emaillogin.php?e_id=" . $to_array['id'] . "&c_id=" . $campaignmail_id . "&redirect=" . urlencode($redirect_to) . "&login=" . urlencode($login);
	
		$unsubscribe_link = $cfg['path']['url_site'] . "emaillogin.php?e_id=" . $to_array['id'] . "&c_id=" . $campaignmail_id . "&redirect=mem_emailoptions.php&login=" . urlencode($login) . "&u_id=Y";
	
		$internalprofile_link = $cfg['path']['url_site'] . "mem_profile.php?id=" . $to_array['id'];
		$externalprofile_link = $cfg['path']['url_site'] . "profileid.php?profile=" . $to_array['id'];
	
		$replacestring = str_replace(array('[%to_name%]',
		                                   '[%from_name%]',
		                                   '[%to_location%]',
		                                   '[%from_location%]',
		                                   '[%to_imagelink%]',
		                                   '[%from_imagelink%]',
		                                   '[%to_videolink%]',
		                                   '[%from_videolink%]',
		                                   '[%hidden_image%]',
		                                   '[%login_link%]',
		                                   '[%unsubscribe_link%]',
		                                   '[%internalprofile_link%]',
		                                   '[%externalprofile_link%]',
		                                   '[%to_password%]',
		                                   '[%gallery_password%]',
		                                   '[%accept%]',
										   '[%deny%]',
											'[%to_user_email%]'),
		                             array($to_name,
		                                   $from_name,
		                                   $to_location,
		                                   $from_location,
		                                   $to_imagelink,
		                                   $from_imagelink,
		                                   $to_videolink,
		                                   $from_videolink,
		                                   $hidden_image,
		                                   $login_link,
		                                   $unsubscribe_link,
		                                   $internalprofile_link,
		                                   $externalprofile_link,
		                                   $to_password,
		                                   $gallery_password,
		                                   "<a href='javascript:;' onclick='{$cfg['path']['url_site']}'>accept</a>",
		                                   "<a href='javascript:;' onclick='{$cfg['path']['url_site']}'>deny</a>",
		                                   $to_user_email), $replacestring);
	
		return $replacestring;
	}
}


if (!function_exists('typelocloc')) {
	function typelocloc($joined){
			global $db;
			list($ret['sess_country'],
			     $ret['sess_state'],
			     $ret['sess_city']) = @mysql_fetch_array
			     					(
			                           mysql_query("SELECT `country`,`state`,`city` 
			                    				    FROM `tblLocations` 
			                                        WHERE  `user_id`   = '".$_SESSION['sess_id']."' AND 
			                                               `fromdate` <= '".$joined."'              AND 
			                                               `todate`   >= '".$joined."'
			                                        LIMIT 1"
			                                      )
			                         );
			                         
			if(!$ret['sess_country']) $ret['sess_country'] = $_SESSION['sess_country'];
			if(!$ret['sess_state'])   $ret['sess_state']   = $_SESSION['sess_state'];
			if(!$ret['sess_city'])    $ret['sess_city']    = $_SESSION['sess_city'];
			
			if($ret['sess_country'] != 1) $ret['sess_state'] = 0;
			
		return $ret;
	}
}

if (!function_exists('id_to_screenname')) {
	function id_to_screenname($id) {
		$query = @mysql_query("SELECT `screenname` FROM `tblUsers` WHERE `id` = '" . $id . "' LIMIT 1");
		$arr = @mysql_fetch_array($query);
		return $arr['screenname']?$arr['screenname']:'-Unknown-';
	}
}

if (!function_exists('operator_to_name')) {
	function operator_to_name($id) {
		$query = @mysql_query("SELECT `user` FROM `tblAdmin` WHERE `id` = '" . $id . "' LIMIT 1");
		$arr = @mysql_fetch_array($query);
		return $arr['user']?$arr['user']:'-Unknown-';
	}
}

function chat_mails_bgcolor($user_to, $user_from)
{
	global $cfg;

	$datesent = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-$cfg['option']['urgent_mail'],date("Y")));

	$arr = mysql_fetch_array(mysql_query("SELECT COUNT(*) as count
	                                             FROM `tblTypeMails`
	                                             WHERE `user_from` = '". $user_from ."' AND
												       `user_to` = '". $user_to ."' AND
												       `operator_id` = '0' AND
												  	   `folder` = '1' AND
												  	   (`urgent` = 'Y' OR `date_sent` <= '" . $datesent ."')"));
												  	  //(`urgent` = 'Y' OR `date_sent` <= '" . $datesent ."')"));

	if($arr['count'] > 0) return true;

	return false;
}



/*function admin_send_mail($db,$email,$for,$type,$to_id,$from_id)
{
	$to_array   = $db->get_row("SELECT * FROM `tblUsers` WHERE `id` = '" . $to_id   . "' LIMIT 1");
	$from_array = $db->get_row("SELECT * FROM `tblUsers` WHERE `id` = '" . $from_id . "' LIMIT 1");

	$mail = $db->get_row("SELECT `subject`,`message` FROM `tblMailerMachine` WHERE `for` = '".$for."' AND `type` = '".$type."'");

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: FlirtiGo.com <donotreply@flirtigo.com>\r\n";

    $subject = replace_before_send($mail['subject'], $to_array, $from_array);
    $message = replace_before_send($mail['message'], $to_array, $from_array);

	@mail($email, $subject, $message, $headers);
}*/



function admin_send_mail($db,$allow_email,$for,$type,$to_id,$from_id)
{
	global $cfg, $whisper_id;

	$to_array   = $db->get_row("SELECT * FROM `tblUsers` WHERE `id` = '" . $to_id   . "' LIMIT 1");
	$from_array = $db->get_row("SELECT * FROM `tblUsers` WHERE `id` = '" . $from_id . "' LIMIT 1");

	$mail = $db->get_row("SELECT `subject`,`message`,`folder` FROM `tblMailerMachine` WHERE `for` = '".$for."' AND `type` = '".$type."'");
	
	if($mail['subject']!="" && $mail['message']!=""){
    	$subject = replace_before_send($mail['subject'], $to_array, $from_array);
    	$message = replace_before_send($mail['message'], $to_array, $from_array);


		if($type == 'external' && ($to_array[$allow_email] == "Y" or $allow_email == "Y") && $subject && $message)
		{
			send_mail($to_array['email'], $to_array['screenname'], $subject, $message);
		}
		elseif($type == 'internal')
		{
			$into_table = "tblMails";

			if($for == 'new_whisper') $e_type = 'F'; else $e_type = 'E';

			if($for == 'new_whisper' && $to_array['typeusr'] == "Y") { $into_table = "tblTypeWhispers"; $message = $whisper_id;}


			@$db->query("INSERT INTO `". $into_table ."` ( `user_id`,
			                                           `user_from`,
			                                           `user_to`,
			                                           `subject`,
			                                           `message`,
			                                           `folder`,
			                                           `type`,
			                                           `date_sent`
			                                          )
			                                  VALUES ( '" . $to_id . "',
			                                           '" . $from_id . "',
			                                           '" . $to_id . "',
			                                           '" . addslashes( $subject ) . "',
			                                           '" . addslashes( $message ) . "',
			                                           '" . $mail['folder']. "',
			                                           '" . $e_type . "',
			                                           NOW()
			                                          )");
		}
	}
}


function admin_sent_message($db, $to, $from_id, $subject, $message, $savemail)
{
	global $cfg;

	//$to_id = @$db->get_row("SELECT `id`, `typeusr` FROM `tblUsers` WHERE `disabled` = 'N' AND `screenname` = '" . $to . "' LIMIT 1");
	$to_id = @$db->get_row("SELECT `id`, `typeusr` FROM `tblUsers` WHERE `disabled` = 'N' AND (`screenname` = '" . $to . "' OR `id`=" . $to . ") LIMIT 1");
	$into_table = $to_id['typeusr'] == 'Y'?'tblTypeMails':'tblMails';
	
	if($to_id['id'] > 0){
		$is_block = @$db->get_var("SELECT `type` FROM `tblHotBlockList`
		                                       WHERE `user_id` = '" . $to_id['id'] . "' AND
		                                             `friend_user_id` = '" . $from_id. "' AND
		                                             `type` = 'B'
		                                       LIMIT 1");

		if($is_block != 'B'){
			$send_mail = @$db->query("INSERT INTO `". $into_table ."` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`date_sent`)
			                                       VALUES    ('" . $to_id['id'] . "','" . $from_id . "','" . $to_id['id'] . "','" . addslashes( $subject ) . "','" . addslashes( $message ) . "',NOW())");

			if(!$send_mail){
				return "Unknown error, message was not sent.";
			}

			if($savemail == 1){
				$operator = $_SESSION['admin']>0?$_SESSION['admin']:1;
				$save_mail = @$db->query("INSERT INTO `tblTypeMails` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`folder`,`new`,`operator_id`,`date_sent`)
			                                           VALUES    ('" . $from_id . "','" . $from_id . "','" . $to_id['id'] . "','" . addslashes( $subject ) . "','" . addslashes( $message ) . "','2','N','".$operator."',NOW())");

				$update = @$db->query("UPDATE `tblTypeMails` SET `operator_id` = '" . $operator ."', `new` = 'N', `urgent` = 'N'
				                                             WHERE `user_id` = '" . $from_id ."' AND
				                                                   `user_from` = '" . $to_id['id'] . "' AND
				                                                   `operator_id` = '0' AND
				                                                   `folder` = '1'");
			    @$db->query("UPDATE `tblUsers` SET `mailreceived` = 'Y' WHERE `mailreceived` = 'N' AND `id` = '". $to_id['id'] ."' LIMIT 1");
			    @$db->query("UPDATE `tblPhotos` SET `photo_viewed` = `photo_viewed` + 1 WHERE `user_id` = '". $to_id['id'] ."' LIMIT 4");

			    /* ... update tblMails ... */
				$upobj_mails = @mysql_query("SELECT *
						    			FROM `tblTypeMails`
						    			WHERE `user_id` = '" . $from_id . "'       AND
								  			  `user_from` = '" . $to_id['id'] . "' AND
								  			  `folder` = '1'
						    			ORDER BY `date_sent` DESC"
						    		   );
				while($upMailsobj = @mysql_fetch_object($upobj_mails)){
					@$db->query("UPDATE `tblMails` SET `new` = 'N' WHERE `id_to_id` = '" . (int) $upMailsobj->id ."' AND `user_to` = '".$upMailsobj->user_to."'");
				}
			    /* ..end update tblMails.. */

				/* ... update viewed table ... */
				if(!@mysql_num_rows(mysql_query("SELECT `user_id` FROM `tblViewedProfile` WHERE `user_id` = '" . $to_id['id'] . "' AND `viewed_user_id` = '" . $from_id . "'"))){
					@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $to_id['id'] . "', '" . $from_id . "', NOW())");
				}
				/* ..end update viewed.. */
			}

			$email = @$db->get_row("SELECT `email`, `emailnotif` FROM `tblUsers` WHERE `id` = '" . $to_id['id'] . "' LIMIT 1");

			if($email['emailnotif'] == 'Y')
			{
				admin_send_mail($db,'Y','new_message','external',$to_id['id'],$from_id);
			}
		}
	} else {
		$to_id = @$db->get_row("SELECT `id` FROM `tblUsers` WHERE `screenname` = '" . $to . "' LIMIT 1");

		$update = @$db->query("UPDATE `tblTypeMails` SET   `new` = 'N', `urgent` = 'N'
			                                         WHERE `user_id` = '" . $from_id ."' AND
				                                           `user_from` = '" . $to_id['id'] . "' AND
				                                           `operator_id` = '0' AND
				                                           `folder` = '1'");

		return "User was not found in our database!";
	}
}

function box_sent_message($db, $to, $from_id, $subject, $message, $savemail)
{
	global $cfg;

	$to_id = @$db->get_row("SELECT `id`, `typeusr` FROM `tblUsers` WHERE `disabled` = 'N' AND `screenname` = '" . $to . "' LIMIT 1");
	$into_table = $to_id['typeusr'] == 'Y'?'tblTypeMails':'tblMails';

	if($to_id['id'] > 0){
		$is_block = @$db->query("SELECT `type` FROM `tblHotBlockList`
		                                       WHERE `user_id` = '" . $to_id['id'] . "' AND
		                                             `friend_user_id` = '" . $from_id. "' AND
		                                             `type` = 'B'
		                                       LIMIT 1");
		if(!$is_block){
			$send_mail = @$db->query("INSERT INTO `". $into_table ."` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`date_sent`)
			                                       VALUES    ('" . $to_id['id'] . "','" . $from_id . "','" . $to_id['id'] . "','" . addslashes( $subject ) . "','" . addslashes( $message ) . "',NOW())");

			if(!$send_mail){
				return "Unknown error, message was not sent.";
			}

			    /* ... update tblMails ... */
				$upobj_mails = @mysql_query("SELECT *
						    			FROM `tblTypeMails`
						    			WHERE `user_id` = '" . $from_id . "'       AND
								  			  `user_from` = '" . $to_id['id'] . "' AND
								  			  `folder` = '1'
						    			ORDER BY `date_sent` DESC"
						    		   );
				while($upMailsobj = @mysql_fetch_object($upobj_mails)){
					@$db->query("UPDATE `tblMails` SET `new` = 'N' WHERE `id_to_id` = '" . (int) $upMailsobj->id ."' AND `user_to` = '".$upMailsobj->user_to."'");
				}
			    /* ..end update tblMails.. */

			/* ... update viewed table ... */
			if(!@mysql_num_rows(mysql_query("SELECT `user_id` FROM `tblViewedProfile` WHERE `user_id` = '" . $to_id['id'] . "' AND `viewed_user_id` = '" . $from_id . "'"))){
				@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $to_id['id'] . "', '" . $from_id . "', NOW())");
			}
			/* ..end update viewed.. */

			if($savemail == 1){
				$operator = $_SESSION['admin']>0?$_SESSION['admin']:1;
				$save_mail = @$db->query("INSERT INTO `". $into_table ."` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`folder`,`new`,`operator_id`,`date_sent`)
			                                           VALUES    ('" . $from_id . "','" . $from_id . "','" . $to_id['id'] . "','" . addslashes( $subject ) . "','" . addslashes( $message ) . "','2','N','".$operator."',NOW())");

			    @$db->query("UPDATE `tblUsers` SET `mailreceived` = 'Y' WHERE `mailreceived` = 'N' AND `id` = '". $to_id['id'] ."' LIMIT 1");
			    @$db->query("UPDATE `tblPhotos` SET `photo_viewed` = `photo_viewed` + 1 WHERE `user_id` = '". $to_id['id'] ."' LIMIT 4");

				/* ... update viewed table ... */
				if(!@mysql_num_rows(mysql_query("SELECT `user_id` FROM `tblViewedProfile` WHERE `user_id` = '" . $to_id['id'] . "' AND `viewed_user_id` = '" . $from_id . "'"))){
					@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $to_id['id'] . "', '" . $from_id . "', NOW())");
				}
				/* ..end update viewed.. */
			}

			$email = @$db->get_row("SELECT `email`, `emailnotif` FROM `tblUsers` WHERE `id` = '" . $to_id['id'] . "' LIMIT 1");

			if($email['emailnotif'] == 'Y')
			{
				admin_send_mail($db,'Y','new_message','external',$to_id['id'],$from_id);
			}
		}
	} else {
		$to_id = @$db->get_row("SELECT `id` FROM `tblUsers` WHERE `screenname` = '" . $to . "' LIMIT 1");

		$update = @$db->query("UPDATE `tblTypeMails` SET   `new` = 'N', `urgent` = 'N'
			                                         WHERE `user_id` = '" . $from_id ."' AND
				                                           `user_from` = '" . $to_id['id'] . "' AND
				                                           `operator_id` = '0' AND
				                                           `folder` = '1'");

		return "User was not found in our database!";
	}
}


if (!function_exists('ip2country')) {
	function ip2country($ip) {
		$sql = "SELECT `country` FROM `tblNationsIp` WHERE `ip` < INET_ATON('" . $ip . "') ORDER BY ip DESC LIMIT 0,1";
		list($country) = @mysql_fetch_row(mysql_query($sql));
	
		return $country;
	}
}

if (!function_exists('looking')) {
	function looking($looking) {
		global $cfg;
	
		for($param = 0; $param < count($cfg['profile']['looking']); $param++) {
			if($looking & (1 << $param)) {
				if(empty($look)) {
				    $look = $cfg['profile']['looking'][$param];
				} else {
					$look .= ", " . $cfg['profile']['looking'][$param];
				}
			}
		}
	
		return $look;
	}
}

if (!function_exists('looking_array')) {
	function looking_array($looking) {
		global $cfg;
	
		for($param = 0; $param < count($cfg['profile']['looking']); $param++) {
			if($looking & (1 << $param)) {
				if(empty($look)) {
				    $look = 1;
				    $look_array[$param] = 1;
				} else {
					$look_array[$param] = 1;
				}
			}
		}
	
		return $look_array;
	}
}

if (!function_exists('forr')) {
	function forr($forr)
	{
		global $cfg;
	
		for($param = 0; $param < count($cfg['profile']['for']); $param++)
		{
			if($forr & (1 << $param)){
				if(empty($for)){
				    $for = $cfg['profile']['for'][$param];
				}
				else
				{
					$for .= ", " . $cfg['profile']['for'][$param];
				}
			}
		}
	
		return $for;
	}
}

if (!function_exists('forr_array')) {
	function forr_array($forr)
	{
		global $cfg;
	
		for($param = 0; $param < count($cfg['profile']['for']); $param++)
		{
			if($forr & (1 << $param)){
				if(empty($for)){
				    $for = 1;
				    $for_array[$param] = 1;
				}
				else
				{
					$for_array[$param] = 1;
				}
			}
		}
	
		return $for_array;
	}
}

if (!function_exists('fetishes_array')) {
	function fetishes_array($forr)
	{
		global $cfg;
	
		for($param = 0; $param < count($cfg['profile']['sexualactivities']); $param++)
		{
			if($forr & (1 << $param)){
				if(empty($for)){
				    $for = 1;
				    $for_array[$param] = 1;
				}
				else
				{
					$for_array[$param] = 1;
				}
			}
		}
	
		return $for_array;
	}
}

function admin_checkpicture()
{
	global $cfg, $_FILES;

	if (is_uploaded_file($_FILES['photo_file']['tmp_name']) AND isset($_FILES['photo_file']['tmp_name']))
	{
		$picture_size = getimagesize($_FILES['photo_file']['tmp_name']);
		if ($picture_size[0] < 200 OR $picture_size[1] < 200){
			return "Photo must be at least 200x200 px!";
		}
		if ($picture_size[0] > 1000 OR $picture_size[1] > 1000){
			return "Photo must be at most 1000x1000 px!";
		}

		if ($_FILES['photo_file']['size'] > ceil($cfg['option']['picture_size'] * 1024 * 1024))
			return "<br />File to big. Maximum file size: " . $cfg['option']['picture_size'] . " MB.";
	}
	elseif ($_FILES['photo_file']['tmp_name'] == "" or $_FILES['photo_file']['size'] == 0)
	{
		return "Unknown file type.";
	}
	else
	{
		return "Uknown Error.";
	}

	return 0;
}

function admin_upload_picture($db, $id, $pic_name, $pic_description)
{
	global $cfg, $_FILES;

	if (is_uploaded_file($_FILES['photo_file']['tmp_name']) AND isset($_FILES['photo_file']['tmp_name']))
	{
		@$db->query("INSERT INTO tblPhotos (`user_id`, `photo_name`, `photo_description`, `approved`, `upload_ip`)
			         VALUES ('" . $id . "', '" . $pic_name . "', '" . $pic_description ."', 'Y', '" . $_SERVER['REMOTE_ADDR'] . "')"
		);
		$pic_tblid = mysql_insert_id();

		$sFile_ = $cfg['path']['dir_photos'] . $id . "_" . $pic_tblid . "_";
		$im = new Image();

		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['b_x'], $cfg['image']['b_y'], $cfg['image']['watermark'], $cfg['image']['watermark_size']);
			$im->save($sFile_ . "b.jpg", $cfg['image']['quality']);
		}
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['m_x'], $cfg['image']['m_y'], $cfg['image']['watermark'], $cfg['image']['watermark_size']);
			$im->save($sFile_ . "m.jpg", $cfg['image']['quality']);
		}
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['s_x'], $cfg['image']['s_y'], $cfg['image']['watermark'], 0);
			$im->save($sFile_ . "s.jpg", $cfg['image']['quality']);
		}
		if ($im->load($_FILES['photo_file']['tmp_name']))
		{
			$im->resize($cfg['image']['r_x'], $cfg['image']['r_y'], $cfg['image']['watermark'], 0);
		}
	}
}

if (!function_exists('send_mail')) {
	function send_mail($to_email, $to_name, $subject, $message)
	{
		$mail          = new PHPMailer();
	
		$mail->Subject = stripslashes($subject);
		$mail->Body    = stripslashes($message);
	
		/*
		$mail->FromName = 'DirtyFlirting';
		$mail->From     = 'alert@dirtyalerts.com';
		$mail->Hostname = 'dirtyalerts.com';
		$mail->Host     = 'dirtyalerts.com';
		$mail->Sender   = 'alert@dirtyalerts.com';
		$mail->Helo     = 'dirtyalerts.com';
		*/
		
		$mail->FromName = 'FlirtiGo';
		$mail->From     = 'no-reply@flirtigo.com';
		//$mail->Hostname = 'mail.flirtigo.com';
		//$mail->Host     = 'mail.flirtigo.com';
		$mail->Sender   = 'no-reply@flirtigo.com';
		$mail->Helo     = 'mail.flirtigo.com';
	
		//$mail->IsQmail;
		$mail->AddAddress($to_email,$to_name);
		$mail->IsHTML(true);
		if($mail->send())
		{
			$mail->ClearAddresses();
		
			return true;
		}else{
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
	
		return false;
	}
}

if (!function_exists('bannedwords')) {
	function bannedwords($db, $type = "B", $text = "")
	{
		$words = $db->get_results("SELECT `word` FROM `tblFilters` WHERE `type` != '" . $type . "'");
	
		foreach($words as $key => $value)
		{
			$replace_what[] = $value['word'];
			$replace_with[] = "<font color='red'><B>" . $value['word'] . "</B></font>";
		}
	
		$text = str_replace($replace_what, $replace_with, $text);
	
		return $text;
	}
}

function payments_stats($username)
{
	global $db;
	
	// find processor ... 
	
		$is_ccbill = $db->get_var("SELECT `username` FROM `ccbill_post` WHERE `username` = '" . $username . "' ");
		if(!$is_ccbill){
			$is_2000 = $db->get_var("SELECT `client_username` FROM `tblPayments2000` WHERE `client_username` = '" . $client_username . "' ");
			if(!$is_2000){
				$arr['processor'] = $arr['date'] = '-';
			}else{
				$arr['processor'] = '2000Charge';
				$arr['date']      = $db->get_var("SELECT `date` FROM `tblPayments2000` WHERE `client_username` = '" . $client_username . "' ORDER BY `date` ASC LIMIT 1");
				$arr['amount']    = $db->get_var("SELECT SUM(`client_amount`) FROM `tblPayments2000` WHERE `client_username` = '" . $client_username . "'");
				$arr['months']    = $db->get_var("SELECT COUNT(`client_amount`) FROM `tblPayments2000` WHERE `client_username` = '" . $client_username . "' AND `status` = 'add'");
			}
		}else{
			$arr['processor'] = 'CCBill';
			$arr['date']      = $db->get_var("SELECT `start_date` FROM `ccbill_post` WHERE `username` = '" . $username . "' ORDER BY `start_date` ASC LIMIT 1");
			$arr['amount']    = $db->get_var("SELECT SUM(`initialPrice`) FROM `ccbill_post` WHERE `username` = '" . $username . "'");
			$arr['amount']   += $db->get_var("SELECT SUM(`amount`) FROM `ccbill_rebills`,`ccbill_post` WHERE `ccbill_rebills`.`subscription_id` = `ccbill_post`.`subscription_id` AND `ccbill_post`.`username` = '" . $username . "'");
			$arr['months']    = $db->get_var("SELECT COUNT(`initialPrice`) FROM `ccbill_post` WHERE `username` = '" . $username . "'");
			$arr['months']   += $db->get_var("SELECT COUNT(`amount`) FROM `ccbill_rebills`,`ccbill_post` WHERE `ccbill_rebills`.`subscription_id` = `ccbill_post`.`subscription_id` AND `ccbill_all_ipn`.`username` = '" . $username . "'");
		}
	
	return $arr;
}

function idtooperator($id)
{
	global $db;

	return $db->get_var("SELECT `user` FROM `tblAdmin` WHERE `id` = '" . (int) $id . "'");
}
?>