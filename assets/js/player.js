//{{{主方法
var YoukuWs = function(){
	var fullScreen=false;
	var o_lyrics;
	var gc= new Array();
	var lyrics_offset=0;
	//用户ID
	var uid=1;
	var mvid=1;


	var order=[];
	$(document).ready(function(){
			$("#_IDFullscreen").click(function(){
					if(!YoukuWs.fullScreen){
						$("#playerBox").removeClass("playerBox");
						$("#playerBox").addClass("playerBoxFullscreen");
					}else{
						$("#playerBox").removeClass("playerBoxFullscreen");
						$("#playerBox").addClass("playerBox");
					}
					YoukuWs.fullScreen=!YoukuWs.fullScreen;
					
			});
			$(document).mousemove(function(e){
				if($(document).height()-e.pageY<100 && YoukuWs.fullScreen){
					var t = $(document).height()-$("#fullscreen").height();
					$("#fullscreen").css({top:t,width:"100%"});
					$("#fullscreen").show();
				}else{
					$("#fullscreen").hide();
				}
			}); 
			$(window).resize(function(){
				if($(document).height()+24>=screen.height && $(window).width()==screen.width){
					//认为是全屏
					$("#playerBox").removeClass("playerBox");
					$("#playerBox").addClass("playerBoxFullscreen");
					YoukuWs.fullScreen=true;
				}else{
					$("#playerBox").removeClass("playerBoxFullscreen");
					$("#playerBox").addClass("playerBox");
					YoukuWs.fullScreen=false;
				}
				//$('#status').html("resize"+", "+$(window).height()+", "+$(document).height()+", "+screen.height);
				//$('#status').html("resize"+", "+$(window).width()+", "+$(document).width()+", "+screen.width);
			});
			$("#_IDPlay").click(function(){
					//{{{播放模式
					PlayType=0;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					YoukuWs.playRadio();
			}).button({icons:{primary:"ui-icon-play"}});
			$("#_IDSkip").click(function(){
					YoukuWs.MvAction("skip",CurrentMvID);
					//{{{播放模式
					PlayType=0;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					YoukuWs.playRadio();
			}).button({icons:{primary:"ui-icon-seek-next"}});
			$("#_IDChange").click(function(){
				//换台模式
				$.ajax({
					url: "/player.main.radioList",
					dataType:"json",type:"post",
					success: function( result) {
						if(result && result.items){
							$("#_RadioChannel ul").html("");
							for(var i=0;i<result.items.length;i++){
								var cid = YoukuWs.get("cid");
								var dsb ="";
								if(cid==result.items[i].ListID){
									dsb="disabled='disabled'";
								}else{
									dsb="";
								}
								//$("#_RadioChannel ul").append("<li><button "+dsb+" id='"+result.items[i].ListID+"'>播放</button> "+result.items[i].ListName+"("+result.items[i].ListCount+"个视频)</li>");
								$("#_RadioChannel ul").append("<li><button "+dsb+" id='"+result.items[i].ListID+"'>播放</button> "+result.items[i].ListName+"</li>");
							}
							//$("#_RadioChannel button[id="+cid+"]").attr("disabled","disabled");
							//$("#_RadioChannel button[id!="+cid+"]").removeAttr("disabled");
							$("#_RadioChannel").dialog({
								width:400,height:300
							});
							$("#_RadioChannel button").live("click",function(){
								$("#_RadioChannel").dialog("close");
								//alert($(this).attr("id"));
								YoukuWs.set("cid",$(this).attr("id"));
								radioPlayList=[];
								YoukuWs.playRadio();
							});
							$("#_RadioChannel button").button({icons:{primary:"ui-icon-play"}});
						}
					}
				});
			}).button();
			$("#_IDDown").click(function(){
					YoukuWs.MvAction("down",CurrentMvID);
					YoukuWs.playRadio();
			});
			$("#_IDUp").click(function(){
					YoukuWs.MvAction("up",CurrentMvID);
			});
			$("#_LiUp").live('click',function(){
				$("#_ContentListen").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentListen").dialog("close");
						}
					}
					]
				});
				YoukuWs.listAction("up",1);
			});
			$("#_LiSkip").live('click',function(){
				$("#_ContentListen").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentListen").dialog("close");
						}
					}
					]
				});
				YoukuWs.listAction("skip",1);
			});
			$("#_LiDown").live('click',function(){
				$("#_ContentListen").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentListen").dialog("close");
						}
					}
					]
				});
				YoukuWs.listAction("down",1);
			});
			$("#_LiList").live('click',function(){
						$("#_IDList").dialog({
							width:410,height:280,buttons: [],open:function(event,ui){
								YoukuWs.listList();
							}
						});
			});
			$("#_LiListen").live('click',function(){
				$("#_ContentListen").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentListen").dialog("close");
						}
					}
					]
				});
				YoukuWs.listListen(1);
			});
			$("#_ContentMusic >li,#_ContentListen >ul >li,#_ContentSearch >li").live('click',function(){
					//{{{播放模式
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					var vid = $(this).attr('vid');
					YoukuWs.play(vid);
					return false;
			});
			$("#_IDLyricsPr").click(function(){
					lyrics_offset=parseInt(lyrics_offset)+1000;
					$("#_IDLyricsInfo").html("已前进").fadeIn("slow",function(){
								$("#_IDLyricsInfo").fadeOut("slow");	
					});
					YoukuWs.saveOffset();
			});
			$("#_IDLyricsErr").click(function(){
				if(mvid>0 && uid>0){
					$.ajax({
						url: "/player.main.LyricsError",
						data: {
							MvID:mvid
						},
						success: function( result) {
							$("#_IDLyricsInfo").html("已报错").fadeIn("slow",function(){
										$("#_IDLyricsInfo").fadeOut("slow");	
							});
						}

					});
				}
			});
			$("#_IDLyricsView").click(function(){
				var html = "";
				$("#_ContentLyrics >div").each(function(n,item){
					html+=$(item).html()+"<br/>";
				});
				$("#_ContentLyricsView >div").html(html);
				$("#_ContentLyricsView").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentLyricsView").dialog("close");
						}
					}
					]
				});
			});
			$("#_IDLyricsBk").click(function(){
					lyrics_offset=parseInt(lyrics_offset)-1000;
					$("#_IDLyricsInfo").html("已后退").fadeIn("slow",function(){
								$("#_IDLyricsInfo").fadeOut("slow");	
					});
					YoukuWs.saveOffset();
			});
			//加载播放列表
			$("#_IDLogout").live("click",function(){
					$('.header').load("/user.main.logout");
			});
			$("#_IDSignup2").live("click",function(){
				$("#_ContentLogin").dialog("close");
				$("#_IDSignup").trigger("click");
			});
			$("#_IDLogin").live("click",YoukuWs.login);
			$("#_IDLogin2").live("click",YoukuWs.login);
			$("#_IDUsage").live("click",function(){
					$("#_ContentUsage").dialog({
						width:600,height:480, buttons: [
							{
								text:_LabelOk,
								click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
			});
			$("#_IDAbout").live("click",function(){
					$("#_ContentAbout").dialog({
						width:300,height:180, buttons: [
							{
								text:_LabelOk,click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
			});
			$("#_IDSignup").live("click",function(){
					$("#_ContentSignup").dialog({
						width:320,height:260, buttons: [
							{
								text:_LabelOk,click: function() {
									$.post("/user.main.signup",$("#_FormSignup").serialize(),function(data){
										data=data.replace(/<[^>]+>/g,"");
										data=eval("("+data+")");
										if(data.uid){
											//注册成功
											$('.header').load("/player.main.header");
											$("#_ContentSignup").dialog( "close" );
											//登录成功
										}else{
											//登录失败
											$("#_FormSignup .info").html("<b>"+data.info+"</b>").slideDown("fast");
										}
									});
								}
							},{
								text:_LabelCancel,click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
			});
			//可以被放入和被排序
			$( "#_ContentSearch" ).sortable();
			$( "#_Content" ).droppable({
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					tolerance:"pointer",
					accept:"#_ContentSearch >li,#_ContentListen >ul >li",
							drop: function( event, ui ) {
									//这里是从搜索结果拖到当前播放列表
									YoukuWsPlaylist.add(ui.draggable.attr("mvid"),ui.draggable.attr('vid'),ui.draggable.attr("mvname"));
									//TODO 服务保存
									setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							}
			});
			$("#_ContentMusic").sortable({
					stop:function(event,ui){
						setTimeout("YoukuWsPlaylist.save()",200);
					},start:function(event,ui){
					}

			});
			$( "#_ContentList >li .del" ).live("click",function(){
				_this = this;
				$("<div>你确定要删除么?</div>" ).dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"删除": function() {
							_this2=this;
							var lid = $(_this).parents("li").attr("lid");
							$.ajax({
								url: "/user.list.del",
								data: {
									ListID:lid
								},type:"post",
								dataType:"json",
								success: function( List) {
									$('.header').load("/player.main.header");
									if(List){
										YoukuWs.listList();
									}
									$( _this2 ).dialog( "destroy");
								}

							});
						},
						Cancel: function() {
							$( this ).dialog( "destroy");
						}
					}
				});
			});
			$( "#_ContentList >li .empty" ).live("click",function(){
				_this = this;
				$("<div>你确定要清空么?</div>" ).dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"清空": function() {
							_this2=this;
							var lid = $(_this).parents("li").attr("lid");
							$.ajax({
								url: "/user.list.empty",
								data: {
									ListID:lid
								},type:"post",
								dataType:"json",
								success: function( List) {
									if(List){
										YoukuWs.listList();
									}
									$( _this2 ).dialog( "destroy");
								}

							});
						},
						Cancel: function() {
							$( this ).dialog( "destroy");
						}
					}
				});
			});
			$( "#_ContentList >li .load" ).live("click",function(){
				var lid = $(this).parents("li").attr("lid");
				YoukuWs.listContents(lid);
			});
			$("#_ContentListen >ul").sortable({
				stop:function(event,ui){
					var order=[];
					var lid=0;
					$(this).find("li").each(function (index, domEle) { 
						lid = $(domEle).attr("lid");
						if(index!=$(domEle).attr("ord")){
							var o={order:index,mvid:$(domEle).attr("mvid")};
							order.push(o);
						}
					});
					if(order.length==0 || lid==0)return;
					$.ajax({
						url: "/user.list.contentsorder",
						type:"POST",
						data: {
							order:order,lid:lid
						},
						dataType:"json",
						success: function( result) {
							//应该修改当前的ord值
							for(var i in  order){
								$("#_ContentListen >ul >li[mvid="+order[i].mvid+"]").attr("ord",order[i].order);
							}
						}
					});
				}
			});
			$( "#_ContentList >li .edit" ).live("click",function(){
				var lid = $(this).parents("li").attr("lid");
				$("#_ContentListen DIV").html("");
				$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在加载中...</li>');
				$("#_ContentListen").dialog({
					width:400,height:300, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$("#_ContentListen").dialog("close");
						}
					}
					]
				});
				$.ajax({
					url: "/user.list.listContents",
					data:{lid:lid},
					dataType:"json",
					success: function( result) {
						if(result && result.items && result.items.length>0){
							var o = $("#_ContentListen >ul");
							o.html('');
							for(var i=0;i<result.items.length;i++){
								var html='<li type="list" mvname="'+result.items[i].MvName+'" vid="'+result.items[i].MvVideoID+'" lid="'+result.items[i].ListID+'" ord="'+result.items[i].MvOrder+'" mvid="'+result.items[i].MvID+'">'+
								'<span class="left">'+result.items[i].MvName+'</span>'+
								'<span class="right">'+result.items[i].MvSeconds+' <a class="delMv">X</a></span>'+
								'<div class="clear"></div>'+
								'</li>';
								o.append(html);
							}
						}
					}
				});
			});
			$( "#_ContentListen .delMv" ).live("click",function(){
				var type= $(this).parents("li").attr("type");
				var mvid= $(this).parents("li").attr("mvid");
				var _this=this;
				if(type=="list"){
					var lid= $(this).parents("li").attr("lid");
					//删除列表里的歌曲
					$.ajax({
						url: "/user.list.delcontent",
						data: {
							lid:lid,
							mvid:mvid
						},type:"post",
						dataType:"json",
						success: function( result) {
							setTimeout(function() { $(_this).parents("li").remove(); }, 1);//fro ie patch
						}
					});
				}else if(type=="action"){
					var actiontype = $(this).parents("li").attr("actiontype");
					$.ajax({
						url: "/player.main.delAction",
						data: {
							actiontype:actiontype,
							mvid:mvid
						},type:"post",
						dataType:"json",
						success: function( result) {
							$('#_IDHeader').load("/player.main.header");
							setTimeout(function() { $(_this).parents("li").remove(); }, 1);//fro ie patch
						}
					});
				}else if(type=="listen"){
					$.ajax({
						url: "/player.main.delListen",
						data: {
							mvid:mvid
						},type:"post",
						dataType:"json",
						success: function( result) {
							$('#_IDHeader').load("/player.main.header");
							setTimeout(function() { $(_this).parents("li").remove(); }, 1);//fro ie patch
						}
					});
				};
				return false;
			});
			$( "#_ContentList >li .rename" ).live("click",function(){
				var lname = $(this).parents("li").find(".name").html();//attr("lid");
				var lid = $(this).parents("li").attr("lid");
				var html='<div>新的歌单：<input type="text" value="'+lname+'"/></div>';
				$(html).dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"改名": function() {
							_this=this;
							if($("#_IDNewName").val()=="")return;
							$.ajax({
								url: "/user.list.edit",
								data: {
									ListID:lid,
									ListName:$(_this).find("input").val()
								},type:"post",
								dataType:"json",
								success: function( result) {
									if(result){
										YoukuWs.listList();
									}
									$( _this ).dialog( "destroy");
								}

							});
						},
						Cancel: function() {
							$( this ).dialog( "destroy");
						}
					}
				});
			});
			$( "#_ContentList >li" ).live("mouseover",function(){$(this).find(".right").show();
			}).live("mouseout",function(){$(this).find(".right").hide();
			});
			$( "#_ContentList" ).sortable({
						stop:function(event,ui){
							var order=[];
							$(this).find("li").each(function (index, domEle) { 
								if(index!=$(domEle).attr("ord")){
									var o={lid:$(domEle).attr("lid"),order:index};
									order.push(o);
								}
							});
							if(order.length==0)return;
							$.ajax({
								url: "/user.list.order",
								type:"POST",
								data: {
									order:order
								},
								dataType:"json",
								success: function( result) {
									//应该修改当前的ord值
									for(var i in  order){
										$("#_ContentList >li[lid="+order[i].lid+"]").attr("ord",order[i].order);
									}
								}
							});
						}
					});
			$("#_BtPre").click(function(){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.playPre();
			}).button({icons:{primary:"ui-icon-seek-prev"}});;
			$("#_BtNext").click(function(){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.playNext();
			}).button({icons:{primary:"ui-icon-seek-next"}});;
			$("#_BtTrash").button().droppable({
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					accept:"#_ContentMusic >li,#_ContentList >li",
					tolerance:"pointer",
					drop: function( event, ui ) {
							YoukuWsPlaylist.del(ui.draggable.attr("vid"));
							setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
					}
			}).click(function(){
					var li=$("#_ContentMusic >li[class*=current]");
					if(li.html()==null)return;
					YoukuWs.playNext();
					YoukuWsPlaylist.del(li.attr("vid"));
					setTimeout(function() { li.remove(); }, 1);//fro ie patch
			});
			$("#PlayModeSet [name=set]").click(function(){
				PlayMode = $("#PlayModeSet [name=set]:checked").val();
				YoukuWs.set("PlayModeSet",PlayMode);
			});
			if(YoukuWs.get("PlayModeSet")){
					PlayMode = YoukuWs.get("PlayModeSet");
					$("#PlayModeSet [value="+PlayMode+"]").attr("checked",true);//(PlayMode);
			}
			//$("#PlayModeSet" ).buttonset().show();
			$("#_BtPlayModeSet").button("option","disabled",true).show();
			$("button").button().show();

			$("#_BtClearList").button().click(function(){
				$("#_ContentClearList").dialog({
					modal: true, width:320,height:200, buttons: [
						{
							text:_LabelOk,
							click: function() {
								YoukuWsPlaylist.empty();
								$("#_ContentMusic").html("");
								$( this ).dialog( "close" );
							}
						},
						{
							text:_LabelCancel,
							click: function() {
								$( this ).dialog( "close" );
							}
						}
					]
				});
			});
			//{{{
			PlayType = YoukuWs.get("PlayType",0);
			$("#_IDRight >.list").each(function(i,item){
					if(i==PlayType){
						$("#_IDNav >li").eq(i).css("background-color","").show();
						$(item).show();
					}else{
						$("#_IDNav >li").eq(i).css("background-color","#ddd").show();
				   		$(item).hide();
					}
			});
			$("#_IDNav >li").click(function(){
					var _this = this;
					$("#_IDNav >li").each(function(i,item){
								//{{{ save scrollTop
								window._ContentMusicTop=window._ContentMusicTop?window._ContentMusicTop:0;
								if($("#_ContentMusic").scrollTop()>0){
									window._ContentMusicTop = $("#_ContentMusic").scrollTop();
								}
								//}}}
								$(item).css("background-color","#ddd");
								$("#_IDRight >.list").eq(i).hide();
					});
					$("#_IDNav >li").each(function(i,item){
							if($(_this).html()==$(item).html()){
								$(item).css("background-color","");
								$("#_IDRight >.list").eq(i).show();

								//{{{ restore scrollTop
								if(i==1 && window._ContentMusicTop>0){
									$("#_ContentMusic").scrollTop(window._ContentMusicTop);
								}
								//}}}
							}
					});
				});
			//}}}
			$("#_BtAddList").button();
			$("#_BtAddMv").button().click(function(){
				$( "#_DialogAdd" ).dialog({
					width:500,height:320, buttons: {
							"增加": function() {
								var k =($("#_DialogAdd textarea").val());
								$.ajax({type:"POST",dataType:"json",url:"/player.main.getVideo",data:{"k":k},success:function(msg){
											YoukuWsPlaylist.addArray(msg);
											$("#_DialogAdding").hide();
											$("#_DialogAdd").dialog( "close" );
										},beforeSend:function(xhr){
											$("#_DialogAdding").show();
										}
								});
							},
							"取消": function() {
								$( this ).dialog( "close" );
							}
					},
					close:function(event,ui){
						//alert("CLOSE");
					}
				});
			}).show();
			$("#_AListAdd").click(function(){
				$("#_CtListAdd").toggle("fast");
			});
			$("#_IDListAdd").click(function(){
				if($("#_IDListName").val()=="")return;
				$.ajax({
					url: "/user.list.add",
					data: {
						ListName:$("#_IDListName").val()
					},
					dataType:"json",
					success: function( List) {
						if(List){
							$('#_IDHeader').load("/player.main.header");
							YoukuWs.listList();
						}
					}

				});
			});
			$("#_BtSaveList").button().click(function(){
					if(YoukuWs.isLogin()){
						$("#_IDList").dialog({
							width:410,height:280,buttons: [
								{
									text:_LabelOk,
									click: function() {
										_this2=this;
										var lids=[];
									   	$("#_ContentList input:checked").each(function(i,n){
												lids.push($(n).val());
										});
										if(lids.length>0){
											var mvids=[];
									   		$("#_ContentMusic >li").each(function(i,n){
													mvids.push($(n).attr("mvid"));
											});
											$("#_IDListDialogAdding").show();
											$.ajax({
												url: "/user.list.addContents",
												data: {
													lids:lids,
													mvids:mvids
												},type:"post",
												dataType:"json",
												success: function( List) {
													$("#_IDListDialogAdding").hide();
													if(List){
														YoukuWs.listList();
													}
													$( _this2 ).dialog( "destroy");
													alert("保存成功");
												}

											});
											
											
										}else{
											alert("请选择你要保存的歌单");
										}
									}
								},
								{
									text:_LabelCancel,
									click: function() {
										$( this ).dialog( "close" );
									}
								}
							],open:function(event,ui){
								YoukuWs.listList();
							}
						});
					}else{
						YoukuWs.login(function(){$("#_BtSaveList").trigger("click");});
					}
			}).show();
			$("#_BtOpenList").button().click(function(){
					if(YoukuWs.isLogin()){
						//显示列表
						$("#_ContentList").dialog({
							width:300,height:250
						});
					}else{
						YoukuWs.login(function(){$("#_BtOpenList").trigger("click");});
					}
			}).show();

			var objURL={};
			window.location.search.replace(
				new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
				objURL[ $1 ] = $3;
				}
			);
			if(objURL.lid){
				PlayType=1;
				YoukuWs.set("PlayType",PlayType);
				YoukuWs.listContents(objURL.lid);
			};
			YoukuWs.autoLogin();
			$.each(YoukuWsPlaylist.list(),function(i,n){
					var o = '<li mvid="'+n.m+'" vid="'+n.v+'"><a>'+n.t+'</a></li>';
					$("#_ContentMusic").append(o);
			});
			$(window).bind("beforeunload",function(){
				var r= PlayerInfo();
				if(r){
					var time = isNaN(r.time)?0:r.time;
					if(time>0){
						YoukuWs.set("time",time);
					}
				}
			});
			setInterval(YoukuWs.checkTime,500);
			setInterval(YoukuWs.adReload,1000*60*10);// 10分钟一次
			CurrentMvID = YoukuWs.get("CurrentMvID");
			if(PlayType==0){
				YoukuWs.playRadio();
			}else{
				if(YoukuWs.get("vid")){
					var time = YoukuWs.get("time",0);
					YoukuWs.play(YoukuWs.get("vid"),time);
				}else{
					vid = $("#_ContentMusic >li").first().attr("vid");
					YoukuWs.play(vid);
				};
			}
	});
	var pre_index=0;
	function showLyric(str){
			var o = $("#_ContentLyrics");
			o.html('');
			gc= new Array();
			parseLyric(str);
			if(!gc ||gc.length==0)return;
			for (var k=0;k<gc.length;k++)
			{
					if(gc[k].w==""){
							gc[k].w="&nbsp;";
					}
					var c = '<div time="'+gc[k].t+'" id="_ID'+k+'">'+gc[k].w+'</div>';
					o.append(c);
			}
	}
	
	function parseLyric(str)
	{
			if(!str || str=="")return;
			ti=/\[ti:(.+)\]/i.test(str)?"标题："+RegExp.$1:"";
			ar=/\[ar:(.+)\]/i.test(str)?"歌手："+RegExp.$1:"";
			al=/\[al:(.+)\]/i.test(str)?"专辑："+RegExp.$1:"";
			by=/\[by:(.+)\]/i.test(str)?"制作："+RegExp.$1:"";
			otime=parseInt(/\[offset:(.+)\]/i.test(str)?RegExp.$1:0);
	
			str=str.replace(/[^\]]\[/g,"\n[");
			matches = str.match(/\n\[\d+:.+\][^\[\r\n]*/ig);
			if(!matches)return;
			rr=matches.length;
			for (var i=0;i<rr;i++)
			{
					var gctimes=/\[(.+)\].*/.exec(matches[i])[1].split("][");
					var gcword=/.+\](.*)/.exec(matches[i])[1];
					for (var j in gctimes)
					{ 
							gc.push({t:(parseInt(gctimes[j].split(":")[0])*60+parseFloat(gctimes[j].split(":")[1]))*1000 ,w:gcword});
					}
			}
			$.grep( gc, function(n,i){
					return n.w!="" && n.w!=undefined;
			});
			gc.sort(function (a,b){return a.t-b.t;});
	}
	/*可以优化为2分算法*/
	function getLyric(t){
			if(!gc || gc.length==0)return;
			for (var k=0;k<gc.length;k++){
					if(t>=gc[k].t){
							if(gc[k+1] && t<=gc[k+1].t){
								var gc_tmp = gc[k];
								gc_tmp.i=k;
								return(gc_tmp);
							}
							if(!gc[k+1]){
								var gc_tmp = gc[k];
								gc_tmp.i=k;
								return(gc_tmp);
							}
					}
			}
	};
	
	return {
		version:"1.1",
		/*播放视频*/
		play:function(vid,time){
			if(!time)time=0;
			mvid = 0;
			showLyric("");
			vid = vid?vid:"XMjI4MTczMDIw";
			pre=PlayType==0?0:1;
			if(PlayType==0){
					$("#_IDSkip").show();
					$("#_IDPlay").hide();
			}else{
					$("#_IDSkip").hide();
					$("#_IDPlay").show();
			}
			next=1;
			CurrentVideoID=vid;
			YoukuWs.set("vid",CurrentVideoID);
			//下载歌词
			$.ajax({
				url: "/player.main.getLyric",
				data: {
					vid:vid
				},
				dataType:"json",
				success: function( result) {
					if(result){
				   		if(result.LyricsContent && result.LyricsContent!=""){
							showLyric(result.LyricsContent);
							lyrics_offset = parseInt(result.LyricsOffset);
							mvid = result.MvID;
							$("#_IDLyricsAdmin").fadeIn("slow");
						}else{
							//显示没有歌词
							$("#_IDLyricsAdmin").fadeOut("slow");
						}
						//如果这歌词是这个用户的，可以编辑
						if(result.UserID==YoukuWs.uid)
						{
							$("#_IDLyricsEd").fadeIn("slow");
						}else{
							$("#_IDLyricsEd").fadeOut("slow");
						}
					}
				}
			});
			swfobject.embedSWF("http://static.youku.com/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",
				{isAutoPlay:true,VideoIDS:vid,winType:"index","show_pre":pre,"show_next":next,firsttime:time},
				{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"},{},function(){
					if(PlayType!=0){//非收听模式
					//{{{
						var t = 0;
						var o = $("#_ContentMusic [vid="+vid+"]");
						if(!o || !o.position())return;
						t = o.position().top+o.outerHeight()-o.parent().height();
						if(t>0){
							t = o.parent().scrollTop() + o.position().top+o.height()-o.parent().height(); //432
							o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
							});
						}else if( t<0-(o.parent().height()-o.outerHeight())){
							t = (o.parent().scrollTop()+o.position().top);
							o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
							});
						}
					//}}}
						$("#_ContentMusic >li").removeClass("current");
						o.addClass('current');
						YoukuWs.setTitle($("#_ContentMusic [vid="+vid+"] A").html());
					}
			});
		},
		checkTime:function(){
			if(!o_lyrics){
					o_lyrics = $('#_ContentLyrics');
			}
			var LyricTop = $("#_LyricsTop");
			var r= PlayerInfo();
			if(!r){
				LyricTop.hide();
				return;
			}
			var time = isNaN(r.time)?0:r.time;
			var l = getLyric(time*1000+parseInt(lyrics_offset));
			if(!l){
				LyricTop.hide();
				return;
			}
			var id = "_ID"+l.i;
			var index = l.i;
			if(pre_index  == index)return;else{
				pre_index=index;
			}
			//向上移动
			var LyricCurrent = $("#"+id);
			//var t = l.top - 100;
			var t = LyricCurrent.position().top + $("#_ContentLyrics").scrollTop()- 120;
			LyricTop.show();
			$("#_ContentLyrics .red").removeClass("red");
			o_lyrics.animate({scrollTop:t+"px"},"fast","linear",function(){
					if(LyricCurrent.html().replace("&nbsp",'')!=""){
							var t2 = LyricCurrent.position().top;
							LyricTop.animate({"top":t2+"px"},"fast");
							LyricTop.animate({
									"height":LyricCurrent.height()+"px"
							},"fast");
							LyricCurrent.addClass("red");
					}
			});
	
		},
		_realPlayRadio:function(){
			var o= radioPlayList.shift();
			$("#_IDRadio3").hide();
			$("#_IDRadio2").show();
			if(o){
				//队列里有数据
				CurrentMvID = o.MvID;
				$("#_IDVideoTitle").html(o.MvName);
				$("#_IDVideoPic").attr("src",o.MvPic);
				YoukuWs.set("CurrentMvID",CurrentMvID);
				YoukuWs.play(o.MvVideoID);
				YoukuWs.setTitle(o.MvName);
			}
			if(radioPlayList[0]){
					$("#_IDNextVideoTitle").html(radioPlayList[0].MvName);
					$("#_IDNextVideoPic").attr("src",radioPlayList[0].MvPic);
			}
	  	},
		playRadio:function(){
			//获取当前队列的数据，如果为空就从服务器取
				if(radioPlayList.length<2){
					$.ajax({
						url: "/player.main.radio",
						data: {
							cid:YoukuWs.get("cid"),
							mvid:CurrentMvID
						},
						dataType:"json",
						success: function( result) {
							if(result && result.items){
								YoukuWs.set("cid",result.cid);
								radioPlayList=radioPlayList.concat(result.items);
								YoukuWs._realPlayRadio();
							}
						}
					});
				}else{
								YoukuWs._realPlayRadio();
				}
		},
		playRandom:function(pre){
			if(randMusicList.length!=$('#_ContentMusic li').size()){
				randMusicList=[];
				$('#_ContentMusic li').each(function(i,n){
						randMusicList.push($(n).attr("vid"));
				});
				randMusicList.sort(function(){return (Math.round(Math.random())-0.5);});
			}
			vid ="";
			if(randMusicList.length>0){
					if(pre){
						for(var i=0;i<randMusicList.length;i++){
								if(randMusicList[i]==CurrentVideoID){
										if(randMusicList[i-1]){
												vid = randMusicList[i-1];
										}else{
												vid = randMusicList[randMusicList.length-1];
										}
										break;
								}
						}
					}else{
						for(var i=0;i<randMusicList.length;i++){
								if(randMusicList[i]==CurrentVideoID){
										if(randMusicList[i+1]){
												vid = randMusicList[i+1];
										}else{
												vid = randMusicList[0];
										}
										break;
								}
						}
					}
			}
			if(!vid){
				vid = $("#_ContentMusic li").first().attr("vid");
				randMusicList=[];
			}
			if(vid)YoukuWs.play(vid);
		},
		/*播放下一个*/
		playNext:function(){
			if(parseInt(PlayMode)==3)return YoukuWs.playRandom();
			vid = CurrentVideoID;
			vid = $("#_ContentMusic [vid="+vid+"]").next().attr("vid");
			if(!vid){
				vid = $("#_ContentMusic li").first().attr("vid");
			}
			if(vid)YoukuWs.play(vid);
		},
		/*播放上一个*/
		playPre:function(){
			if(parseInt(PlayMode)==3)return YoukuWs.playRandom(true);
			 vid = CurrentVideoID;
			 vid = $("#_ContentMusic [vid="+vid+"]").prev().attr("vid");
			 if(!vid){
			 vid = $("#_ContentMusic li").last().attr("vid");
			 }
			if(vid)YoukuWs.play(vid);
		},
		setTitle:function(t){
			 var t = t.replace(/<[^>]+>/g,"");
			 if(t)document.title=t;
		},
		MvAction:function(type,mvid){
			$.ajax({
				url: "/player.main.mvaction/"+type+"."+mvid,
				dataType:"json",
				success: function( result) {
					if(result&&result.type){
						if(YoukuWs.isLogin()){
							if(result.result && result.record){
							switch(result.type){
								case "down":$("#_CtDown").html(parseInt($("#_CtDown").html())+1);
								break;
								case "up":$("#_CtUp").html(parseInt($("#_CtUp").html())+1);
								break;
								case "skip":$("#_CtSkip").html(parseInt($("#_CtSkip").html())+1);
								break;
							}
							}
						}
					}
				}

			});
	 	},
		get:function(k,defaultValue){
			//TODO userData for IE
			if('localStorage' in window && window['localStorage'] !== null){
				if(localStorage[k])return localStorage[k];
			}
			if($.cookie(k))return $.cookie(k);
			return defaultValue;
		},
		set:function(k,v){
			//TODO userData for IE
			if('localStorage' in window && window['localStorage'] !== null){
				localStorage[k] = v;
				return;
			}
			$.cookie(k,v,{expires:40});
		},
		adReload:function(){
			if($.browser.mozilla){
					return;
			}
			$(".googlead").each(function(index,dom){
				var a = $(dom).clone();
				$(dom).html('');
				$(dom).html(a.html());
			});

		},saveOffset:function(){
			if(mvid>0 && uid>0){
				$.ajax({
					url: "/player.main.saveoffset",
					data: {
						MvID:mvid,
						offset:lyrics_offset
					},
					success: function( result) {
					}

				});
			}
		},isLogin:function(){
				return YoukuWs.get("uid");
		},login:function(callback){
			$("#_ContentLogin").dialog({
				width:320,height:240, buttons: [
					{
						text:_LabelOk,
						click: function() {
							$.post("/user.main.login",$("#_FormLogin").serialize(),function(data){
									data=data.replace(/<[^>]+>/g,"");
									data=eval("("+data+")");
									if(data && data.result==1){
										$('.header').load("/player.main.header");
										$("#_ContentLogin").dialog( "close" );
										if(callback && typeof(callback)=="function")callback();
										//登录成功
									}else{
										//登录失败
										$("#_FormLogin .info").html("<b>登录失败，用户名或者密码错</b>").slideDown("fast");
									}
								});
						}
					},
					{
						text:_LabelCancel,
						click: function() {
							$( this ).dialog( "close" );
						}
					}
				]
			});
		},autoLogin:function(){
			if(this.get("token") && this.get("uid")){
				$.post("/user.main.autologin","token="+this.get("token")+"&uid="+this.get("uid"),function(data){
					if(data){
						$('#_IDHeader').load("/player.main.header");
						//登录成功
					}
				},"json");
			}
		},
		listListen:function(page){
				$("#_ContentListen DIV").html("");
				$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在加载中...</li>');
				$.ajax({
					url: "/player.main.listListen."+page,
					dataType:"json",
					success: function( result) {
						var o = $("#_ContentListen >ul");
						o.html('');
						for(var i=0;i<result.items.length;i++){
							var html='<li type="listen" mvname="'+result.items[i].MvName+'" vid="'+result.items[i].MvVideoID+'" mvid="'+result.items[i].MvID+'">'+
							'<span class="left">'+result.items[i].MvName+'</span>'+
							'<span class="right">'+result.items[i].MvSeconds+' <a class="delMv">X</a></span>'+
							'<div class="clear"></div>'+
							'</li>';
							o.append(html);
						}
						var pager="<div>";
						if(parseInt(result.page)-2>0)pager+="<a onclick='YoukuWs.listListen("+(parseInt(result.page)-2)+")'>"+(parseInt(result.page)-2)+"</a>";
						if(parseInt(result.page)-1>0)pager+="<a onclick='YoukuWs.listListen("+(parseInt(result.page)-1)+")'>"+(parseInt(result.page)-1)+"</a>";
						pager+="<b>"+result.page+"</b>";
						if(parseInt(result.page)+1<=result.totalPage)pager+="<a onclick='YoukuWs.listListen("+(parseInt(result.page)+1)+")'>"+(parseInt(result.page)+1)+"</a>";
						if(parseInt(result.page)+2<=result.totalPage)pager+="<a onclick='YoukuWs.listListen("+(parseInt(result.page)+2)+")'>"+(parseInt(result.page)+2)+"</a>";
						pager+="</div>";
						o.append(pager);
					}

				});
		},
		listAction:function(action,page){
				$("#_ContentListen DIV").html("");
				$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在加载中...</li>');
				$.ajax({
					url: "/player.main.listAction."+action+"."+page,
					dataType:"json",
					success: function( result) {
						var o = $("#_ContentListen >ul");
						o.html("");
						for(var i=0;i<result.items.length;i++){
							var html='<li type="action" actiontype="'+result.items[i].ActionType+'" mvname="'+result.items[i].MvName+'" vid="'+result.items[i].MvVideoID+'" mvid="'+result.items[i].MvID+'">'+
							'<span class="left">'+result.items[i].MvName+'</span>'+
							'<span class="right">'+result.items[i].MvSeconds+' <a class="delMv">X</a></span>'+
							'<div class="clear"></div>'+
							'</li>';
							o.append(html);
						}
						var pager="<div>";
						if(parseInt(result.page)-2>0)pager+="<a onclick='YoukuWs.listAction(\""+action+"\","+(parseInt(result.page)-2)+")'>"+(parseInt(result.page)-2)+"</a>";
						if(parseInt(result.page)-1>0)pager+="<a onclick='YoukuWs.listAction(\""+action+"\","+(parseInt(result.page)-1)+")'>"+(parseInt(result.page)-1)+"</a>";
						pager+="<b>"+result.page+"</b>";
						if(parseInt(result.page)+1<=result.totalPage)pager+="<a onclick='YoukuWs.listAction(\""+action+"\","+(parseInt(result.page)+1)+")'>"+(parseInt(result.page)+1)+"</a>";
						if(parseInt(result.page)+2<=result.totalPage)pager+="<a onclick='YoukuWs.listAction(\""+action+"\","+(parseInt(result.page)+2)+")'>"+(parseInt(result.page)+2)+"</a>";
						pager+="</div>";
						$("#_ContentListen").append(pager);
					}

				});
		},listList:function(){
				$("#_ContentList").html("");
				$.ajax({
					url: "/user.list.list",
					dataType:"json",
					success: function( result) {
						if(result && result.items && result.items.length>0){
							var o = $("#_ContentList");
							for(var i=0;i<result.items.length;i++){
								var r='<li ord="'+result.items[i].ListOrder+'" lid="'+result.items[i].ListID+'"><div class="left"><input value="'+result.items[i].ListID+'" style="vertical-align:top" type="checkbox"/><span class="name">'+result.items[i].ListName+'</span> ('+result.items[i].ListCount+'首)</div><div class="right hide">';
								if(result.items[i].ListCount>0)r+='<span class="edit">歌曲整理</span> ';
								r+='<span class="load">加载</span> <span class="empty">清空</span> <span class="del">删除</span> <span class="rename">改名</span></div><div class="clear"></div></li>';
								o.append(r);
							}
							$( "#_ContentList >li" ).droppable({
									accept:"#_ContentMusic >li,#_ContentSearch >li",
									activeClass: "ui-state-highlight",
									hoverClass: "ui-state-error",
									tolerance:"pointer",
									drop: function( event, ui ) {
											//setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
											//TODO移动到另一个列表
											var lid=$(this).attr("lid");
											if(!lid)return;
											$.ajax({
												url: "/user.list.addContents",
												data: {
													lids:lid,
													mvids:$(ui.draggable).attr("mvid")
												},type:"post",
												dataType:"json",
												success: function( List) {
													$("#_IDListDialogAdding").hide();
													if(List){
														YoukuWs.listList();
														alert("保存成功");
													}else{
														alert("已经成功添加");
													}
												}

											});
									}
							});
							$("#_CtListAdd").hide("fast");
						}else{
							$("#_CtListAdd").show("fast");
						}

					}

				});
		},listContents:function(lid){
				$.ajax({
					url: "/user.list.listContents",
					data:{lid:lid},
					dataType:"json",
					success: function( result) {
						if(result && result.items && result.items.length>0){
							YoukuWsPlaylist.addArray(result.items);
						}

					}

				});
		}
	}
}();
var YoukuWsPlaylist = function(){
		var o={};
		o.addArray=function(arr,noappend){
				var all = $.parseJSON(YoukuWs.get("list"))||[];
				var content   = $("#_ContentMusic");
				var isappend=false;
				for(var i=0;i<arr.length;i++){
					var m = {};
					m.v = arr[i].MvVideoID;
					m.m = arr[i].MvID;
					m.t = arr[i].MvName;
					finded = false;
					$.each(all,function(i,item){
							if(item.v == m.v){
									finded = true;
									return;
							}
					});
					if(!finded){
						all.push(m);
					};
					if(!noappend && !finded){
						var html = '<li mvid="'+m.m+'" vid="'+m.v+'"><a>'+m.t+'</a></li>';
						content.append(html);
						isappend=true;
					}
				};
				if(isappend){
					var t = 0;
					var o = $("#_ContentMusic [vid="+m.v+"]");
					if(!o || !o.position())return;
					t = o.position().top+o.outerHeight()-o.parent().height();
					if(t>0){
						t = o.parent().scrollTop() + o.position().top+o.height()-o.parent().height();
						o.parent().scrollTop(t);
					}else if( t<0-(o.parent().height()-o.outerHeight())){
						t = (o.parent().scrollTop()+o.position().top);
						o.parent().scrollTop(t);
					}
				}
				YoukuWs.set("list",JSON.stringify(all));
		};
		o.add=function(mvid,vid,title){
				YoukuWsPlaylist.addArray([{MvVideoID:vid,MvID:mvid,MvName:title}]);
		};
		o.list=function(){
				return $.parseJSON(YoukuWs.get("list"))||[];
		};
		o.save=function(){
			this.empty();
			var all = [];
			$("#_ContentMusic >li").each(function(i,n){
				var o=$(n);
				var m = {};
				m.MvVideoID= o.attr("vid");
				m.MvID= o.attr("mvid");
				m.MvName= o.find("a").html();
				all.push(m);
			});
			YoukuWsPlaylist.addArray(all,true);
		};
		o.empty=function(){
				YoukuWs.set("list",JSON.stringify([]));
		};
		o.del=function(vid){
				var all = $.parseJSON(YoukuWs.get("list"))||[];
				for(var i=0;i<all.length;i++){
						if(all[i].v == vid){
							all.splice(i,1);
						}
				};
				YoukuWs.set("list",JSON.stringify(all));
		};
		return o;
}();
//}}}
//{{{播放器回调

var playerId="player";
/**
  * 播放模式
  * 0 播放完当前停止
  * 1 单曲
  * 2 顺序播放
  * 3 随机播放
  */
var PlayMode=2;
/**
  * 播放类型
  * 0 电台
  * 1 列表播放
  */
var randMusicList=[];
var randMusicListIndex=0;
var PlayType=0;
//当前播放视频ID，主要是播放模式用
var CurrentVideoID="";
//当前听歌的MvID，主要是收音模式用
var CurrentMvID=0;
var radioPlayList=[];
function onPlayerStart(obj){
		if(YoukuWs.isLogin()){
				$.ajax({type:"POST",dataType:"json",url:"/player.main.addListen",data:{"vid":obj.vidEncoded},success:function(msg){
							if(msg){
								$("#_CtListen").html(parseInt($("#_CtListen").html())+1);
							}
						}
				});
		}
		//PlayerColor("000000","4F4F4F",25);
}
function onPlayerError(vid){
		if(PlayType!=0){
		var h = $("#_ContentMusic [vid="+vid+"] A[error!=1]");
			h.attr("error",1);
			h.html("<font color='red'>播放失败:</font> "+h.html());
			YoukuWs.playNext();
		}else{
			YoukuWs.playRadio();
		}
		//PlayerColor("000000","4F4F4F",25);
}
function onPlayerComplete(obj){
		if(PlayType==0){
			YoukuWs.playRadio();
			return;
		}
		switch(parseInt(PlayMode)){
				case 1:
						YoukuWs.play(CurrentVideoID);
				break;

				case 2:
						YoukuWs.playNext();
				break;

				case 3:
						YoukuWs.playRandom();
				break;
				default:
		}
}
function _player(moviename) {
		if (navigator.appName.indexOf("Microsoft") != -1)return window[moviename?moviename:playerId];
		return document[moviename?moviename:playerId];
};
function PlayerColor(bgcolor,gracolor,trans){
		return _player().setSkinColor(bgcolor,gracolor,trans);
};
function PlayerPause(flag){
	    return _player().pauseVideo(flag);
};
function PlayerInfo(){
		try{
			return _player().getNsData();
		}catch(e){
		}
};
function PlayerSeek(s){
		s = isNaN(parseInt(s))?0:parseInt(s);
		_player().nsseek(parseInt(s));
};
function PlayerPlayPre(obj){
		YoukuWs.playPre();
}
function PlayerPlayNext(obj){
		if(PlayType==0){
			YoukuWs.playRadio();
		}else{
			YoukuWs.playNext();
		}
}
//}}}
//{{{
function search(page){
	page = page?page:1;
	$("#keywords").autocomplete("close");
	YoukuWs.set("keywords",$("#keywords").val());
	var key = $("#keywords").val();
	if(key=="")return;
	var o =$("#_ContentSearch");
	o.html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在查找中...</li>');
	o.dialog({
				width:410,height:250
				});
	$.ajax({
		url: "/player.main.search",
		data: {
			k:$("#keywords").val()
		},dataType:"json",
		beforeSend:function(xhr){
		},select:function(event,ui){
		},success: function( data) {
			$("#keywords").autocomplete("close");
			var o =$("#_ContentSearch");
			o.html('');
			if(!data || data.length==0){
				o.html('<li>没有找到,请换下搜索条件试试</li>');
			}else{
				for(var i=0;i<data.length;i++){
					var html = '<li mvname="'+data[i].MvName+'" title="点击播放:'+data[i].MvName+'" mvid="'+data[i].MvID+'" vid="'+data[i].MvVideoID+
							'"><a><span class="left"><span class="handle ui-icon ui-icon-arrow-4"></span></span>'+
							'<span class="left">'+ data[i].MvName+'</span>'+
							'<span class="right">'+data[i].MvSeconds+'</span>'+
							'<div class="clear"></div></a></li>';
					o.append(html);
				}
			};
		}

	});
}
$("#keywords").ready(function(){
	$("#keywords").change(function(){
		YoukuWs.set("keywords",$("#keywords").val());
	});
	var keywords = YoukuWs.get("keywords");
	if(keywords){
		$("#keywords").val(keywords);
	};
	$("#keywords").autocomplete({
		minLength:1,
		source: function( request, response ) {
			$.ajax({
				url: "/player.main.complete",
				data: {
					k:$("#keywords").val()
				},
				beforeSend:function(xhr){
				},select:function(event,ui){
				},success: function( result) {
						result=result.replace(/<[^>]+>/g,"");
						result=eval("("+result+")");
					var r = result;
					response( $.map( r.result, function( item ) {
							return {
								label: item.keyword,
								value: item.keyword
							};
					}));
				}

			});
		}
	});
});
//}}}
