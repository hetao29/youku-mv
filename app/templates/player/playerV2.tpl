<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<title>{'标题'|tr}</title>
{if defined($smarty.const.DEV)}
				<script type="text/javascript" src="/assets/js/jquery-1.5.1.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.corner.js"></script>
				<script type="text/javascript" src="/assets/js/jquery-ui-1.8.7.custom.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<script type="text/javascript" src="/assets/js/json2.js"></script>
				<script type="text/javascript" src="/assets/js/player.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
				<link href="/assets/css/styleV2.css" media="all" rel="stylesheet" type="text/css" />
{else}
				<script type="text/javascript" src="{'/player.js'|version:$jsversion}"></script>
				<link href="{'/player.css'|version:$cssversion}" media="all" rel="stylesheet" type="text/css" />
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
		<body>
{*
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
										<div id="copyright">2011 @copyright</div>
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
												<ul id="_IDNav">
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
<a id="_IDUp">{"顶"|tr}</a>
<a id="_IDDown">{"删"|tr}</a></div>
										</div>
										<div class="list" id="_IDLocalList" style="display:none">
												<div style="padding-bottom:5px;padding-top:5px;text-align:left">
														<form onsubmit="search();return false;" style="vertical-align:middle">
																<input style="vertical-align:middle" type="search" size="18" id="keywords" placeholder="请输入关键词" autofocus="" value="" autocomplete="off" />
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
<ul>
{*
{foreach item=item from=$radios->items}
	<li><button {if empty($item.ListCount)}disabled{/if} id="{$item.ListID}" ct="{$item.ListCount}">播放</button> {$item.ListName}({$item.ListCount}个视频)</li>
{/foreach}
*}
</ul>
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
{*
																<span id="_IDLyricsBk" style="cursor:pointer;border:1px solid;">{"后退"|tr}</span>
																<span id="_IDLyricsPr" style="cursor:pointer;border:1px solid;">{"前进"|tr}</span> 
																<span id="_IDLyricsErr" style="cursor:pointer;border:1px solid;">{"报错"|tr}</span>
																<span id="_IDLyricsView" style="cursor:pointer;border:1px solid;">{"查看"|tr}</span>
*}
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
										<form>
												<div>{"歌单名"|tr}：<input type="text" id="_IDListName"/><input id="_IDListAdd" type="button" value="{'建立'|tr}"/></div>
										</form>
										<hr/>
								</div>
								<ul id="_ContentList">
								</ul>
						</div>
						<div id="_ContentLogin" title="{'登录'|tr}" style="display:none">
								<form id="_FormLogin" style="padding:10px;margin:auto;">
										<table width="100%">
												<tr><td class="info" colspan="2">&nbsp;</td></tr>
												<tr><td>{'邮箱'|tr}:</td><td><input name="useremail"/></td></tr>
												<tr><td>{'密码'|tr}:</td><td><input type="password" name="password"/></td></tr>
												<tr>
														<td></td>
														<td><input type="checkbox" id="forever" name="forever"/><label for="forever">{"记住登录"|tr}</label>
																<a id="_IDSignup2">{"注册"|tr}</a>
														</td>
												</tr>
										</table>
								</form>
						</div>
						<div id="_ContentSignup" title="{'注册'|tr}" style="display:none">
								<form id="_FormSignup" style="padding:10px;margin:auto;">
										<table width="100%">
												<tr><td class="info" colspan="2">&nbsp;</td></li>
												<tr><td>{'邮箱'|tr}:</td><td><input name="useremail"/></td></tr>
												<tr><td>{'别名'|tr}:</td><td><input name="useralias"/></td></tr>
												<tr><td>{'密码'|tr}:</td><td><input type="password" name="password"/></td></tr>
												<tr><td>{'密码确认'|tr}:</td><td><input type="password" name="password2"/></td></tr>
										</table>
								</form>
						</div>
						<div id="_ContentAbout" title="{'关于'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-left:45px;">
										{"copyright"|tr}
								</div>
						</div>
						<div id="_ContentUsage" title="{'使用说明'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-left:45px;">
										{"copyright"|tr}
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
		</body>
		<div style="display:none"><script src="http://s16.cnzz.com/stat.php?id=2780428&web_id=2780428&show=pic" language="JavaScript"></script></div>
</html>
