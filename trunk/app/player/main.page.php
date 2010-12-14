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
