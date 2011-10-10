<?php 
require("../includes/cnn.php");

include("../../includes/config/" . "db.php");
include("../../includes/config/" . "path.php");
include("../../includes/config/" . "image.php");
include("../../includes/config/" . "option.php");
include("../../includes/config/" . "profile.php");
include("../../includes/config/" . "template.php");

include_once( $cfg['path']['dir_include'] . "class"  . "/" . "db.php" );

$db = new db( $cfg['db']['user'], 
              $cfg['db']['password'], 
              $cfg['db']['db'], 
              $cfg['db']['host']
            );


            
$featuredUsersToDelete=$_POST['usercheckfield'];
if($featuredUsersToDelete!=0){
	$featuredUsersToDeleteArray=explode(",",$featuredUsersToDelete);
	foreach($featuredUsersToDeleteArray as $featuredUserId){
		$db->query("UPDATE `tblUsers` SET `featured` = 'N' WHERE `id`  = '".$featuredUserId."'");
	}
}



?>