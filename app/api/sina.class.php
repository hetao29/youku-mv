<?php
define( "WB_AKEY" , '1540972486' );
define( "WB_SKEY" , 'd79244b4e304f84c356708ba38f40c4a' );
require_once(WWW_ROOT."/lib/weibo/saetv2.ex.class.php");
class api_sina{
	function postWeibo($msg){
		if(($user=user_api::islogin())!==false){
			$token=$user['UserPassword'];
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token);
			//$ms  = $c->home_timeline(); // done
			//$uid_get = $c->get_uid();
			//$uid = $uid_get['uid'];
			//$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			$r = $c->update($msg,NULL,NULL,array(array('x'=>'xx')));
			if(!empty($r['id'])){
				return true;
			}
			error_log(var_export($token,true),3,	"/opt/youku-fm-read-only/youkufm_api_error_log");
			error_log(var_export($c,true),3,	"/opt/youku-fm-read-only/youkufm_api_error_log");
			error_log(var_export($r,true),3,	"/opt/youku-fm-read-only/youkufm_api_error_log");
			//exit;
		}
		return false;

	}
}
