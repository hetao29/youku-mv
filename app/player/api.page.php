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
			//$SingerNameS[]=$singer['SingerName'];
			$SingerNameS[]="@".$singer['SingerName'];
		}
		return "我正在#优酷电台#收听《 ".(implode(" , ",$SingerNameS))." - {$item['VideoName']} 》\n您们也来这里听听吧: http://apps.weibo.com/youkufm?vid={$item['VideoID']}  \n\n( 分享来自 @优酷电台 ，视频源：http://v.youku.com/v_show/id_".(singer_music::encode($item['VideoID'])).".html )";
	}
	function pageNetease($inPath){
		$vid = !empty($inPath[3])?$inPath[3]:0;
		$video_api = new video_api;
		$item = $video_api->getVideoInfo($vid);
		$SingerNameS=array();
		foreach($item['Singers'] as $singer){
			//$SingerNameS[]=$singer['SingerName'];
			$SingerNameS[]="@".$singer['SingerName'];
		}
		return "我正在#优酷电台#收听《 ".(implode(" , ",$SingerNameS))." - {$item['VideoName']} 》\n您们也来这里听听吧: http://youku.fm/#vid={$item['VideoID']}  \n\n( 分享来自 @优酷电台 ，视频源：http://v.youku.com/v_show/id_".(singer_music::encode($item['VideoID'])).".html )";
	}
	function pageSinaPost($inPath){
		if(!empty($_POST['content']) && ($user=user_api::islogin())!==false){
			$sina = new api_sina;
			return $sina->postWeibo($_POST['content']);
		}
		return false;
	}
	function pageNeteasePost($inPath){
		if(!empty($_POST['content']) && ($user=user_api::islogin())!==false){
			include_once(WWW_ROOT.'/lib/netease/t163_php_sdk/config.php');
			include_once(WWW_ROOT.'/lib/netease/t163_php_sdk/api/tblog.class.php');
			$access_token = SJson::decode($user['UserPassword']);
			$tblog = new TBlog(CONSUMER_KEY, CONSUMER_SECRET,$access_token->oauth_token , $access_token->oauth_token_secret);
			//$url = $tblog ->upload($_POST['content'],$target_path);    // 发送带图片微博
			$url = $tblog ->upload($_POST['content']);    // 发送带图片微博
			if(!empty($url['id']))return true;
		}
		return false;
	}
}
