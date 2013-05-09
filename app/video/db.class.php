<?php
/*
 * 此类操作下面的表
 * s_video 
 * s_video_extension 
 * s_lyrics 
 */
class video_db{
	private $_dbConfig;
	private $_zone;
	function __construct($zone="video"){
		$this->_zone = $zone;
		$this->_dbConfig = SDb::getConfig($this->_zone);
		$this->_db = new SDb();
		$this->_db->init($this->_dbConfig);
	}
	function getVideotmp(){
		return $this->_db->select("s_video",array("VideoDuration"=>0));//"=>$vid));
	}
	/**
	 * get
	 */
	function getVideo($vid){
		return $this->_db->selectOne("s_video",array("VideoID"=>$vid));
	}
	/**
	 * 主要是给rebuild.php来用来做索引的
	 */
	function listVideo($startTime,$limit=-1){
		$this->_db->setLimit($limit);
		return $this->_db->select("s_video",array("VideoUpdateTime>='$startTime'","VideoStatus!=-2"),"*","",array("VideoUpdateTime"=>"ASC","VideoID"=>"ASC"));
	}
	function getVideoExtension($vid){
		return $this->_db->selectOne("s_video_extension",array("VideoID"=>$vid));
	}
	function getLyrics($VideoID){
		return $this->_db->selectOne("s_lyrics",array("VideoID"=>$VideoID));
	}
	function listVideoByAlbumID($AlbumID,$page=1,$size=-1){
		//从搜索出数据
		$this->_db->setPage($page);
		$this->_db->setLimit($size);
		return $this->_db->select(array("s_video"),array("AlbumID"=>$AlbumID));
	}
	
	function listVideoRand($pageSize=20){
		$this->_db->setPage(1);
		$this->_db->setLimit($pageSize);
		return $this->_db->select("s_video",array("VideoStatus"=>1),array("VideoID"),"",array("RAND()"=>"ASC"));
	}

	function listVideoBySingerID($SingerID){
		return $this->_db->select(
			array("s_video","s_singer"),
			array("s_singer.SingerID"=>$SingerID,"s_video.SingerIDS=s_singer.SingerID"),
			array(
					"s_singer.SingerName","s_video.VideoID", "s_video.VideoName", "s_video.VideoDuration","s_video.VideoPubdate"
			),
			"",
			array("VideoPubdate"=>"desc")
		);
	}
	//function getVideoCount(){
	//	$row = $this->_db->selectOne("s_video",array(),"count(*) ct");
	//	return $row['ct'];
	//}
	/**
	 * update
	 */
	function updateVideo($vid,$Video){
		return $this->_db->update("s_video",array("VideoID"=>$vid),$Video);
	}
	function updateVideoExtension($vid,$Video){
		return $this->_db->update("s_video_extension",array("VideoID"=>$vid),$Video);
	}
	function updateLyrics($VideoID,$Lyrics){
		return $this->_db->update("s_lyrics",array("VideoID"=>$VideoID),$Lyrics);
	}
	/**
	 * add
	 */
	function addVideo($Video,$replace=false){
		return $this->_db->insert("s_video",$Video,$replace);
	}
	function addVideoExtension($Video){
		return $this->_db->insert("s_video_extension",$Video);
	}
	function addLyrics($Lyrics){
		return $this->_db->insert("s_lyrics",$Lyrics,$replace = true);
	}
}
?>
