<ul class="nav">
	<!--<li><a id="_IDUsage">{'使用说明'|tr:'main'}</a></li>-->
	<li><a id="_IDAbout">{'关于'|tr}</a></li>
	{if empty($user)}
	<li><a id="_IDSignup">{'注册'|tr}</a></li>
	<li><a id="_IDLogin">{'登录'|tr}</a></li>
	<li>登录后，能记住你所喜好</li>
	{else}
	<li><a id="_IDLogout">{'退出'|tr}</a></li>
	<li><a>{"欢迎"|tr} {$user.UserAlias}</a></li>
	<li id="_LiList"><a>歌单({$_CtList})</a></li>
	<li id="_LiListen"><a>听过(<span id="_CtListen">{$_CtListen}</span>)</a></li>
	<li id="_LiUp"><a>顶(<span id="_CtUp">{$act[0]|default:0}</span>)</a></li>
	<li id="_LiDown"><a>删(<span id="_CtDown">{$act[1]|default:0}</span>)</a></li>
	<li id="_LiSkip"><a>跳过(<span id="_CtSkip">{$act[2]|default:0}</span>)</a></li>
	{/if}
</ul>
<div class="clear"></div>

