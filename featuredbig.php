<?php
/* DIRTYFLIRTING.COM */

define("IN_MAINSITE", TRUE);
define("IS_AJAX", true);

include ("./includes/" . "require" . "/" . "site_head.php");

if(!isset($_SESSION['featured_users'])){
$featured = @$db->get_results("SELECT u.`id`, u.`screenname`, u.`country`, u.`city`, u.`typeloc`, u.`typeusr`, 
                                      u.`joined`, u.`birthdate`
                               FROM   `tblUsers` u 
                               WHERE  u.`sex` = '1' AND 
                                      u.`featured` = 'Y' AND
                                      (u.`country` = '".$userArea['id']."' OR 
                                       	(SELECT `area` 
                                         FROM   `ip2nationCountries` 
                                         WHERE  `id` = u.`country` LIMIT 1) = '".$userArea['area']."' )
                               ORDER BY rand() 
                               LIMIT " . (int) $_GET['limit']);
}else{
	foreach ($_SESSION['featured_users'] as $k => $val)
	$featured[$k] = $val;
}

if(isset($_SESSION['sess_id'])){
	$profile_link = $cfg['path']['url_site'] . "profile/";
}else{
	$profile_link = $cfg['path']['url_site'] . "profile/";
}

unset($_SESSION['featured_users']);

for($i=0; $i<count($featured); $i++)
{
	$_SESSION['featured_users'][$i] = $featured[$i];
	$table[$i] = "<table cellspacing=\"1\" cellpadding=\"1\" style=\"border: 0px;\">";
	  $table[$i] .= "<tr>";
	    $table[$i] .= "<td style=\"text-align: center; vertical-align: middle;\">";
	      $table[$i] .= "<a href=\"" . $profile_link . urlencode($featured[$i]['screenname']) . "\"
	                        target=\"_self\">
	                        <img src=\"" . $cfg['path']['url_site'] . "showphoto.php?id=" . $featured[$i]['id'] . "&m=Y&t=s&p=1\" style=\"border: 1px solid #FFFFFF; width: 85px; height: 85px;\" alt=\"" . $featured[$i]['screenname'] . "\" />
	                     </a> ";
	    $table[$i] .= "<td>";

	    $table[$i] .= "<td style=\"text-align: left; vertical-align: middle;\">";
	      $table[$i] .= "<div class=\"featuredBoxText\">";
	        $table[$i] .= "<a href=\"" . $profile_link . urlencode($featured[$i]['screenname']) . "\" target=\"_self\" class=\"featuredBoxLink\">" . $featured[$i]['screenname'] . "</a><br />";
	        $paramsr  = array("id" => $featured[$i]['id'],
	                         "screenname" => $featured[$i]['screenname'],
	                         "rating" => $featured[$i]['rating']);
	        $table[$i] .= smarty_rateme($paramsr) . "<br />";

	        $paramsl  = array("country" => $featured[$i]['country'],"city"    => $featured[$i]['city'],
	                         "typeloc" => $featured[$i]['typeloc'],"type"    => "short");
	        $table[$i] .= smarty_location($paramsl) . "<br />";

	        $views = $db->get_var("SELECT `photo_viewed` FROM `tblPhotos`
	                               WHERE `user_id` = '" . $featured[$i]['id'] . "'
	                               ORDER BY `photo_viewed` DESC LIMIT 1");
	        $table[$i] .= $views . " views" . "<br />";

	        $paramso = array("user_id" => $featured[$i]['id']);
	        $table[$i] .= smarty_online($paramso);

	      $table[$i] .= "</div>";
	    $table[$i] .= "</td>";
	  $table[$i] .= "</tr>";
	$table[$i] .= "</table>";
}

$html  = "<table cellspacing=\"1\" cellpadding=\"1\" style=\"border: 0px;\">";

for($i=0; $i<count($featured); $i+=3)
{
  $html .= "<tr>";
    $html .= "<td>" . $table[$i] . "</td>";
    $html .= "<td>" . $table[$i+1] . "</td>";
    $html .= "<td>" . $table[$i+2] . "</td>";
  $html .= "</tr>";
}

$html .= "</table>";

echo $html;
?>