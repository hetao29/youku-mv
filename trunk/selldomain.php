<?php
$host = $_SERVER['HTTP_HOST'];
$e = explode(".",$host);
if(count($e)<2){
	$host = $e[0];
}else{
	$b = $e[count($e)-2];
	$b = strtoupper($b{0}).substr($b,1);
	$host = $b . "." . strtoupper($e[count($e)-1]);
}
$hostname = strtolower($host);
if(stristr($_SERVER['HTTP_ACCEPT_LANGUAGE'],"zh")!==false){
	$title="此域名出售";
	$contact="请联系";
	$inCN=1;
	$info = "";
}else{
	$inCN=1;
	$title="This domain is for sale(10,000$)";
	$contact="Please contact me";
	$info="";
}



@mkdir("log");
if(function_exists("date_default_timezone_set"))date_default_timezone_set("Asia/Shanghai");

//记下所有域名信息,和访问次数
$dataFile = "log/".date("Ym",time()).".data";
$alldomains=unserialize(@file_get_contents($dataFile));

if(!is_array($alldomains))$alldomains=array();
if(!empty($_REQUEST['xxxxxx'])){
	print_r($alldomains);
	exit;
}

if(!isset($alldomains[$hostname]))$alldomains[$hostname]=1;
else $alldomains[$hostname]+=1;

file_put_contents($dataFile,serialize($alldomains),LOCK_EX);

//记下LOG
$logFile = "log/".date("Ym",time()).".log";
$logData = date("[Y-m-d H:i:s",time())."][".getIp()."] ".$hostname."\t";
if(!empty($_SERVER['HTTP_REFERER']))
$logData .=$_SERVER['HTTP_REFERER'];
$logData .="\r\n";
file_put_contents($logFile,$logData,FILE_APPEND |LOCK_EX);

//如果是新域名,抓取whois信息中的电话和邮箱

//获取whois信息
//1.(COM/NET/WS)从whois.internic.com获取到 whois服务器
//2.再从 whois服务器上获取信息
//print_r(dns_get_record ("youku.ws"));
/*
$whois = new Whois_class();
if($whois->checkDomain("sina", "tw") == TRUE){
	echo "Available";
}else{
	echo "Taken";
}

class Whois_class{
    var $serverList = array(
		'com'	=> array(	'server'	=> 'whois.internic.com',	'response'	=> 'No match for'),
		'net'	=> array(	'server'	=> 'whois.internic.com',	'response'	=> 'No match for'),
		'ws'	=> array(	'server'	=> 'whois.worldsite.ws',	'response'	=> 'No match for'),
		'cn'	=> array(	'server'	=> 'whois.cnnic.net.cn',	'response'	=> 'No match for'),
		'tw'	=> array(	'server'	=> 'whois.twnic.net.tw',	'response'	=> 'No Found'),
		'info'	=> array(	'server'	=> 'whois.afilias.net',		'response'	=> 'NOT FOUND'),
		'name'	=> array(	'server'	=> 'whois.nic.name',		'response'	=> 'No match'),
		'eu'	=> array(	'server'	=> 'whois.nic.biz',			'response'	=> 'Not found'),
		'lt'	=> array(	'server'	=> 'whois.domreg.lt',		'response'	=> 'available'),
		'eu'	=> array(	'server'	=> 'whois.eu',				'response'	=> 'FREE'),
		'us'	=> array(	'server'	=> 'whois.nic.us',			'response'	=> 'FREE'),
		'cc'	=> array(	'server'	=> 'whois.nic.cc',			'response'	=> 'FREE'),
		'biz'	=> array(	'server'	=> 'whois.neulevel.biz',	'response'	=> 'FREE'),
		'org'	=> array(	'server'	=> 'whois.publicinterestregistry.net',	'response'	=> 'NOT FOUND'),
	);

	function checkDomain($name, $top){
		$domain		= $name . "." . $top;
		$server		= $this->serverList[$top]["server"];
		$findText	= $this->serverList[$top]["response"];

		try{
			$con = fsockopen($server, 43);
		}
		catch(Exception $e){
			return FALSE;
		}
		
		fputs($con, $domain."\r\n");
			
		$response = "";
		while(!feof($con)){
			$response .= fgets($con, 128); 
		}
		
		// removing all comments from the response
		// this is needed due to some *smart* whois, who have same text saying the domain is availible
		// along with the same text in comments, even if the domain is NOT availible (-;
		$response = preg_replace("/%.*\n/", "", $response);
		
		echo $response . chr(10);
		
		fclose($con);
			
		if(strpos($response, $findText)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

exit;*/
function getIP($long=false){
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";

    return $ip;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE><?php echo $title;?>-<?php echo $host;?></TITLE>
<meta name="title" content="<?php echo $title;?> - <?php echo $host;?>">
<meta name="keywords" content="<?php echo $title;?> - <?php echo $host;?>">
<meta name="description" content="<?php echo $title;?> - <?php echo $host;?>" />
<style>
body { text-align:center; background-color:#515151; }
a{color: #CCC;text-decoration: none;}
#page { text-align:center;margin:0 auto;width:760px; }
/*div{border:inset}*/
#header{padding-bottom:10px;padding-top:10px;}
#main{background-color:#393939; padding-top:35px;}
#info{color: #CCC;font-size:12px;padding:10px;}
#footer{padding-top:20px;color:#777;font-size: 12px;}
.domain{color:#CCC;font-size:24px;font-weight: bold;}
.text{color: #CCC;font-size:14px;}
.clear{clear:both}
.right{float:right;}
.left{float:left;}

</style>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15949841-1");
pageTracker._setDomainName("none");
pageTracker._setAllowLinker(true);
pageTracker._trackPageview();
} catch(err) {}</script>
<BODY>
<div id="page">
  <div id="header">
    <div class="left domain"><?php echo $host;?></div>
    <div class="right text" ><?php echo $title;?></div>
    <div class="clear"></div>
    <div class="right text"><?php echo $contact;?><span id="contact"></span></div>
    <div class="clear"></div>
  </div>
  <div id="main">
    <div id="id1" class="left" style="width:49%; padding-left:13px;">
      <script type="text/javascript"><!--
google_ad_client = "pub-8444474852440924";
/* 300x250, 创建于 10-4-20 */
google_ad_slot = "3548629920";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
      <script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
    </div>
    <div id="id2" class="left"  style="width:49%;" >
      <script type="text/javascript"><!--
google_ad_client = "pub-8444474852440924";
/* 300x250, 创建于 10-4-20 */
google_ad_slot = "3548629920";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
      <script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
    </div>
    <div class="clear"></div>
    <div style="padding-top:40px; width:100%; padding-bottom:20px;">
      <script type="text/javascript"><!--
  google_ad_client = "pub-8444474852440924";
  google_ad_format = "js_sdo";
  google_color_bg = "393939";
  google_cts_mode ="rs";
  google_num_cts = "3";
  google_cts_font_size = "14";
  google_color_link = "CCCCCC";
  google_searchbox_width = 215;
  google_searchbox_height = 26;
  google_link_target = 2;
  google_ad_channel = "8844582402";
  google_rs_pos = "right";
  google_ad_height = 35;
  google_ad_width = 500;
//-->
</script>
      <script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_sdo.js">
</script>
    </div>
  </div>
  <div id="info"></div>
  <div id="footer">Copyright © 2010 <?php echo $host;?> All Rights Reserved. </div>
</div>
<script type="text/javascript">
var info="<?php echo $info;?>";
<?php
//http://dean.edwards.name/packer/
?>
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('e $(2){d 3.c(2)}$("4").b=",9:<a 7=\'8:0@0.1\'>0@0.1</a> 5:6";',15,15,'hetao|name|t|document|contact|QQ|231073376|href|mailto|Email||innerHTML|getElementById|return|function'.split('|'),0,{}))
$("info").innerHTML=info;
</script>
</BODY>
<!-- hetal,2010/04/20-->
</HTML>
