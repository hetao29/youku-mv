						<ul class="nav">
								<li><a id="_IDUsage">{'使用说明'|tr:'main'}</a></li>
								<li><a id="_IDAbout">{'关于'|tr}</a></li>
{if empty($user)}
								<li><a id="_IDSignup">{'注册'|tr}</a></li>
								<li><a id="_IDLogin">{'登录'|tr}</a></li>
{else}
								<li><a>{"欢迎"|tr} {$user.UserAlias}</a></li>
								<li><a id="_IDLogout">{'退出'|tr}</a></li>
								<li><a>我的歌单</a></li>
								<li><a>听过的歌</a></li>
								<li><a>资料修改</a></li>
{/if}
						</ul>
						<div class="clear"></div>

