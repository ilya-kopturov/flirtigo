<?
set_time_limit(0);

include("includes/cnn.php");

$i = 1;

$sql = mysql_query("SELECT * FROM `tblUsers` WHERE `typeusr` = 'Y' ORDER BY rand() LIMIT 1000");

while($obj = mysql_fetch_object($sql)){
	
	$obj_user = mysql_fetch_object(mysql_query("SELECT * FROM `tblUsers` WHERE `typeusr` = 'N' ORDER BY rand() LIMIT 1"));
	
	$subject = "Hello " . $obj->id . " " . $i;
	$message = "Hello " . $obj->id . " " . $i;
	
	mysql_query("INSERT INTO `tblTypeMails` (`user_id`,`user_from`,`user_to`,`subject`,`message`,`date_sent`) 
	             VALUES ('".$obj->id."','".$obj_user->id."','".$obj->id."','".$subject."','".$message."',NOW())");
	
	$i++;
}
?>