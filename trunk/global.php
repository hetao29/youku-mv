<?php
require_once("slightphp/SlightPHP.php");
define("DEV","true");
define("PLUGINS_DIR","slightphp/plugins");
define("WWW_ROOT",dirname(__FILE__));
/*echo error info*/
//SlightPHP::setDebug(true);

SlightPHP::setAppDir(dirname(__FILE__)."/app");
SlightPHP::setDefaultZone("player");
SlightPHP::setDefaultPage("main");
SlightPHP::setDefaultEntry("entry");

SlightPHP::setSplitFlag("-_.");
//{{{
SDb::setConfigFile(SlightPHP::$appDir . "/index/db.ini.php");
SLanguage::setLanguageDir(SlightPHP::$appDir."/../locale");
//SLanguage::$defaultLocale="zh-CN";
//SLanguage::setLocale("zh-CN");
//}}}
function __autoload($class){
	if($class{0}=="S"){
		require_once(PLUGINS_DIR."/$class.class.php");
	}else{
		require_once(SlightPHP::$appDir."/".str_replace("_","/",$class).".class.php");
	}
}
?>
