<?php
class player_main extends STpl{
	function __construct(){
		//echo $this->render("head.tpl");
	}
	function __destruct(){
		//echo $this->render("footer.tpl");
	}
	function pageEntryV3($inPath,$out="",$vid=""){
		$param=array();
		$allLanguage=array(
			"zh-cn"=>"中文 (简体)",
			"zh-tw"=>"中文 (繁體)",
			"en"=>"English",
			"ko"=>"한국어",
			"ja"=>"日本語",
		);
		$language="中文 (简体)";
		if(!empty($_COOKIE['language'])){
			$l = $_COOKIE['language'];
			if(!empty($allLanguage[$l])){
				$language = $allLanguage[$l];
				SLanguage::setLocale($l);
			}

		}
		$param['language']=$language;
		$param['allLanguage']=$allLanguage;
		$param['out']=$out;
		$param['vid']=$vid;
		$param['jsversion']=filemtime(WWW_ROOT."/"."assets/js/v3/v3.js");
		$param['cssversion']=filemtime(WWW_ROOT."/"."assets/style/default/css/fm.css");
		$style="default";

		if(!empty($inPath[3]) && $inPath[3]=="gdg"){
			//郭德纲专题
			$style="gdg";
			$param['lid']=343;
			$url = parse_url(@$_SERVER['HTTP_REFERER']);
			parse_str(@$url['query'],$params);
			$vid = @$params['vid'];
			$sina = new api_sina;
			//从POST过来的signed_request中提取oauth2信息
			if(!empty($_REQUEST["signed_request"])){
				require_once(WWW_ROOT."/lib/weibo/config.php");
				require_once(WWW_ROOT."/lib/weibo/saetv2.ex.class.php");
				$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
				$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
				if($data=='-2'){
					die('签名错误!');
				}else{
					$_SESSION['oauth2']=$data;
				}
				//判断用户是否授权
				if (empty($_SESSION['oauth2']["user_id"])) {
					$params['appkey']=WB_AKEY;
					$params['vid'] = $vid;
					return $this->render("app/sina.tpl",$params);
				} else {//若已获取到access token，则加载应用信息
					$c = new SaeTClientV2( WB_AKEY,WB_SKEY,$_SESSION['oauth2']['oauth_token'] ,'' );
					$user_id = $_SESSION['oauth2']['user_id'];
					$UserEmail = $user_id."@weibo.com";
					$db = new user_db;
					$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::SINA);
					if(empty($user)){
						//增加用户
						//新浪这个接口很慢
						$info = $c->show_user_by_id($user_id);
						$User = array();
						$User['UserAlias']=$info['name'];
						$User['UserEmail']=$UserEmail;
						$User['UserPassword']=$_SESSION['oauth2']['oauth_token'];
						$User['ParterID']=user_parter::SINA;
						$UserID = $db->addUser($User);
						$user=$db->getUserByID($UserID);
					}else{
						//更新用户
						//if($user['UserPassword']!==$_SESSION['oauth2']['oauth_token']){
						$info = $c->show_user_by_id($user_id);
						$user['UserAlias']=$info['name'];
						$user['UserPassword']=$_SESSION['oauth2']['oauth_token'];
						$db->updateUser($user);
						//}
					}
					user_api::logout();
					user_api::login($user,!empty($_REQUEST['forever']));
				}
				$param['out']="sina";
			}
		}
		$param['style']=$style;
		return $this->render("playerV3/main.tpl",$param);
	}
	function pageHeaderV3($inPath){
		$allLanguage=array(
			"zh-cn"=>"中文 (简体)",
			"zh-tw"=>"中文 (繁體)",
			"en"=>"English",
			"ko"=>"한국어",
			"ja"=>"日本語",
		);
		$param = array();
		$language="中文 (简体)";
		if(!empty($_COOKIE['language'])){
			$l = $_COOKIE['language'];
			if(!empty($allLanguage[$l])){
				$language = $allLanguage[$l];
			}

		}
		$param['language']=$language;
		$out = !empty($inPath[3])?$inPath[3]:"";
		$param['outx']=$out;
		if(($User=user_api::islogin())!==false){
			$db = new user_db;
			$action = $db->getAction($User['UserID']);
			$param['user'] = $User;
			$param['_CtListen'] = $db->getListenCount($User['UserID']);
			$param['_CtList'] = $db->getListCount($User['UserID']);
			$act = array();
			if(!empty($action->items)){
				foreach($action->items as $item){
					$k=$item['ActionType'];
					$v=$item['ct'];
					$act[$k]=$v;
				}
			}
			$param['act'] = $act;
		}
		$param['allLanguage'] = $allLanguage;
		return $this->render("playerV3/header.tpl",$param);
	}

	function pageSina($inPath){
		$url = parse_url(@$_SERVER['HTTP_REFERER']);
		parse_str(@$url['query'],$params);
		$vid = @$params['vid'];
		$sina = new api_sina;
		//从POST过来的signed_request中提取oauth2信息
		if(!empty($_REQUEST["signed_request"])){
			require_once(WWW_ROOT."/lib/weibo/config.php");
			require_once(WWW_ROOT."/lib/weibo/saetv2.ex.class.php");
			$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
			$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
			if($data=='-2'){
				die('签名错误!');
			}else{
				$_SESSION['oauth2']=$data;
			}
			//判断用户是否授权
			if (empty($_SESSION['oauth2']["user_id"])) {
				$params['appkey']=WB_AKEY;
				$params['vid'] = $vid;
				return $this->render("app/sina.tpl",$params);
			} else {//若已获取到access token，则加载应用信息
				$c = new SaeTClientV2( WB_AKEY,WB_SKEY,$_SESSION['oauth2']['oauth_token'] ,'' );
				$user_id = $_SESSION['oauth2']['user_id'];
				$UserEmail = $user_id."@weibo.com";
				$db = new user_db;
				$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::SINA);
				if(empty($user)){
					//增加用户
					//新浪这个接口很慢
					$info = $c->show_user_by_id($user_id);
					$User = array();
					$User['UserAlias']=$info['name'];
					$User['UserEmail']=$UserEmail;
					$User['UserPassword']=$_SESSION['oauth2']['oauth_token'];
					$User['ParterID']=user_parter::SINA;
					$UserID = $db->addUser($User);
					$user=$db->getUserByID($UserID);
				}else{
					//更新用户
					//if($user['UserPassword']!==$_SESSION['oauth2']['oauth_token']){
					$info = $c->show_user_by_id($user_id);
					$user['UserAlias']=$info['name'];
					$user['UserPassword']=$_SESSION['oauth2']['oauth_token'];
					$db->updateUser($user);
					//}
				}
				user_api::logout();
				user_api::login($user,!empty($_REQUEST['forever']));
			}
		}
		return $this->pageEntry($inPath,"sina",@$params['vid']);
	}
	/**
	 * QQ空间
	 * 腾讯朋友
	 */
	function pageQQ($inPath,$out="qq"){
		if(empty($_GET['openkey']) || empty($_GET['openid'])){
			return $this->pageEntry($inPath,"qq");
		}
		include_once(WWW_ROOT.'/lib/qq/qzone/qzone.class.1.0.0.php');
		include_once(WWW_ROOT.'/lib/qq/qzone/qzone.config.php');
		$qzone = new Qzone(QQ_QZONE_APPID, QQ_QZONE_APPKEY, QQ_QZONE_APPNAME);
		$qzone->setServerName(QQ_QZONE_SERVER);
		$openid = $_GET['openid'];
		$openkey = $_GET['openkey'];
		$_SESSION['qq_openid'] = $openid;
		$_SESSION['qq_openkey'] = $openkey;
		$result = $qzone->getUserInfo($openid, $openkey);
		if(!isset($result['ret']) || $result['ret']!==0){
			user_api::logout();
		}else{
			$UserEmail=$openid."@qq.com";
			$db = new user_db;
			$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::TENCENT);
			if(empty($user)){
				//增加用户
				$User = array();
				$User['UserAlias']=$result['nickname'];
				$User['UserEmail']=$UserEmail;
				$User['UserPassword']=$openkey;
				$User['ParterID']=user_parter::TENCENT;
				$UserID = $db->addUser($User);
				$user=$db->getUserByID($UserID);
			}else{
				//更新用户
				if($user['UserAlias']!==$result['nickname']){
					$user['UserAlias']=$result['nickname'];
					$user['UserPassword']=$openkey;
					$db->updateUser($user);
				}
			}
			user_api::logout();
			user_api::login($user,!empty($_REQUEST['forever']));
		}
		return $this->pageEntry($inPath,$out);
	}
	/**
	 * QQ微薄
	 */
	function pageQQWeibo($inPath){

		include_once(WWW_ROOT.'/lib/qq/weibo/config.php');
		if( isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) //第5，6步
		{
			
			//从Callback返回时
			if(OpenSDK_Tencent_Weibo::getAccessToken($_GET['oauth_verifier']))
			{
				//此时已经可以正常调用CGI
				$uinfo = OpenSDK_Tencent_Weibo::call('user/info');
				if(!empty($uinfo->data)){
					$openid = $uinfo->data->openid;
					$openkey = empty($_REQUEST['openkey'])?"":$_REQUEST['openkey'];
					$nick = $uinfo->data->nick;
				//	$email = $uinfo->data->email;

					
					$UserEmail=$openid."@qq.com";

					$db = new user_db;
					$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::TENCENT);
					if(empty($user)){
						//增加用户
						$User = array();
						$User['UserAlias']=$nick;
						$User['UserEmail']=$UserEmail;
						$User['UserPassword']=$openkey;
						$User['ParterID']=user_parter::TENCENT;
						$UserID = $db->addUser($User);
						$user=$db->getUserByID($UserID);
					}else{
						//更新用户
						if($user['UserAlias']!==$nick){
							$user['UserAlias']=$nick;
							$user['UserPassword']=$openkey;
							$db->updateUser($user);
						}
					}
					user_api::logout();
					user_api::login($user,!empty($_REQUEST['forever']));
					return $this->pageEntry($inPath,"qqweibo");
				}
			}
		}
		$callback = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
		$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
		header('Location: ' . $url);
	}
	/**
	 * WebQQ
	 */
	function pageQQWeb($inPath){
		return $this->pageQQ($inPath);
		//下面的app_openid有问题，tencent没有与QQ号绑定，shit!!!!!!!!!!!!!!!!!!!
		include_once(WWW_ROOT.'/lib/qq/webqq/webqq_openid.class.php');
		$openId = new WebQQ_OpenID(
			'400012205',		// 填入应用 ID
			'SVvr3vDp1SxfUTpq'	// 填入应用的通信密钥。此参数仅有 WebQQ 和开发者自己知晓，请勿公开！！
		);
		if(empty($_GET['app_openid']) || empty($_GET['app_openkey']) || !$openId->checkSig()){
			return $this->pageEntry($inPath,"qq");
		}
		$UserEmail=$_GET['app_openkey']."@qq.com";
		$db = new user_db;
		$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::TENCENT);
		if(empty($user)){
			//增加用户
			//新浪这个接口很慢
			$User = array();
			$User['UserAlias']="";
			$User['UserEmail']=$UserEmail;
			$User['UserPassword']=$_GET['app_openkey'];
			$User['ParterID']=user_parter::TENCENT;
			$UserID = $db->addUser($User);
			$user=$db->getUserByID($UserID);
		}else{
			//更新用户
			//$user['UserAlias']="";
			//$user['UserPassword']=$_GET['app_openkey'];
			//$db->updateUser($user);
		}
		user_api::logout();
		user_api::login($user,!empty($_REQUEST['forever']));
		return $this->pageEntry($inPath,"qq");
	}
	function pageSohu($inPath){
		return $this->pageEntry($inPath,"sohu");
	}
	function pageNetease($inPath){
		include_once(WWW_ROOT.'/lib/netease/t163_php_sdk/config.php');
		include_once(WWW_ROOT.'/lib/netease/t163_php_sdk/api/tblog.class.php');
		if(empty($_REQUEST["oauth_token"])){
			unset($_SESSION['access_token']);
			unset($_SESSION['request_token']);
			$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
			$request_token = $oauth->getRequestToken();
			$aurl = $oauth->getAuthorizeURL( $request_token['oauth_token'],
				"http://".$_SERVER['HTTP_HOST'].'/player.main.netease'
			);
			$_SESSION['request_token'] = $request_token;
			return $this->redirect($aurl);
			//return $this->render("app/netease.tpl",$params=array("aurl"=>$aurl));
		}else{
			if(empty($_SESSION['access_token'])){
				$oauth = new OAuth( CONSUMER_KEY, CONSUMER_SECRET , $_SESSION['request_token']['oauth_token'] , $_SESSION['request_token']['oauth_token_secret']  );

				if ($access_token = $oauth->getAccessToken($_REQUEST['oauth_token'])){
					$_SESSION['access_token'] = $access_token;
				}else{
					unset($_SESSION['access_token']);
					$this->redirect("/player.main.netease");
				}
			}else{
				$access_token = $_SESSION['access_token'];
			}
			if(empty($_SESSION['access_token']) || !empty($_SESSION['access_token']['oauth_problem'])){
				unset($_SESSION['access_token']);
				$this->redirect("/player.main.netease");
			}

			$tblog = new TBlog(CONSUMER_KEY, CONSUMER_SECRET,$access_token['oauth_token'] , $access_token['oauth_token_secret']);
			$me = $tblog->show_user_id("");
			if(!empty($me['email'])){
				$UserEmail = $me['email'];
				$db = new user_db;
				$user = $db->getUserByEmail($UserEmail,$paterid=user_parter::NETEASE);
				if(empty($user)){
					//增加用户
					//新浪这个接口很慢
					$User = array();
					$User['UserAlias']=$me['name'];
					$User['UserEmail']=$me['email'];
					$User['UserPassword']="";
					$User['ParterID']=user_parter::NETEASE;
					$UserID = $db->addUser($User);
					$user=$db->getUserByID($UserID);
				}else{
					//更新用户
					//if($user['UserPassword']!==$_SESSION['oauth2']['oauth_token']){
					if($user['UserAlias']!==$me['name']){
						$user['UserAlias']=$me['name'];
						$user['UserPassword']="";
						$db->updateUser($user);
					}
					//}
				}
				$user['UserPassword']=SJson::encode($access_token);
				user_api::logout();
				user_api::login($user,!empty($_REQUEST['forever']));
			}
		}
		return $this->pageEntry($inPath,"netease",@$params['vid']);
	}
	function pageFaceBook($inPath){
		return $this->pageEntry($inPath,"facebook");
	}
	function pageRenren($inPath){
		return $this->pageEntry($inPath,"renren");
	}
	function pageEntryOld($inPath,$out="",$vid=""){
		$param=array();
		$param['v']=array("1"=>"32","2"=>"DD");
		$allLanguage=array(
			"zh-cn"=>"中文 (简体)",
			"zh-tw"=>"中文 (繁體)",
			"en"=>"English",
			"ko"=>"한국어",
			"ja"=>"日本語",
		);
		$language="中文 (简体)";
		if(!empty($_COOKIE['language'])){
			$l = $_COOKIE['language'];
			if(!empty($allLanguage[$l])){
				$language = $allLanguage[$l];
			}

		}
		$param['language']=$language;
		$param['allLanguage']=$allLanguage;
		$param['out']=$out;
		$param['vid']=$vid;
		$param['jsversion']=filemtime(WWW_ROOT."/"."assets/js/youku.ws.js");
		$param['cssversion']=filemtime(WWW_ROOT."/"."assets/css/styleV2.css");
		return $this->render("player/playerV2.tpl",$param);
	}
	function pageEntry($inPath,$out="",$vid=""){
		return $this->pageEntryV3($inPath,$out,$vid);
		/*
		$param=array();
		$param['v']=array("1"=>"32","2"=>"DD");
		$allLanguage=array(
			"zh-cn"=>"中文 (简体)",
			"zh-tw"=>"中文 (繁體)",
			"en"=>"English",
			"ko"=>"한국어",
			"ja"=>"日本語",
		);
		$language="中文 (简体)";
		if(!empty($_COOKIE['language'])){
			$l = $_COOKIE['language'];
			if(!empty($allLanguage[$l])){
				$language = $allLanguage[$l];
			}

		}
		$param['language']=$language;
		$param['allLanguage']=$allLanguage;
		$param['out']=$out;
		$param['vid']=$vid;
		$param['jsversion']=filemtime(WWW_ROOT."/"."assets/js/youku.ws.js");
		$param['cssversion']=filemtime(WWW_ROOT."/"."assets/css/styleV2.css");
		return $this->render("player/playerV2.tpl",$param);
		*/
	}
	function pageHeader($inPath){
		$param = array();
		$out = !empty($inPath[3])?$inPath[3]:"";
		$param['out']=$out;
		if(($User=user_api::islogin())!==false){
			$db = new user_db;
			$action = $db->getAction($User['UserID']);
			$param['user'] = $User;
			$param['_CtListen'] = $db->getListenCount($User['UserID']);
			$param['_CtList'] = $db->getListCount($User['UserID']);
			$act = array();
			if(!empty($action->items)){
				foreach($action->items as $item){
					$k=$item['ActionType'];
					$v=$item['ct'];
					$act[$k]=$v;
				}
			}
			$param['act'] = $act;
		}
		return $this->render("player/headerV2.tpl",$param);
	}
	/**
	 * 跳过视频,顶视频,踩视频
	 * 如果登录,记住用户跳过的记录,如果没有登录,只是更新s_mv
	 * @param $actiontype=$inPath[3] skip|up|down
	 * 0 喜欢(up)
	 * 1 删除(down)
	 * 2 跳过(skip)
	 * @param $vid=$inPath[4] 
	 */
	function pageVideoAction($inPath){
		$result=new stdclass;
		if(!empty($inPath[3]) && !empty($inPath[4])){
			switch($inPath[3]){
			case "up":
				$fileds="VideoUpTimes";
				$actiontype = 0;
				break;
			case "down":
				$fileds="VideoDownTimes";
				$actiontype = 1;
				break;
			case "skip":
				$fileds="VideoSkipTimes";
				$actiontype = 2;
				break;
			default:
				return $result;
			}
			$db = new video_db;
			$extension = $db->getVideoExtension($inPath[4]);
			if(empty($extension)){
				$r = $db->addVideoExtension(array("$fileds=1","VideoID"=>$inPath[4]));
			}else{
				$r = $db->updateVideoExtension($inPath[4],array("$fileds=$fileds+1"));
			}
			$result->result = ($r!==false) ? true : false;
			$result->type=$inPath[3];
			if(($User=user_api::islogin())!==false){
				$user_db = new user_db;
				$record=$user_db->addAction(array("UserID"=>$User['UserID'],"VideoID"=>$inPath[4],"ActionType"=>$actiontype));
				if($record!==false){
					$result->record=true;
				}else{
					$result->record=false;
				}
			}

		}
		return $result;
	}
	function pageDelAction($inPath){
		if(($User=user_api::islogin())!==false && isset($_REQUEST['actiontype']) && !empty($_REQUEST['vid'])){
			$VideoID= $_REQUEST['vid'];
			$ActionType = $_REQUEST['actiontype'];
			$UserID=$User['UserID'];
			$db = new user_db;
			return $db->delAction($UserID,$VideoID,$ActionType);
		}
	}
	function pageDelActionV3($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['vid'])){
			$VideoID= $_REQUEST['vid'];
			$action =!empty($inPath[3])?$inPath[3]:"";
			switch($action){
				case "up":	$actiontype=0;	break;
				case "down":$actiontype=1;	break;
				case "skip":$actiontype=2;	break;
				default:return false;
			}
			$UserID=$User['UserID'];
			$db = new user_db;
			return $db->delAction($UserID,$VideoID,$ActionType);
		}
	}
	function pageListAction($inPath){
		if(($User=user_api::islogin())!==false){
			$action =!empty($inPath[3])?$inPath[3]:"";
			$page =!empty($inPath[4])?$inPath[4]:1;
			switch($action){
				case "up":	$actiontype=0;	break;
				case "down":$actiontype=1;	break;
				case "skip":$actiontype=2;	break;
				default:return false;
			}
			$db = new user_db;
			$video_api = new video_api;
			$r = $db->listAction($User['UserID'],$actiontype,$page,$size=10);
			if(!empty($r->items)){
				foreach($r->items as &$item){
					$item = $video_api->getVideoInfo($item['VideoID']);
				}
			}
			$r->actiontype=$actiontype;
			return $r;
		}
	}
	function pageRadioList($inPath){
		$db = new user_db;
		return $db->ListRadioList();
	}
	function pageRadio($inPath){
		$defaultChannelID=2;
		$chanelId=empty($_REQUEST['cid'])?$defaultChannelID:$_REQUEST['cid'];

		$video_api = new video_api;
		if($chanelId==5){
			$video_db = new video_db;
			$r = $video_db->listVideoRand(30);
		}else{
			$user_db = new user_db;
			$r = $user_db->listContentRand($chanelId);
			if(empty($r->items)){
				$r = $user_db->listContentRand($defaultChannelID);
			}

		}
		foreach($r->items as &$item){
			$item = $video_api->getVideoInfo($item['VideoID']);
		}

		$r->cid = $chanelId;
		return $r;
	}
	/**
	 * 增加MV
	 * @param $VideoName
	 * @param $VideoID (url)
	 * @param [$VideoListID]
	 */

	function pageAddVideo($inPath){
		$vid = $_REQUEST['vid'];
		if(!empty($vid)){
			$api = new video_api;
			return $api->getVideoByVid($vid);
		}
	}
	function pageGetVideoByVid($inPath){
		$vid = $_REQUEST['vid'];
		if(!empty($vid)){
			$api = new video_api;
			return $api->getVideoInfo($vid);
		}
	}
	/**
	 * 获取已经播放历史
	 * @param $page $inPath[3]
	 **/
	function pageListListen($inPath){
		if(($User=user_api::islogin())!==false){
			$page =!empty($inPath[3])?$inPath[3]:1;
			$size =!empty($inPath[4])?$inPath[4]:10;
			$db = new user_db;
			$video_api = new video_api;
			$r= $db->ListListen($User['UserID'],$page,$size);
			if(!empty($r->items)){
				foreach($r->items as &$item){
					$item = $video_api->getVideoInfo($item['VideoID']);
				}
			}
			return $r;
		}
	}
	function pageAddListen($inPath){
		if(($User=user_api::islogin())!==false && !empty($_REQUEST['vid'])){
			$db = new user_db;
			$video_db = new video_db;
			$vid = singer_music::decode($_REQUEST['vid']);
			$api = new video_api;
			$v=$api->getVideo($vid);
			if(!empty($v) && ($r=$db->addListen(array("VideoID"=>$v['VideoID'],"UserID"=>$User['UserID'])))!==false){
				return true;
			}
		}
		return false;
	}
	function pageDelListen($inPath){
		if(($User=user_api::islogin())!==false){
			$db = new user_db;
			$UserID= $User['UserID'];
			$vids = array();
			if(!is_array($_REQUEST['vid'])){
				$vids = array($_REQUEST['vid']);
			}else{
				$vids = $_REQUEST['vid'];
			}
			foreach($vids as $vid){
				$VideoID= singer_music::decode($vid);
				return $db->delListen($UserID,$VideoID);
			}
		}
		return false;
	}
	/*获取曲库信息*/
	function pageGetMusic($inPath){
		$vid = singer_music::decode($_REQUEST['vid']);
		$video_api= new video_api;
		return $video_api->getVideoInfo($vid);
	}
	/**获取歌手信息和歌手歌曲列表*/
	function pageGetSinger($inPath){
		$sid = $_REQUEST['sid'];
		$video_api = new video_api;
		$sphinx_api = new sphinx_api;
		$r = new stdclass;
		$r->items = $sphinx_api->listBySingerID($sid);
		if(!empty($r->items)){
			foreach($r->items as &$item){
				$item = $video_api->getVideoInfoByLuceneVideo($item);
			}
		}
		return $r;
	}
	/**获取歌手信息和歌手歌曲列表*/
	function pageGetSingerV3($inPath){
		$sid = $_REQUEST['sid'];
		$page = empty($inPath[3])?1:$inPath[3];
		$video_api = new video_api;
		$sphinx_api = new sphinx_api;
		$r = $sphinx_api->listBySingerIDV3($sid,$page,10);
		if(!empty($r->items)){
			foreach($r->items as &$item){
				$item = $video_api->getVideoInfoByLuceneVideo($item);
			}
		}
		return $r;
	}
	/**获取专辑信息*/
	function pageGetAlbumV3($inPath){
		//从搜索出数据
		$sid = $_REQUEST['sid'];
		$page = empty($inPath[3])?1:$inPath[3];
		$video_db= new video_db;
		$video_api = new video_api;
		$r = $video_db->listVideoByAlbumID($sid,$page,10);
		if(!empty($r->items)){
			foreach($r->items as &$item){
				$item = $video_api->getVideoInfo($item['VideoID']);
			}
		}
		return $r;
	}
	/**获取专辑信息*/
	function pageGetAlbum($inPath){
		//从搜索出数据
		$sid = $_REQUEST['sid'];
		$video_db= new video_db;
		$video_api = new video_api;
		$r = $video_db->listVideoByAlbumID($sid);
		if(!empty($r->items)){
			foreach($r->items as &$item){
				$item = $video_api->getVideoInfo($item['VideoID']);
			}
		}
		return $r;
	}
	/**
	 * 读取歌词
	 **/
	function pageGetLyric($inPath){
		$db = new video_db;
		$vid = singer_music::decode($_REQUEST['vid']);
		$api = new video_api;
		$mv  = $api->getVideoInfo($vid);
		if(!empty($mv)){
			$lyric = $db->getLyrics($mv['VideoID']);
			if(empty($lyric) || $lyric['LyricsStatus']==-2)
			{
				$api = new video_api;
				$k = (!empty($mv['Singers'][0]['SingerName'])?$mv['Singers'][0]['SingerName']." ":"").$mv['VideoName'];
				$content = $api->downlyric($k);
				if(empty($content))$content="";
				if(!empty($content)){
					$lyric['LyricsStatus']=1;
				}else{
					$lyric['LyricsStatus']=-1;
				}
				//这样只下载一次，避免被发现有问题
				$lyric = array();
				$lyric['LyricsContent']=$content;
				$lyric['LyricsOffset']=0;
				$lyric['UserID']=1;
				$lyric['VideoID']=$mv['VideoID'];
				$db->addLyrics($lyric);
			}
			return $lyric;
		}
		return array();
	}


	function pageSaveOffset($inPath){
		$VideoID= singer_music::decode($_REQUEST['VideoID']);
		$offset = $_REQUEST['offset'];
		if(empty($VideoID) || !isset($offset)){
			return;
		}
		$db = new video_db;
		$lyric = $db->getLyrics($VideoID);
		if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
			return;
		}
		$db->updateLyrics($VideoID,array("LyricsOffset"=>$offset));
		return true;
	}
	function pageLyricsError($inPath){
		$VideoID= singer_music::decode($_REQUEST['VideoID']);
		if(empty($VideoID)){
			return;
		}
		$db = new video_db;
		$lyric = $db->getLyrics($VideoID);
		if(empty($lyric)  || $lyric['UserID']!=1){//TODO，当前登录用户
			return;
		}
		$db->updateLyrics($VideoID,array("LyricsStatus"=>-2));
		return true;
	}
	function pageComplete($inPath){
		$k = $_REQUEST['k'];
		if(empty($k))return "[]";
		$k = urlencode($k);
		$r = file_get_contents("http://tip.so.youku.com/search_keys?type=video&k=$k&limit=15");
		if($r){
			preg_match("/\[.*?\]/",$r,$_m);
			if(!empty($_m)){
				$keywords=array();
				$r = SJson::decode($_m[0]);
				if(!empty($r)){
					for($i=0;$i<count($r);$i++){
						$tmp = str_replace(array("mv","mtv"),"",$r[$i]->keyword);
						if(!empty($keywords[$tmp])){
							unset($r[$i]);
						}else{
							$keywords[$tmp]=1;
							$r[$i]->keyword=$tmp;
						}
					}
				}
				sort($r);
				return $r;
			}
		}
		return "[]";
	}
	function pageSearch($inPath){
		$k = $_REQUEST['k'];
		if(empty($k))return;
		$video_api = new video_api;

		$sphinx_api = new sphinx_api;
		$r = $sphinx_api->search($k,1000,$mustHaveSingers=true);
		if(!empty($r)){
			foreach($r as &$item){
				$item = $video_api->getVideoInfoByLuceneVideo($item);
			}
		}else{
			$r=$video_api->search($k);
		}
		return $r;
	}
	function pageSearchV3($inPath){
		$k = $_REQUEST['k'];
		if(empty($k))return;
		$k = mb_convert_encoding($k,"utf8","utf8,gbk");
		$video_api = new video_api;
		$page = empty($inPath[3])?1:$inPath[3];

		$sphinx_api = new sphinx_api;
		$r = $sphinx_api->searchV3($k,$page,10,$mustHaveSingers=true);
		if(!empty($r->items)){
			foreach($r->items as &$item){
				$item = $video_api->getVideoInfoByLuceneVideo($item);
			}
		}
		if(empty($r->items) || count($r->items)<=5)){
			$r2=$video_api->searchV3($k,$page,10-count($r->items));
			$r->items = array_merge($r->items,$r2->items);
		}
		return $r;
	}
	/*得到视频信息*/
	function pageGetVideo($inPath){
		$api = new video_api;
		$k = $_REQUEST['k'];
		return $api->getVideoInfoByURL($k);
	}
}
?>
