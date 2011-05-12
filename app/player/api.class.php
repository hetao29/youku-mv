<?php
class player_api{
		function getMvByVid($vid){
				$vid = singer_music::decode($vid);
				$player_db = new player_db;
				$Mv = $player_db->getMvByVid($vid);
				if(empty($Mv)){
					$Mv = array();
					$Mv['MvSourceID']=1;
					switch($Mv['MvSourceID']){
						case 1:
							$video = $this->getVideoInfo($vid);
						break;
					}
					if(!empty($video)){
						$Mv['MvName'] = $Mv['MvAlias']=$video->title;
						$Mv['MvSeconds'] = $video->seconds;
						$Mv['VideoID'] = singer_music::decode($video->vid);
						$Mv['MvPic'] = $video->pic;
						$Mv['MvPubDate'] = $video->pubdate;
					}
					$Mv['UserID'] = 1;//我自己,TODO
					$player_db->addMv($Mv);
				}
				return $Mv;
		}
		function getVideoInfo($vid){
			$r = SHttp::get("http://api.youku.com/api_ptvideoinfo",array("pid"=>"XOA==","rt"=>3,"id"=>$vid));
			$r = SJson::decode($r);
			$v = new stdclass;
			if(!empty($r->item->title)){
				$v->title = $r->item->title;
				$v->pic = $r->item->imagelink;
				$v->pubdate= $r->item->pubdate;
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
						"/动人/",
						"/倾情出演/",
						"/倾情演出/",
						"/演绎/",
						"/高清版/",
						"/演唱会/",
						"/作品/",
						"/翻唱/",
						"/无字幕/",
						"/字幕/",
						"/字幕/",
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
						"/糖果盒子/",
						"/台湾版/",
						"/歌词/",
						"/主题曲/",
						"/MV/i",
						"/MTV/i",
						"/YOUKU/i",
						"/KTV/i",
						"/FLV/i",
						"/高清/",
						"/全新/",
						"/演绎/",
						"/新专辑/",
						"/101231/",
						"/给力2011跨年演唱会/",
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
						"/韩国/",
						"/插曲/",
						"/主打/",
						"/现场/",
						"/原版/",
						"/国语/",
						"/正式/",
						"/官方/",
						"/DJ/",
						"/演出版/",
						"/杨晃/",
						"/心月/",
						"/当红新人/",
						"/新人/",
						"/【.*】/",
						"/[.*]/",
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
			$MvName=urlencode($MvName);
			$r = SHttp::get("http://mp3.sogou.com/api/lrc2?query=$MvName&id=1");
			preg_match('/lrc":"(.+?)","/ims',$r,$_m);
			if(!empty($_m[1])){
					return mb_convert_encoding($_m[1],"utf8","gbk,utf8");
			}
		}
}
