//{{{主方法
var YoukuWs = function(){
	var o_lyrics;
	var gc= "";

	$(document).ready(function(){
			$("#_IDList").click(function(){
					//显示列表
					$("#_ContentList").dialog({
						width:410,height:250
					});
					//$("#_ContentList").slideToggle("fast",function(){
					//		//$("#_ContentList").fadeIn("fast");
					//		$("#_IDList").html("关闭播放列表");
					//});
			});
			$("#_ContentList li").live('click',function(){
			});
			//$("#_IDAdd").click(function(){
			//		$( "#_DialogAdd" ).dialog({
			//				close:function(event,ui){
			//						alert("CLOSE");
			//				}
			//		});
			//});
			$("#_ContentMusic >li,#_ContentSearch >li").live('click',function(){
					var vid = $(this).attr('vid');
					YoukuWs.play(vid);
					return false;
			});
			//可以被放入和被排序
			$( "#_Content >ul" ).sortable({
					stop:function(event,ui){
							//应该保存数据
					},remove:function(event,ui){
							alert("REMOVE");
							//应该保存数据
					}
			});
			$( "#_Content >ul" ).disableSelection();
			//$( ".list >ul" ).selectable();
			$( "#_ContentMusic" ).droppable({
					activeClass: "ui-state-default",
					hoverClass: "ui-state-highlight",
					accept:"#_ContentSearch >li",
							drop: function( event, ui ) {
									//这里是从搜索结果拖到当前播放列表
									var o = '<li vid="'+ui.draggable.attr('vid')+'"><a>'+ui.draggable.find("a").html()+'</a></li>';
									$("#_ContentMusic").append(o);
									setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							}
			});
			$( "#_ContentList >li" ).droppable({
					accept:"#_ContentMusic >li,#_ContentSearch >li",
					drop: function( event, ui ) {
							//setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							alert("MV");
							//$( this )
							//.html( "回收站:Dropped!" )
							//.addClass( "ui-state-highlight" );
					}
			});
			$("#_BtTrash").button({ icons: { primary: "ui-icon-trash" } }).droppable({
					//activeClass: "ui-state-default",
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					accept:"#_ContentMusic >li",
					drop: function( event, ui ) {
							setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							//$( this ) .html( "回收站:!" );
									//.addClass( "ui-state-highlight" );
					}
			});
			$("#PlayModeSet [name=set]").click(function(){
				YoukuWs.set("PlayModeSet",$("#PlayModeSet [name=set]:checked").val());
				//alert($("#PlayModeSet [name=set]:checked").val());
			});
			if(YoukuWs.get("PlayModeSet")){
					PlayMode = YoukuWs.get("PlayModeSet");
					$("#PlayModeSet [value="+PlayMode+"]").attr("checked",true);//(PlayMode);
			}
			$("#PlayModeSet" ).buttonset().show();
			$("#_BtPlayModeSet").button("option","disabled",true);

			$("#_BtOpenList").button({ icons: { primary: "ui-icon-folder-open" } });
			$("#_BtAddList").button({ icons: { primary: "ui-icon-plusthick" } });
			$("#_BtAddMv").button({ icons: { primary: "ui-icon-plusthick" } }).live("click",function(){
				$( "#_DialogAdd" ).dialog({
						close:function(event,ui){
								alert("CLOSE");
						}
				});
			});
			$("#_BtSearch").button({ icons: { primary: "ui-icon-search" } });
			$("button").show();

			showLyric();
			setInterval(checkTime,500);
			setInterval(YoukuWs.adReload,1000*60*10);// 10分钟一次
			if(YoukuWs.get("vid")){
				YoukuWs.play(YoukuWs.get("vid"));
			}else{
				vid = $("#_ContentMusic >li").first().attr("vid");
				YoukuWs.play("vid");
			};
			$(".main").show();
	});
	var pre_index=0;
	function checkTime(){
			if(!o_lyrics){
					o_lyrics = $('.lyrics');
			}
			var r= PlayerInfo();
			if(!r)return;
			var time = isNaN(r.time)?0:r.time;
			var l = getLyric(time*1000);
			if(!l){return;}
			var id = "_ID"+l.i;
			var index = l.i;
			if(pre_index  == index)return;else{
				pre_index=index;
			}
			//向上移动
			var t = l.top - 100;
			var LyricTop = $("#_LyricsTop");
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
	function showLyric(){
			parseLyric($("#lyrics_c").val());
			$(".lyrics").html('');
			var tmp_top=0;
			for (var k=0;k<gc.length;k++)
			{
					if(gc[k].w==""){
							gc[k].w="&nbsp;";
					}
					var c = '<div id="_ID'+k+'">'+gc[k].w+'</div>';
					$(".lyrics").append(c);
					gc[k].top = tmp_top;
					tmp_top+= $("#_ID"+k).height();
			}
	}
	
	function parseLyric(str)
	{
			ti=/\[ti:(.+)\]/i.test(str)?"标题："+RegExp.$1:"";
			ar=/\[ar:(.+)\]/i.test(str)?"歌手："+RegExp.$1:"";
			al=/\[al:(.+)\]/i.test(str)?"专辑："+RegExp.$1:"";
			by=/\[by:(.+)\]/i.test(str)?"制作："+RegExp.$1:"";
			otime=parseInt(/\[offset:(.+)\]/i.test(str)?RegExp.$1:0);
	
			gc=str.match(/\n\[\d+:.+\][^\[\r\n]*/ig);
			rr=gc.length;
			for (var i=0;i<rr;i++)
			{
					var gctimes=/\[(.+)\].*/.exec(gc[i])[1].split("][");
					var gcword=/.+\](.*)/.exec(gc[i])[1];
					for (var j in gctimes)
					{ 
							gc.push({t:(parseInt(gctimes[j].split(":")[0])*60+parseFloat(gctimes[j].split(":")[1]))*1000 ,w:gcword});
					}
			}
			gc.splice(0,rr);
			$.grep( gc, function(n,i){
					return n.w!="";
			});
			gc.sort(function (a,b){return a.t-b.t});
	}
	/*可以优化为2分算法*/
	function getLyric(t){
			for (var k=0;k<gc.length && gc[k] &&gc[k+1];k++){
					if(t>=gc[k].t && t<=gc[k+1].t){
							var gc_tmp = gc[k];
							gc_tmp.i=k;
							return(gc_tmp);
					}
			}
	};
	
	return {
		version:"1.1",
		/*播放视频*/
		play:function(vid){
			pre=1;
			next=1;
			CurrentVideoID=vid;
			YoukuWs.set("vid",CurrentVideoID);
			swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",
				{isAutoPlay:true,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},
				{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"},{},function(){
					$("#_ContentMusic >li").removeClass("current");
					$("#_ContentMusic [vid="+vid+"]").addClass('current');
					YoukuWs.setTitle("YOUKU.WS 正在播放 - " +$("#_ContentMusic [vid="+vid+"] A").html() +"  ");
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
			document.title=t;
		},
		get:function(k){
			if('localStorage' in window && window['localStorage'] !== null){
				if(localStorage[k])return localStorage[k];
			}
			if($.cookie(k))return $.cookie(k);
		},
		set:function(k,v){
			if('localStorage' in window && window['localStorage'] !== null){
				localStorage[k] = v;return;
			}
			$.cookie(k,v,{expires:40});
		},
		adReload:function(){
			$(".googlead").each(function(index,dom){
				var a = $(dom).clone();
				$(dom).html('');
				$(dom).html(a.html());
			});

		}
	}
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
	var key = $("#keywords").val();
	$( "#_ContentSearch" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在查找中...</li>');
	$( "#_ContentSearch" ).dialog({
				width:410,height:250
				});
	$.getJSON("/player.main.search?k="+key, function(data){
		$("#_ContentSearch").html('');
		if(data.item.length==0){
			$("#_ContentSearch").html('<li>没有找到,请换下搜索条件试试</li>');
		}else{
			for(var i=0;i<data.item.length;i++){
				var o = '<li title="点击播放:'+data.item[i].title+'" vid="'+data.item[i].videoid+
						'"><div><span class="handle ui-icon ui-icon-arrow-4"></span><a>'+
						data.item[i].title+'</a><span class="right">时长:'+
						data.item[i].duration+
						'</span></div><div class="clear"></div></li>';
				$("#_ContentSearch").append(o);
			}
		}
		$( "#_ContentSearch" ).dialog({
				width:410,height:250,
				close:function(event,ui){
				}
		});
	});
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
	}
		
	$("#keywords").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "/player.main.complete",
				//dataType: "json",
				data: {
					k:$("#keywords").val()
				},
				beforeSend:function(xhr){
				},
				success: function( result) {
					var r = eval(result);
					response( $.map( r.result, function( item ) {
						return {
							label: item.keyword,
							//label: "<div>"+item.keyword+ "<span class='right'>["+item.count+"]个视频</span></div>",
							value: item.keyword,
							count: item.count,
						}
					}));
				},

			});
		},
		open: function(event,ui){
		}/*,
		select: function( event, ui ) {
			$( "#keywords" ).val( ui.item.label );
			//$( "#project-id" ).val( ui.item.value );
			//$( "#project-description" ).html( ui.item.desc );
			//$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
			return false;
		}*/
	});/*.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<div>" + item.label + "<span class='right'>[" + item.count+ "]个视频</span></div>" )
				.appendTo( ul );
	};
	/*
	$("#keywords").autocomplete("/player.main.complete?",{
		autoFill:false,delay:200,max:20,width:200,"parse":parse,
		formatItem: function(row, i, max) {
			return  "<div>"+row.keyword + " <span class='right hits'>[" + row.count + "]个视频</span></div>";
		},
		 extraParams: {
	   },
		formatMatch: function(row, i, max) {
			return row.keyword;
		}
	});
	$("#keywords").result(function(event, data, formatted) {
		YoukuWs.set("keywords",$("#keywords").val());
		search();
	});
	*/
	
});

$("#search").ready(function(){
	$("#search_bt").click(function(){
		search();
	})
});
//}}}
