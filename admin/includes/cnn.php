<? //db details
define("IS_ADMIN", true);

//session_start();
//ini_set('error_reporting', E_NONE);

//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL &  ~E_DEPRECATED & ~E_NOTICE);
//set_magic_quotes_runtime(0);
ini_set("magic_quotes_runtime", 0);
ini_set("magic_quotes_gpc", '0');
ini_set("display_errors", 1);

#ini_set('error_reporting', E_STRICT);
define("DBHOST", '127.0.0.1');
define("DBNAME", 'flirtigo');
define("DBUSER", 'root');
define("DBPASS", 'admin');//A9lqus2elKys

define('ConstPropertyImageBig','300');
define('ConstImageQuality','80');
//client name
define("CLIENT", '');
define("SITEEMAIL", '');
define("ADMINEMAIL", '');
define("SITE_URL", 'http://74.52.129.47/');
$SITEURL="http://74.52.129.47/";
//web site
//page body settings
	$PSettings="margin-left:10px; margin-bottom:10px; margin-right:10px; margin-top:10px;";
	$PSettingsTab="margin-left:40px; margin-bottom:10px; margin-right:10px; margin-top:10px;";
	$PSettingsTab2="margin-left:60px; margin-bottom:10px; margin-right:10px; margin-top:10px;";
//page body settings
//page start title
	$PStartTitle="Proven Web Wealth - ";
//page start title
//page header and footer
	$PSHeader="inc_header.php";
	$PSFooter="inc_footer.php";
//page header and footer
//define table borders
$td_border_b="
border-bottom-color:#CBE052; border-bottom-width:1px; border-bottom-style:solid;
border-top-color:#CBE052; border-top-width:1px; border-top-style:solid;
border-left-color:#CBE052; border-left-width:1px; border-left-style:solid;
border-right-color:#CBE052; border-right-width:1px; border-right-style:solid;
padding-left:0; padding-right:0";
$td_brder_t="
border-bottom-color:#CBE052; border-bottom-width:1px; border-bottom-style:solid;
border-top-color:#CBE052; border-top-width:0px; border-top-style:solid;
border-left-color:#CBE052; border-left-width:1px; border-left-style:solid;
border-right-color:#CBE052; border-right-width:1px; border-right-style:solid;
padding-left:0; padding-right:0";
$td_brder_lt="border-bottom-color:#CBE052; border-bottom-width:1px; border-bottom-style:solid;
border-top-color:#CBE052; border-top-width:0px; border-top-style:solid;
border-left-color:#CBE052; border-left-width:0px; border-left-style:solid;
border-right-color:#CBE052; border-right-width:1px; border-right-style:solid;
padding-left:0; padding-right:0";
$td_brder_full="border-bottom-color:#CBE052; border-bottom-width:1px; border-bottom-style:solid;
border-top-color:#CBE052; border-top-width:1px; border-top-style:solid;
border-left-color:#CBE052; border-left-width:1px; border-left-style:solid;
border-right-color:#CBE052; border-right-width:1px; border-right-style:solid;
padding-left:0; padding-right:0";
$table_options="WIDTH=\"98%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"4\" align=\"center\"";
$table_o="WIDTH=\"98%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"4\" align=\"center\" bgcolor=\"#000000\"";
$tr_o="bgcolor=\"#FFFFFF\"";
$table_e="WIDTH=\"98%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"4\" align=\"center\" bgcolor=\"#FFECEC\"";
//define table borders
include("functions.php");
//connect to databas
connect_db();
?>
