<!DOCTYPE html>
<html>
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<title>{'标题'|tr}</title>
				{if defined($smarty.const.DEV)}
				<script type="text/javascript" src="/assets/js/jquery-1.5.1.js"></script>
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
				<script type="text/javascript" src="/assets/js/player.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
				<link href="/assets/css/styleV2.css" media="all" rel="stylesheet" type="text/css" />
				{else}
				<link href="{'/player.css'|version:$cssversion}" media="all" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="{'/player.js'|version:$jsversion}"></script>
				{/if}
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
				<script type="text/javascript">
						var _LabelOk="{'确认'|tr}";
						var _LabelCancel="{'取消'|tr}";
				</script>
		</head>
		<body>{*
			<div id="IDTips" style="position:absolute;top:0px;width:100%;text-align:center;margin:auto">
				<span style="background: #FFF; color: #000; margin: 0px; padding: 5px; height: 25px; line-height: 25px; padding-left: 20px; padding-right: 25px; border-bottom-left-radius: 8px 8px; border-bottom-right-radius: 8px 8px;">
				wfefwefef 中国人兴旺污染                  不
				</span>
			</div>
				
				<a style="width:50px" id="test">fjiw</a>
				<a class="bt" bt_set="true" style="width:60px">
						<span class="bt_b"> 
								<span class="bt_c">&nbsp;</span> 
								<span class="bt_d">
										<span style="padding-top:3px" class="left ui-icon ui-icon-play"></span>
										<span class="right">Play</span>
								</span>
						</span>
				</a>

				<a class="bt" bt_set="true">
						<span class="bt_b"> 
								<span class="bt_c">&nbsp;</span>
								<span class="bt_d">Play</span>
						</span>
				</a>
				*}
				{*
				<a href="#nogo" class="bt_a">
						<span class="bt_b">
								<span class="bt_c">&nbsp;</span>
								<span class="bt_d">
										圆角按钮</span>
						</span>
				</a>
				*}
{*
				<div style="position:absolute;width: 100%;margin: auto;background-color:green;text-align:center;">fwef
					<div class="center" style="position:absolute;width: 756px;background-color:red;text-align:center;">fwef</div>
				</div>
				*}
				{if !empty($facebook)}
				<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js"></script>
				<script type="text/javascript">
						window.fbAsyncInit = function() {
						FB.init({
						appId  : '173211992709193',
						status : false, // check login status
						cookie : true, // enable cookies to allow the server to access the session
						xfbml  : true  // parse XFBML
						});
						FB.Canvas.setSize({ height: 540 });
						window.setTimeout(function() {
						//FB.Canvas.setAutoResize();
						FB.Canvas.setSize({ height: 540 });
						},250);
						}
						//$(function() {
						//						$( "#tabs" ).tabs();
						//							});
				</script>
				{/if}

{*
				<div style="width:800px;margin: 0px auto;position:relative">
					<div class="center" style="-moz-opacity:0.5;filter:alpha(opacity=50);opacity:0.5;z-index:99;background-color:#101010;position:fixed;_position:absolute;width: 800px;height:600px;background-color:red;text-align:center;color:#000">
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						<span style="position:relative;color:yellow">图层背景半透明，字体颜色不半透明</span>
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
						fwef<br />
					</div>
				</div>
*}

				{if empty($facebook)}
				<div class="header" id="_IDHeader">
						{part path="/player.main.header"}
				</div>
				{/if}
				<div class="content">

						<div class="main">
								<div class="left shadow" id="box">
										<div class="title">
												<span class="right"><a title="宽屏" href="javascript:void(0);" id="_IDThx"><span class="thx_close"></span></a></span>
												<span style="line-height:22px" id="title">Youku.FM</span>
										</div>
										<hr />
										<div id="playerBox" class="playerBox"><div id="player"></div></div>
										{*<div style="height:65px">
												<img src="/assets/images/style2/center.png" />
										</div>
										*}
										<div id="musicInfo"></div>
										<div id="share_handle"> 
											<img id="ImgDown" style="" width="16" src="/assets/images/ico/down.png" />
											<img id="ImgUp" style="display:none" width="16" src="/assets/images/ico/up.png" />
										</div>
										<div id="share" style="display:none;"> 
												<span><a target="_blank" href="#" _href="http://v.t.sina.com.cn/share/share.php?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm?vid=:vid:&content=utf8"><img title="分享到新浪微薄" src="http://static.youku.com/v/img/ico_sina.gif" /></a></span>
												<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm?vid=:vid:" ><img title=分享到QQ空间" src="http://static.youku.com/v/img/ico_Qzone.gif" /></a></span>
												<span><a target="_blank" href="#" _href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm?vid=:vid:" ><img title=分享到腾讯朋友" src="http://static.youku.com/v1.0.0659/v/img/ico_pengyou.png" /></a></span>
												<span><a target="_blank" href="#" _href="http://www.kaixin001.com/repaste/share.php?rurl=http://v.youku.com/v_show/id_:vid:.html&rcontent=http://v.youku.com/v_show/id_:vid:.html&rtitle=:title: http://youku.fm?vid=:vid:" ><img title=分享到开心网" src="http://static.youku.com/v1.0.0659/v/img/ico_kaixin.gif" /></a></span>
												<span><a target="_blank" href="#" _href="http://space.fetion.com.cn/api/share?source=优酷网&url=http://v.youku.com/v_show/id_:vid:.html&title=:title: http://youku.fm?vid=:vid:" ><img title=分享到飞信空间" src="http://static.youku.com/v1.0.0659/v/img/feixin_14px.png" /></a></span>
												<span><a target="_blank" href="#" _href="http://www.139.com/share/share.php?tl=953010001&source=shareto139_youku&url=http://v.youku.com/v_show/id_:vid:.html&title=title=:title: http://youku.fm?vid=:vid:" ><img title=分享到139说客" src="http://static.youku.com/v1.0.0659/v/img/ico_139.gif" /></a></span>
												<span><a target="_blank" href="#" _href="http://share.renren.com/share/buttonshare.do?link=http://v.youku.com/v_show/id_:vid:.html&title=:title:"><img src="http://static.youku.com/v/img/ico_renren.gif" /></a></span>
										</div>
										<div id="copyright"> 
											©2010-2011   Youku.FM
										</div>
								</div>
								<div id="_IDRight" class="box2 right" style="width:255px">
										{*
										<div id="rightTop" style="height:12px;margin-top:15px;background-color:rgb(136,136,136)">
										</div>
										<div style="height:40px;background-color:rgb(115,139,170)">
												<input style="margin:8px" type="text"/>
										</div>
										*}
										<div style="padding-top:10px;">
												<ul id="IDNav">
														<li><a>{'电台模式'|tr}</a></li>
														<li><a>{'播放模式'|tr}</a></li>
														<li><a>{'显示歌词'|tr}</a></li>
												</ul>
												<div class="clear"></div>
										</div>
										<div class="list" id="_IDRadio" style="display:none;">
												<div id="_IDRadio2" style="display:none">
														<div style="padding:10px;"><b>{"当前播放"|tr}:</b><span id="_IDVideoTitle"></span><div><img id="_IDVideoPic" class="shadow" /></div></div>
														<div style="padding:10px"><b>{"接着播放"|tr}:</b><span id="_IDNextVideoTitle"></span>
																<div><img id="_IDNextVideoPic" class="shadow" /></div>
														</div>
												</div>
												<div id="_IDRadio3" style="height:150px"></div>
												<div>
														<a id="_IDSkip" style="" title="跳过这个视频">{'跳过'|tr}</a>
														<a id="_IDPlay" style="display:none">{'播放'|tr}</a>
														<a id="_IDChange">{'换台'|tr}</a>
														<a id="_IDUp">{"喜欢"|tr}</a>
														<a id="_IDDown">{"不喜欢"|tr}</a></div>
										</div>
										<div class="list" id="_IDLocalList" style="display:none">
												<div style="padding-bottom:5px;padding-top:5px;text-align:left">
														<form onsubmit="search();return false;" style="vertical-align:middle">
																<input style="vertical-align:middle" type="search" size="18" id="keywords" placeholder="请输入关键词" value="" autocomplete="off" />
																<a id="_BtSearch">{'搜索'|tr}</a>
														</form>
												</div>
												<div id="_Content" style="position:relative;">
														<ul id="_ContentMusic" style="display:block;height:230px;overflow:hidden;overflow-y:auto;">
														</ul>
												</div>
												<div id="action">
														<div>
																<div id="PlayModeSet" style="">
																		<input type="radio" id="set1" name="set" value="1"/>
																		<label style="width:95px;" for="set1">{'单曲'|tr}</label>
																		<input type="radio" id="set2" name="set" value="2" checked/>
																		<label style="width:95px;" for="set2">{'循环'|tr}</label>
																		<input type="radio" id="set3" name="set" value="3"/>
																		<label style="width:95px;" for="set3">{'随机'|tr}</label>
																</div>
														</div>
														<div style="padding-bottom:6px">
																<a id="_BtAddMv">{'增加'|tr}</a>
																<a id="_BtTrash">{'删除'|tr}</a>
																<a id="_BtSaveList">{'保存'|tr}</a>
																<a id="_BtClearList">{'清空'|tr}</a>
														</div>
														<div>
																<a id="_BtPre">{'上一首'|tr}</a>
																<a id="_BtNext">{'下一首'|tr}</a>
														</div>
												</div>

										</div>
										<div title="电台选择" id="_RadioChannel" style="display:none">
												<ul></ul>
										</div>
										<div class="list" id="_IDLyrics" style="display:none">
												<div id="tabs-lyrics" style="width:240px;position:relative;">
														<div id="_LyricsTop" class="lyrics_top" style="display:none;padding-left:5px;padding-right:5px;width:225px;"></div>
														<div id="_ContentLyrics" class="lyrics" style="overflow:hidden;width:225px;height:300px;"></div>
														<div id="_IDLyricsAdmin" style="display:none">
																<a id="_IDLyricsBk">{"后退"|tr}</a>
																<a id="_IDLyricsPr">{"前进"|tr}</a>
																<a id="_IDLyricsErr">{"报错"|tr}</a>
																<a id="_IDLyricsView">{"查看"|tr}</a>
																<span id="_IDLyricsInfo" style="position:absolute;top:304px;left:200px;width:60px;"></span>
														</div>
												</div>
										</div>

								</div>
								<div class="clear"></div>
						</div>
						{*						<div id="googlead" class="googlead" style="padding:5px;margin:auto;zoom:1;">
								<script type="text/javascript">
										google_ad_client = "ca-pub-8444474852440924";
										/* YOUKU */
										google_ad_slot = "2284360826";
										google_ad_width = 728;
										google_ad_height = 90;
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>
						</div>
						*}
				</div>

				<div>

						<div id="_DialogAdd" title="{'增加歌曲'|tr}" style="display:none;">
								<div>{"请输入优酷播放页地址"|tr}({"一次只能添加一种地址"|tr}):</div>
								<div><textarea style="width:460px;height:24px">http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html</textarea></div>
								<div>{"如普通播放页"|tr}:<br/>http://v.youku.com<span class="red">/v_show/id_XMjI2MDIxNTYw</span>.html</div>
								<div>{"如专辑播放页"|tr}:<br/>http://v.youku.com<span class="red">/v_playlist/f5365488o1p0</span>.html</div>
								<div>{"如节目显示页"|tr}:<br/>http://www.youku.com<span class="red">/show_page/id_zd121155eef0a11df97c0</span>.html</div>
								<div>{"如专辑显示页"|tr}:<br/>http://www.youku.com<span class="red">/playlist_show/id_5365488</span>.html</div>
								<div id="_DialogAdding" style="text-align:center;display:none"><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> {"正在添加中"|tr}...</div>
						</div>

						<ul id="_ContentSearch" style="display:none">
						</ul>
						<div id="_IDList" title="{'歌单'|tr}" style="display:none;position:relative;">
								<div id="_IDListDialogAdding" style="position:absolute;padding:30px;left:140px;top:40px;z-index:99;text-align:center;display:none"><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> {"正在添加中"|tr}...</div>
								<div><span>{"请选择歌单或者"|tr}<b><a id="_AListAdd">{"新建歌单"|tr}</a></b></span></div>
								<div id="_CtListAdd" style="display:none">
										<form onsubmit="return false" >
												<div>{"歌单名"|tr}：<input type="text" id="_IDListName"/><input id="_IDListAdd" type="button" value="{'建立'|tr}"/></div>
										</form>
										<hr/>
								</div>
								<ul id="_ContentList">
								</ul>
						</div>
						<div id="_ContentLogin" title="{'登录'|tr}" style="display:none">
								<form id="_FormLogin" onsubmit="return YoukuWs.formlogin();" style="padding:10px;margin:auto;">
										<table width="100%">
												<tr><td class="info" colspan="2">&nbsp;</td></tr>
												<tr><td>{'邮箱'|tr}/{'用户名'|tr}:</td><td><input type="text" name="useremail"/></td></tr>
												<tr><td>{'密码'|tr}:</td><td><input type="password" type="text" name="password"/></td></tr>
												<tr>
														<td></td>
														<td><input type="checkbox" id="forever" name="forever"/><label for="forever">{"记住登录"|tr}</label>
																<a id="_IDSignup2" style="text-decoration:underline;"><b>{"注册"|tr}</b></a>
														</td>
												</tr>
												<tr><td></td><td><button id="_IDLoginSubmit" type="submit">{'登录'|tr}</button></td></tr>
										</table>
								</form>
						</div>
						<div id="_ContentSignup" title="{'注册'|tr}" style="display:none">
								<form onsubmit="return YoukuWs.formsignup();"  id="_FormSignup" style="padding:10px;margin:auto;">
										<table width="100%">
												<tr><td class="info" colspan="2">&nbsp;</td></li>
												<tr><td>{'邮箱'|tr}:</td><td><input name="useremail"/></td></tr>
												<tr><td>{'别名'|tr}:</td><td><input name="useralias"/></td></tr>
												<tr><td>{'密码'|tr}:</td><td><input type="password" name="password"/></td></tr>
												<tr><td>{'密码确认'|tr}:</td><td><input type="password" name="password2"/></td></tr>
												<tr><td></td><td><button id="_IDSingupSubmit" type="submit">{'注册'|tr}</button></td></tr>
										</table>
								</form>
						</div>
						<div id="_ContentAbout" title="{'关于'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-left:45px;">
										{"copyright"|tr}
								</div>
						</div>
						<div id="_ContentUsage" title="{'使用说明'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-top:5px;">



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
	上一首，向上(Up)/向左(Left)，在“电台模式”下，这按钮没有作用
	下一首，向下(Down)/向右(Right)
	播放/暂停，空格键(Space)
	宽屏/标屏，回车键(Enter)

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
	英文/繁体中文/简体中文</pre>





								</div>
						</div>
						<div id="_ContentClearList" title="{'删除确认'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-left:45px;">
										{"您确定要清空吗"|tr}?
								</div>
						</div>
						<div id="_ContentLyricsView" title="{'显示歌词'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;text-align:center">
								</div>
						</div>
						<div id="_ContentListen" style="display:none">
								<ul style="padding:15px;margin:auto;">
										<li></li>
								</ul>
						</div>
						{*<a onclick="PlayerPause(true)">d</a>
						<a onclick="PlayerPause(false)">e</a>
						<div id="fullscreen" style="display:none;z-index:100;width:100%;text-align:center;position:absolute;"><button id="_IDFullscreen">fullscreen</button></div>
						*}
				</div>
				<div style="display:none"><script src="http://s16.cnzz.com/stat.php?id=2780428&web_id=2780428&show=pic" language="JavaScript"></script></div>
{*
				<div id="debug">debug</div>
				<div id="debug2">debug2</div>
				*}
		</body>
</html>
