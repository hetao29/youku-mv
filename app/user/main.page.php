<?php
//error_log(var_export($_REQUEST,true),3,"/tmp/xx.log");
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
	function pageLogoutV3($inPath){
			user_api::logout();
			header("location:/player.main.headerV3");
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
			$ParterID=0;
			if(!empty($_REQUEST['ParterID'])){
				$ParterID=$_REQUEST['ParterID'];
			}
			$db = new user_db;
			$user = $db->getUserByEmail($useremail,$ParterID);
			//error_log(var_export($user,true),3,"/tmp/xx.log");
			//error_log("\n".user_api::pwd($password)."\n",3,"/tmp/xx.log");
			$o  = new stdclass;
			if(!empty($user) && $user['UserPassword']==user_api::pwd($password)){
					user_api::login($user,!empty($_REQUEST['forever']));
					$o->result=1;
			}else{
					//尝试和优酷用户登录
					$r = SHttp::post("http://open.youku.com/developer/login?submit=1",array("name"=>$useremail,"password"=>$password,"forever=0"));
					if(stripos($r,"login_success")){
					//if($r==1){
							//在优酷登录成功
							$user = $db->getUserByEmail($useremail,$paterid=user_parter::YOUKU);
							//error_log(var_export($user,true),3,"/tmp/log.log");
							if(empty($user)){
								//增加用户
								$User = array();
								$User['UserAlias']=$useremail;
								$User['UserEmail']=$useremail;
								$User['UserPassword']=user_api::pwd($password);
								$User['ParterID']=user_parter::YOUKU;
								$UserID = $db->addUser($User);
								$user=$db->getUserByID($UserID);
							}else{
								//更新用户
								$user['UserPassword']=user_api::pwd($password);
								$db->updateUser($user);
							}
							//更新s_user
							$o->result=1;
							user_api::login($user,!empty($_REQUEST['forever']));
					}else{
						$o->result=-1;
					}
			}
			//error_log(var_export($o,true),3,"/tmp/xx.log");
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
			$User['UserPassword']=user_api::pwd($_REQUEST['password']);
			if(!empty($_REQUEST['ParterID'])){
				$User['ParterID'] = $_REQUEST['ParterID'];
			}
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
