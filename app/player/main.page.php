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
			$k = $_REQUEST['q'];
			if(empty($k))return "{}";
			$k = urlencode($k);
			$r = file_get_contents("http://tip.so.youku.com/search_keys?type=video&k=$k&limit=10");
			if($r===false){
					return "{}";
			}
			return $r;
	}
	function pageSearch($inPath){
			$k = $_REQUEST['k'];
			if(empty($k))return;
			$r = file_get_contents("http://www.youku.com/api_ptvideo/st_3_pid_XOA?sv=$k&rt=3&ob=6&pz=10&pg=1");
			return $r;
	}
}
?>
