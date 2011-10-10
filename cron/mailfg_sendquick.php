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

/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep mailfg_sendquick", $out);
$cronruns = 0;                                                                                                                                               
if(is_array($out) && $out !== array())
{
        foreach ($out as $line)
        {
                if(strstr($line, "mailfg_sendquick.php") && !strstr($line, "/bin/sh -c"))
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


/*                         START CRON 		 */

//$cmpid="660";

list($cmpid,$sendinternal,$srvname) = mysql_fetch_row( mysql_query ("SELECT id,sendinternal,srvname FROM tblCampaign where running='Y' and finishedaddmails='Y' and readyq='Y' and quicktable='N' and quickadding='N'"));

$sql_mails = mysql_query("SELECT * FROM `tblCampaignMails` WHERE `campaignid` = $cmpid");

/*			
			AND toemail not like '%@yahoo.%'
			AND toemail not like '%@hotmail.%' AND toemail not like '%@msn.%' 
			AND toemail not like '%@aol.com' AND toemail not like '%@aim.%'
			"); 
*/

if(!$nrows_mails=mysql_num_rows($sql_mails))
{
    echo  "\n" . "No Campaign to add emails\n";
    
}
else
{
    echo  "\n" . "CampaignID: " . $cmpid . " - selected:".$nrows_mails." emails\n";

}

if($nrows_mails > 0)
{

@mysql_query("update tblCampaign set quickadding='Y' where id= $cmpid");
$srvarr = explode(",",$srvname);
$arrcount = count($srvarr)-1;

    /* START INSERTING INTO QUICKTABLE */
    
    while($obj_mails = mysql_fetch_object($sql_mails))
    {  

    
        /* SETTING SENDING */

	$servername 	  =$srvarr[rand(0,$arrcount)];
	$stime	    	  =1;
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
						
			
		        $sqlremote="INSERT INTO `tblMailQuick` (`campaignid`,`to`,`toname`,`subject`,`message`,`message2`,`servername`,`stime`,`sendid`,onhold)
		        values ('$obj_mails->campaignid','$to','$toname','".addslashes($subject)."','".addslashes($message)."','".addslashes($message2)."','$servername','$stime','$obj_mails->id',1)";
			
			//echo $sqlremote;
			
			@mysql_query($sqlremote);
			
		}
		else
		{
		//echo "Is_block: " . $is_block . ", SendExternal: " . $obj->sendexternal . "\n";
		//echo "Email: " . $obj_mails->toemail . "\n";
						
		@mysql_query("UPDATE `tblCampaign` SET `sent` = `sent` + 1 WHERE `id` = '" . $cmpid . "'");
		@mysql_query("UPDATE `tblCampaignMails` SET `sent` = 'Y' WHERE `id` = '" . $obj_mails->id . "' ORDER by id ASC LIMIT 1");
		}
	}
      }
      @mysql_query("update tblCampaign set quickadding='N',quicktable='Y' where id= $cmpid");
      @mysql_query("update tblMailQuick set onhold='0' where campaignid= $cmpid");
}

/*                       END START CRON                                                   */
?>
