<?php
set_time_limit(0);
error_reporting(E_ALL ^E_NOTICE);
ini_set("include_path",dirname(__FILE__));

require_once 'Zend/Search/Lucene.php';
require_once('Zend/Search/CN_Lucene_Analyzer.php');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new CN_Lucene_Analyzer());
try{
	$index = Zend_Search_Lucene::open('index');
}catch(Exception $e){
	$index = new Zend_Search_Lucene('index',true);//建立索引对象，TRUE表示一个新的索引

	$db=mysql_connect("localhost","root");
	mysql_select_db("youku");
	mysql_query("set names utf8");
	//$r = mysql_query("select  MusicName,VideoID,AlbumName,s_music.SingerIDS,MusicStyle,MusicArea,MusicPubdate from s_music,s_album where s_music.AlbumID=s_album.AlbumID LIMIT 33570 ,10");
	//$r = mysql_query("select  MusicName,VideoID,AlbumName,s_music.SingerIDS,MusicStyle,MusicArea,MusicPubdate from s_music,s_album where s_music.AlbumID=s_album.AlbumID LIMIT 33500 ,50");
	//$r = mysql_query("select  MusicName,VideoID,AlbumName,s_music.SingerIDS,MusicStyle,MusicArea,MusicPubdate from s_music,s_album where s_music.AlbumID=s_album.AlbumID LIMIT 50");
	$r = mysql_query("select  MusicName,VideoID,AlbumName,s_music.SingerIDS,MusicStyle,MusicArea,MusicPubdate from s_music,s_album where s_music.AlbumID=s_album.AlbumID ");
	$textos=array();
	$t = microtime_float();
	//{{{
	//得到所有的singer
			$r2=mysql_query("select singerid,singername from s_singer");
			$singernames=array();
			while($row2=mysql_fetch_row($r2)){
					$id=$row2[0];
					$singernames[$id]=$row2[1];
			}
	//}}}
	$i=0;
	$total=0;
	//try{
		while($row=mysql_fetch_row($r)){
				$singerids=$row[3];
				$singerids=explode("/",$row[3]);
				$names=array();
				foreach($singerids as $id){
						$names[]=$singernames[$id];
				}
				//print_r($row);
				//print_r($names);
				//echo $row[0]."\n";
				$doc = new Zend_Search_Lucene_Document();//建立一个索引文档
				$doc->addField(Zend_Search_Lucene_Field::Text('MusicName', 	$row[0]));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoID', 	$row[1]));
				$doc->addField(Zend_Search_Lucene_Field::Text('AlbumName', 	$row[2]));
				$doc->addField(Zend_Search_Lucene_Field::Text('SingerNames',implode("/",$names)));
				$doc->addField(Zend_Search_Lucene_Field::Unstored('MusicStyle',	$row[4]));
				$doc->addField(Zend_Search_Lucene_Field::Unstored('MusicArea', 	$row[5]));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('MusicPubdate',$row[6]));
				$index->addDocument($doc); //将这个文档加到索引中
				$total++;
				if($i++>2000){
						$index->commit();
						echo "$total, ";
						$t2=microtime_float();
						echo $t2-$t." seconds\n";
						$t=$t2;
						$i=0;
				}
		}
		$index->commit();//提交，保存索引资料
		$index->optimize();
	$t = microtime_float() - $t;
}
//{{{
/*
exit;
 */
//}}}
echo "\n\nSEARCH\n\n";
$keyword="MusicName:相爱";
//$keyword="66472591";
$keyword="SingerNames:启靓";
$keyword="MusicName:+see +Me";
$keyword="MusicName:pet~";
//$keyword="MusicName:关不住";
//$query = new Zend_Search_Lucene_Search_Query_Phrase( array($keyword));
//$query = Zend_Search_Lucene_Search_QueryParser::parse($keyword);
// $hits = $index->find($query);
//print_r($hits[0]->name);
 $hits = $index->find($keyword);
foreach($hits as $h){
echo($h->id.":".$h->VideoID.":".$h->SingerNames.":".$h->MusicName);
echo "\n";
}
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
?>
