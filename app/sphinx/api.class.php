<?php
/*
chdir(dirname(__FILE__));
require("../../global.php");
$test = new sphinx_api;
$videos = $test->listBySingerID(69);
print_r($videos);
$videos = $test->get(69);
print_r($videos);
*/
class sphinx_api{
	var $mapping=array(
		"videoid"		=>"VideoID",
		"videoname"		=>"VideoName",
		"singernames"	=>"SingerNameS",
		"singerids"		=>"SingerIDS",
		"videothumb"	=>"VideoThumb",
		"videopubdate"	=>"VideoPubdate",
		"albumname"		=>"AlbumName",
		"albumid"		=>"AlbumID",
		"videoduration"	=>"VideoDuration",
		"videoarea"		=>"VideoArea",
		"videostyle"	=>"VideoStyle",
		"videostatus"	=>"VideoStatus",
		"videolanguage"	=>"VideoLanguage");
	var $sphinx;
		function __construct(){
			$this->sphinx = new SSphinx;
			$this->sphinx->SetServer ( "localhost", 9312 );
			$this->sphinx->SetArrayResult ( true );
		}
		private function resToVideos($res){
			$items = array();
			if(!empty($res['matches'])){
				foreach($res['matches'] as $match){
					$item=array();
					foreach($match['attrs'] as $k=>$v){
						if(is_array($v)){$v=implode("/",$v);};
						if(isset($this->mapping[$k]))$k=$this->mapping[$k];
						$item[$k]=$v;
					}
					$items[]=$item;
				}
			}
			return $items;
		}
		/**
		 * 获取视频
		 */
		function get($vid){
			$this->sphinx->ResetFilters();
			$this->sphinx->ResetGroupBy();
			$this->sphinx->SetMatchMode ( $mode=SPH_MATCH_EXTENDED );
			//$this->sphinx->SetFilterRange ( $args[++$i], $args[++$i], $args[++$i] );
			$this->sphinx->SetLimits(0,1,1);
			$this->sphinx->SetFilter ("videoid",array($vid ));
			//$this->sphinx->SetFilterRange("videoid",96,96);
			$res = $this->sphinx->Query ( $q="", $index="video" );
			$videos = $this->resToVideos($res);
			return @$videos[0];
		}
		function listBySingerID($SingerID){
			$this->sphinx->ResetFilters();
			$this->sphinx->ResetGroupBy();
			$this->sphinx->SetMatchMode ( $mode=SPH_MATCH_EXTENDED );
			//$this->sphinx->SetFilterRange ( $args[++$i], $args[++$i], $args[++$i] );
			$this->sphinx->SetLimits(0,1000,1000);
			$this->sphinx->SetSortMode (SPH_SORT_EXTENDED ,"videostatus desc, videopubdate desc");
			$this->sphinx->SetFilter ("singerids",array($SingerID ));
			//$this->sphinx->SetFilterRange("videoid",96,96);
			$res = $this->sphinx->Query ( $q="", $index="video" );
			return $this->resToVideos($res);
		}
		function search($key,$limit=50,$mustHaveSingers=true){
			 
			$key = $this->sphinx->EscapeString ($key);
			
			$search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "'", "<", ">", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "：", "）", "（", "．", "。", "，", "！", "；", "“", "”", "‘", "’", "［", "］", "、", "—", "　", "《", "》", "－", "…", "【", "】");
			$key = str_replace($search,' ',$key);


			$keywords = explode(" ",$key);
			$key="";
			foreach($keywords as $_k){
				$key.='+"'.$_k.'" ';
			}
			//$key ="+".$key;
			//$keywords = $this->sphinx->BuildKeywords ($key, "video", false );
			$this->sphinx->ResetFilters();
			$this->sphinx->ResetGroupBy();
			$this->sphinx->SetMatchMode ( $mode=SPH_MATCH_EXTENDED );
			//$this->sphinx->SetFilterRange ( $args[++$i], $args[++$i], $args[++$i] );
			$this->sphinx->SetLimits(0,$limit,10000);
			$this->sphinx->SetSortMode (SPH_SORT_EXTENDED ,"videostatus desc, videopubdate desc");
			//$this->sphinx->SetFilter ("@videostatus",array(-1 ));
			//$this->sphinx->SetFilterRange("videoid",96,96);
			$res = $this->sphinx->Query ( $q="@(videoname,singernames) $key", $index="video" );
			$videos = $this->resToVideos($res);
			return $videos;
		}
		function SetFilterRange ( $attribute, $min, $max, $exclude=false ){
			return $this->sphinx->SetFilterRange ( $attribute, $min, $max, $exclude );
		}
		function SetFilter ( $attribute, $values, $exclude=false ){
			return $this->sphinx->SetFilter ( $attribute, $values, $exclude );
		}
		function query($q,$limit){
			$this->sphinx->SetLimits(0,$limit,10000);
			$this->sphinx->SetMatchMode ( $mode=SPH_MATCH_EXTENDED );
			return $this->resToVideos($this->sphinx->query($q,"video"));
		}
}
