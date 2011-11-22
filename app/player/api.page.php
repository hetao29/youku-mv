<?php
class player_api{
	function __construct(){
	}
	function __destruct(){
	}
	function pageSina($inPath){
		$vid = !empty($inPath[3])?$inPath[3]:0;
		$video_api = new video_api;
		$item = $video_api->getVideoInfo($vid);
		$SingerNameS=array();
		foreach($item['Singers'] as $singer){
			$SingerNameS[]=$singer['SingerName'];
		}
		return "我正在#优酷电台# http://apps.weibo.com/youkufm \n收听 《 ".(implode(",",$SingerNameS))." 》 - 《 {$item['VideoName']} 》\n你们也来这里听听吧: http://youku.fm#vid={$item['VideoID']} \n\n(分享来自 @优酷电台 ，源视频：http://v.youku.com/v_show/id_".(singer_music::encode($item['VideoID'])).".html)";
	}
	function pageSinaPost($inPath){
		if(!empty($_POST['content']) && ($user=user_api::islogin())!==false){
			$sina = new api_sina;
			$sina->postWeibo($_POST['content']);
			return true;
		}
		return false;
	}
}
