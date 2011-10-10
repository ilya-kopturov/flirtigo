<?php
/* HOOKUPHOTEL.COM */

set_time_limit(0);

define("IN_MAINSITE", TRUE);
error_reporting(E_ALL &  ~E_DEPRECATED & ~E_NOTICE);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include( $include_dir . "/includes/config/" . "db.php" );
include( $include_dir . "/includes/config/" . "path.php" );
include( $include_dir . "/includes/config/" . "image.php" );
include( $include_dir . "/includes/config/" . "option.php" );
include( $include_dir . "/includes/config/" . "profile.php" );
include( $include_dir . "/includes/config/" . "template.php" );
include($include_dir . "/includes/function/" . "general.php");
include($include_dir . "/includes/function/" . "profile.php");


include_once($include_dir . "/includes/function/" . "mailer.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once($include_dir . "/includes/class/" . "phpmailer.php");

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );



/* end INCLUDES  */

/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cron_purple_autoreply", $out);
$cronruns = 0;

if(is_array($out) && $out !== array()) 
{
	foreach ($out as $line)
	{
		if(strstr($line, "cron_purple_autoreply.php") && !strstr($line, "/bin/sh -c"))
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
//$mail = new PHPMailer();
/*          end mailer set                       */
/*                         START CRON                                                     */

$profilesSql="SELECT tTM.`user_id`, count(tTM.`user_id`) as count, aPM.subject, aPM.message
        				 FROM   `tblTypeMails` tTM
        				 INNER JOIN `tblAutoPurple` as aPM ON (tTM.`user_id`=aPM.`user_id`)
        				 WHERE tTM.`new` = 'Y' AND tTM.`folder` = '1' AND aPM.`active`='1'
        				 GROUP BY tTM.`user_id`
        				 ";

$profiles=$db->get_results($profilesSql);
//var_dump($profiles);
if(!empty($profiles)){
	foreach($profiles as $keyprofile=>$profile){
		$profileDetailsReplyMessage[$profile['user_id']]=array('subject'=>$profile['subject'],'message'=>$profile['message']);
		$sql[$profile['user_id']]="(SELECT t1.* FROM `tblTypeMails` as t1 
			WHERE t1.`new` = 'Y' AND t1.`folder` = 1  AND t1.`user_to`= '" . $profile['user_id'] . "' AND (t1.`operator_id` = '0' OR t1.`operator_id`=0) 
				AND (SELECT count(id) FROM `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1 AND
     			 t1.user_from NOT IN (
				SELECT t1.user_from
				FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to`= '" . $profile['user_id'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0))
		    UNION
		   (SELECT t1.* FROM `tblTypeMails` as t1 
			WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to`= '" . $profile['user_id'] . "' AND (t1.`operator_id` = '0' OR t1.`operator_id`=0) AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1 AND
      		t1.user_from NOT IN (
				SELECT t1.user_from
				FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $profile['user_id'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
				UNION
				SELECT t1.user_from
				FROM `tblTypeMails` as t1 
				WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to`= '" . $profile['user_id'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1
				)
			GROUP BY t1.`user_from`
		)";
		$emails[$profile['user_id']]=$db->get_results($sql[$profile['user_id']]);
		//var_dump($emails[$profile['user_id']]);
		//var_dump(count($emails[$profile['user_id']]));	
		//echo "<br/><br/>";echo "<br/><br/>";
		//echo"ssss";
		//die();
		if(!empty($emails[$profile['user_id']])){
			foreach($emails[$profile['user_id']] as $email){
				//$usertosend=$db->get_var("SELECT `accesslevel` FROM `tblUsers` WHERE `id`='".$emails['user_from']."'");
				//if($usertosend=='0'){
					$subject = htmlentities(strip_tags(trim($profileDetailsReplyMessage[$profile['user_id']]['subject'])))?htmlentities(strip_tags(trim($profileDetailsReplyMessage[$profile['user_id']]['subject']))):'(no subject)';
					$to      = id_to_screenname(trim($email['user_from']));
					$message = htmlentities(strip_tags(trim($profileDetailsReplyMessage[$profile['user_id']]['message'])));
					$savemail= 1;
					$redirect_to = "mem_mail.php?folder=inbox";
			//var_dump($to);
					$error = admin_sent_message($db, $email['user_from'], $email['user_to'], $subject, $message, $savemail);
				//}
			}
		}
	
	}
}
?>
