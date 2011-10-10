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


include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
/* end INCLUDES */


/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_addmassrequestmails", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronfg_addmassrequestmails.php") && !strstr($line, "/bin/sh -c"))
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



/*                         START CRON                                                     */
 $sql = mysql_query("SELECT * FROM `tblMassRequest` WHERE `finishedaddmails` = 'N' AND `ready` = 'Y'");

 while($obj = mysql_fetch_object($sql))
 {
 	$sql_clause = "SELECT `id` FROM `tblUsers` WHERE `disabled` = 'N' AND `typeusr` = 'N' ";
 	$where_clause = ""; $look = "";
 	
 	if(trim($obj->toscreenname)) {
 		$where_clause .= " AND ";
 		$where_clause .= " `screenname` = '" . $obj->toscreenname . "' LIMIT 1";
 	} else {
 		$where_clause .= " AND ";
 		$where_clause .= " `sex` = '" . $obj->sex . "'";
 		$where_clause .= " AND ";
 		$where_clause .= " `birthdate` <= '" . birthday($obj->age_from) . "'";
 		$where_clause .= " AND ";
 		$where_clause .= " `birthdate` >= '" . birthday($obj->age_to) . "'";
 		
 		if($obj->looking > 0){
			for($param = 0; $param < count($cfg['profile']['looking']); $param++)
			{
				if($obj->looking & (1 << $param)){
					if(empty($look)){
			    		$look = 1;
			    		$where_clause .= " AND ";
			    		$where_clause .= " (`looking` & (1 << " . $param . ") ";
					}
					else
					{
			    		$where_clause .= " OR ";
			    		$where_clause .= " `looking` & (1 << " . $param . ") ";
					}
				}
			}
			
			$where_clause .= ")";
 		}
 		
 		$ems = 0;
 		
 		if($obj->emailserver > 0){
			for($param = 0; $param < count($cfg['option']['emailserver']); $param++)
			{
				if($obj->emailserver & (1 << $param)){
					if(!$ems){
			    		$ems = 1;
			    		$where_clause .= " AND ";
			    		if($param == (count($cfg['option']['emailserver']) - 1)){
			    			$where_clause .= " (`email` not like '%@yahoo%' AND `email` not like '%@hotmail%' AND `email` not like '%@aol%'";
			    		}else{
			    			$where_clause .= " (`email` like '%@" . $cfg['option']['emailserver'][$param] . "%' ";
			    		}
					}
					else
					{
			    		$where_clause .= " OR ";
			    		if($param == (count($cfg['option']['emailserver']) - 1)){
			    			$where_clause .= " (`email` not like '%@yahoo%' AND `email` not like '%@hotmail%' AND `email` not like '%@aol%')";
			    		}else{
			    			$where_clause .= " `email` like '%@" . $cfg['option']['emailserver'][$param] . "%' ";
			    		}
					}
				}
			}
			
			$where_clause .= ")";
 		}
 		
 		if($obj->joinedfrom != "0000-00-00"){
 			$where_clause .= " AND ";
 			$where_clause .= " `joined` >= '" . $obj->joinedfrom . " 00:00:00'";
 		}
 		
 		if($obj->joinedto != "0000-00-00"){
 			$where_clause .= " AND ";
 			$where_clause .= " `joined` <= '" . $obj->joinedto . " 23:59:59'";
 		}
 		
 		if($obj->lastloginfrom != "0000-00-00"){
 			$where_clause .= " AND ";
 			$where_clause .= " `lastlogin` >= '" . $obj->lastloginfrom . " 23:59:59'";
 		}
 		
 		if($obj->lastloginto != "0000-00-00"){
 			$where_clause .= " AND ";
 			$where_clause .= " `lastlogin` <= '" . $obj->lastloginto . " 23:59:59'";
 		}
 		
 		if($obj->mailreceived != "A"){
 			$where_clause .= " AND ";
 			$where_clause .= " `mailreceived` = '" . $obj->mailreceived . "'";
 		}
 		
 		if($obj->mailresponded != "A"){
 			$where_clause .= " AND ";
 			$where_clause .= " `mailresponded` = '" . $obj->mailresponded . "'";
 		}
 		
 		if($obj->mailopened != "A"){
 			$where_clause .= " AND ";
 			$where_clause .= " `mailopened` = '" . $obj->mailopened . "'";
 		}
 		
 		if($obj->loggedin != "A"){
 			$where_clause .= " AND ";
 			$where_clause .= " `firsttime` = '" . $obj->loggedin . "'";
 		}
 		
 		if($obj->payed != "A"){
 			if($obj->payed == "Y"){
 				$where_clause .= " AND ";
 				$where_clause .= " `accesslevel` > '0'";
 			} elseif($obj->payed == "N"){
 				$where_clause .= " AND ";
 				$where_clause .= " `accesslevel` = '0'";
 			}
 		}
 		
 		if($obj->cancelled != "A"){
 			//$where_clause .= " AND ";
 			//$where_clause .= " `cancelled` = '" . $obj->cancelled . "'";
 		}
 		
 		$arrorigin_arr = array();
 		$arrorigin_arr = explode(",", $obj->origin);
 		
 		if($arrorigin_arr[0] != "A"){
 				$where_clause .= " AND (";
 				$firstorigin = 1;
 				foreach($arrorigin_arr as $param){
 					if($firstorigin == 1){
 						$where_clause .= " `origin` = '" . $param . "' ";
 					}else{
 						$where_clause .= " OR `origin` = '" . $param . "' ";
 					}
 					$firstorigin = 2;
 				}
 				$where_clause .= ")";
 		}
 		
 		if($obj->originaccesslevel != "A"){
 			if($obj->originaccesslevel == "P"){
 				$where_clause .= " AND ";
 				$where_clause .= " `orgaccesslevel` > '0'";
 			} elseif($obj->originaccesslevel == "F"){
 				$where_clause .= " AND ";
 				$where_clause .= " `orgaccesslevel` = '0'";
 			}
 		}
 		
 		if($obj->emailstatus != "A"){
 			if($obj->emailstatus == "G"){
 				$where_clause .= " AND ";
 				$where_clause .= " `emailstatus` = 'G'";
 			} elseif($obj->emailstatus == "GD"){
 				$where_clause .= " AND ";
 				$where_clause .= " (`emailstatus` = 'G' OR `emailstatus` = 'D')";
 			} elseif($obj->emailstatus == "B"){
 				$where_clause .= " AND ";
 				$where_clause .= " `emailstatus` = 'B'";
 			} elseif($obj->emailstatus == "I"){
 				$where_clause .= " AND ";
 				$where_clause .= " `emailstatus` = 'I'";
 			} elseif($obj->emailstatus == "D"){
 				$where_clause .= " AND ";
 				$where_clause .= " `emailstatus` = 'D'";
 			}
 		}
 		
 		if($obj->howmany != 0){
 			$where_clause .= " LIMIT " . $obj->howmany;
 		}
 	}
 	
 	$sql_clause .= $where_clause;
 	
 	@mail("mar-notifications@w2interactive.com","Create MASSREQUEST CAMPAIGN - SQL QUERY (". $obj->id .")",$sql_clause);
 	
 	$add_query = @mysql_query($sql_clause);
 	
 	echo "\n" . $sql_clause . "\n";
 	
 	while($obj_add = mysql_fetch_object($add_query))
 	{
 		$campaignmail_id = $obj->id;
 		$redirect_to = "mem_index.php";
 		
 		$to_array   = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 		                                                     FROM `tblUsers` WHERE `id` = '" . $obj_add->id . "'"));
        
 		$from_array = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 		                                                     FROM `tblUsers` WHERE `id` = '" . $obj->sendid . "'"));
        
 		list($subjectextern, $messageextern) = @mysql_fetch_row(mysql_query("SELECT `subject`, `message`
 		                                                                     FROM   `tblMailerMachine`
 		                                                                     WHERE  `type` = 'external' AND 
 		                                                                            `for`  = 'request_password'
 		                                                                     LIMIT  1"));
 		
 		list($subjectintern, $messageintern) = @mysql_fetch_row(mysql_query("SELECT `subject`, `message`
 		                                                                     FROM   `tblMailerMachine`
 		                                                                     WHERE  `type` = 'internal' AND 
 		                                                                            `for`  = 'request_password'
 		                                                                     LIMIT  1"));
        
        $subjectintern = replace_before_send($subjectintern, $to_array, $from_array);
        $subjectextern = replace_before_send($subjectextern, $to_array, $from_array);
        
        $messageintern = replace_before_send($messageintern, $to_array, $from_array);
        $messageextern = replace_before_send($messageextern, $to_array, $from_array);
        
        //echo "<br/>" . $subjectintern . "<br/>";
        //echo "<br/>" . $subjectextern . "<br/>";
        //echo "<br/>" . $messageintern . "<br/>";
        //echo "<br/>" . $messageextern . "<br/>"; 
        
        @mysql_query("INSERT INTO `tblMassRequestMails` (`campaignid`,
                                                         `sendid`,
                                                         `toid`,
                                                         `toemail`,
                                                         `subjectintern`,
                                                         `messageintern`,
                                                         `subjectextern`,
                                                         `messageextern`,
                                                         `dateinsert`) 
                                              VALUES ('" . $campaignmail_id . "',
                                                      '" . $obj->sendid . "',
                                                      '" . $to_array['id'] . "',
                                                      '" . addslashes($to_array['email']) . "',
                                                      '" . addslashes($subjectintern) . "',
                                                      '" . addslashes($messageintern) . "',
                                                      '" . addslashes($subjectextern) . "',
                                                      '" . addslashes($messageextern) . "',
                                                      NOW())");
		
		echo "MYSQL_ERROR: " . mysql_error() . "<br/>";
 	}
 	
 	$recipients = mysql_fetch_array(mysql_query("SELECT COUNT(*) as recipients FROM `tblMassRequestMails` WHERE `campaignid` = '" . $obj->id . "'"));
 	echo $recipients['recipients'];
 	mysql_query("UPDATE `tblMassRequest` SET `finishedaddmails` = 'Y', `recipients` = '" . $recipients['recipients'] . "' WHERE `id` = '" . $obj->id . "'");
 	echo "MYSQL_ERROR(3): " . mysql_error() . "<br/>\n";
 }
/*                       END START CRON                                                   */
?>
