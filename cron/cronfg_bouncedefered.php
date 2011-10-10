<?php 

set_time_limit(0);

/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_bouncedefered", $out);
$cronruns = 0;

if(is_array($out) && $out !== array())
{
        foreach ($out as $line)
        {
                if(strstr($line, "cronfg_bouncedefered.php") && !strstr($line, "/bin/sh -c"))
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


/* end INCLUDES */     

$dbhost = '66.135.63.101';
$dbusername = 'flirtigo';
$dbpasswd = 'oUJq5bx9elrt-';
$database_name ='flirtigo';

$connection = mysql_pconnect("$dbhost","$dbusername","$dbpasswd") or die ("Couldn't connect to server.");
$db = mysql_select_db("$database_name", $connection) or die("Couldn't select database.");
session_start();


function extract_emails($str)
{
    // This regular expression extracts all emails from
        // a string:
            $regexp = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
                preg_match_all($regexp, $str, $m);
                 
                     return isset($m[0]) ? $m[0] : array();   
}

 
require_once 'Net/POP3.php';
require_once('pop/rfc822_addresses.php');
require_once('pop/mime_parser.php');
        

ob_start(); 

$server	      = 'mail.flirtigo.com';		       
$login        = 'bounce@flirtigo.com'; 
$pass         = 'ffGBwFU%'; 
$port	      = '110';

// ** Initialize BounceStudio API ** //
$bs = new bounceStudio();
$bs->IgnoreAddresses  = "";

// **Initialize POP3 Reading
$pop3 = new Net_POP3();
$pop3->connect($server, $port);
$pop3->login($login,$pass);

$Count = $pop3->numMsg();

    if( (!$Count) or ($Count == -1) )
    {   
	mail("mar-notifications@w2interactive.com","FG Bounce","Login OK, No Messages");
	echo "Login OK, No Messages";
        exit;
    }

    if ($Count < 1)
    {
        die();
    } else {
	mail("mar-notifications@w2interactive.com","FG Bounce","Login OK, Inbox contains [".$Count."] messages");
        echo "Login OK: Inbox contains [$Count] messages<BR>\n";
    }

    // loop thru the array to get each message
    for ($i=1; $i <= $Count; $i++){
           
            // ** Call BounceStudio API bsBounceCheck To See If File Is a Bounce ** //
            $body = $pop3->getMsg($i);
            $bs->RawMessageBuffer = $body;                                                                                                            
//            $bs->LicenseKey       = "Test User/123456789";
	    $bs->LicenseKey       = "W2 - Justin Sheffield/C1B828AC19AE8A888";
            $BounceCode = $bs->DoBounceCheck();
            $email      = $bs->BouncedEmailAddress;
            
  //  	    $dbsql="insert into tblBounceNew (errorid,email,msg,date) values ($BounceCode,'$email','".mysql_escape_string($body)."',NOW())";
    //	    @mysql_query($dbsql);
    	    
    	    if($BounceCode=='10')
    	    {
    		@mysql_query("update tblUsers set emailstatus='B' where email='".$email."'");
	    }	                                
	    	
	     //////////////////////////////////////////////////////////////////////
	    
            $pop3->deleteMsg($i);

      }// end for loop

$pop3->disconnect();
@mysql_query("delete from tblBounceNew where errorid=0");




?>
