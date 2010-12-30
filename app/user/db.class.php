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
	/*增加收听日志*/
	function addListen($Listen){
		return $this->_db->insert("s_user_listen",$Listen,false,false,array("ListenTotal=ListenTotal+1","ListenTime=CURRENT_TIMESTAMP"));
	}
	function getUserByEmail($useremail){
		return $this->_db->selectOne("s_user",array("UserEmail"=>$useremail));
	}
}
?>
