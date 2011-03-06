<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<title>{'标题'|tr}</title>
				{if defined($smarty.const.DEV)}
				<script type="text/javascript" src="/assets/js/jquery-1.4.4.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery-ui-1.8.7.custom.min.js"></script>
				<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
				<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<script type="text/javascript" src="/assets/js/json2.js"></script>
				<script type="text/javascript" src="/assets/js/player.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
				<link href="/assets/css/styleV2.css" media="all" rel="stylesheet" type="text/css" />
				{else}
				<script type="text/javascript" src="/player.js"></script>
				<link href="/player.css" media="all" rel="stylesheet" type="text/css" />
				{/if}
				<script type="text/javascript">
						var _LabelOk="{'确认'|tr}";
						var _LabelCancel="{'取消'|tr}";
				</script>
		</head>
		<body>
				{if !empty($error)}
				{if $error==1}
				你没有登录，请登录
				<a onclick="YoukuWs.login(function(){ window.location=window.location; });">{'登录'|tr}</a>
				{else if $error==2}
				你没有权限访问
				{/if}
				{/if}

				<div id="_ContentLogin" title="{'登录'|tr}" style="display:none">
						<form id="_FormLogin" style="padding:10px;margin:auto;">
								<table width="100%">
										<tr><td class="info" colspan="2">&nbsp;</td></tr>
										<tr><td>{'邮箱'|tr}:</td><td><input name="useremail"/></td></tr>
										<tr><td>{'密码'|tr}:</td><td><input type="password" name="password"/></td></tr>
										<tr>
												<td></td>
												<td><input type="checkbox" id="forever" name="forever"/><label for="forever">{"记住登录"|tr}</label>
												</td>
										</tr>
								</table>
						</form>
				</div>
		</body>
</html>
