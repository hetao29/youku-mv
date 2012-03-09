<?php
class player_error{
	function __construct(){
	}
	function __destruct(){
	}
	function pageEntry($inPath){
		if(!empty($_REQUEST['vid'])){
			$vid = $_REQUEST['vid'];
			error_log("onPlayerError:"+$vid);
		}
	}

}
