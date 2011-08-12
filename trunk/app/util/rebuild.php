<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
$log=dirname(__FILE__)."/"."rebuild.log";
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
		if($i++>=20){
				$t2 = microtime_float();
				echo ($total)."/$len\t".($t2-$t)." seconds\n";
				$t  = $t2;
				$i=0;
		};
		$vid = $item['VideoID'];
		$v   = $video_api->getVideoInfo($vid);
		$search_api->update($vid,$v);
		file_put_contents($log,$v['VideoUpdateTime']."/".$v['VideoID']);
}
$search_api->optimize();
