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
	function getRandMv($ListID=1,$UserID=0,$pageSize=50){
		$this->_db->setLimit($pageSize);
		if(!empty($UserID) && is_numeric($UserID)){
			return $this->_db->select(
					array("s_mv","s_list_content"),
					array(
							"s_mv.MvID=s_list_content.MvID",
							"s_list_content.ListID"=>$ListID,
							"s_mv.MvID not in(select MvID from s_user_action where UserID=$UserID and ActionType!=2)"
					)
					,array("s_mv.MvID","s_mv.MvName","s_mv.MvVideoID","s_mv.MvSeconds","s_mv.MvPic")
					,"ORDER BY rand()");
		}
		return $this->_db->select(
					array("s_mv","s_list_content"),
					array("s_mv.MvID=s_list_content.MvID","s_list_content.ListID"=>$ListID)
					,array("s_mv.MvID","s_mv.MvName","s_mv.MvVideoID","s_mv.MvSeconds","s_mv.MvPic")
					,"ORDER BY rand()");
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
