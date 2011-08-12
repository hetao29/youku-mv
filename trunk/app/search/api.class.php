<?php
ini_set("include_path",dirname(__FILE__));
require_once 'Zend/Search/Lucene.php';
require_once('Zend/Search/CN_Lucene_Analyzer.php');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new CN_Lucene_Analyzer());
class search_api{
		var $dataDir;
		var $index;
		function __construct(){
				$this->dataDir=dirname(__FILE__)."/data";
				try{
						$this->index = Zend_Search_Lucene::open($this->dataDir);
				}catch(Exception $e){
						$this->index = new Zend_Search_Lucene($this->dataDir,true);//建立索引对象，TRUE表示一个新的索引
				}
		}
		/**
		 * 删除一条索引
		 */
		function del($vid){
				$v=$this->get($vid);
				if(!empty($v)){
						$r = $this->index->delete($v->_id);
				}
		}
		/**
		 * 获取视频
		 */
		function get($vid){
				$query="VideoID:".$vid;
				$hits = $this->query($query);
				if(!empty($hits)) return $hits[0];
		}
		/**
		 * 更新/增加一条索引
		 */
		function update($vid,$Video){
				$this->del($vid);
				$this->__add($Video);
		}
		/**
		 * 检索
		 */
		function query($query){
				$hits = $this->index->find($query);
				$results=array();
				$names=array();
				foreach($hits as $hit){
						$o=new stdclass;
						$names = empty($names)?$hit->getDocument()->getFieldNames():$names;
						foreach($names as $name){
								$o->_id = $hit->id;
								if($name=='VideoPubdate'){
									$str = $hit->getDocument()->getFieldUtf8Value($name);
									$o->$name = substr($str,0,4)."-".substr($str,4,2)."-".substr($str,6,2);
								}else{
									$o->$name = $hit->getDocument()->getFieldUtf8Value($name);
								}

						}
						$results[]=$o;
				}
				return $results;
		}
		/**
		 * 优化
		 */
		function optimize(){
				$this->index->optimize();
				$this->index->commit();
		}
		/**
		 * 增加
		 * @param @VideoInfo = video_api::getVideoInfo($vid)
		 */
		private function __add($VideoInfo){
				$doc = new Zend_Search_Lucene_Document();
				if(empty($VideoInfo['VideoID'])||empty($VideoInfo['VideoName']))return false;

				$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoID', 	$VideoInfo['VideoID']));
				$doc->addField(Zend_Search_Lucene_Field::Text('VideoName', 		$VideoInfo['VideoName']));
				if(!empty($VideoInfo['Album'])){
						$doc->addField(Zend_Search_Lucene_Field::Text('AlbumName',	$VideoInfo['Album']['AlbumName']));
				}
				if(!empty($VideoInfo['Singers'])){
						$singernames=array();
						foreach($VideoInfo['Singers'] as $singer){
								$singernames[]=$singer['SingerName'];
						}
						$doc->addField(Zend_Search_Lucene_Field::Text('SingerNames',implode("/",$singernames)));
				}
				if(!empty($VideoInfo['VideoStyle'])){
						$doc->addField(Zend_Search_Lucene_Field::Text('VideoStyle',	$VideoInfo['VideoStyle']));
				}
				if(!empty($VideoInfo['VideoArea']))$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoArea', 	$VideoInfo['VideoArea']));
				if(!empty($VideoInfo['VideoLanguage']))$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoLanguage',$VideoInfo['VideoLanguage']));
				if(!empty($VideoInfo['VideoPubdate'])){
						//把时间的-号取消,如2011-11-11变成20111111
						$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoPubdate',str_replace("-","",$VideoInfo['VideoPubdate'])));
				}
				$this->index->addDocument($doc); //将这个文档加到索引中
		}
}
//{{{ testcase
$api = new search_api;
$v = $api->get($vid=57520070);
print_r($v);
//print_r($api->query("山丹丹"));
/*
//$api->optimize();
chdir(dirname(__FILE__));
require("../../global.php");
$vid = 17682534;
//$vid = 20959074;
$video_api = new video_api;
$v=$video_api->getVideoInfo($vid);
print_r($v);
$v['VideoName']="DDDDD32";
//$v=new stdclass;
//$v->VideoID=57520070;
//$v->VideoName="XX";
$api->update($vid,$v);
$v = $api->get($vid);
print_r($v);
//$api->del($vid);
//}}}
//*/
