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
						"/MV/i",
						"/高清/",
						"/\-/",
						"/【/",
						"/】/",
				);
				$replacement= array(
						"",
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
