<?php
echo '<?xml version="1.0" encoding="utf-8"?>
<sphinx:docset>

<sphinx:schema>
	<sphinx:field name="albumname"/> 
	<sphinx:field name="videoname"/> 
	<sphinx:field name="singernames"/> 
	<sphinx:field name="videolanguage"/> 
	<sphinx:field name="videostyle"/> 
	<sphinx:field name="videoarea"/> 

	<sphinx:attr name="videoid" type="int"/> 
	<sphinx:attr name="videoname" type="string"/> 
	<sphinx:attr name="singernames" type="string"/> 
	<sphinx:attr name="videolanguage" type="string"/> 
	<sphinx:attr name="videostyle" type="string"/> 
	<sphinx:attr name="videoarea" type="string"/> 
	<sphinx:attr name="albumname" type="string"/> 
	<sphinx:attr name="singerids" type="multi"/> 
	<sphinx:attr name="albumid" type="int"/> 
	<sphinx:attr name="videothumb" type="string"/> 
	<sphinx:attr name="videopubdate" type="int"/> 
	<sphinx:attr name="videoduration" type="int"/> 
	<sphinx:attr name="videostatus" type="float"/> 
</sphinx:schema>';
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
$log="sphinx.xmlpipe.log";
$db = new video_db;
$video_api = new video_api;
$logData = trim(@file_get_contents($log));
$startTime=0;$startVideoID=0;
if(!empty($logData)){
		$tmp = explode("/",$logData);
		$startTime=trim($tmp[0]);
		$startVideoID=trim($tmp[1]);
}
//echo "START FROM $startTime / $startVideoID\n";
$singer_db = new singer_db;
$tmp = $singer_db->listSinger(1,-1);
$singers=array();
foreach($tmp->items as $item){
		$id = $item['SingerID'];
		$singers[$id]=$item;
}
unset($tmp);

$album_db = new album_db;
$tmp = $album_db->listAlbum(1,-1);
$albums=array();
foreach($tmp->items as $item){
		$id = $item['AlbumID'];
		$albums[$id]=$item;
}
unset($tmp);

$i=0;
$total=0;
function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
}
$t = microtime_float();
$pageSize=2000;
if(empty($startVideoID)){
	$videos = $db->listVideo($startVideoID,$pageSize,$page=1);
}else{
	$videos = $db->listVideoByTime($startTime,$pageSize,$page=1);
}
$totalPage = $videos->totalPage;
//error_log(var_export($videos,true),3,"/tmp/x.log");
for($page=1;$page<=$totalPage;$page++){
	if(empty($startVideoID)){
		$videos = $db->listVideo($startVideoID,$pageSize,$page);
	}else{
		$videos = $db->listVideoByTime($startTime,$pageSize,$page);
	}

	foreach($videos->items as $item){
		$total++;
		if($i++>=100){
			$t2 = microtime_float();
			$t  = $t2;
			$i=0;
		};
		if(empty($item['SingerIDS']))continue;
		$vid = $item['VideoID'];
		$singerids = split("/",$item['SingerIDS']);
		$item['SingerIDS'] = str_replace("/"," ",$item['SingerIDS']);
		$singernames=array();
		//$singerids2=array();
		foreach($singerids as $singerid){
			$singernames[]=@$singers[$singerid]['SingerName'];
			//$singerids[]=array('SingerID'=>$singerid);
		}
		if(empty($singernames))continue;
		$item['SingerNameS']=implode("/",$singernames);
		//$item['SingerIDS']=$singerids;
		$id = $item['AlbumID'];
		$item['AlbumName']=@$albums[$id]['AlbumName'];
		$item['VideoPubdate'] = str_replace("-","",$item['VideoPubdate']);
		add($item);
		$vid = (int)$item['VideoID']+1;
		file_put_contents($log,$item['VideoUpdateTime']."/".$vid);
		unset($item);
	}
}
function add($item){
	$item['id'] = $item['VideoID'];
	echo '<sphinx:document id="'.$item['VideoID'].'">'."\n";
	unset($item['VideoUpdateTime']);
	foreach($item as $k=>$v){
		$k = strtolower($k);
		echo "\t<$k>";
		if(is_numeric($v)){echo $v;}
		else{echo "<![CDATA[$v]]>";}
		echo "</$k>\n";
	}
	echo "</sphinx:document>\n\n";
}
//echo' <sphinx:killlist> <id>96</id> <id>603</id> </sphinx:killlist>';
echo '</sphinx:docset>';
