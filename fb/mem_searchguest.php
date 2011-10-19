<?php
/* DIRTYFLIRTING.COM                                                                         
                                                                                           
                                                                                           
                                                                                         */

define("IN_MAINSITE", TRUE);


include ("./includes/" . "require" . "/" . "site_head.php");

check_session($db, $_SESSION['sess_pass'], $_SESSION['sess_screenname'], 1);
/* ... sql ... */


/* ..end sql.. */

/* ... functions ... */
$featured      = mem_featuredPopular("small");
$stats         = stats($db);
/* ..end functions.. */

/* ... assign ... */
$smarty->assign("stats", $stats);
$smarty->assign("featured", $featured);

$smarty->assign("countries", $cfg['countries']);
$smarty->assign("states",    $cfg['states']);
// ... end assign ... //

// ...  smarty ... //
$smarty->register_function('age', 'smarty_age');

$smarty->display( $cfg['template']['dir_template'] . "login/" . "header.tpl" );
$smarty->display( $cfg['template']['dir_template'] . "login/" . "searchguest.tpl" );
$smarty->display( $cfg['template']['dir_template'] . "login/" . "footer.tpl" );

$smarty->unregister_function('age');
// ...end smarty...//

include ("./includes/" . "require" . "/" . "site_foot.php");
?>