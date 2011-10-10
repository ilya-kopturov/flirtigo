<?
session_start();

include("../includes/config/" . "db.php");
include("../includes/config/" . "path.php");
include("../includes/config/" . "image.php");
include("../includes/config/" . "option.php");
include("../includes/config/" . "profile.php");
include("../includes/config/" . "template.php");
?>

<html>
<head>
  <title>View Video</title>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#000000">
 <div align="center">
 <object id="flashplayer" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="260">
   <param name="movie" value="<?=$cfg['path']['url_site'];?>media/videoplayer/flvplayer.swf" />
   <param name="allowfullscreen" value="true" />
   <param name="flashvars" value="&file=<?=$cfg['path']['url_videos'];?>flv/<?=$_GET['user_id'];?>_<?=$_GET['video_id'];?>.flv&image=<?=$cfg['path']['url_videos'];?>thumb/<?=$_GET['user_id'];?>_<?=$_GET['video_id'];?>_m.jpg&height=260&width=320">
 </object>
 </div>
</body>
</html>