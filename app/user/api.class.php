<?php
class user_api{
		static public function login($User,$forever=false){
			if(!empty($User['UserID'])){
				$_SESSION['user']=$User;
				$db = new  user_db;
				$expired=0;
				if($forever){
					$expired=time()+365*3600*24;//一年过期
					$db->addUserToken(array("UserID"=>$User['UserID'],"UserToken"=>session_id()));
				}
				setcookie("token",session_id(),$expired);
				setcookie("uid",$User['UserID'],$expired);
				return true;
			}
			return false;
		}
		static public function  islogin(){
			return isset($_SESSION['user']);
		}
		static public function logout(){
			$db = new  user_db;
			$db->delUserToken($_SESSION['user']['UserID'],session_id());
			unset($_SESSION['user']);
			setcookie("uid",0,time()-3600*24);
			setcookie("token",0,time()-3600*24);
		}
}
