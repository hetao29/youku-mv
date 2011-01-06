<?php
class player_js{
	function __construct(){
	}
	function __destruct(){
	}
	function pageEntry($inPath){

			header("Content-type: text/javascript;charset=utf-8");
			$expires = 60*60*24*1;//1 days
			header("Pragma: public");
			header("Cache-Control: maxage=".$expires);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			return file_get_contents(WWW_ROOT."/"."assets/js/youku.ws.js");
	}
}
