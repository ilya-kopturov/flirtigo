<?php
//error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set("magic_quotes_gpc", '0');

define("IN_MAINSITE", TRUE);

include('../includes/require/site_head.php');

$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");

$user = @mysql_fetch_array(mysql_query(
	"SELECT
		u.*,
		c.name AS country_name,
		s.name AS state_name
	FROM
		`tblUsers` u
		LEFT JOIN `tblCountries` c ON u.country = c.id
		LEFT JOIN `tblStates` s ON u.state = s.id
	WHERE
		u.id = '" . $_GET['id'] . "'
	LIMIT 1"
));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
<title>View Profile</title>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">

<table width="100%">
  <tr>
    <td colspan="8" height="3" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <tr class="tablecateg" style="background:url(pics/main/backgr_tabel_fade.jpg)">
    <td style="padding-left: 10px;" width="60%" align="left">Profile info of <?=id_to_screenname($_GET['id']);?></td>
    <td style="padding-left: 10px;" width="40%" align="left">View Images</td>
  </tr>
  <tr>
    <td colspan="8" height="1" bgcolor="#990000" width="100%"></td>
  </tr>
  
  <tr class="tablecateg">
    <td style="padding-left: 10px;" width="60%" align="left" valign="top">
    
    
						<table width="98%" border="0" cellpadding="4" cellspacing="1" class="middle-column">
							<tr align="center">
								<th height="30" colspan="2"><?if ($user['introtitle']) echo $user['introtitle']; else echo "Introduction Title text"; ?></th>
							</tr>	  
							<tr valign="top"> 
								<td width="130" class="middle-column" valign="top"><label class="middle-column-link">Age:</label></td><td bgcolor="#FFFFFF"><?=age($user['birthdate']);?></th>
							</tr>
							<tr> 
								<td><label class="middle-column-link">I am/We are a:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['sex'][$user['sex']];?></td>
							</tr>
							<tr valign="top"> 
								<td class="middle-column"><label class="middle-column-link">Interested in:</label></td><td bgcolor="#FFFFFF"><?=looking($user['looking']);?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">For some:</label></td><td bgcolor="#FFFFFF"><?=forr($user['for']);?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">City:</label></td><td bgcolor="#FFFFFF"><?=$user['city'];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Location:</label></td><td bgcolor="#FFFFFF"><?= $user['country_name'] ?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">State:</label></td><td bgcolor="#FFFFFF"><?= $user['state_name'] ?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Body type:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['bodytype'][$user['bodytype']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Height:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['height'][$user['height']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Body Hair:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['bodyhair'][$user['bodyhair']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Cock/Breast size:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['cockbreast'][$user['cockbreast']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Safe Sex:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['safesex'][$user['safesex']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Hair color:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['haircolor'][$user['haircolor']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Ethnicity:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['ethnicity'][$user['ethnicity']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Travel arrangements:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['travel'][$user['travel']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Smoking:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['smoking'][$user['smoking']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Drinking:</label></td><td bgcolor="#FFFFFF"><?=$cfg['profile']['drinking'][$user['drinking']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Introduction text:</label></td><td bgcolor="#FFFFFF"><?=$user['introtext'];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">Looking for:</label></td><td bgcolor="#FFFFFF"><?=$user['describe'];?></td>
							</tr>
						</table>     
    
    
    </td>
    <td width="40%" align="center">
      <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$_GET['id']?>&t=s&p=1">
        <br><br>
      <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$_GET['id']?>&t=s&p=2">
        <br><br>
      <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$_GET['id']?>&t=s&p=3">
        <br><br>
      <img src="<?=$cfg['path']['url_site']?>showphoto.php?id=<?=$_GET['id']?>&t=s&p=4">
        <br><br>
    </td>
  </tr>
  
  <tr>
    <td colspan="8" height="3" bgcolor="#990000" width="100%"></td>
  </tr>
</table>

</body>
</html>
