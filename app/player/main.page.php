<?php
class player_main extends SGui{
	function __construct(){
		echo $this->render("head.tpl");
	}
	function __destruct(){
		echo $this->render("footer.tpl");
	}
	function pageEntry($inPath){
		echo $this->render("player/player.tpl");
	}
	function pageHeader($inPath){
			$param = array();
			if(!empty($_SESSION['user'])){
					$param['user'] = $_SESSION['user'];
			}
		echo $this->render("player/header.tpl",$param);
	}
	/**
	 * 增加MV
	 * @param $MvName
	 * @param $MvVideoID (url)
	 * @param [$MvListID]
	 */

	function pageAddMV($inPath){
			$Mv = array();
			$api = new player_api;
			$vid = $_REQUEST['vid'];
			$Mv['MvSourceID']=1;
			switch($Mv['MvSourceID']){
				case 1:
					$video = $api->getVideoInfo($vid);
				break;
			}
			if(!empty($video)){
				$Mv['MvName'] = $Mv['MvAlias']=$video->title;
				$Mv['MvSeconds'] = $video->seconds;
				$Mv['MvVideoID'] = $video->vid;
			}
			$Mv['UserID'] = 1;//我自己,TODO
			$db= new player_db;
			$db->addMv($Mv);
			return true;
	}
	/**
	 * 增加列表
	 * @param $ListName
	 */
	function pageAddList($inPath){
	}
	/**
	 * 获取一个列表歌曲
	 * @param $ListID
	 */
	function pageListMv($inPath){
	}
	/**
	 * 列出所有列表
	 */
	function pageListList($inPath){
	}
	/**
	 * 读取歌词
	 **/
	function pageGetLyric($inPath){
			$lyric = new stdclass;
			$lyric->LyricContent="[ti:如果这就是爱情]
[ar:张靓颖]
[al:我相信]
[by:活在當下]
[00:01.12]张靓颖 - 如果这就是爱情
[00:05.89]
[04:31.85][00:06.73]www.51lrc.com @ 活在當下 制作
[00:14.45]
[00:16.50]你做了选择 对的错的
[00:23.02]我只能承认 心是痛的
[00:29.02]怀疑你舍得 我被伤的那么深
[00:36.49]就放声哭了 何必再强忍
[00:41.04]
[00:41.74]我没有选择 我不再完整
[00:48.11]原来最后的吻 如此冰冷
[00:54.60]你只能默认 我要被割舍
[01:00.66]眼看着 你走了
[02:53.98][01:06.61]
[02:54.49][01:07.05]如果这不是结局 如果我还爱你
[03:00.98][01:13.69]如果我愿相信 你就是唯一
[03:06.93][01:19.62]如果你听到这里 如果你依然放弃
[03:13.30][01:25.95]那这就是爱情 我难以抗拒
[03:19.15][01:32.25]
[03:59.06][03:19.73][01:32.64]如果这就是爱情 本来就不公平
[04:05.70][03:26.27][01:38.85]你不需要讲理 我可以离去
[04:11.66][03:32.23][01:44.82]如果我成全了你 如果我能祝福你
[04:17.93][03:38.54][01:51.15]那不是我看清 是我证明 我爱你
[04:29.80][03:51.89][02:00.99]
[02:03.86]灰色的天空 无法猜透
[02:10.10]多余的眼泪 无法挽留
[02:16.32]什么都牵动 感觉真的好脆弱
[02:23.79]被呵护的人 原来不是我
[02:28.92]
[02:29.47]我不要你走 我不想放手
[02:35.42]却又不能够奢求 同情的温柔
[02:41.69]你可以自由 我愿意承受
[02:47.98]把昨天 留给我
";
			return $lyric;
			$vid = $_GET['vid'];
			//
			$db = new player_db;
			$mv  = $db->getMvByVid($vid);
			if(!empty($vm)){
					$lyric = $db->getLyric($mv['MvID']);
					return $lyric;
			}
	}
	/**
	 * 添加歌词
	 */
	function pageAddLyric($inPath){
	}
	function pageComplete($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return "{}";
			$k = urlencode($k);
			$r = file_get_contents("http://tip.so.youku.com/search_keys?type=video&k=$k&limit=10");
			if($r===false){
					return "{}";
			}
			$r = str_replace("showresult('","",$r);
			$r = str_replace("',false)","",$r);
			return $r;
	}
	function pageSearch($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return;
			//$k = urlencode($k);
			$r = SHttp::get("http://www.youku.com/api_ptvideo/st_3_pid_XOA",array("sv"=>$k,"rt"=>3,"ob"=>6,"pz"=>30,"pg"=>1));
			return $r;
	}
	/*得到视频信息*/
	function pageGetVideo($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return;
			if(preg_match("/v_show\/id_(.*?)\./",$k,$_m)){
					//普通视频播放页
					//v_show/id_XMjI3MTU1ODM2.html
					$vid = urlencode($_m[1]);
					$r = SHttp::get("http://api.youku.com/api_ptvideoinfo",array("pid"=>"XOA==","rt"=>3,"id"=>$k));
					$r = SJson::decode($r);
					$o = new stdclass;
					$v = new stdclass;
					$o->items=array();
					$o->items[]=&$v;
					$v->vid = $vid;
					$v->title = $r->item->title;
					$v->seconds= $r->item->duration;
					return SJson::encode($o);
			}elseif(preg_match("/show_page\/id_(.*?)\./",$k,$_m)){
					//节目显示页
					$pid = $_m[1];
					$st = 11;
			}elseif(preg_match("/playlist_show\/id_(.*?)\./",$k,$_m)){
					//专辑显示页
					$pid = $_m[1];
					$st = 8;
					//playlist_show/id_5358637.html

			}elseif(preg_match("/v_playlist\/f(\\d*)/",$k,$_m)){
					//专辑播放页
					//v_playlist/f5358637o1p1.html
					$pid = $_m[1];
					$st = 8;
			}
			if(!empty($pid)){
					$r = SHttp::get("http://api.youku.com/api_ptvideo/st_$st",array("pid"=>"XOA==","rt"=>3,"pz"=>100,"sv"=>$pid));
					$r = SJson::decode($r);
					$o = new stdclass;
					$o->items=array();
					foreach($r->item as $item){
						$v = new stdclass;
						$v->vid = $item->videoid;
						$v->title = $item->title;
						$v->seconds= $item->duration;
						$o->items[]=$v;
					}
					return SJson::encode($o);
			}
			return "{}";
	}
}
?>
