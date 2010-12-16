<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>YOUKU MV PLAYER</title>
{*
				<script type="text/javascript" src="/slightphp/js/jquery-1.4.4.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<script type="text/javascript" src="/assets/js/json2.js"></script>
				<script type="text/javascript" src="/assets/js/player.js"></script>
*}
				<link href="/assets/css/style.css" media="all" rel="stylesheet" type="text/css" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="/assets/js/youku.ws.js"></script>
		</head>
		<script>
		var _LabelOk="{'确认'|tr}";
		var _LabelCancel="{'取消'|tr}";
		</script>
		<body>

				<div class="header">
{part path="/player.main.header"}
				</div>
				<div class="content">

				<!--
						<div class="main">
							<div class="left" style="border-right:1px solid #F0F0F0;">
										<div class="list">
										few
										</div>
								
							</div>
							<div class="left">center</div>
							<div class="right">right</div>
							<div class="clear"></div>
						</div>
						-->
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
										<div id="_IDLyricsAdmin">
											<span id="_IDLyricsBk" style="cursor:pointer;border:1px solid;">后退</span>
											<span id="_IDLyricsPr" style="cursor:pointer;border:1px solid;">前进</span> 
										   	<span id="_IDLyricsEd" style="cursor:pointer;border:1px solid;">编辑</span>
										   	<span id="_IDLyricsErr" style="cursor:pointer;border:1px solid;">报错</span>
											<span id="_IDLyricsInfo" style="position:absolute;top:348px;left:180px;"></span>
										</div>
								</div>
							<div class="clear"></div>
						</div>
						<div class="googlead" style="padding:5px;margin:auto">
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
				<div id="info"></div>

				<div id="debug"></div>
				<div id="debug2"></div>
{*				<textarea id="lyrics_c" style="display:none;">
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
*}
				<div id="_DialogAdd" style="display:none;">
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
					<form id="_FormLogin" style="padding:15px;margin:auto;text-align:center">
						<ul>
						<li><div>{'账号'|tr}:<input name="username"/></div></li>
						<li><div>{'密码'|tr}:<input type="password" name="password"/></div></li>
						<li><div class="info"></div></li>
						<!--<li><div><input type="checkbox" /><label>记住</label><a>忘记密码</a></div></li>-->
						<ul>
					</form>
				</div>
				<div id="_ContentSignup" title="{'注册'|tr}" style="display:none">
					<form id="_FormSignup" style="padding:15px;margin:auto;text-align:center">
						<ul>
						<li><div>账号:<input id="username" name="username"/></div></li>
						<li><div>密码:<input name="password"/></div></li>
						<!--<li><div><input type="checkbox" /><label>记住</label><a>忘记密码</a></div></li>-->
						<ul>
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
		</body>
</html>
