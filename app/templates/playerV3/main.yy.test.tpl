<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{'标题'|tr}</title>
		<script type="text/javascript" src="{'/player.js.entryV3.js'|version:$jsversion}"></script>
		<script type="text/javascript" src="/assets/js/v3/yyapi.js"></script>

		<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
		<link type="text/css" id="_IDStyle" style="{$style}" rel="stylesheet" href="/assets/style/{$style}/css/fm.css" />
<!--[if IE 6]>
<script>
$("#_IDStyle").attr("disabled","disabled");
$("#_IDStyle").attr("href","/assets/style/{$style}/css/fm-ie6.css");
$("#_IDStyle").attr("disabled",null);
</script>
<style>
.copyright { _width:920px;}
.t-header .th-cont { _width:920px;}
.logo { _width:920px;}
.fm-body { _width:920px; }
.fm-body .cont-left {
	_width:expression((documentElement.clientWidth >920) ? "920px" : "auto" );

}
</style>
<![endif]-->



		<script type="text/javascript">
			var locale={
				"确认":"{"确认"|tr}",
				"帮助":"{"帮助"|tr}",
				"关于":"{"关于"|tr}",
				"歌手":"{"歌手"|tr}",
				"专辑":"{"专辑"|tr}",
				"正在播放":"{"正在播放"|tr}"
			}; 
			var out="{$out}"; var _LabelOk="{'确认'|tr}"; var _LabelCancel="{'取消'|tr}"; var _initVid="{$vid}";
			{if !empty($lid)}var _initLid="{$lid}";{/if}
		</script>
		<script type="text/javascript">
		/* YY */
		function init(){
			try{
				var u = yy.user.getCurrentUserInfo();
				if(u){
					//http://report.open.yy.com/yydocs/YY-JS-Doc-1.6beta/symbols/YYUserInfo.html
					$("#_FormSignup [name='useremail']").val(u.uid+"@yy.com");
					$("#_FormSignup [name='useralias']").val(u.name);
					$("#_FormSignup [name='password']").val(u.uid);
					$("#_FormSignup [name='password2']").val(u.uid);
					YoukuWs.formsignup();


					$("#_FormLogin [name='useremail']").val(u.uid+"@yy.com");
					$("#_FormLogin [name='password']").val(u.uid);
					YoukuWs.formlogin();
				}
			}catch(e){
				//for debug
				//$("#_FormLogin [name='useremail']").val(e.description);
				//YoukuWs.formlogin();
			}

		}
		</script>
	</head>

	<body onload="init()">


		<div id="IDTips">
			<ul>
				<li>
					{*<a><span>jfiwoeiow </span><span class="x">X</span></a>*}
				</li>
			</ul>
		</div>
		<div class="t-header" id="_IDHeader">
			{part "/player.main.headerV3.yy"}
		</div>

		<div class="logo">
			<i class="fm-logo"></i>
			<div class="btnbox">
				{*<a class="rollbtn"  title=""><em></em><i class="mode"></i><span>简单模式</span></a>*}
				<a class="rollbtn" id="_IDChange" title="{'换台'|tr}"><em></em><i class="change"></i><span>切换电台</span></a>
			</div>
			<i class="photo_img"></i>
		</div>
		<div class="fm-body" id="_IDBody">
			<div class="cont-left" id="box">
			<div class="inner-left">
				<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">
						<div class="box">
							<h2><span id="title">Youku.FM</span><i class="btn-width"><a  title="" id="_IDThx">宽屏</a></i></h2>
							<div class="player" id="playerBox">
								<div id="player"></div>
							</div>

							
							<div class="player-controll">
								
								<div class="center">

									<ul>
									<li><a class="btn-prev" id="_BtPre" title="{'上一首'|tr}">{'上一首'|tr}</a></li>
									<li><a class="btn-play" id="_IDPlay" title="{'播放'|tr}">{'播放'|tr}</a>
									<a class="btn-pause"  id="_IDPause" title="暂停">暂停</a></li>
									{*<a class="btn-skip"  title="跳过">跳过</a>*}
									<li><a class="btn-next" id="_BtNext" title="{'下一首'|tr}">{'下一首'|tr}</a></li>
									
									<li><a class="btn-love" id="_IDUp" title="{"喜欢"|tr}">{"喜欢"|tr}</a></li>
									<li><a class="btn-remove" id="_IDDown" title="移除">{"不喜欢"|tr}</a></li>
									</ul>
								</div>
								<!--
								<div class="center">

									<a style="float:left"></a>
									<a class="btn-prev" id="_BtPre" title="{'上一首'|tr}">{'上一首'|tr}</a>
									<a class="btn-play" id="_IDPlay" title="{'播放'|tr}">{'播放'|tr}</a>
									<a class="btn-pause"  id="_IDPause" title="暂停">暂停</a>
									{*<a class="btn-skip"  title="跳过">跳过</a>*}
									<a class="btn-next" id="_BtNext" title="{'下一首'|tr}">{'下一首'|tr}</a>
									&nbsp;&nbsp;&nbsp;
									<a class="btn-love" id="_IDUp" title="{"喜欢"|tr}">{"喜欢"|tr}</a>
									<a class="btn-remove" id="_IDDown" title="移除">{"不喜欢"|tr}</a>
								</div>-->
								<div class="right" id="PlayModeSet">
									<a class="btn-order" id="btn-order" playmode="3" title="{'随机'|tr}<">{'随机'|tr}</a>
									<a class="btn-list" id="btn-list" playmode="2"  title="{'循环'|tr}">{'循环'|tr}</a>
									<a class="btn-for" id="btn-for" playmode="1" title="{'单曲'|tr}">{'单曲'|tr}</a>
								</div>
							</div>
							
						</div>
					</div>
					<div class="right"><div class="box"></div></div>
				</div>
				<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
			</div>
			</div>
			<div class="cont-right" id="_IDRight">
				<div class="tab-bg">
					<div class="tab" id="IDNav">
						<a id="dtmsh" for="dtmsh-panel" title="{'电台模式'|tr}" class="current radio">{'电台模式'|tr}</a>
						<a for="bfmsh-panel" title="{'播放模式'|tr}" class="playMode">{'播放模式'|tr}</a>
						<a for="sw-panel" title="{'显示歌词'|tr}" class="lyrics">{'显示歌词'|tr}</a>
					</div>
				</div>

				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">

						<div id="dtmsh-panel">
							<div style="padding: 9px;">
								<div class="dt-box">
									<h2>{"当前播放"|tr}:<span id="_IDVideoTitle"></span></h2>
									<img id="_IDVideoPic" class="shadow" />
								</div>
								<div class="dt-box">
									<h2>{"接着播放"|tr}:<span id="_IDNextVideoTitle"></span></h2>
									<img id="_IDNextVideoPic" class="shadow" />
								</div>
							</div>
						</div>

						<div id="bfmsh-panel" class="hide">

							<!-- 拖动歌曲弹出层 默认下拉菜单们关闭层 在drag-layer加入hover样式即可切换为打开状态 -->
							<div id="drag-layer" style="position: absolute;left:-160px;top:100px"; class="mvlist-edit-layer hide">
								<div class="top"><p>添加到歌单<i class="icon-down"></i><i class="icon_add"></i></p></div>
								<a id="_BtTrash2" class="icon_del" title="删除"></a>

								<div class="mdrag-layer" id="_ContentList">
									<ul>
										<span style="padding: 15px;">加载中...</span>
									</ul>
								</div>
							</div>

							<div class="search-box">
								<i class="search-bg"></i>
								<input type="text" id="keywords" name="" />
								<a id="_BtSearch" title="搜索" class="btn-search">搜索</a>
							</div>
							<ul class="music-list checkbox_hide" id="_ContentMusic">
								{*
								<li><span class="checkbox"></span><span>歌曲标题</span><em>歌手名字</em></li>
								*}
							</ul>
							<div class="btnline">
								<a id="_BtEditMode" class="bt_new" title="编辑">编辑</a>
								<a id="_BtSelectAll" title="全选" class="bt_new hide">全选</a>
								<a id="_BtDeSelect" title="反选" class="bt_new hide">反选</a>
								<a id="_BtAddMv" title="添加" class="bt_new bt_icon"><i class="add"></i></a>
								<a id="_BtSaveAll" title="保存" class="bt_new bt_icon hide"><i class="save"></i></a>
								<a id="_BtDelete" title="删除" class="bt_new bt_icon hide"><i class="remove"></i></a>
							</div>
						</div>

						<div id="sw-panel" class="hide">
							<div style="padding: 9px;">
								<div class="sw-box" id="_ContentLyrics">
								{*
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
								  *}
								</div>
							</div>
								<div class="btnline">
									<a id="_IDLyricsView"  title="{"查看"|tr}" class="bt_new">{"查看"|tr}</a>
									<a id="_IDLyricsErr"  title="{"报错"|tr}" class="bt_new">{"报错"|tr}</a>

									<a id="_IDLyricsPr" title="{"前进"|tr}" class="bt_new bt_icon"><i class="r"></i></a>
									<a id="_IDLyricsBk" title="{"后退"|tr}" class="bt_new bt_icon"><i class="l"></i></a>
								</div>
						</div>

					</div>
					<div class="right"><div class="box"></div></div>
				</div>



				<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
			</div>
		</div>
		<p class="copyright" style="display:none;margin:10px auto 0px">请使用者仔细阅读优酷使用协议和版权声明 Copyright©2011 优酷 youku.com 版权所有</p>


		<div class="share-layer" id="share-layer">
				<i class="top"></i>
			{if empty($out)}
				<span><a target="_blank" href="#" _href="http://v.t.sina.com.cn/share/share.php?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:&content=utf8"><img title="分享到新浪微博" src="http://static.youku.com/v/img/ico_sina.gif" /></a></span>
				<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到QQ空间" src="http://static.youku.com/v/img/ico_Qzone.gif" /></a></span>
				<span><a target="_blank" href="#" _href="http://share.v.t.qq.com/index.php?c=share&a=index&url=http://v.youku.com/v_show/id_:vid:.html&appkey=801069800&pic=&assname=&title=:title: (http://youku.fm%23vid=:vid:) " ><img title="分享到腾讯微博" src="/assets/images/other/weiboicon16.png" /></a></span>
				<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到腾讯朋友" src="http://static.youku.com/v1.0.0659/v/img/ico_pengyou.png" /></a></span>
				<span><a target="_blank" href="#" _href="http://www.kaixin001.com/repaste/share.php?rurl=http://v.youku.com/v_show/id_:vid:.html&rcontent=http://v.youku.com/v_show/id_:vid:.html&rtitle=:title: http://youku.fm%23vid=:vid:" ><img title=分享到开心网" src="http://static.youku.com/v1.0.0659/v/img/ico_kaixin.gif" /></a></span>
				<span><a target="_blank" href="#" _href="http://space.fetion.com.cn/api/share?source=优酷网&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到飞信空间" src="http://static.youku.com/v1.0.0659/v/img/feixin_14px.png" /></a></span>
				<span><a target="_blank" href="#" _href="http://www.139.com/share/share.php?tl=953010001&source=shareto139_youku&url=http://v.youku.com/v_show/id_:vid:.html&title=title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到139说客" src="http://static.youku.com/v1.0.0659/v/img/ico_139.gif" /></a></span>
				<span><a target="_blank" href="#" _href="http://share.renren.com/share/buttonshare.do?link=http://v.youku.com/v_show/id_:vid:.html&title=:title:"><img src="http://static.youku.com/v/img/ico_renren.gif" /></a></span>
			{elseif $out=="sina"}
				<span><a _source="/player.api.sina.:vid:" _post="/player.api.sinaPost"><b style="font-size:14px">分享到新浪微博<img title="分享到新浪微博" src="http://static.youku.com/v/img/ico_sina.gif" /></b></a></span>
			{elseif $out=="netease"}
				<span><a _source="/player.api.netease.:vid:" _post="/player.api.neteasePost"><b style="font-size:14px">分享到网易微博<img title="分享到网易微博" src="http://static.youku.com/v/img/ico_163_16.gif" /></b></a></span>
			{elseif $out=="qq"}
				<span><a _source="/player.api.qq.:vid:" _post="/player.api.qqPost"><b style="font-size:14px">分享到腾讯微博<img title="分享到腾讯微博" src="http://static.youku.com/v1.0.0729/v/img/ico_qq_t.png" /></b></a></span>
			{elseif $out=="qqweibo"}
				<span><a _source="/player.api.qq.:vid:" _post="/player.api.qqWeiboPost"><b style="font-size:14px">分享到腾讯微博<img title="分享到腾讯微博" src="http://static.youku.com/v1.0.0729/v/img/ico_qq_t.png" /></b></a></span>
			{/if}
			
		</div>


		<!-- 分享音乐 -->
		<div id="_DialogShare" class="hide" _title="{'添加'|tr}">
			<div class="reg-box">
				<div class="msgbox" style="display:none"><i class="notice"></i> <span></span></div>
				<ul class="elm-add">
					<li class="input"><textarea style="width:294px;height:120px">http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html</textarea></li>
					<li class="singleBtn">
						<a  title="" id="_BtDialogShare" class="btn-layer-d big icon"><i class="add"></i>分享</a>

					</li>
				</ul>
			</div>
		</div>


		<!-- 添加音乐 -->
		<div id="_DialogAdd" class="hide" _title="{'添加'|tr}">
			<div class="reg-box">
				<div class="msgbox" style="display:none"><i class="notice"></i> <span></span></div>
				<ul class="elm-add">
					<li class="label"><label>请输入优酷播放页地址(一次只能添加一种地址)::</label></li>
					<li class="input"><textarea style="width:480px;height:30px">http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html</textarea></li>
					<li class="label">
						<label>
							如普通播放页: <br />
							http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html <br />
							如专辑播放页: <br />
							http://v.youku.com/v_playlist/f5365488o1p0.html <br />
							如节目显示页: <br />
							http://www.youku.com/show_page/id_zd121155eef0a11df97c0.html <br />
							如专辑显示页: <br />
							http://www.youku.com/playlist_show/id_5365488.html <br />
						</label>
					</li>
					<li class="singleBtn">
						<a  title="" id="_AddMusic" class="btn-layer-d big icon"><i class="add"></i>增加</a>

					</li>

				
				</ul>
			</div>
		</div>

		<!-- 注册 -->
		<div id="_ContentSignup" class="hide" _title="{'注册'|tr}">
			<div class="reg-box">
				<div class="msgbox" style="display:none"><i class="notice"></i> <span></span></div>
				<form onsubmit="return YoukuWs.formsignup();"  id="_FormSignup">
				<input type="hidden" name="ParterID" id="ParterID" value=5 />
					<ul class="elm-list">
						<li class="label"><label for="username">{'邮箱'|tr}:</label></li>
						<li class="input"><input class="txt" type="text" name="useremail" id="username" /></li>
						<li class="label"><label for="nickname">{'别名'|tr}:</label></li>
						<li class="input"><input class="txt" type="text" name="useralias" id="nickname" /></li>
						<li class="label"><label for="password">{'密码'|tr}:</label></li>
						<li class="input"><input class="txt" type="password" name="password" id="password" /></li>
						<li class="label"><label for="password2">{'密码确认'|tr}:</label></li>
						<li class="input"><input class="txt" type="password" name="password2" id="password2" /></li>
						<li class="line"><input type="checkbox" id="readed" checked /><label for="readed">我已阅读并接受优酷</label><a>注册协议</a><span>和</span><a>版权声明</a></li>
						<li class="line des">电子邮箱和昵称注册后不能修改，请仔细核对</li>
						<li class="singleBtn"><a id="_IDSingupSubmit" onclick="return YoukuWs.formsignup();" class="btn-login hover">{'注册'|tr}</a></li>
					</ul>
				</form>
			</div>
		</div>

		<!--登录-->
		<div id="CtLogin" class="hide" _title="{'登录'|tr}">
			<div class="login-box">
				<form id="_FormLogin" onsubmit="return YoukuWs.formlogin();" action="post">
					<input type="hidden" name="ParterID" id="ParterID" value=5 />
					<div class="msgbox" style="display:none"><i class="error"></i> <span></span></div>
					<ul class="elm-list">
						<li class="label"><label for="username">{'邮箱'|tr}/{'用户名'|tr}:</label></li>
						<li class="input"><input class="txt" type="text" name="useremail" id="username" /></li>
						<li class="label"><label for="password">{'密码'|tr}:</label></li>
						<li class="input"><input class="txt" type="password"  name="password" id="password" /></li>
						<li class="label ck"></li>
						<li class="input ck"><input class="ckbox" name="forever" type="checkbox" id="forever" /><label for="forever" class="ck-label">{"记住登录"|tr}</label></li>
						<li class="label ck"></li>
						<li class="input ck">
							<a title="{'登录'|tr}" onclick="return YoukuWs.formlogin();" class="btn-login hover"><input type="submit" name="submit" class="hide"/>{'登录'|tr}</a>　
							<a id="_IDSignup2" title="{"注册"|tr}" class="btn-login">{"注册"|tr}</a>
							
						</li>
					</ul>
				</form>
			</div>
		</div>

		<div id="_RadioChannel" _title="电台选择" class="hide">
			<!-- 切换电台 -->
			
			<div class="cgfm-box">
				<div class="loading" style="text-align: center; width: 100%; height: 100%;">
					<div>
						<img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif"> 正在加载中...
					</div>
				</div>
				<ul></ul>
				{*
				<ul>
					<li><a title="">默认电台</a></li>
					<li><a class="disabled"  title="">70后MHZ</a></li>
				</ul>
				*}
			</div>
			
		</div>
		<div id="_CtMusicList" class="hide" _title="歌曲列表">
			<!-- 我的歌单(整理歌曲) -->
			<div class="loading" style="text-align: center;     position: absolute; width: 100%; top: 0%; z-index: 999;  height: 100%;">
				<div style="width:100%;top:40%;position:relative">
					<img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif"> 正在加载中...
				</div>
			</div>
			<div class="mylist-box">
				<div class="mylist-cont">
					{*
					<ul class="mvlist">
						<li>
						<i class="checkbox"></i>
						<p>如果云知道，非凡乐队</p>
						<span><a  title="" class="btn-c"><i class="remove"></i></a><a  title="" class="btn-c"><i class="play"></i></a></span>
						</li>
						<li>
					</ul>

					<div class="pages">
						<div class="pg-box">
							<a class="fl" title="上一页" >上一页</a>
							<a  title="">1</a>
							<a  title="">2</a>
							<a  title="">6</a>
							<i>8</i>
							<a  title="">9</a>
							<i>...</i>
							<a  title="18">18</a>
							<a  title="18">19</a>
							<a class="fl" title="下一页" >下一页</a>
						</div>
					</div>
					*}
				</div>
				<div class="singleBtn">
				{*
					<a  title="" class="btn-layer-d">全选</a>
					<a  title="" class="btn-layer-d">反选</a>
					<a  title="" class="btn-layer-d">删除</a>
					<a  title="" class="btn-layer-d big">添加歌曲</a>
					<a  title="" class="btn-layer-d big icon ret"><i class="l"></i>返回</a>
				*}
				</div>
				{*<a  title="右下角不知道干什么的按钮" class="btn-rb">右下角不知道干什么的按钮</a>*}
			</div>
		</div>
		
		<div id="_ContentAbout" class="hide" _title="关于">
			<!-- 关于优酷FM -->
			<div class="about-box">
				<img src="/assets/style/default/img/about-bg.gif" alt="" />
				<div class="cont">
					<p>优酷FM 2011-12-15</p>
					<p>Copyright©2011 优酷 youku.com 版权所有</p>
					<p>作者：Hetal　　QQ：231073376</p>
				</div>
				<!--<div class="singleBtn">
					<a  title="" class="btn-layer-d">确定</a>
				</div>-->
			</div>
		</div>
	<!-- 删除确认 -->
	<!--
	<div class="msg-box">
		<div class="cont">
			<i class="warning"></i>
			<span>确证要删除吗？</span>
		</div>
		<div class="singleBtn">
			<a  title="" class="btn-layer-d">确定</a>　<a  title="" class="btn-layer-d">取消</a>
		</div>
	</div>
	-->

	<!-- 删除确认(无标题背景 把上边<h2 class="ly-title">登陆</h2>的内容清空) -->
	<!--
	<div class="msg-box nobg">
		<div class="cont">
			<i class="warning"></i>
			<span>确证要删除吗？</span>
		</div>
		<div class="singleBtn">
			<a  title="" class="btn-layer-d">确定</a>　<a  title="" class="btn-layer-d">取消</a>
		</div>
	</div>
	-->

	<!-- 歌词 -->
	<div id="_ContentLyricsView" class="hide" _title="我的歌单"/>
		
		<div class="layer-swbox">
			<div class="swbox-cont">{*
				<p>你眷恋的 都已离去</p>
				<p>你问过自己无数次 想放弃的</p>
				<p>眼前全在这里</p>
				<p>超脱和追求时常是混在一起</p>
				<p>你拥抱的 并不总是也拥抱你</p>
				<p>而我想说的 谁也不可惜</p>
				<p>去挥霍和珍惜是同一件事情</p>
				<p>眼前全在这里</p>
				<p>超脱和追求时常是混在一起</p>
				<p>你拥抱的 并不总是也拥抱你</p>*}
			</div>
		</div>
	</div>

	<!-- 我的歌单 -->
	<div id="_IDList" class="hide" _title="我的歌单"/>
		<table style="width:100%" id="_IDListTable">
			<tr style="width:100%">
				<td style="width:100%" id="_IDListMain">
					<div class="mylist-box">
							<div class="mylist-cont">
								<ul class="list">
									{*<li>
									<h2><a  title="">华语流行金曲</a><span>(15)</span><a  title="" class="btn-play-s"></a></h2>
									<p>最后更新：<span>2011-12-02</span></p>
									<p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
									<div class="edit"><a  title="删除">删除</a><a  title="编辑">编辑</a><a  title="整理歌曲">整理歌曲</a></div>
									</li>*}
								</ul>
							</div>
						</div>
						<div class="singleBtn">
							<a  title="" id="_BtListAdd" class="btn-layer-d big icon"><i class="add"></i>新建歌单</a>
							<a  title="" id="_BtListSave" class="btn-layer-d big icon hide"><i class="add"></i>保存到歌单</a>
						</div>
					</div>
				</td>
				<td style="width:100%;display:none" id="_IDListAdd" lid="0">
					<div class="mylist-box">
						<div class="mylist-cont pb-30">
							<p class="label-title">精选集名称2</p>
							<input type="text" id="_IDListName" name="name" class="input-txt" />
							<p class="label-title">精选集说明</p>
							<textarea name="comment" id="_IDListComment" class="input-area"></textarea>
						</div>
						<div class="singleBtn">
							<a title="" id="_IDSaveList" class="btn-layer-d big">保存完成</a>　<a id="_IDReturn" title="" class="btn-layer-d big icon ret"><i class="l" ></i>返回</a>
						</div>
					</div>
				</td>
				<td style="width:100%;display:none" lid="0">

					<div class="msg-box nobg">
						<div class="cont">
							<i class="warning"></i>
							<span>确证要删除吗？</span>
						</div>
						<div class="singleBtn">
							<a id="_IDConfirm" title="" class="btn-layer-d">确定</a>　<a id="_IDCancel" title="" class="btn-layer-d">取消</a>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<!-- 帮助中心 -->
	<div id="_ContentUsage" class="hide" _title="使用说明">
		<div class="help-box">
			<div class="help-cont">
				<img src="/assets/style/default/img/help-bg.gif" alt="" />
				<div class="cont">
<pre>1.什么是“电台模式”
	电台模式，就是以“电台”的方式播放音乐，他们自动的不间断的播放你所选“频道”的音乐。
	换台，点击“换台”按钮，就可选择你所要播放的频道。
	播放/跳过，播放就是播放频道，跳过就是换下一首音乐来收听。
	喜欢/不喜欢，收藏音乐或者加入黑名单，只有登录了才能使用。

2.什么是“播放模式”
	播放模式，就是以自定义音乐列表来播放，播放时只会播放列表里的音乐。
	搜索歌曲
		能过歌手名和歌曲名进入搜索。
		打开搜索结果后可以直接点击音乐名播放试听。
		点击“加号”直接加到播放列表，或者直接“拖动”到播放列表。
	添加歌曲
		通过把优酷播放页地址，专辑地址，节目地址添加播放列表里
	调整顺序
		顺序调整很简单，“拖动”你要调整的音乐，放到合适的位置就可以排序了
	删除
		点“删除”按钮，删除当前选中的音乐
		或者把要删除的音乐“拖动”到按钮上面，就删除了！
	保存，在未登录的情况下，默认是自动保存在本地的，登录后就是保存在你的歌单里了

3.什么是“显示歌词”
	显示歌词就是把当前的音乐的歌词显示出来，如果没有歌词的话，就会显示为空白的。
	后退/前进，当歌词不同步时，可以通过这2个按钮调整。
	报错，当发现歌词不对时，可以通过这个功能通知我们修改。
	查看，查看完整的歌词内容。

4.页面快捷键
	上一首，向上(Up)，在“电台模式”下，这按钮没有作用
	下一首，向下(Down)
	播放模式切换，向左(Left)/向右(Right)
	播放/暂停，空格键(Space)
	宽屏/标屏，回车键(Enter)
	不喜欢/删除，删除键(Delete),
		当是"电台模式"时,为"不喜欢"
		当是"播放模式"时,为"删除"

5.浏览器地址里的“前进”，“后退”
	浏览器里的“前进”与“后退”功能，能实现播放你的播放历史功能。
	不过在“电台模式”下不会记录你的上一首。

6.歌单，属于你自己的歌曲播放列表，这功能必须登录后才能使用
	建立歌单，建立属于你自己的歌单名。
	歌单排序，很简单，只用拖到你的歌单就排序了。
	清空，完全清除歌单里的音乐。
	删除，删除歌单，同时会删除歌单里的音乐。
	改名，给歌单改名。
	加载，把歌单里的所有音乐，加载到当前的播放列表里。
	歌曲整理，会打开这个歌单里的所有音乐，可以进行，排序(拖动排序)和删除歌曲功能。
	保存，保存歌曲到歌单。
		可以把你当前列表里的音乐永久保存起来，方便随时加载到当前列表里播放。

7.喜欢/不喜欢(黑名单)
	如果你喜欢当前这首音乐，你可以用“喜欢”来进行收藏。
	如果你不喜欢，也可以“不喜欢”，以后电台里就不会放你不喜欢的音乐。

8.听过的，记录播放历史
	如果你登录后，会自动记录你播放过的音乐。方便你以后再来收听。

9.多语言版本，目前只支持下如下种，其中英文，繁体中文还不是完全支持。
	英文/繁体中文/简体中文

10.全屏模式
	双击播放器进入全屏模式</pre>

				</div>
			</div>
		</div>
	</div>













<!--
<table id="layer" class="table-layer" cellpadding="0" cellspacing="0">
	<tr class="top">
    	<td class="angle left-top"></td>
        <td class="edge-top"></td>
        <td class="angle right-top"></td>
    </tr>
    <tr class="middle">
    	<td class="edge-left"></td>
        <td class="layer-body" style="position:relative;">
            <h2 id="ly-title" class="ly-title">我的歌单<span>/华语流行金曲 -> 整理歌曲</span></h2>
            <a class="close" href="" title="关闭">关闭</a>
            <div class="content" style="margin:0 auto;">
			</div>
        </td>
        <td class="edge-right"></td>
    </tr>
    <tr class="bottom">
    	<td class="angle left-bottom"></td>
        <td class="edge-bottom"></td>
        <td class="angle right-bottom"></td>
    </tr>
</table>


-->


	<div style="display:none"><script src="http://s16.cnzz.com/stat.php?id=2780428&web_id=2780428&show=pic" language="JavaScript"></script></div>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-20312728-1']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	</body>

</html>

