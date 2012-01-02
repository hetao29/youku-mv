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

			};
			var out="{$out}";
			var _LabelOk="{'确认'|tr}";
			var _LabelCancel="{'取消'|tr}";
			var _initVid="{$vid}";
		</script>
		</head>

<body>
		<div class="t-header">
			{part "/player.main.headerV3.".$out}
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

<!-- 遮盖 半透明背景 -->
<div id="over" class="screen-over" style="display:none";>&nbsp;</div>

<!-- 弹出层 外框架相同，只改变 class="content"内容 及标题(h2 class="ly-title")内容 以及 h3 class="list-des" 的display属性即可 h3只有我的歌单列表时显示 -->
<div class="layer" id="layer" style="display:none";>
	<div class="ly-box">
    	<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
        <div class="cont-border">
        	<div class="left"><div class="box"></div></div>
            <h2 id="ly-title" class="ly-title">我的歌单<span>/华语流行金曲 -> 整理歌曲</span></h2>
            <h3 class="list-des" style="display:none;"><i class="face"></i>您可以将播放列表内的歌曲直接拖动到歌单内</h3>
            <a class="close" href="" title="关闭">关闭</a>
            <div class="content">
            	<!-- 登陆 -->
				<!--
            	<div class="login-box">
                	<div class="msgbox"><i class="error"></i> 请输入正确的邮箱地址</div>
                	<ul class="elm-list">
                    	<li class="label"><label for="username">用户名:</label></li>
                        <li class="input"><input class="txt" type="text" id="username" /></li>
                        <li class="label"><label for="password">密码:</label></li>
                        <li class="input"><input class="txt" type="password" id="password" /></li>
                        <li class="label ck"></li>
                        <li class="input ck"><input class="ckbox" type="checkbox" id="forever" /><label for="forever" class="ck-label">下次自动登录</label></li>
                        <li class="label ck"></li>
                        <li class="input ck"><a href="" title="" class="btn-login hover">登陆</a>　<a href="" title="" class="btn-login">注册</a></li>
                    </ul>
                </div>
				-->
                
                <!-- 注册 -->
                <!--
                <div class="reg-box">
                	<div class="msgbox"><i class="notice"></i> 请输入正确的邮箱地址</div>
                    <ul class="elm-list">
                    	<li class="label"><label for="username">邮箱:</label></li>
                        <li class="input"><input class="txt" type="text" id="username" /></li>
                        <li class="label"><label for="nickname">昵称:</label></li>
                        <li class="input"><input class="txt" type="text" id="nickname" /></li>
                        <li class="label"><label for="password">密码:</label></li>
                        <li class="input"><input class="txt" type="password" id="password" /></li>
                        <li class="label"><label for="password2">确认密码:</label></li>
                        <li class="input"><input class="txt" type="password" id="password2" /></li>
                        <li class="line"><input type="checkbox" id="readed" /><label for="readed">我已阅读并接受</label><a href="" title="" target="_blank">注册协议</a><span>和</span><a href="" title="" target="_blank">版权声明</a></li>
                        <li class="line des">电子邮箱和昵称注册后不能修改，请仔细核对</li>
                        <li class="singleBtn"><a href="" title="" class="btn-login hover">注册</a></li>
                    </ul>
                </div>
                -->
                
                <!-- 删除确认 -->
                <!--
                <div class="msg-box">
                	<div class="cont">
                        <i class="warning"></i>
                        <span>确证要删除吗？</span>
                   	</div>
                    <div class="singleBtn">
                    	<a href="" title="" class="btn-layer-d">确定</a>　<a href="" title="" class="btn-layer-d">取消</a>
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
                    	<a href="" title="" class="btn-layer-d">确定</a>　<a href="" title="" class="btn-layer-d">取消</a>
                    </div>
                </div>
                -->
                
                <!-- 切换电台 -->
                <!--
                <div class="cgfm-box">
                	<ul>
                    	<li><a class="btn-fm-d" href="" title="">默认电台</a></li>
                        <li><a class="btn-fm-d" href="" title="">70后MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">80后MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">90后MHZ</a></li>
                    </ul>
                    <ul>
                    	<li><a class="btn-fm-d" href="" title="">华语MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">粤语MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">欧美MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">日语MHZ</a></li>
                        <li><a class="btn-fm-d" href="" title="">韩语MHZ</a></li>
                    </ul>
                    <ul class="big">
                    	<li><a class="btn-fm-d big" href="" title="">2010年流行金曲</a></li>
                        <li><a class="btn-fm-d big" href="" title="">2011年国语新曲</a></li>
                        <li><a class="btn-fm-d big" href="" title="">2011年日韩新曲</a></li>
                        <li><a class="btn-fm-d big" href="" title="">2011年欧美新曲</a></li>
                    </ul>
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
                    	<a href="" class="btn-layer-d" title="">关闭</a>
                    </div>
                </div>
                 -->
                
                <!-- 我的歌单 -->
                <!--
                <div class="mylist-box">
                	<div class="mylist-cont">
                    	<ul class="list">
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        	<li>
                            	<h2><a href="" title="">华语流行金曲</a><span>(15)</span><a href="" title="" class="btn-play-s"></a></h2>
                                <p>最后更新：<span>2011-12-02</span></p>
                                <p>甜而温暖，重复一整天也不会腻味，七克力般甜蜜的声音。重复一整天也不会腻味。</p>
                                <div class="edit"><a href="" title="删除">删除</a><a href="" title="编辑">编辑</a><a href="" title="整理歌曲">整理歌曲</a></div>
                            </li>
                        </ul>
                    </div>
                    <div class="singleBtn">
                    	<a href="" title="" class="btn-layer-d big icon"><i class="add"></i>新建歌单</a>
                    </div>
                </div>
                -->
                
                <!-- 我的歌单(整理歌曲) -->
               <!--
               	<div class="mylist-box">
                	<div class="mylist-cont">
                    	<ul class="mvlist">
                        	<li>
                            	<i class="checkbox"></i>
                                <p>如果云知道，非凡乐队</p>
                                <span><a href="" title="" class="btn-c"><i class="remove"></i></a><a href="" title="" class="btn-c"><i class="play"></i></a></span>
                            </li>
                            <li>
                            	<i class="checkbox"></i>
                                <p>如果云知道，非凡乐队</p>
                                <span><a href="" title="" class="btn-c"><i class="remove"></i></a><a href="" title="" class="btn-c"><i class="play"></i></a></span>
                            </li>
                            <li>
                            	<i class="checkbox"></i>
                                <p>如果云知道，非凡乐队</p>
                                <span><a href="" title="" class="btn-c"><i class="remove"></i></a><a href="" title="" class="btn-c"><i class="play"></i></a></span>
                            </li>
                            <li>
                            	<i class="checkbox"></i>
                                <p>如果云知道，非凡乐队</p>
                                <span><a href="" title="" class="btn-c"><i class="remove"></i></a><a href="" title="" class="btn-c"><i class="play"></i></a></span>
                            </li>
                            <li>
                            	<i class="checkbox"></i>
                                <p>如果云知道，非凡乐队</p>
                                <span><a href="" title="" class="btn-c"><i class="remove"></i></a><a href="" title="" class="btn-c"><i class="play"></i></a></span>
                            </li>
                        </ul>
                        
                        <div class="pages">
                        	<div class="pg-box">
                            	<a class="fl" title="上一页" href="">上一页</a>
                                <a href="" title="">1</a>
                                <a href="" title="">2</a>
                                <a href="" title="">3</a>
                                <a href="" title="">4</a>
                                <a href="" title="">5</a>
                                <a href="" title="">6</a>
                                <i>8</i>
                                <a href="" title="">9</a>
                                <i>...</i>
                                <a href="" title="18">18</a>
                                <a href="" title="18">19</a>
                                <a class="fl" title="下一页" href="">下一页</a>
                            </div>
                        </div>
                    </div>
                    <div class="singleBtn">
                    	<a href="" title="" class="btn-layer-d">全选</a>
                        <a href="" title="" class="btn-layer-d">反选</a>
                        <a href="" title="" class="btn-layer-d">删除</a>
                        <a href="" title="" class="btn-layer-d big">添加歌曲</a>
                        <a href="" title="" class="btn-layer-d big icon ret"><i class="l"></i>返回</a>
                    </div>
                    <a href="" title="右下角不知道干什么的按钮" class="btn-rb">右下角不知道干什么的按钮</a>
                </div>
               	-->
                
                
                <!-- 我的歌单(编辑/新建歌单) -->
				 <!--
               	<div class="mylist-box">
                	<div class="mylist-cont pb-30">
                    	<p class="label-title">精选集名称</p>
                        <input type="text" class="input-txt" />
                        <p class="label-title">精选集说明</p>
                        <textarea class="input-area"></textarea>
                    </div>
                    <div class="singleBtn">
                        <a href="" title="" class="btn-layer-d big">保存完成</a>　<a href="" title="" class="btn-layer-d big icon ret"><i class="l"></i>返回</a>
                    </div>
                </div>
				 -->
                
                <!-- 关于优酷FM -->
				<!--
                <div class="about-box">
                	<img src="img/about-bg.gif" alt="" />
                    <div class="cont">
                        <p>优酷FM 2011-12-15</p>
                        <p>Copyright©2011 优酷 youku.com 版权所有</p>
                        <p>作者：Hetal　　QQ：231073376</p>
                    </div>
                    <div class="singleBtn">
                    	<a href="" title="" class="btn-layer-d">确定</a>
                    </div>
                </div>
				-->
               
                <!-- 帮助中心 -->
				 <!--
                <div class="help-box">
                	<div class="help-cont">
                        <img src="img/help-bg.gif" alt="" />
                        <div class="cont">
                            <h2><i class="icon_ques"></i>什么是“电台模式”？</h2>
                            <p>电台模式，就是以“电台”的方式播放音乐，他们自动的不间断的播放你所选“频道”的音乐。换台，点击“换台”按钮，就可选择你所要播放的频道。播放/跳过，播放就是播放频道，跳过就是换下一首音乐来收听。喜欢/不喜欢，收藏音乐或者加入黑名单，只有登录了才能使用。</p>
                        </div>
                        <div class="cont">
                            <h2><i class="icon_ques"></i>什么是“电台模式”？</h2>
                            <p>电台模式，就是以“电台”的方式播放音乐，他们自动的不间断的播放你所选“频道”的音乐。换台，点击“换台”按钮，就可选择你所要播放的频道。播放/跳过，播放就是播放频道，跳过就是换下一首音乐来收听。喜欢/不喜欢，收藏音乐或者加入黑名单，只有登录了才能使用。</p>
                        </div>
                        <div class="cont">
                            <h2><i class="icon_ques"></i>什么是“电台模式”？</h2>
                            <p>电台模式，就是以“电台”的方式播放音乐，他们自动的不间断的播放你所选“频道”的音乐。换台，点击“换台”按钮，就可选择你所要播放的频道。播放/跳过，播放就是播放频道，跳过就是换下一首音乐来收听。喜欢/不喜欢，收藏音乐或者加入黑名单，只有登录了才能使用。</p>
                        </div>
                        <div class="cont">
                            <h2><i class="icon_ques"></i>什么是“电台模式”？</h2>
                            <p>电台模式，就是以“电台”的方式播放音乐，他们自动的不间断的播放你所选“频道”的音乐。换台，点击“换台”按钮，就可选择你所要播放的频道。播放/跳过，播放就是播放频道，跳过就是换下一首音乐来收听。喜欢/不喜欢，收藏音乐或者加入黑名单，只有登录了才能使用。</p>
                        </div>
                    </div>
                    <div class="singleBtn">
                    	<a href="" title="" class="btn-layer-d">确定</a>
                    </div>
                </div>
				-->
            </div>
            <div class="right"><div class="box"></div></div>
       	</div>
        <div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>
    </div>
</div>


<!-- 拖动歌曲弹出层 默认下拉菜单们关闭层 在drag-layer加入hover样式即可切换为打开状态 -->
<div id="drag-layer" class="mvlist-edit-layer hover">
	<div class="top"><p>添加到歌单<i class="icon-down"></i><i class="icon_add"></i></p></div>
	<i class="icon_del"></i>
	
	<div class="mdrag-layer">
		<a href="" title="">华语流行金曲(23)</a>
		<a href="" title="">华语流行金曲(23)</a>
		<a href="" title="">华语流行金曲(23)</a>
		<a href="" title="" class="hover">华语流行金曲(23)</a>
		<a href="" title="">华语流行金曲(23)</a>
	</div>
</div>

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



//在改变弹出层内容后调用，用来更新弹出层的显示位置，确保在屏幕的正中间偏上位置
var udpateLayerPosition = function() {
	var _ly = document.getElementById('layer');
	var _w = _ly.clientWidth;
	var _h = _ly.clientHeight;
	var _bH = document.documentElement.clientHeight;
	var _top = _bH/2 - _ly.clientHeight/2 > 0 ? (_bH/2 - _ly.clientHeight/2)/3 : _bH/2 - _ly.clientHeight/2;
	_ly.style.marginLeft = "-"+Math.round(_ly.clientWidth/2)+"px";
	_ly.style.marginTop = "-"+Math.round(_ly.clientHeight/2+_top)+"px";
}
udpateLayerPosition();

var updateOverHeight = function() {
	var _w = document.body.clientWidth;
	var _h = document.body.clientHeight;
	var _wv = document.documentElement.clientWidth;
	var _hv = document.documentElement.clientHeight;
	document.getElementById('over').style.width = Math.max(_w,_wv)+"px";
	document.getElementById('over').style.height = Math.max(_h,_hv)+"px";
}
updateOverHeight();
</script>

</body>
</html>

