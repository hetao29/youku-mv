<?php
//更新s_singer.MvCount里的数
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$datas = $db->listMusicMv(1,-1);
foreach($datas->items as $data){
		if($data['VideoID']==0){
			$data['VideoID']=singer_music::decode($data['MvVideoID']);
			$db->updateMusicMv($data);
		}
		print_r($data);
		continue;
//		echo $ct;exit;
//		if($music['SingerType']==9 || $music['SingerType']==99){
//			$k=$music['MusicName'];
//		}else{
//			$k=$music['SingerName']." ".$music['MusicName'];
//		}
//		print_r($music);
//		//$k="我爱你-中国娃娃";
//		$r = SHttp::get("http://api.youku.com/api_ptvideo/st_3_pid_XOA",array("sv"=>$k,"rt"=>3,"ob"=>6,"pz"=>5,"pg"=>1));
//		$r = SJson::decode($r);
//		$tmp_music=array();
//		$tmp_music['_Finished']=-1;
//		if(!empty($r->item)){
//				$tmp_music['_Finished']=1;
//				foreach($r->item as $tmp){
//						$mv=array();
//						$mv['MusicID']=$music['MusicID'];
//						$mv['MvVideoID']=$tmp->videoid;
//						$mv['title']=$tmp->title;
//						$mv['snapshot']=$tmp->snapshot;
//						$mv['duration']=$tmp->duration;
//						$mv['author']=$tmp->author;
//						$mv['pubDate']=$tmp->pubDate;
//						$mv['pv']=$tmp->pv;
//						$db->addMusicMv($mv);
//				}
//		}
//		$tmp_music["MusicID"]=$music['MusicID'];
//		$db->updateMusic($tmp_music);
//		usleep(300);
}
