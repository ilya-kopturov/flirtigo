<?php 

set_time_limit(0);

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
$login        = 'unsubscribe@flirtigo.com'; 
$pass         = '4pGJdkPf'; 
$port	      = '110';


$mime=new mime_parser_class;
$pop3 = new Net_POP3();


$mime->mbox = 1;
$mime->decode_bodies = 1;
$mime->ignore_syntax_errors = 1;



$pop3->connect($server, $port);
$pop3->login($login,$pass);

$Count = $pop3->numMsg();

    if( (!$Count) or ($Count == -1) )
    {   echo "Login OK, No Messages";
        exit;
    }

    if ($Count < 1)
    {
        die();
    } else {
        echo "Login OK: Inbox contains [$Count] messages<BR>\n";
    }

    // loop thru the array to get each message
    for ($i=1; $i <= $Count; $i++){
           
            $head=$pop3->getParsedHeaders($i);
            $to=$head['To'];
            $from=$head['From'];
            $subject=$head['Subject'];
            $body = $pop3->getMsg($i);
            
            $fromarr=extract_emails($from);
            $fromemail=$fromarr[0];
            
	    $dbsql="Update tblUsers set emailstatus='B' where email='$fromemail'";
   	    echo $fromemail."\n";
            @mysql_query($dbsql);
		                                
	    	
	     //////////////////////////////////////////////////////////////////////
	    
            $pop3->deleteMsg($i);

      }// end for loop

$pop3->disconnect();




?>
