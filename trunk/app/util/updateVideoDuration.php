<?php
/**
 * 重作所有索引
 */
exit;
chdir(dirname(__FILE__));
require("../../global.php");

$video_api = new video_api;
$video_db= new video_db;
$r = $video_db->getVideotmp();
foreach($r->items as $v){
		$video_api->getVideoDuration($v['VideoID']);//更新时间 
}
