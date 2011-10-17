<?php

require_once ($cfg['path']['dir_include']."require" . "/" . "Facebook/facebook.php");
$facebook = new Facebook(array(
	'appId'  => $cfg['facebook']['app_id'],
	'secret' => $cfg['facebook']['app_secret'],
	//'cookie' => true,
));
//var_dump($facebook);
$fb_user_id = null;
$fb_auth_url = null;
$fb_me = null;
//$fb_no_join = null;
// Get User ID
$fb_user_id = $facebook->getUser();

if ($fb_user_id) {
	try 
	{
		$fb_me = $facebook->api('/me');
	}
	catch (Exception $e)
	{
		echo "FB exception";
		$fb_user_id = null;
	}
}
if ($fb_user_id) {
	$fb_auth_url = $facebook->getLogoutUrl(
		array(
			'redirect_uri'					=> $cfg['path']['url_site'],
		)
	);
} else {
	$fb_auth_url = $facebook->getLoginUrl(
		array(
			'redirect_uri'			=> $cfg['path']['url_site'] . 'fb_login.php',
			'display'				=>'page',
			'scope'					=>'email,user_birthday,status_update,publish_stream'
		)
	);
}
/* generate logout URL */
if(!$fb_user_id) {
	$logout_url = $cfg['path']['url_site'] . 'mem_logout.php';
} else {
	$logout_url = $facebook->getLogoutUrl(
		array(
			'next'					=> $cfg['path']['url_site'] . 'mem_logout.php',
		)
	);
}
