<?php
exit;
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$specials = $db->listSpecial(1,-1);
foreach($specials->items as $special){
		//preg_match("/_(.+?)\.html/i",$singer['_TmpUrl'],$_m);
		$url = $special['_TmpUrl'];
		$content = file_get_contents($url);
		//得到专辑信息
			//语言
			preg_match("/language(.+?)dl/ims",$content,$_m);
			preg_match("/dd\>(.+?)\</ims",$_m[0],$_m2);
			$special['SpecialLanguage']=trim($_m2[1]);
			//
			preg_match("/pubdate(.+?)dl/ims",$content,$_m);
			preg_match("/dd\>(.+?)\</ims",$_m[0],$_m2);
			$special['SpecialPubDate']=trim(strip_tags($_m2[1]));
			//
			preg_match("/class\=\"style\"(.+?)dl/ims",$content,$_m);
			preg_match("/dd\>(.+?)dd/ims",$_m[0],$_m2);
			$special['SpecialStyle']=trim(strip_tags($_m2[1]));
			//
			preg_match("/class\=\"company\"(.+?)dl/ims",$content,$_m);
			preg_match("/dd\>(.+?)dd/ims",$_m[0],$_m2);
			$special['SpecialCompany']=trim(strip_tags($_m2[1]));
			//
			preg_match("/class\=\"description\"\>(.+?)\<\/div\>/ims",$content,$_m);
			//preg_match("/dd\>(.+?)dd/ims",$_m[0],$_m2);
			$special['SpecialComment']=trim(strip_tags($_m[1]));
			$special['_Finished']=1;
			//
			preg_match("/class\=\"albumPic(.+?)\<\/div\>/ims",$content,$_m);
			preg_match("/src=\"(.+?)\"/ims",$_m[0],$_m2);
			$special['_TmpSpecialCover']=trim(strip_tags($_m2[1]));
			//下载图片
			//TODO
			$special['_Finished']=1;
			$db->updateSpecial($special);
			print_r($special);
		//得到歌曲
			preg_match("/class\=\"songList\">(.+?)\<\/table\>/ims",$content,$_m);
			preg_match_all("/class\=\"songName.+?>(.+?)\<\/a\>/ims",$_m[0],$_m2);
			//print_r($_m);
			//$songs=array();
			foreach($_m2[1] as $m){
					$musicname = trim(strip_tags($m));
					$music=array();
					$music['SingerID']=$special['SingerID'];
					$music['SpecialID']=$special['SpecialID'];
					$music['MusicPubdate']=$special['SpecialPubDate'];
					$music['MusicName']=$musicname;
					$db->addMusic($music);
			}
		usleep(3);
}
