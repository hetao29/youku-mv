<?php
/**
 * 用户歌单管理
 */
class user_list{
	function __construct(){
	}
	function pageAdd($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['ListName'])){
				$ListName=strip_tags($_REQUEST['ListName']);
				if(empty($ListName))return false;
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
	function pageEmpty($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['ListID'])){
				$db = new user_db;
				if(($List=$db->getList($_REQUEST['ListID']))!==false){
						if($List['UserID']==$User['UserID']){
								return $db->emptyList($List['ListID']);
						}
				};
		}
		return false;
	}
	function pageEdit($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['ListID']) && !empty($_REQUEST['ListName'])){
				$ListName = strip_tags($_REQUEST['ListName']);
				if(empty($ListName))return false;
				$db = new user_db;
				if(($List=$db->getList($_REQUEST['ListID']))!==false){
						if($List['UserID']==$User['UserID']){
								$List=array("ListName"=>$ListName);
								return $db->editList($_REQUEST['ListID'],$List);
						}
				};
		}
		return false;
	}
	function pageContents($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lids']) && !empty($_REQUEST['vids'])){
				$realLids=array();
				if(is_numeric($_REQUEST['lids'])){
						$realLids[]=$_REQUEST['lids'];
				}elseif(is_array($_REQUEST['lids'])){
						$realLids=$_REQUEST['lids'];
				}

				$realVids=array();
				if(is_numeric($_REQUEST['vids'])){
						$realVids[]=$_REQUEST['vids'];
				}elseif(is_array($_REQUEST['vids'])){
						$realVids=$_REQUEST['vids'];
				}
				$api = new player_api;
				$db = new user_db;
				$mvs=array();
				foreach($realVids as $vid){
					$mv=$api->getMvByVid($vid);
					if(!empty($mv)){
						$mvs[]=$mv;
					}
				}
				$lists=array();
				foreach($realLids as $lid){
					$list=$db->getList($lid);
					if(!empty($list) && $list['UserID']==$User['UserID']){
						$lists[]=$list;
					}
				}
				if(!empty($lists) && !empty($mvs)){
					foreach($lists as $list){
							foreach($mvs as $mv){
									$db->addListContent($list["ListID"],$mv['MvID']);
							}
					}
					return true;
				}
		}
		return false;
	}
}
?>
