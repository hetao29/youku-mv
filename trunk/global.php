<?php
require_once("slightphp/SlightPHP.php");
//define("DEV","true");
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
SDb::setConfigFile(SlightPHP::$appDir . "/db.ini.php");
SLanguage::setLanguageDir(SlightPHP::$appDir."/../locale");
//SLanguage::$defaultLocale="zh-CN";
//SLanguage::setLocale("zh-CN");
//}}}
function __autoload($class){
	if($class{0}=="S"){
		$file = PLUGINS_DIR."/$class.class.php";
	}else{
		$file = SlightPHP::$appDir."/".str_replace("_","/",$class).".class.php";
	}
	if(file_exists($file)) return require_once($file);
}
spl_autoload_register('__autoload');
?>
