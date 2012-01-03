<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{'标题'|tr}</title>
		<script type="text/javascript" src="/slightphp/js/jquery-1.7.min.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.core.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.mouse.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.position.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.button.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.autocomplete.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.resizable.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.sortable.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.dialog.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.draggable.js"></script>
		<script type="text/javascript" src="/assets/js/development-bundle/ui/jquery.ui.droppable.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.corner.js"></script>
		<script type="text/javascript" src="/assets/js/json2.js"></script>
		<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>

		<!--
		<script type="text/javascript" src="/assets/js/v3/config.js"></script>
		<script type="text/javascript" src="/assets/js/v3/ui.js"></script>
		-->
		<script type="text/javascript" src="/assets/js/v3/player.js"></script>

		<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />

		<link type="text/css" rel="stylesheet" href="/assets/style/default/css/fm.css" />

		<script type="text/javascript">
			var locale={
				"确认":"{"确认"|tr}",
				"帮助":"{"帮助"|tr}",
				"关于":"{"关于"|tr}",
				"歌手":"{"歌手"|tr}",
				"专辑":"{"专辑"|tr}",
				"正在播放":"{"正在播放"|tr}",

			}; var out="{$out}"; var _LabelOk="{'确认'|tr}"; var _LabelCancel="{'取消'|tr}"; var _initVid="{$vid}";
		</script>
	</head>

	<body>
		<div class="t-header" id="_IDHeader">
			{part "/player.main.headerV3.".$out}
		</div>
		<div class="logo">
			<i class="fm-logo"></i>
			<div class="btnbox">
				<a class="rollbtn"  title=""><em></em><i class="mode"></i><span>简单模式</span></a>
				<a class="rollbtn" id="_IDChange" title="{'换台'|tr}"><em></em><i class="change"></i><span>切换电台</span></a>
			</div>
		</div>
		<div class="fm-body">
			<div class="cont-left" id="box">
			<div class="inner-left">
				<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">
						<h2><span id="title">Youku.FM</span><i class="btn-width"><a  title="" id="_IDThx">宽屏</a></i></h2>
						<div class="player" id="playerBox">
							<div id="player"></div>
						</div>
						<div class="player-controll">
							<a id="share" class="btn-share" title="" ><i class="icon-share"></i>分享</a>
							<div class="center">

							
								<a class="btn-prev" id="_BtPre" title="{'上一首'|tr}">{'上一首'|tr}</a>
								<a class="btn-play" id="_IDPlay" title="{'播放'|tr}">{'播放'|tr}</a>
								<a class="btn-pause"  id="_IDPause" title="暂停">暂停</a>
								{*<a class="btn-skip"  title="跳过">跳过</a>*}
								<a class="btn-next" id="_BtNext" title="{'下一首'|tr}">{'下一首'|tr}</a>
								&nbsp;&nbsp;&nbsp;
								<a class="btn-love" id="_IDUp" title="{"喜欢"|tr}">{"喜欢"|tr}</a>
								<a class="btn-remove" id="_IDDown" title="移除">{"不喜欢"|tr}</a>
							</div>
							<div class="right" id="PlayModeSet">
								<a class="btn-order" playmode="3" title="{'随机'|tr}<">{'随机'|tr}</a>
								<a class="btn-list" playmode="2"  title="{'循环'|tr}">{'循环'|tr}</a>
								<a class="btn-for" playmode="1" title="{'单曲'|tr}">{'单曲'|tr}</a>
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
						<a id="dtmsh" for="dtmsh-panel" title="{'电台模式'|tr}" class="current">{'电台模式'|tr}</a>
						<a for="bfmsh-panel" title="{'播放模式'|tr}">{'播放模式'|tr}</a>
						<a for="sw-panel" title="{'显示歌词'|tr}">{'显示歌词'|tr}</a>
					</div>
				</div>

				<div class="cont-border">
					<div class="left"><div class="box"></div></div>
					<div class="content">

						<div id="dtmsh-panel">
							<div class="dt-box">
								<h2>{"当前播放"|tr}:<span id="_IDVideoTitle"></span></h2>
								<img id="_IDVideoPic" class="shadow" />
							</div>
							<div class="dt-box">
								<h2>{"接着播放"|tr}:<span id="_IDNextVideoTitle"></span></h2>
								<img id="_IDNextVideoPic" class="shadow" />
							</div>
						</div>

						<div id="bfmsh-panel" class="hide">
							<div class="search-box">
								<i class="search-bg"></i>
								<input type="text" id="keywords" name="" />
								<a id="_BtSearch" title="搜索" class="btn-search">搜索</a>
							</div>
							<ul class="music-list" id="_ContentMusic">
								{*
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
								*}
							</ul>
							<div class="btnline">
								<a  title="全选" class="btn-w">全选</a>
								<a  title="反选" class="btn-w">反选</a>
								<a  title="保存" class="btn-c"><i class="save"></i>保存</a>
								<a  title="删除" id="_BtTrash" class="btn-c"><i class="remove"></i>删除</a>
								<a  title="添加" class="btn-c"><i class="add"></i>添加</a>
							</div>
							
						</div>

						<div id="sw-panel" class="hide">
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
							<div class="btnline">
								<a id="_IDLyricsErr"  title="{"报错"|tr}" class="btn-w">{"报错"|tr}</a>
								<a id="_IDLyricsView"  title="{"查看"|tr}" class="btn-w">{"查看"|tr}</a>

								<a id="_IDLyricsPr" title="{"前进"|tr}" class="btn-c"><i class="r"></i></a>
								<a id="_IDLyricsBk" title="{"后退"|tr}" class="btn-c"><i class="l"></i></a>
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
			<span><a target="_blank" href="#" _href="http://v.t.sina.com.cn/share/share.php?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:&content=utf8"><img title="分享到新浪微博" src="http://static.youku.com/v/img/ico_sina.gif" /></a></span>
			<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到QQ空间" src="http://static.youku.com/v/img/ico_Qzone.gif" /></a></span>
			<span><a target="_blank" href="#" _href="http://share.v.t.qq.com/index.php?c=share&a=index&url=http://v.youku.com/v_show/id_:vid:.html&appkey=801069800&pic=&assname=&title=:title: (http://youku.fm%23vid=:vid:) " ><img title="分享到腾讯微博" src="/assets/images/other/weiboicon16.png" /></a></span>
			<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到腾讯朋友" src="http://static.youku.com/v1.0.0659/v/img/ico_pengyou.png" /></a></span>
			<span><a target="_blank" href="#" _href="http://www.kaixin001.com/repaste/share.php?rurl=http://v.youku.com/v_show/id_:vid:.html&rcontent=http://v.youku.com/v_show/id_:vid:.html&rtitle=:title: http://youku.fm%23vid=:vid:" ><img title=分享到开心网" src="http://static.youku.com/v1.0.0659/v/img/ico_kaixin.gif" /></a></span>
			<span><a target="_blank" href="#" _href="http://space.fetion.com.cn/api/share?source=优酷网&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到飞信空间" src="http://static.youku.com/v1.0.0659/v/img/feixin_14px.png" /></a></span>
			<span><a target="_blank" href="#" _href="http://www.139.com/share/share.php?tl=953010001&source=shareto139_youku&url=http://v.youku.com/v_show/id_:vid:.html&title=title=:title: http://youku.fm%23vid=:vid:" ><img title=分享到139说客" src="http://static.youku.com/v1.0.0659/v/img/ico_139.gif" /></a></span>
			<span><a target="_blank" href="#" _href="http://share.renren.com/share/buttonshare.do?link=http://v.youku.com/v_show/id_:vid:.html&title=:title:"><img src="http://static.youku.com/v/img/ico_renren.gif" /></a></span>
		</div>


		<div id="CtLogin" class="hide" title="{'登录'|tr}">
			<div class="login-box">
				<form id="_FormLogin" onsubmit="return YoukuWs.formlogin();" action="post">
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


		<!-- 拖动歌曲弹出层 默认下拉菜单们关闭层 在drag-layer加入hover样式即可切换为打开状态 -->
		<div id="drag-layer" style="position: absolute;left:0px;top:0px"; class="mvlist-edit-layer hide">
			<div class="top"><p>添加到歌单<i class="icon-down"></i><i class="icon_add"></i></p></div>
			<a id="_BtTrash2" class="icon_del" title="删除"></a>

			<div class="mdrag-layer" id="_ContentList">
				<ul>
					<li><a  title="">华语流行金曲(23)</a></li>
				</ul>

				<a  title="">华语流行金曲(23)</a>
				<a  title="">华语流行金曲(23)</a>
				<a  title="">华语流行金曲(23)</a>
				<a  title="" class="hover">华语流行金曲(23)</a>
				<a  title="">华语流行金曲(23)</a>
			</div>
		</div>


		<!-- 注册 -->
		<div id="_ContentSignup" class="hide">
			<div class="reg-box">
				<div class="msgbox" style="display:none"><i class="notice"></i> 请输入正确的邮箱地址</div>
				<ul class="elm-list">
					<li class="label"><label for="username">邮箱:</label></li>
					<li class="input"><input class="txt" type="text" id="username" /></li>
					<li class="label"><label for="nickname">昵称:</label></li>
					<li class="input"><input class="txt" type="text" id="nickname" /></li>
					<li class="label"><label for="password">密码:</label></li>
					<li class="input"><input class="txt" type="password" id="password" /></li>
					<li class="label"><label for="password2">确认密码:</label></li>
					<li class="input"><input class="txt" type="password" id="password2" /></li>
					<li class="line"><input type="checkbox" id="readed" /><label for="readed">我已阅读并接受优酷</label><a>注册协议</a><span>和</span><a>版权声明</a></li>
					<li class="line des">电子邮箱和昵称注册后不能修改，请仔细核对</li>
					<li class="singleBtn"><a class="btn-login hover">注册</a></li>
				</ul>
			</div>
		</div>
		<div id="_RadioChannel" title="电台选择" class="hide">
			<!-- 切换电台 -->
			
			<div class="cgfm-box">
				<ul>
					<li><a class="btn-fm-d"  title="">默认电台</a></li>
					<li><a class="btn-fm-d"  title="">70后MHZ</a></li>
					<li><a class="btn-fm-d"  title="">80后MHZ</a></li>
					<li><a class="btn-fm-d"  title="">90后MHZ</a></li>
				</ul>
				<ul>
					<li><a class="btn-fm-d"  title="">华语MHZ</a></li>
					<li><a class="btn-fm-d"  title="">粤语MHZ</a></li>
					<li><a class="btn-fm-d"  title="">欧美MHZ</a></li>
					<li><a class="btn-fm-d"  title="">日语MHZ</a></li>
					<li><a class="btn-fm-d"  title="">韩语MHZ</a></li>
					<li><a class="btn-fm-d"  title="">2011年国语新曲</a></li>
					<li><a class="btn-fm-d"  title="">2011年日韩新曲</a></li>
					<li><a class="btn-fm-d"  title="">2011年欧美新曲</a></li>
				</ul>
				<ul class="big">
					<li><a class="btn-fm-d big"  title="">2010年流行金曲</a></li>
					<li><a class="btn-fm-d big"  title="">2011年国语新曲</a></li>
					<li><a class="btn-fm-d big"  title="">2011年日韩新曲</a></li>
					<li><a class="btn-fm-d big"  title="">2011年欧美新曲</a></li>
				</ul>
			</div>
			
		</div>
		<div id="_CtMusicList" class="hide" _title="歌曲列表">
			<!-- 我的歌单(整理歌曲) -->
			<div id="loading" style="text-align:center;padding:10px;position: absolute;width: 100%;top: 30%;z-index: 999;">
				<img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在加载中...
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
				<div class="singleBtn">
					<a  title="" class="btn-layer-d">确定</a>
				</div>
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
	<!--
	<div class="layer-swbox">
		<div class="swbox-cont">
			<p>你眷恋的 都已离去</p>
			<p>你问过自己无数次 想放弃的</p>
			<p>眼前全在这里</p>
			<p>超脱和追求时常是混在一起</p>
			<p>你拥抱的 并不总是也拥抱你</p>
			<p>而我想说的 谁也不可惜</p>
			<p>去挥霍和珍惜是同一件事情</p>
			<p>眼前全在这里</p>
			<p>超脱和追求时常是混在一起</p>
			<p>你拥抱的 并不总是也拥抱你</p>
		</div>
		<div class="singleBtn">
			<a  class="btn-layer-d" title="">关闭</a>
		</div>
	</div>
	-->
	<div id="_IDList" class="hide" _title="我的歌单"/>
		<!-- 我的歌单 -->
		<table style="width:100%">
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


	</body>

</html>

