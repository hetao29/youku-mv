<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>YOUKU MV PLAYER</title>
				<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="/slightphp/js/jquery-1.4.4.min.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom.css" media="all" rel="stylesheet" type="text/css" />
				{literal}
				<script type="text/javascript">
						var playerId="player";
						function onPlayerStart(vid,vidEncoded){
								//PlayerColor("000000","4F4F4F",25);
						}
function onPlayerError(vid){
		//PlayerColor("000000","4F4F4F",25);
}
$(document).ready(function(){
				$(".list li a").live('click',function(){
						var vid = $(this).attr('vid');
						t(vid);
						$(".list li").removeClass("current");
						$(this).parent().addClass('current');

						return false;
						});
				});
function onPlayerComplete(vid,vidEncoded,isFullScreen){
		t('XMjI2MDIxNTYw');
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
		swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",{isAutoPlay:true,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"});//,{id:"xx"});
		//swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",{isAutoPlay:false,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"});//,{id:"xx"});
}
t('XMjI2MDIxNTYw');
$(function() {
				//可以被放入和被排序
				$( ".list >ul" ).sortable({
stop:function(event,ui){
//应该保存数据
//alert($(this).sortable("serialize",{attribute:"vid"}));
//alert($(ui.placeholder).html());;
//alert($(ui.sender).html());;
//for(var i in ui.position)alert(ui.position[i]);
//($(ui.item).);;
//alert($(this).html());;
},remove:function(event,ui){
alert("REMOVE");
//应该保存数据
}
						});
				$( ".list >ul" ).disableSelection();
				$( ".trash" ).droppable({
					drop: function( event, ui ) {
					setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
					$( this )
					.html( "回收站:Dropped!" )
					.addClass( "ui-state-highlight" );
					}
					});
});
</script>
<style>
.hide{display:none;}
		body {
				/*color:#5C71A2;*/
				/*color:#000;*/
				color:#222;
				font-size:1.2em;
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
		width:900px;
		margin:auto;
		background:#fff; color:#111;  border:2px solid #ccc; text-align:center; 
		padding:0px;
}
.header{width:900px;margin:10px auto;}
li{
		font-size: 1.1em;
		line-height: 10px;
}
.list{
margin:auto;
margin:5px;
}
.list .head{
		color: #014CCC;
		background: #EAF9FE none;
		/*border-color: #E5E5E5;*/
		border: 1px solid #A7D6E0;
		height: 20px;
		width:190px;
		margin-left:10px;
}
.list ul{
	height:265px;
}
.list li  {
		cursor:pointer;
		clear:both;
		padding:1px;
		border-bottom:1px solid #E5E5E5;
		text-align:left;
		width:190px;
		line-height:20px;
}
.list .current{
		overflow:hidden;
		background: #6A9BC0 url(http://static.youku.com/index/img/master.png) no-repeat 5px -1312px;
}
.list li a{
		padding-left:15px;
		display:block;
}
.list .current a:hover {
		background: #6A9BC0 url(http://static.youku.com/index/img/master.png) no-repeat 5px -1312px;
}
.list a:hover {
		background:#daf3fa; 
		text-decoration:none;
}
.list .trash{
		border: 1px solid #A7D6E0;
		width:190px;
		margin-left:10px;
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
		font-size:12px;
}
.content .main{
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
		margin:5px;
		width:400px;
		height:320px;
}
.lyrics{
		margin:auto;
		margin:5px;
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

						<!--<div class="ad"><img src="https://www.google.com/adsense/static/zh_CN/images/728x15.gif" /></div>-->
						<div class="main">
								<div class="left" style="border-right:1px solid #F0F0F0;">

										<div class="list">
										<div id="submitform">
												<form action="/" method="get" onsubmit="send()">
														<input type="text" id="q" name="q" /> 
														<input type="submit" id="btnSubmit" value="搜索" />
												</form>
										</div>
												<div class="head">
														<<返回播放列表
												</div>
												<ul>
														<li class="current"><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以1</a></li>
														<li ><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以2</a></li>
														<li ><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以3</a></li>
														<li ><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以4</a></li>
														<li ><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以5</a></li>
														<li ><a vid="XMTM0MDE5NzAw">黄晓明 - 什么都可以6</a></li>
												</ul>
												<div class="clear"></div>
												<div class="trash">回收站</div>
										</div>

								</div>
								<div class="right" style="width:260px;height:340px;overflow:hidden;overflow-y:scroll">
										<!--<img src="https://www.google.com/adsense/static/zh_CN/images/250x250.gif"/>-->
										<div class="lyrics">
										<pre>
歌词:
雨  还是下不停  打醒了 你的距离 
想要放弃   放弃这段感情 
注定我们就在此分离 

你转过身离去  留下我 没有回应 
我想追去  可怜模糊眼睛 
再给一点点勇气  让我的眼泪流下去

看著自己  站在茫茫人海里 
是在淋雨还是逃避 我试著让自己放弃 

多麼熟悉 多麼小心遇见你 
回到过去  我牵著你的手 oh~

什麼都可以  愿意为你守护到天明 
让每个角落都有我的心  就是我想坚强的意义 
有那麼多的生命和爱情  我的世界我只有拥有你 
我只想给你独特的惊喜  却不理

我只想给你独特的惊喜 你却不理
										</pre>
										</div>
								</div>
								<div class="right">
									<div>
									<input type="checkbox" style="vertical-align: top;" value="LOOP"/>循环播放
									<input type="checkbox" style="vertical-align: top;" value="LOOP"/>随机播放
									<input type="checkbox" style="vertical-align: top;" value="LOOP"/>单曲循环
									</div>
									<div class="playerBox"><div id="player"></div></div>
								</div>
								<div class="clear"></div>
						</div>
								<div class="imglist" style="padding:5px">
										<ul style="margin:auto">
												<img src="https://www.google.com/adsense/static/zh_CN/images/leaderboard.gif" />
												<!--<img src="https://www.google.com/adsense/static/zh_CN/images/200x90.gif" />-->
										</ul>
								</div>


				</div>

		</body>
</html>
