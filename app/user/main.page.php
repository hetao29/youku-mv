<?php
class user_main{
	function __construct(){
	}
	function pageKeepAlive($inPath){
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
			$logined = false;
			$UserToken = $db->getUserToken($uid,$token);
			if(!empty($UserToken['UserID']) && $UserToken['UserTokenExpiredTime']>time()){
					$UserID = $UserToken['UserID'];
					$User = $db->getUserByID($UserID);
					$logined = user_api::login($User,true);
			}
			return true;
	}
	///user.main.login
	function pageLogin($inPath){
			$useremail= $_REQUEST['useremail'];
			$password = $_REQUEST['password'];
			$db = new user_db;
			if(SUtil::validEmail($useremail)){
				$user = $db->getUserByEmail($useremail);
			}else{
				$user = $db->getUser($useremail);
			}
			$o  = new stdclass;
			if(!empty($user) && $user['UserPassword']==$password){
					user_api::login($user,!empty($_REQUEST['forever']));
					$o->result=1;
			}else{
					//尝试和优酷用户登录
					$r = SHttp::post("http://www.youku.com/index_login/",array("username"=>$useremail,"password"=>$password,"forever=0"));
					if($r==1){
							//在优酷登录成功
							$user = $db->getUserByEmail($useremail,$paterid=1);
							if(empty($user)){
								//增加用户
								$User = array();
								$User['UserAlias']=$useremail;
								$User['UserEmail']=$useremail;
								$User['UserPassword']=$password;
								$User['ParterID']="1";
								$UserID = $db->addUser($User);
								$user=$db->getUserByID($UserID);
							}else{
								//更新用户
								$user['UserPassword']=$password;
								$db->updateUser($user);
							}
							//更新s_user
							$o->result=1;
							user_api::login($user,!empty($_REQUEST['forever']));
					}else{
						$o->result=-1;
					}
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
