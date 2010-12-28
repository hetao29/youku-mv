<?php
class player_api{
		function getVideoInfo($vid){
			$r = SHttp::get("http://api.youku.com/api_ptvideoinfo",array("pid"=>"XOA==","rt"=>3,"id"=>$vid));
			$r = SJson::decode($r);
			$v = new stdclass;
			if(!empty($r->item->title)){
				$v->title = $r->item->title;
				$v->pic = $r->item->imagelink;
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
						"/繁体字/",
						"/倾情出演/",
						"/倾情演出/",
						"/演绎/",
						"/高清版/",
						"/演唱会/",
						"/作品/",
						"/翻唱/",
						"/无字幕/",
						"/珍藏版/",
						"/高音质/",
						"/字幕版/",
						"/正式版/",
						"/现场版/",
						"/有字幕/",
						"/新春演唱会/",
						"/优酷首播音乐/",
						"/优酷/",
						"/演唱会/",
						"/拍客/",
						"/猴姆独家/",
						"/完整版/",
						"/台湾版/",
						"/歌词/",
						"/主题曲/",
						"/MV/i",
						"/MTV/i",
						"/YOUKU/i",
						"/KTV/i",
						"/FLV/i",
						"/高清/",
						"/新专辑/",
						"/新单/",
						"/网络歌曲/",
						"/单曲/",
						"/视频/",
						"/首播/",
						"/专辑/",
						"/老歌/",
						"/试听/",
						"/首发/",
						"/新歌/",
						"/天籁之声/",
						"/插曲/",
						"/主打/",
						"/现场/",
						"/原版/",
						"/正式/",
						"/官方/",
						"/DJ/",
						"/演出版/",
						"/杨晃/",
						"/心月/",
						"/【茹】/",
						"/【天籁之音】/",
						"/FM首播/",
						"/独家/",
						"/最新/",
						"/1080p/i",
						"/DVD/i",
						"/SXS/i",
						"/\-/",
						"/\_/",
						"/\:/",
						"/\：/",
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
						"/『/",
						"/』/",
						"/！/",
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
