<?php

//请填上自己的app key
$appkey = '801069800';
//请填上自己的app secret
$appsecret = 'fc7be2353c81288603b428d345777190';
require_once dirname(__FILE__).'/lib/OpenSDK/Tencent/Weibo.php';

OpenSDK_Tencent_Weibo::init($appkey, $appsecret);



