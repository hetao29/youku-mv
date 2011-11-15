<!DOCTYPE html>
<html>
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="Shortcut Icon" href="/assets/images/ico/favicon_32x32.ico" />
				<title>{'标题'|tr}</title>
{if defined(DEV)}
<script type="text/javascript" src="/assets/js/jquery-1.5.1.js"></script>
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
<script type="text/javascript" src="/assets/js/player.js"></script>
<script type="text/javascript" src="/assets/js/swfobject/swfobject.js"></script>
				<link href="/assets/css/jquery-ui-1.8.6.custom-smoothness.css" media="all" rel="stylesheet" type="text/css" />
				<link href="/assets/css/admin.css" media="all" rel="stylesheet" type="text/css" />
{else}
				<script type="text/javascript" src="{'/player.js'|version:$jsversion}"></script>
				<link href="{'/player.css'|version:$cssversion}" media="all" rel="stylesheet" type="text/css" />
{/if}
		</head>
		<body>
				<h1>电台维护</h1>
				<table border=1 id="_IDLists">
						<tr>
								<td>节目ID</td><td>顺序号(越小越靠前)</td><td>曲目数</td><td>类型</td><td>用户ID</td><td>名字</td><td>&nbsp;</td></tr>
						{foreach $lists->items as $item}
						<tr>
								<td>{$item['ListID']}</td>
								<td>{$item.EditOrder}</td>
								<td>{$item.ListCount}</td>
								<td>{if $item.ListType==0}用户列表{else}<span class="red">电台频道</span>{/if}</td>
								<td>{$item.UserID}</td>
								<td>{$item.ListName}</td>
								<td><a id="{$item.ListID}" class="_Edit">编辑</a></td>
						</tr>
						{/foreach}
				</table>
				<div id="_EditBox" style="display:none">
						<h3>修改</h3>
						<form>
								<ul>
										<li>名称:<span class="name"></span></li>
										<li>类型:<select name="ListType" class="type"><option value=0>用户类型</option><option value=1>电台视频</option></select></li>
										<li>顺序:<input class="order" name="EditOrder" type="text"/></li>
										<li><input type="hidden" class="id" name="ListID" value=""/></li>
								</ul>
								<button value="修改" class="commit">修改</button>
						</form>

				</div>
				<script>
						$(document).ready(function(){
								$("#_IDLists ._Edit").live('click',function(){
										$("button").button();
										var lid = ($(this).attr("id"));
										$.ajax({
												url: "/admin.main.getList."+lid,
												type:"post",
												dataType:"json",
												success: function( List) {
														//var r=$("#_EditBox").tmpl(List);
														//alert($(r).html());
														if(List){
																$("#_EditBox .name").html(List.ListName);
																$("#_EditBox .order").val(List.EditOrder);
																$("#_EditBox .type").val(List.ListType);
																$("#_EditBox .id").val(List.ListID);
																$("#_EditBox .commit").live("click",function(){
																		var r = ($("#_EditBox form").serialize());
																		$.ajax({
																				url: "/admin.main.edit?"+r,
																				//data: {
																						//		ListID:lid
																						//},type:"post",
																				dataType:"json",
																				success: function( r) {
																						if(r){
																								alert("修改成功");
																								window.location = window.location;
																								}else{
																								alert("未做修改");
																						}
																				}

																		});
																		return false;
																});
																$("#_EditBox").dialog({
																		width:400,height:300, buttons: []
																});
														}
												}

										});
								});
						});
				</script>
		</body>
</html>
