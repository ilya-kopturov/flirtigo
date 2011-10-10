<?
session_set_cookie_params(0);
session_start();

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

include("includes/functions.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );

//* ... submit reply message ...*//
if(isset($_POST['reply']))
{
	$subject = htmlentities(strip_tags(trim($_POST['subject'])))?htmlentities(strip_tags(trim($_POST['subject']))):'(no subject)';
	$message = htmlentities(strip_tags(trim($_POST['message'])));
	$savemail= 1;
	$redirect_to = "mem_mail.php?folder=inbox";
	 
	$error = replytoall_sent_message($db, (int) $_GET['user_from'], (int) $_GET['user_to'], $subject, $message, $savemail);
	
	
	//echo "<script>window.opener.location.href = window.opener.location.href;</script>";
	
	sleep(1);
	
	echo "<script>this.close();</script>";
}
//* . end submit reply message .*//

$lastmail = @mysql_fetch_object(mysql_query("SELECT * 
						 FROM `tblTypeMails` 
						 WHERE `user_id` = '" . $_GET['user_to'] . "' AND
							   `user_from` = '" . $_GET['user_from'] . "' AND
							   `operator_id` = '0' AND
							   `folder` = '1' 
						 ORDER BY `date_sent` DESC
						 LIMIT 1"));

$lsubject = "Re: " . str_replace(array('Fwd:','Re:'),array('',''),$lastmail->subject);
$lmessage = "\r\n\r\n\r\n\r\n\r\n------" . id_to_screenname($lastmail->user_from) . " wrote:\r\n>" . htmlentities(strip_tags(str_replace('\r\n','\r\n>',$lastmail->message)));

$e_mails = mysql_query("SELECT * 
						    FROM `tblTypeMails` 
						    WHERE `user_id` = '" . $_GET['user_to'] . "' AND
								  `user_from` = '" . $_GET['user_from'] . "' AND
								  `operator_id` = '0' AND
								  `folder` = '1' 
						    ORDER BY `date_sent` DESC");

$e_num = mysql_num_rows($e_mails);

/**
 * Last reply
 */
function last_reply($from, $to){
	$e_history = mysql_query("SELECT `operator_id` FROM `tblTypeMails` 
						    	   WHERE ((`user_to` = '" . $to . "' AND `user_from` = '" . $from . "') OR 
						    	         (`user_from` = '" . $to . "' AND `user_to` = '" . $from . "')) AND 
								  	     `operator_id` != '0' 
						    	   ORDER BY `date_sent` DESC
						    	   LIMIT 1");
	list($last) = mysql_Fetch_array($e_history);
	
	if( (int) $last > 0){
		return operator_to_name($last);
	}
	return "-none-";
}
?>
<html>
<head>
<title>Reply to all messages between <?=id_to_screenname($_GET['user_to']);?> and <?=id_to_screenname($_GET['user_from']);?></title>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">

<table width="100%">
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <tr class="tablecateg">
    <td bgcolor="#990000" style="color: white; padding-left: 10px;" width="60%" align="left">Reply to all messages send it <br><br><b>To:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript: window.open('viewprofile.php?id=<?=$_GET[user_to];?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600'); void(0);" style="color: white;"><?=id_to_screenname($_GET['user_to']);?></a> <br><b>From:</b>&nbsp;&nbsp;<a href="javascript: window.open('viewprofile.php?id=<?=$_GET[user_from];?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600'); void(0);" style="color: white;"><?=id_to_screenname($_GET['user_from']);?></a><br><b>Last reply by:</b>&nbsp;&nbsp;<?=last_reply($_GET["user_from"], $_GET["user_to"]);?></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <?if($e_num){?>
  <form method="post">
  <tr>
    <td style="padding-left: 10px; padding-right: 10px" width="100%">
      <table cellpadding="0" cellspacing="0" border="0" width="500">
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 15px; font-face: Verdana;">
           <b>Subject:</b><br>
           <input type="text" name="subject" style="width:500px;" value="<?=$lsubject?>">
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 15px; font-face: Verdana;">
           <b>Message:</b><br>
           <textarea name="message" style="width:500px; height:300px;"><?=$lmessage;?></textarea>
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 15px; font-face: Verdana;">
            <input style="width:200px; height:35px;" type="submit" name="reply" value="Reply to ALL messages">
          </td>
        </tr>
      </table>
      <br>
      <br>
    </td>
  </tr>
  </form>
  
  <tr>
    <td height="1" bgcolor="#990000" width="100%"></td>
  </tr>
  <tr>
    <td style="padding-left: 10px; color: #FFFFFF" height="1" bgcolor="#990000" width="100%">Unreplyied Messages</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#990000" width="100%"></td>
  </tr>
  <tr>
    <td height="10" width="100%"></td>
  </tr>
    
  <?while($obj = mysql_fetch_object($e_mails)){?>
  <tr>
    <td style="padding-left: 10px; padding-right: 10px" width="100%">
      <table cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC" width="100%">
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           Subject:<br>
           <input type="text" name="subject" style="width:100%;" value="<?=htmlentities(strip_tags(($obj->subject)));?>">
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           Message:<br>
           <textarea name="message" style="width:100%; height: 100px;"><?=htmlentities(strip_tags(trim($obj->message)));?></textarea>
          </td>
        </tr>
      </table>
      <br>
      <br>
    </td>
  </tr>
  <?
    mysql_query("UPDATE `tblMails` SET `new` = 'N' WHERE `id_to_id` = '" . $obj->id . "' AND 
                                                         `folder` = '2' AND 
                                                         `user_id` = '" . $obj->user_from ."' AND 
                                                         `user_to` = '" . $obj->user_id ."' LIMIT 1");
    }?>
  
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  <?} else {?>
  <tr>
    <td align="center" height="3" bgcolor="#FFFFFF" width="100%">
    No messages to reply.<br><br>
    <input onclick="window.close();" type="button" name="nothing" value="Close window"></td>
  </tr>
  <?}?>
</table>

</body>
</html>