<?php
set_time_limit(0);
ini_set("include_path",dirname(__FILE__));
require_once 'Zend/Search/Lucene.php';
//require_once 'library/Zend/Search/Lucene/Document/Html.php';
require_once('Zend/Search/CN_Lucene_Analyzer.php');
//{{{
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new CN_Lucene_Analyzer());
$index = new Zend_Search_Lucene('index',true);//建立索引对象，TRUE表示一个新的索引
$db=mysql_connect("localhost","root");
mysql_select_db("youku");
mysql_query("set names utf8");
$r = mysql_query("select * from s_music limit 20");
$textos=array();
$t = microtime_float();
$t = microtime_float() - $t;
print "<strong>".$t."</strong> seconds<br>";
while($row=mysql_fetch_row($r)){
	echo $name = $row[6];
	echo "\n";
	$id = $row[1];
	$doc = new Zend_Search_Lucene_Document();//建立一个索引文档
	$doc->addField(Zend_Search_Lucene_Field::Text('name', $name));
	$doc->addField(Zend_Search_Lucene_Field::Text('id', $id));
	$index->addDocument($doc); //将这个文档加到索引中
}
$index->commit();//提交，保存索引资料
$index->optimize();
$t = microtime_float() - $t;
//}}}
$keyword="月亮";
$keyword="Pasa";
$index = new Zend_Search_Lucene('index');//建立索引对象，TRUE表示一个新的索引
//$query = Zend_Search_Lucene_Search_QueryParser::parse($keyword);
// $hits = $index->find($query);
//print_r($hits[0]->name);
 $hits = $index->find($keyword);
print_r($hits[0]->name);
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
?>
