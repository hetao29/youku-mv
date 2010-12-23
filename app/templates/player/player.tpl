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
				<script type="text/javascript" src="/assets/js/player.js"></script>
				<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
{*<script type="text/javascript" src="/assets/js/youku.ws.js"></script>*}
{literal}
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
{/literal}
		</head>
		<script>
				var _LabelOk="{'确认'|tr}";
				var _LabelCancel="{'取消'|tr}";
		</script>
		<body>
{if !empty($facebook)}
{literal}
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
window.fbAsyncInit = function() {
FB.init({
    appId  : '173211992709193',
    status : false, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
});
FB.Canvas.setAutoResize();
//FB.Canvas.setSize({ width: 910, height: 520 });
}
</script>
{/literal}
{/if}

				<div class="header">
						{part path="/player.main.header"}
				</div>
				<div class="content">

						<div class="main">
								<div class="left" style="border-right:1px solid #F0F0F0;">
										<div class="list">
												<div>
														<form onsubmit="search();return false;" style="vertical-align:middle">
																<input style="vertical-align:middle" type="text" size="18" id="keywords" placeholder="请输入关键词" autofocus="" value="" autocomplete="off" class="ui-widget-content" />
																<button id="_BtSearch" style="vertical-align:middle" class="ui-button ui-widget ui-state-default ui-corner-all">{'搜索'|tr}</button>
														</form>
												</div>
												<div id="_Content" style="position:relative;padding-top:6px;padding-bottom:6px;">
														<ul id="_ContentMusic" style="display:block;height:272px;overflow:hidden;overflow-y:auto;">
														</ul>
												</div>
												<div id="action">
														<div>
																<button style="width:100px;" id="_BtAddMv">增加歌曲</button>
																<button style="width:100px;" id="_BtTrash">回收站</button>
																<button style="width:100px;" id="_BtSaveList">保存歌曲</button>
																<button style="width:100px;" id="_BtOpenList">打开歌单</button>
																<!--<button style="width:110px;" id="_BtAddList">增加歌单</button>-->
														</div>
												</div>

										</div>

								</div>
								<div class="left">
										<div class="playerBox"><div id="player"></div></div>
										<div>
												<div id="PlayModeSet" style="display:none">
														<input type="radio" disabled id="set0" name="set" value="0"/>
														<label style="width:95px;" for="set0">{'播放设置'|tr}</label>
														<input type="radio" id="set1" name="set" value="1"/>
														<label style="width:95px;" for="set1">{'单曲循环'|tr}</label>
														<input type="radio" id="set2" name="set" value="2" checked/>
														<label style="width:95px;" for="set2">{'循环播放'|tr}</label>
														<input type="radio" id="set3" name="set" value="3"/>
														<label style="width:95px;" for="set3">{'随机播放'|tr}</label>
												</div>
										</div>
								</div>
								<div class="right" style="width:240px;position:relative;">
										<div class="googlead">
												<script type="text/javascript">
														google_ad_client = "ca-pub-8444474852440924";
														/* YOUKU-234-60 */
														google_ad_slot = "1537780825";
														google_ad_width = 234;
														google_ad_height = 60;
												</script>
												<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
										</div>
										<div id="_LyricsTop" class="lyrics_top" style="display:none;padding-left:5px;padding-right:5px;width:225px;"></div>
										<div id="_ContentLyrics" class="lyrics" style="overflow:hidden;width:225px;height:278px;"></div>
										<div id="_IDLyricsAdmin" style="display:none">
												<span id="_IDLyricsBk" style="cursor:pointer;border:1px solid;">后退</span>
												<span id="_IDLyricsPr" style="cursor:pointer;border:1px solid;">前进</span> 
												<span id="_IDLyricsEd" style="cursor:pointer;border:1px solid;">编辑</span>
												<span id="_IDLyricsErr" style="cursor:pointer;border:1px solid;">报错</span>
												<span id="_IDLyricsView" style="cursor:pointer;border:1px solid;">查看</span>
												<span id="_IDLyricsInfo" style="position:absolute;top:348px;left:180px;"></span>
										</div>
								</div>
								<div class="clear"></div>
						</div>
						<div class="googlead" style="padding:5px;margin:auto;zoom:1;">
								<script type="text/javascript">
										google_ad_client = "ca-pub-8444474852440924";
										/* YOUKU */
										google_ad_slot = "2284360826";
										google_ad_width = 728;
										google_ad_height = 90;
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>
						</div>
				</div>

				<div id="debug"></div>
				<div id="debug2"></div>
				<div>

						<div id="_DialogAdd" title="增加歌曲" style="display:none;">
								<div>请输入优酷播放页地址:</div>
								<div><textarea style="width:460px;height:24px">http://v.youku.com/v_show/id_XMjI2MDIxNTYw.html</textarea></div>
								<div>如普通播放页：http://v.youku.com<span class="red">/v_show/id_XMjI2MDIxNTYw</span>.html</div>
								<div>如专辑播放页：http://v.youku.com<span class="red">/v_playlist/f5358705o1p2</span>.html</div>
								<div>如节目显示页：http://www.youku.com<span class="red">/show_page/id_zd121155eef0a11df97c0</span>.html</div>
								<div>如专辑显示页：http://www.youku.com<span class="red">/playlist_show/id_5358705</span>.html</div>
								<div>一次只能添加一种地址</div>
								<div id="_DialogAdding" style="text-align:center;display:none"><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在添加中...</div>
						</div>

						<ul id="_ContentSearch" style="display:none">
						</ul>
						<ul id="_ContentList" style="display:none;">
								<li lid="">
										<div class="left">黄晓明 2</div><div>9首</div>
								</li>
								<li lid="">
										<div>黄晓明 2</div>
								</li>
						</ul>
						<div id="_ContentLogin" title="{'登录'|tr}" style="display:none">
								<form id="_FormLogin" style="padding:10px;margin:auto;">
										<table width="100%">
												<tr><td class="info" colspan="2">&nbsp;</td></tr>
												<tr><td>{'邮箱'|tr}:</td><td><input name="useremail"/></td></tr>
												<tr><td>{'密码'|tr}:</td><td><input type="password" name="password"/></td></tr>
												<tr>
													<td></td>
													<td><input type="checkbox" id="forever" name="forever"/><label for="forever">记住登录</label>
													<a id="_IDSignup2">注册</a>
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
										作者:Hetal 2010-12-15<br/>
										版本所有,山寨必究
								</div>
						</div>
						<div id="_ContentUsage" title="{'使用说明'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;padding-left:45px;">
										作者:Hetal 2010-12-15<br/>
										版本所有,山寨必究
								</div>
						</div>
						<div id="_ContentLyricsView" title="{'查看歌词'|tr}" style="display:none">
								<div style="padding:15px;margin:auto;text-align:center">
								</div>
						</div>
				</div>
		</body>
</html>
