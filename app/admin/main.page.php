<?php
class admin_main extends SGui{
	function __construct(){
		if(($User=user_api::islogin())===false){
				//登录
				$param['error']=1;
				die($this->render("admin/error.tpl",$param));
		}
		if($User['UserType']!=1){
				//你不是管理员
				$param['error']=2;
				die($this->render("admin/error.tpl",$param));
		}

	}
	function __destruct(){
	}
	function pageEntry($inPath){
		echo $this->render("admin/main.tpl",$param);
	}
}
