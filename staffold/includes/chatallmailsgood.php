<?php
if($_GET['action'] == "delete" and $_GET['del_user_from'] and $_GET['del_user_to'])
{
	@mysql_query("DELETE FROM `tblTypeMails` WHERE `user_from` = '" . $_GET['del_user_from'] . "' AND 
	                                               `user_to` = '" . $_GET['del_user_to'] . "' AND
	                                               `operator_id` = 0");
}

$daysago = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$limit = $_GET['limit']>0?$_GET['limit']:10;
$page  = $_GET['page']>0?$_GET['page']:1;
$content = $_GET['content'];
//$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"`date_sent` ASC, nrofmails ASC";
$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"nrofmails ASC, `user_from` ASC, `date_sent` ASC";

$sql = "(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'red' as color
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) = 0 )
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'purple' as color
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1 AND
      t1.user_from NOT IN (
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0))
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'purple' as color
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1 AND
      t1.user_from NOT IN (
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 
WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1

)
GROUP BY t1.`user_from`
)
UNION
(SELECT t1.*, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1) as nrOfMails, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
       (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr,
       'blue' as color
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`date_sent` < '".$daysago."' AND t1.user_from NOT IN (

SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 0
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) = 1
UNION
SELECT t1.user_from
FROM `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) = 1 )
GROUP BY t1.`user_from`)";

$nr = mysql_num_rows(mysql_query($sql));

while($page > ceil($nr/$limit))$page--;

$sql .= " LIMIT " . $limit . " OFFSET " . (($page-1) * $limit);

$query = mysql_query($sql); echo mysql_error();

$countries = $db->get_results("SELECT * FROM `tblCountries`", ARRAY_N);
?>
<iframe name="replytoall_iframe" id="replytoall_iframe" style="width: 1px; height: 1px;"></iframe>
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
  <tr>
    <td width="60%"><font class="pagetitle">All Mails List</font></td>
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
			  </select>
			</font>
		  </td>
		</tr>
		</form>
	  </table>
	</td>
  </tr>
  
  <tr>
    <td colspan="2">
      <table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		  <td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
          <td width="2%" align="center" style="border: thin solid white;">&nbsp;</td>
          <td width="2%" align="center" style="border: thin solid white;">&nbsp;</td>
		  <td width="15%" align="center" style="border: thin solid white;"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=user_from&ttype=<?if($_GET['order']=='user_from' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>From</td>
          <td width="15%" align="center" style="border: thin solid white;"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=user_to&ttype=<?if($_GET['order']=='user_to' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>To</td>
		  <td width="10%" align="center" style="border: thin solid white;">Country</td>
		  <td width="15%" align="center" style="border: thin solid white;"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=date_sent&ttype=<?if($_GET['order']=='date_sent' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>Date</td>
		  <td width="20%" align="center" style="border: thin solid white;">Subject</td>
		  <td width="7%" align="center" style="border: thin solid white;">Reply</td>
		  <td width="8%" align="center" style="border: thin solid white;">History</td>
	      <td width="6%" align="center" style="border: thin solid white;">Action</td>
        </tr>
		<tr>
		  <td colspan="10" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<?while($obj = mysql_fetch_object($query)){
			$subject = "Re: " . str_replace(array('Fwd:','Re:'),array('',''),$obj->subject);
			$message = "\r\n\r\n\r\n\r\n\r\n------" . id_to_screenname($obj->user_from) . " wrote:\r\n>" . htmlentities(strip_tags(str_replace('\r\n','\r\n>',$obj->message)));
		?>
        <tr bgcolor="#ABC9ED" style="font-size: 13px; font-face: Verdana;">
          <td width="2%"  align="center" <?php if((int) $obj->nrOfMails > 1) {?> onclick="showhide1(<?=$obj->user_from;?>);" <?} ?> style="cursor: hand; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><?php if((int) $obj->nrOfMails > 1) echo "<div id=\"div_".$obj->user_from."\" name=\"div_".$obj->user_from."\" style=\"display:inline; font-weight: bold;\">+</div>"; ?></td>
          <td width="2%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><img width="10" height="10" src="images/color<?php echo $obj->color;?>.gif"></td>
		  <td width="15%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_from;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_from);?></a></td>
          <td width="15%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_id);?></a></td>
		  <td width="10%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><? list($country) = mysql_fetch_array(mysql_query("SELECT `country` FROM `tblUsers` WHERE `id` = '" . $obj->user_from . "' LIMIT 1")); echo $countries[$country];?></td>
		  <td width="15%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><?=$obj->date_sent;?></td>
		  <td width="20%" style="padding-left: 5px; border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;" align="left"><?=substr($obj->subject,0,20);?>...</td>
		  <td width="7%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><div name="reply<?php echo $obj->id;?>" id="reply<?php echo $obj->id;?>" onclick="showhide('reply_<?php echo $obj->id;?>');" style="cursor: hand; color: blue;">reply</a></td>
		  <td width="8%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><a name="history<?php echo $obj->id;?>" id="history<?php echo $obj->id;?>" onclick="showhide('history_<?php echo $obj->id;?>');" style="cursor: hand;">view</a> ( <?=$obj->nrofRepliestoUser;?> )</td>
	      <td width="6%" align="center" style="border-left: 1px solid white; border-top: 1px solid white; border-right: 1px solid white;"><? if((int) $obj->c_id == 0){?><a href="javascript: if (confirm('Are u sure you want to delete this set of messages?!')){document.location.href='index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>&del_user_from=<?=$obj->user_from;?>&del_user_to=<?=$obj->user_to;?>&action=delete'}; void(0);">delete</a><?}?></td>
        </tr>
        <form method="post" action="newreplytoall.php" target="replytoall_iframe">
        <tr id="reply_<?php echo $obj->id;?>" name="reply_<?php echo $obj->id;?>" style="display: none;" bgcolor="#ABC9ED">
          <td colspan="3"></td>
          <td colspan="6">
          	<input type="hidden" name="subject"   value="<?php echo $subject;?>" />
          	<input type="hidden" name="user_from" value="<?php echo $obj->user_from;?>" />
          	<input type="hidden" name="user_to"   value="<?php echo $obj->user_to;?>"   />
          	<input type="hidden" name="messid"   value="<?php echo $obj->id;?>"   />
          	<input type="hidden" name="form_submited" value="yes" />
            <textarea name="message" rows="8" style="width: 99%;"><?php echo $message;?></textarea>
          </td>
          <td>
            <input type="submit" name="reply" value="Send" />
          </td>
        </tr>
        </form>
        <?php
			$e_history = mysql_query("SELECT * FROM `tblTypeMails` 
						    	      WHERE ((`user_to` = '" . $obj->user_to . "' AND `user_from` = '" . $obj->user_from . "') OR 
						    	             (`user_from` = '" . $obj->user_to . "' AND `user_to` = '" . $obj->user_from . "')) AND 
								  	          `operator_id` != '0' 
						    	      ORDER BY `date_sent` DESC");
         ?>
        <tr id="history_<?php echo $obj->id;?>" name="history_<?php echo $obj->id;?>" style="display: none;" bgcolor="#F9FCA6" style="font-size: 13px; font-face: Verdana;">
          <td colspan="2"></td>
          <td colspan="8">
            <?php while($obje = @mysql_fetch_object($e_history)){ ?>
            To: <b><?=id_to_screenname($obje->user_to);?></b> &nbsp; From: <b><?=id_to_screenname($obje->user_from);?></b>  &nbsp; &nbsp; Replied by: <b><?=operator_to_name($obje->operator_id);?></b> <br />
            Subject: <br />
          	<input type="text" name="h_subject"   value="<?php echo $obje->subject;?>" /> <br />
          	Message: <br />
            <textarea name="h_message" rows="8" style="width: 99%;"><?php echo $obje->message;?></textarea> <br /><br />
            <?php } ?>
          </td>
        </tr>
        <?php
        	if($obj->nrOfMails > 1){
        		
        		echo "<tr><td colspan=\"10\">";
				$int = "SELECT t1.*,  
                               (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`user_to` = t1.`user_to` AND t2.`folder` = 1) as nrOfMailstoFake, 
                               (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE t2.`user_from` = t1.`user_to` AND t2.`user_to` = t1.`user_from` AND t2.`operator_id` != 0 AND t2.`folder` = 2) as nrofRepliestoUser, 
                               (SELECT count( id ) FROM   `tblTypeMails` as t2 WHERE ((t2.`new` = 'N' AND t2.`operator_id` != 0) OR (t2.`new` = 'Y')) AND t2.`user_from` = t1.`user_from` AND t2.`folder` = 1 AND t2.`date_sent` < t1.`date_sent`) as mailNr
                        FROM   `tblTypeMails` as t1 WHERE t1.`new` = 'Y' AND t1.`folder` = 1 AND t1.`user_from` = '" . $obj->user_from . "' AND t1.`id` != " . $obj->id . " 
                        ORDER BY t1.`date_sent` ASC, t1.`user_id` ASC";
                $intquery = mysql_query($int); echo mysql_error();
                echo "<table id=\"" . $obj->user_from . "\" name=\"" . $obj->user_from . "\" style=\"display: none;\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
                while($objint = mysql_fetch_object($intquery)){
                	$subject = "Re: " . str_replace(array('Fwd:','Re:'),array('',''),$objint->subject);
                	$message = "\r\n\r\n\r\n\r\n\r\n------" . id_to_screenname($objint->user_from) . " wrote:\r\n>" . htmlentities(strip_tags(str_replace('\r\n','\r\n>',$objint->message)));
         ?>
        <tr bgcolor="<?php echo $color=$color=='#FFFFFF'?'#F2F2F2':'#FFFFFF';?>" style="font-size: 13px; font-face: Verdana;">
          <td width="2%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;">&nbsp;</td>
          <td width="2%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><? if((int) $objint->nrOfMailstoFake == 1 OR $objint->mailNr == 1){?><img width="10" height="10" src="images/colorpurple.gif"><?}elseif($objint->date_sent < $daysago){?><img width="10" height="10" src="images/colorblue.gif"><?}else{?><img width="10" height="10" src="images/colorgreen.gif"><?}?></td>
		  <td width="15%" style="padding-left: 5px; border-left: 1px solid white; border-right: 1px solid white;" align="left"></td>
          <td width="15%" style="padding-left: 5px; border-left: 1px solid white; border-right: 1px solid white;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$objint->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($objint->user_id);?></a></td>
		  <td width="10%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><? list($country) = mysql_fetch_array(mysql_query("SELECT `country` FROM `tblUsers` WHERE `id` = '" . $objint->user_from . "' LIMIT 1")); echo $countries[$country];?></td>
		  <td width="15%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><?=$objint->date_sent;?></td>
		  <td width="20%" style="padding-left: 5px; border-left: 1px solid white; border-right: 1px solid white;" align="left"><?=substr($objint->subject,0,20);?>...</td>
		  <td width="7%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><a name="reply<?php echo $objint->id;?>" id="reply<?php echo $objint->id;?>" onclick="showhide('reply_<?php echo $objint->id;?>');" style="cursor: hand;">reply</a></td>
		  <td width="8%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><a name="history<?php echo $objint->id;?>" id="history<?php echo $objint->id;?>" onclick="showhide('history_<?php echo $objint->id;?>');" style="cursor: hand;">view</a> ( <?=$objint->nrofRepliestoUser;?> )</td>
	      <td width="6%" align="center" style="border-left: 1px solid white; border-right: 1px solid white;"><? if((int) $objint->c_id == 0){?><a href="javascript: if (confirm('Are u sure you want to delete this set of messages?!')){document.location.href='index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>&del_user_from=<?=$objint->user_from;?>&del_user_to=<?=$objint->user_to;?>&action=delete'}; void(0);">delete</a><?}?></td>
        </tr>
        <form method="post" action="newreplytoall.php" target="replytoall_iframe">
        <tr id="reply_<?php echo $objint->id;?>" name="reply_<?php echo $objint->id;?>" style="display: none;" bgcolor="<? if(chat_mails_bgcolor($objint->user_to,$objint->user_from)){echo '#ABC9ED';}else{echo $color;}?>">
          <td colspan="3"></td>
          <td colspan="6">
          	<input type="hidden" name="subject"   value="<?php echo $subject;?>" />
          	<input type="hidden" name="user_from" value="<?php echo $objint->user_from;?>" />
          	<input type="hidden" name="user_to"   value="<?php echo $objint->user_to;?>"   />
          	<input type="hidden" name="messid"   value="<?php echo $objint->id;?>"   />
          	<input type="hidden" name="form_submited" value="yes" />
            <textarea name="message" rows="8" style="width: 99%;"><?php echo $message;?></textarea>
          </td>
          <td>
            <input type="submit" name="reply" value="Send" />
          </td>
        </tr>
        </form>
        <?php
			$e_history = mysql_query("SELECT * FROM `tblTypeMails` 
						    	      WHERE ((`user_to` = '" . $objint->user_to . "' AND `user_from` = '" . $objint->user_from . "') OR 
						    	             (`user_from` = '" . $objint->user_to . "' AND `user_to` = '" . $objint->user_from . "')) AND 
								  	          `operator_id` != '0' 
						    	      ORDER BY `date_sent` DESC");
         ?>
        <tr id="history_<?php echo $objint->id;?>" name="history_<?php echo $objint->id;?>" style="display: none;" bgcolor="#F9FCA6" style="font-size: 13px; font-face: Verdana;">
          <td colspan="2"></td>
          <td colspan="8">
            <?php while($obje = @mysql_fetch_object($e_history)){ ?>
            To: <b><?=id_to_screenname($obje->user_to);?></b> &nbsp; From: <b><?=id_to_screenname($obje->user_from);?></b>  &nbsp; &nbsp; Replied by: <b><?=operator_to_name($obje->operator_id);?></b> <br />
            Subject: <br />
          	<input type="text" name="h_subject"   value="<?php echo $obje->subject;?>" /> <br />
          	Message: <br />
            <textarea name="h_message" rows="8" style="width: 99%;"><?php echo $obje->message;?></textarea> <br /><br />
            <?php } ?>
          </td>
        </tr>
         <?php
                }
                echo "</table>";
                echo "</td></tr>";
        	}
         ?>
        <?}?>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<tr>
		  <td colspan="10" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
		  <td style="padding-left: 10px;" align="left" colspan="10">
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=1&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">First</a>&nbsp;&nbsp;
		    <? if($page > 1){?> 
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=($page-1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Prev</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Prev&nbsp;&nbsp
		    <? } ?>
		    &nbsp;&nbsp&nbsp;<?=$page;?> of <?=ceil($nr/$limit);?>&nbsp&nbsp;&nbsp
		    <? if($page < ceil($nr/$limit)){?> 
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=($page+1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Next</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Next&nbsp;&nbsp
		    <? } ?>
	        &nbsp;&nbsp;<a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=ceil($nr/$limit);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Last</a>
		  </td>
        </tr>
		<tr>
		  <td colspan="10" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
      </table>
    </td>
  </tr>
</table>

<script language="JavaScript">
	if(document.getElementById('chatinterface1').style.display == 'none'){
		document.getElementById('chatinterface1').style.display = '';
	}
	if(document.getElementById('chatinterface2').style.display == 'none'){
		document.getElementById('chatinterface2').style.display = '';
	}
	if(document.getElementById('chatinterface3').style.display == 'none'){
		document.getElementById('chatinterface3').style.display = '';
	}
	if(document.getElementById('chatinterface4').style.display == 'none'){
		document.getElementById('chatinterface4').style.display = '';
	}
	if(document.getElementById('chatinterface5').style.display == 'none'){
		document.getElementById('chatinterface5').style.display = '';
	}
	if(document.getElementById('chatinterface6').style.display == 'none'){
		document.getElementById('chatinterface6').style.display = '';
	}
	if(document.getElementById('chatinterface7').style.display == 'none'){
		document.getElementById('chatinterface7').style.display = '';
	}
	if(document.getElementById('chatinterface8').style.display == 'none'){
		document.getElementById('chatinterface8').style.display = '';
	}
</script>