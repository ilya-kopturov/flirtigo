<?php
$username     = id_to_screenname($_GET['id']);
$arr_paystats = payments_stats($username);

if($arr_paystats['processor'] == 'CCBill'){
        $sql = mysql_query("SELECT A.username, A.start_date as date, A.initialPrice as amount, 'add' as type
                                                                FROM `ccbill_post` AS A
                                                                WHERE A.username = '". $username ."'
                                                UNION
                                                SELECT A.username, B.transactionDate as date, B.amount, 'rebill' as type
                                                                FROM `ccbill_post` AS A, `ccbill_rebills` AS B
                                                                WHERE A.username = '". $username ."'
                                                                AND A.subscription_id = B.subscription_id
                                                UNION
                                                SELECT A.username, C.transactionDate as date, '-' as amount, 'cancel' as type
                                                                FROM `ccbill_cancelation` AS C, `ccbill_post` AS A
                                                                WHERE A.username = '". $username ."'
                                                                AND A.subscription_id = C.subscription_id");
}elseif($arr_paystats['processor'] == '2000Charge'){
        $sql = mysql_query("SELECT `date` as date, `client_username` as username, `status` as type, `client_amount` as amount FROM `tblPayments2000` WHERE `client_username` = '" . $client_username . "' ORDER BY `date` ASC");
}
?>

<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
  <tr>
    <td width="100%"><font class="pagetitle">Payments History for <?=id_to_screenname($_GET['id']);?></font></td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td>
      <table cellpadding="2" cellspacing="2" border="0">
        <tr>
          <td width="100" align="left" style="font-size: 11px; font-family: Verdana;">Member since:</td>
          <td style="font-size: 11px; font-family: Verdana; font-weight: bold; color: blue;"><?if($arr_paystats['date'] != '-'){?> <?=date("F j, Y, g:i a", mktime(substr($arr_paystats['date'],11,2),substr($arr_paystats['date'],14,2),substr($arr_paystats['date'],17,2),substr($arr_paystats['date'],5,2),substr($arr_paystats['date'],8,2),substr($arr_paystats['date'],0,4)));?> ( <?=$arr_paystats['months'];?> months ) <?}else{echo "-";}?></td>
        </tr>
        <tr>
          <td width="100" align="left" style="font-size: 11px; font-family: Verdana;">Processor:</td>
          <td style="font-size: 11px; font-family: Verdana; font-weight: bold; color: blue;"><?echo $arr_paystats['processor']?></td>
        </tr>
        <tr>
          <td width="100" align="left" style="font-size: 11px; font-family: Verdana;">Paid amount:</td>
          <td style="font-size: 11px; font-family: Verdana; font-weight: bold; color: blue;"><?echo $arr_paystats['amount']?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td>
      <table cellpadding="0" cellspacing="1" border="0" width="650">
        <tr style="font-size: 12px; font-family: Arial; font-weight: bold; color: black;" bgcolor="#DFE9FD">
          <td align="center" width="25"  height="25">Id</td>
          <td align="center" width="175" height="25">Date</td>
          <td align="center" width="150" height="25">UserId</td>
          <td align="center" width="100" height="25">Processor</td>
          <td align="center" width="100" height="25">Type</td>
          <td align="center" width="100" height="25">Amount</td>
        </tr>
        <?if($sql){ $i = 1;?>
        <?while($array = mysql_fetch_array($sql)){?>
        <? if($tdcolor == "#FFFFFF"){$tdcolor = "#F2F2F2";}else{$tdcolor = "#FFFFFF";}?>
        <tr style="font-size: 11px; font-family: Verdana; color: black;" onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
          <td align="center" width="25"  height="20"><?=$i;?></td>
          <td align="center" width="125" height="20"><?=$array['date'];?></td>
          <td align="center" width="100" height="20"><?=$array['username'];?></td>
          <td align="center" width="100" height="20"><?=$arr_paystats['processor'];?></td>
          <td align="center" width="100" height="20"><?=$array['type'];?></td>
          <td align="center" width="100" height="20"><?if((int) $array['amount'] > 0){?><?=$array['amount'];?>$<?}else{echo "-";}?></td>
        </tr>
        <?$i++;}?>
        <?}else{?>
        <tr style="font-size: 11px; font-family: Verdana; color: black;">
          <td align="center" colspan="4" height="20">No records found.</td>
        </tr>
        <?}?>  
      </table>
    </td>
  </tr>
</table>

<script language="JavaScript">
	if(document.getElementById('users1').style.display == 'none'){
		document.getElementById('users1').style.display = '';
	}
	if(document.getElementById('users2').style.display == 'none'){
		document.getElementById('users2').style.display = '';
	}
	if(document.getElementById('users3').style.display == 'none'){
		document.getElementById('users3').style.display = '';
	}
	if(document.getElementById('users4').style.display == 'none'){
		document.getElementById('users4').style.display = '';
	}
	if(document.getElementById('users5').style.display == 'none'){
		document.getElementById('users5').style.display = '';
	}
	if(document.getElementById('users6').style.display == 'none'){
		document.getElementById('users6').style.display = '';
	}
	if(document.getElementById('users7').style.display == 'none'){
		document.getElementById('users7').style.display = '';
	}
	if(document.getElementById('users8').style.display == 'none'){
		document.getElementById('users8').style.display = '';
	}
	if(document.getElementById('users9').style.display == 'none'){
		document.getElementById('users9').style.display = '';
	}
	if(document.getElementById('users10').style.display == 'none'){
		document.getElementById('users10').style.display = '';
	}
	if(document.getElementById('users11').style.display == 'none'){
		document.getElementById('users11').style.display = '';
	}
</script>
