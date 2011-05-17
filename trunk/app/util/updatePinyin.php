<?php
//这个文件要没有用了,更新歌手的时候自动更新了
exit;
//更新s_singer.SingerPinyin里的数
chdir(dirname(__FILE__));
include("ChineseSpellUtils.php");
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$singers = $db->listsinger(1,-1);
$spell = new ChineseSpell;
foreach($singers->items as $singer){

		if(empty($singer['SingerNamePinYin'])){
			$singer['SingerNamePinYin'] = $spell->getFullSpell(mb_convert_encoding($singer['SingerName'],"gbk","utf8"));
			$db->updateSiger($singer);
		}
}
