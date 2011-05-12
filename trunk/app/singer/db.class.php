<?php
class singer_db{
	private $_dbConfig;
	private $_zone;
	function __construct($zone="user"){
		$this->_zone = $zone;
		$this->_dbConfig = SDb::getConfig($this->_zone);
		$this->_db = SDb::getDbEngine("pdo_mysql");
		$this->_db->init($this->_dbConfig);
	}
	function addSinger($Singer){
		return $this->_db->insert("s_singer",$Singer);
	}
	function updateSiger($Singer){
		return $this->_db->update("s_singer",array("SingerID"=>$Singer['SingerID']),$Singer);
	}
	function listSinger($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_singer"),
				//array("SingerID"=>4048),
				//array("SingerID"=>1),
				array(),
				"*",
				"ORDER BY SingerID"
		);
	}
	function getMvCount($SingerID){
		return $this->_db->selectOne("s_music",array("SingerID"=>$SingerID,"_Finished"=>1),array("count(*) as _Ct"));
	}
	function addSpecial($Special){
		return $this->_db->insert("s_special",$Special);
	}
	function updateSpecial($Special){
		return $this->_db->update("s_special",array("SpecialID"=>$Special['SpecialID']),$Special);
	}
	function listSpecial($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_special"),
				//array("SpecialID"=>11177),
				//array("SpecialID"=>193),
				array(),
				"*",
				"ORDER BY SpecialID"
		);
	}
	function addMusic($Music){
		return $this->_db->insert("s_music",$Music);
	}
	function getMusic($MusicID){
		return $this->_db->selectOne(
			array("s_music","s_singer","s_special"),
			array("s_music.MusicID"=>$MusicID,"s_music.SingerID=s_singer.SingerID","s_music.SpecialID=s_special.SpecialID"),
			array("s_music.MusicID","s_music.MusicName","s_singer.SingerID","s_singer.SingerName","s_sepcial.SpecialID","s_special.SpecialName")
			);
	}
	function updateMusic($Music){
		return $this->_db->update("s_music",array("MusicID"=>$Music['MusicID']),$Music);
	}
	function listMusic($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_music","s_singer"),
				array("s_music.SingerID=s_singer.SingerID","s_music._Finished=1"),
				array("s_music.MusicName","s_singer.SingerName","s_music.MusicID","s_singer.SingerType"),
				"ORDER BY MusicID"
		);
	}
	function listMusic2($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_music"),
				array("_Finished=1"),
				array("*"),
				"ORDER BY MusicID"
		);
	}
	function getMusicIDByVideoID($VideoID){
		return $this->_db->selectOne("s_music",array("VideoID"=>$VideoID));
	}
	function getMusicIDByVideoID2($VideoID){
		return $this->_db->selectOne("s_music_video",array("VideoID"=>$VideoID));
	}
	function addMusicVideo($MusicVideo){
		return $this->_db->insert("s_music_video",$MusicVideo);
	}
	function updateMusicVideo($MusicVideo){
		return $this->_db->update("s_music_video",array("MusicID"=>$MusicVideo['MusicID']),$MusicVideo);
	}
/*
	function listMusicVideo($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_music_video"),
				array(),
				"*",
				"ORDER BY MusicID"
		);
	}
*/
	function listMusicVideo($MusicID){
		$this->_db->setLimit(-1);
		$this->_db->setPage(1);
		return $this->_db->select(
				array("s_music_video"),
				array("MusicID"=>$MusicID),
				"*",
				"ORDER BY pv desc ,pubDate desc"
		);
	}
}
?>
