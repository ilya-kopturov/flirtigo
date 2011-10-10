<?
	if(!empty($_POST["action"]) && $_POST["action"]=="add"){
		$anr=rand(0, 200);
		$qry="insert into `tblCreateSite` (`Name`) values ('needstobeupdated".$anr."')";
		$qry=mysql_query($qry);
		$qry="select * from `tblCreateSite` where `Name`='needstobeupdated".$anr."'";
		$qry=mysql_query($qry);
		$qry=mysql_fetch_array($qry);
		$theid=$qry["Id"];
		$qry="update `tblCreateSite` set";
		$qry.=" `Name`='".$_POST["name"]."'";
		$qry.=", `Template`='".$_POST["template"]."'";
		$qry.=", `Url`='".$_POST["url"]."'";
		$qry.=", `NrUsers`='".$_POST["nr_total"]."'";
		######begin creating rules
		$qry.=", `Rules`='";
		if($_POST["rules"]>0){
			//$qry.="select * from (";
			for($i=1;$i<=$_POST["rules"];$i++){
				$qry.=" (select * from tblUsers";
				##select the sex
				$sex="";
				$sex.=($_POST["man".$i])?("1,"):("0,");
				$sex.=($_POST["woman".$i])?("1,"):("0,");
				$sex.=($_POST["couple".$i])?("1,"):("0,");
				$sex.=($_POST["group".$i])?("1,"):("0,");
				$sex.=($_POST["lesbian".$i])?("1,"):("0,");
				$sex.=($_POST["gay".$i])?("1"):("0");
				if($sex!="0,0,0,0,0,0"){
					$front=0;
					$where="";
					if($where==""){
						$where=" where (";
						$qry.=" where (";
					}
					##sex=man
					if($_POST["man".$i]!=""){
						$qry.=" `Sex`=\'man\'";
						$front=1;
					}
					##sex=woman
					if($_POST["woman".$i]!=""){
						if($front==1) $qry.=" or";
						$qry.=" `Sex`=\'woman\'";
						$front=1;
					}
					##sex=couple
					if($_POST["couple".$i]!=""){
						if($front==1) $qry.=" or";
						$qry.=" `Sex`=\'couple\'";
						$front=1;
					}
					##sex=group
					if($_POST["group".$i]!=""){
						if($front==1) $qry.=" or";
						$qry.=" `Sex`=\'group\'";
						$front=1;
					}
					##sex=lesbian
					if($_POST["lesbian".$i]!=""){
						if($front==1) $qry.=" or";
						$qry.=" `Sex`=\'lesbian\'";
						$front=1;
					}
					##sex=gay
					if($_POST["gay".$i]!=""){
						if($front==1) $qry.=" or";
						$qry.=" `Sex`=\'gay\'";
						$front=1;
					}
					$qry.=")";
				}
				##select the sex
				##select countryes
				if($_POST["country".$i]!=""){
					$country=array();
					$country=$_POST["country".$i];
					if($country[0]!=''){
						if($where==""){
							$where=" where (";
							$qry.=" where (";
						}else{
							$qry.=" and (";
						}
						for($c=0;$c<count($country);$c++){
							if($country[$c]!=""){
								$op=($c!=0)?(" or "):("");
								$qry.=$op."`Country`='".$country[$c]."'";
							}
						}
						$qry.=")";
					}
				}
				##select countryes
				##select looking for
				$op=" ".$_POST["looking_operator".$i];
				$looking="";
				$looking.=($_POST["lookingman".$i])?("1,"):("0,");
				$looking.=($_POST["lookingwoman".$i])?("1,"):("0,");
				$looking.=($_POST["lookingcouple".$i])?("1,"):("0,");
				$looking.=($_POST["lookinggroup".$i])?("1,"):("0,");
				$looking.=($_POST["lookinglesbian".$i])?("1,"):("0,");
				$looking.=($_POST["lookinggay".$i])?("1"):("0");
				if($looking!="0,0,0,0,0,0"){
					$front=0;
					if($where==""){
						$where=" where (";
						$qry.=" where (";
					}else{
						$qry.=" and (";
					}
					##sex=man
					if($_POST["lookingman".$i]!=""){
						$qry.=" LookingMan=\'1\'";
						$front=1;
					}
					##sex=woman
					if($_POST["lookingwoman".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" LookingWoman=\'1\'";
						$front=1;
					}
					##sex=couple
					if($_POST["lookingcouple".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" LookingCouple=\'1\'";
						$front=1;
					}
					##sex=group
					if($_POST["lookinggroup".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" LookingGroup=\'1\'";
						$front=1;
					}
					##sex=lesbian
					if($_POST["lookinglesbian".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" LookingLesbian=\'1\'";
						$front=1;
					}
					##sex=gay
					if($_POST["lookinggay".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" LookingGay=\'1\'";
						$front=1;
					}
					$qry.=")";
				}
				##select looking for
				##select account type
				$op=" or";
				$account="";
				$account.=($_POST["free".$i])?("1,"):("0,");
				$account.=($_POST["silver".$i])?("1,"):("0,");
				$account.=($_POST["gold".$i])?("1,"):("0");
				if($account!="0,0,0"){
					$front=0;
					if($where==""){
						$where=" where (";
						$qry.=" where (";
					}else{
						$qry.=" and (";
					}
					##account=free
					if($_POST["free".$i]!=""){
						$qry.=" PayedMember=\'1\'";
						$front=1;
					}
					##account=silver
					if($_POST["silver".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" PayedMember=\'2\'";
						$front=1;
					}
					##account=silver
					if($_POST["gold".$i]!=""){
						if($front==1) $qry.=$op;
						$qry.=" PayedMember=\'3\'";
						$front=1;
					}
				}
				##select account type
				$qry.=")";
				##limit the number
				if($_POST["nr".$i]!=""){
					$qry.=" limit ".$_POST["nr".$i];
				}
				##limit the number
				$qry.=")";
				$qry.=($i<$_POST["rules"])?(" union"):("");
			}
			
			if($_POST["nr_total"]!=""){
				$qry.=" limit ".$_POST["nr_total"];
			}
		}else{
			if($_POST["nr_total"]!=""){
				$qry.=" select * from tblUsers limit ".$_POST["nr_total"];
			}
		}
		######end creating rules
		
		$qry.="'";
		echo $qry.=" where Id='".$theid."'";
		$qry=mysql_query($qry);
		$msg="The site with id ".$theid." was inserted in the database";
		echo "<br><script>document.location.href='index.php?content=editsite&id=".$theid."&msg=".$msg."'</script><br>";
	}
?>
<form name="addform" method="post" action="index.php?content=addsite">
<input type="hidden" name="action" value="add" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Create New Site -<font color="#990000"> Step 1</font></font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$_GET["msg"] ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td><font class="tablename">* - required fields</font></td>
	</tr>
	<tr>
		<td height="4"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Name*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="name" id="name" size="35" value="" /></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Total number of exported users:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="nr_total" id="nr" size="35" value="" />(if not completed all the users will be selected)</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<input type="hidden" name="rules" value="0" />
			<?
				for($r=1;$r<=10;$r++){
			?>
			<tr>
				<td>
			<div id="rule<?=$r ?>" style="display:none">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td onmouseover="this.style.backgroundColor='#FFFFE6'" onmouseout="this.style.backgroundColor='#FFFFE6'" height="25" bgcolor="#FFFFE6" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" colspan="2" align="center">&nbsp;&nbsp;<font class="tabletext" style="color:#990000; font-size:14px"><strong>Rule <?=$r ?>:</strong></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Number of exported users:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="nr<?=$r ?>" id="nr" size="35" value="" />(if not completed all the users will be selected)</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Users sex:</font></td>
					<td width="70%" align="left"><font class="tabletext">
					<input type="checkbox" name="man<?=$r ?>" value="1" />Man
					<input type="checkbox" name="woman<?=$r ?>" value="1" />Woman
					<input type="checkbox" name="couple<?=$r ?>" value="1" />Couple (man and woman)
					<input type="checkbox" name="group<?=$r ?>" value="1" />Group
					<input type="checkbox" name="lesbian<?=$r ?>" value="1" />Lesbian Couple
					<input type="checkbox" name="gay<?=$r ?>" value="1" />Gay Coople
					</font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">From country:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="country<?=$r ?>[]" id="country" size="10" multiple="multiple">
					<option value="">--All countries--</option>
					<?
						$cqry="select * from tblCountry order by Name";
						$cqry=mysql_query($cqry);
						$nrc=mysql_num_rows($cqry);
						$sel="";
						for($i=0;$i<$nrc;$i++){
							$country=mysql_fetch_array($cqry);
							if($theuser["Country"]==$country["Id"]){
								$sel=" selected='selected'";
							} else {
								$sel="";
							}
							echo "<option".$sel." value='".$country["Id"]."' class='forms'>".$country["Name"]."</option>";
						}
					?>
					</select></font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Looking:</font></td>
					<td width="70%" align="left"><font class="tabletext"><input class="tabletext" name="lookingman<?=$r ?>" id="lookinman" value="1" type="checkbox" /> Man <input class="tabletext" name="lookingwoman<?=$r ?>" id="lookingwoman" value="1" type="checkbox" /> 
					Woman <input class="tabletext" name="lookingcouple<?=$r ?>" id="lookingcouple" value="1" type="checkbox" /> 
					Couple (man and woman)<input class="tabletext" name="lookinggroup<?=$r ?>" id="lookinggroup" value="1" type="checkbox" /> 
					Group <input class="tabletext" name="lookinglesbian<?=$r ?>" id="lookinglesbian" value="1" type="checkbox" /> 
					Lesbian Couple <input class="tabletext" name="lookinggay<?=$r ?>" id="lookinggay" value="1" type="checkbox" /> 
					Gay Couple<br />
					&nbsp;Operator: <select name="looking_operator<?=$r ?>">
					<option value="or">or</option>
					<option value="and">and</option>
					</select> (ex: man or/and couple)</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Account type:</font></td>
					<td width="70%" align="left"><font class="tabletext"><input type="checkbox" name="free<?=$r ?>" value="1" /> Free <input type="checkbox" name="silver<?=$r ?>" value="1" /> Silver <input type="checkbox" name="gold<?=$r ?>" value="1" /> Gold</font></td>
				</tr>
				</table>		
				</td>
			</tr>
			</table>
			</div>
				</td>
			</tr>
			<? } ?>
			
			
			<tr>
				<td onmouseover="this.style.backgroundColor='#FFFFE6'" onmouseout="this.style.backgroundColor='#FFFFE6'" height="25" bgcolor="#FFFFE6" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" colspan="2" align="center">&nbsp;&nbsp;<font class="tabletext"><input type="button" name="addrule" value="Add Rule" style="background:#990000; color:#FFFFE6; border:1px solid #990000" onclick="document.addform.rules.value=Number(document.addform.rules.value)+1; if(document.addform.rules.value<=10){document.getElementById('rule'+document.addform.rules.value).style.display='block'}else{alert('Maximum rules')}" /> (no more than 10)</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			<tr>
				<td  onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#FFFFFF'" height="25" bgcolor="#FFFFFF" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Template*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><select class="tabletext" name="template" id="template">
					<option value="">--Select--</option>
					<?
						$query="select * from tblTemplates order by Id";
						$query=mysql_query($query);
						for($i=0;$i<mysql_num_rows($query);$i++){
							$templ=mysql_fetch_array($query);
							echo "<option value='".$templ["Id"]."'>".$templ["Name"]."</option>";
						}
					?>
					</select></font></td>
				</tr>
				</table>		
				</td>
			</tr>
			<tr>
				<td onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='#f2f2f2'" height="25" bgcolor="#f2f2f2" width="100%">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" align="right">&nbsp;&nbsp;<font class="tabletext">Url*:</font></td>
					<td width="70%" align="left">&nbsp;<font class="tabletext"><input type="text" class="tabletext" name="url" id="url" size="35" /> (ex: <strong>server</strong> without http:// or ftp:// in front)</font></td>
				</tr>
				</table>				
				</td>
			</tr>
			
			
			 <tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%">&nbsp;&nbsp;<font class="tablecateg"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			 
			<tr>
				<td height="25" style="background:url(pics/main/backgr_tabel_fade.jpg)" width="100%">
				<?
					//create the list of fields that have to ve verified
					$verif="name,url,template";
					
				?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="100%">&nbsp;&nbsp;<font class="tablecateg"><input class="tablecateg" type="button" onclick="javascript: verif('addform','<?=$verif ?>')" style="color:#333333" name="insert" value="Save">&nbsp;&nbsp;<input class="tablecateg" type="reset" style="color:#333333" name="reset" value="Reset"></font></td>
				</tr>
				</table>				</td>
			</tr>
			</table>		</td>
	</tr>	
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>

<script language="JavaScript">
	if(document.getElementById('websites1').style.display == 'none'){
		document.getElementById('websites1').style.display = '';
	}
	if(document.getElementById('websites2').style.display == 'none'){
		document.getElementById('websites2').style.display = '';
	}
	if(document.getElementById('websites3').style.display == 'none'){
		document.getElementById('websites3').style.display = '';
	}
</script>