<?php
class player_main extends SGui{
	function __construct(){
		//echo $this->render("head.tpl");
	}
	function __destruct(){
		//echo $this->render("footer.tpl");
	}
	function pageQQ($inPath){
			return $this->pageEntry($inPath,1);
	}
	function pageFaceBook($inPath){
			return $this->pageEntry($inPath,1);
	}
	function pageRenren($inPath){
			return $this->pageEntry($inPath,1);
	}
	function pageEntry($inPath,$facebook=0){
		$param=array();
		if(!empty($facebook)){
			$param=array("facebook"=>1);
		}
		$param['jsversion']=filemtime(WWW_ROOT."/"."assets/js/youku.ws.js");
		$param['cssversion']=filemtime(WWW_ROOT."/"."assets/css/styleV2.css");
		return $this->render("player/playerV2.tpl",$param);
	}
	function pageHeader($inPath){
			$param = array();
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
		echo $this->render("player/headerV2.tpl",$param);
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
					$result->result= $db->addVideoExtension(array("$fileds=1","VideoID"=>$inPath[4]));
				}else{
					$result->result= $db->updateVideoExtension($inPath[4],array("$fileds=$fileds+1"));
				}
				$result->type=$inPath[3];
				if(($User=user_api::islogin())!==false){
						$user_db = new user_db;
						$record=$user_db->addAction(array("UserID"=>$User['UserID'],"VideoID"=>$inPath[4],"ActionType"=>$actiontype));
						if($record==1){
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
	function pageRadioList($inPath){
		$db = new user_db;
		return $db->ListRadioList();
	}
	function pageRadio($inPath){
			$chanelId=empty($_REQUEST['cid'])?2:$_REQUEST['cid'];

			$user_db = new user_db;
			$video_api = new video_api;

			$r = $user_db->listContentRand($chanelId);

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
				return $api->getVideoByVid($vid);
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
					return $r;
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
			if(($User=user_api::islogin())!==false){
					$db = new user_db;
					$video_db = new video_db;
					$vid = singer_music::decode($_REQUEST['vid']);
					$api = new video_api;
					$v=$api->getVideo($vid);
					if(!empty($v) && ($r=$db->addListen(array("VideoID"=>$v['VideoID'],"UserID"=>$User['UserID'])))===1){
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
			$search_api = new search_api;
			$r = new stdclass;
			$r->items = $search_api->query("SingerIDS:$sid");
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
			$mv  = $api->getVideo($vid);
			if(!empty($mv)){
					$lyric = $db->getLyrics($mv['VideoID']);
					if(empty($lyric) || $lyric['LyricsStatus']==-2)
					{
						$api = new video_api;
						$content = $api->downlyric($mv['VideoName']);
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
			$r = file_get_contents("http://tip.so.youku.com/search_keys?type=video&k=$k&limit=10");
			if($r){
				preg_match("/\[.*?\]/",$r,$_m);
				if(!empty($_m)){
						return $_m[0];
				}
			}
			return "[]";
	}
	function pageSearch($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return;
			$video_api = new video_api;

			$search_api = new search_api;
			$r = $search_api->search($k,30,true);
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
