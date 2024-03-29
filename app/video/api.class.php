<?php
class video_api{
		/**
		 * 增加视频记录,普通增加
		 */
		function addVideo($Video){
				$video_db = new video_db;
				//加入到数据库里
				if($video_db->addVideo($Video)){
						$Video=$this->getVideoInfo($Video['VideoID']);
				}else{
						$video_db->updateVideo($Video['VideoID'],$Video);
						$Video=$this->getVideoInfo($Video['VideoID']);
				};
				return true;

		}
		/**
		 * 从数据库,或者API上获取视频
		 */
		function getVideoDuration($vid){
				$vid = singer_music::decode($vid);
				//从数据库里获取
				$video_db = new video_db;
				$v = $video_db->getVideo($vid);
				if(!empty($v) && empty($v['VideoDuration'])){
					$v= $this->__getVideoInfo($vid,false);
					$video_db->updateVideo($v['VideoID'],array("VideoDuration"=>$v['VideoDuration']));
				}
				return $v['VideoDuration'];
		}
		function getVideo($vid){
				$vid = singer_music::decode($vid);
				//从数据库里获取
				$video_db = new video_db;
				$Mv = $video_db->getVideo($vid);
				if(empty($Mv)){
					return  $this->__getVideoInfo($vid);
				}
				return $Mv;
		}
		/**
		 * 获取视频详细信息
		 */
		function getVideoInfo($vid){
			$v = $this->getVideo($vid);
			if(!empty($v)){
				if(!empty($v['SingerIDS'])){
					//获取歌手信息 
					$singer_db = new singer_db;
					$tmp=explode("/",$v['SingerIDS']);
					$singers=array();
					foreach($tmp as $id){
							$singers[]=$singer_db->getSinger($id);
					}
					$v['Singers']=$singers;
				}
				if(!empty($v['AlbumID'])){
					//获取专辑信息 
					$album_db=new album_db;
					$v['AlbumName']=$album_db->getAlbumName($v['AlbumID']);
				}
				if(!empty($v['VideoThumb'])){
					//换成大图
					$v['VideoThumb'] = str_replace("com/0","com/1",$v['VideoThumb']);
				}
			}
			return $v;
		}
		/**
		 * 补充 Video信息
		 */
		function getVideoInfoByLuceneVideo($v){
			if(!empty($v)){
				if(!empty($v['SingerIDS']) && !empty($v['SingerNameS'])){
					$ids = explode("/",$v['SingerIDS']);
					$names = explode("/",$v['SingerNameS']);
					$singers=array();
					foreach($ids as $i=>$id){
						$singers[]=array("SingerID"=>$id,"SingerName"=>$names[$i]);
					}
					$v['Singers']=$singers;
				}
				//时间转换
				$v['VideoPubdate']=substr($v['VideoPubdate'],0,4)."-".substr($v['VideoPubdate'],4,2)."-".substr($v['VideoPubdate'],6,2);
			}
			return $v;
		}
		/**
		 * 搜索
		 **/
		public function searchV3($key,$page=1,$size=10){
			$r = SHttp::get("https://openapi.youku.com/v2/searches/video/by_keyword.json",
					array(
						"client_id"=>"e8066412aa60d453",
						"keyword"=>$key,
						"count"=>$size,
						"page"=>$page,
					)
				);
			$r = SJson::decode($r);
			$o = array();
			foreach($r->videos as $item){
				$vid = $item->id;
				$db=new video_db;
				$vid = singer_music::decode($vid);
				$Video = $db->getVideo($vid);
				if(empty($Video)){
					//{{{
					$Video = array();
					$Video['VideoSourceID']=1;
					$Video['VideoName'] = $item->title;
					$Video['VideoDuration'] = $this->__strTotime($item->duration);
					$Video['VideoID'] = singer_music::decode($item->id);
					$Video['VideoThumb'] = $item->thumbnail;
					$Video['VideoPubDate'] = $item->published;
					$this->addVideo($Video);
					//}}}
				}
				$o[]=$Video;
			}
			
			$result=new stdclass;
			$result->page=$page;
			$result->pageSize=$size;
			$result->totalPage=ceil($r->total/$size);
			$result->total=$r->total;
			$result->items=$o;
			return $result;
		}
		public function search($key,$page=1,$size=10){
			$r = SHttp::get("http://api.youku.com/api_ptvideo/st_3_pid_XOA==",array("sv"=>$key,"rt"=>3,"ob"=>6,"pz"=>$size,"pg"=>$page));
			$r = SJson::decode($r);
			$o = array();
			foreach($r->item as $item){
				$vid = $item->videoid;
				$db=new video_db;
				$vid = singer_music::decode($vid);
				$Video = $db->getVideo($vid);
				if(empty($Video)){
					//{{{
					$Video = array();
					$Video['VideoSourceID']=1;
					$Video['VideoName'] = $item->title;
					$Video['VideoDuration'] = $this->__strTotime($item->duration);
					$Video['VideoID'] = singer_music::decode($item->videoid);
					$Video['VideoThumb'] = $item->snapshot;
					$Video['VideoPubDate'] = $item->pubDate;
					$this->addVideo($Video);
					//}}}
				}
				$o[]=$Video;
			}
			return $o;
		}
		private function __strTotime($str){
				$tmp = explode(":",$str);
				$len = count($tmp);
				$sec = $tmp[$len-1];
				$min = $tmp[$len-2];
				$hour=0;
				if($len>2)$hour=$tmp[$len-3];
				return $sec+$min*60+$hour*3600;
		}
		/**
		 * 从API上获取视频信息,获取一个视频信息
		 */
		private function __getVideoInfo($vid,$add=true){
			$url = "https://openapi.youku.com/v2/videos/show.json";
			$key = "video_id";
			$r = SHttp::get($url,
					array(
						"client_id"=>"e8066412aa60d453",
						$key=>$vid
						)
					);
			$r = SJson::decode($r);
			if(!empty($r)){
				$video = array();
				$video['VideoSourceID']=1;
				$video['VideoName'] = $r->title;
				$video['VideoDuration'] = $this->__strTotime($r->duration);
				$video['VideoID'] = singer_music::decode($r->id);
				$video['VideoThumb'] = $r->thumbnail;
				$video['VideoPubdate'] = $r->published;;
				if($add)$this->addVideo($video);
				return $video;
			}
		}
		/**
		 * 从API上获取信息,获取很多信息
		 */
		public function getVideoInfoByURL($k){
			$o = array();
			$k = $_REQUEST['k'];
			if(empty($k))return;
			if(preg_match("/\?f=(\\d*)/",$k,$_m)){
					//专辑播放页
					///v_show/id_XNDc5NjEyNTky.html?f=18551010
					$pid = $_m[1];
					$url = "https://openapi.youku.com/v2/playlists/videos.json";
					$key = "playlist_id";
			}elseif(preg_match("/v_show\/id_(.*?)\./",$k,$_m)){
					//普通视频播放页
					$pid = $_m[1];
					$url = "https://openapi.youku.com/v2/videos/show_batch.json";
					$key = "video_ids";
			}elseif(preg_match("/show_page\/id_(.*?)\./",$k,$_m)){
					//节目显示页
					$pid = $_m[1];
					$url = "https://openapi.youku.com/v2/shows/videos.json";
					$key = "show_id";
			}elseif(preg_match("/playlist_show\/id_(\\d*)/",$k,$_m)){
					//专辑显示页
					$pid = $_m[1];
					$url = "https://openapi.youku.com/v2/playlists/videos.json";
					$key = "playlist_id";
			}elseif(preg_match("/f\=(\\d*)/",$k,$_m)){
					//专辑播放页
					//v_playlist/f5358637o1p1.html
					$pid = $_m[1];
					$url = "https://openapi.youku.com/v2/playlists/videos.json";
					$key = "playlist_id";
			}
			$pageSize=10;
			$r = SHttp::get($url,
					array(
						"client_id"=>"e8066412aa60d453",
						$key=>$pid,
						"count"=>$pageSize,
						"page"=>1,
						)
					);
			if(!empty($r)){
					$r = SJson::decode($r);
					$totalPage=1;
					if(!empty($r->total) && !empty($r->total)){
							$totalPage = ceil($r->total / $pageSize);
					}
					if($totalPage>1){
						for($i=2;$i<=$totalPage;$i++){
							$r2 = SHttp::get($url,
									array(
										"client_id"=>"e8066412aa60d453",
										$key=>$pid,
										"count"=>$pageSize,
										"page"=>$i,
										)
									);
							$r2 = SJson::decode($r2);
							if(!empty($r2))$r->videos=array_merge($r->videos,$r2->videos);
						}
					}
					foreach($r->videos as $item){
						$vid = singer_music::decode($item->id);
						$video_db = new video_db;
						$video = $video_db->getVideo($vid);
						if(empty($video)){
							$video = array();
						}

						$video['VideoSourceID']=1;
						$video['VideoName'] = $item->title;
						$video['VideoDuration'] = $this->__strTotime($item->duration);
						$video['VideoID'] = singer_music::decode($item->id);
						$video['VideoThumb'] = $item->thumbnail;
						$video['VideoPubdate'] = $item->published;
						$video_db->addVideo($video,true);
						$o[]=$video;
					}
			}
			return $o;
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
						"/超清/",
						"/HD/",
						"/乐队/",
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
			//error_log($MvName,3,"/tmp/x.log");
			$MvName=urlencode($MvName);
			/* v1
			$r = SHttp::get("http://mp3.sogou.com/api/lrc2?query=$MvName&id=1");
			preg_match('/lrc":"(.+?)","/ims',$r,$_m);
			if(!empty($_m[1])){
					return mb_convert_encoding($_m[1],"utf8","gbk,utf8");
			}
			*/
			// v2 
			$r = SHttp::get("http://music.baidu.com/search/lrc?key=$MvName");
			preg_match("/down\-lrc\-btn \{ 'href'\:'(.+?)'/ims",$r,$_m);
			if(!empty($_m[1])){
				$url = 'http://music.baidu.com'.$_m[1];
				$ct = SHttp::get($url);
				return trim(mb_convert_encoding($ct,"utf8","gbk,utf8"));
			}
		}
}
