<?php
/* HOOKUPHOTEL.COM  */

set_time_limit(0);

define("IN_MAINSITE", TRUE);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

$include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once( $include_dir . "/includes/config/" . "db.php" );
include_once( $include_dir . "/includes/config/" . "path.php" );
include_once( $include_dir . "/includes/config/" . "image.php" );
include_once( $include_dir . "/includes/config/" . "option.php" );
include_once( $include_dir . "/includes/config/" . "profile.php" );
include_once( $include_dir . "/includes/config/" . "template.php" );

include_once($include_dir . "/includes/function/" . "general.php");
include_once($include_dir . "/includes/function/" . "profile.php");
include_once($include_dir . "/includes/function/" . "mailer.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

include_once( "phpmailer" . "/" . "class.phpmailer.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );
/* end INCLUDES  */




/*                         START CRON 		 */

$cmpid="622";

list($sendinternal) = mysql_fetch_row( mysql_query ("SELECT sendinternal FROM tblCampaign where id=$cmpid"));

$sql_mails = mysql_query("SELECT * FROM `tblCampaignMails` WHERE `campaignid` = $cmpid");

/*			
			AND toemail not like '%@yahoo.%'
			AND toemail not like '%@hotmail.%' AND toemail not like '%@msn.%' 
			AND toemail not like '%@aol.com' AND toemail not like '%@aim.%'
			"); 
*/

$nrows_mails = mysql_num_rows($sql_mails);

echo  "\n" . "CampaignID: " . $cmpid . " - selected:".$nrows_mails." emails\n";

if($nrows_mails > 0)
{

    /* START INSERTING INTO QUICKTABLE */
    
    while($obj_mails = mysql_fetch_object($sql_mails))
    {  

    
        /* SETTING SENDING */

	$subjectintern    =$obj_mails->subjectintern;
	$messageintern    =$obj_mails->messageintern;
	$subject   	  =$obj_mails->subjectextern;
	$message          =$obj_mails->messageextern;
	$message2         =$obj_mails->messageexternplain;
	$to	          =$obj_mails->toemail;
	$toname           =id_to_screenname($obj_mails->toid);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	/* --------------- */


	if($obj_mails->toid && $obj_mails->sendid)
	{
		$is_block = 0;
		$is_block = @$db->query("SELECT `type` FROM `tblHotBlockList` WHERE `user_id` = '" . $obj_mails->toid . "' AND 
		                        `friend_user_id` = '" . $obj_mails->sendid. "' AND `type` = 'B' LIMIT 1");
					
	        if(!$is_block)
		 {
			if($sendinternal == 'Y')
			{
			
			$sqlintern = "INSERT INTO `tblMails` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`c_id`,`date_sent`) 
						VALUES    ('" . $obj_mails->toid . "','" . $obj_mails->sendid . "','" . $obj_mails->toid . "',
						'" . addslashes( $obj_mails->subjectintern ) . "','" . addslashes( $obj_mails->messageintern ) . "',
						'". $obj_mails->campaignid. "',NOW())";
			//echo $sqlintern;
			@mysql_query($sqlintern);
			}
						
		}
	}
      }
}

/*                       END START CRON                                                   */
?>
