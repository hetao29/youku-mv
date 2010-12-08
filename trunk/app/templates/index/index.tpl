<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>YOUKU.WS</title>
				<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="/slightphp/js/jquery-1.4.4.min.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<!--<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom.css" media="all" rel="stylesheet" type="text/css" />
				-->
				{literal}
				<script type="text/javascript">
						var playerId="player";
						function onPlayerStart(vid,vidEncoded){
								//PlayerColor("000000","4F4F4F",25);
						}
function onPlayerError(vid){
		//PlayerColor("000000","4F4F4F",25);
}
//$(function() {
//$( ".list" ).sortable();
//$( ".list" ).disableSelection();
//});
$(document).ready(function(){
				$("#_IDPlayer").click(function(){
						window.open($(this).attr('href'),'player','width=950,height=570');return false;
						});
				$(".list li a").click(function(){
						var vid = $(this).attr('vid');
						t(vid);
						$(".list li").removeClass("current");
						$(this).parent().addClass('current');

						return false;
						}
						);
				});
</script>
<style>
		body {
				/*color:#5C71A2;*/
				/*color:#000;*/
				color:#222;
				font-size:1.4em;
				background:#dddddd;
}/*font: 25px Arial;}*/
div{
		display: block;
}
img, a img {border:0;}
a {
		color:#222;
		text-decoration:none;
}
a:hover {text-decoration:underline;}
.content {
		width:970px;
		margin:auto;
		background:#fff; color:#111;  border:2px solid #ccc; text-align:center; 
		padding:0px;
}
.header{width:1000px;margin:10px auto;}
li{
		font-size: 1.1em;
		line-height: 10px;
}
.list .head{
		color: #014CCC;
		background: #EAF9FE none;
		/*border-color: #E5E5E5;*/
		border: 1px solid #A7D6E0;
		height: 20px;
		width:200px;
		margin-left:10px;
}
.list li  {
		cursor:pointer;
		clear:both;
		padding:1px;
		border-bottom:1px solid #E5E5E5;text-align:left;
		width:200px;
		line-height:20px;
}
.list .current{
		overflow:hidden;
		background: #6A9BC0 url(http://static.youku.com/index/img/master.png) no-repeat 5px -1312px;
}
.list li a{
		padding-left:20px;
		display:block;
}
.list .current a:hover {
		background: #6A9BC0 url(http://static.youku.com/index/img/master.png) no-repeat 5px -1312px;
}
.list a:hover {
		background:#daf3fa; 
		text-decoration:none;
}
.header li  {
		float: left;
		padding-left:5px;
		padding-right:5px;
}
.header .nav{
		margin-left:auto;width:220px;
}
.content li{
		float: left;
}
.content li{
		margin-left:10px;
		margin-right:10px;
		font-size:14px;
}
.content .main{
		height:430px;
}
.content .nav{
		margin:18px auto;
}
.footer li{
		float: left;
	padding:10px;
}
.footer .nav{
		margin:8px auto;
		padding-bottom:8px;
		margin-left:auto;
		width:400px;
}
.footer a{
		color:#5C71A2;
}
/*
input {font: normal 19px Arial; }
input#q {
		height: 25px; padding:2px 5px 0 2px; border-style:none; border-width:0;overflow:auto; width:292px; text-align:center;}
textarea {font: normal 12px Courier; margin: 5px 0; }
h1#web20write {width:700px; height:54px; dislay:block; text-align:center;}
div#result,div#api,div#services,div#submitform,div#who,div#embed,div#footer {
		background: #e5e5e5; display:block; clear:both; margin:15px 40px; padding:5px;  border-radius:5px;
}
*/
.playerBox{
		margin:auto;
		margin-top:70px;
		width:400px;
		height:320px;
}
.imglist li{
		padding:3px;
}
.imglist{
		height:100px;
		overflow:auto;
		overflow-y:hidden;
}
h3 {font-weight:bold; margin:2px; text-aling:left;}

				</style>
				{/literal}
		</head>
		<body>

				<div class="header">
						<ul class="nav">
								<li><a id="login">登录</a></li>
								<li><a href="">注册</a></li>
								<li><a href="">关于</a></li>
								<li><a href="">帮助</a></li>
								<li><a href="">English</a></li>
						</ul>
						<div class="clear"></div>
				</div>
				<div class="content">
						<ul class="nav">
								<li><a href="" title="jQuery Forum">首页</a> | </li>
								<li><a href="" title="jQuery Forum">播放列表</a> | </li>
								<li><a href="" title="jQuery Forum">资料管理</a> | </li>
								<li><a href="" title="jQuery Forum">增加歌曲</a> | </li>
								<li><a href="" title="jQuery Forum">邀请好友</a></li>
								<li><a id="_IDPlayer" href="/player" title="jQuery Forum">打开播放器</a></li>
								<li>
								<!--<img src="https://www.google.com/adsense/static/zh_CN/images/468x15.gif"/>-->
								</li>
						<div class="clear"></div>
						</ul>

						<div class="main">
								<div class="left" style="border-right:1px solid #F0F0F0;">

										<div id="submitform">
												<form action="/" method="get" onsubmit="send()">
														<input type="text" id="q" name="q" /> 
														<input type="submit" id="btnSubmit" value="搜索" />
												</form>
										</div>

								</div>
								<div class="right" style="width:300px;">
										<!--<img src="https://www.google.com/adsense/static/zh_CN/images/250x250.gif"/>-->
										fwef
								</div>
								<div class="right">
								</div>
								<div class="clear"></div>
						</div>
								<div class="imglist" style="padding:15px">
										<ul style="margin:auto">
												<img src="https://www.google.com/adsense/static/zh_CN/images/leaderboard.gif" />
												<img src="https://www.google.com/adsense/static/zh_CN/images/200x90.gif" />
										</ul>
								</div>


				</div>
						<div class="footer">
								<ul class="nav">
										<li><a href="" title="jQuery Forum">Login 登录</a></li>
										<li><a href="" title="jQuery Forum">Sign up</a></li>
										<li><a href="" title="jQuery Forum">About us</a></li>
										<li><a href="" title="jQuery Forum">Help</a></li>
										<li><a href="" title="jQuery Forum">English</a></li>
								</ul>
								<div class="clear"></div>
						</div>

		</body>
</html>
<!-- http://web2.0write.com -->
