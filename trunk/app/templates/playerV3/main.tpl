<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>{'标题'|tr}</title>
		<script type="text/javascript" src="/assets/js/jquery-1.4.4.js"></script>
		<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
		<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
		<script type="text/javascript" src="/assets/js/json2.js"></script>

		<script type="text/javascript" src="/assets/js/v3/config.js"></script>
		<script type="text/javascript" src="/assets/js/v3/api.js"></script>
		<script type="text/javascript" src="/assets/js/v3/ui.js"></script>
		<script type="text/javascript" src="/assets/js/v3/player.js"></script>

		<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />

		<link type="text/css" rel="stylesheet" href="/assets/style/default/css/fm.css" />

	</head>

	<body>
		<div class="t-header">
			<div class="th-cont">
				<i class="yk-logo"></i>
				<ul id="login_success">
					<li><a href="" title="">帮助</a></li>
					<li><a href="" title="">关于</a></li>
					<li>|</li>
					<li class="language" onmouseover="(function(t){ t.className='language hover' ; })(this)" onmouseout="(function(t){ t.className='language'})(this)">语言选择<i class="icon-down"></i><em class="panel"><a href="">简体中文</a><a href="">English</a><a href="">한국의</a><a href="">日本語</a></em></li>
					<li>|</li>
					<li><a href="" title="">喜欢(<span>230</span>)</a></li>
					<li><a href="" title="">听歌(<span>222</span>)</a></li>
					<li><a href="" title="">歌单(<span>21</span>)</a></li>
					<li>|</li>
					<li><a href="" title="">退出</a></li>
					<li class="family"><span class="black">gggg111222@000.com</span></li>
				</ul>
				<ul id="login_no" style="display:none;">
					<li><a href="" title="">关于</a></li>
					<li><a href="" title="">使用说明</a></li>
					<li>|</li>
					<li><a href="" title="">注册</a></li>
					<li><a href="" title="">登录</a></li>
					<li>|</li>
					<li><a href="" title="">登录</a>后，能记住你所喜好</li>
				</ul>
			</div>
		</div>
		<div class="logo"><i class="fm-logo"></i><div class="btnbox"><a class="rollbtn" href="" title=""><em></em><i class="mode"></i><span>简单模式</span></a><a class="rollbtn" href="" title=""><em></em><i class="change"></i><span>切换电台</span></a></div></div>
		<div class="fm-body">
			<div class="cont-left" id="box">
				<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">
						<h2>【<span>华语MHZ</span>】我的模样 - <span>张靓颖《改变》</span><i class="btn-width"><a href="" title="" id="_IDThx">宽屏</a></i></h2>
						<div class="player" id="playerBox">
							<div id="player"></div>
						</div>
						<div class="player-controll">
							<a id="share" class="btn-share" title="" href=""><i class="icon-share"></i>分享</a>
							<div class="center">
								<a class="btn-play" href="" title="播放">播放</a><a class="btn-prev" href="" title="上一首">上一首</a><a class="btn-next" href="" title="下一首">下一首</a><a class="btn-pause" href="" title="暂停">暂停</a><a class="btn-love" href="" title="喜欢">喜欢</a><a class="btn-remove" href="" title="移除">移除</a><a class="btn-skip" href="" title="跳过">跳过</a>
							</div>
							<div class="right" id="testRight">
								<a class="btn-for" href="javascript:void(0)" title="循环播放">循环播放</a>
								<a class="btn-order" href="javascript:void(0)" title="无序播放">无序播放</a>
								<a class="btn-list select" href="javascript:void(0)" title="XXXX">XXXX</a>
							</div>
						</div>
					</div>
					<div class="right"><div class="box"></div></div>
				</div>
				<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
			</div>
			<div class="cont-right" id="_IDRight">
				<div class="tab-bg">
					<div class="tab"><a id="dtmsh" href="javascript:void(0)" title="电台模式" class="current">电台模式</a><a href="javascript:void(0)" title="播放模式" id="bfmsh">播放模式</a><a href="javascript:void(0)" title="显示歌词" id="sw">显示歌词</a></div>
				</div>

				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">

						<div id="dtmsh-panel">
							<div class="dt-box">
								<h2>当前播放：<span>歌曲名称</span></h2>
								<a href=""><img src="temp.jpg" alt="" /></a>
							</div>
							<div class="dt-box">
								<h2>接着播放：<span>歌曲名称</span></h2>
								<a href=""><img src="temp.jpg" alt="" /></a>
							</div>
						</div>

						<div id="bfmsh-panel" class="hide">
							<div class="search-box">
								<i class="search-bg"></i>
								<input type="text" id="" name="" />
								<a href="" title="搜索" class="btn-search">搜索</a>
							</div>
							<ul class="music-list" id="_ContentMusic">
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题歌曲标题歌曲标题歌曲标题歌曲标题歌曲标题歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名歌手名字歌手名字字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
								<li><i class="checkbox"></i><span>歌曲标题</span><em>歌手名字</em></li>
							</ul>
							<div class="btnline">
								<a href="javascript:void(0)" title="全选" class="btn-w">全选</a>
								<a href="javascript:void(0)" title="反选" class="btn-w">反选</a>
								<a href="javascript:void(0)" title="保存" class="btn-c"><i class="save"></i>保存</a>
								<a href="javascript:void(0)" title="删除" class="btn-c"><i class="remove"></i>删除</a>
								<a href="javascript:void(0)" title="添加" class="btn-c"><i class="add"></i>添加</a>
							</div>
						</div>

						<div id="sw-panel" class="hide">
							<div class="sw-box">
								<p>罗志祥  爱转角</p>
								<p>爱转角遇见了谁是否有爱情的美</p>
								<p>爱转角以后的街能不能有我来陪</p>
								<p>爱转角遇见了谁是否不让你流泪</p>
								<p>也许陌生到了解 让我来当你的谁</p>
								<p>我不让爱掉眼泪 不让你掉眼泪</p>
								<p class="current">心不再拚命躲不去害怕结果</p>
								<p>有美丽笑容</p>
								<p>我不让爱掉眼泪 不让你掉眼泪我不让爱掉眼泪 不让你掉眼泪</p>
								<p >我不让爱掉眼泪 不让你掉眼泪</p>
								<p>心不再拚命躲不去害怕结果</p>
								<p>有美丽笑容</p>
								<p>我不让爱掉眼泪 不让你掉眼泪</p>
								<p>我不让爱掉眼泪 不让你掉眼泪</p>
								<p>心不再拚命躲不去害怕结果</p>
								<p>有美丽笑容</p>
								<p>我不让爱掉眼泪 不让你掉眼泪</p>
							</div>
							<div class="btnline">
								<a  href="" title="报错" class="btn-w">报错</a>
								<a  href="" title="查看" class="btn-w">查看</a>

								<a href="" title="" class="btn-c"><i class="r"></i></a>
								<a href="" title="" class="btn-c"><i class="l"></i></a>
							</div>
						</div>

					</div>
					<div class="right"><div class="box"></div></div>
				</div>



				<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
			</div>
		</div>
		<p class="copyright">请使用者仔细阅读优酷使用协议和版权声明 Copyright©2011 优酷 youku.com 版权所有</p>

		<div class="share-layer" id="share-layer">
			<i class="top"></i>
			<span><a target="_blank" href="#" _href="http://v.t.sina.com.cn/share/share.php?url=http://v.youku.com/v_show/id_:vid:.html&amp;title=:title: http://youku.fm%23vid=:vid:&amp;content=utf8"><img title="分享到新浪微博" src="http://static.youku.com/v/img/ico_sina.gif"></a></span>
			<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://v.youku.com/v_show/id_:vid:.html&amp;title=:title: http://youku.fm%23vid=:vid:"><img title="分享到QQ空间&quot;" src="http://static.youku.com/v/img/ico_Qzone.gif"></a></span>
			<!--<span><a target="_blank" href="#" _href="http://share.v.t.qq.com/index.php?c=share&amp;a=index&amp;url=http://v.youku.com/v_show/id_:vid:.html&amp;appkey=801069800&amp;pic=&amp;assname=&amp;title=:title: (http://youku.fm%23vid=:vid:) "><img title="分享到腾讯微博" src="/assets/images/other/weiboicon16.png"></a></span>-->
			<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&amp;url=http://v.youku.com/v_show/id_:vid:.html&amp;title=:title: http://youku.fm%23vid=:vid:"><img title="分享到腾讯朋友&quot;" src="http://static.youku.com/v1.0.0659/v/img/ico_pengyou.png"></a></span>
			<span><a target="_blank" href="#" _href="http://www.kaixin001.com/repaste/share.php?rurl=http://v.youku.com/v_show/id_:vid:.html&amp;rcontent=http://v.youku.com/v_show/id_:vid:.html&amp;rtitle=:title: http://youku.fm%23vid=:vid:"><img title="分享到开心网&quot;" src="http://static.youku.com/v1.0.0659/v/img/ico_kaixin.gif"></a></span>
			<span><a target="_blank" href="#" _href="http://space.fetion.com.cn/api/share?source=优酷网&amp;url=http://v.youku.com/v_show/id_:vid:.html&amp;title=:title: http://youku.fm%23vid=:vid:"><img title="分享到飞信空间&quot;" src="http://static.youku.com/v1.0.0659/v/img/feixin_14px.png"></a></span>
			<span><a target="_blank" href="#" _href="http://www.139.com/share/share.php?tl=953010001&amp;source=shareto139_youku&amp;url=http://v.youku.com/v_show/id_:vid:.html&amp;title=title=:title: http://youku.fm%23vid=:vid:"><img title="分享到139说客&quot;" src="http://static.youku.com/v1.0.0659/v/img/ico_139.gif"></a></span>
			<span><a target="_blank" href="#" _href="http://share.renren.com/share/buttonshare.do?link=http://v.youku.com/v_show/id_:vid:.html&amp;title=:title:"><img src="http://static.youku.com/v/img/ico_renren.gif"></a></span>
		</div>
	</body>
</html>
<!--
<div class="screen-over"></div>
<div class="login-layer" id="login-layer">
	<div class="ly-box">
		<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
		<div class="cont-border">
			<div class="left"><div class="box"></div></div>
			<h2 class="ly-title">登陆</h2>
			<a class="close" href="" title="关闭">关闭</a>
			<div class="content">
				<div class="contbox">

				</div>
			</div>
			<div class="right"><div class="box"></div></div>
		</div>
		<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
	</div>
</div>
-->
<!--
<script type="text/javascript">

	// get absolute position
var getLT = function(obj){
	var _elm = document.getElementById(obj);
	var _l = _elm.offsetLeft;
	var _h = _elm.offsetTop;
	while (_elm = _elm.offsetParent) {
		_l += _elm.offsetLeft;
		_h += _elm.offsetTop;
	}
	return { left: _l,top: _h};
}

// music list click effect(checkbox)
var _elements = document.getElementById('_ContentMusic').getElementsByTagName('li');
for(var i=0; i<_elements.length; i++) {
	_elements[i].onclick = function() {
		this.className = this.className == 'select' ? '' : 'select';
	}
}

// share hover effect
document.getElementById('share').onmouseover = function() {
	document.getElementById('share').className = "btn-share hover";
	var _pos = getLT('share');
	document.getElementById('share-layer').style.left = (_pos.left)+"px";
	document.getElementById('share-layer').style.top = (_pos.top+27)+"px";
	document.getElementById('share-layer').style.display = "block";
}
document.getElementById('share').onmouseout = function() {
	document.getElementById('share').className = "btn-share";
	document.getElementById('share-layer').style.display = "none";
}
document.getElementById('share-layer').onmouseover = document.getElementById('share').onmouseover;
document.getElementById('share-layer').onmouseout = document.getElementById('share').onmouseout;


var showTab = function(id,flag) {
	var _pre = flag ? '-panel' : '';
	var _arr = [];
	_arr[0] = document.getElementById('dtmsh'+_pre);
	_arr[1] = document.getElementById('bfmsh'+_pre);
	_arr[2] = document.getElementById('sw'+_pre);

	for (var i=0; i<_arr.length; i++) {
		if (id+_pre == _arr[i].id) 
			_arr[i].className = "current";
		else
			_arr[i].className = flag ? "hide" : "";
	}
	if (!flag)
		showTab(id,1);
}
document.getElementById('dtmsh').onclick = document.getElementById('bfmsh').onclick = document.getElementById('sw').onclick = function() {
	showTab(this.id);
}


</script>
-->
