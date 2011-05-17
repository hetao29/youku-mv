<?php
exit;
//更新歌手列表,可以5天执行一次
//1.importsinger.php
//2.importspecial.php
//3.importmusic.php
chdir(dirname(__FILE__));
include("../../global.php");
include("ChineseSpellUtils.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$spell = new ChineseSpell;
//华语男歌手
$w = base64_decode("MXRpbmc=");
$data=array(
	1 =>"http://www.$w.com/group/group0_1.html",
	2 =>"http://www.$w.com/group/group0_2.html",
	3 =>"http://www.$w.com/group/group0_3.html",
	4 =>"http://www.$w.com/group/group3_14.html",
	5 =>"http://www.$w.com/group/group3_15.html",
	6 =>"http://www.$w.com/group/group3_16.html",
	7 =>"http://www.$w.com/group/group5_0.html",
	8 =>"http://www.$w.com/group/group4_0.html",
	9 =>"http://www.$w.com/group/group6_0.html",
	99=>"http://www.$w.com/group/group7_0.html",
);
foreach($data as $type=>$url){
	$content = file_get_contents($url);
	preg_match_all("/href=\"\/singer([^\"]+?)\">(.+?)\<\/a\>/im",$content,$_m);
	foreach($_m[1] as $key=>$url){
			$url="http://www.$w.com/singer".$url;
			$name=trim($_m[2][$key]);
			$Singer=array(
					"SingerName"=>$name,
					"SingerNamePinYin"=>$spell->getFullSpell(mb_convert_encoding($name,"gbk","utf8")),
					"_TmpUrl"=>$url,"SingerType"=>$type
			);
			if($db->addSinger($Singer)){
				echo $name.":$type\n";
			}
	}
}
