
			<div class="th-cont">
				<i class="yk-logo"></i>
				<ul id="login_success">
					<li><a id="_IDUsage">{'使用说明'|tr}</a></li>
					<li><a id="_IDAbout">{'关于'|tr}</a></li>
					<li>|</li>
					<li id="_IDLanguage" class="language">{'语言'|tr}<i class="icon-down"></i>
						<em class="panel">
							{foreach($allLanguage as $k=>$v)}
							<a data="{$k}">{$v}</a> 
							{/foreach}
						</em>
					</li>
					<li>|</li>
					{if empty($user)}
					<li><a id="_IDSignup">{'注册'|tr}</a></li>
					<li><a id="_IDLogin">{'登录'|tr}</a></li>
					<li>|</li>
					<li>登录后，能记住你所喜好</li>
					{else}
					<li id="_LiUp"><a>{"喜欢"|tr}(<span id="_CtUp">{@$act[0]|default:0}</span>)</a></li>
					<li id="_LiListen"><a>{"听过"|tr}(<span id="_CtListen">{$_CtListen|default:0}</span>)</a></li>
					<li id="_LiList"><a>{"歌单"|tr}({$_CtList|default:0})</a></li>
					<li>|</li>
					{if empty($outx)}<li><a id="_IDLogout">{'退出'|tr}</a></li>{/if}
					<li class="family"><span class="black">{$user['UserAlias']}</span></li>
					{/if}
				</ul>
			</div>