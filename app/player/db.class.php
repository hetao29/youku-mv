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
	function getRandMusicNew(){
$sql='
SELECT 
 s_music.MusicID,s_music.VideoID,s_singer.SingerName,s_music.MusicName,
 concat(s_singer.SingerName," - ",s_music.MusicName)  MvName,
 s_music_video.snapshot MvPic,s_music_video.duration MvSeconds
FROM s_singer,s_music,s_music_video 
WHERE 
 s_music._Finished=1 and  
 s_singer.SingerID=s_music.SingerID and  
 s_music.MusicPubdate >"2011-01-01" and
 s_music.MusicID=s_music_video.MusicID and 
 s_music.VideoID=s_music_video.VideoID 
ORDER BY RAND() ASC 
LIMIT 50;
';
		return ($this->_db->query($sql));
	}
	function getRandMusicNew2010(){
$sql='
SELECT 
 s_music.MusicID,s_music.VideoID,s_singer.SingerName,s_music.MusicName,
 concat(s_singer.SingerName," - ",s_music.MusicName)  MvName,
 s_music_video.snapshot MvPic,s_music_video.duration MvSeconds
FROM s_singer,s_music,s_music_video 
WHERE 
 s_music._Finished=1 and  
 s_singer.SingerID=s_music.SingerID and  
 s_music.MusicPubdate between "2010-01-01" and "2011-01-01" and
 s_music.MusicID=s_music_video.MusicID and 
 s_music.VideoID=s_music_video.VideoID 
ORDER BY RAND() ASC 
LIMIT 50;
';
		return ($this->_db->query($sql));
	}
	function getRandMusic($ListID=1,$UserID=0,$pageSize=50){
		//80后经典
			//1.s_singer.SingerType=1,2,3
			//2.s_music.pubDate>'1995-01-01' < '2005-01-01'
			//alter table s_singer add KEY SingerType( SingerType);
		//算法要优化
		$this->_db->setPage(1);
		$this->_db->setLimit($pageSize);
/*
$sql="SELECT 
 s_music.MusicID,s_music.VideoID,s_singer.SingerName,s_music.MusicName,
 concat(s_singer.SingerName,' - ',s_music.MusicName)  MvName,
 s_music_video.snapshot MvPic,s_music_video.duration MvSeconds
FROM s_singer,s_music,s_music_video JOIN
 (SELECT (RAND() *
  (SELECT MAX(MusicID) FROM s_music where 
  MusicPubdate between '1995-01-01' and 
  '2005-01-01' and _Finished=1)) AS MusicID)
 AS p2
WHERE 
 s_music.MusicID >= p2.MusicID and 
 s_music._Finished=1 and  
 s_singer.SingerID=s_music.SingerID and  
 s_singer.SingerType in(1,2,3) and  
 s_music.MusicPubdate between '1995-01-01' and '2005-01-01' and
 s_music.MusicID=s_music_video.MusicID and 
 s_music.VideoID=s_music_video.VideoID 
group by s_music.VideoID 
ORDER BY s_music.VideoID ASC 
LIMIT 100";
*/
$sql='
SELECT 
 s_music.MusicID,s_music.VideoID,s_singer.SingerName,s_music.MusicName,
 concat(s_singer.SingerName," - ",s_music.MusicName)  MvName,
 s_music_video.snapshot MvPic,s_music_video.duration MvSeconds
FROM s_singer,s_music,s_music_video 
WHERE 
 s_music._Finished=1 and  
 s_singer.SingerID=s_music.SingerID and  
 s_singer.SingerType in(1,2,3) and  
 s_music.MusicPubdate between "1995-01-01" and "2005-01-01" and
 s_music.MusicID=s_music_video.MusicID and 
 s_music.VideoID=s_music_video.VideoID 
ORDER BY RAND() ASC 
LIMIT 50;';
		return ($this->_db->query($sql));
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
