<?php
class player_js{
	function __construct(){
	}
	function __destruct(){
	}
	function pageEntry($inPath){

			header("Content-type: text/javascript;charset=utf-8");
			$expires = 60*60*24*10;//1 days
			header("Pragma: public");
			header("Cache-Control: maxage=".$expires);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			return file_get_contents(WWW_ROOT."/"."assets/js/youku.ws.js");
	}
	function pageEntryV3($inPath){

			header("Content-type: text/javascript;charset=utf-8");
			$expires = 60*60*24*10;//1 days
			header("Pragma: public");
			header("Cache-Control: maxage=".$expires);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			return file_get_contents(WWW_ROOT."/"."assets/js/v3/v3.js");
	}
}
