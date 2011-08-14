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
					$result|=$db->updateListContentsOrder($ListID,singer_music::decode($order['vid']),$order['order']);
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
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lids']) && !empty($_REQUEST['vids'])){
				$realLids=array();
				if(is_numeric($_REQUEST['lids'])){
						$realLids[]=$_REQUEST['lids'];
				}elseif(is_array($_REQUEST['lids'])){
						$realLids=$_REQUEST['lids'];
				}

				$realMvids=array();
				if(is_numeric($_REQUEST['vids'])){
						$realMvids[]=$_REQUEST['vids'];
				}elseif(is_array($_REQUEST['vids'])){
						$realMvids=$_REQUEST['vids'];
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
							foreach($realMvids as $vid){
									$result = $db->addListContent($list["ListID"],singer_music::decode($vid),$i);
									$i++;
							}
					}
				}
		}
		return $result;
	}
	function pageDelContent($inPath){
		$result=false;
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['lid']) && !empty($_REQUEST['vid'])){
				$UserID=$User['UserID'];
				$ListID=$_REQUEST['lid'];
				$VideoID=singer_music::decode($_REQUEST['vid']);
				$db = new user_db;
				$List = $db->getList($ListID);
				if(empty($List) || $List['UserID']!=$UserID)return false;
				$result=$db->delListContent($ListID,$VideoID);
		}
		return $result;
	}
	function pageListContents($inPath){
		if(!empty($_REQUEST['lid'])){
				$db = new user_db;
				$video_api = new video_api;
				$List = $db->getList($_REQUEST['lid']);
				if(!empty($List)){
						$r = $db->listContent($List['ListID']);
						if(!empty($r->items)){
								foreach($r->items as &$item){
										$item = array_merge($item,$video_api->getVideoInfo($item['VideoID']));
								}
						}
						return $r;
				}
		}
	}
}
?>
