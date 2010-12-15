<?php
class player_db{
	private $_dbConfig;
	private $_zone;
	function __construct($zone="player"){
		$this->_zone = $zone;
		$this->_dbConfig = SDb::getConfig($this->_zone);
		$this->_db = SDb::getDbEngine("pdo_mysql");
		$this->_db->init($this->_dbConfig);
	}
	function getMvByVid($vid){
		return $this->_db->selectOne("s_mv",array("MvVideoID"=>$vid));
	}
	function addMv($Mv){
		return $this->_db->insert("s_mv",$Mv);
	}
}
?>
