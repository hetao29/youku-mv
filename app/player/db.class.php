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
		return $this->_db->selectOne("s_video",array("VideoID"=>$vid));
	}
	function getRandMv($ListID=1,$UserID=0,$pageSize=50){
		$this->_db->setLimit($pageSize);
		if(!empty($UserID) && is_numeric($UserID)){
			return $this->_db->select(
					array("s_video","s_list_content"),
					array(
							"s_video.VideoID=s_list_content.VideoID",
							"s_list_content.ListID"=>$ListID,
							"s_video.VideoID not in(select VideoID from s_user_action where UserID=$UserID and ActionType!=2)"
					)
					,array("s_video.VideoID","s_video.MvName","s_video.MvSeconds","s_video.MvPic")
					,"ORDER BY rand()");
		}
		return $this->_db->select(
					array("s_video","s_list_content"),
					array("s_video.VideoID=s_list_content.VideoID","s_list_content.ListID"=>$ListID)
					,array("s_video.VideoID","s_video.MvName","s_video.MvSeconds","s_video.MvPic")
					,"ORDER BY rand()");
	}
	function getMv($vid){
		return $this->_db->selectOne("s_video",array("VideoID"=>$vid));
	}
	function updateMv($vid,$Mv){
		return $this->_db->update("s_video",array("VideoID"=>$vid),$Mv);
	}
	function getMvCount(){
		$row = $this->_db->selectOne("s_video",array(),"count(*) ct");
		return $row['ct'];
	}
	function addMv($Mv){
		return $this->_db->insert("s_video",$Mv);
	}
	function updateLyrics($VideoID,$Lyrics){
		return $this->_db->update("s_lyrics",array("VideoID"=>$VideoID),$Lyrics);
	}
	function getLyrics($VideoID){
		return $this->_db->selectOne("s_lyrics",array("VideoID"=>$VideoID));
	}
	function addLyrics($Lyrics){
		return $this->_db->insert("s_lyrics",$Lyrics,$replace = true);
	}
}
?>
