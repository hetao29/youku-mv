<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
$log="rebuild.log";
$db = new video_db;
$video_api = new video_api;
$search_api = new search_api;
$logData = trim(file_get_contents($log));
$startTime=0;$startVideoID=0;
if(!empty($logData)){
		$tmp = explode("/",$logData);
		$startTime=trim($tmp[0]);
		$startVideoID=trim($tmp[1]);
}
echo "START FROM $startTime / $startVideoID\n";
$videos = $db->listVideo($startTime,$startVideoID);
$singer_db = new singer_db;
$tmp = $singer_db->listSinger(1,-1);
$singers=array();
foreach($tmp->items as $item){
		$id = $item['SingerID'];
		$singers[$id]=$item;
}

$album_db = new album_db;
$tmp = $album_db->listAlbum(1,-1);
$albums=array();
foreach($tmp->items as $item){
		$id = $item['AlbumID'];
		$albums[$id]=$item;
}
$i=0;
$total=0;
$len=count($videos->items);
function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
}
$t = microtime_float();
foreach($videos->items as $item){
		$total++;
		if($i++>=100){
				$t2 = microtime_float();
				echo ($total)."/$len\t".($t2-$t)." seconds\n";
				$t  = $t2;
				$i=0;
		};
		$vid = $item['VideoID'];
		$singerids = split("/",$item['SingerIDS']);
		$singernames=array();
		foreach($singerids as $singerid){
				$singernames[]=@$singers[$singerid];
		}
		if(empty($singernames))continue;
		$item['Singers']=$singernames;
		$id = $item['AlbumID'];
		$item['Album']=@$albums[$id];
		$v   = $video_api->getVideoInfo($vid);
		$search_api->add($item);
		file_put_contents($log,$item['VideoUpdateTime']."/".$item['VideoID']);
}
$search_api->optimize();
