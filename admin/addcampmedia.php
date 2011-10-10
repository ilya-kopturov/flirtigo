<?php

define("IN_MAINSITE", TRUE);


include('../includes/require/site_head.php');

include('System/Command.php');

$uid = $_SESSION['sess_id'];
if (strcmp($_GET['u'], 't') == 0) {
	$fileInfo = base64_decode(urldecode($_POST["hidFileID"]));
	list($tmpFile, $origFile, $mime) = explode('<=>', $fileInfo);
	$attachments = array();
	$attachment['type'] = $_POST["type"];
	$attachment['tmp'] = $tmpFile;
	$attachment['orig'] = $origFile;
	$attachment['mime'] = $mime;

	if (strcasecmp($attachment['type'], 'video') == 0) {
		set_time_limit(0);
		$input = "{$cfg['path']['dir_upload']}$tmpFile";
		$tmpOutput = md5(SECRET . microtime() . SECRET);
		$output = "{$cfg['path']['dir_upload']}$tmpOutput";
		$cmd = new System_Command();
		$cmd->pushCommand($cfg['path']['cmd_mencoder'], $input, "-o $output", '-of lavf', '-oac mp3lame', '-lameopts abr:br=56', '-ovc lavc', '-lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3', '-lavfopts format=flv', '-vf scale=320:260', '-srate 22050');
		$cmd->pushOperator('AND');
		$cmd->pushCommand($cfg['path']['cmd_mplayer'], $input, '-ss 1', '-nosound', "-vo jpeg:outdir={$cfg['path']['dir_upload']}/", '-frames 1');
		if (System_Command::isError($result = $cmd->execute())) {
			$attachment = null;
			@unlink($output);
			@unlink("{$cfg['path']['dir_upload']}00000001.jpg");
		} else {
			@rename("{$cfg['path']['dir_upload']}00000001.jpg", "{$cfg['path']['dir_upload']}{$tmpOutput}_thumb.jpg");
			$attachment['tmp'] = $tmpOutput;
			$attachment['mime'] = 'video/x-flv';
		}
		@unlink($input);
	}

	$error = null;
	if ($attachment) {
		$_SESSION['mail_attachments'][$_GET['e']][] = $attachment;
	} else {
		$error = $result->getMessage();
	}
	
	if(!$error){
		foreach($_SESSION['mail_attachments'][$_GET['e']] as $key => $attach){
			$txt .= '<div>';
			if($attach['type'] == "picture") {
				$txt .= '<img style="display:inline;vertical-align:middle;" width="16" src="'.$cfg['path']['url_site'].'templates/site/dirtyflirting/login/images/dirtyflirting_mailpicture.gif" />';	
			}else{
				$txt .= '<img style="display:inline;vertical-align:middle;" width="16" src="'.$cfg['path']['url_site'].'templates/site/dirtyflirting/login/images/dirtyflirting_mailvideo.gif" />';
			}
			$txt .= '<span style="display:inline;vertical-align:middle;">'.$attach['orig'].'</span>';
			$txt .= '&nbsp;<a id="at' . $attach['tmp'] . '" style="display:inline;vertical-align:middle;color:red;" href="javascript:deleteAttachment(\\\'' . $attach['tmp'] . '\\\')" title="Delete ' . $attach['orig'] . '">[x]</a>';			
			$txt .= '</div>';
		}
		
		if(!$txt){
			$txt = '<div>No attachments</div>';
		}
	}
		
	print <<< EOF
if ('$error' != '') {
	alert('Failed to encode your video.');
} else {
	opener.document.getElementById("messageinterntype").innerHTML = '{$txt}';
	window.close();
}
EOF;
	exit;
}
$type = (empty($_GET['t']) || !(in_array($_GET['t'], array('picture', 'video')))) ? 'picture' : $_GET['t'];

$smarty->assign('type', $type);
$smarty->display("{$cfg['template']['dir_template']}ajax/admin_upload_popup.tpl");
?>