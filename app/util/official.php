<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
include("ChineseSpellUtils.php");
$spell = new ChineseSpell;
function listVideoFromOfficial($start,$end){
		$params['q']="singertype:男,女,乐队,组合,群星 showid:0 category:音乐 state:normal videoid:$start-$end";
		$params['fd']="releasedate mv_type mv_genre singertype publishtime thumburl singertype videoid singer language title category state seconds tags area";
		$params['pl']="100";
		$params['ob']="videoid:desc";
		$params['ft']="json";
		$params['cl']="test_page";
		$params['h']="3";
		$url = "http://10.103.12.71/video.dvd";
		$result=array();
		$page=1;
		do{
			$params['pn']=$page++;
			sleep(1);
			$r = SHttp::get($url,$params);
			$r = SJson::decode($r);
			if(!empty($r->results)){
				$result=array_merge($result,$r->results);
			}
			//print_r($r);
			echo "CT:";
			echo count($result);
			echo "\n";
		//print_r($r);
		//if($xx++==2)exit;
			//if($xx++==2){print_r($result);exit;}
		}while(count($result)<$r->total);

		//print_r($result);
		return $result;
		//print_r($r);
		//return $r;
}
$start=0;
$maxvid=0;
$end=1687000;

$iii=0;
while($iii++<1000)
{
	$log = "official.log";
	$logData = trim(file_get_contents($log));
	if(!empty($logData)){
		$tmp = explode("/",$logData);
		$start=trim($tmp[0]);
		$end=trim($tmp[1]);
	}
	echo "\n\nSTART FROM $start/ $end\n\n";

	$r = listVideoFromOfficial($start,$end);
	if(count($r)<=1){die("\n\n EMPTY DATA\n");}


	foreach($r as $v){
		$start=max($start,$v->pk_video);
		$singer_db = new singer_db;
		$album_db = new album_db;
		$video_db = new video_db;
			//if(empty($v->firstepisode_videoid))continue;
			$Video=array();
			$Video['VideoName']		=$v->title;
			$Video['VideoThumb']	=$v->thumburl;
			$Video['VideoID']		=$v->pk_video;
			if(!empty($v->releasedate)){
				$Video['VideoPubdate']	=$v->releasedate;
			}else{
				$Video['VideoPubdate']	=$v->publishtime;
			}
			$Video['VideoDuration']	=$v->seconds;
	
			if(!empty($v->area)) $Video['VideoArea']		=$v->area[0];
			if(!empty($v->language)) $Video['VideoLanguage']	=$v->language[0];
			$singerids=array();
			if(!empty($v->singer)){
					foreach($v->singer as $s){
							$Singer=$singer_db->getSingerByName($s->name);
							if(empty($Singer)){
									$Singer=array();
									$Singer['SingerName']=$s->name;
									$Singer['SingerNamePinYin']=$spell->getFullSpell(mb_convert_encoding($s->name,"gbk","utf8"));
									if(count($v->singer)==1){
											$Singer['SingerGender']=$v->singertype[0];
									}
									echo "add singer\n";
									print_r($Singer);
									$Singer['SingerID']=$singer_db->addSinger($Singer);
							}
							$singerids[]=$Singer['SingerID'];
					};
			}
			$styles=array();
			foreach($v->mv_type as $mv_type){
					$mv_type = str_replace("音乐","",$mv_type);
					$mv_type = str_replace("MV","",$mv_type);
					if(!empty($mv_type)){
							$styles[]=$mv_type;
					}
			}
			if(!empty($v->mv_genre)) $styles=array_merge($styles,$v->mv_genre);
			$Video['VideoStyle']	=implode("/",$styles);
			if(!empty($singerids)){
				sort($singerids);
				$Video['SingerIDS']	=implode("/",$singerids);
			}else{
				$Video['SingerIDS']	=0;
			}
			$Video['AlbumID']	=0;
			//if(!empty($v->album)){
			//	$Album = $album_db->getAlbumByName($v->album,$Video['SingerIDS']);
			//	if(empty($Album)){
			//			$Album['SingerIDS'] = $Video['SingerIDS'];
			//			$Album['AlbumName'] = $v->album;
			//			echo "add album\n";
			//			print_r($Album);
			//			$Album['AlbumID'] = $album_db->addAlbum($Album);
			//	}
			//	$Video['AlbumID'] = $Album['AlbumID'];
			//}
			$Video['VideoStatus']	=1;
			//print_r($v);
			//print_r($Video);
			if($video_db->addVideo($Video)!==false){
					echo $Video['VideoID']." ".$v->title." Success\n";
			}else{
				$up=array();
				$up['VideoPubdate']=$Video['VideoPubdate'];
				$up['VideoStyle']=$Video['VideoStyle'];
				$up['VideoDuration']=$Video['VideoDuration'];
				$up['VideoLanguage']=$Video['VideoLanguage'];
				$up['VideoArea']=$Video['VideoArea'];
				$video_db->updateVideo($Video['VideoID'],$up);
					echo $Video['VideoID']." ".$v->title." Update Success\n";
				
			};
			unset($Video);
			unset($singer_db);
			unset($album_db) ;
			unset($video_db) ;
	}
	$end=$start+1000000;
	file_put_contents($log,$start."/".$end);
	sleep(10);
}
