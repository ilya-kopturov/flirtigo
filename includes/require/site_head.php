<?php
/* $Id: site_head.php 572 2008-06-19 08:00:20Z bogdan $ */

ob_start();
//'ob_gzhandler');

session_start();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past



if (!defined('IN_MAINSITE')) die("Critical Error!");

//error_reporting(E_ALL & ~E_NOTICE);
//set_magic_quotes_runtime(0);
//ini_set("magic_quotes_gpc", '0');

//ini_set('display_errors', 1);
//error_reporting(E_ALL);


include_once realpath(dirname(__FILE__) . '/../config') . '/common.php';		// fphp



include_once(PATH_INCLUDES . 'Zend/Loader.php');
spl_autoload_register('Zend_Loader::autoload');

include_once(PATH_INCLUDES . "config/crypt.php");
include_once(PATH_INCLUDES . "config/db.php");
include_once(PATH_INCLUDES . "config/path.php");
include_once(PATH_INCLUDES . "config/mail.php");
//override server settings
@include_once(PATH_INCLUDES . 'config/local.conf.php');

//it's time to check if ajax scripts are called correctly
if (IS_AJAX && !IS_ADMIN && stristr(php_sapi_name(), 'apache')) {
	$apache_headers = array_change_key_case(apache_request_headers(), CASE_LOWER);
	if (strtolower($apache_headers['x-requested-with']) != 'xmlhttprequest') {
		die('<script>setTimeout(function(){window.location.href="' . $cfg['path']['url_site'] . '"}, 1500)</script><span style="display:inline-block;vertical-align:middle;">&nbsp;Browser Error! <a href="http://www.matchbill.com" target="_blank">Please Contact Support</a> and tell us what you did in order to receive the error.</span>');
	}
}

include_once(PATH_INCLUDES . "config/image.php");
include_once(PATH_INCLUDES . "config/video.php");
include_once(PATH_INCLUDES . "config/option.php");
include_once(PATH_INCLUDES . "config/profile.php");
include_once(PATH_INCLUDES . "config/template.php");
include_once(PATH_INCLUDES . "config/countries.php");
include_once(PATH_INCLUDES . "config/facebook.php");

include_once(PATH_INCLUDES . "function/general.php");
include_once(PATH_INCLUDES . "function/image.php");
include_once(PATH_INCLUDES . "function/video.php");
include_once(PATH_INCLUDES . "function/login.php");
include_once(PATH_INCLUDES . "function/smarty.php");
include_once(PATH_INCLUDES . "function/profile.php");
include_once(PATH_INCLUDES . "function/mailer.php");
include_once(PATH_INCLUDES . "function/member.php");
include_once(PATH_INCLUDES . "function/search.php");
include_once(PATH_INCLUDES . "function/facebook_func.php");

include_once(PATH_INCLUDES . "class/image.php");
include_once(PATH_INCLUDES . "class/db.php");
include_once(PATH_INCLUDES . "class/join.php");
//include_once(PATH_INCLUDES . "class/xmlrpc.php");
include_once(PATH_INCLUDES . "class/phpmailer.php");
include_once(PATH_INCLUDES . "smarty/Smarty.class.php");

class DFSmarty extends Smarty {
	public function __construct() {
		global $cfg;

		parent::Smarty();
		$this->template_dir = PATH_TEMPLATES;
		$this->compile_dir = PATH_ROOT . "templates_c";
		$this->force_compile = false;
		$this->debugging = false;
		$this->compile_check = true;
		//$this->error_reporting = E_ALL & ~E_NOTICE;
		$this->use_sub_dirs = true;
	}
}

$smarty = new DFSmarty();
$smarty->register_function('rnd_md5', 'smarty_rnd_md5');
$smarty->register_function('screenname', 'smarty_screenname');
$smarty->assign("cfg", $cfg);
$smarty->assign('site_section', $site_section = ($_SESSION['sess_id'] ? 'login' : 'public'));

if (isset($_GET['error'])) $smarty->assign("error", htmlspecialchars(strip_tags($_GET['error'])));
if (isset($_GET['msg'])) $smarty->assign("msg",   htmlspecialchars(strip_tags($_GET['msg'])));

$db = &DFDB::factory("mysql://{$cfg['db']['user']}:{$cfg['db']['password']}@{$cfg['db']['host']}/{$cfg['db']['db']}");
if (MDB2::isError($db)) {
	$smarty->display(PATH_TEMPLATES . "site/dirtyflirting/{$site_section}/header.tpl");
	$smarty->display(PATH_TEMPLATES . "site/dirtyflirting/public/sqlerror.tpl" );
	$smarty->display(PATH_TEMPLATES . "site/dirtyflirting/{$site_section}/footer.tpl" );
	exit;
}

if (!(IS_AJAX === true) && $_SESSION['sess_id']) $_SESSION["sess_newmails"] = number_format($db->get_var("SELECT COUNT(*) FROM tblMails WHERE user_id = '{$_SESSION['sess_id']}' AND (`folder` = '1' OR `folder` = '5') AND new = 'Y'"), 0, '', '');

//Access Control List
include_once(PATH_INCLUDES . "class/liveuser.php" );

/**
 * UK IP
 */
//$_SERVER['REMOTE_ADDR'] = '84.13.175.153';

/* Get Region & Country */
$userArea = ip2area($_SERVER['REMOTE_ADDR']);
$smarty->assign("userArea", $userArea);
