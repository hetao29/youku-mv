<?php
class user_db{
	private $_dbConfig;
	private $_zone;
	function __construct($zone="user"){
		$this->_zone = $zone;
		$this->_dbConfig = SDb::getConfig($this->_zone);
		$this->_db = SDb::getDbEngine("pdo_mysql");
		$this->_db->init($this->_dbConfig);
	}
	function getUser($UserName){
		return $this->_db->selectOne("s_user",array("UserName"=>$UserName));
	}
	function getUserByEmail($useremail,$parterid=0){
		return $this->_db->selectOne("s_user",array("UserEmail"=>$useremail,"ParterID"=>$parterid));
	}
	function getUserByID($UserId){
		return $this->_db->selectOne("s_user",array("UserID"=>$UserId));
	}
	function delUserToken($UserID,$Token){
		return $this->_db->delete("s_user_token",array("UserToken"=>$Token,"UserID"=>$UserID));
	}
	function getUserToken($UserID,$Token){
		return $this->_db->selectOne("s_user_token",array("UserToken"=>$Token,"UserID"=>$UserID));
	}
	function addUserToken($Token){
		$Token['UserTokenExpiredTime']=time()+3600*24*365;//一年过期
		return $this->_db->insert("s_user_token",$Token,true);
	}
	function addUser($User){
		return $this->_db->insert("s_user",$User);
	}
	function updateUser($User){
		return $this->_db->insert("s_user",$User,true);
	}
	/*视频顶踩
	--ActionType 
	--0 喜欢(up)
	--1 删除(down)
	--2 跳过(skip)
	 */
	function addAction($Action){
		return $this->_db->insert("s_user_action",$Action,true);
	}
	function delAction($UserID,$VideoID,$ActionType=null){
		$condition=array("UserID"=>$UserID,"VideoID"=>$VideoID);
		if($ActionType!==null){
				$condition['ActionType']=$ActionType;
		}
		return $this->_db->delete("s_user_action",$condition);
	}
	function getAction($UserID){
		return $this->_db->select("s_user_action",array("UserID"=>$UserID),array("ActionType","count(*) ct"),$groupBy="group by ActionType");
	}
	function listAction($UserID,$ActionType,$page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_user_action"),
				array("s_user_action.UserID"=>$UserID,"s_user_action.ActionType"=>$ActionType),
				array("s_user_action.VideoID","s_user_action.ActionType","ActionTime"),
				"ORDER BY ActionTime DESC"
		);
	}
	//{{{
	function addList($List){
		return $this->_db->insert("s_list",$List);
	}
	function addListContent($ListID,$VideoID,$MvOrder=0){
		if(($r=$this->_db->insert("s_list_content",array("ListID"=>$ListID,"VideoID"=>$VideoID,"MvOrder"=>$MvOrder),true))===1){
			return $this->_db->update("s_list",array("ListID"=>$ListID),array("ListCount=ListCount+1"));
		};
		return false;
	}
	function delListContent($ListID,$VideoID){
		if($this->_db->delete("s_list_content",array("ListID"=>$ListID,"VideoID"=>$VideoID))){
			return $this->_db->update("s_list",array("ListID"=>$ListID),array("ListCount=ListCount-1"));
		};
		return false;
	}
	function listContent($ListID){
			$this->_db->setLimit(1000);
			return $this->_db->select(
					array("s_list_content"),
					array("ListID"=>$ListID),
					array("ListID","VideoID","MvOrder"),"ORDER BY MvOrder"
			);
	}
	
	function listContentRand($ListID=1,$pageSize=20){
		$this->_db->setPage(1);
		$this->_db->setLimit($pageSize);
		return $this->_db->select("s_list_content",array("ListID"=>$ListID),array("VideoID"),"ORDER BY RAND() ASC");
	}
	function getListCount($UserID){
		$row = $this->_db->selectOne("s_list",array("UserID"=>$UserID),array("count(*) ct"));
		return $row['ct'];
	}
	function updateListOrder($UserID,$ListID,$ListOrder){
		return $this->_db->update("s_list",array("ListID"=>$ListID,"UserID"=>$UserID),array("ListOrder"=>$ListOrder));
	}
	function updateListContentsOrder($ListID,$VideoID,$MvOrder){
		return $this->_db->update("s_list_content",array("ListID"=>$ListID,"VideoID"=>$VideoID),array("MvOrder"=>$MvOrder));
	}
	function editList($ListID,$List){
		return $this->_db->update("s_list",array("ListID"=>$ListID),$List);
	}
	function delList($ListID){
		if($this->_db->delete("s_list",array("ListID"=>$ListID))){
				if($this->_db->delete("s_list_content",array("ListID"=>$ListID))!==false){
						return true;
				}
		}
		return false;
	}
	function emptyList($ListID){
		$this->editList($ListID,array("ListCount"=>0));
		return $this->_db->delete("s_list_content",array("ListID"=>$ListID));
	}
	function getList($ListID){
		return $this->_db->selectOne("s_list",array("ListID"=>$ListID));
	}
	function ListList($UserID){
		return $this->_db->select("s_list",array("UserID"=>$UserID),"*","ORDER BY ListOrder");
	}
	function ListAllList($page=1,$limit=50){
		$this->_db->setPage($page);
		$this->_db->setLimit($limit);
		return $this->_db->select("s_list",array(),"*","ORDER BY ListType DESC ,EditOrder ASC");
	}
	function ListRadioList(){
		return $this->_db->select("s_list",array("ListType"=>1),"*","ORDER BY EditOrder ASC");
	}
	//}}}
	/*增加收听日志*/
	function addListen($Listen){
		return $this->_db->insert("s_user_listen",$Listen,false,false,array("ListenTotal=ListenTotal+1","ListenTime=CURRENT_TIMESTAMP"));
	}
	function delListen($UserID,$VideoID){
		return $this->_db->delete("s_user_listen",array("UserID"=>$UserID,"VideoID"=>$VideoID));
	}
	/*收听日志*/
	function ListListen($UserID,$page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_user_listen"),
				array("s_user_listen.UserID"=>$UserID),
				array("s_user_listen.VideoID"),
				"ORDER BY ListenTime DESC"
		);
	}
	function getListenCount($UserID){
		$row = $this->_db->selectOne("s_user_listen",array("UserID"=>$UserID),array("count(*) ct"));
		return $row['ct'];
	}
}
?>
