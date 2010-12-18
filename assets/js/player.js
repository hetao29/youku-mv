//{{{主方法
var YoukuWs = function(){
	var o_lyrics;
	var gc= new Array();
	var lyrics_offset=0;
	//用户ID
	var uid=1;
	var mvid=1;

	var order=[];
	$(document).ready(function(){
			$("#_ContentMusic >li,#_ContentSearch >li").live('click',function(){
					var vid = $(this).attr('vid');
					YoukuWs.play(vid);
					return false;
			});
			$.each(YoukuWsPlaylist.list(),function(i,n){
					var o = '<li vid="'+n.v+'"><a>'+n.t+'</a></li>';
					$("#_ContentMusic").append(o);
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
			$("#_IDLogin").live("click",function(){
					$("#_FormLogin .info").html("").hide();;
					$("#_ContentLogin").dialog({
						width:300,height:200, buttons: [
							{
								text:_LabelOk,
								click: function() {
									$.post("/user.main.login",$("#_FormLogin").serialize(),function(data){
											data=data.replace(/<[^>]+>/g,"");
											data=eval("("+data+")");
											if(data && data.result==1){
												$('.header').load("/player.main.header");
												$("#_ContentLogin").dialog( "close" );
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
			});
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
						width:300,height:180, buttons: {
								"注册": function() {
									//TODO LOGIN
									return;
								},
								"取消": function() {
									$( this ).dialog( "close" );
								}
						}
					});
			});
			//可以被放入和被排序
			$( "#_ContentSearch" ).sortable();
			$( "#_Content" ).droppable({
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					tolerance:"pointer",
					accept:"#_ContentSearch >li",
							drop: function( event, ui ) {
									//这里是从搜索结果拖到当前播放列表
									YoukuWsPlaylist.add(ui.draggable.attr('vid'),ui.draggable.find("span").eq(2).html());
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
			$( "#_ContentList >li" ).droppable({
					accept:"#_ContentMusic >li,#_ContentSearch >li",
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					tolerance:"pointer",
					drop: function( event, ui ) {
							setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							//TODO移动到另一个列表
							alert("MV");
					}
			});
			$( "#_ContentList" ).sortable({
						stop:function(event,ui){
							$(this).find("li:not(.ui-sortable-placeholder)").each(function (index, domEle) { 

								if(order[index]!=$(domEle).attr("vid")){
								//TODO顺序已经改变，需要保存在服务
								//	alert($(domEle).find("a").html()+index);//attr("vid"));
								};
							});
						},start:function(event,ui){
							$(this).find("li:not(.ui-sortable-placeholder)").each(function (index, domEle) { 
								order[index]=$(domEle).attr("vid");
							});
						},remove:function(event,ui){
								//alert("REMOVE");
								//应该保存数据
						}
					});
			$("#_BtTrash").button({ icons: { primary: "ui-icon-trash" }}).droppable({
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					accept:"#_ContentMusic >li,#_ContentList >li",
					tolerance:"pointer",
					drop: function( event, ui ) {
							YoukuWsPlaylist.del(ui.draggable.attr("vid"));
							setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
					}
				});
			$("#PlayModeSet [name=set]").click(function(){
				YoukuWs.set("PlayModeSet",$("#PlayModeSet [name=set]:checked").val());
			});
			if(YoukuWs.get("PlayModeSet")){
					PlayMode = YoukuWs.get("PlayModeSet");
					$("#PlayModeSet [value="+PlayMode+"]").attr("checked",true);//(PlayMode);
			}
			$("#PlayModeSet" ).buttonset().show();
			$("#_BtPlayModeSet").button("option","disabled",true).show();

			$("#_BtOpenList").button({ icons: { primary: "ui-icon-folder-open" } }).click(function(){
					//显示列表
					$("#_ContentList").dialog({
						width:300,height:250
					});
			}).show();
			$("#_BtAddList").button({ icons: { primary: "ui-icon-plusthick" } });
			$("#_BtAddMv").button({ icons: { primary: "ui-icon-plusthick" } }).click(function(){
				$( "#_DialogAdd" ).dialog({
					width:500,height:280, buttons: {
							"增加": function() {
								var k =($("#_DialogAdd textarea").val());
								$.ajax({type:"POST",url:"/player.main.getVideo",data:{"k":k},success:function(msg){
											msg=msg.replace(/<[^>]+>/g,"");
											msg=eval("("+msg+")");
											for(var i=0;i<msg.items.length;i++){
												if(msg.items[i].vid && msg.items[i].title && msg.items[i].seconds){
													YoukuWsPlaylist.add(msg.items[i].vid,msg.items[i].title);//,msg.items[i].seconds);
												}
											}
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
			$("#_BtSaveList").button({icons:{primary:"ui-icon-disk"}}).show();

			setInterval(checkTime,500);
			setInterval(YoukuWs.adReload,1000*60*10);// 10分钟一次
			if(YoukuWs.get("vid")){
				YoukuWs.play(YoukuWs.get("vid"));
			}else{
				vid = $("#_ContentMusic >li").first().attr("vid");
				YoukuWs.play(vid);
			};
	});
	var pre_index=0;
	function checkTime(){
			if(!o_lyrics){
					o_lyrics = $('.lyrics');
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
			var t = l.top - 100;
			var LyricCurrent = $("#"+id);
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
	
	}
	function showLyric(str){
			gc= new Array();
			parseLyric(str);
			$(".lyrics").html('');
			var tmp_top=0;
			if(!gc ||gc.length==0)return;
			for (var k=0;k<gc.length;k++)
			{
					if(gc[k].w==""){
							gc[k].w="&nbsp;";
					}
					var c = '<div time="'+gc[k].t+'" id="_ID'+k+'">'+gc[k].w+'</div>';
					$(".lyrics").append(c);
					gc[k].top = tmp_top;
					tmp_top+= $("#_ID"+k).height();
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
		play:function(vid){
			mvid = 0;
			showLyric("");
			vid = vid?vid:"XMjI4MTczMDIw";
			pre=1;
			next=1;
			CurrentVideoID=vid;
			YoukuWs.set("vid",CurrentVideoID);
			//下载歌词
			$.ajax({
				url: "/player.main.getlyric",
				data: {
					vid:vid
				},
				//dataType:"json",
				success: function( result) {
					result=result.replace(/<[^>]+>/g,"");
					try{
						result=eval("("+result+")");
					}catch(e){
						result={};
					}
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
			swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",
				{isAutoPlay:true,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},
				{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"},{},function(){
					var t = 0;
					var o = $("#_ContentMusic [vid="+vid+"]");
					if(!o || !o.position())return;
					YoukuWs.setTitle($("#_ContentMusic [vid="+vid+"] A").html());
					t = o.position().top+o.outerHeight()-o.parent().height();
					if(t>0){
						t = o.parent().scrollTop() + o.position().top+o.height()-o.parent().height(); //432
						o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
						});
					}else if( t<0-(o.parent().height()-o.outerHeight())){
						t = o.parent().scrollTop() - o.outerHeight();//o.position().top;//-o.parent().height(); //432
						o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
						});
					}
					$("#_ContentMusic >li").removeClass("current");
					o.addClass('current');
			});
		},
		playRandom:function(){
			var rand_num = Math.floor(Math.random()*$('#_ContentMusic li').size());
			vid = $("#_ContentMusic li").eq(rand_num).attr("vid");
			if(vid)YoukuWs.play(vid);
		},
		/*播放下一个*/
		playNext:function(){
			vid = CurrentVideoID;
			vid = $("#_ContentMusic [vid="+vid+"]").next().attr("vid");
			if(!vid){
				vid = $("#_ContentMusic li").first().attr("vid");
			}
			if(vid)YoukuWs.play(vid);
		},
		/*播放上一个*/
		playPre:function(){
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
			 //t=t.substring(1)+t.substring(0,1);
			 //setTimeout("YoukuWs.setTitle("+t+")",1000);
		},
		get:function(k){
			//TODO userData for IE
			if('localStorage' in window && window['localStorage'] !== null){
				if(localStorage[k])return localStorage[k];
			}
			if($.cookie(k))return $.cookie(k);
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
		}
	}
}();
var YoukuWsPlaylist = function(){
		var o={};
		o.add=function(vid,title,noappend){
				var all = $.parseJSON(YoukuWs.get("list"))||[];
				finded = false;
				//v = vid;
				//t = title
				$.each(all,function(i,item){
						if(item.v == vid){
								finded = true;
								all[i].t=title;
						}
				});
				if(!finded){
					var m = {};
					m.v = vid;
					m.t= title;
					all[all.length]=m;
					if(!noappend){
						var o = '<li vid="'+vid+'"><a>'+title+'</a></li>';
						$("#_ContentMusic").append(o);
						//$.ajax({
						//	url: "/player.main.addmv",
						//	data: {
						//		vid:vid
						//	},
						//	success: function( result) {
						//	}

						//});
					}
				}
				YoukuWs.set("list",JSON.stringify(all));
		};
		o.list=function(){
				return $.parseJSON(YoukuWs.get("list"))||[];
		};
		o.save=function(){
			o.empty();
			$("#_ContentMusic >li").each(function(i,n){
				YoukuWsPlaylist.add($(n).attr("vid"),$(n).find("a").html(),true);
			});
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
var CurrentVideoID="";
function onPlayerStart(vid,vidEncoded){
		//PlayerColor("000000","4F4F4F",25);
}
function onPlayerError(vid){
		$("#_ContentMusic [vid="+vid+"] A").html("<font color='red'>播放失败:</font> "+$("#_ContentMusic [vid="+vid+"] A").html());
		YoukuWs.playNext();
		//PlayerColor("000000","4F4F4F",25);
}
function onPlayerComplete(vid,vidEncoded,isFullScreen){
		PlayMode = $("#PlayModeSet [name=set]:checked").val();
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
function PlayerPlayPre(vid,vidEncoded,isFullScreen){
		YoukuWs.playPre();
}
function PlayerPlayNext(vid,vidEncoded,isFullScreen){
		onPlayerComplete();
}
//}}}
//{{{
function search(page){
	page = page?page:1;
	$("#keywords").autocomplete("close");
	YoukuWs.set("keywords",$("#keywords").val());
	var key = $("#keywords").val();
	if(key=="")return;
	$( "#_ContentSearch" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在查找中...</li>');
	$( "#_ContentSearch" ).dialog({
				width:410,height:250
				});
	$.ajax({
		url: "/player.main.search",
		data: {
			k:$("#keywords").val()
		},
		beforeSend:function(xhr){
		},select:function(event,ui){
		},success: function( data) {
			data=data.replace(/<[^>]+>/g,"");
			try{
			data=eval("("+data+")");
			}catch(e){data=null;}
			$("#keywords").autocomplete("close");
			$("#_ContentSearch").html('');
			if(!data || !data.item || data.item.length==0){
				$("#_ContentSearch").html('<li>没有找到,请换下搜索条件试试</li>');
			}else{
				for(var i=0;i<data.item.length;i++){
					var o = '<li title="点击播放:'+data.item[i].title+'" vid="'+data.item[i].videoid+
							'"><a><span class="left"><span class="handle ui-icon ui-icon-arrow-4"></span></span>'+
							'<span class="left">'+ data.item[i].title+'</span>'+
							'<span class="right">'+data.item[i].duration+'</span>'+
							'<div class="clear"></div></a></li>';
					$("#_ContentSearch").append(o);
				}
			};
			$( "#_ContentSearch" ).dialog({
					width:410,height:250,
					close:function(event,ui){
					}
			});
		}

	});
	/*
	$.getJSON("/player.main.search?k="+key, function(data){
					alert(data);
						data=data.replace(/<[^>]+>/g,"")
						data=eval("("+data+")");
		$("#keywords").autocomplete("close");
		$("#_ContentSearch").html('');
		if(!data || !data.item || data.item.length==0){
			$("#_ContentSearch").html('<li>没有找到,请换下搜索条件试试</li>');
		}else{
			for(var i=0;i<data.item.length;i++){
				var o = '<li title="点击播放:'+data.item[i].title+'" vid="'+data.item[i].videoid+
						'"><a><span class="left"><span class="handle ui-icon ui-icon-arrow-4"></span></span>'+
						'<span class="left">'+ data.item[i].title+'</span>'+
						'<span class="right">'+data.item[i].duration+'</span>'+
						'<div class="clear"></div></a></li>';
				$("#_ContentSearch").append(o);
			}
		};
		$( "#_ContentSearch" ).dialog({
				width:410,height:250,
				close:function(event,ui){
				}
		});
	});
	*/
}
//function parse(data) {
//	data = data.replace("showresult('","").replace("',false)","");                                                                         
//	var r = eval(data);                                                                                                                    
//	var parsed=[];                                                                                                                         
//	if(!r)return;
//	for(var i=0;i<r.result.length;i++){                                                                                                    
//		parsed[i]={                                                                                                                        
//			data:r.result[i] ,                                                                                                             
//			value:r.result[i].keyword ,                                                                                                    
//			result:r.result[i].keyword
//		}
//	}
//	return parsed;
//}
$("#keywords").ready(function(){
	$("#keywords").change(function(){
		YoukuWs.set("keywords",$("#keywords").val());
	});
	//return;
	var keywords = YoukuWs.get("keywords");
	if(keywords){
		$("#keywords").val(keywords);
	};
		
/*
var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];

		$( "#keywords" ).autocomplete({
			source: availableTags
		});

*/
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

//$("#_BtSearch").ready(function(){
//	$("#_BtSearch").click(function(){
//		search();
//	});
//});
//}}}