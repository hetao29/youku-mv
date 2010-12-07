//{{{主方法
var YoukuWs = function(){
	var o_lyrics;
	var gc= "";

	$(document).ready(function(){
			$("#_IDList").click(function(){
					//显示列表
					$("#_ContentList").slideToggle("fast",function(){
							//$("#_ContentList").fadeIn("fast");
							$("#_IDList").html("关闭播放列表");
					});
			});
			$("#_ContentList li").live('click',function(){
			});
			$("#_IDAdd").click(function(){
					$( "#_DialogAdd" ).dialog({
							close:function(event,ui){
									alert("CLOSE");
							}
					});
			});
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
					accept:"#_ContentSearch >li",
							drop: function( event, ui ) {
									//这里是从搜索结果拖到当前播放列表
									setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
									var o = '<li vid="'+ui.draggable.attr('vid')+'"><a>'+ui.draggable.html()+'</a></li>';
									$("#_ContentMusic").append(o);
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
			$( ".trash" ).droppable({
					drop: function( event, ui ) {
							setTimeout(function() { ui.draggable.remove(); }, 1);//fro ie patch
							$( this )
									.html( "回收站:Dropped!" )
									.addClass( "ui-state-highlight" );
					}
			});
			$("#PlayModeSet [name=set]").click(function(){
						$.cookie('PlayMode',$("#PlayModeSet [name=set]:checked").val(),{expires:60});
			});
			if($.cookie("PlayMode")){
					PlayMode = ($.cookie("PlayMode"));
					$("#PlayModeSet [value="+PlayMode+"]").attr("checked",true);//(PlayMode);
			}
			showLyric();
			setInterval(checkTime,500);
	});
	function checkTime(){
			try{
					if(!o_lyrics){
							o_lyrics = $('.lyrics');
					}
					var r= PlayerInfo();
					//var h= o_lyrics.height();
					var time = isNaN(r.time)?0:r.time;
					//var alltime= isNaN(r.alltime)?0:r.alltime;
					//var p= r.time / r.alltime;
					//var t= p*h;
	
					//t= t<(h/2)?0:t;
					var l = getLyric(time*1000);
					if(!l){return;}
					var id = "_ID"+l.i;
					var index = l.i;
					//向上移动
					//var t = $("#_ID0").height()*(index-8);
					var t = l.top - 160;
					//$("#debug").html("top:"+t);
					$("#_LyricsTop").show();
					o_lyrics.animate({scrollTop:t+"px"},"fast","linear",function(){
							if($("#"+id).html().replace("&nbsp",'')!=""){
									var t2 = $("#"+id).position().top;
									$("#_LyricsTop").animate({"top":t2+"px"},"fast");
									$("#_LyricsTop").animate({
											"height":$("#"+id).height()+"px"
											},"fast");
							}
					});
	
	
	
	
					$("#_ContentLyrics .red").removeClass("red");
					$("#"+id).addClass("red");
					$("#debug2").html(l.w +":"+l.t);
					return;
			}catch(e){
					$("#debug").html(e.description);
			}
	
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
	function getLyric(t){
			for (var k=0;k<gc.length;k++){
					if(t>=gc[k].t && t<=gc[k+1].t){
							var gc_tmp = gc[k];
							gc_tmp.i=k;
							return(gc_tmp);
					}
			}
	}
	
	return {
		version:"1.1",
		/*播放视频*/
		play:function(vid){
			pre=1;
			next=1;
			CurrentVideoID=vid;
			swfobject.embedSWF("http://static.youku.com/v1.0.0133/v/swf/qplayer.swf", playerId, "100%", "100%", "9.0.0", "expressInstall.swf",{isAutoPlay:true,VideoIDS:vid,winType:"interior","show_pre":pre,"show_next":next},{allowFullScreen:true,allowscriptaccess:"always","wmode":"transparent"},{},function(){
				$("#_ContentMusic >li").removeClass("current");
				$("#_ContentMusic [vid="+vid+"]").addClass('current');
				YoukuWs.setTitle("YOUKU.WS 正在播放 - " +$("#_ContentMusic [vid="+vid+"] A").html() +"  ");
			});
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
		//PlayerColor("000000","4F4F4F",25);
}
//alert($.cookie('a'));
//alert($.cookie('a',"b"));
function onPlayerComplete(vid,vidEncoded,isFullScreen){
		PlayMode = $("#PlayModeSet [name=set]:checked").val();
		switch(parseInt(PlayMode)){
				case 1:
						YoukuWs.play(CurrentVideoID);
				break;
				case 2:
				case 3:
						YoukuWs.playNext();
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
		return _player().getNsData();

};
function PlayerSeek(s){
		s = isNaN(parseInt(s))?0:parseInt(s);
		_player().nsseek(parseInt(s));
};
function PlayerPlayPre(vid,vidEncoded,isFullScreen){
		YoukuWs.playPre();
}

function PlayerPlayNext(vid,vidEncoded,isFullScreen){
		YoukuWs.playNext();
}
//}}}
//{{{
function search(page){
	page = page?page:1;
	var key = $("#keywords").val();
	$.getJSON("/player.main.search?k="+key, function(data){
		$("#_ContentSearch").html('');
		 for(var i=0;i<data.item.length;i++){
			var o = '<li vid="'+data.item[i].videoid+'"><a title="'+data.item[i].title+'">'+data.item[i].title+'</a></li>';
			$("#_ContentSearch").append(o);
		}
					$( "#_ContentSearch" ).dialog({
							close:function(event,ui){
							}
					});
	});
}
function parse(data) {
	data = data.replace("showresult('","").replace("',false)","");                                                                         
	var r = eval(data);                                                                                                                    
	var parsed=[];                                                                                                                         
	if(!r)return;
	for(var i=0;i<r.result.length;i++){                                                                                                    
		parsed[i]={                                                                                                                        
			data:r.result[i] ,                                                                                                             
			value:r.result[i].keyword ,                                                                                                    
			result:r.result[i].keyword
		}
	}
	return parsed;
}
$("#keywords").ready(function(){
	//$("#keywords").focus();
	//$("#keywords").change(function(){
	//alert("D");
	//	$("#debug").html($("#keywords").val());
	//});
	//return;
	if(localStorage.keywords)$("#keywords").val(localStorage.keywords)
		
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
		localStorage.keywords = data.keyword;
		search();
	});
	
});

$("#search").ready(function(){
	$("#search_bt").click(function(){
		search();
	})
});
//}}}
YoukuWs.play('XMTYxNjc5MzY4');







