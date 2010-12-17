<?php
class player_api{
		function getVideoInfo($vid){
			$r = SHttp::get("http://api.youku.com/api_ptvideoinfo",array("pid"=>"XOA==","rt"=>3,"id"=>$vid));
			$r = SJson::decode($r);
			$v = new stdclass;
			if(!empty($r->item->title)){
				$v->title = $r->item->title;
				$v->seconds= $r->item->duration;
				if(preg_match("/v_show\/id_(.*?)\./",$r->item->playlink,$_m)){
						$v->vid = $_m[1];
				}
			}
			return $v;
		}
		function downlyric($MvName){
			//关键字过滤
				$pattern = array(
						"/主打歌/",
						"/高清版/",
						"/演唱会/",
						"/无字幕/",
						"/珍藏版/",
						"/字幕版/",
						"/有字幕/",
						"/新春演唱会/",
						"/优酷首播音乐/",
						"/演唱会/",
						"/拍客/",
						"/猴姆独家/",
						"/完整版/",
						"/主题曲/",
						"/MV/i",
						"/高清/",
						"/视频/",
						"/专辑/",
						"/主打/",
						"/现场/",
						"/原版/",
						"/正式/",
						"/官方/",
						"/DJ/",
						"/演出版/",
						"/杨晃/",
						"/独家/",
						"/1080p/i",
						"/DVD/i",
						"/SXS/i",
						"/\-/",
						"/\_/",
						"/【/",
						"/】/",
						"/《/",
						"/》/",
						"/\</",
						"/\>/",
						"/\(/",
						"/\)/",
						"/\{/",
						"/\}/",
				);
			$replacement= array(
				" ",
			);
			$MvName = preg_replace($pattern,$replacement,$MvName);
			$MvName= mb_convert_encoding($MvName,"gbk","utf8,gbk");
			$r = SHttp::get("http://mp3.sogou.com/lyric.so",array("query"=>$MvName,"class=3","w=0"));
			preg_match_all("/downlrc\.jsp(.+?)\"/",$r,$_m);
			if(!empty($_m[0][0])){
					$r = SHttp::get("http://mp3.sogou.com/".$_m[0][0]);
					return mb_convert_encoding($r,"utf8","gbk,utf8");
			}
		}
}
