<?php
class user_api{
		static public function login($User,$forever=false){
			if(!empty($User['UserID'])){
				$_SESSION['user']=$User;
				$db = new  user_db;
				if($forever){
					$db->addUserToken(array("UserID"=>$User['UserID'],"UserToken"=>session_id()));
					setcookie("token",session_id(),time()+365*3600*24);//一年过期
				}
				setcookie("uid",$User['UserID'],time()+365*3600*24);
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
			setcookie("uid",0,time()-3600);
			setcookie("token",0,time()-3600);
		}
}
