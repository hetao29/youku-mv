<?php
/**
 * WebQQ OpenID SDK
 *
 * PHP version 5
 *
 * <code>
 *  // 检查签名是否有效
 *  $openId = new WebQQ_OpenID('App ID', 'Secret Key');
 *  var_dump($openId::checkSig());
 * </code>
 * 
 * @category  WebQQ
 * @package   WebQQ_OpenID
 * @author    ChappellQu <chappell(dot)wat(at)gmail(dot)com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.0.0
 * @link      http://dev.qq.com/wiki/index.php?title=OpenId
 */

/**
 * 检查必要组件:
 *     hash_hmac (PHP 5.1.2+, PECL hash 1.1+)
 */
if (!function_exists('hash_hmac')) {
	throw new Exception('请加载 hash_hmac 组件');
}

/**
 * WebQQ_OpenID 类
 */
class WebQQ_OpenID
{

	//	{{{	properties

	/**
	 * 必要参数
     *
     * @var		array
     * @static
     * @access	private
	 */
	private static $_paramList = array(
		/**
		 * 应用 ID
		 *
		 * 它是应用的唯一标识，可通过它来查找应用的基本信息。
		 * 由腾讯开发平台在第三方应用注册时进行统一分配。
		 *
		 * @var		string
		 */
		'app_id',

		/**
		 * 应用的语言
		 *
		 * 2052: 简体中文
		 * 1028: 繁体中文
		 * 1033: 英文
		 *
		 * @var		string
		 */
		'app_lang',

		/**
		 * 一次性的随机字符串
		 *
		 * 必须保证对于同一个 app_ts ，该值是唯一的
		 *
		 * @var		string
		 */
		'app_nonce',

		/**
		 * 时间戳
		 *
		 * 自 January 1, 1970 00:00:00 GMT 以来经过的秒数
		 *
		 * @var		string
		 */
		'app_ts',

		/**
		 * 与应用通信的用户 ID
		 *
		 * 对于同一应用，它能定位到唯一用户。
		 *
		 * @var		string
		 */
		'app_openid',

		/**
		 * 与应用通信的验证字符串
		 *
		 * 用于验证通信的合法性。
		 *
		 * @var		string
		 */
		'app_openkey',

		/**
		 * 用户 IP
		 *
		 * 当前用户的 IP
		 * 暂未启用
		 *
		 * @var		string
		 */
		//'app_userip',

		/**
		 * 签名 
		 *
		 * 通过特定算法计算出的签名，用来验证请求是否合法
		 *
		 * @var		string
		 */
		'sig',
	);

	//	}}}

	/**
	 * 配置项
     *
     * @var		array
     * @static
     * @access	private
	 */
	private static $_configList = array(
		'app_id'	=>	'',
		'app_lang'	=>	'',
		/**
		 * 应用的通信密钥
		 *
		 * 用于验证合法性，确保应用和腾讯服务器之间的通信安全。
		 * 由腾讯开发平台在第三方应用注册时生成并知会开发者，
		 * 只有双方知道，唯一且不公开！
		 *
		 * @var		string
		 * @static
		 * @access	private
		 */
		'app_skey'	=>  '',
	);

	//	}}}

	//	{{{	constructor

	/**
	 * 构造
     *
	 * @param	string	$appId	应用 ID
	 * @param	string	$sKey	应用的通信密钥
	 * @return	void
	 */
	function __construct($appId, $sKey, $lang = '2052')
	{
		if (empty($appId) || empty($sKey)) {
			self::halt('请完整填写 appId 和 secretKey');
		}

		// 向配置写入 appId / secretKey 和 lang
		self::setConfig('app_id', (string)$appId);
		self::setConfig('app_skey', (string)$sKey);
		self::setConfig('app_lang', (string)$lang);
	}

	//	}}}

	//	{{{	destructor

	/**
	 * 析构
     *
	 * @return	void
	 */
	function __destruct()
	{
	}

	//	}}}

	//	{{{	halt()

	/**
	 * 抛出错误
     *
	 * @param	string	$errMsg	错误信息
     * @static
     * @access	private
	 * @return	void
	 */
	private static function halt($errMsg = '未知错误')
	{
		throw new Exception($errMsg);
	}

	//	}}}

	//	{{{	setConfig()

	/**
	 * 设置配置
     *
	 * @param	string	$key	配置名
	 * @param	string	$val	配置值
     * @static
     * @access	private
	 * @return	void
	 */
	private static function setConfig($key, $val)
	{
		if (empty($key) || empty($val)) {
			self::halt('配置项的名称和值均不能为空');
		} else if (!array_key_exists($key, self::$_configList)) {
			self::halt('未知的配置名');
		}

		// 更新配置项
		self::$_configList[$key] = $val;
	}

	//	}}}

	//	{{{	getConfig()

	/**
	 * 获取配置
     *
	 * @param	string	$key	配置名
	 * @param	string	$val	配置值
     * @static
     * @access	private
	 * @return	string
	 */
	private static function getConfig($key)
	{
		if (empty($key)) {
			self::halt('配置项的名称不能为空');
		} else if (!array_key_exists($key, self::$_configList)) {
			self::halt('未知的配置名');
		}

		// 返回配置项
		return self::$_configList[$key];
	}

	//	}}}

	//	{{{	checkSig()

	/**
	 * 校验签名 (sig) 是否合法
	 *
	 * 只有合法的签名才能证明 openId 真实有效
     *
     * @static
     * @access	public
	 * @return	boolean
	 */
	public static function checkSig()
	{
		do {
			// 构建用于生成签名的参数数组
			$paramArr = array();
			foreach (self::$_paramList as &$key) {
				// 参数缺失
				if (!array_key_exists($key, $_GET)) {
					break 2;
				}

				// 从 URL 里取得所需参数
				$val = $_GET[$key];

				// 检查参数值
				if (empty($val)) {
					// 值为空
					break 2;
				} else if (array_key_exists($key, self::$_configList) && $val !== self::$_configList[$key]) {
					// 与配置值不符
					break 2;
				}

				// 写入参数数组
				$paramArr[$key] = $val;
			}

			// 排序
			ksort($paramArr);

			// 取得签名
			$sig = strtolower($paramArr['sig']);
			unset($paramArr['sig']); // 删除

			// 校验结果
			return $sig === hash_hmac('sha1', http_build_query($paramArr), self::getConfig('app_skey') . '&');
		} while (0);

		// 校验发生意外
		return false;
	}

	//	}}}

}
