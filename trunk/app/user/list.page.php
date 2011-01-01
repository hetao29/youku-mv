<?php
/**
 * 用户歌单管理
 */
class user_list{
	function __construct(){
	}
	function pageAdd($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['ListName'])){
				$ListName=$_REQUEST['ListName'];
				$List=array("UserID"=>$User['UserID'],"ListName"=>$ListName,"ListCreateTime=now()");
				$db = new user_db;
				if(($ListID = $db->addList($List))!==false){
					return $db->getList($ListID);
				};
		}
		return false;
	}
	function pageList($inPath){
		if(($User=user_api::islogin())!==false){
				$db = new user_db;
				if(($Lists = $db->ListList($User['UserID']))!==false){
						return $Lists;
				};
		}
		return false;
	}
	function pageDel($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['ListID'])){
				$db = new user_db;
				if(($List=$db->getList($_REQUEST['ListID']))!==false){
						if($List['UserID']==$User['UserID']){
								return $db->delList($List['ListID']);
						}
				};
		}
		return false;
	}
	function pageEdit($inPath){
	}
}
?>
