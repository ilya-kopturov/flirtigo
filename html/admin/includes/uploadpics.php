<?
	include("cnn.php");
	include("create_thumb.php");
	$msg="";
	if(!empty($_POST["action"]) && $_POST["action"]=="addpic"){
		$qry="select * from tblUsers where Id='".$_GET["id"]."'";
		$qry=mysql_query($qry);
		$theuser=mysql_fetch_array($qry);
		$nrpic=0;
		for($i=0;$i<=10;$i++){
			if($theuser["Pic".$i]!="") $nrpic++;
		}
		$new_name_img=$theuser["ScreenName"]."pic".$nrpic.rand(0,9999999).".";
		$uploadname=$_FILES['picture']['name'];
		$uploadsize=$_FILES['picture']['size'];
		$uploadnamel=strtolower($uploadname);
		//detecteaza daca esti jpg sau gif
		$namesplit=explode('.',$uploadnamel);
		//verify if does not contaigns more than 1 dot
		if(count($namesplit)==2){
		//verify if is jpg or gif or png or bmp
			if($namesplit[1]=="jpg" || $namesplit[1]=="gif" || $namesplit[1]=="png" || $namesplit[1]=="bmp"){
				$new_name_img.=$namesplit[1];
				//verify if file size is no more than 2 MB
				if($uploadsize<2000000){
					//create the large picture
					if (move_uploaded_file($_FILES['picture']['tmp_name'], "../../pictures/" .$uploadname)) {
						$succes=0; // if = 3 then all the pics were saved ( big, small and tiny)
						for($i=0;$i<3;$i++){
							if($i==0){
								$maxw=500;
								$maxh=800;
								$t="b";
							}
							if($i==1){
								$maxw=200;
								$maxh=400;
								$t="s";
							}
							if($i==2){
								$maxw=80;
								$maxh=160;
								$t="t";
							}
							//get the picture sizes
							list($width,$height)=getimagesize("../../pictures/".$uploadname);
							if($width>$maxw){
								$percent=$maxw/$width;
								$height=$height*$percent;
								$width=$maxw;
							}
							if($height>$maxh){
								$percent=$maxh/$height;
								$width=$width*$percent;
								$height=$maxh;
							}
							##create_thumbnail("../../pictures/".$uploadname, "../../pictures/users".$t."/" . $new_name_img, $width, $height, 100)
							if (create_thumbnail("../../pictures/".$uploadname, "../../pictures/users".$t."/" . $new_name_img, $width, $height, 100)){
								$succes++;
							}else{
								$msg.="<br>The picture ".$i." has not been inserted";
							}
						}
						if($succes==3){
								$msg.="The picture $new_name_img was uploaded";
								unlink("../../pictures/".$uploadname);
								if($_GET["thepic"]!=""){
									$thepicdb=$_GET["thepic"];
								}else{
									$thepicdb="Pic".$nrpic;
								}
								$qry="update tblUsers set ".$thepicdb."='".$new_name_img."' where Id='".$_GET["id"]."'";
								$qry=mysql_query($qry);
								$msg.="<br>The picture was inserted in the database";
						}else{
							$msg.="<br>The pictures have not been created";
						}
					}else{
						$msg.="File not uploaded";
					}
				}else{
					$msg.="File size must not exced 2 MB";
				}
			}else{
				$msg.="File is not a Jpg, Gif, Png or Bmp";
			}
		}else{
			$msg.="Unrecognized file type!";
		}
	}
?>
<html>
<head>
<link href='../default.css' rel='stylesheet' type='text/css'>
</head>
<body>
<form name="addpic" method="post" action="uploadpics.php?id=<?=$_GET["id"] ?><?=($_GET["thepic"]!="")?("&thepic=".$_GET["thepic"]):("") ?>" enctype="multipart/form-data">
<input type="hidden" name="action" value="addpic" />
<table style="vertical-align:top" align="center" width="95%" height="95%" cellpadding="0" cellspacing="0" border="0">	
	<tr>
		<td height="20"></td>
	</tr>
	<!-- Page title line -->
	<tr>
		<td width="100%"><font class="pagetitle">Upload pic </font></td>
	</tr>
	<!-- Page content line -->
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="20" width="100%" bgcolor="#EEEEEE" style="border-style:solid; border-color:#000000; border-width:0px">
		
					<table bgcolor="#EEEEEE" style="vertical-align:middle" align="center" border="0" cellpadding="0" height="22" cellspacing="0">
					<tr valign="middle">
						<td valign="middle" height="22"><font class="filternameblack"><?=$msg ?></font></td>
					</tr>
					</table>		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="10" align="center"><input class="tabletext" name="picture" type="file" size="35" /></td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="10" align="center"><input class="tabletext" name="Submit" type="submit" value="Upload" size="35" /></td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="100%"></td>
	</tr>
</table>
</form>
</body>
</html>