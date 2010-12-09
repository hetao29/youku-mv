<?php
class user_main{
	function __construct(){
	}
	function pageEntry($inPath){
		echo "User";
	}
	///user.main.logout
	function pageLogout($inPath){
			unset($_SESSION['user']);
			header("location:/player.main.header");
	}
	///user.main.login
	function pageLogin($inPath){
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
			$db = new user_db;
			$user = $db->getUser($username);
			$o  = new stdclass;
			if(!empty($user) && $user['UserPassword']==$password){
					$_SESSION['user']=$user;
					$o->result=1;
			}else{
					$o->result=-1;
			}
			return $o;
	}

}
?>
