<?
session_set_cookie_params(0);
session_start();

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

include("../includes/function/" . "general.php");
include("../includes/function/" . "profile.php");
include("../includes/function/" . "mailer.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );

$e_history = mysql_query("SELECT * FROM `tblTypeMails` 
						    	   WHERE ((`user_to` = '" . $_GET['user_to'] . "' AND `user_from` = '" . $_GET['user_from'] . "') OR 
						    	         (`user_from` = '" . $_GET['user_to'] . "' AND `user_to` = '" . $_GET['user_from'] . "')) AND 
								  	     `operator_id` != '0' 
						    	   ORDER BY `date_sent` DESC");
?>
<html>
<head>
<title>View Profile</title>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">

<table width="100%">
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <tr class="tablecateg">
    <td style="padding-left: 10px;" width="60%" align="left">View history of messages between: &nbsp;&nbsp;<b><?=id_to_screenname($_GET['user_to']);?></b> &nbsp;and&nbsp; <b><?=id_to_screenname($_GET['user_from']);?></b></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#990000" width="100%"></td>
  </tr>

  
  <?while($obj = mysql_fetch_object($e_history)){?>
  <tr>
    <td style="padding-left: 10px; padding-right: 10px" width="100%">
      <table cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC" width="100%">
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           To: <b><?=id_to_screenname($obj->user_to);?></b> &nbsp; &nbsp; From: <b><?=id_to_screenname($obj->user_from);?></b>
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           Date: <b><?=$obj->date_sent;?></b>
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           Subject:<br>
           <input type="text" name="subject" style="width:100%;" value="<?=$obj->subject?>">
          </td>
        </tr>
        <tr>
          <td style="padding: 10px 10px 10px 10px;" width="100%" style="font-size: 13px; font-face: Verdana;">
           Message:<br>
           <textarea name="message" style="width:100%; height: 70px;"><?=trim($obj->message);?></textarea>
          </td>
        </tr>
      </table>
      <br>
      <br>
    </td>
  </tr>
  <?}?>
    
  
  <tr>
    <td height="3" bgcolor="#990000" width="100%"></td>
  </tr>
</table>

</body>
</html>