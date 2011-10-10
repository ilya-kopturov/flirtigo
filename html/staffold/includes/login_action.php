<?
session_set_cookie_params(0);
session_start();
//require connect to database file
require("cnn.php");
//login
if(!empty($_GET["action"]) && str_replace('"','',str_replace("'","",htmlspecialchars($_GET["action"])))=="login"){
	//getting user and password
	$user_post=str_replace('"','',str_replace("'","",htmlspecialchars($_POST["username"])));
	$pass_post=str_replace('"','',str_replace("'","",htmlspecialchars($_POST["pass"])));
	//verifying the user and password
	if(!empty($user_post) && !empty($pass_post) && $user_post!='' && $pass_post!=''){
		//getting user list and passwords from database
		$qry="select * from tblAdmin order by id";
		$qry=mysql_query($qry);
		$nr_qry=mysql_num_rows($qry);
		for($i=0; $i<$nr_qry;$i++){
			$theuser=mysql_fetch_array($qry);
			$user_db=htmlspecialchars(stripslashes($theuser["user"]));
			$pass_db=htmlspecialchars(stripslashes($theuser["pass"]));
			if($user_db==$user_post && $pass_db==$pass_post){
				$i=$nr_qry;
				$validaccount=true; // value is true if valid account found
			}
		}
		if($validaccount){
			//verifying if account is valid
			$qry="select * from `tblAdmin` where `user`='".$user_post."' and `pass`='".$pass_post."'";
			$qry=mysql_query($qry);
			$qry=mysql_fetch_array($qry);
			// if is main account then skip verifying
			if($qry["main"]!=1){
			//if not main then verify if valid
				if($qry["activ"]!=1){
					//if acoount not active, redirect
					$msg="Account is not activ! Please contact the site admin!";
					echo("<script>document.location.href='../index.php?msg=".$msg."'</script>");
					exit();
				}
			}
			$_SESSION['admin']         = $qry["id"];
			$_SESSION['p_admin']       = "bla";
			$_SESSION['sid']           = session_id();
			$_SESSION['is4chat']       = $qry['chat'];
			$_SESSION['isforchat']     = $qry['isforchat'];
			$_SESSION['isforapproval'] = $qry['isforapproval'];
			$_SESSION['isforpicture']  = $qry['isforpicture'];
			$_SESSION['isforvideo']    = $qry['isforvideo'];
    		
			echo("<script>document.location.href='../index.php?content=intro'</script>");
		}else{
			//if none valid account, redirect
			$msg="Invalid username or password!";
			echo "<script>document.location.href='../index.php?msg=".$msg."'</script>";
			exit();
		}
	}else{
		//if user or password empty, redirect
		$msg="Unknown error! Please try again!";
		//echo $msg;
		//echo $user_post;
		//echo $pass_post;
		echo("<script>document.location.href='../index.php?msg=".$msg."'</script>");
	}
}
//logout
if(!empty($_GET["action"]) && $_GET['action'] == "logout"){
	    $_SESSION = array();
		session_unset($_SESSION);
		session_destroy();
		echo("<script>document.location.href='../index.php'</script>");	
}
?>