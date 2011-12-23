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
	function pageQQ($inPath){
		$vid = !empty($inPath[3])?$inPath[3]:0;
		$video_api = new video_api;
		$item = $video_api->getVideoInfo($vid);
		$SingerNameS=array();
		foreach($item['Singers'] as $singer){
			$SingerNameS[]="@".$singer['SingerName'];
		}
		return "我正在#优酷电台#收听《 ".(implode(" , ",$SingerNameS))." - {$item['VideoName']} 》\n您们也来这里听听吧: http://youku.fm/#vid={$item['VideoID']}";
	}
	function pageQqPost($inPath){
		$user=user_api::islogin();
		if(!empty($_SESSION['qq_openid']) && !empty($_SESSION['qq_openkey'])){
			if(!empty($_POST['content']) && ($user=user_api::islogin())!==false){
				$url = "http://open.t.qq.com/api/t/add_video";
				include_once(WWW_ROOT.'/lib/qq/qzone/qzone.config.php');
				include_once(WWW_ROOT.'/lib/qq/weibo/lib/OpenSDK/OAuth/sns_sig_check.php');
				$params=array();
				$params['openid']=$_SESSION['qq_openid'];

				$params['appid'] = QQ_QZONE_APPID;
				$params['openkey']=$_SESSION['qq_openkey'];
				$params['format']="json";
				$params['content']=$_POST['content'];
				$params['clientip']=$_SERVER['REMOTE_ADDR'];
				$params['reqtime'] = time();
				$params['wbversion'] = '1';
				$params['url'] = "http://v.youku.com/v_show/id_".(singer_music::encode($_POST['vid'])).".html";
				$params['pf'] = 'tapp';
				$urls = @parse_url($url);
				$sig = SnsSigCheck::makeSig("POST", $urls['path'], $params, QQ_QZONE_APPKEY.'&');
				$params['sig'] = $sig;
				$r = SHttp::post($url,$params);
				$r = SJson::decode($r);
				if(!empty($r->data->id)){
					return true;
				}
			}
		}
		return false;
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
