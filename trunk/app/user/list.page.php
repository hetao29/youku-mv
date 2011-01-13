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
	//保存列表顺序
	function pageOrder($inPath){
		$result=false;
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['order'])){
				$UserID=$User['UserID'];
				$db = new user_db;
				foreach($_REQUEST['order'] as $order){
					$result|=$db->updateListOrder($UserID,$order['lid'],$order['order']);
				}
		}
		return $result;
	}
	//保存列表内容顺序
	function pageContentsOrder($inPath){
		$result=false;
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['order']) && !empty($_REQUEST['lid'])){
				$UserID=$User['UserID'];
				$ListID=$_REQUEST['lid'];
				$db = new user_db;
				$List = $db->getList($_REQUEST['lid']);
				if(empty($List) || $List['UserID']!=$UserID)return false;
				foreach($_REQUEST['order'] as $order){
					$result|=$db->updateListContentsOrder($ListID,$order['mvid'],$order['order']);
				}
		}
		return $result;
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
		$result=false;
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
				$lists=array();
				foreach($realLids as $lid){
					$list=$db->getList($lid);
					if(!empty($list) && $list['UserID']==$User['UserID']){
						$lists[]=$list;
					}
				}
				if(!empty($lists) && !empty($realMvids)){
					foreach($lists as $list){
							$i=0;
							foreach($realMvids as $mvid){
									$result = $db->addListContent($list["ListID"],$mvid,$i);
									$i++;
							}
					}
				}
		}
		return $result;
	}
	function pageDelContent($inPath){
		$result=false;
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lid']) && !empty($_REQUEST['mvid'])){
				$UserID=$User['UserID'];
				$ListID=$_REQUEST['lid'];
				$MvID=$_REQUEST['mvid'];
				$db = new user_db;
				$List = $db->getList($ListID);
				if(empty($List) || $List['UserID']!=$UserID)return false;
				$result=$db->delListContent($ListID,$MvID);
		}
		return $result;
	}
	function pageListContents($inPath){
		if(!empty($_REQUEST['lid'])){
				$db = new user_db;
				$List = $db->getList($_REQUEST['lid']);
				if(!empty($List)){
						return $db->listContent($List['ListID']);
				}
		}
	}
}
?>
