<?
require("includes/cnn.php");

$arr = mysql_query("SELECT `id` FROM `tblTypeMails` 
	                            WHERE `user_from` = '". $_GET['user_to'] ."' AND 
									  `user_to` = '". $_GET['user_from'] ."' AND 
									  `operator_id` != '0' AND 
									  `folder` = '2'");

$count = mysql_num_rows($arr);

if(!$count){
	readfile("images/greensquare.gif");
}/* else {
	readfile("images/redsquare.gif");
}*/
?>