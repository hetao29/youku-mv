
			<div class="th-cont">
				<i class="yk-logo"></i>
				<ul id="login_success">
					<li><a id="_IDUsage">{'使用说明'|tr}</a></li>
					<li><a id="_IDAbout">{'关于'|tr}</a></li>
					<li>|</li>
					<li class="language" onmouseover="(function(t){ t.className='language hover' ; })(this)" onmouseout="(function(t){ t.className='language'})(this)">语言选择<i class="icon-down"></i><em class="panel"><a href="">简体中文</a><a href="">English</a><a href="">한국의</a><a href="">日本語</a></em></li>
					<li>|</li>
					<li id="_LiUp"><a>{"喜欢"|tr}(<span id="_CtUp">{@$act[0]|default:0}</span>)</a></li>
					<li id="_LiListen"><a>{"听过"|tr}(<span id="_CtListen">{$_CtListen|default:0}</span>)</a></li>
					<li id="_LiList"><a>{"歌单"|tr}({$_CtList|default:0})</a></li>
					<li>|</li>
					{if empty($user)}
					<li><a id="_IDSignup">{'注册'|tr}</a></li>
					<li><a id="_IDLogin">{'登录'|tr}</a></li>
					<li>|</li>
					<li><a href="" title="">登录</a>后，能记住你所喜好</li>
					{else}
					{if empty($out)}<li><a id="_IDLogout">{'退出'|tr}</a></li>{/if}
					<li class="family"><span class="black">{$user['UserAlias']}</span></li>
					{/if}
				</ul>
			</div>