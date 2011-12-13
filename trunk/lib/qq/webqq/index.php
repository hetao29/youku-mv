<meta charset="utf-8">
<?php

/**
 * 如何测试：
 * 1. 登录 dev.qq.com 并打开“我的应用”；
 * 2. 确认“是否使用腾讯账号登录”选择了“是”；
 * 3. 修改页面，填写应用 ID 和通信密钥，并上传；
 * 4. 修改“应用网址”为本页面地址；
 * 5. 从 WebQQ （或从“我开发的应用”）里启动应用，查看自动登录结果；
 */

// 引入类文件
require_once('webqq_openid.class.php');

// 实例化
$openId = new WebQQ_OpenID(
	/**
	 * 使用前请根据应用的情况填写以下参数
	 * 在 dev.qq.com 里点击应用名称即可查看相关数据
	 */
	'App ID',		// 填入应用 ID
	'Secret Key'	// 填入应用的通信密钥。此参数仅有 WebQQ 和开发者自己知晓，请勿公开！！
);

// 检查签名是否合法
var_dump($openId::checkSig());
