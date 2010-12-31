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
session_start();

ob_start("ob_gzhandler");
require_once("global.php");

if(!empty($_SERVER['HTTP_ORIGIN'])){
  header('Access-Control-Allow-Origin: *');  
}
$r=SlightPHP::run();
if($r!==null && !is_string($r)){
	echo SJson::encode($r);
}else{
	echo $r;
}
