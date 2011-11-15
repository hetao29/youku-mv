<?php
class player_main extends STpl{
	function __construct(){
		//echo $this->render("head.tpl");
	}
	function __destruct(){
		//echo $this->render("footer.tpl");
	}
	function pageSina($inPath){
			//从POST过来的signed_request中提取oauth2信息
			if(!empty($_REQUEST["signed_request"])){
					require_once(WWW_ROOT."/lib/weibo/config.php");
					require_once(WWW_ROOT."/lib/weibo/saetv2.ex.class.php");
					$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
					$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
					if($data=='-2'){
							die('签名错误!');
					}else{
							$_SESSION['oauth2']=$data;
					}
					//判断用户是否授权
					if (empty($_SESSION['oauth2']["user_id"])) {//若没有获取到access token，则发起授权请求
echo '<html>
<head>
<link href="/player.css" media="all" rel="stylesheet" type="text/css" />

<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script> 
function authLoad(){
 	App.AuthDialog.show({
	client_id : "'.WB_AKEY.'",    //必选，appkey
	redirect_uri : "http://apps.weibo.com/youkufm",     //必选，授权后的回调地址，例如：http://apps.weibo.com/giftabc
	height: 120    //可选，默认距顶端120px
	});
}
</script>
</head>
<body>
<script>authLoad();</script>
</body>
</html>
';
							exit;
					} else {//若已获取到access token，则加载应用信息
							$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
							$user_id = $_SESSION['oauth2']['user_id'];
							$UserEmail = $user_id."@weibo.com";
							$db = new user_db;
							$user = $db->getUserByEmail($UserEmail,$paterid=2);
							if(empty($user)){
									//增加用户
									//新浪这个接口很慢
									$info = $c->show_user_by_id($user_id);
									$User = array();
									$User['UserAlias']=$info['name'];
									$User['UserEmail']=$UserEmail;
									$User['UserPassword']=$_SESSION['oauth2']['oauth_token'];
									$User['ParterID']="2";
									$UserID = $db->addUser($User);
									$user=$db->getUserByID($UserID);
							}else{
									//更新用户
									//if($user['UserPassword']!==$_SESSION['oauth2']['oauth_token']){
											$info = $c->show_user_by_id($user_id);
											$user['UserAlias']=$info['name'];
											$user['UserPassword']=$_SESSION['oauth2']['oauth_token'];
											$db->updateUser($user);
									//}
							}
							user_api::logout();
							user_api::login($user,!empty($_REQUEST['forever']));
					}
			}
			return $this->pageEntry($inPath,"sina");
	}
	function pageQQ($inPath){
			return $this->pageEntry($inPath,"qq");
	}
	function pageFaceBook($inPath){
			return $this->pageEntry($inPath,"facebook");
	}
	function pageRenren($inPath){
			return $this->pageEntry($inPath,"renren");
	}
	function pageEntry($inPath,$out=""){
		$param=array();
		$param['out']=$out;
		$param['jsversion']=filemtime(WWW_ROOT."/"."assets/js/youku.ws.js");
		$param['cssversion']=filemtime(WWW_ROOT."/"."assets/css/styleV2.css");
		return $this->render("player/playerV2.tpl",$param);
	}
	function pageHeader($inPath){
		$param = array();
		$out = !empty($inPath[3])?$inPath[3]:"";
		$param['out']=$out;
		if(($User=user_api::islogin())!==false){
			$db = new user_db;
			$action = $db->getAction($User['UserID']);
			$param['user'] = $User;
			$param['_CtListen'] = $db->getListenCount($User['UserID']);
			$param['_CtList'] = $db->getListCount($User['UserID']);
			$act = array();
			if(!empty($action->items)){
				foreach($action->items as $item){
					$k=$item['ActionType'];
					$v=$item['ct'];
					$act[$k]=$v;
				}
			}
			$param['act'] = $act;
		}
		return $this->render("player/headerV2.tpl",$param);
	}
	/**
	 * 跳过视频,顶视频,踩视频
	 * 如果登录,记住用户跳过的记录,如果没有登录,只是更新s_mv
	 * @param $actiontype=$inPath[3] skip|up|down
	 * 0 喜欢(up)
	 * 1 删除(down)
	 * 2 跳过(skip)
	 * @param $vid=$inPath[4] 
	 */
	function pageVideoAction($inPath){
			$result=new stdclass;
			if(!empty($inPath[3]) && !empty($inPath[4])){
				switch($inPath[3]){
					case "up":
							$fileds="VideoUpTimes";
							$actiontype = 0;
						break;
					case "down":
							$fileds="VideoDownTimes";
							$actiontype = 1;
						break;
					case "skip":
							$fileds="VideoSkipTimes";
							$actiontype = 2;
						break;
					default:
							return $result;
				}
				$db = new video_db;
				$extension = $db->getVideoExtension($inPath[4]);
				if(empty($extension)){
					$r = $db->addVideoExtension(array("$fileds=1","VideoID"=>$inPath[4]));
				}else{
					$r = $db->updateVideoExtension($inPath[4],array("$fileds=$fileds+1"));
				}
				$result->result = ($r!==false) ? true : false;
				$result->type=$inPath[3];
				if(($User=user_api::islogin())!==false){
						$user_db = new user_db;
						$record=$user_db->addAction(array("UserID"=>$User['UserID'],"VideoID"=>$inPath[4],"ActionType"=>$actiontype));
						if($record!==false){
							$result->record=true;
						}else{
							$result->record=false;
						}
				}

			}
			return $result;
	}
	function pageDelAction($inPath){
		if(($User=user_api::islogin())!==false && isset($_REQUEST['actiontype']) && !empty($_REQUEST['vid'])){
				$VideoID= $_REQUEST['vid'];
				$ActionType = $_REQUEST['actiontype'];
				$UserID=$User['UserID'];
				$db = new user_db;
				return $db->delAction($UserID,$VideoID,$ActionType);
		}
	}
	function pageListAction($inPath){
			if(($User=user_api::islogin())!==false){
					$action =!empty($inPath[3])?$inPath[3]:0;
					$page =!empty($inPath[4])?$inPath[4]:1;
					switch($action){
							case "up":	$actiontype=0;	break;
							case "down":$actiontype=1;	break;
							case "skip":$actiontype=2;	break;
					}
					$db = new user_db;
					$video_api = new video_api;
					$r = $db->listAction($User['UserID'],$actiontype,$page);
					if(!empty($r->items)){
							foreach($r->items as &$item){
									$item = $video_api->getVideoInfo($item['VideoID']);
							}
					}
					$r->actiontype=$actiontype;
					return $r;
			}
	}
	function pageRadioList($inPath){
		$db = new user_db;
		return $db->ListRadioList();
	}
	function pageRadio($inPath){
			$defaultChannelID=2;
			$chanelId=empty($_REQUEST['cid'])?$defaultChannelID:$_REQUEST['cid'];

			$video_api = new video_api;
			if($chanelId==5){
				$video_db = new video_db;
				$r = $video_db->listVideoRand(30);
			}else{
				$user_db = new user_db;
				$r = $user_db->listContentRand($chanelId);
				if(empty($r->items)){
					$r = $user_db->listContentRand($defaultChannelID);
				}

			}
			foreach($r->items as &$item){
					$item = $video_api->getVideoInfo($item['VideoID']);
			}

			$r->cid = $chanelId;
			return $r;
	}
	/**
	 * 增加MV
	 * @param $VideoName
	 * @param $VideoID (url)
	 * @param [$VideoListID]
	 */

	function pageAddVideo($inPath){
			$vid = $_REQUEST['vid'];
			if(!empty($vid)){
				$api = new video_api;
				return $api->getVideoByVid($vid);
			}
	}
	function pageGetVideoByVid($inPath){
			$vid = $_REQUEST['vid'];
			if(!empty($vid)){
				$api = new video_api;
				return $api->getVideoInfo($vid);
			}
	}
	/**
	 * 获取已经播放历史
	 * @param $page $inPath[3]
	 **/
	function pageListListen($inPath){
			if(($User=user_api::islogin())!==false){
					$page =!empty($inPath[3])?$inPath[3]:1;
					$db = new user_db;
					$video_api = new video_api;
					$r= $db->ListListen($User['UserID'],$page);
					if(!empty($r->items)){
							foreach($r->items as &$item){
									$item = $video_api->getVideoInfo($item['VideoID']);
							}
					}
					return $r;
			}
	}
	function pageAddListen($inPath){
			if(($User=user_api::islogin())!==false && !empty($_REQUEST['vid'])){
					$db = new user_db;
					$video_db = new video_db;
					$vid = singer_music::decode($_REQUEST['vid']);
					$api = new video_api;
					$v=$api->getVideo($vid);
					if(!empty($v) && ($r=$db->addListen(array("VideoID"=>$v['VideoID'],"UserID"=>$User['UserID'])))!==false){
							return true;
					}
			}
			return false;
	}
	function pageDelListen($inPath){
			if(($User=user_api::islogin())!==false){
					$db = new user_db;
					$UserID= $User['UserID'];
					$VideoID= singer_music::decode($_REQUEST['vid']);
					return $db->delListen($UserID,$VideoID);
			}
			return false;
	}
	/*获取曲库信息*/
	function pageGetMusic($inPath){
			$vid = singer_music::decode($_REQUEST['vid']);
			$video_api= new video_api;
			return $video_api->getVideoInfo($vid);
	}
	/**获取歌手信息和歌手歌曲列表*/
	function pageGetSinger($inPath){
			$sid = $_REQUEST['sid'];
			$video_api = new video_api;
			$sphinx_api = new sphinx_api;
			$r = new stdclass;
			$r->items = $sphinx_api->listBySingerID($sid);
			if(!empty($r->items)){
				foreach($r->items as &$item){
						$item = $video_api->getVideoInfoByLuceneVideo($item);
				}
			}
			return $r;
	}
	/**获取专辑信息*/
	function pageGetAlbum($inPath){
			//从搜索出数据
			$sid = $_REQUEST['sid'];
			$video_db= new video_db;
			$video_api = new video_api;
			$r = $video_db->listVideoByAlbumID($sid);
			if(!empty($r->items)){
					foreach($r->items as &$item){
							$item = $video_api->getVideoInfo($item['VideoID']);
					}
			}
			return $r;
	}
	/**
	 * 读取歌词
	 **/
	function pageGetLyric($inPath){
			$db = new video_db;
			$vid = singer_music::decode($_REQUEST['vid']);
			$api = new video_api;
			$mv  = $api->getVideoInfo($vid);
			if(!empty($mv)){
					$lyric = $db->getLyrics($mv['VideoID']);
					if(empty($lyric) || $lyric['LyricsStatus']==-2)
					{
						$api = new video_api;
						$k = (!empty($mv['Singers'][0]['SingerName'])?$mv['Singers'][0]['SingerName']." ":"").$mv['VideoName'];
						$content = $api->downlyric($k);
						if(empty($content))$content="";
						if(!empty($content)){
							$lyric['LyricsStatus']=1;
						}else{
							$lyric['LyricsStatus']=-1;
						}
						//这样只下载一次，避免被发现有问题
						$lyric = array();
						$lyric['LyricsContent']=$content;
						$lyric['LyricsOffset']=0;
						$lyric['UserID']=1;
						$lyric['VideoID']=$mv['VideoID'];
						$db->addLyrics($lyric);
					}
					return $lyric;
			}
			return array();
	}


	function pageSaveOffset($inPath){
			$VideoID= singer_music::decode($_REQUEST['VideoID']);
			$offset = $_REQUEST['offset'];
			if(empty($VideoID) || !isset($offset)){
					return;
			}
			$db = new video_db;
			$lyric = $db->getLyrics($VideoID);
			if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
					return;
			}
			$db->updateLyrics($VideoID,array("LyricsOffset"=>$offset));
			return true;
	}
	function pageLyricsError($inPath){
			$VideoID= singer_music::decode($_REQUEST['VideoID']);
			if(empty($VideoID)){
					return;
			}
			$db = new video_db;
			$lyric = $db->getLyrics($VideoID);
			if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
					return;
			}
			$db->updateLyrics($VideoID,array("LyricsStatus"=>-2));
			return true;
	}
	function pageComplete($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return "[]";
			$k = urlencode($k);
			$r = file_get_contents("http://tip.so.youku.com/search_keys?type=video&k=$k&limit=15");
			if($r){
				preg_match("/\[.*?\]/",$r,$_m);
				if(!empty($_m)){
						$keywords=array();
						$r = SJson::decode($_m[0]);
						if(!empty($r)){
								for($i=0;$i<count($r);$i++){
									$tmp = str_replace(array("mv","mtv"),"",$r[$i]->keyword);
									if(!empty($keywords[$tmp])){
										unset($r[$i]);
									}else{
										$keywords[$tmp]=1;
										$r[$i]->keyword=$tmp;
									}
								}
						}
						sort($r);
						return $r;
				}
			}
			return "[]";
	}
	function pageSearch($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return;
			$video_api = new video_api;
			
			$sphinx_api = new sphinx_api;
			$r = $sphinx_api->search($k,1000,$mustHaveSingers=true);
			if(!empty($r)){
					foreach($r as &$item){
						$item = $video_api->getVideoInfoByLuceneVideo($item);
					}
			}else{
					$r=$video_api->search($k);
			}
			return $r;
	}
	/*得到视频信息*/
	function pageGetVideo($inPath){
			$api = new video_api;
			$k = $_REQUEST['k'];
			return $api->getVideoInfoByURL($k);
	}
}
?>
