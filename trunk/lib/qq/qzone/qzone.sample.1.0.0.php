<?php
/**
 * PHP Sample Code for Qzone Open API
 *
 * @version 1.0.0
 * @author dev.opensns@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */
 
require('qzone.class.1.0.0.php');

/**
* appid/appkey/appname 是应用的标识
*/
$appid = 'your appid';
$appkey = 'your appkey';
$appname = 'your appname';

/**
* Qzone OpenAPI 服务器的地址（域名或IP）
* 具体API地址请参考文档 
* http://wiki.opensns.qq.com/wiki/API%E6%96%87%E6%A1%A3
* http://wiki.opensns.qq.com/wiki/qzone/user/info
* 【注意区分正式、测试环境】
*/
$server_name = '119.147.75.204';

$qzone = new Qzone($appid, $appkey, $appname);
$qzone->setServerName($server_name);

debug($qzone);

/**
* openid 和 openkey 会通过 GET 参数传递给应用
*/
$openid = $_GET['openid'];
$openkey = $_GET['openkey'];

#########################################################
# 1. 返回当前登录用户信息
#########################################################

$result = $qzone->getUserInfo($openid, $openkey);
debug($result, 'test getUserInfo');

#########################################################
# 2. 获取好友列表
#########################################################

$result = $qzone->getFriendList($openid, $openkey);
debug($result, 'test getFriendList');

#########################################################
# 3. 验证是否好友
#########################################################

// 好友的 openid
$fopenid = '00000000000000000000000000002D2E';
$result = $qzone->isFriend($openid, $openkey, array('fopenid' => $fopenid));
debug($result, 'test isFriend');

#########################################################
# 4. 批量获取用户详细信息
#########################################################

// 好友的 openid
$fopenids = array('00000000000000000000000000002D2E','00000000000000000000000000002B35','000000000000000000000000001C2DF9');
$result = $qzone->getMultiInfo($openid, $openkey, array('fopenids' => $fopenids));
debug($result, 'test getMultiInfo');

if (0 == $result['ret']) {
	foreach ($result['items'] as $userInfo) {
		echo $userInfo['nickname'], ' ';
		echo "<img src=\"http://{$userInfo['figureurl']}\" width=\"50\" height=\"50\" /><br />\n";
	}
}

#########################################################
# 5. 验证登录用户是否安装了应用
#########################################################

$result = $qzone->isSetuped($openid, $openkey);
debug($result, 'test isSetuped');

#########################################################
# 6. 判断用户是否为黄钻
#########################################################

$result = $qzone->isVip($openid, $openkey);
debug($result, 'test isVip');

#########################################################
# 7. 获取好友的签名信息
#########################################################

$fopenids = array('00000000000000000000000000002D2E','00000000000000000000000000002B35','000000000000000000000000001C2DF9');
$result = $qzone->getEmotion($openid, $openkey, array('fopenids' => $fopenids));
debug($result, 'test getEmotion');

/**
 * 输出调试信息
 */
function debug($obj, $msg = null){
	if (isset($msg)) {
		echo "[{$msg}]<hr>\n";
	}
	var_dump($obj);
	echo "<hr>\n";
}

//End of Script