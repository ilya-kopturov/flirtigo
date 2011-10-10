<?php
/* DIRTYFLIRTING.COM                                                                         
                                                                                           
                                                                                           
                                                                                         */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once($include_dir . "/includes/config/" . "db.php");
include_once($include_dir . "/includes/config/" . "path.php");
include_once($include_dir . "/includes/config/" . "image.php");
include_once($include_dir . "/includes/config/" . "option.php");
include_once($include_dir . "/includes/config/" . "profile.php");
include_once($include_dir . "/includes/config/" . "template.php");

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );
/* end INCLUDES                                                                           */



/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronhb_addnewslettermails", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cronhb_addnewslettermails.php") && !strstr($line, "/bin/sh -c"))
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
 $sql = @mysql_query("SELECT * FROM `tblNewsletter` WHERE `finishedaddmails` = 'N'");
 
 while($obj = mysql_fetch_object($sql))
 {
 	$sql_clause = "SELECT `id` FROM `tblUsers` WHERE 1 ";
 	$where_clause = ""; $look = "";
 	
 	if(trim($obj->toscreenname)) {
 		$where_clause .= " AND ";
 		$where_clause .= " `screenname` = '" . $obj->toscreenname . "' LIMIT 1";
 	} else {
 		$where_clause .= " AND ";
 		$where_clause .= " `sex` = '" . $obj->sex . "'";
 		
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
 		
 		if($obj->payed != "A"){
 			if($obj->payed == "Y"){
 				$where_clause .= " AND ";
 				$where_clause .= " `accesslevel` > '0'";
 			} elseif($obj->payed == "Y"){
 				$where_clause .= " AND ";
 				$where_clause .= " `accesslevel` = '0'";
 			}
 		}
 		
 		if($obj->cancelled != "A"){
 			//$where_clause .= " AND ";
 			//$where_clause .= " `cancelled` = '" . $obj->cancelled . "'";
 		}
 		
 		if($obj->howmany != 0){
 			$where_clause .= " LIMIT " . $obj->howmany;
 		}
 	}
 	
 	$sql_clause .= $where_clause;
 	
 	$add_query = @mysql_query($sql_clause);
 	
 	echo "\n" . $sql_clause . "\n";
 	
 	while($obj_add = mysql_fetch_object($add_query))
 	{
 		$newslettermail_id = $obj->id;
 		
 		$to_array   = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 		                                                     FROM `tblUsers` WHERE `id` = '" . $obj_add->id . "'"));
        
 		$from_array = @mysql_fetch_array(mysql_query("SELECT `id`,`screenname`, `email`, `country`, `state`, `city`, `pass` 
 		                                                     FROM `tblUsers` WHERE `id` = '" . $obj->sendid . "'"));
        
        //print_r($to_array);
        //echo "<br/>";
        //print_r($from_array);
        
        $subject = replace_before_send($obj->subject, $to_array, $from_array);
        $message = replace_before_send($obj->message, $to_array, $from_array);
        
        //echo "<br/>" . $subjectintern . "<br/>";
        //echo "<br/>" . $subjectextern . "<br/>";
        //echo "<br/>" . $messageintern . "<br/>";
        //echo "<br/>" . $messageextern . "<br/>"; 
        
        @mysql_query("INSERT INTO `tblNewsletterMails` (`newsletterid`,
                                                      `sendemail`,
                                                      `sendname`,
                                                      `toid`,
                                                      `toemail`,
                                                      `subject`,
                                                      `message`,
                                                      `dateinsert`) 
                                              VALUES ('" . $newslettermail_id . "',
                                                      '" . addslashes($obj->sendemail) . "',
                                                      '" . addslashes($obj->sendname) . "',
                                                      '" . $to_array['id'] . "',
                                                      '" . addslashes($to_array['email']) . "',
                                                      '" . addslashes($subject) . "',
                                                      '" . addslashes($message) . "',
                                                      NOW())");
 	}
 	
 	$recipients = @mysql_fetch_array(mysql_query("SELECT COUNT(*) as recipients FROM `tblNewsletterMails` WHERE `newsletterid` = '" . $obj->id . "'"));
 	@mysql_query("UPDATE `tblNewsletter` SET `finishedaddmails` = 'Y', `recipients` = '" . $recipients['recipients'] . "' WHERE `id` = '" . $obj->id . "'");
 	
 	//echo "<br/><br/><br/>";
 }
/*                       END START CRON                                                   */
?>