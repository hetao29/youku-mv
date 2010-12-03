<?php /* Smarty version 2.6.26, created on 2010-12-03 10:05:11
         compiled from index/index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
																<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
																<title>YOUKU.WS</title>
																<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
																<script type="text/javascript" src="/slightphp/js/jquery-1.4.4.min.js"></script>
																<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
																<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
																<?php echo '
																<script type="text/javascript">
																								var playerId="player";
																								function onPlayerStart(vid,vidEncoded){
																																//PlayerColor("000000","4F4F4F",25);
																								}
function onPlayerError(vid){
								//PlayerColor("000000","4F4F4F",25);
}
$(document).ready(function(){
});
function onPlayerComplete(vid,vidEncoded,isFullScreen){
								t(\'XMjI2MDIxNTYw\');
								//PlayerSeek(3);
}
function _player(moviename) {
								if (navigator.appName.indexOf("Microsoft") != -1)return window[moviename?moviename:playerId];
								return document[moviename?moviename:playerId];
};
function PlayerColor(bgcolor,gracolor,trans){
								return _player().setSkinColor(bgcolor,gracolor,trans);
};
function PlayerSeek(s){
								s = isNaN(parseInt(s))?0:parseInt(s);
								_player().nsseek(parseInt(s));
};
function PlayerPlayPre(vid,vidEncoded,isFullScreen){
								alert("Pre"+vid);
}

function PlayerPlayNext(vid,vidEncoded,isFullScreen){
								alert("next"+vid);
}
function t(vid){
								pre=1;
								next=1;
								swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",{isAutoPlay:true,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},{allowFullScreen:true,allowscriptaccess:"always","bgcolor":"#FFFFFF"});//,{id:"xx"});
}
																														$(function() {
																																								$( ".imglist" ).sortable();
																																										$( ".imglist" ).disableSelection();
																																											});
t(\'XMjI2MDIxNTYw\');
</script>
<style>
								body {
																/*color:#5C71A2;*/
																/*color:#000;*/
																color:#222;
																font-size:1.4em;
																background:#dddddd;
}/*font: 25px Arial;}*/
img, a img {border:0;}
a {
								color:#222;
								text-decoration:none;
}
a:hover {text-decoration:underline;}
.content {
								width:1000px;
								margin:auto;
								background:#fff; color:#111;  border:2px solid #ccc; text-align:center; 
								padding:0px;
}
.header{width:1000px;margin:14px auto;}
li{
								font-size: 1.1em;
								line-height: 10px;
}
.list li  {
								clear:both;
								padding:5px;
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
.content .nav{
								margin:18px auto;
								margin-left:23px;
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
								margin-top:20px;
								margin-right:20px;
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
'; ?>

</head>
<body>

								<div class="header">
																<ul class="nav">
																								<li><a href="">登录</a></li>
																								<li><a href="">注册</a></li>
																								<li><a href="">关于</a></li>
																								<li><a href="">帮助</a></li>
																								<li><a href="">English</a></li>
																</ul>
																<div class="clear"></div>
								</div>
								<div class="content">
																<!--<h1 id="web20write"><a href="http://web2.0write.com/"><img width="503" height="" title="Web 2.0 Write" alt="Web 2.0 Write"></a></h1>-->
																<ul class="nav">
																								<li><a href="" title="jQuery Forum">首页</a> | </li>
																								<li><a href="" title="jQuery Forum">播放列表</a> | </li>
																								<li><a href="" title="jQuery Forum">资料管理</a> | </li>
																								<li><a href="" title="jQuery Forum">增加歌曲</a> | </li>
																								<li><a href="" title="jQuery Forum">邀请好友</a></li>
																								<li>
																								<img src="https://www.google.com/adsense/static/zh_CN/images/468x15.gif"/>
																								</li>
																</ul>
																<div class="clear"></div>

																<div class="main">
																								<div class="left nav">

																																<div id="submitform">
																																								<form action="/" method="get" onsubmit="send()">
																																																<input type="text" id="q" name="q"> 
																																																<input type="submit" id="btnSubmit" value="搜索">
																																								</form>
																																</div>
																																<div class="list">
																																播放列表
																																								<ul>
																																																<li>fjweiofw</li>
																																																<li>fjweiofw</li>
																																																<li>fjweiofw</li>
																																																<li>fjweiofw</li>
																																																<li>fjweiofw</li>
																																								</ul>
																								</div>

																								</div>
																								<div class="right" style="width:300px;">
																																<!--<img src="https://www.google.com/adsense/static/zh_CN/images/250x250.gif"/>-->
																																fwef
																								</div>
																								<div class="right">
																																<div class="playerBox"><div id="player"></div></div>
																								</div>
																								<div class="clear"></div>
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
								</div>

</body>
</html>
<!-- http://web2.0write.com -->