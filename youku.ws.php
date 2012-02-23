<?php
//$url="http://v.youku.com/v_show/id_XMjEyNzcwMzEy.html";
if(!empty($_REQUEST['url'])){
	$url_shorted = video::encode($_REQUEST['url']);
	$url_shorted = "http://youku.ws/$url_shorted";
}
//echo $a=str_replace("=","",base64_encode(pack("N",83032030)));
//print_r(unpack("N",base64_decode($a)));
//print_r($a = video::encode($url));
//print_r(video::decode($a));
class video{
	/**
	 * 把短网址：http://youku.ws/JEOWES
	 * 变长网址：http://v.youku.com/v_show/id_XMjEyNzcwMzEy.html 
	 */
	public static function decode($videoId){
		$vid = unpack("L",base64_decode($videoId));
		if(!empty($vid[1])){
			return "X".(base64_encode($vid[1]<<2));
		}
	}
	/**
	 * 把长网址：http://v.youku.com/v_show/id_XMjEyNzcwMzEy.html 
	 * 变短网址：http://youku.ws/JEOWES
	 */
	public static function encode($videoId){
		
		preg_match("/id_(.+?)\./i",$videoId,$m);
		if(!empty($m[1])){
			$videoId = $m[1];
			$vid = base64_decode(substr($videoId,1))>>2;
			return str_replace("=","",base64_encode(pack("L",$vid)));
		}
	}
}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="">
		<title>Youku.WS(优酷WebStart短网址服务)</title>

		<style>
		body{max-width:none;margin:0;padding:0}
		#page{
			margin: 0 auto;clear:both;width:720px;
		}
		#footer{
			text-align:left;
		}
		#shorten_container{background:#e5ecf9;padding:.5em 1em;vertical-align:middle;white-space:nowrap}
		#shorten{font-size:120%}
		#shorten{height:1.33em;margin-right:.2em;padding:0;width: 585px;border:1px solid #666}
		#shorten_button{width:5.5em}

		button{
				font:inherit;-webkit-appearance:button;background-color:#eee;
				background-image:-webkit-gradient(linear,0% 0%,0% 100%,from(white),to(#ddd));
				background-image:-moz-linear-gradient(center bottom,#ddd,white);
				filter:progid:DXImageTransform.Microsoft.Gradient(startColorstr='white',endColorstr='#dddddd');
				border:1px solid #999;padding:0 8px;*padding:0
		}
		button:active{
			background-color:#ccc;
			background-image:-webkit-gradient(linear,0% 0%,0% 100%,from(#ccc),to(#ddd));
			background-image:-moz-linear-gradient(center bottom,#ddd,#ccc);
			filter:progid:DXImageTransform.Microsoft.Gradient(startColorstr='#cccccc',endColorstr='#dddddd')
		}
		button p{line-height:2;margin:0}

		</style>
</head>
<body>
	<div id="page">
		<div style="padding-top:30px;padding-bottom:30px;">
			<a>
				<img id="logo" src="http://static.youku.com/v1.0.0742/index/img/youkulogo-s.png">
			</a>
		</div>
		<div id="shorten_container">
			<form id="shorten_form" action="" method="get">
				<div style="padding-top:30px"><label for="shorten">请输入优酷视频播放页地址：</label></div>
				<div id="shorten_line">
					<input type="text" id="shorten" name="url" tabindex="1" value="<?php echo @$_REQUEST['url'];?>">
					<button id="shorten_button" type="submit"><p>变短</p></button>
				</div>
				
				<div style="padding-top:30px"><label for="shorten">简短后视频播放页地址：	</label></div>
				<div id="shorten_line">
					<a href="<?php echo @$url_shorted;?>"><?php echo @$url_shorted;?></a>
				</div>
			</form>
		</div>

		<p id="footer"><span>© 2011 Youku.WS</span></p>
	</div>

</body></html>