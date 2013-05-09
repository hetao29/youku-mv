<?php
class user_profile extends STpl{
	function pageEntry($inPath){
		echo "User Profile";
	}
	function pageEdit($inPath){
		echo "User Profile Edit";
		return $this->render("user/profile.tpl");
	}
}
?>
