<?php
/*初始化s_music 的默认视频*/
exit;
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$musics = $db->listMusic2(1,-1);
foreach($musics->items as $music){
		echo $music['MusicID']."\n";
		$videos = $db->listMusicVideo($music['MusicID']);
		if(!empty($videos->items)){
				$music['VideoID']=$videos->items[0]['VideoID'];
		}
		$db->updateMusic($music);
}
