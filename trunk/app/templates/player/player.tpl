<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>YOUKU MV PLAYER</title>
				<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="/slightphp/js/jquery-1.4.4.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.autocomplete.js"></script>
				<!--<script type="text/javascript" src="/assets/js/jquery.autocomplete.fixed.js"></script>-->
				<script type="text/javascript" src="/assets/js/player.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom.css" media="all" rel="stylesheet" type="text/css" />
				{literal}
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
.red{
color:red
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
		width:210px;
		margin-left:10px;
}
#_Content{
	height:250px;
	overflow:hidden;
   overflow-y:scroll;
}
.list {
	height:320px;
	width:235px;
}
.list li  {
		cursor:pointer;
		clear:both;
		padding:1px;
		border-bottom:1px solid #E5E5E5;
		text-align:left;
		width:210px;
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
		width:210px;
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
.content{
padding-top:5px;
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
#PlayModeSet input{
		vertical-align: top;
}
h3 {font-weight:bold; margin:2px; text-aling:left;}
.lyrics_top{
/*background: #999; /* for non-css3 browsers */
-moz-opacity:0.5;              /* Moz + FF */ 
opacity: 0.5; 
position:absolute;
top:0px;
filter:alpha(opacity=50) progid:DXImageTransform.Microsoft.gradient(startColorstr='#cccccc', endColorstr='#000000'); /* for IE */
background: -webkit-gradient(linear, left top, left bottom, from(#ccc), to(#000)); /* for webkit browsers */
background: -moz-linear-gradient(top, #ccc, #000); /* for firefox 3.6+ */
}

/* {{{ */
.ac_results {
	padding: 0px;
	border: 1px solid #A7D6E0;
	background-color: white;
	overflow: hidden;
	z-index: 99999;
}

.ac_results ul {
	width: 100%;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}

.ac_results li {
	margin: 0px;
	padding: 2px 5px;
	cursor: default;
	display: block;
	/* 
	if width will be 100% horizontal scrollbar will apear 
	when scroll mode will be used
	*/
	/*width: 100%;*/
	font: menu;
	font-size: 12px;
	/* 
	it is very important, if line-height not setted or setted 
	in relative units scroll will be broken in firefox
	*/
	line-height: 16px;
	overflow: hidden;
}

.ac_loading {
	background: white url('indicator.gif') right center no-repeat;
}

.ac_odd {
	background-color: #eee;
}

.ac_over {
	background-color: #0A246A;
	color: white;
}
/* }}} */
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
								<!--<li><a href="">English</a></li>-->
						</ul>
						<div class="clear"></div>
				</div>
				<div class="content">

						<!--<div class="ad"><img src="https://www.google.com/adsense/static/zh_CN/images/728x15.gif" /></div>-->
						<div class="main">
								<div class="left" style="border-right:1px solid #F0F0F0;">

										<div class="list">
										<div id="submitform">
													<form onsubmit="search();return false;">
											          <input type="text" size="18" id="keywords" placeholder="请输入关键词" autofocus="" value="" autocomplete="off" class="ac_input">
											            <input type="submit" id="search_bt" value="搜  索">
											        </form>

														<!--<input type="text" id="q" name="q" /> 
														<input type="submit" id="btnSubmit" value="搜索" />
														-->
												</form>
										</div>
												<div class="head">
														<span id="_IDList">打开播放列表</span>
												</div>
												<div id="_Content">
												<ul id="_ContentList" style="display:none;border:1px solid">
														<li><a vid="XMTM0MDE5NzAw">黄晓明 2</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 3</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 4</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 4</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 4</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 4</a></li>
														<li><a vid="XMTM0MDE5NzAw">黄晓明 6</a></li>
												</ul>
												<div class="clear"></div>
												<ul id="_ContentMusic">
														<li vid="XMTM0MDE5NzAw"><a >黄晓明 - 什么都可以4</a></li>
														<li vid="XMTkwMTUwODU2"><a >任贤齐《心肝宝贝》MV</a></li>
														<li vid="XMTYxNjc5MzY4"><a >张靓颖 - 如果这就是爱情</a></li>
												</ul>
												<div class="clear"></div>
												<ul id="_ContentSearch">
												<!--
														<li vid="XMTM0MDE5NzAw"><a >s黄晓明 - 什么都可以4</a></li>
														<li vid="XMTkwMTUwODU2"><a >s任贤齐《心肝宝贝》MV</a></li>
														<li vid="XMTYxNjc5MzY4"><a >s靓颖 - 如果这就是爱情</a></li>
												-->
												</ul>
													<div class="clear"></div>
												</div>
												<div class="clear"></div>
												<div id="_IDAdd" class="trash">
													<a href="#">增加歌单</a>
													<a href="#">增加歌曲</a>
												</div>
												<div id="_DialogAdd" style="display:none">
												请输入优酷播放页地址:<br /><input /><br />如：http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html
												<a href='javascript: $( "#_DialogAdd" ).dialog("close")'>close</a>
												</div>
												<div class="trash">回收站</div>
										</div>

								</div>
								<div class="right" style="width:240px;height:322px;position:relative;">
										<div id="_LyricsTop" class="lyrics_top" style="display:none;padding-left:5px;padding-right:5px;width:225px;"></div>
										<div id="_ContentLyrics" class="lyrics" style="overflow:hidden;height:322px;"></div>
								</div>
								<div class="right">
									<div class="playerBox"><div id="player"></div></div>
									<span>
									<form id="PlayModeSet">播放设置:
									<input type="radio" id="set1" name="set" value="1"/><label><label for="set1">单曲循环</label>
									<input type="radio" id="set2" name="set" value="2" checked/><label for="set2">循环播放</label>
									<input type="radio" id="set3" name="set" value="3"/><label for="set3">随机播放</label>
									</form>
									</span>
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

		<div id="debug">debug</div>
		<div id="debug2">debug</div>
		<textarea id="lyrics_c" style="display:none;">
[ti:如果这就是爱情]
[ar:张靓颖]
[al:我相信]
[by:活在當下]
[00:01.12]张靓颖 - 如果这就是爱情
[00:05.89]
[04:31.85][00:06.73]www.51lrc.com @ 活在當下 制作
[00:14.45]
[00:16.50]你做了选择 对的错的
[00:23.02]我只能承认 心是痛的
[00:29.02]怀疑你舍得 我被伤的那么深
[00:36.49]就放声哭了 何必再强忍
[00:41.04]
[00:41.74]我没有选择 我不再完整
[00:48.11]原来最后的吻 如此冰冷
[00:54.60]你只能默认 我要被割舍
[01:00.66]眼看着 你走了
[02:53.98][01:06.61]
[02:54.49][01:07.05]如果这不是结局 如果我还爱你
[03:00.98][01:13.69]如果我愿相信 你就是唯一
[03:06.93][01:19.62]如果你听到这里 如果你依然放弃
[03:13.30][01:25.95]那这就是爱情 我难以抗拒 
[03:19.15][01:32.25]
[03:59.06][03:19.73][01:32.64]如果这就是爱情 本来就不公平
[04:05.70][03:26.27][01:38.85]你不需要讲理 我可以离去
[04:11.66][03:32.23][01:44.82]如果我成全了你 如果我能祝福你
[04:17.93][03:38.54][01:51.15]那不是我看清 是我证明 我爱你
[04:29.80][03:51.89][02:00.99]
[02:03.86]灰色的天空 无法猜透
[02:10.10]多余的眼泪 无法挽留
[02:16.32]什么都牵动 感觉真的好脆弱
[02:23.79]被呵护的人 原来不是我 
[02:28.92]
[02:29.47]我不要你走 我不想放手
[02:35.42]却又不能够奢求 同情的温柔
[02:41.69]你可以自由 我愿意承受
[02:47.98]把昨天 留给我
		</textarea>
		<div id="_IDSearchResult">
		<ul>
			<li>
				<img src="http://g4.ykimg.com/01270F1F464CFD6F29FE8D00000000370139A8-837E-B64B-A766-BC13C0E31515" /><br />
				铁道部回应新规质疑：普通旅客列车车票改签需在开车前办理
			</li>
			<li>
				<img src="http://g4.ykimg.com/01270F1F464CFD6F29FE8D00000000370139A8-837E-B64B-A766-BC13C0E31515" /><br />
				铁道部回应新规质疑：普通旅客列车车票改签需在开车前办理
			</li>
		</ul>
		<div>
</body>
</html>
