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


$countries = $db->get_results("SELECT * FROM `tblCountries`", ARRAY_N);
$states = $db->get_results("SELECT * FROM `tblStates`", ARRAY_N);

$user = @mysql_fetch_array(mysql_query("SELECT * FROM `tblUsers` WHERE `id` = '" . $_GET['id'] . "' LIMIT 1"));
?>
<html>
<head>
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
								<td><label class="middle-column-link">Location:</label></td><td bgcolor="#FFFFFF"><?=$countries[$user['country']];?></td>
							</tr>
							<tr valign="top"> 
								<td><label class="middle-column-link">State:</label></td><td bgcolor="#FFFFFF"><?=$states[$user['state']];?></td>
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