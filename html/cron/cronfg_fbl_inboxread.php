<?php 


/* ............................ check if cron runs or not ................................*/
$ps = exec("ps aux | grep cronfg_fbl_inboxread", $out);
$cronruns = 0;

if(is_array($out) && $out !== array())
{
        foreach ($out as $line)
        {
                if(strstr($line, "cronfg_fbl_inboxread.php") && !strstr($line, "/bin/sh -c"))
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



function get_fbl_email_to($header_title,$str){
        $matches=array();
        preg_match("/$header_title\s+(\S+@\S+)\s+/",$str,$matches);
        if(count($matches)>1){
                return $matches[1];
        }
        return false;
}

set_time_limit(0);

 $include_dir = "/home/httpd/vhosts/flirtigo.com/html";

include_once( $include_dir . "/includes/config/" . "db.php" );
include_once( $include_dir . "/includes/config/" . "path.php" );
include_once( $include_dir . "/includes/config/" . "profile.php" );
include_once($include_dir . "/includes/function/" . "general.php");
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );

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

$server       = 'mail.flirtigo.com';
$login        = 'fbl@flirtigo.com';
$pass       = '@tV!yzXx';
$port         = '110';



$mime=new mime_parser_class;
$pop3 = new Net_POP3();


$mime->mbox = 1;
$mime->decode_bodies = 1;
$mime->ignore_syntax_errors = 1;



$pop3->connect($server, $port);
$pop3->login($login,$pass);

$Count = $pop3->numMsg();

    if( (!$Count) or ($Count == -1) )
    {   
	mail("sales@w2interactive.com","HH FBL","Login OK,No messages");
	echo "Login OK, No Messages";
        exit;
    }

    if ($Count < 1)
    {
        die();
    } else {
    //echo $Count;
    //die();
	mail("sales@w2interactive.com","HH FBL","Login OK,Inbox contains [".$Count."] messages");
    	echo "Login OK: Inbox contains [$Count] messages<BR>\n";
    	
		for ($i=1; $i <= $Count; $i++){
           
            $head=$pop3->getParsedHeaders($i);
            $to=$head['To'];
            $from=$head['From'];
            $subject=$head['Subject'];
            $body = $pop3->getMsg($i);
            
            $fromarr=extract_emails($from);
            $fromemail=$fromarr[0];
            
	    	$bodymare=explode("<br/>",$body);
	    	
	    	/*
	    	$email_fbl_to[$i]=get_fbl_email_to("X-Apparently-To:",$body);
	    	if($email_fbl_to[$i]){
	    		$user_fbl[$i]=$db->get_row("SELECT `screenname`,`pass` FROM `tblUsers` WHERE `email`='".$email_fbl_to[$i]."'");
	    	}else{
	    		$email_fbl_to[$i]=get_fbl_email_to("X-HmXmrOriginalRecipient:",$body);
	    		if($email_fbl_to[$i]){
	    			$user_fbl[$i]=$db->get_row("SELECT `screenname`,`pass` FROM `tblUsers` WHERE `email`='".$email_fbl_to[$i]."'");
	    		}else{
	    			//$email_fbl_to[$i]=get_fbl_email_to("X-HmXmrOriginalRecipient:",$body);
	    			//if($email_fbl_to[$i]){
	    				//$user_fbl[$i]=$db->get_row("SELECT `screenname`,`pass` FROM `tblUsers` WHERE `email`='".$email_fbl_to[$i]."'");
	    			//}
	    		}
	    	}
	    	*/
	    	$testingpos1=strpos($body,"X-Apparently-To:");
	    	$testingpos2=strpos($body,"X-HmXmrOriginalRecipient:");
	    	$testingpos3=strpos($body,"User-email:");
                $testingpos4=strpos($body,"To:");

	    	if($testingpos1!=null){
	    		$email_fbl_to[$i]=get_fbl_email_to("X-Apparently-To:",$body);
	    	}
	    	if($testingpos2!=null){
	    		$email_fbl_to[$i]=get_fbl_email_to("X-HmXmrOriginalRecipient:",$body);
			}
			if($testingpos3!=null && empty($email_fbl_to[$i])){
				$email_fbl_to[$i]=str_replace("\"","",get_fbl_email_to("User-email:",$body));
			}
			
			if($email_fbl_to[$i]!=null){
	    		$user_fbl[$i]=$db->get_row("SELECT `screenname`,`pass` FROM `tblUsers` WHERE `email`='".$email_fbl_to[$i]."'");
	    	}

                 if($testingpos4!=null) $to=get_fbl_email_to("To:",$body);

                if (strpos($to,"unsubscribe@")!== false) { $email_fbl_to[$i]=$fromemail;
                 $user_fbl[$i]=$db->get_row("SELECT `id`, `screenname`,`pass` FROM `tblUsers` WHERE `email`='".$email_fbl_to[$i]."'");
                }



	    	//echo("<br/><br/><br/>");
	    	//var_dump($email_fbl_to[$i]);
	    	//echo("<br/><br/><br/>");
	    	//echo("<br/>");
	    	//var_dump($user_fbl[$i]);
	    	//echo("<br/><br/><br/>");echo("<br/><br/><br/>");
	    	//var_dump($head);
	    	//echo"<br/><br/><br/><br/>";
	    	//var_dump($body);
	    	//die();
	    	//$user_name_for_array_initial[$i]=explode("A reminder of your username and password are:",$body);
	    	//$user_name_for_array_second[$i]=explode("Password:",$user_name_for_array_initial[$i][1]);
	    	//$user_name_for[$i]=$user_name_for_array_second[$i][0];
	    	//$user_password_for_array[$i]=explode("</b>",$user_name_for_array_second[$i][1]);
	    	//$user_password_for[$i]=$user_password_for_array[$i][0];
	    	
	    	//$ins=1;
	    	//if
	    	//var_dump($user_name_for[$i]);
			//echo"<br/>";
			//var_dump($user_password_for[$i]);
			//echo"<br/><br/><br/><br/><br/><br/>";
 /*  	
	    	if($fromemail=="feedback@arf.mail.yahoo.com"){ 
				//$ins=1;
				//echo " --------------------------";
				//print_r($bodymare);
				//echo " --------------------------";
				//echo $bodymare[2];
				//echo " --------------------------";
		
				if(strpos($body,"You have received a new email message")>0){   
		    		//echo $bodymare[14]." / ".$bodymare[15]."\n";
		    		//$acc=$bodymare[16];
		    		//$pass=$bodymare[17];
		    		$acc=$user_name_for[$i];
		    		$pass=$user_password_for[$i];
				}   
		
				if(strpos($body,"You have a FLIRT waiting")>0){   
		    		//echo $bodymare[16]." / ".$bodymare[17]."\n";
		    		//$acc=$bodymare[16];
		    		//$pass=$bodymare[17];
		    		$acc=$user_name_for[$i];
		    		$pass=$user_password_for[$i];
				}    
	    	}
	    	if($fromemail=="scomp@aol.net"){ 
				//$ins=1;
				//echo " --------------------------";   
				//print_r($bodymare);
				//echo " --------------------------";
				//echo $bodymare[2];
				//echo " --------------------------";
		
				if(strpos($body,"You have received a new email message")>0){   
		    		//echo $bodymare[14]." / ".$bodymare[15]."\n";
		    	 	//$acc=$bodymare[16];
		    		//$pass=$bodymare[17];
		    		$acc=$user_name_for[$i];
		    		$pass=$user_password_for[$i];
				}   
		
				if(strpos($body,"You have a FLIRT waiting")>0){   
		    		//echo $bodymare[16]." / ".$bodymare[17]."\n";
		    		//$acc=$bodymare[16];
		    		//$pass=$bodymare[17];
		    		$acc=$user_name_for[$i];
		    		$pass=$user_password_for[$i];
				}  
	    	}
	    if($fromemail=="staff@hotmail.com"){ 
			//$ins=1;
			//echo " --------------------------";   
			//print_r($bodymare);
			//echo " --------------------------";
			//echo $bodymare[2];
			//echo " --------------------------";

			if(strpos($body,"You have received a new email message")>0){   
		    	//echo $bodymare[14]." / ".$bodymare[15]."\n";
		    	//$acc=$bodymare[16];
		    	//$pass=$bodymare[17];
		    	//$acc=$user_name_for[$i];
		    	//$pass=$user_password_for[$i];
			}   
		
			if(strpos($body,"You have a FLIRT waiting")>0){   
		    	echo $bodymare[16]." / ".$bodymare[17]."\n";
		    	//$acc=$bodymare[16];
		    	//$pass=$bodymare[17];
		    	//$acc=$user_name_for[$i];
		    	//$pass=$user_password_for[$i];
			}  
	    }
          
*/		
            ///////////////////////////////////////////////////////////////////////
	    
	    	if(!empty($user_fbl[$i])){
	    		$acc=$user_fbl[$i]['screenname'];
	    		$pass=$user_fbl[$i]['pass'];
	    	}else{
	    		$acc="";
	    		$pass="";
	    		echo"<br/>User doesnt exist into the database.<br/>";
	    	}
	    	$sqlmailreply="INSERT INTO tblFblMails (
        		`from`, 
        		`account`,
        		`pass`,
        		`insdate`
        		) values (
        		'".$fromemail."',
        		'".addslashes($acc)."',
        		'".addslashes($pass)."',
        		NOW()
        		)";
	    	
	    	echo "-------------------------"."\n".$sqlmailreply."\n"."------------------------------";
	    	
	    	@mysql_query($sqlmailreply);
			$dbsql="Update tblUsers set emailstatus='B' where screenname='$acc' and pass='$pass'";
            @mysql_query($dbsql);
		                                
			@mysql_query("Update tblFblMails set processed='1' where id=$obj->id");
	    	
	 
	    /*
	    if($ins){	
			$acc=str_replace("A reminder of your username and password are:<br>","",$acc);
			//$acc=$user_name_for[$i];
			$acc=str_replace("<b>","",$acc);
			$acc=str_replace("</b>","",$acc);
			$acc=str_replace("Username: ","",$acc);
			$acc=trim($acc,"\r\n");
			//$pass=$user_password_for[$i];
			$pass=str_replace("<b>","",$pass);
			$pass=str_replace("</b>","",$pass);
			$pass=str_replace("Password: ","",$pass);
			$pass=trim($pass,"\r\n");
			
			
            $sqlmailreply="INSERT INTO tblFblMails (
        		`from`, 
        		`account`,
        		`pass`,
        		`insdate`
        		) values (
        		'".$fromemail."',
        		'".addslashes($acc)."',
        		'".addslashes($pass)."',
        		NOW()
        		)";
        	
			//echo "-------------------------"."\n".$sqlmailreply."\n"."------------------------------";
			//@mysql_query($sqlmailreply);	
		
			//var_dump($acc);
			//echo"<br/>";
			//var_dump($pass);
			
			$dbsql="Update tblUsers set emailstatus='B' where screenname='$acc' and pass='$pass'";
            //@mysql_query($dbsql);
		                                
			//@mysql_query("Update tblFblMails set processed='1' where id=$obj->id");
		                                                
	     }	
	     */
	     //////////////////////////////////////////////////////////////////////
	    
         $pop3->deleteMsg($i);

      }// end for loop
    }

    // loop thru the array to get each message


$pop3->disconnect();




?>
