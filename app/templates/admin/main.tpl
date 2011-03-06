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
		</head>
		<body>
				<h1>电台维护</h1>
				<table border=1>
						<tr>
								<td>顺序号</td><td>曲目</td><td>类型</td><td>用户ID</td><td>名字</td></tr>
						{foreach item=item from=$lists->items}
						<tr>
								<td>{$item.ListOrder}</td>
								<td>{$item.ListCount}</td>
								<td>{if $item.ListType==0}用户列表{else}<span class="red">电台频道</span>{/if}</td>
								<td>{$item.UserID}</td>
								<td>{$item.ListName}</td>
						</tr>
						{/foreach}
				</table>
		</body>
</html>
