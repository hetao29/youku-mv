<?php
exit;
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
//$api = new player_api;
//$end  =$db->getMvCount();
//华语男歌手
$w = base64_decode("MXRpbmc=");
$url="http://www.$w.com/group/group7_0.html";
$type=99;
$content = file_get_contents($url);
//preg_match_all("/href=\"\/singer*?\"*?\>(.*?)\<\/a\>/im",$content,$_m);
preg_match_all("/href=\"\/singer([^\"]+?)\">(.+?)\<\/a\>/im",$content,$_m);
foreach($_m[1] as $key=>$url){
		$url="http://www.1ting.com/singer".$url;
		$name=trim($_m[2][$key]);
		$Singer=array("SingerName"=>$name,"_TmpUrl"=>$url,"SingerType"=>$type);
		$db->addSinger($Singer);
		echo $name.":".$url."\n";
}
