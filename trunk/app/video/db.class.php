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
		$this->_db = SDb::getDbEngine("pdo_mysql");
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
	function listVideo($startTime){
		return $this->_db->select("s_video",array("VideoUpdateTime>='$startTime'"),"*","ORDER BY VideoUpdateTime ASC,VideoID ASC");
	}
	function getVideoExtension($vid){
		return $this->_db->selectOne("s_video_extension",array("VideoID"=>$vid));
	}
	function getLyrics($VideoID){
		return $this->_db->selectOne("s_lyrics",array("VideoID"=>$VideoID));
	}
	function listVideoByAlbumID($AlbumID){
		//从搜索出数据
		return $this->_db->select(array("s_video"),array("AlbumID"=>$AlbumID));
	}
	function listVideoBySingerID($SingerID){
		return $this->_db->select(
			array("s_video","s_singer"),
			array("s_singer.SingerID"=>$SingerID,"s_video.SingerIDS=s_singer.SingerID"),
			array(
					"s_singer.SingerName","s_video.VideoID", "s_video.VideoName", "s_video.VideoDuration","s_video.VideoPubdate"
			),
			"ORDER BY VideoPubdate desc"
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
	function addVideo($Video){
		return $this->_db->insert("s_video",$Video);
	}
	function addVideoExtension($Video){
		return $this->_db->insert("s_video_extension",$Video);
	}
	function addLyrics($Lyrics){
		return $this->_db->insert("s_lyrics",$Lyrics,$replace = true);
	}
	function getRandVideo($ListID=1,$UserID=0,$pageSize=50){
		//算法要优化
		$this->_db->setPage(1);
		$this->_db->setLimit($pageSize);
/*
$sql="SELECT 
 s_video.VideoID,s_video.VideoID,s_singer.SingerName,s_video.VideoName,
 concat(s_singer.SingerName,' - ',s_video.VideoName)  MvName,
 s_video_video.snapshot MvPic,s_video_video.duration MvSeconds
FROM s_singer,s_video,s_video_video JOIN
 (SELECT (RAND() *
  (SELECT MAX(VideoID) FROM s_video where 
  VideoPubdate between '1995-01-01' and 
  '2005-01-01' and _Finished=1)) AS VideoID)
 AS p2
WHERE 
 s_video.VideoID >= p2.VideoID and 
 s_video._Finished=1 and  
 s_singer.SingerID=s_video.SingerID and  
 s_singer.SingerType in(1,2,3) and  
 s_video.VideoPubdate between '1995-01-01' and '2005-01-01' and
 s_video.VideoID=s_video_video.VideoID and 
 s_video.VideoID=s_video_video.VideoID 
group by s_video.VideoID 
ORDER BY s_video.VideoID ASC 
LIMIT 100";
*/
$sql='
SELECT 
 s_video.VideoID,s_singer.SingerName,s_video.VideoName,
 concat(s_singer.SingerName," - ",s_video.VideoName)  VideoName,
 s_video.VideoThumb VideoThumb,s_video.VideoDuration VideoDuration 
FROM s_singer,s_video
WHERE 
 s_singer.SingerID=s_video.SingerIDS and  
 s_video.VideoPubdate between "1995-01-01" and "2005-01-01" 
ORDER BY RAND() ASC 
LIMIT 50;';
		return ($this->_db->query($sql));
	}
}
?>
