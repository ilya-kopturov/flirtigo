<?
//////////////////////////////////////////

$qry_sel=mysql_query("SELECT * FROM tblAdmin");
$count=mysql_num_rows($qry_sel);

if (isset($_POST['update']))
{

$ar=$_POST['checkbox'];

$qry="delete from tblfakeaccess where `fake`=".$_POST['profile'];
//echo $qry;
@mysql_query($qry);

 for($i=0;$i<$count;$i++)
 {
   if($ar[$i])
   {
   $accesssql="insert into tblfakeaccess (`fake`,`operator`) values (".$_POST['profile'].",".$ar[$i].")";  
   //echo $accesssql;
   @mysql_query($accesssql); 
   }
 }

}


//////////////////////////////////////////
 
$profiles = mysql_query("SELECT tTM.`user_id`, count(tTM.`user_id`) as count,
                                                (SELECT `joined`
                                                 FROM   `tblUsers`
                                                 WHERE  `id` = tTM.`user_id`
                                                 LIMIT 1) as joined
                                         FROM   `tblTypeMails` tTM
                                         WHERE tTM.`new` = 'Y' AND tTM.`folder` = '1'
                                         GROUP BY tTM.`user_id`
                                         ORDER BY joined DESC");




?>
<form name="form"  method="post">
<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Assign Fakes to Chat Operators</font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td style="background-color:#EEEEEE; border:1px solid #CCCCCC">
		<table width="100%"  cellpadding="0" cellspacing="0" >
		<tr height="50">
			<td colspan="3" style="text-align:center "><?=$msg?></td>
		</tr>
	        <tr>
                  <td >
                    Select Fake to see Operator Access:
                    <select name="profile" onchange="submit();">
                    <option value="0">-select profile-</option>
                    <option value="1"<?if($_POST['profile']=='1') echo "selected";?>>See "ALL EMAILS"</option>
                    <option value="2"<?if($_POST['profile']=='2') echo "selected";?>>See ALL FAKES</option>
                    <option value="3"<?if($_POST['profile']=='3') echo "selected";?>>See "ASSIGNEMT/STATS/USERS"</option>
                    <option value="5"<?if($_POST['profile']=='5') echo "selected";?>>See "ALL PURPLES"</option>
                    
                     <?while($obj_p = mysql_fetch_array($profiles)){
                     
                     $users='';
                     $srlsql=mysql_query("SELECT user FROM tblAdmin INNER JOIN tblfakeaccess ON tblAdmin.id = tblfakeaccess.operator AND tblfakeaccess.fake ='".$obj_p['user_id']."'");
                     while($obj_pp=mysql_fetch_array($srlsql))
                     {
                        $users.=$obj_pp['user']." / ";
                     }
                     ;
                     
                     ?>
                      <option value="<?=$obj_p['user_id'];?>" <? if($_POST['profile'] == $obj_p['user_id']) echo "selected";?> ><?=id_to_screenname($obj_p['user_id']);?> (<?=$obj_p['count'];?>) - <?echo $users?></option>
                    <?}?>
                    </select>
		                 </label>
                      </td>
                  </tr>
                <tr height="50">
                        <td colspan="3" style="text-align:center"></td>
                </tr>
		<tr>
		
		<td>
		<table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">		
		<tr>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td colspan="4" bgcolor="#FFFFFF"><strong>Allow access to see fake :<?=id_to_screenname($_POST['profile'])?></strong> </td>
		</tr>
		<tr>
		  <td align="center" bgcolor="#FFFFFF">#</td>
	 	  <td align="center" bgcolor="#FFFFFF"><strong>Id</strong></td>
		  <td align="center" bgcolor="#FFFFFF"><strong>UserName</strong></td>
		  <td align="center" bgcolor="#FFFFFF"><strong>Fakes Assigned</strong></td>
		</tr>
		<?php
			while($rows=mysql_fetch_array($qry_sel)){
		?>
		 <tr>
		<td align="center" bgcolor="#FFFFFF"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $rows['id']; ?>"
		
	<?php
	$selsql="select * from tblfakeaccess where fake='".$_POST['profile']."' and operator='".$rows['id']."'";
	$qres=mysql_query($selsql);
	if (mysql_num_rows($qres)) echo "checked";
	?>
	</td>
		
		<td bgcolor="#FFFFFF"><? echo $rows['id']; ?></td>
		<td bgcolor="#FFFFFF"><? echo $rows['user']; ?></td>
		<td width="45%" bgcolor="#FFFFFF">
		<?
		$slsql=mysql_query("select fake from `tblfakeaccess` where fake not in (1,2,3) and operator='".$rows['id']."'");
		while($qry = mysql_fetch_array($slsql))
		    {
		    $prf = mysql_query("SELECT count(`user_id`) as count FROM `tblTypeMails`  WHERE `new` = 'Y' AND `folder` = '1' and `user_id`='".$qry['fake']."'");
                    $obj_prf = mysql_fetch_array($prf);                     
		    echo id_to_screenname($qry['fake'])."  (".$obj_prf['count'].") "; 
		    }
		?>
		</td>
		</tr>
		<?php
			}
		?>
		<tr>
		<td colspan="5" align="center" bgcolor="#FFFFFF"><input name="update" type="submit" id="update" value="Update"></td>
		</tr>
		</table>
		</td>
		</tr>
</table>
</td>

</table>
  </form>
