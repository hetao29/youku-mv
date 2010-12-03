<?php
class player_main extends SGui{
	function __construct(){
		echo $this->render("head.tpl");
	}
	function __destruct(){
		echo $this->render("footer.tpl");
	}
	function pageEntry($inPath){
		echo $this->render("player/player.tpl");
	}
}
?>
