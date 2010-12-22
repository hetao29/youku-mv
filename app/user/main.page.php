<?php
class user_main{
	function __construct(){
	}
	function pageEntry($inPath){
		echo "User";
	}
	///user.main.logout
	function pageLogout($inPath){
			user_api::logout();
			header("location:/player.main.header");
	}
	function pageisLogin($inPath){
			return user_api::islogin();
	}
	/**
	 * 自动登录
	 */
	function pageAutoLogin($inPath){
			$token = $_REQUEST['token'];
			$uid = $_REQUEST['uid'];
			$db = new user_db;
			$UserToken = $db->getUserToken($uid,$token);
			if(!empty($UserToken['UserID']) && $UserToken['UserTokenExpiredTime']>time()){
					$UserID = $UserToken['UserID'];
					$User = $db->getUserByID($UserID);
					return user_api::login($User,true);
			}
			return false;
	}
	///user.main.login
	function pageLogin($inPath){
			$useremail= $_REQUEST['useremail'];
			$password = $_REQUEST['password'];
			$db = new user_db;
			$user = $db->getUserByEmail($useremail);
			$o  = new stdclass;
			if(!empty($user) && $user['UserPassword']==$password){
					user_api::login($user,!empty($_REQUEST['forever']));
					$o->result=1;
			}else{
					$o->result=-1;
			}
			return $o;
	}
	function pageSignup($inPath){
			$result = new stdclass;
			if(empty($_REQUEST['useremail'])){
					$result->info = "你的邮箱地址不能为空";
					return $result;
			}
			if(!SUtil::validEmail($_REQUEST['useremail'])){
					$result->info = "你的邮箱地址错误";
					return $result;
			}
			if(empty($_REQUEST['password']) || empty($_REQUEST['password2'])){
					$result->info = "你的密码不能为空";
					return $result;
			}
			if($_REQUEST['password'] != $_REQUEST['password2']){
					$result->info = "你的2次密码不相同";
					return $result;
			}
			$User = array();
			$User['UserAlias']=$_REQUEST['useralias'];
			$User['UserEmail']=$_REQUEST['useremail'];
			$User['UserPassword']=$_REQUEST['password'];
			$db = new user_db;
			$UserID = $db->addUser($User);
			if($UserID>0){
					//注册成功
					$result->uid=$UserID;
					//自动登录
					$User['UserID']=$UserID;
					user_api::login($User);
			}else{
					$result->info="你的邮箱已经被注册";
			}
			return $result;
	}

}
?>
