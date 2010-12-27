<?php
class player_main extends SGui{
	function __construct(){
		//echo $this->render("head.tpl");
	}
	function __destruct(){
		//echo $this->render("footer.tpl");
	}
	function pageFaceBook($inPath){
			return $this->pageEntry($inPath,1);
			try{
			$book = new player_facebook;
			}catch(Exception $e){
					print_r($e);
			}
	}
	function pageEntry($inPath,$facebook=0){
		$param=array();
		if(!empty($facebook)){
			$param=array("facebook"=>1);
		}
		echo $this->render("player/playerV2.tpl",$param);
	}
	function pageHeader($inPath){
			$param = array();
			if(!empty($_SESSION['user'])){
					$param['user'] = $_SESSION['user'];
			}
		echo $this->render("player/headerV2.tpl",$param);
	}
	function pageRadio($inPath){
			//$result = new stdclass;
			$db = new player_db;
			$mvid = $_REQUEST['mvid'];
			$result=array();
			$mvid++;
			$result[] = $db->getMv($mvid);
			$mvid++;
			$result[] = $db->getMv($mvid);
			return $result;
			//电台频道
			//0表示私有频道，其它表示频道ID，甚至包括电视频道
			$chanelId= empty($_REQUEST['cid'])?0:$_REQUEST['cid'];
			//视频ID，当前的视频ID
			$vid = $_REQUEST['vid'];
			//如果是登录用户，在s_user_listen中找出不是这个用户听过的最新的歌，如果没有，就去s_mv 中找
			//同时算出相互喜欢歌
			//1.听过些歌的人，还听这的一些歌
			//2.喜欢过这首歌的人，还听过的，和喜欢的
			//同时不能包含用户不喜欢的歌
			//如果没有登录的用户，在s_user_listen中找出不是当前歌的歌
			$userid = 0;
			if(($User=user_api::islogin())!==false){
					$userid = $User['UserID'];
			}
	}
	/**
	 * 增加MV
	 * @param $MvName
	 * @param $MvVideoID (url)
	 * @param [$MvListID]
	 */

	function pageAddMv($inPath){
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
			return $Mv;
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
	function pageSaveOffset($inPath){
			$MvID= $_REQUEST['MvID'];
			$offset = $_REQUEST['offset'];
			if(empty($MvID) || empty($offset)){
					return;
			}
			$db = new player_db;
			$lyric = $db->getLyrics($MvID);
			if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
					return;
			}
			$db->updateLyrics($MvID,array("LyricsOffset"=>$offset));
			return true;
	}
	function pageLyricsError($inPath){
			$MvID= $_REQUEST['MvID'];
			if(empty($MvID)){
					return;
			}
			$db = new player_db;
			$lyric = $db->getLyrics($MvID);
			if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
					return;
			}
			$db->updateLyrics($MvID,array("LyricsStatus"=>-2));
			return true;
	}
	function pageAddListen($inPath){
			if(($User=user_api::islogin())!==false){
					$db = new user_db;
					$player_db = new player_db;
					$vid = $_REQUEST['vid'];
					$mv = $player_db->getMvByVid($vid);
					if(empty($mv)){
						$tmpmv  = $this->pageAddMv($inPath);
						$mv 	= $player_db->getMvByVid($tmpmv['MvVideoID']);
					}
					return $db->addListen(array("MvID"=>$mv['MvID'],"UserID"=>$User['UserID']));
			}
	}
	/**
	 * 读取歌词
	 **/
	function pageGetLyric($inPath){
			$vid = $_REQUEST['vid'];
			$db = new player_db;
			$mv  = $db->getMvByVid($vid);
			if(empty($mv)){
					$tmpmv  = $this->pageAddMv($inPath);
					$mv 	= $db->getMvByVid($tmpmv['MvVideoID']);
			}
			if(!empty($mv)){
					$lyric = $db->getLyrics($mv['MvID']);
					if(empty($lyric) || $lyric['LyricsStatus']==-2)
					{
						$api = new player_api;
						$content = $api->downlyric($mv['MvAlias']);
						if(empty($content))$content="";
						//if(!empty($content)){
						//这样只下载一次，避免被发现有问题
						$lyric = array();
						$lyric['LyricsContent']=$content;
						$lyric['LyricsOffset']=0;
						$lyric['UserID']=1;
						$lyric['LyricsStatus']=-1;
						$lyric['MvID']=$mv['MvID'];
						$db->addLyrics($lyric);
						//}
					}
					return $lyric;
			}
			return array();
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
					$r = player_api::getVideoInfo($_m[1]);
					$o = new stdclass;
					$o->items=array();
					$o->items[]=$r;
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
