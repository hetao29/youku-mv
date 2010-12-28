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
	function getMv($mvid){
		return $this->_db->selectOne("s_mv",array("MvID"=>$mvid));
	}
	function updateMv($mvid,$Mv){
		return $this->_db->update("s_mv",array("MvID"=>$mvid),$Mv);
	}
	function getMvCount(){
		$row = $this->_db->selectOne("s_mv",array(),"count(*) ct");
		return $row['ct'];
	}
	function addMv($Mv){
		return $this->_db->insert("s_mv",$Mv);
	}
	function updateLyrics($MvID,$Lyrics){
		return $this->_db->update("s_lyrics",array("MvID"=>$MvID),$Lyrics);
	}
	function getLyrics($MvID){
		return $this->_db->selectOne("s_lyrics",array("MvID"=>$MvID));
	}
	function addLyrics($Lyrics){
		return $this->_db->insert("s_lyrics",$Lyrics,$replace = true);
	}
}
?>
