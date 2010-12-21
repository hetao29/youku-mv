<?php
/**
 * sample to test
 *
 * http://localhost/samples/index.php/zone/default/entry/a/b/c
 * http://localhost/samples/index.php/zone-default-entry-a-b-c.html
 *
 */
/* use static */
//{{{

require_once("global.php");

/*echo error info*/
SlightPHP::setDebug(true);

SlightPHP::setAppDir("app");
SlightPHP::setDefaultZone("player");
SlightPHP::setDefaultPage("main");
SlightPHP::setDefaultEntry("entry");

SDb::setConfigFile(SlightPHP::$appDir . "/index/db.ini.php");
//{{{
SLanguage::setLanguageDir(SlightPHP::$appDir."/../locale");
SLanguage::setLocale("zh-CN");
//}}}
SlightPHP::setSplitFlag("-_.");
#SError::$CONSOLE= true;
if(!empty($_SERVER['HTTP_ORIGIN'])){
  header('Access-Control-Allow-Origin: *');  
}
$r=SlightPHP::run();
if(!is_string($r)){
	echo SJson::encode($r);
}else{
	echo $r;
}
