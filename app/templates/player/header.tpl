						<ul class="nav">
{if empty($user)}
								<li><a id="_IDLogin">{'登录'|tr}</a></li>
								<li><a id="_IDSignup">{'注册'|tr}</a></li>
{else}
								<li><a id="_IDLogin">{"欢迎"|tr} {$user.UserName}</a></li>
								<li><a id="_IDLogout">{'退出'|tr}</a></li>
{/if}
								<li><a id="_IDAbout">{'关于'|tr}</a></li>
								<li><a id="_IDUsage">{'使用说明'|tr:'main'}</a></li>
						</ul>
						<div class="clear"></div>

