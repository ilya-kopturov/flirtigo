<?
$arr_new = array("Y" => "Yes", "N" => "No");
$arr_upd = array("1" => "Weekly", "2" => "Monthly");

if(isset($_POST['addplugin'])){
	if($_POST['title'] AND $_POST['description'] and $_POST['url'] and $_FILES['bigpic']['tmp_name'] AND $_FILES['smallpic']['tmp_name']){
		@mysql_query("INSERT INTO `tblMembersClub` (`title`, `url`, `description`, `updated`, `new`) 
	    	          VALUES ('" . addslashes(trim($_POST['title'])) . "', '" . addslashes(trim($_POST['url'])) . "', '" . addslashes(trim($_POST['description'])) . "', 
	        	              '" . (int) $_POST['updated']. "', '" . $_POST['new'] . "')");
		
		if(!mysql_error()){
			$pic_id = mysql_insert_id();
			
			move_uploaded_file($_FILES['bigpic']['tmp_name'],   "/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $pic_id . "b.jpg");
			move_uploaded_file($_FILES['smallpic']['tmp_name'], "/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $pic_id . "s.jpg");
			$_POST = array();
		}else{
			echo mysql_error();
		}
	}
}

if(isset($_POST['editplugin'])){
	@mysql_query("UPDATE `tblMembersClub` SET `title` = '" . addslashes(trim($_POST['title'])) . "', 
											  `url` = '" . addslashes(trim($_POST['url'])) . "', 
	                                          `description` = '" . addslashes(trim($_POST['description'])) . "', 
	                                          `updated` = '" . (int) $_POST['updated'] . "', 
	                                          `new` = '" . (int) $_POST['new']. "'
	              WHERE `id` = '" . (int) $_POST['id'] . "'");
	
	if(!mysql_error()){
		if($_FILES['bigpic']['tmp_name']){
			unlink("/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "b.jpg");
			move_uploaded_file($_FILES['bigpic']['tmp_name'],   "/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "b.jpg");
		}
		if($_FILES['smallpic']['tmp_name']){
			unlink("/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "s.jpg");
			move_uploaded_file($_FILES['smallpic']['tmp_name'],   "/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "s.jpg");
		}
	}else{
		echo mysql_error();
	}
	
	$_POST = array();
}

if(isset($_POST['deleteplugin']) AND (int) $_POST['id'] > 0){
	@mysql_query("DELETE FROM `tblMembersClub` WHERE `id` = '" . (int) $_POST['id'] . "' LIMIT 1");
	@mysql_query("DELETE FROM `tblFavoritePlugins` WHERE `plugin_id` = '" . (int) $_POST['id'] . "' LIMIT 1");
	unlink("/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "b.jpg");
	unlink("/home/httpd/vhosts/flirtigo.com/html/images/mc_" . (int) $_POST['id'] . "s.jpg");
	
	$_POST = array();
}
?>

<table style="vertical-align:top" align="center" width="95%" cellpadding="0" cellspacing="20" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Members Club Page</font></td>
	</tr>
	<tr>
	    <td align="left" width="100%"><font class="filternameblack"><span style="font-color: red"><?=$msg;?></span></font></td>
	</tr>
	<!-- Page content line -->
	<?
		$qry = "SELECT * FROM `tblMembersClub` ORDER BY `id` DESC";
		
		$qry = mysql_query($qry);
		$nr_found=mysql_num_rows($qry);
	?>
	<tr>
	<td>
	<table style="vertical-align:top; width:1000px" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top">
			<table bgcolor="#CCCCCC" cellpadding="0" cellspacing="3">
			<form enctype="multipart/form-data" method="post">
			<tr height="35">
			  <td colspan="2" style="font-face: 'Verdana'; font-size: 12px;"><u>Add Plugin</u></td>
			</tr>
			<tr height="20">
			  <td class="tablecateg">Title:</td>
			  <td class="tablecateg"><input type="text" name="title" value="<?=$_POST['title'];?>" maxlength="100" style="width: 300px;"></td>
			</tr>
			<tr height="20">
			  <td class="tablecateg">URL:</td>
			  <td class="tablecateg"><input type="text" name="url" value="<?=$_POST['url'];?>" maxlength="150" style="width: 300px;"></td>
			</tr>
			<tr height="20">
			  <td class="tablecateg">Description:</td>
			  <td class="tablecateg"><textarea name="description" style="width: 300px; height: 75px;"><?if(trim($_POST['description'])){ echo trim($_POST['description']);}?></textarea></td>
			</tr>
			<tr height="20">
			  <td class="tablecateg">Big Pic:</td>
			  <td class="tablecateg"><input type="file" name="bigpic" style="width: 300px;"></td>
			</tr>
			<tr height="20">
			  <td class="tablecateg">Small Pic:</td>
			  <td class="tablecateg"><input type="file" name="smallpic" style="width: 300px;"></td>
			</tr>
			<tr height="25">
			  <td class="tablecateg">Updated:</td>
			  <td class="tablecateg">
			    <select name="updated">
			      <option value="1" <? if($_POST['updated'] == 1) echo "selected";?> >Weekly</option>
			      <option value="2" <? if($_POST['updated'] == 2) echo "selected";?> >Monthly</option>
			    </select>&nbsp;&nbsp;&nbsp;&nbsp;
			    New: <input type="radio" name="new" value="Y" <? if($_POST['new'] == 'Y' or !$_POST['new']) echo "checked";?> > Y &nbsp;<input type="radio" name="new" value="N" <? if($_POST['new'] == 'N') echo "checked";?> > N
			  </td>
			</tr>
			<tr height="40">
			  <td class="tablecateg"></td>
			  <td class="tablecateg"><input type="submit" name="addplugin" value="Add Plugin" style="width: 300px;"></td>
			</tr>
			</form>
			</table>		
			</td>
	</tr>
	
	<tr>
	  <td height="30"></td>
	</tr>
	
	<tr>
		<td valign="top">
			<table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td colspan="2" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			<?
				$tdcolor="#f2f2f2";
				for($i=0; $i<$nr_found; $i++){
				if($i%2 == 0){
				if($tdcolor=="#f2f2f2"){
					$tdcolor="#FFFFFF";
				} else {
					$tdcolor="#f2f2f2";
				}}
				
				$plugins = mysql_fetch_array($qry);
				
			?>
			<? if($i%2 == 0 and $i != 0){?>
			  </tr>
			  <tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
			<?}elseif($i%2 == 0){?>
			  <tr onmouseover="this.style.backgroundColor='#CCCCCC'" onmouseout="this.style.backgroundColor='<?=$tdcolor ?>'" style="background-color:<?=$tdcolor ?>">
			<?}?>
			  <td align="left" width="500">
			    <table cellpadding="2" cellspacing="3">
		        <form enctype="multipart/form-data" method="post">
		        <input type="hidden" name="id" value="<?=$plugins['id'];?>">
			    <tr height="20">
			      <td class="tablecateg">Title:</td>
			      <td class="tablecateg"><input type="text" name="title" value="<?=$plugins['title'];?>" maxlength="100" style="width: 300px;"></td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">URL:</td>
			      <td class="tablecateg"><input type="text" name="url" value="<?=$plugins['url'];?>" maxlength="150" style="width: 300px;"></td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">Description:</td>
			      <td class="tablecateg"><textarea name="description" style="width: 300px; height: 75px;"><?if(trim($plugins['description'])){ echo trim($plugins['description']);}?></textarea></td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">
			      </td>
			      <td class="tablecateg">
			        <img src="/images/mc_<?=$plugins['id'];?>b.jpg?<?=rand();?>" border="1" />
			      </td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">Big Pic:</td>
			      <td class="tablecateg"><input type="file" name="bigpic" style="width: 300px;"></td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">
			      </td>
			      <td class="tablecateg">
			        <img src="/images/mc_<?=$plugins['id'];?>s.jpg?<?=rand();?>" border="1" />
			      </td>
			    </tr>
			    <tr height="20">
			      <td class="tablecateg">Small Pic:</td>
			      <td class="tablecateg"><input type="file" name="smallpic" style="width: 300px;"></td>
			    </tr>
			    <tr height="25">
			      <td class="tablecateg">Updated:</td>
			      <td class="tablecateg">
			        <select name="updated">
			          <option value="1" <? if($plugins['updated'] == 1) echo "selected";?> >Weekly</option>
			          <option value="2" <? if($plugins['updated'] == 2) echo "selected";?> >Monthly</option>
			        </select>&nbsp;&nbsp;&nbsp;&nbsp;
			        New: <input type="radio" name="new" value="Y" <? if($plugins['new'] == 'Y' or !$plugins['new']) echo "checked";?> > Y &nbsp;<input type="radio" name="new" value="N" <? if($plugins['new'] == 'N') echo "checked";?> > N
			      </td>
			    </tr>
			    <tr height="40">
			      <td class="tablecateg"></td>
			      <td class="tablecateg"><input type="submit" name="editplugin" value="Edit Plugin" style="width: 100px;"> &nbsp;&nbsp;&nbsp; <input type="submit" name="deleteplugin" value="DELETE" style="background-color:#BBD2F8; width: 100px;"></td>
			    </tr>
			    </form>
			    </table>	
			  </td>
			<?
				}
			?>
			<tr>
				<td colspan="2" height="3" bgcolor="#990000" width="100%"></td>
			</tr>
			</table>		
			</td>
	</tr>
	</table>
	</td>
	</tr>
	
</table>

<script language="JavaScript">
	if(document.getElementById('content1').style.display == 'none'){
		document.getElementById('content1').style.display = '';
	}
	if(document.getElementById('content2').style.display == 'none'){
		document.getElementById('content2').style.display = '';
	}
</script>