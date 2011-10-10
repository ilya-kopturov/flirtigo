<?
if($_GET['action'] == "delete" and $_GET['del_user_from'] and $_GET['del_user_to'])
{
	@mysql_query("DELETE FROM `tblTypeMails` WHERE `user_from` = '" . $_GET['del_user_from'] . "' AND 
	                                               `user_to` = '" . $_GET['del_user_to'] . "' AND
	                                               `operator_id` = 0");
}

if($_POST['hidden_submit'] and $_POST['profile'] > 0)
{
	$_SESSION['sell_operator'] = $_POST['profile'];
}

$nr = @mysql_fetch_array(mysql_query("SELECT COUNT(*) as count FROM `tblTypeMails` WHERE `operator_id` = '".$_SESSION['sell_operator']."' AND `folder` = '2' LIMIT 100"));

if($nr['count'] > 100) $nr['count'] = 100;

$limit = $_GET['limit']>0?$_GET['limit']:100;
$page  = $_GET['page']>0?$_GET['page']:1;
$content = $_GET['content'];
$order = $_GET['order']!=''?$_GET['order'] . " " . $_GET['ttype']:"`date_sent` DESC, `user_id` ASC, `user_from` ASC";

while($page > ceil($nr['count']/$limit))$page--;

$profiles = mysql_query("SELECT `id`, `user` FROM `tblAdmin` WHERE `isforchat` = '1'");

$sql = "SELECT *
        FROM `tblTypeMails`
        WHERE `operator_id` = '".$_SESSION['sell_operator']."' AND `folder` = '2' 
        ORDER BY " . $order . " 
        LIMIT " . $limit;

$query = mysql_query($sql);
$num = mysql_num_rows($query);

$countries = $db->get_results("SELECT * FROM `tblCountries`", ARRAY_N);
?>
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
  <tr>
    <td width="75%">
      <font class="pagetitle">Last 100 mails</font>
      <br>
      <br>

	  <form method="post">
	  <input type="hidden" name="hidden_submit" value="submit">
	  <table style="background-color:#EEEEEE; border:1px solid #CCCCCC" cellpadding="0" cellspacing="0" style="width:100%">
	    <tr>
		  <td style="padding: 3px 0px 3px 10px; font-face: Verdana; font-size: 13px;" align="left" width="50%">
		    Select Operator: 
		    <select name="profile" onchange="submit();">
		      <option value="0">-select operator-</option>
		    <?while($obj_p = mysql_fetch_array($profiles)){?>
		      <option value="<?=$obj_p['id'];?>" <? if($_SESSION['sell_operator'] == $obj_p['id']) echo "selected";?> ><?=$obj_p['user'];?></option>
		    <?}?>
		    </select>
		  </td>
		</tr>
	  </table>
	  </form>

    </td>
  </tr>

<form name="form" method="get">
<input type="hidden" name="content" value="<?=$content;?>">
<input type="hidden" name="page" value="<?=$page;?>">
  
  <?if($num>0){?>
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
  <?}?>
  
  <tr>
    <td colspan="2">
      <table width="100%">
		<tr>
		  <td colspan="6" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
          <td width="10%" align="center"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=user_to&ttype=<?if($_GET['order']=='user_to' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>To</td>
		  <td width="10%" align="center"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=user_from&ttype=<?if($_GET['order']=='user_from' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>From</td>
		  <td width="10%" align="center">Country</td>
		  <td width="15%" align="center"><A href="index.php?content=chatmails&limit=<?=$limit?>&page=<?=$page?>&order=date_sent&ttype=<?if($_GET['order']=='date_sent' and $_GET['ttype']=='asc') echo 'desc'; else echo 'asc'; ?>"><img src="images/sort/sort_off2.gif" border="0" align="absmiddle"></a>Date</td>
		  <td width="15%" align="center">Subject</td>
		  <td width="40%" align="center">Message</td>
        </tr>
		<tr>
		  <td colspan="6" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
        <?if($num){?>
		<?while($obj = mysql_fetch_object($query)){?>
        <tr bgcolor="<? if(chat_mails_bgcolor($obj->user_to,$obj->user_from)){echo '#ABC9ED';}else{echo $color=$color=='#FFFFFF'?'#F2F2F2':'#FFFFFF';}?>" style="font-size: 13px; font-face: Verdana;">
          <td style="padding-left: 15px;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_to;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_to);?></a></td>
		  <td style="padding-left: 15px;" align="left"><a href="javascript: window.open('viewprofile.php?id=<?=$obj->user_from;?>','profilewindow','resizable=yes,scrollbars=yes,width=700, height=600'); void(0);"><?=id_to_screenname($obj->user_from);?></a></td>
		  <td align="center"><? list($country) = mysql_fetch_array(mysql_query("SELECT `country` FROM `tblUsers` WHERE `id` = '" . $obj->user_from . "' LIMIT 1")); echo $countries[$country];?></td>
		  <td align="center"><?=$obj->date_sent;?></td>
		  <td style="padding-left: 15px;" align="left"><?=$obj->subject;?>...</td>
		  <td style="padding-left: 15px;" align="left">
		    <textarea style="width: 400px; height: 200px;"><?=htmlentities($obj->message);?></textarea>
		  </td>
        </tr>
        <?}?>
        <?}else{?>
        <tr>
          <td align="center" height="3" bgcolor="#FFFFFF" colspan="6" style="font-face: Verdana; font-size:12px;">Select Profile First!</td>
        </tr>
        <?}?>
        <tr>
          <td height="3" bgcolor="#FFFFFF" colspan="6"></td>
        </tr>
		<tr>
		  <td colspan="6" height="1" bgcolor="#990000" width="100%"></td>
		</tr>
        <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
		  <td style="padding-left: 10px;" align="left" colspan="6">
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=1&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">First</a>&nbsp;&nbsp;
		    <? if($page > 1){?> 
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=($page-1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Prev</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Prev&nbsp;&nbsp
		    <? } ?>
		    &nbsp;&nbsp&nbsp;<?=$page;?> of <?=ceil($nr['count']/$limit);?>&nbsp&nbsp;&nbsp
		    <? if($page < ceil($nr['count']/$limit)){?> 
		    <a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=($page+1);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Next</a>&nbsp;&nbsp;
		    <? } else { ?>
		    Next&nbsp;&nbsp
		    <? } ?>
	        &nbsp;&nbsp;<a href="index.php?content=chatmails&limit=<?=$limit;?>&page=<?=ceil($nr['count']/$limit);?>&order=<?=$_GET['order'];?>&ttype=<?=$_GET['ttype'];?>">Last</a>
		  </td>
        </tr>
		<tr>
		  <td colspan="6" height="3" bgcolor="#990000" width="100%"></td>
		</tr>
      </table>
    </td>
  </tr>
</table>
</form>

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
</script>