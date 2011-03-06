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
		$page=empty($inPath[3])?1:$inPath[3];
		$db = new user_db;
		$param['lists']= $db->ListAllList($page,$limit=100);
		echo $this->render("admin/main.tpl",$param);
	}
	function PagegetList($inPath){
		$ListID=empty($inPath[3])?1:$inPath[3];
		$db = new user_db;
		return $db->getList($ListID);
	}
	function PageEdit($inPath){
		$db = new user_db;
		$ListID=!empty($_REQUEST['ListID'])?$_REQUEST['ListID']:0;
		$ListType=!empty($_REQUEST['ListType'])?$_REQUEST['ListType']:0;
		$ListOrder=!empty($_REQUEST['ListOrder'])?$_REQUEST['ListOrder']:0;
		if(empty($ListID))return false;
		return $db->editList($ListID,array("ListType"=>$ListType,"ListOrder"=>$ListOrder));
	}
}
