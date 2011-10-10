<?php

define("IN_MAINSITE", true);
define("IS_AJAX", true);

include('../includes/require/site_head.php');

if (!empty($_SESSION['admin'])) {
	$id = (int)$_GET['id'];
	$attachment = $db->get_row("SELECT ma.* FROM tblMailAttachments ma INNER JOIN tblMails m ON ma.email_id = m.id WHERE ma.id = '$id' LIMIT 1");

	$width = $attachment['type'] == 'video' ? 330 : 650;
} else {
	die;
}

?>
<div style="width: <?= $width ?>px;">
	<div class="redtitle"></div>
	<div style="float:right;">
		<a href="javascript:;" onclick="$('#attachment_popup').jqmHide().remove()" title="Close">
			<img src="/js/jqm_close.gif" border="0">
		</a>
	</div>
	<div class="clear" style="clear:both"><img src="/images/pixel.gif" height="5"></div>
	<div style="width: <?= $width - 10 ?>px;">
		<?php if ($attachment['type'] == 'video') { ?>
			<div class="videoplayer">
				<embed
				src="/mediaplayer.swf"
				width="320"
				height="260"
				allowscriptaccess="always"
				allowfullscreen="true"
				flashvars="height=260&width=320&file=<?= $cfg['path']['url_attachments'] . $attachment['file'] ?>&autostart=true&searchbar=false"
				/>
			</div>
		<?php } else { ?>
			<img style="border:1px solid black" src="attachment.php?<?= md5(microtime()) ?>&id=<?= $attachment['id'] ?>" width="640">
		<?php } ?>
	</div>
</div>