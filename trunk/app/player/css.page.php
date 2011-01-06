<?php
class player_css{
	function __construct(){
	}
	function __destruct(){
	}
	function pageEntry($inPath){
			header("Content-type: text/css;charset=utf-8");
			$expires = 60*60*24*1;//1 days
			header("Pragma: public");
			header("Cache-Control: maxage=".$expires);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			echo file_get_contents(WWW_ROOT."/"."assets/css/styleV2.css");
			return file_get_contents(WWW_ROOT."/"."assets/css/jquery-ui-1.8.6.custom-smoothness.css");
	}
}
