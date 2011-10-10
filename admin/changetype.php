<?php
session_set_cookie_params(0);
session_start();

set_include_path(".:../pear");

require("includes/cnn.php");

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");

include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );
include_once( $cfg['path']['dir_include'] . "class"  . "/" . "phpmailer.php" );


$db = & DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");

$sql_pictures = mysql_query("SELECT * FROM `tblPhotos` WHERE `user_id` = '" . $_GET['id'] . "' AND `approved` = 'Y'");
$nr_pictures  = mysql_num_rows($sql_pictures);
$sql_videos   = mysql_query("SELECT * FROM `tblVideos` WHERE `user_id` = '" . $_GET['id'] . "' AND `approved` = 'Y'");
$nr_videos    = mysql_num_rows($sql_videos);
?>

<html>
  <head>
    <title>Change Campaign Internal Message Type</title>
    <script type="text/javascript">
     function checkpictureid(val){
		opener.document.addform.messageinterntype_id.value = val;
		opener.document.addform.messageinterntype.value = "I";
		opener.document.getElementById("messageinterntype_label").innerHTML = "<img src='http://dev.flirtigo.com/showphoto.php?<?=md5(microtime());?>&photo_id="+val+"' />";
		
		self.close();
     }
     
     function checkvideoid(val){
		opener.document.addform.messageinterntype_id.value = val;
		opener.document.addform.messageinterntype.value = "V";
		opener.document.getElementById("messageinterntype_label").innerHTML = "<img src='http://dev.flirtigo.com/videothumb.php?<?=md5(microtime());?>&video_id="+val+"' />";
		
		self.close();
     }
    </script>
  </head>
  <body>
    <table>
      <tr>
        <td style="vertical-align: top;">
          <table>
            <tr>
              <td>Images</td>
            </tr>
            <?php
            while($obj_pictures = mysql_fetch_object($sql_pictures)){
            ?>
            <tr>
              <td>
                <img style="cursor: pointer;" src="http://dev.flirtigo.com/showphoto.php?<?=md5(microtime());?>&photo_id=<?=$obj_pictures->id;?>" onclick="javascript: checkpictureid(<?=$obj_pictures->id;?>);" /></td>
            </tr>
            <?php
            }
            ?>
          </table>
        </td>
        <td width="30"></td>
        <td style="vertical-align: top;">
          <table>
            <tr>
              <td>Videos</td>
            </tr>
            <?php
            while($obj_videos = mysql_fetch_object($sql_videos)){
            ?>
            <tr>
              <td>
                <img style="cursor: pointer;" src="http://dev.flirtigo.com/videothumb.php?<?=md5(microtime());?>&video_id=<?=$obj_videos->id;?>" onclick="javascript: checkvideoid(<?=$obj_videos->id;?>);" />
                </td>
            </tr>
            <?php
            }
            ?>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>