<?php

define("IN_MAINSITE", TRUE);

include ("./includes/" . "require" . "/" . "site_head.php");

/* search FB login in DB */
if(!$fb_user_id) {
	// here user Not logged in via FB. redirect to home
	header("Location: " . $cfg['path']['url_site']);
}
// get FB data
$fb_data = @$db->query("
	SELECT 
		fb_id
	FROM tblFBData
	WHERE fb_id = '".$fb_user_id."';
");
if($fb_data) {
	$row = $fb_data->fetchRow();
}
if(is_array($row)) {
	// this FB id is exist. Redirect to standard login page
	header("Location: " . $cfg['path']['url_site'] . 'login.php');
	// TODO: save log if needed
} else {
	// this FB id is exist - this is first time log in. Add record to db
	$name = $fb_me['name'];
	$first_name = $fb_me['first_name'];
	$last_name = $fb_me['last_name'];
	$link = $fb_me['link'];
	$username = $fb_me['username'];
	$birthday = $fb_me['birthday'];
	$birthday = explode('/',$fb_me['birthday']);
	$birthday = $birthday[2].'-'.$birthday[0].'-'.$birthday[1];
	$location = $fb_me['location']['name'];
	$gender = $fb_me['gender'];
	if($gender == 'male') {
		$sex = 0;
	} else {
		$sex = 1;
	}
	$email = $fb_me['email'];
	$timezone = $fb_me['timezone'];
	$locale = $fb_me['locale'];
	$verified = $fb_me['verified'];
	$updated_time = $fb_me['updated_time'];
	$time_now = date("Y-m-d H:i:s ", time());
	// Create new user
	$sql = "
		INSERT INTO tblUsers(screenname, pass, gallery_pass, email, cell, sex, looking, `for`, rating, votes, introtext, introtitle, `describe`, bodytype, p_bodytype, height, p_height, weight, p_weight, haircolor, p_haircolor, eyecolor, p_eyecolor, ethnicity, p_ethnicity, smoking, p_smoking, drinking, p_drinking, sexualactivities, fantasies, birthdate, p_birthdate, country, `state`, city, zip, hide, withpicture, withvideo, emailstatus, emailnotif, whispernotif, newsletternotif, mailreceived, mailresponded, mailopened, typeusr, typeloc, redirect, mostwanted, approved, approvedby, approveddate, firsttime, disabled, accesslevel, featured, linked, joined, lastlogin, typelogin, lastip, upgraded, downgrade_after, origin, orgaccesslevel, orgolduserid, promcode) 
		VALUES('', '', '', '$email', '', $sex, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, 0, 0, 0, 0, 0, '', '$birthday', '0000-00-00', 0, 0, '', '', 'N', 'N', 'N', 'G', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 0, '0000-00-00', 'N', 'N', '0', 'N', 0, '$time_now', '$time_now', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', '');
	";
	// get user id
	$res = @$db->query($sql);
	$id = $db->lastInsertID('tblUsers', 'id');
	// Add Facebook data
	$res = @$db->query("
		INSERT INTO tblFBData(fb_id, user_id, user_name, first_name, last_name, username, date_of_birth, email, gender, link, location, timezone, verified, locale, created_time, last_update_date)
		VALUES('$fb_user_id', $id, '$name', '$first_name', '$last_name', '$username', '$birthday', '$email', '$gender', '$link', '$location', $timezone, $verified, '$locale', '$time_now', '$updated_time');
	");
	// Redirect to start page
	header("Location: " . $cfg['path']['url_site'] . 'join.php');
}
