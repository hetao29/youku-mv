<?php
class user_api{
		static public function login($User){
			$_SESSION['user']=$User;
			setcookie("uid",$User['UserID']);
		}
		static public function  islogin(){
			return isset($_SESSION['user']);
		}
		static public function logout(){
			unset($_SESSION['user']);
			setcookie("uid",0,time()-3600);
		}
}
