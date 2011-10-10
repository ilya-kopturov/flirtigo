<?
if($_GET['action'] == "delete" and $_GET['del_user_from'] and $_GET['del_user_to'])
{
	deletemails($_GET['del_user_from'], $_GET['del_user_to'], $_SESSION['admin']>0?$_SESSION['admin']:1);
}

$nr = @mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `new` = 'Y' AND `folder` = '1'"));

$limit = $_GET['limit']>0?$_GET['limit']:10;
$page  = $_GET['page']>0?$_GET['page']:1;
$content = $_GET['content'];
$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"nrofmails ASC, `date_sent` ASC, `user_id` ASC, `user_from` ASC";

while($page > ceil($nr['count']/$limit))$page--;

$sql = "SELECT tTM.*, 
			(
			 SELECT count( id ) 
			 FROM `tblTypeMails` 
			 WHERE `user_to` = tTM.user_from
			 AND `user_from` = tTM.user_to
			 AND `operator_id` !=0
			 AND `folder` =2
			 ) AS nrofmails 
        FROM `tblTypeMails` as tTM 
        WHERE `new` = 'Y' AND `folder` = '1' 
        ORDER BY " . $order . " 
        LIMIT " . $limit . " 
        OFFSET " . (($page-1) * $limit);

$query = mysql_query($sql);

$countries = $db->get_results("SELECT * FROM `tblCountries`", ARRAY_N);
?>
<form name="form" method="get">
<input type="hidden" name="content" value="<?=$content;?>">
<input type="hidden" name="page" value="<?=$page;?>">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
  <tr>
    <td width="75%"><font class="pagetitle">All Mails List</font></td>
    <td align="right" width="25%">
	  <table style="background-color:#EEEEEE; border:1px solid #CCCCCC" cellpadding="0" cellspacing="0" width="150">
	    <tr style="padding: 5px 5px 5px 5px;">
		  <td colspan="1" align="left"><font class="tablename">&nbsp;Legend:</font></td>
		</tr>
		<tr style="padding: 5px 5px 5px 5px;">
		  <td colspan="2" align="left" width="50%" style="color: #000000; font-size: 13px; font-face: Verdana">
		    <img src="images/greensquare.gif"> - first reply
		    <br>
		    <img src="images/redsquare.gif"> - first campaign reply
		    <br>
		    <span style="background: '#ABC9ED'; width: 100px; padding-left: 15px;">urgent mail</span>
		  </td>
		</tr>
	  </table>    
    </td>
  </tr>
  
  <tr>
    <td colspan="2" style="background-color:#EEEEEE; border:1px solid #CCCCCC">
	  <table cellpadding="0" cellspacing="0" style="width:100%">
	    <tr height="30">
		  <td style="padding-left: 10px;" align="left" width="50%">
		    <font class="tablename"><font size="3" color="black"><?=number_format($nr['count'],0,',',','); ?></font> entries found in database for all fake users</font>
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
	  </table>
	</td>
  </tr>
  
  <tr>
    <td colspan="2">
      <table width="100%">
		<tr>
		  <td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
          <td width="2%" align="center">&nbsp;</td>
          <td width="10%" align="center"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=user_to&ttype=<?if($_GET['order']=='user_to' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>To</td>
		  <td width="10%" align="center"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=user_from&ttype=<?if($_GET['order']=='user_from' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>From</td>
		  <td width="10%" align="center">Country</td>
		  <td width="15%" align="center"><A href="index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=date_sent&ttype=<?if($_GET['order']=='date_sent' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>Date</td>
		  <td width="25%" align="center">Subject</td>
		  <td width="10%" align="center">Reply</td>
		  <td width="10%" align="center">History</td>
	      <td width="8%" align="center">Action</td>
        </tr>
		<tr>
		  <td colspan="9" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<?while($obj = mysql_fetch_object($query)){?>
        <tr bgcolor="<? if(chat_mails_bgcolor($obj->user_to,$obj->user_from)){echo '#ABC9ED';}else{echo $color=$color=='#FFFFFF'?'#F2F2F2':'#FFFFFF';}?>" style="font-size: 13px; font-face: Verdana;">
          <td align="center"><? if((int) $obj->nrofmails == 0){ if((int) $obj->c_id > 0){?><img width="10" height="10" src="images/redsquare.gif"><?}else{?><img width="10" height="10" src="images/greensquare.gif"><?}}?></td>
          <td style="padding-left: 15px;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_id;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_id);?></a></td>
		  <td style="padding-left: 15px;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_from;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_from);?></a></td>
		  <td align="center"><? list($country) = mysql_fetch_array(mysql_query("SELECT `country` FROM `tblUsers` WHERE `id` = '" . $obj->user_from . "' LIMIT 1")); echo $countries[$country];?></td>
		  <td align="center"><?=$obj->date_sent;?></td>
		  <td style="padding-left: 15px;" align="left"><?=substr($obj->subject,0,20);?>...</td>
		  <td align="center"><a href="javascript: window.open('replytoall.php?user_from=<?=$obj->user_from;?>&user_to=<?=$obj->user_to;?>','replywindow','resizable=yes,scrollbars=yes,width=800,height=650,fullscreen=yes'); void(0);">reply</a></td>
		  <td align="center"><a href="javascript: window.open('history.php?user_from=<?=$obj->user_from;?>&user_to=<?=$obj->user_to;?>','historywindow','resizable=yes,scrollbars=yes,width=800, height=650,fullscreen=yes'); void(0);">view</a> ( <?=$obj->nrofmails;?> )</td>
	      <td align="center"><? if((int) $obj->c_id == 0){?><a href="javascript: if (confirm('Are u sure you want to delete this set of messages?!')){document.location.href='index.php?content=chatallmails&limit=<?=$limit?>&page=<?=$page?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>&del_user_from=<?=$obj->user_from;?>&del_user_to=<?=$obj->user_to;?>&action=delete'}; void(0);">delete</a><?}?></td>
        </tr>
        <?}?>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<tr>
		  <td colspan="9" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
		  <td style="padding-left: 10px;" align="left" colspan="9">
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=1&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">First</a>&nbsp;&nbsp;
		    <? if($page > 1){?> 
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=($page-1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Prev</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Prev&nbsp;&nbsp
		    <? } ?>
		    &nbsp;&nbsp&nbsp;<?=$page;?> of <?=ceil($nr['count']/$limit);?>&nbsp&nbsp;&nbsp
		    <? if($page < ceil($nr['count']/$limit)){?> 
		    <a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=($page+1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Next</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Next&nbsp;&nbsp
		    <? } ?>
	        &nbsp;&nbsp;<a href="index.php?content=chatallmails&limit=<?=$limit;?>&page=<?=ceil($nr['count']/$limit);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Last</a>
		  </td>
        </tr>
		<tr>
		  <td colspan="9" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
      </table>
    </td>
  </tr>
</table>
</form>