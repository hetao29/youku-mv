<?php
//require_once 'OpenSDK/OAuth/Interface.php';
class OpenSDK_Util
{

	/**
	 * fix json_encode
	 *
	 * @see json_encode
	 * @param mix $value
	 * @return string
	 */
	public static function json_encode($value)
	{
		return SJson::encode($value);
	}
	/**
	 * json_decode
	 *
	 * @see json_decode
	 * @param string $json
	 * @param bool $assoc
	 * @return array|object
	 */
	public static function json_decode($json , $assoc=null)
	{
		return SJson::decode($value);
	}

	/**
	 * rfc3986 encode
	 * why not encode ~
	 *
	 * @param string|mix $input
	 * @return string
	 */
	public static function urlencode_rfc3986($input)
    {
        if(is_array($input))
        {
            return array_map( array( __CLASS__ , 'urlencode_rfc3986') , $input);
        }
        else if(is_scalar($input))
		{
			return str_replace('%7E', '~', rawurlencode($input));
		}
		else
		{
			return '';
		}
    }

	/**
	 * fix hash_hmac
	 *
	 * @see hash_hmac
	 * @param string $algo
	 * @param string $data
	 * @param string $key
	 * @param bool $raw_output
	 */
	public static function hash_hmac( $algo , $data , $key , $raw_output = false )
	{
		if(function_exists('hash_hmac'))
		{
			return hash_hmac($algo, $data, $key, $raw_output);
		}

		$algo = strtolower($algo);
		if($algo == 'sha1')
		{
			$pack = 'H40';
		}
		elseif($algo == 'md5')
		{
			$pach = 'H32';
		}
		else
		{
			return '';
		}
		$size = 64;
		$opad = str_repeat(chr(0x5C), $size);
		$ipad = str_repeat(chr(0x36), $size);

		if (strlen($key) > $size) {
			$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
		} else {
			$key = str_pad($key, $size, chr(0x00));
		}

		for ($i = 0; $i < strlen($key) - 1; $i++) {
			$opad[$i] = $opad[$i] ^ $key[$i];
			$ipad[$i] = $ipad[$i] ^ $key[$i];
		}

		$output = $algo($opad.pack($pack, $algo($ipad.$data)));

		return ($raw_output) ? pack($pack, $output) : $output;
	}
}
class OpenSDK_OAuth_Client
{
	/**
	 * 签名的url标签
	 * @var string
	 */
	public $oauth_signature_key = 'oauth_signature';

	/**
	 * app secret
	 * @var string
	 */
	private $_app_secret = '';

	/**
	 * token secret
	 * @var string
	 */
	private $_token_secret = '';

	/**
	 * 上一次请求返回的Httpcode
	 * @var number
	 */
	private $_httpcode = null;

	/**
	 * 是否debug
	 * @var bool
	 */
	private $_debug = false;

	public function  __construct( $appsecret='' , $debug=false)
	{
		$this->_app_secret = $appsecret;
		$this->_debug = $debug;
	}
	/**
	 * 设置App secret
	 * @param string $appsecret
	 */
	public function setAppSecret($appsecret)
	{
		$this->_app_secret = $appsecret;
	}

	/**
	 * 设置token secret
	 * @param string $tokensecret
	 */
	public function setTokenSecret($tokensecret)
	{
		$this->_token_secret = $tokensecret;
	}

	/**
	 * 组装参数签名并请求接口
	 *
	 * @param string $url
	 * @param array $params
	 * @param string $method
	 * @param false|array $multi false:普通post array: array ( '{fieldname}' =>array('type'=>'mine','name'=>'filename','data'=>'filedata') ) 文件上传
	 * @return string
	 */
	public function request( $url, $method, $params, $multi = false, $is_oauth=true)
	{
		if($is_oauth){ 	//使用oauth参数集调用接口
			$oauth_signature = $this->sign($url, $method, $params);
			$params[$this->oauth_signature_key] = $oauth_signature;
		}
		else{	//使用openod&openkey参数集调用接口
		
			//去除 oauth 的所有认证参数，使用openid&openkey 参数集合
			unset($params['oauth_token']);
			unset($params['oauth_nonce']);
			unset($params['oauth_consumer_key']);
			unset($params['oauth_signature_method']);
			unset($params['oauth_version']);
			unset($params['oauth_timestamp']);
			unset($params['oauth_signature']);	
			
			// 生成签名
			require_once("sns_sig_check.php");
			$urls = @parse_url($url);
			$sig = SnsSigCheck::makeSig($method, $urls['path'], $params, $this->_app_secret.'&');
			$params['sig'] = $sig;
			print_r($params);
		}		

		return $this->http($url, $params, $method, $multi);
	}

	/**
	 * OAuth 协议的签名
	 *
	 * @param string $url
	 * @param string $method
	 * @param array $params
	 * @return string
	 */
	private function sign( $url , $method, $params )
	{
		uksort($params, 'strcmp');
		$pairs = array();
        foreach($params as $key => $value)
        {
			$key = OpenSDK_Util::urlencode_rfc3986($key);
            if(is_array($value))
            {
                // If two or more parameters share the same name, they are sorted by their value
                // Ref: Spec: 9.1.1 (1)
                natsort($value);
                foreach($value as $duplicate_value)
                {
                    $pairs[] = $key . '=' . OpenSDK_Util::urlencode_rfc3986($duplicate_value);
                }
            }
            else
            {
                $pairs[] = $key . '=' . OpenSDK_Util::urlencode_rfc3986($value);
            }
        }
		
        $sign_parts = OpenSDK_Util::urlencode_rfc3986(implode('&', $pairs));
		
		$base_string = implode('&', array( strtoupper($method) , OpenSDK_Util::urlencode_rfc3986($url) , $sign_parts ));

        $key_parts = array(OpenSDK_Util::urlencode_rfc3986($this->_app_secret), OpenSDK_Util::urlencode_rfc3986($this->_token_secret));

        $key = implode('&', $key_parts);
        $sign = base64_encode(OpenSDK_Util::hash_hmac('sha1', $base_string, $key, true));
		if($this->_debug)
		{
			echo 'base_string: ' , $base_string , "\n";
			echo 'sign key: ', $key , "\n";
			echo 'sign: ' , $sign , "\n";
		}
		return $sign;
	}

	/**
	 * Http请求接口
	 *
	 * @param string $url
	 * @param array $params
	 * @param string $method 支持 GET / POST / DELETE
	 * @param false|array $multi false:普通post array: array ( 'fieldname'=>array('type'=>'mine','name'=>'filename','data'=>'filedata') ) 文件上传
	 * @return string
	 */
	private function http( $url , $params , $method='GET' , $multi=false )
	{
		//for test ,print all send params
//		ksort($params);
//		print_r($params);
		
		$method = strtoupper($method);
		$postdata = '';
		$urls = @parse_url($url);
		$httpurl = $urlpath = @$urls['path'] . (@$urls['query'] ? '?' . @$urls['query'] : '');
		if( !$multi )
		{
			$parts = array();
			foreach ($params as $key => $val)
			{
				$parts[] = urlencode($key) . '=' . urlencode($val);
			}
			if ($parts)
			{
				$postdata = implode('&', $parts);
				$httpurl = $httpurl . (strpos($httpurl, '?') ? '&' : '?') . $postdata;
			}
			else
			{
			}
		}
		
		$host = @$urls['host'];
		$port = @$urls['port'] ? @$urls['port'] : 80;
		$version = '1.1';
		if($urls['scheme'] === 'https')
        {
            $port = 443;
        }
		$headers = array();
		if($method == 'GET')
		{
			$headers[] = "GET $httpurl HTTP/$version";
		}
		else if($method == 'DELETE')
		{
			$headers[] = "DELETE $httpurl HTTP/$version";
		}
		else
		{
			$headers[] = "POST $urlpath HTTP/$version";
		}
		$headers[] = 'Host: ' . $host;
		$headers[] = 'User-Agent: OpenSDK-OAuth';
		$headers[] = 'Connection: Close';

		if($method == 'POST')
		{
			if($multi)
			{
				$boundary = uniqid('------------------');
				$MPboundary = '--' . $boundary;
				$endMPboundary = $MPboundary . '--';
				$multipartbody = '';
				$headers[]= 'Content-Type: multipart/form-data; boundary=' . $boundary;
				foreach($params as $key => $val)
				{
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'Content-Disposition: form-data; name="' . $key . "\"\r\n\r\n";
					$multipartbody .= $val . "\r\n";
				}
				foreach($multi as $key => $data)
				{
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'Content-Disposition: form-data; name="' . $key . '"; filename="' . $data['name'] . '"' . "\r\n";
					$multipartbody .= 'Content-Type: ' . $data['type'] . "\r\n\r\n";
					$multipartbody .= $data['data'] . "\r\n";
				}
				$multipartbody .= $endMPboundary . "\r\n";
				$postdata = $multipartbody;
			}
			else
			{
				$headers[]= 'Content-Type: application/x-www-form-urlencoded';
			}
		}
        $ret = '';
        $fp = fsockopen($host, $port, $errno, $errstr, 5);

        if(! $fp)
        {
            $error = 'Open Socket Error';
			return '';
        }
        else
        {
			if( $method != 'GET' && $postdata )
			{
				$headers[] = 'Content-Length: ' . strlen($postdata);
			}
            $this->fwrite($fp, implode("\r\n", $headers));
			$this->fwrite($fp, "\r\n\r\n");
			if( $method != 'GET' && $postdata )
			{
				$this->fwrite($fp, $postdata);
			}
			//skip headers
            while(! feof($fp))
            {
                $ret .= fgets($fp, 1024);
            }
			if($this->_debug)
			{
				echo $ret;
			}
			fclose($fp);
			$pos = strpos($ret, "\r\n\r\n");
			if($pos)
			{
				$rt = trim(substr($ret , $pos+1));
				$responseHead = trim(substr($ret, 0 , $pos));
				$responseHeads = explode("\r\n", $responseHead);
				$httpcode = explode(' ', $responseHeads[0]);
				$this->_httpcode = $httpcode[1];
				if(strpos( substr($ret , 0 , $pos), 'Transfer-Encoding: chunked'))
				{
					$response = explode("\r\n", $rt);
					$t = array_slice($response, 1, - 1);

					return implode('', $t);
				}
				return $rt;
			}
			return '';
        }
	}

	/**
	 * 返回上一次请求的httpCode
	 * @return number 
	 */
	public function getHttpCode()
	{
		return $this->_httpcode;
	}

	private function fwrite($handle,$data)
	{
		fwrite($handle, $data);
		if($this->_debug)
		{
			echo $data;
		}
	}
}
class OpenSDK_OAuth_Interface
{

	/**
	 * app key
	 * @var string
	 */
	protected static $_appkey = '';
	/**
	 * app secret
	 * @var string
	 */
	protected static $_appsecret = '';

	/**
	 * OAuth 版本
	 * @var string
	 */
	protected static $version = '1.0';
	
	const RETURN_JSON = 'json';
	const RETURN_XML = 'xml';
	/**
	 * 初始化
	 * @param string $appkey
	 * @param string $appsecret
	 */
	public static function init($appkey,$appsecret)
	{
		self::setAppkey($appkey, $appsecret);
	}
	/**
	 * 设置APP Key 和 APP Secret
	 * @param string $appkey
	 * @param string $appsecret
	 */
	protected static function setAppkey($appkey,$appsecret)
	{
		self::$_appkey = $appkey;
		self::$_appsecret = $appsecret;
	}

	protected static $timestampFunc = null;

	/**
	 * 获得本机时间戳的方法
	 * 如果服务器时钟存在误差，在这里调整
	 * 
	 * @return number
	 */
	public static function getTimestamp()
	{
		if(null !== self::$timestampFunc && is_callable(self::$timestampFunc))
		{
			return call_user_func(self::$timestampFunc);
		}
		return time();
	}

	/**
	 * 设置获取时间戳的方法
	 *
	 * @param function $func
	 */
	public static function timestamp_set_save_handler( $func )
	{
		self::$timestampFunc = $func;
	}

	protected static $getParamFunc = null;

	public static function getParam( $key )
	{
		if(null !== self::$getParamFunc && is_callable(self::$getParamFunc))
		{
			return call_user_func(self::$getParamFunc, $key);
		}
		return $_SESSION[ $key ];
	}

	/**
	 *
	 * 设置Session数据的存取方法
	 * 类似于session_set_save_handler来重写Session的存取方法
	 * 当你的token存储到跟用户相关的数据库中时非常有用
	 * $get方法 接受1个参数 $key
	 * $set方法 接受2个参数 $key $val
	 *
	 * @param function $get
	 * @param function $set
	 */
	public static function param_set_save_handler( $get, $set)
	{
		self::$getParamFunc = $get;
		self::$setParamFunc = $set;
	}

	protected static $setParamFunc = null;

	public static function setParam( $key , $val=null)
	{
		if(null !== self::$setParamFunc && is_callable(self::$setParamFunc))
		{
			return call_user_func(self::$setParamFunc, $key, $val);
		}
		if( null === $val)
		{
			unset($_SESSION[$key]);
			return ;
		}
		$_SESSION[ $key ] = $val;
	}

}

/**
 * Tencent 微博 SDK
 *
 * 依赖：
 * 1、PECL json >= 1.2.0	no need now
 * 2、PHP >= 5.2.0 because json_decode no need now
 * 3、$_SESSION
 * 4、PECL hash >= 1.1 no need now
 *
 * only need PHP >= 5.0
 *
 * 如何使用：
 * 1、将OpenSDK文件夹放入include_path
 * 2、require_once 'OpenSDK/Tencent/Weibo.php';
 * 3、OpenSDK_Tencent_Weibo::init($appkey,$appsecret);
 * 4、OpenSDK_Tencent_Weibo::getRequestToken($callback); 获得request token
 * 5、OpenSDK_Tencent_Weibo::getAuthorizeURL($token); 获得跳转授权URL
 * 6、OpenSDK_Tencent_Weibo::getAccessToken($oauth_verifier) 获得access token
 * 7、OpenSDK_Tencent_Weibo::call();调用API接口
 *
 * 建议：
 * 1、PHP5.2 以下版本，可以使用Pear库中的 Service_JSON 来兼容json_decode
 * 2、使用 session_set_save_handler 来重写SESSION。调用API接口前需要主动session_start
 * 3、OpenSDK的文件和类名的命名规则符合Pear 和 Zend 规则
 *    如果你的代码也符合这样的标准 可以方便的加入到__autoload规则中
 *
 * @author icehu@vip.qq.com
 */

class OpenSDK_Tencent_Weibo extends OpenSDK_OAuth_Interface
{

	private static $accessTokenURL = 'http://open.t.qq.com/cgi-bin/access_token';

	private static $authorizeURL = 'http://open.t.qq.com/cgi-bin/authorize';

	private static $requestTokenURL = 'http://open.t.qq.com/cgi-bin/request_token';

	/**
	 * OAuth 对象
	 * @var OpenSDK_OAuth_Client
	 */
	protected static $oauth = null;
	/**
	 * OAuth 版本
	 * @var string
	 */
	protected static $version = '1.0';
	/**
	 * 存储oauth_token的session key
	 */
	const OAUTH_TOKEN = 'tencent_oauth_token';
	/**
	 * 存储oauth_token_secret的session key
	 */
	const OAUTH_TOKEN_SECRET = 'tencent_oauth_token_secret';
	/**
	 * 存储access_token的session key
	 */
	const ACCESS_TOKEN = 'tencent_access_token';

	/**
	 * 存储oauth_name的Session key
	 */
	const OAUTH_NAME = 'tencent_oauth_name';
	const OPENID = 'tencent_open_id';
	const OPENKEY = 'tencent_open_key';
	/**
	 * 获取requestToken
	 *
	 * 返回的数组包括：
	 * oauth_token：返回的request_token
     * oauth_token_secret：返回的request_secret
	 * oauth_callback_confirmed：回调确认
	 * 
	 * @param string $callback 回调地址
	 * @return array
	 */
	public static function getRequestToken($callback='null')
	{
		self::getOAuth()->setTokenSecret('');
		$response = self::request( self::$requestTokenURL, 'GET' , array(
			'oauth_callback' => $callback,
		));
		parse_str($response , $rt);
		if($rt['oauth_token'] && $rt['oauth_token_secret'])
		{
			self::getOAuth()->setTokenSecret($rt['oauth_token_secret']);
			self::setParam(self::OAUTH_TOKEN, $rt['oauth_token']);
			self::setParam(self::OAUTH_TOKEN_SECRET, $rt['oauth_token_secret']);
			return $rt;
		}
		else
		{
			return false;
		}
	}

	/**
	 *
	 * 获得授权URL
	 *
	 * @param string|array $token
	 * @param bool $mini 是否mini窗口
	 * @return string
	 */
	public static function getAuthorizeURL($token , $mini=false)
	{
		if(is_array($token))
        {
            $token = $token['oauth_token'];
        }
		return self::$authorizeURL . '?oauth_token=' . $token . ($mini ? '&mini=1' : '');
	}

	/**
	 * 获得Access Token
	 * @param string $oauth_verifier
	 * @return array
	 */
	public static function getAccessToken( $oauth_verifier = false )
    {
		$response = self::request( self::$accessTokenURL, 'GET' , array(
			'oauth_token' => self::getParam(self::OAUTH_TOKEN),
			'oauth_verifier' => $oauth_verifier
		));
		parse_str($response,$rt);
		if( $rt['oauth_token'] && $rt['oauth_token_secret'] )
		{  
			self::getOAuth()->setTokenSecret($rt['oauth_token_secret']);
			self::setParam(self::ACCESS_TOKEN, $rt['oauth_token']);
			self::setParam(self::OAUTH_TOKEN_SECRET, $rt['oauth_token_secret']);
			self::setParam(self::OAUTH_NAME, $rt['name']);
			self::setParam(self::OPENID, $_GET["openid"]);
			self::setParam(self::OPENKEY, $_GET["openkey"]);
		}
		return $rt;
    }

	/**
	 * 统一调用接口的方法
	 * 照着官网的参数往里填就行了
	 * 需要调用哪个就填哪个，如果方法调用得频繁，可以封装更方便的方法。
	 *
	 * 如果上传文件 $method = 'POST';
	 * $multi 是一个二维数组
	 *
	 * array(
	 *	'{fieldname}' => array(		//第一个文件
	 *		'type' => 'mine 类型',
	 *		'name' => 'filename',
	 *		'data' => 'filedata 字节流',
	 *	),
	 *	...如果接受多个文件，可以再加
	 * )
	 *
	 * @param string $command 官方说明中去掉 http://open.t.qq.com/api/ 后面剩余的部分
	 * @param array $params 官方说明中接受的参数列表，一个关联数组
	 * @param string $method 官方说明中的 method GET/POST
	 * @param false|array $multi 是否上传文件
	 * @param bool $is_oauth 是否使用oauth方式调用，默认为是。如果置为false，则表明是用openid&openkey方式调用
	 * @param bool $decode 是否对返回的字符串解码成数组
	 * @param OpenSDK_Tencent_Weibo::RETURN_JSON|OpenSDK_Tencent_Weibo::RETURN_XML $format 调用格式
	 */
	public static function call($command , $params=array() , $method = 'GET' ,$multi=false ,$is_oauth=true, $decode=true , $format=self::RETURN_JSON)
	{
		if($format == self::RETURN_XML)
			;
		else
			$format == self::RETURN_JSON;
		$params['format'] = $format;
		//去掉空数据
		foreach($params as $key => $val)
		{
			if(strlen($val) == 0)
			{
				unset($params[$key]);
			}
		}
		$params['oauth_token'] = self::getParam(self::ACCESS_TOKEN);
		$response = self::request( 'http://open.t.qq.com/api/'.ltrim($command,'/') , $method, $params, $multi,$is_oauth);
		if($decode)
		{
			if($format == self::RETURN_JSON)
			{
				return SJson::decode($response, true);
			}
			else
			{
				//parse xml2array later
				return $response;
			}
		}
		else
		{
			return $response;
		}
	}

	/**
	 * 获得OAuth 对象
	 * @return OpenSDK_OAuth_Client
	 */
	protected static function getOAuth()
	{
		if( null === self::$oauth )
		{
			self::$oauth = new OpenSDK_OAuth_Client(self::$_appsecret);
			$secret = self::getParam(self::OAUTH_TOKEN_SECRET);
			if($secret)
			{
				self::$oauth->setTokenSecret($secret);
			}
		}
		return self::$oauth;
	}

	/**
	 *
	 * OAuth协议请求接口
	 *
	 * @param string $url
	 * @param string $method
	 * @param array $params
	 * @param array $multi
	 * @return string
	 * @ignore
	 */
	protected static function request($url , $method , $params , $multi=false,$is_oauth=true)
	{
		if(!self::$_appkey || !self::$_appsecret)
		{
			exit('app key or app secret not init');
		}
		
		if($is_oauth)
		{
			$params['oauth_nonce'] = md5( mt_rand(1, 100000) . microtime(true) );
			$params['oauth_consumer_key'] = self::$_appkey;
			$params['oauth_signature_method'] = 'HMAC-SHA1';
			$params['oauth_version'] = self::$version;
			$params['oauth_timestamp'] = self::getTimestamp();
		}
		else
		{
			/*使用openid和openkey来*/
			if ($_SESSION[self::OPENID] && $_SESSION[self::OPENKEY]){
				$params['appid'] = self::$_appkey;
				$params['openid'] = $_SESSION[self::OPENID];
				$params['openkey'] = $_SESSION[self::OPENKEY];
				$params['clientip'] = "127.0.0.1";
				$params['reqtime'] = time();
				$params['wbversion'] = '1';
				$params['pf'] = 'tapp';
			}
		}
		return self::getOAuth()->request($url, $method, $params, $multi, $is_oauth);
	}
}
