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
	function pageAddContents($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lids']) && !empty($_REQUEST['mvids'])){
				$realLids=array();
				if(is_numeric($_REQUEST['lids'])){
						$realLids[]=$_REQUEST['lids'];
				}elseif(is_array($_REQUEST['lids'])){
						$realLids=$_REQUEST['lids'];
				}

				$realMvids=array();
				if(is_numeric($_REQUEST['mvids'])){
						$realMvids[]=$_REQUEST['mvids'];
				}elseif(is_array($_REQUEST['mvids'])){
						$realMvids=$_REQUEST['mvids'];
				}
				$api = new player_api;
				$db = new user_db;
				//$mvs=array();
				//foreach($realVids as $vid){
				//	$mv=$api->getMvByVid($vid);
				//	if(!empty($mv)){
				//		$mvs[]=$mv;
				//	}
				//}
				$lists=array();
				foreach($realLids as $lid){
					$list=$db->getList($lid);
					if(!empty($list) && $list['UserID']==$User['UserID']){
						$lists[]=$list;
					}
				}
				if(!empty($lists) && !empty($realMvids)){
					foreach($lists as $list){
							foreach($realMvids as $mvid){
									$db->addListContent($list["ListID"],$mvid);
							}
					}
					return true;
				}
		}
		return false;
	}
	function pageListContents($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lid'])){
				$db = new user_db;
				$List = $db->getList($_REQUEST['lid']);
				if(!empty($List)){
						return $db->listContent($List['ListID']);
				}
		}
		return false;
	}
}
?>
