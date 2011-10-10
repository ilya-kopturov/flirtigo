<?php
$usrType = array('F', 'S', 'G');

if($_POST['actiontype'] == "delete")
{
	foreach($_POST['mail_id'] as $key => $value){
		@mysql_query("DELETE FROM `tblTypeMails` WHERE `user_from` = '" . $value . "' AND 
	                                               `user_to` = '" . $key . "' AND
	                                               `operator_id` = 0");
	}
	
}

if($_POST['hidden_submit'] and $_POST['profile'] > 0)
{
	$_SESSION['sell_profile'] = $_POST['profile'];
}

$daysago = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$limit = $_GET['limit']>0?$_GET['limit']:10;
$page  = $_GET['page']>0?$_GET['page']:1;
$content = $_GET['content'];
//$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"`date_sent` ASC, nrofmails ASC";
$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"nrofmails ASC, `user_from` ASC, `date_sent` ASC";

$profiles = mysql_query("SELECT tTM.`user_id`, count(tTM.`user_id`) as count,
               					(SELECT `joined`
                				 FROM   `tblUsers`
                				 WHERE  `id` = tTM.`user_id`
                				 LIMIT 1) as joined
        				 FROM   `tblTypeMails` tTM
        				 WHERE tTM.`new` = 'Y' AND tTM.`folder` = '1' 
        				 GROUP BY tTM.`user_id`
        				 ORDER BY joined DESC");

$sql = "(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'red' as color, 1 as sort_col
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) = 0 )
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'purple' as color, 3 as sort_col
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1 AND
      t1.user_from NOT IN (
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0))
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'purple' as color, 3 as sort_col
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1 AND
      t1.user_from NOT IN (
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1

)
GROUP BY t1.`user_from`
)
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'blue' as color, 2 as sort_col
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND t1.`date_sent` < '".$daysago."' AND t1.user_from NOT IN (

SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1 )
GROUP BY t1.`user_from`)
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'green' as color, 4 as sort_col
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND t1.user_from NOT IN (
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_to` = '" . $_SESSION['sell_profile'] . "' AND t1.`date_sent` < '".$daysago."' )
GROUP BY t1.`user_from`)
ORDER BY sort_col, date_sent";

$nr = mysql_num_rows(mysql_query($sql));

while($page > ceil($nr/$limit))$page--;

$sql .= " LIMIT " . $limit . " OFFSET " . (($page-1) * $limit);

if($_SESSION['sell_profile']){
	$query = mysql_query($sql); echo mysql_error();
}

$countries = $db->get_results("SELECT * FROM `tblCountries`", ARRAY_N);
?>

<script type="text/javascript"/">
<!--
function checkAll()	{
	var cbs = document.forms["mailform"].elements;
	if(cbs) {
		if(cbs.length) {
			for (var i=0; i<cbs.length; i++) {       
				cbs[i].checked = document.forms["mailform"].elements["selectAll"].checked;
			}
		}
		else {
			cbs.checked = document.forms["mailform"].elements["selectAll"].checked;
		}
	}
}

function setonchange(s){
	if(s.options[s.selectedIndex].value == "delete"){
		if (confirm('Are u sure you want to delete this set of messages?!')){
			document.forms["mailform"].action = "http://www.hookuphotel.com<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
			document.forms["mailform"].submit();
		}
	}else if(s.options[s.selectedIndex].value == "reply"){
		document.forms["mailform"].action = "http://www.hookuphotel.com/staff/replyselected.php";
		document.forms["mailform"].submit();
	}
}

function sendReplyMessage(subject, user_from, user_to, messid, message){
	document.forms["newreplyform"].subject.value = subject;
	document.forms["newreplyform"].user_from.value = user_from;
	document.forms["newreplyform"].user_to.value = user_to;
	document.forms["newreplyform"].messid.value = messid;
	document.forms["newreplyform"].message.value = message;
	document.forms["newreplyform"].submit();
}
//-->
</script>

<form method="post" action="newreplytoall.php" target="replytoall_iframe" name="newreplyform">
  <input type="hidden" name="subject"   value="" />
  <input type="hidden" name="user_from" value="" />
  <input type="hidden" name="user_to"   value=""   />
  <input type="hidden" name="messid"   value=""   />
  <input type="hidden" name="form_submited" value="yes" />
  <input type="hidden" name="message" value="">
</form>
<iframe name="replytoall_iframe" id="replytoall_iframe" style="width: 1px; height: 1px;"></iframe>
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
  <tr>
    <td width="60%">
      <font class="pagetitle">Mails by Users</font>
      <br>
      <br>

	  <form method="post">
	  <input type="hidden" name="hidden_submit" value="submit">
	  <table style="background-color:#EEEEEE; border:1px solid #CCCCCC" cellpadding="0" cellspacing="0" style="width:100%">
	    <tr>
		  <td style="padding: 3px 0px 3px 10px; font-face: Verdana; font-size: 13px;" align="left" width="50%">
		    Select Profile: 
		    <select name="profile" onchange="submit();">
		      <option value="0">-select profile-</option>
		    <?while($obj_p = mysql_fetch_array($profiles)){?>
		      <option value="<?=$obj_p['user_id'];?>" <? if($_SESSION['sell_profile'] == $obj_p['user_id']) echo "selected";?> ><?=id_to_screenname($obj_p['user_id']);?> (<?=$obj_p['count'];?>)</option>
		    <?}?>
		    </select>
		  </td>
		</tr>
	  </table>
	  </form>

    </td>
    <td align="right" width="40%">
	  <table style="background-color:#EEEEEE; border:1px solid #CCCCCC" cellpadding="0" cellspacing="0" width="200">
	    <tr style="padding: 5px 5px 5px 5px;">
		  <td colspan="1" align="left"><font class="tablename">&nbsp;Legend:</font></td>
		</tr>
		<tr style="padding: 5px 5px 5px 5px;">
		  <td align="left" style="color: #000000; font-size: 13px; font-face: Verdana">
		    <img src="images/colorred.gif"> - first email to staff user
		    <br>
		    <img src="images/colorpurple.gif"> - second email to staff user
		    <br>
		    <img src="images/colorblue.gif"> - needs urgent reply
		    <br>
		    <img src="images/colorgreen.gif"> - doesn't need reply yet
		    <br><br>
		    <b>G</b> - gold, <b>S</b> - silver, <b>F</b> - free
		  </td>
		</tr>
	  </table>    
    </td>
  </tr>
  
  <tr>
    <td colspan="2" style="background-color:#EEEEEE; border:1px solid #CCCCCC">
	  <table cellpadding="0" cellspacing="0" style="width:100%">
		<form name="form" method="get">
		<input type="hidden" name="content" value="<?=$content;?>">
		<input type="hidden" name="page" value="<?=$page;?>">
	    <tr height="30">
		  <td style="padding-left: 10px;" align="left" width="50%">
		    <font class="tablename"><font size="3" color="black"><?=number_format($nr,0,',',','); ?></font> entries found in database for all fake users</font>
		  </td>
		  <td style="padding-right: 10px;" align="right" width="50%">
		    <font class="filternameblack">Entries per page:
		      <select class="tabletext" name="limit" onchange="form.submit();">
		        <option class="1" <? if($limit==1) echo "selected"; ?>>1</option>
			    <option class="5" <? if($limit==5) echo "selected"; ?>>5</option>
			    <option class="10" <? if($limit==10) echo "selected"; ?>>10</option>
			    <option class="20" <? if($limit==20) echo "selected"; ?>>20</option>
			    <option class="50" <? if($limit==50) echo "selected"; ?>>50</option>
			    <option class="100" <? if($limit==100) echo "selected"; ?>>100</option>
			    <option class="200" <? if($limit==200) echo "selected"; ?>>200</option>
			    <option class="300" <? if($limit==300) echo "selected"; ?>>300</option>			    
			  </select>
			</font>
		  </td>
		</tr>
		</form>
	  </table>
	</td>
  </tr>
  
<form name="mailform" method="post" id="mailform">
<input type="hidden" name="requesturi" value="<?=$_SERVER['REQUEST_URI']?>" />  
  <tr>
    <td colspan="2">
      <table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		  <td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
          <td width="2%" align="center" style="border: thin solid white;">&nbsp;</td>
		  <td width="13%" align="center" style="border: thin solid white;"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=user_from&ttype=<?if($_GET['order']=='user_from' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>From</td>
          <td width="12%" align="center" style="border: thin solid white;"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=user_to&ttype=<?if($_GET['order']=='user_to' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>To</td>
		  <td width="10%" align="center" style="border: thin solid white;">Country</td>
		  <td width="15%" align="center" style="border: thin solid white;"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=date_sent&ttype=<?if($_GET['order']=='date_sent' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>Date</td>
		  <td width="15%" align="center" style="border: thin solid white;">Subject</td>
		  <td width="15%" align="center" style="border: thin solid white;">Status</td>
		  <td width="6%" align="center" style="border: thin solid white;">Reply</td>
		  <td width="6%" align="center" style="border: thin solid white;">History</td>
	      <td width="6%" align="center" style="border: thin solid white;">
	        <select name="actiontype" onchange="setonchange(this);" style="font-face: Verdana; font-size: 9px;">
	          <option>Action</option>
	          <option value="delete">Delete</option>
	          <option value="reply">Reply</option>
	        </select>
	      </td>
        </tr>
		<tr>
		  <td colspan="10" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="10"></td>
        </tr>
        <?php if($nr){ ?>
	    <tr>
	      <td colspan="9" style="padding: 0px; margin-bottom: 5px;"></td>
	      <td align="center"  bgcolor="#F9E1E1" style="padding: 0px; margin-bottom: 5px;">
	        <input type="checkbox" name="selectAll" onclick="checkAll()">
	      </td>
        </tr>
		<?while($obj = mysql_fetch_object($query)){
			$subject = "Re: " . str_replace(array('Fwd:','Re:'),array('',''),$obj->subject);
			$subject = htmlentities(strip_tags($subject), ENT_QUOTES);
			$message = "\r\n\r\n\r\n\r\n\r\n------" . id_to_screenname($obj->user_from) . " wrote:\r\n>" . htmlentities(strip_tags(str_replace('\r\n','\r\n>',$obj->message)));
		?>
        <tr bgcolor="#ABC9ED" style="font-size: 13px; font-face: Verdana;">
          <td width="2%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><img width="10" height="10" src="images/color<?php echo $obj->color;?>.gif"></td>
		  <td width="13%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left">(<?php echo $usrType[idtofield($obj->user_from, "accesslevel")]; ?>) <a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_from;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_from);?></a></td>
          <td width="12%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_id);?></a></td>
		  <td width="10%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><? list($country) = mysql_fetch_array(mysql_query("SELECT `country` FROM `tblUsers` WHERE `id` = '" . $obj->user_from . "' LIMIT 1")); echo $countries[$country];?></td>
		  <td width="15%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><?=$obj->date_sent;?></td>
		  <td width="15%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><?=substr($obj->subject,0,20);?>...</td>
		  <td width="15%" style="padding-left: 2px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><?php echo checkStatus(id_to_screenname($obj->user_from)); echo " | "; if( (int) idtofield($obj->user_from, "accesslevel") > 0){echo "Active";}else{echo "Dead";} ?></td>
		  <td width="6%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><span name="checkreply<?php echo $obj->id;?>" id="checkreply<?php echo $obj->id;?>"><a name="reply<?php echo $obj->id;?>" id="reply<?php echo $obj->id;?>" onclick="showhide2('reply_<?php echo $obj->id;?>', <?php echo $obj->id;?>, 'reply');" style="cursor: hand; color: blue;">reply</a></span></td>
		  <td width="6%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><a name="view<?php echo $obj->id;?>" id="view<?php echo $obj->id;?>" onclick="showhide2('view_<?php echo $obj->id;?>', <?php echo $obj->id;?>, 'view');" style="cursor: hand; color: blue;">view</a> (<?=$obj->nrofRepliestoUser;?>)</td>
	      <td width="6%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;">
	      		<input type="checkbox" name="mail_id[<?=$obj->user_to?>]" value="<?=$obj->user_from; ?>" />
	      </td>
        </tr>
        <tr id="reply_<?php echo $obj->id;?>" name="reply_<?php echo $obj->id;?>" style="display: none;" bgcolor="#ABC9ED">
          <td colspan="3"></td>
          <td colspan="6">
            <textarea id="messageReply<?php echo $obj->id;?>" name="messageReply<?php echo $obj->id;?>" rows="8" style="width: 99%;"><?php echo $message;?></textarea>
            <input type="hidden" id="subjectReply<?php echo $obj->id;?>" name="subjectReply<?php echo $obj->id;?>" value="<?php echo $subject;?>" />
          </td>
          <td>
            <input type="button" name="reply" value="Send" onclick="sendReplyMessage(document.getElementById('subjectReply<?php echo $obj->id;?>').value, <?php echo $obj->user_from ?>, <?php echo $obj->user_to ?>, <?php echo $obj->id ?>, document.getElementById('messageReply<?php echo $obj->id;?>').value)" />
          </td>
        </tr>
        <?php
			$e_history = mysql_query("SELECT * FROM `tblTypeMails` 
						    	      WHERE ((`user_to` = '" . $obj->user_to . "' AND `user_from` = '" . $obj->user_from . "') OR 
						    	             (`user_from` = '" . $obj->user_to . "' AND `user_to` = '" . $obj->user_from . "')) AND 
								  	          `operator_id` != '0' 
						    	      ORDER BY `date_sent` DESC");
         ?>
        <tr id="view_<?php echo $obj->id;?>" name="view_<?php echo $obj->id;?>" style="display: none;" bgcolor="#F9FCA6" style="font-size: 13px; font-face: Verdana;">
          <td colspan="2"></td>
          <td colspan="8">
            <?php while($obje = @mysql_fetch_object($e_history)){ ?>
            To: <b><?=id_to_screenname($obje->user_to);?></b> &nbsp; From: <b><?=id_to_screenname($obje->user_from);?></b>  &nbsp; &nbsp; Replied by: <b><?=operator_to_name($obje->operator_id);?></b>  &nbsp; &nbsp; Date: <b><?=$obje->date_sent;?></b> <br />
            Subject: <br />
          	<input type="text" name="h_subject"   value="<?php echo $obje->subject;?>" /> <br />
          	Message: <br />
            <textarea name="h_message" rows="8" style="width: 99%;"><?php echo $obje->message;?></textarea> <br /><br />
            <?php } ?>
          </td>
        </tr>
        <?}?>
        <?}else{?>
        <tr>
          <td align="center" height="3" bgcolor="#FFFFFF" colspan="10" style="font-face: Verdana; font-size:12px;">Select Profile First!</td>
        </tr>
        <?}?>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<tr>
		  <td colspan="10" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
		  <td style="padding-left: 10px;" align="left" colspan="10">
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=1&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">First</a>&nbsp;&nbsp;
		    <? if($page > 1){?> 
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=($page-1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Prev</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Prev&nbsp;&nbsp
		    <? } ?>
		    &nbsp;&nbsp&nbsp;<?=$page;?> of <?=ceil($nr/$limit);?>&nbsp&nbsp;&nbsp
		    <? if($page < ceil($nr/$limit)){?> 
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=($page+1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Next</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Next&nbsp;&nbsp
		    <? } ?>
	        &nbsp;&nbsp;<a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=ceil($nr/$limit);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Last</a>
		  </td>
        </tr>
		<tr>
		  <td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
      </table>
    </td>
  </tr>
</form>
</table>