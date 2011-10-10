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
//var_dump($_POST);
//send_mail("mariusbej@yahoo.com","marius","test","test mailing:2525");

//$from_id_user=$_POST['fakeUserId'];
if(isset($_POST['reply']))
{
	foreach($_POST['mail_id'] as $key => $value){
		$subject = htmlentities(strip_tags(trim($_POST['subject'])))?htmlentities(strip_tags(trim($_POST['subject']))):'(no subject)';
		$to	= trim($key);
//		$to      = id_to_screenname(trim($key));
		$message = htmlentities(strip_tags(trim($_POST['message'])));
		$savemail= 1;
		$redirect_to = "mem_mail.php?folder=inbox";
	 
		$error = admin_sent_message($db, $to, $_POST['fakeUserId'], $subject, $message, $savemail);
	}
	
	header("Location: " . $_POST['requesturi']);
	exit(0);
}elseif( isset($_POST['actiontype']) ){
	if( count($_POST['mail_id']) == 0){
		header("Location: " . $_POST['requesturi']);
		exit(0);
	}
}
//* . end submit reply message .*//

?>
<html>
<head>
<title>MANAGEME - CONTENT MANAGER</title>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">

<table width="100%">
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <tr class="tablecateg">
    <td bgcolor="#990000" style="color: white; padding-left: 10px;" width="60%" align="left">Reply to all messages send it <br><br><b><!--To:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript: window.open('viewprofile.php?id=<?=$_SESSION['sell_profile'];?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600'); void(0);" style="color: white;"><?=id_to_screenname($_SESSION['sell_profile']);?></a><br><b>-->From:</b>&nbsp;&nbsp;
    <?foreach($_POST['mail_id'] as $key => $value){?>
    	<a href="javascript: window.open('viewprofile.php?id=<?=$key;?>','profilewindow','resizable=yes,scrollbars=yes,width=700,height=600'); void(0);" style="color: white;"><?=id_to_screenname($key);?></a>,&nbsp;
    <?}?>
    
    </td>
  </tr>
  <tr>
    <td height="1" bgcolor="#990000" width="100%"></td>
  </tr>
  
  
  <form method="post">
  	<input type="hidden" name="fakeUserId" value="<?=$_POST['fakeUserId']?>" />
    <input type="hidden" name="requesturi" value="<?=$_POST['requesturi']?>" />
  <? foreach($_POST['mail_id'] as $key => $value) { ?>
  	<input type="hidden" name="mail_id[<?=$key?>]" value="<?=$value?>" />
  <?}?>
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
   
  <?php
    foreach ($_POST['mail_id'] as $key => $value)
    {
		$e_mails = mysql_query("SELECT * FROM `tblTypeMails` WHERE `id`=".$value);
  ?> 
  <?while($obj = mysql_fetch_object($e_mails)){?>
  <tr>
    <td style="padding-left: 10px; padding-right: 10px" width="100%">
      <table cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC" width="100%">
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           <b>From:</b> &nbsp; <?=id_to_screenname($obj->user_from);?>
          </td>
        </tr>
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
    $email_nr++;
    }?>
  <?php
   }
  ?>
  
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  <?if($email_nr == 0){?>
  <tr>
    <td align="center" height="3" bgcolor="#FFFFFF" width="100%">
    No messages to reply.<br><br>
    <input onclick="window.close();" type="button" name="nothing" value="Close window"></td>
  </tr>
  <?}?>
</table>
</body>
</html>
