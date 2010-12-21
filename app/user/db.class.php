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
	function getUser($username){
		return $this->_db->selectOne("s_user",array("UserName"=>$username));
	}
	function addUser($User){
		return $this->_db->insert("s_user",$User);
	}
	function getUserByEmail($useremail){
		return $this->_db->selectOne("s_user",array("UserEmail"=>$useremail));
	}
}
?>
