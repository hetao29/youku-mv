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
	/*视频顶踩
	--ActionType 
	--0 喜欢(up)
	--1 删除(down)
	--2 跳过(skip)
	 */
	function addAction($Action){
		return $this->_db->insert("s_user_action",$Action,true);
	}
	function getAction($UserID){
		return $this->_db->select("s_user_action",array("UserID"=>$UserID),array("ActionType","count(*) ct"),$groupBy="group by ActionType");
	}
	function listAction($UserID,$ActionType,$page,$pageSize=10){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_user_action","s_mv"),
				array("s_user_action.UserID"=>$UserID,"s_user_action.MvID=s_mv.MvID","s_user_action.ActionType"=>$ActionType),
				array("s_user_action.MvID","MvName","MvVideoID","MvSeconds","ActionTime"),
				"ORDER BY ActionTime DESC"
		);
	}
	//{{{
	function addList($List){
		return $this->_db->insert("s_list",$List);
	}
	function addListContent($ListID,$MvID){
		if($this->_db->insert("s_list_content",array("ListID"=>$ListID,"MvID"=>$MvID))){
			$this->_db->update("s_list",array("ListID"=>$ListID),array("ListCount=ListCount+1"));
		};
	}
	function listContent($ListID){
			$this->_db->setLimit(-1);
			return $this->_db->select(
					array("s_mv","s_list_content"),
					array("s_mv.MvID=s_list_content.MvID","s_list_content.ListID"=>$ListID)
			);
	}
	function getListCount($UserID){
		$row = $this->_db->selectOne("s_list",array("UserID"=>$UserID),array("count(*) ct"));
		return $row['ct'];
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
	//}}}
	/*增加收听日志*/
	function addListen($Listen){
		return $this->_db->insert("s_user_listen",$Listen,false,false,array("ListenTotal=ListenTotal+1","ListenTime=CURRENT_TIMESTAMP"));
	}
	/*收听日志*/
	function ListListen($UserID,$page,$pageSize=10){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_user_listen","s_mv"),
				array("s_user_listen.UserID"=>$UserID,"s_user_listen.MvID=s_mv.MvID"),
				array("s_user_listen.MvID","MvName","MvVideoID","MvSeconds","ListenTime"),
				"ORDER BY ListenTime DESC"
		);
	}
	function getListenCount($UserID){
		$row = $this->_db->selectOne("s_user_listen",array("UserID"=>$UserID),array("count(*) ct"));
		return $row['ct'];
	}
	function getUserByEmail($useremail){
		return $this->_db->selectOne("s_user",array("UserEmail"=>$useremail));
	}
}
?>
