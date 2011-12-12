<html>
<head>
<link href="/player.css" media="all" rel="stylesheet" type="text/css" />

<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script> 
function authLoad(){
	App.AuthDialog.show({
		client_id : "{$appkey}",    //必选，appkey
		redirect_uri : "http://apps.weibo.com/youkufm{if !empty($vid)}?vid={$vid}{/if}",
		height: 120    //可选，默认距顶端120px
	});
}
</script>
</head>
<body>
<script>authLoad();</script>
</body>
</html>
