<?php
ini_set("include_path",dirname(__FILE__));
require_once 'Zend/Search/Lucene.php';
require_once('Zend/Search/CN_Lucene_Analyzer.php');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new CN_Lucene_Analyzer());
Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
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
		function get($vid,$cache=false){
				$query="VideoID:".$vid;
				$hits = $this->query($query,0,$cache);
				if(!empty($hits)) return $hits[0];
		}
		function search($key,$limit,$cache=true){
				$keys=split(" ",$key);
				$query="contents:(";
				foreach($keys as $key){
						$query.="+'".trim($key)."'";
				}
				$query.=")";
				return $this->query($query,0,$cache);
		}
		/**
		 * 更新/增加一条索引
		 */
		function update($vid,$Video){
				$this->del($vid);
				$this->add($Video);
		}
		/**
		 * 检索
		 */
		function query($query,$limit=0,$cache=false){
				//{{{
				if($cache){
					$cache_api  = SCache::getCacheEngine($cacheengine="File");
					$cache_api->init(array("dir"=>WWW_ROOT."/cache","depth"=>3));
					$key = md5($query.":".$limit);
					if($r = $cache_api->get($key)){
							return $r;
					}
				}
				//}}}
				$this->index->setResultSetLimit($limit);
				$hits = $this->index->find($query);
				$results=array();
				$names=array();
				foreach($hits as $hit){
						$o=array();
						$names = empty($names)?$hit->getDocument()->getFieldNames():$names;
						foreach($names as $name){
								$o['_id'] = $hit->id;
								if($name=='VideoPubdate'){
									$str = $hit->getDocument()->getFieldUtf8Value($name);
									$o[$name] = substr($str,0,4)."-".substr($str,4,2)."-".substr($str,6,2);
								}else{
									$o[$name] = $hit->getDocument()->getFieldUtf8Value($name);
								}

						}
						$results[]=$o;
				}
				if($cache)$cache_api->set($key,$results,60*60*24*7);
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
		public function add($VideoInfo){
				if(empty($VideoInfo['VideoID'])||empty($VideoInfo['VideoName'])||empty($VideoInfo['Singers']))return false;


				$singernames=array();
				$singerids=array();
				if(!empty($VideoInfo['Singers'])){
						$singernames=array();
						foreach($VideoInfo['Singers'] as $singer){
								$singernames[]=$singer['SingerName'];
								$singerids[]=$singer['SingerID'];
						}
				}
				$contents=	implode("/",$singernames)."/".$VideoInfo['VideoName']."/".
							@$VideoInfo['Album']['AlbumName']."/";
				$doc = new Zend_Search_Lucene_Document();
				$doc->addField(Zend_Search_Lucene_Field::Keyword('VideoID', 	$VideoInfo['VideoID']));
				$doc->addField(Zend_Search_Lucene_Field::UnStored('contents',$contents));
				//$doc->addField(Zend_Search_Lucene_Field::Text('SingerNameS',implode("/",$singernames)));
				$doc->addField(Zend_Search_Lucene_Field::UnStored('SingerIDS',implode("/",$singerids)));
				//$doc->addField(Zend_Search_Lucene_Field::UnIndexed('VideoName', 		$VideoInfo['VideoName']));
				//$doc->addField(Zend_Search_Lucene_Field::UnIndexed('AlbumID',	@$VideoInfo['Album']['AlbumID']));

				$doc->addField(Zend_Search_Lucene_Field::UnStored('VideoStyle',	@$VideoInfo['VideoStyle']));
				//$doc->addField(Zend_Search_Lucene_Field::UnIndexed('VideoDuration',	@$VideoInfo['VideoDuration']));
				$doc->addField(Zend_Search_Lucene_Field::UnStored('VideoArea', 	@$VideoInfo['VideoArea']));
				$doc->addField(Zend_Search_Lucene_Field::UnStored('VideoLanguage',@$VideoInfo['VideoLanguage']));
				//把时间的-号取消,如2011-11-11变成20111111
				$doc->addField(Zend_Search_Lucene_Field::UnStored('VideoPubdate',str_replace("-","",@$VideoInfo['VideoPubdate'])));
				$this->index->addDocument($doc); //将这个文档加到索引中
		}
}
