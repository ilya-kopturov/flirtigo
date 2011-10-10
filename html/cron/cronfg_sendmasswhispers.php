<?php
/* DIRTYFLIRTING.COM */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');
ini_set("display_errors", 1);

set_include_path(".:/home/httpd/vhosts/flirtigo.com/html/pear:/home/httpd/vhosts/flirtigo.com/html/includes");

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once($include_dir . "/includes/config/" . "db.php");
include_once($include_dir . "/includes/config/" . "path.php");
include_once($include_dir . "/includes/config/" . "mail.php");
include_once($include_dir . "/includes/config/" . "crypt.php");
include_once($include_dir . "/includes/config/" . "image.php");
include_once($include_dir . "/includes/config/" . "option.php");
include_once($include_dir . "/includes/config/" . "profile.php");
include_once($include_dir . "/includes/config/" . "template.php");

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");


include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php"        );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_sendmasswhispers", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_sendmasswhispers.php") && !strstr($line, "/bin/sh -c"))
		{
			echo $line. "\n";
			$cronruns++;
		}
	}
}
if ($cronruns >= 2)
{
	die("Cron 'cron_sendmasswhispers.php' allready runs!!!");
}
/* ................................ end of check  ........................................*/

/*          mailer and set headers                */
$mail = new PHPMailer();
/*          end mailer set                       */


/*                         START CRON                                                     */
$sql = mysql_query("SELECT `id`, `sendexternal`, `interval`, `whisperid`, `toseed`, `toevery` FROM `tblMassWhispers` WHERE `finishedaddmails` = 'Y' AND `finished` = 'N' AND `running` = 'Y'");
$nrows = mysql_num_rows($sql);

if($nrows > 0)
{
	while($obj = mysql_fetch_object($sql))
	{
		if($obj->sendexternal == 'N'){ $s_limit = 50000; } else { $s_limit = 30; }
		
		$sql_mails = mysql_query("SELECT * FROM `tblMassWhispersMails` WHERE `sent` = 'N' AND `campaignid` = '" . $obj->id ."' LIMIT " . $s_limit); 
		    
		$nrows_mails = mysql_num_rows($sql_mails);
		
		if($nrows_mails > 0)
		{
			while($obj_mails = mysql_fetch_object($sql_mails))
			{
				/* create subjects and messages*/
				$messagetext = create_message_text($obj_mails->toid, $obj_mails->sendid, $obj->whisperid, $obj->id);
				/* end end end end end end end */
				
		        /*  SETTINGS FOR MAILER                */
				if(strstr($obj_mails->toemail,"@yahoo")){
					$extraserver=" syahoo='1'";$slptime=1;
				}elseif(strstr($obj_mails->toemail,"@hotmail")){
					$extraserver=" shotmail='1'";$slptime=2;
				}elseif(strstr($obj_mails->toemail,"@msn")){
					$extraserver=" shotmail='1'";$slptime=2;
				}elseif(strstr($obj_mails->toemail,"@aol")){
					$extraserver=" saol='1'";$slptime=3;
				}else{
					$extraserver=" sother='1'";$slptime=4;
				}
				
			
			$sqlserver = mysql_query("SELECT * FROM `tblServers` WHERE active='1' and ".$extraserver." order by rand() limit 1");
			$nrowsserver = mysql_num_rows($sqlserver);
			$sqlfromname = mysql_query("SELECT * FROM `tblServersFromList`  order by rand() limit 1");

			if($nrowsserver > 0)
			{			
    			$objserver = mysql_fetch_object($sqlserver);
				$objfromname =  mysql_fetch_object($sqlfromname);
				
				
				if($slptime==1) {$stime=$objserver->timeyahoo;}
				if($slptime==2) {$stime=$objserver->timehotmail;}
				if($slptime==3) {$stime=$objserver->timeaol;}
				if($slptime==4) {$stime=$objserver->timeother;}				
				
				///////////////////////////////////////////////////
				
				$from=$objfromname->fromname."@".$objserver->domain;
				$fromname=id_to_screenname($obj_mails->sendid);
				$sender=$objfromname->fromname."@".$objserver->domain;
				$domain=$objserver->domain;
				$domainip=$objserver->domain;
				$helo=$objserver->helo;
				$subject=$messagetext['subjectexternal'];
				$message=$messagetext['messageexternal'];
				$to=$obj_mails->toemail;
				$toname=id_to_screenname($obj_mails->toid);
				$servername=$objserver->servername;
				
				///////////////////////////////////////////////////				
				
				//sleep($stime);
				
				$mail->FromName = $fromname;
				$mail->From     = $from;
				$mail->Sender   = $sender;
								
				$mail->Hostname = $domain;
				$mail->Host     = $domainip;
				$mail->Helo     = $helo;
				
				$mail->Subject = stripslashes($subject);
				$mail->Body    = stripslashes($message);
				
				$mail->AddAddress($to,$toname);
				
				$mail->IsHTML(true);
				if ($objserver->serverlocation==0) $mail->IsQmail(); else $mail->IsSmtp();
                
				
			/*               END SETTINGS MAILER         */	
				
				
				if($obj_mails->toid && $obj_mails->sendid)
				{
					$is_block = 0;
					$is_block = @$db->get_var("SELECT COUNT(*) as block FROM `tblHotBlockList` 
		                                                   WHERE `user_id` = '" . $obj_mails->toid . "' AND 
		                                                         `friend_user_id` = '" . $obj_mails->sendid. "' AND 
		                                                         `type` = 'B' LIMIT 1");
					
					$is_allow = @$db->get_var("SELECT `emailnotif` FROM `tblUsers` WHERE `id` = '" . $obj_mails->toid . "' LIMIT 1");
					
					if(!$is_block)
					{
						$whisper_id = $flirt_id = (int) $obj->whisperid;
						$to = (int)$obj_mails->toid;
											
						//$flirt = $db->get_row("SELECT * FROM tblWhispers WHERE id = '".$obj->whisperid."' LIMIT 1");
						
						$message = @$db->get_var("SELECT `whisper` FROM `tblWhispers` WHERE `id` = '" . (int) $obj->whisperid . "' LIMIT 1");
						$whisper_details = "<img align='absmiddle' src='".$cfg['path']['url_site']."/images/".$obj->whisperid.".gif' border='0'> <b><br>" . $message . "</b>";
						        
						mailermachine($db, 'emailnotif', 'new_whisper', 'internal', $obj_mails->toid, $obj_mails->sendid);
						
						$db->query("UPDATE `tblMassWhispersMails` 
									SET    `sent` = 'Y' 
									WHERE  `id` = " . (int) $obj_mails->id . " 
									LIMIT   1");
						
						/* ... update viewed table ... */
						if(!@mysql_num_rows(mysql_query("SELECT `user_id` FROM `tblViewedProfile` WHERE `user_id` = '" . $obj_mails->sendid . "' AND `viewed_user_id` = '" . $obj_mails->toid . "'"))){
							@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $obj_mails->sendid . "', '" . $obj_mails->toid . "', NOW())");
						}
						/* ..end update viewed.. */
						
						if($is_allow == 'Y' && $obj->sendexternal == 'Y')
						{
						    if($objserver->serverlocation=='1')
						    {
						    $sqlxxx = mysql_query("SELECT * FROM `tblTempCampaignMails` WHERE `origin` = 'masswhispers' AND `sendid` = '$obj_mails->id' AND `campaignid` = '" . $obj->id ."'"); 
  						    $rowsfound = mysql_num_rows($sqlxxx);
						    if($rowsfound==0)
						    {
						    	$sqlremote="INSERT INTO `tblTempCampaignMails` (`origin`,`campaignid`,`fromname`,`from`,`to`,`toname`,`domain`,`domainip`,`helo`,`subject`,`message`,`servername`,`stime`,`sendid`) 
								values ('masswhispers','$obj->id','$fromname','$from','".$obj_mails->toemail."','$toname','$domain','$domainip','$helo','".addslashes($subject)."','".addslashes($message)."','$servername','$stime','$obj_mails->id')";
						    	//echo $sqlremote;
						    	@mysql_query($sqlremote);
						    	echo "Inserare in temporary: " . $obj_mails->toemail . "\n";
						    	@mysql_query("UPDATE `tblMassWhispersMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
						    }
						    }
						    else
						    {
							sleep($stime);
						    
							if($mail->send()){
								@mysql_query("UPDATE `tblMassWhispers` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
								@mysql_query("UPDATE `tblMassWhispersMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
								@mysql_query("UPDATE `tblServers` set `emailno`= `emailno` + 1 where id='$objserver->id'");
								echo "Mesaj extern trimis: " . $obj_mails->toemail . "\n";
								
							}else{
								@mysql_query("UPDATE `tblMassWhispers` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
								@mysql_query("UPDATE `tblMassWhispersMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
								echo "Mail was not sent, mail->send() error! " . $mail->ErrorInfo . " \n";
							}
						    }
						}
						else
						{
							echo "Is_allow: " . $is_allow . ", SendExternal: " . $obj->sendexternal . "\n";
							echo "Email: " . $obj_mails->toemail . "\n";
							
							@mysql_query("UPDATE `tblMassWhispers` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
							@mysql_query("UPDATE `tblMassWhispersMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
						}
					}
					else
					{
						echo "Is_block: " . $is_block . ", SendExternal: " . $obj->sendexternal . "\n";
						echo "Email: " . $obj_mails->toemail . "\n";
						
						@mysql_query("UPDATE `tblMassWhispers` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
						@mysql_query("UPDATE `tblMassWhispersMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' LIMIT 1");
					}
				}
				
				$mail->ClearAddresses();
				
				
				/*                  SEED SENDING         */
				
				$email_nr = @$db->get_var("SELECT `sent` FROM `tblMassWhispers` WHERE `id` = '" . $obj->id . "' LIMIT 1");
				
				if($obj->toevery > 0){
				if( ( ($email_nr%($obj->toevery * 1000)) == 0 ) AND $obj->toseed  AND $obj->toevery > 0)
				{
					$addrs = explode(",", $obj->toseed);
					
					for($i=0;$i<count($addrs);$i++)
					{
						$mail->AddAddress($addrs[$i],$addrs[$i]);
						echo $addrs[$i] . "\n";
					}
					
					echo $mail->Subject . ", " . $mail->Body . "\n";
					
					$mail->send();
					$mail->ClearAddresses();
					
				}
				}
				/*               END SEED SENDING          */
				}
			 	else
			 	{
			 		echo "Nrowsserver: " . $nrowsserver . " Nu exista server pt mailul: " . $obj_mails->toemail . "\n";
			 	}
				/*               END SENDING EMAIL         */
			 }
		}
		else
		{
			$sql_finish   = mysql_query("SELECT * FROM `tblMassWhispersMails` WHERE `sent` = 'N' AND `campaignid` = '" . $obj->id ."' LIMIT 1");
			$nrows_finish = mysql_num_rows($sql_finish);
			if($nrows_finish == 0)
			{
				list($update_campaign_b) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblMassWhispersMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'B'"));
				
				list($update_campaign_d) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblMassWhispersMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'D'"));
				
				@mysql_query("UPDATE `tblMassWhispers` SET `bounced` = '" . $update_campaign_b . "' WHERE `id` = '" . $obj->id . "' LIMIT 1");
				
				echo "Campaign " . $obj->id . " it's Finished! All mails was sent!!";
				@mysql_query("UPDATE `tblMassWhispers` SET `finished` = 'Y', `running` = 'N' WHERE `id` = '" . $obj->id . "'");
				@mysql_query("DELETE FROM `tblMassWhispersMails` WHERE `campaignid` = '" . $obj->id . "'");
			}
			else
			{
				echo "Mai sunt de trimis " . $nrows_finish . " mailuri de trimis din campania " . $obj->id . "\n";
			}
		}
		
	}
} 
else 
{
	echo "No campaign is running in this moment!";
}

/*                       END START CRON                                                   */

/*   functions   */
function create_message_text($toid, $sendid, $whisperid, $mw_id)
{
	global $db, $cfg, $message;
	
	$masswhispers_id = $mw_id;
 	$redirect_to     = "mem_index.php";
 	
 	$to_array   = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 	                                                     FROM `tblUsers` WHERE `id` = '" . $toid . "'"));
    
 	$from_array = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 	                                                     FROM `tblUsers` WHERE `id` = '" . $sendid . "'"));
    
	$message = @$db->get_var("SELECT `whisper` FROM `tblWhispers` WHERE `id` = '" . (int) $whisperid . "'");
	$message = "<img align='absmiddle' src='".$cfg['path']['url_site']."/images/".$whisperid.".gif' border='0'> <b>" . $message . "</b>";
    
	$mailinternal = $db->get_row("SELECT `subject`,`message` FROM `tblMailerMachine` WHERE `for` = 'new_whisper' AND `type` = 'internal'");
	$mailexternal = $db->get_row("SELECT `subject`,`message` FROM `tblMailerMachine` WHERE `for` = 'new_whisper' AND `type` = 'external'");
	
	
	
	//$messagewisper=str_replace("[%whisper_details%]",$message, $mailinternal['message']);
    
    $arr['subjectinternal'] = replace_before_send($mailinternal['subject'], $to_array, $from_array);
    $arr['subjectexternal'] = replace_before_send($mailexternal['subject'], $to_array, $from_array);

    $arr['messageinternal'] = replace_before_send($mailinternal['message'], $to_array, $from_array);
    $arr['messageexternal'] = replace_before_send($mailexternal['message'], $to_array, $from_array);
    
    return $arr;
}
/* end functions */
?>
