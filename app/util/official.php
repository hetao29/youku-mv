<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
include("ChineseSpellUtils.php");
$spell = new ChineseSpell;
function listVideoFromOfficial($startTime){
		$startTime = str_replace("-","",$startTime);
		$startTime = str_replace(" ","",$startTime);
		$startTime = str_replace(":","",$startTime);
		$now = date("YmdHis");
		$params['q']="showcategory:音乐 completed:1 showlastupdate:$startTime-$now";
		$params['fd']="showname show_thumburl mv_type mv_genre singer showlastupdate firstepisode_videoid releasedate area singertype language album";
		$params['pn']="1";
		$params['pl']="1000";
		$params['ob']="showlastupdate:asc";
		$params['ft']="json";
		$params['cl']="test_page";
		$params['h']="3";
		$url = "http://10.103.12.71/show.show";
		$r = SHttp::get($url,$params);
		$r = SJson::decode($r);
		return $r;
}
$log="official.log";
define("DEBUG",true);

while(true){
	$logData = trim(file_get_contents($log));
	$startTime=0;$startVideoID=0;
	if(!empty($logData)){
			$tmp = explode("/",$logData);
			$startTime=trim($tmp[0]);
			$startVideoID=trim($tmp[1]);
	}
	echo "START FROM $startTime / $startVideoID\n";
	$r = listVideoFromOfficial($startTime);
	$singer_db = new singer_db;
	$album_db = new album_db;
	$video_api = new video_api;
	if(empty($r->results) || count($r->results)<10){
			die("OVER\n");
	}
	foreach($r->results as $v){
			if(empty($v->firstepisode_videoid))continue;
			$Video=array();
			$Video['VideoName']		=$v->showname;
			$Video['VideoThumb']	=$v->show_thumburl;
			$Video['VideoID']		=$v->firstepisode_videoid;
			$Video['VideoPubdate']	=$v->releasedate;
			$Video['VideoDuration']	=0;
	
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
			if(!empty($v->album)){
				$Album = $album_db->getAlbumByName($v->album,$Video['SingerIDS']);
				if(empty($Album)){
						$Album['SingerIDS'] = $Video['SingerIDS'];
						$Album['AlbumName'] = $v->album;
						echo "add album\n";
						print_r($Album);
						$Album['AlbumID'] = $album_db->addAlbum($Album);
				}
				$Video['AlbumID'] = $Album['AlbumID'];
			}
			$Video['VideoStatus']	=1;
			print_r($v);
			print_r($Video);
			if($video_api->addVideo($Video)){
					$video_api->getVideoDuration($Video['VideoID']);//更新时间 
					echo $Video['VideoID']." ".$v->showlastupdate." Success\n";
			};
			unset($Video);
			file_put_contents($log,$v->showlastupdate."/".$v->firstepisode_videoid);
	}
}
