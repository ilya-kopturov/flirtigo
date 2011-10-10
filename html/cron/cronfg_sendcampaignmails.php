<?php
/* DIRTYFLIRTING.COM */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');
ini_set("display_errors", 1);

include_once realpath(dirname(__FILE__) . '/../includes/config') . '/common.php';		// fphp

include_once(PATH_INCLUDES . "class/db.php");

include_once(PATH_INCLUDES . "config/db.php");
include_once(PATH_INCLUDES . "config/path.php");
include_once(PATH_INCLUDES . "config/mail.php");
include_once(PATH_INCLUDES . "config/crypt.php");
include_once(PATH_INCLUDES . "config/image.php");
include_once(PATH_INCLUDES . "config/option.php");
include_once(PATH_INCLUDES . "config/profile.php");
include_once(PATH_INCLUDES . "config/template.php");

include_once(PATH_INCLUDES . "function/general.php");
include_once(PATH_INCLUDES . "function/profile.php");
include_once(PATH_INCLUDES . "function/mailer.php");

include_once(PATH_INCLUDES . "class/db.php");
include_once(PATH_INCLUDES . "PHPMailer/class.phpmailer.php");


$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_sendcampaignmails", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_sendcampaignmails.php") && !strstr($line, "/bin/sh -c"))
		{
			echo $line. "\n";
			$cronruns++;
		}
	}
}
if ($cronruns >= 2)
{
	die("Cron allready runs!!!");
}
/* ................................ end of check  ........................................*/

/*          mailer and set headers                */
$mail = new PHPMailer();
/*          end mailer set                       */


/*                         START CRON                                                     */
$sql = mysql_query("SELECT `id`, `interval`, `toseed`, `toevery`, `sendexternal`, `sendinternal`,`routed`,`messageinterntype`,`messageinterntype_id` FROM `tblCampaign` WHERE `finishedaddmails` = 'Y' AND `ready` = 'Y' AND `finished` = 'N' AND `running` = 'Y'");
$nrows = mysql_num_rows($sql);

if($nrows > 0) {
	while($obj = mysql_fetch_object($sql)) {
		$sql_mails = mysql_query("SELECT * FROM `tblCampaignMails` WHERE `sent` = 'N' AND `campaignid` = '" . $obj->id ."' LIMIT 1000"); 
		    
		$nrows_mails = mysql_num_rows($sql_mails);
		
		if($nrows_mails > 0) {
			while($obj_mails = mysql_fetch_object($sql_mails)) {
				echo  "\n" . "CampaignID: " . $obj->id . "\n";
			
		    /*               SETTINGS FOR MAILER           */			
				if(strstr($obj_mails->toemail,"@yahoo")){
					$extraserver=" syahoo=1";$slptime=1;$dest="yahoo";
				}elseif(strstr($obj_mails->toemail,"@hotmail")){
					$extraserver=" shotmail=1";$slptime=2;$dest="hotmail";
				}elseif(strstr($obj_mails->toemail,"@msn")){
					$extraserver=" shotmail=1";$slptime=2;$dest="hotmail";
				}elseif(strstr($obj_mails->toemail,"@aol")){
					$extraserver=" saol=1";$slptime=3;$dest="aol";
				}else{
					$extraserver=" sother=1";$slptime=4;$dest="yahoo";
				}
			
			if($obj->routed==1) {
				$sq="SELECT * FROM `tblServersRoute` WHERE dest='$dest' and campaignid='$obj->id' order by rand() limit 1";
				//echo $sq;
				$sqlroute = mysql_query($sq);
				if(mysql_num_rows($sqlroute) > 0) {    			
				    $objroute   = mysql_fetch_object($sqlroute);
				    $routeserver= $objroute->domainid;
				    $sqlserver = mysql_query("SELECT * FROM `tblServers` WHERE id='$routeserver' and sroute='1' and ".$extraserver);
			    } else {
				    $sqlserver = mysql_query("SELECT * FROM `tblServers` WHERE active='1' and ".$extraserver." order by rand() limit 1");
				}
			} else {
				$sqlserver = mysql_query("SELECT * FROM `tblServers` WHERE active='1' and ".$extraserver." order by rand() limit 1");
			}
			
			$nrowsserver = mysql_num_rows($sqlserver);
			$sqlfromname = mysql_query("SELECT * FROM `tblServersFromList`  order by rand() limit 1");


			if($nrowsserver > 0) {			
				//echo  "\n" . "Exista server pt CampaignID: " . $obj->id . "\n";
				
	        	$objserver   = mysql_fetch_object($sqlserver);
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
				$subject=$obj_mails->subjectextern;
				$message=$obj_mails->messageextern;
				$to=$obj_mails->toemail;
				$toname=id_to_screenname($obj_mails->toid);
				$servername=$objserver->servername;
				
				///////////////////////////////////////////////////				
				
				
			/*               END SETTINGS MAILER         */	
				
				
				if($obj_mails->toid && $obj_mails->sendid) {
					$is_block = 0;
					list($is_block) = mysql_fetch_row(mysql_query("SELECT `type` FROM `tblHotBlockList` 
		                                                   WHERE `user_id` = '" . $obj_mails->toid . "' AND 
		                                                         `friend_user_id` = '" . $obj_mails->sendid. "' AND 
		                                                         `type` = 'B' LIMIT 1"));
					
					list($is_allow) = mysql_fetch_row(mysql_query("SELECT `emailnotif` FROM `tblUsers` WHERE `id` = '" . $obj_mails->toid . "' LIMIT 1"));
				
					
				        if(!$is_block) {
					       $sqlxxx = @mysql_query("SELECT * FROM `tblTempCampaignMails` WHERE `sendid` = '$obj_mails->id' AND `campaignid` = '" . $obj->id ."'"); 
  					       $rowsfound = mysql_num_rows($sqlxxx);
					       if($rowsfound==0) {
					       
						    if($obj->sendinternal == 'Y') {
								$send_mail = @$db->query("INSERT INTO `tblMails` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`multimedia`,`attachment_id`,`date_sent`) 
			            			                   VALUES    ('" . $obj_mails->toid . "','" . $obj_mails->sendid . "','" . $obj_mails->toid . "','" . addslashes( $obj_mails->subjectintern ) . "','" . addslashes( $obj_mails->messageintern ) . "','" .$obj->messageinterntype."','".$obj->messageinterntype_id."',NOW())");
								if($email_id = mysql_insert_id()){
									//campaign_attach($email_id, (int) $obj->id);
									 
									echo "C_ID: " . $obj->id . "\n";
									
									$db->query("Update `tblCampaignMails`
									            SET    `sent` = 'Y'
									            WHERE  `id` = " . (int) $obj_mails->id . "
									            ORDER by id ASC LIMIT   1");
									
									$db->query("INSERT INTO `tblCampaignMailMatchMail` (`campaign_id`, `mail_id`) VALUES ({$obj->id}, {$email_id})");
								}
								
								/* ... update viewed table ... */
								@$db->query("DELETE FROM `tblViewedProfile` WHERE `user_id` = '" . $obj_mails->sendid . "' AND `viewed_user_id` = '" . $obj_mails->toid . "'");
								@$db->query("INSERT INTO `tblViewedProfile` (`user_id`,`viewed_user_id`,`date`) VALUES ('" . $obj_mails->sendid . "', '" . $obj_mails->toid . "', NOW())");
								/* ..end update viewed.. */
								
			                }
						
						    if($is_allow == 'Y') {
								/*
								$mail->FromName		= $fromname;
								$mail->From			= $from;
								
								$mail->Hostname		= "207.44.254.36";
								
								$mail->Subject = stripslashes($subject);
								$mail->Body    = stripslashes($message);
								
								$mail->AddAddress($to, $toname);
								
								$mail->IsHTML(true);
								$mail->IsSMTP();
								
								$mail->send();
								
								$mail->ClearAddresses();
								*/
						    	
							 	$sqlremote="INSERT INTO `tblTempCampaignMails` (`origin`,`campaignid`,`fromname`,`from`,`to`,`toname`,`domain`,`domainip`,`helo`,`multimedia`,`subject`,`message`,`servername`,`stime`,`sendid`) 
							 				values ('campaign','$obj->id','$fromname','$from','$to','$toname','$domain','$domainip','$helo','" . $obj->messageinterntype . "', '".addslashes($subject)."','".addslashes($message)."','$servername','$stime','$obj_mails->id')";
							 	@mysql_query($sqlremote); echo mysql_error();
							 	echo "Inserare in temporary: " . $obj_mails->toemail . "\n";
							 } else {
							    echo "Is_allow: " . $is_allow . ", SendExternal: " . $obj->sendexternal . "\n";
								echo "Email: " . $obj_mails->toemail . "\n";
							
								@mysql_query("UPDATE `tblCampaign` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
								@mysql_query("UPDATE `tblCampaignMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' ORDER by id ASC LIMIT 1");
						 	 }
						}
					} else {
						echo "Is_block: " . $is_block . ", SendExternal: " . $obj->sendexternal . "\n";
						echo "Email: " . $obj_mails->toemail . "\n";
						
						@mysql_query("UPDATE `tblCampaign` SET `sent` = `sent` + 1 WHERE `id` = '" . $obj->id . "'");
						@mysql_query("UPDATE `tblCampaignMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' ORDER by id ASC LIMIT 1");
					}
				}
			} else {
		 		echo "Nrowsserver: " . $nrowsserver . " Nu exista server pt mailul: " . $obj_mails->toemail . "\n";
		 	}
				/*               END SENDING EMAIL         */
			}
		} else {
			$sql_finish   = mysql_query("SELECT * FROM `tblCampaignMails` WHERE `sent` = 'N' AND `campaignid` = '" . $obj->id ."' LIMIT 1");
			$nrows_finish = mysql_num_rows($sql_finish);
			if($nrows_finish == 0) {
				list($update_campaign_b) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'B'"));
				
				list($update_campaign_d) = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cc FROM `tblCampaignMails` AS t1, `tblUsers` AS t2 
		                                                                                WHERE t1.campaignid = '" . $obj->id . "' AND t1.sent = 'Y' AND t1.toid = t2.id AND t2.emailstatus = 'D'"));
				
				@mysql_query("UPDATE `tblCampaign` SET `bounced` = '" . $update_campaign_b . "', `defered` = '" . $update_campaign_d . "' WHERE `id` = '" . $obj->id . "'  ORDER by id ASC LIMIT 1");
				
				echo "Campaign " . $obj->id . " it's Finished! All mails was sent!!";
				@mysql_query("UPDATE `tblCampaign` SET `finished` = 'Y', `running` = 'N', `finishedon` = NOW() WHERE `id` = '" . $obj->id . "'");
				@mysql_query("DELETE FROM `tblCampaignMails` WHERE `campaignid` = '" . $obj->id . "'");
			} else {
				echo "Mai sunt de trimis " . $nrows_finish . " mailuri de trimis din campania " . $obj->id . "\n";
			}
		}
		
	}
} else {
	echo "No campaign is running in this moment!";
}

/*                       END START CRON                                                   */
?>
