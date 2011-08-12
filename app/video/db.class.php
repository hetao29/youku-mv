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
		return $this->_db->select("s_video",array("VideoUpdateTime>='$startTime'"),"VideoID","ORDER BY VideoUpdateTime ASC,VideoID ASC");
	}
	function getVideoExtension($vid){
		return $this->_db->selectOne("s_video_extension",array("VideoID"=>$vid));
	}
	function getLyrics($VideoID){
		return $this->_db->selectOne("s_lyrics",array("VideoID"=>$VideoID));
	}
	function listVideoByAlbumID($AlbumID){
		//从搜索出数据
		return $this->_db->select(array("s_singer","s_video"),array("AlbumID"=>$AlbumID,"s_singer.SingerID=s_video.SingerIDS"));
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
	/**
	 * rand
	 */
	/*
	function getRandVideoNew(){
$sql='
SELECT 
 s_video.VideoID,s_video.VideoID,s_singer.SingerName,s_video.VideoName,
 concat(s_singer.SingerName," - ",s_video.VideoName)  MvName,
 s_video_video.snapshot MvPic,s_video_video.duration MvSeconds
FROM s_singer,s_video,s_video_video 
WHERE 
 s_video._Finished=1 and  
 s_singer.SingerID=s_video.SingerID and  
 s_singer.SingerType in(1,2,3,4,5,6,7,8) and  
 s_video.VideoPubdate >"2011-01-01" and
 s_video.VideoID=s_video_video.VideoID and 
 s_video.VideoID=s_video_video.VideoID 
ORDER BY RAND() ASC 
LIMIT 50;
';
		return ($this->_db->query($sql));
	}
	function getRandVideoNew2010(){
$sql='
SELECT 
 s_video.VideoID,s_video.VideoID,s_singer.SingerName,s_video.VideoName,
 concat(s_singer.SingerName," - ",s_video.VideoName)  MvName,
 s_video_video.snapshot MvPic,s_video_video.duration MvSeconds
FROM s_singer,s_video,s_video_video 
WHERE 
 s_video._Finished=1 and  
 s_singer.SingerType in(1,2,3,4,5,6,7,8) and  
 s_singer.SingerID=s_video.SingerID and  
 s_video.VideoPubdate between "2010-01-01" and "2011-01-01" and
 s_video.VideoID=s_video_video.VideoID and 
 s_video.VideoID=s_video_video.VideoID 
ORDER BY RAND() ASC 
LIMIT 50;
';
		return ($this->_db->query($sql));
	}
	 */
	function getRandVideo($ListID=1,$UserID=0,$pageSize=50){
		//80后经典
			//1.s_singer.SingerType=1,2,3
			//2.s_video.pubDate>'1995-01-01' < '2005-01-01'
			//alter table s_singer add KEY SingerType( SingerType);
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
	/*
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
	 */
}
?>
