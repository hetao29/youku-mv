<?xml version="1.0" encoding="utf-8"?>
<sphinx:docset>

<sphinx:schema>
	<sphinx:field name="VideoID" attr="string"/> 
	<sphinx:field name="AlbumID" attr="string"/> 
	<sphinx:field name="AlbumName" attr="string"/> 
	<sphinx:field name="VideoName" attr="string"/> 
	<sphinx:field name="SingerNameS" attr="string"/> 
	<sphinx:field name="VideoLanguage" attr="string"/> 
	<sphinx:field name="VideoStyle" attr="string"/> 
	<sphinx:attr name="VideoThumb" type="string"/> 
	<sphinx:field name="VideoArea" attr="string"/> 
	<sphinx:field name="SingerIDS" attr="string"/> 
	<sphinx:attr name="VideoDuration" type="int"/> 
	<sphinx:attr name="VideoUpdateTime" type="timestamp"/> 
	<sphinx:field name="VideoPubdate" attr="string"/> 
	<sphinx:attr name="VideoStatus" type="int"/> 
</sphinx:schema>
<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
$log="sphinx.xmlpipe.log";
$db = new video_db;
$video_api = new video_api;
$logData = trim(file_get_contents($log));
$startTime=0;$startVideoID=0;
if(!empty($logData)){
		$tmp = explode("/",$logData);
		$startTime=trim($tmp[0]);
		$startVideoID=trim($tmp[1]);
}
//echo "START FROM $startTime / $startVideoID\n";
$videos = $db->listVideo($startTime,3);
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
$len=count($videos->items);
function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
}
$t = microtime_float();
foreach($videos->items as $item){
		$total++;
		if($i++>=100){
				$t2 = microtime_float();
				echo ($total)."/$len\t".($t2-$t)." seconds\n";
				$t  = $t2;
				$i=0;
		};
		$vid = $item['VideoID'];
		$singerids = split("/",$item['SingerIDS']);
		$singernames=array();
		foreach($singerids as $singerid){
				$singernames[]=@$singers[$singerid]['SingerName'];
		}
		if(empty($singernames))continue;
		$item['SingerNameS']=implode("/",$singernames);
		$id = $item['AlbumID'];
		$item['AlbumName']=@$albums[$id]['AlbumName'];
		$item['VideoDuration'] = str_replace("-","",$item['VideoDuration']);
		add($item);
		file_put_contents($log,$item['VideoUpdateTime']."/".$item['VideoID']);
}
function add($item){
	echo '<sphinx:document id="'.$item['VideoID'].'">'."\n";
	foreach($item as $k=>$v){
		echo "\t<$k>";
		if(is_numeric($v)){echo $v;}
		else{echo "<![CDATA[$v]]>";}
		echo "</$k>\n";
	}
	echo "</sphinx:document>\n\n";
//print_r($item);
}
?>
</sphinx:docset>
<!--
<?xml version="1.0" encoding="utf-8"?>
<sphinx:docset>

<sphinx:schema>
	<sphinx:field name="VideoID"/> 
</sphinx:schema>

<sphinx:document id="1234">
</sphinx:document>

<sphinx:document id="1235">
</sphinx:document>
<sphinx:killlist>
<id>1234</id>
<id>4567</id>
</sphinx:killlist>

</sphinx:docset>

-->