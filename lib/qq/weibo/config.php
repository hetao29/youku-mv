<?php

//请填上自己的app key
$appkey = '801069800';
//请填上自己的app secret
$appsecret = '3108f1bd00d5f9368bfb43273ba5c1db';
require_once dirname(__FILE__).'/lib/OpenSDK/Tencent/Weibo.php';

OpenSDK_Tencent_Weibo::init($appkey, $appsecret);



