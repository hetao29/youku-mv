<?php
exit;
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$start=1;
$db = new player_db;
$api = new player_api;
$end  =$db->getMvCount();
for($i=$start;$i<=$end;$i++){
		$mv = $db->getMv($i);
		if(!empty($mv) && empty($mv['MvPic'])){
			$vid = $mv['MvVideoID'];
			$video = $api->getVideoInfo($vid);
			if(!empty($video->pic)){
					echo $mv['MvID']."\n";
					$db->updateMv($mv['MvID'],array("MvPic"=>$video->pic));
			}
		}

}
