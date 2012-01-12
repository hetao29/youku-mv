(function($){
	$.fn.bt = function(options){
		var defaults = {position:"left"}; 
		var options = $.extend(defaults, options); 
		this.each(function(item){ 
			var t = $(this);
			var html2="";
			if(t.attr("bt_set"))return;
			var html = t.html();
			//var html2='<span class="bt_b" ';
			//if(options.width)html2+="style='width:"+options.width+"px'";
			//else html2+="style='width:38px'";
			//html2+=' >';
			//if(options.icon){
			//	if(options.position=="left"){
			//				html2+='<span class="bt_c">&nbsp;</span> <span class="bt_d"><span style="padding-top:3px" class="left ui-icon '+options.icon+'"></span><span class="right">'+html+'</span></span></span>';
			//	}else{
			//				html2+='<span class="bt_c">&nbsp;</span> <span class="bt_d"><span style="padding-top:3px" class="right ui-icon '+options.icon+'"></span><span class="left">'+html+'</span></span></span>';
			//	}
			//}else{
				if($.browser.msie && parseInt($.browser.version) <9){
					//var x=("NO");
					html2='<span class="bt_b"><span class="bt_c">&nbsp;</span> <span class="bt_d">'+html+'</span> </span>';
					
					if(!t.hasClass("bt"))t.addClass("bt");
				}else{
					//var x=("YES");
					html2=html;//'<span class="bt_new">'+html+'</span>';
					//html2='<span class="bt_b"><span class="bt_c">&nbsp;</span> <span class="bt_d">'+html+'</span> </span>';
					if(!t.hasClass("bt_new"))t.addClass("bt_new");
				}
				//html+=x;
			//var	html2='<span class="bt_b"><span class="bt_c">&nbsp;</span> <span class="bt_d">'+html+'</span> </span>';
			//}
			t.html(html2);
			t.attr("bt_set",true);
			t.attr("href","javascript:void(0);");
		}); 
		return this;
	}; 
	$(document).ready(function(){
		if($.browser.msie && parseInt($.browser.version) <=6){
			YoukuWs.tips("我们建议您升级你的浏览器，以获得更好的体验，或者访问<a href='/player.main.entryOld'><font color='red'>旧版</font></a> ",true);
		}
	});
})(jQuery); 

/*dialog*/
(function($){
	$.fn.center = function () {
		//this.css("position","absolute");
		var top = ( $(window).height() - this.height() ) / 2+$(window).scrollTop();
		top = top<0?0:top;
		this.css("top", top + "px");
		var left = ( $(window).width() - this.width() ) / 2+$(window).scrollLeft();
		left = left<0?0:left;
		this.css("left", left + "px");
		return this;
	};
	$.fn.dg = function(options){

		if(YoukuWs.isIpad()){
			$("#"+playerId).attr("controls",null);
		};
		var defaults = {position:"left"}; 
		var options = $.extend(defaults, options); 
		this.each(function(item){ 
			if(!window.zIndex)window.zIndex=50;window.zIndex++;
			var t = $(this);
			t.show();
			if(t.attr("bt_set")){
				t.find(".table-layer").css("z-index",window.zIndex);
				t.find(".table-layer").center();
				return;
			};
			var content = t.html();
			var mode = t.attr("mode");
			var title = t.attr("_title");
			var title2 = t.attr("_title2");
			var close = t.attr("close");
			var height = options['height'];
			var width = options['width'];
			var w=w2=h="";
			//	if(height) h='height:'+height+'px;';
			if(width) w = "width:"+width+"px;";
			//if(width) w2 = "style='width:"+(width+20)+"px;'";
			mode = mode?true:false;
			var dg="";
			/*
			dg='<div class="layer" style="z-index:'+zIndex+'">';
			dg+='<div class="ly-box" '+w2+'>';
			dg+='<div class="top"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>';
			dg+='<div class="cont-border">';
			dg+='<div class="left"><div class="box"></div></div>';
			dg+='<h2 id="ly-title" class="ly-title">'+title;
			if(title2)dg+='<span>/'+title2+'</span>';
			dg+='</h2>';
			dg+='<a class="close" title="'+close+'">'+close+'</a>';
			dg+='<div class="content" '+w+'>';
			*/
			dg+='<table class="table-layer" cellpadding="0" cellspacing="0" style="z-index:'+zIndex+'">';
			dg+='<tr class="top">';
			dg+='<td class="angle left-top"></td>';
			dg+='<td class="edge-top"></td>';
			dg+='<td class="angle right-top"></td>';
			dg+='</tr>';
			dg+='<tr class="middle">';
			dg+='<td class="edge-left"></td>';
			dg+='<td class="layer-body" style="position:relative;">';
			//dg+='<h2 id="ly-title" class="ly-title">我的歌单<span>/华语流行金曲 -> 整理歌曲</span></h2>';
			dg+='<h2 id="ly-title" class="ly-title">'+title;
			if(title2)dg+='<span>/'+title2+'</span>';
			dg+='</h2>';
			dg+='<a class="close" title="关闭">关闭</a>';
			dg+='<div class="content" style="margin:0 auto; '+w+'">';

			dg+=content;
			dg+='</div>';
			dg+='</td>';
			dg+='<td class="edge-right"></td>';
			dg+='</tr>';
			dg+='<tr class="bottom">';
			dg+='<td class="angle left-bottom"></td>';
			dg+='<td class="edge-bottom"></td>';
			dg+='<td class="angle right-bottom"></td>';
			dg+='</tr>';
			dg+='</table>';
			/*
			dg+='</div>';
			dg+='<div class="right"><div class="box"></div></div>';
			dg+='</div>';
			dg+='<div class="bottom"><div class="box"><i></i><i class="right"></i><div class="boxcenter"></div></div></div>';
			dg+='</div>';
			dg+='</div>';
			*/
			t.html(dg);
			t.find(".table-layer").center();
			t.attr("bt_set",true);
			if(options['close']){
				t.data("close",options['close']);
			}
		}); 
		return this;
	}; 


	$.fn.dgclose = function(options){

		this.each(function(item){ 
			var t = $(this);
			if(!t.attr("bt_set")){
				return;
			};
			t.find(".close").trigger("click");
		}); 
		return this;
	}; 


	$(".close").live("click",function(){
		var p = $(this).parents(".table-layer").parent();
		if(YoukuWs.isIpad()){
			$("#"+playerId).attr("controls","controls");
		}
		var d =p.data("close");
		if(d){
			try{
				d();
			}catch(e){
				eval(d);
			}
		}
		p.hide();
	});
})(jQuery); 

jQuery.extend(
		String.prototype, { 
			tr:function(){
				   if(window.locale!==undefined && window.locale[this]){
					   return window.locale[this];
				   }
				   return this;
			   }
		}
		);
var _location = window.location;

//{{{主方法
$.ajaxSetup({
	dataType:"json"
});
function timeFormat(seconds){
	if(isNaN(seconds))return "00:00";
	var min=Math.floor(seconds/60);
	min=min>9?min:"0"+min;
	var sec=Math.floor(seconds%60);
	sec=sec>9?sec:"0"+sec;
	return min+":"+sec;
}
//{{{
function search(page){
	page = page?page:1;
	$("#keywords").autocomplete("close");
	YoukuWs.set("keywords",$("#keywords").val());
	var key = $("#keywords").val();
	if(key=="")return;
	YoukuWs.loadMusic("/player.main.searchV3.:page:?k="+$("#keywords").val(),page);
}
//}}}
var YoukuWs = function(){
	var fullScreen=false;
	var o_lyrics;
	var gc= new Array();
	var lyrics_offset=0;
	//用户ID
	var uid=1;
	var LyricsInterval=0;
	var flag=true;
	var title="";
	var order=[];
	$(document).ready(function(){
		$("#_IDLyricsAdmin >a").bt();
		//{{{
		if (!$.support.borderRadius){
			//$('#box').corner("tr tl 8px");
			//$("#_IDRight").corner("tr br 8px");
		}
		//}}}

		//{{{键盘快捷键，
		/*
		   上/左 Up：		上一首
		   下/右 Down：	下一首
		   空格 Space:		播放/暂停
		 */

		$(document).keydown(function(e){
			var name 	= e.target.nodeName.toLowerCase();
			if( name !== "input" && name !== "textarea" && name !=="button" && !e.altKey && !e.ctrlKey ) {
				switch(e.which){
					case 38://上
						//只有播放模式下才有下一首
						if(PlayType==1){
							$("#_BtPre").trigger("click");
						}
						break;
					case 40://下
						//if(PlayType==0){
						//	$("#_IDSkip").trigger("click");
						//}else{
							$("#_BtNext").trigger("click");
						//}
						break;
					case 37://左
						var li=$("#IDNav >a");
						var i =li.index($("#IDNav .current"));
						i = i>=1?i-1:li.size()-1;
						$("#IDNav >a").eq(i).trigger("click");
						break;
					case 39://右
						var li=$("#IDNav >a");
						var i =li.index($("#IDNav .current"));
						i = i>li.size()-i?0:i+1;
						$("#IDNav >a").eq(i).trigger("click");
						break;
					case 32://Space
						PlayerPause(YoukuWs.flag);
						YoukuWs.flag=!YoukuWs.flag;
						break;
					case 13://Enter
						$("#_IDThx").trigger("click");
						break;
					case 46://Del

						//if(PlayType==0){
						$("#_IDDown").trigger("click");
						//}else{
						//	$("#_BtTrash").trigger("click");
						//}
						break;
				}
			}
		});
		//}}}

		YoukuWs.loadRadio(false);



		//换台按钮
		$("#_RadioChannel li >a").live("click",function(){
			$("#_RadioChannel").dgclose();
			YoukuWs.set("cid",$(this).attr("id"));
			window.radioPlayList=new Array();
			PlayType=0;
			YoukuWs.set("PlayType",PlayType);
			YoukuWs.playRadio();
		});
		//$("#_IDBeian").attr("href","http://www.miibeian.gov.cn/").attr("target","_blank");
		$("#_IDLanguage").click(function(){
			$("#language").slideToggle("fast");
		});
		$("#language >a").click(function(){
			YoukuWs.set("language",$(this).attr("data"),true);
			_location.replace(_location.pathname);
		});
		$("#share, #share-layer").mouseout(function(){
			$("#share").removeClass("hover");
			$("#share-layer").hide();

		});
		$("#share, #share-layer").mouseover(function(){
			$("#share").addClass("hover");
			var _pos = $("#share").offset();
			$("#share-layer").css("left",(_pos.left)+"px");
			$("#share-layer").css("top",(_pos.top+24)+"px");
			$("#share-layer").show();

		});
		$("#_BtDialogShare").live("click",function(){
			$("#_DialogShare").dgclose();
				YoukuWs.tips("正在发布微博...");
				var _data=$("#_DialogShare textarea").html();
				var postUrl=$("#_DialogShare textarea").attr("postUrl"); 
				$.post(postUrl,{content:_data,vid:CurrentVideoID},function(data){

				if(data){
					YoukuWs.tips("分享视频成功.",false,true);
				}else{
					YoukuWs.tips("分享视频失败，请稍后重试!",false,true);
				}
				},"json");
		});
		$("#share-layer a").click(function(){
			if($(this).attr("_href")){
				var href = ($(this).attr("_href")).replace(/:vid:/g,CurrentVideoID).replace(/:title:/g,"我正在%23优酷电台%23收听《 "+YoukuWs.title+" 》你们也来听听吧: ");
				$(this).attr("href",href);
			}else{

					var url= ($(this).attr("_source")).replace(/:vid:/g,CurrentVideoID);
					var postUrl = $(this).attr("_post");
					$.get(url,function(data){
						//var data="<div style='width:320px;height:220px;overflow:hidden'><textarea style='width:100%;height:100%'>"+data+"</textarea><div>";
						$("#_DialogShare textarea").html(data);
						$("#_DialogShare textarea").attr("postUrl",postUrl);
						$("#_DialogShare").dg({height:120,width:320});
						/*
						$(data).dialog({
							resizable: false,
							height:220,width:320,title:"分享到微博",
							modal: true,title:"分享到微博",
							buttons: [{
								text:"分享到微博",click:function() {
									var _data=$(this).parent('.ui-dialog').find("textarea").val();
									$.post(postUrl,{content:_data,vid:CurrentVideoID},function(data){

									if(data){
										YoukuWs.tips("分享视频成功.");
									}else{
										YoukuWs.tips("分享视频失败，请稍后重试!");
									}
									},"json");
									YoukuWs.tips("正在发布微博...");
									$( this ).dialog( "destroy");
								}},
							{
								text:_LabelCancel,
							click: function() {
								$( this ).dialog( "destroy" );
							}
							}
						]});
						*/
					},"text");
			}


		});
		$("#_IDPlay").click(function(){
			PlayerPause(false);
		});

		$("#_IDPause").click(function(){
			PlayerPause(true);
		});

		$("#_IDLanguage").mouseover(function(){
			$(this).addClass('hover');
		});
		$("#_IDLanguage").mouseout(function(){
			$(this).removeClass('hover');
		});
		$("#_IDLanguage .panel a").live("click",(function(){
			YoukuWs.set("language",$(this).attr("data"),true);
			_location.replace(_location.pathname);

		}));

		$("#_IDThx").click(function(){
			//宽屏模式
			var o = $(this).find("span");
			if(YoukuWs.get("thx")!="open"){
				//to open
				$("#_IDRight").hide();
				$("#_IDBody .cont-left").css("margin-left","0px");
				$("#_IDBody .inner-left").css("margin-left","0px");
				//$("#box").css("width",$(".fm-body").width()+"px");
				YoukuWs.set("thx","open");
				$(this).parent().addClass("already");
			}else{
				//to close
				$("#_IDBody .cont-left").css("margin-left","-258px");
				$("#_IDBody .inner-left").css("margin-left","258px");
				//$("#box").css("width","660px");//.hide();
				$("#_IDRight").show();
				$(this).parent().removeClass("already");
				YoukuWs.set("thx","close");
			}
		});
		if(YoukuWs.get("thx")=="open"){
			YoukuWs.set("thx","close");
			$("#_IDThx").trigger("click");
		}
		//{{{
		$("#_BtListAdd").live("click",function(){
			var index=1;
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).show();

			$("#_IDList .table-layer").center();
		});
		//保存到歌单
		$("#_BtListSave").live("click",function(){
			var selected_music =$("#_ContentMusic >li.select");
			if(selected_music.size()<=0){
				YoukuWs.tips("请先选择要保存的音乐");
				return;
			}
			var selected_list =$("#_IDListMain li.select");
			if(selected_list.size()<=0){
				YoukuWs.tips("请选择要保存歌单.",true);
				return;
			}

			var lids=[];
			var vids=[];
			$.each(selected_list,function(i,item){
				lids.push($(item).attr("lid"));
			});

			$.each(selected_music,function(i,item){
				vids.push($(item).attr("vid"));
			});
			YoukuWs.tips("保存中...");
			$("#_IDList").dgclose();
			if(YoukuWs.isLogin()){
				$.ajax({
					url: "/user.list.addContents",
					data: {
						lids:lids,
					vids:vids
					},type:"post",
					success: function( List) {
								 if(List){
									 YoukuWs.listList();
								 }
								 YoukuWs.tips("保存成功");
							 }

				});
			}else{
				YoukuWs.login(function(){$("#_BtListSave").trigger("click");});
			}


		});

		$("#_IDReturn").live("click",function(){
			var index=0;
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).show();
			$("#_IDList .table-layer").center();
		});
		$("#_IDCancel").live("click",function(){
			var index=0;
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).show();
			$("#_IDList .table-layer").center();
		});
		$("#_IDSaveList").live("click",function(){

			var lid = parseInt($("#_IDListTable td").eq(1).attr("lid"));
			if(lid<=0){
				var url="/user.list.add";
			}else{
				var url="/user.list.edit";
			}

			if($("#_IDListName").val()=="")return;
			$.ajax({
				url: url,
				data: {
					ListName:$("#_IDListName").val(),
				ListComment:$("#_IDListComment").val(),
				ListID:lid
				},
				success: function( List) {
							 if(List){
								 $('#_IDHeader').load("/player.main.headerV3."+out);
								 YoukuWs.listList();
							 }
						 }

			});
			var index=0;
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).show();
			$("#_IDList .table-layer").center();

		});
		$("#_AddMusic").live("click",function(){
			var k =($("#_DialogAdd textarea").val());
			$.ajax({type:"POST",url:"/player.main.getVideo",data:{"k":k},success:function(msg){
				YoukuWsPlaylist.addArray(msg);
				YoukuWs.tips("增加歌曲成功.");
			},beforeSend:function(xhr){
				$("#_DialogAdd").dgclose();
				YoukuWs.tips("增加歌曲中...");
			}
			});
		});
		$("#_IDConfirm").live("click",function(){
			var index=0;
			//{{{删除
			var lid = $("#_IDListTable td").eq(2).attr("lid");
			var li = $("#_IDListTable li[lid="+lid+"]");
			setTimeout(function() {li.remove(); }, 1);
			$.ajax({
				url: "/user.list.del",
				data: {
					ListID:lid
				},type:"post",
				success: function( List) {
							 $('#_IDHeader').load("/player.main.headerV3."+out);
							 if(List){
								 YoukuWs.listList();
							 }
						 }

			});
			//}}}
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).show();
			$("#_IDList .table-layer").center();

		});
		//}}}
		$("#_IDSkip").click(function(){
			YoukuWs.VideoAction("skip",CurrentVideoID);
			//{{{播放模式
			PlayType=0;
			YoukuWs.set("PlayType",PlayType);
			//}}}
			YoukuWs.playRadioNext();
		}).bt({icon:"ui-icon-seek-next",position:"left"});
		$("#_IDChange").click(function(){
			//换台模式
			$("#_RadioChannel ul").html("");
			$("#_RadioChannel .loading" ).show();
			$("#_RadioChannel").dg({
				width:400,height:300,title:"频道列表"
			});
			$.ajax({
				url: "/player.main.radioList",
				type:"post",
				success: function( result) {
					if(result && result.items){
						$("#_RadioChannel ul").html("");

						$("#_RadioChannel .loading" ).hide();
						for(var i=0;i<result.items.length;i++){
							var cid = YoukuWs.get("cid");
							var dsb ="";
							if(cid==result.items[i].ListID){
								dsb="class='disabled'";
							}else{
								dsb="";
							}
							$("#_RadioChannel ul").append("<li ><a "+dsb+" id='"+result.items[i].ListID+"'>"+result.items[i].ListName+"</a></li>");
						}
						$("#_RadioChannel .table-layer").center();
					}
				}
			});
		});
		$("#_IDDown").click(function(){
			if(YoukuWs.isLogin()){
				YoukuWs.VideoAction("down",CurrentVideoID);
				$("#_BtNext").trigger("click");
			}else{
				YoukuWs.login(function(){$("#_IDDown").trigger("click");});
			}
		});
		$("#_IDUp").click(function(){
			if(YoukuWs.isLogin()){
				YoukuWs.VideoAction("up",CurrentVideoID);
			}else{
				YoukuWs.login(function(){$("#_IDUp").trigger("click");});
			}
		});
		$("#_LiUp").live('click',function(){
			YoukuWs.listAction("up",1);
		});
		$("#_LiSkip").live('click',function(){
			YoukuWs.listAction("skip",1);
		});
		$("#_LiDown").live('click',function(){
			YoukuWs.listAction("down",1);
		});
		$("#_LiList").live('click',function(){
			window.listFlag=false;
			$("#_IDList").dg({
				width:550,height:320,title:"歌单列表",close:function(){}
			});
			YoukuWs.listList();
		});


		$("#_LiListen").live('click',function(){
			YoukuWs.listListen(1);
		});

		$("#_ContentListen >ul >li .add,#_ContentSearch >li .add").live('click',function(){
			var li =$(this).parentsUntil("li").parent();
			YoukuWsPlaylist.add(li.attr("vid"),li.attr("mvname"));
			$("#IDNav >li").eq(1).trigger("click");
		});


		//{{{
		//编辑模式
		var editmode=false;
		$("#_BtEditMode").click(function(){
			if(editmode==false){
				$("#_ContentMusic").removeClass("checkbox_hide");
				$("#_BtSelectAll").show();
				$("#_BtDeSelect").show();
				$("#_BtSaveAll").show();
				$("#_BtDelete").show();
				editmode=true;
			}else{
				$("#_ContentMusic").addClass("checkbox_hide");
				$("#_BtSelectAll").hide();
				$("#_BtDeSelect").hide();
				$("#_BtSaveAll").hide();
				$("#_BtDelete").hide();
				editmode=false;
			}
			return false;
		});
		//保存选择的音乐到歌单
		$("#_BtSaveAll").click(function(){
			if(YoukuWs.isLogin()){
				var selected =$("#_ContentMusic >li.select");
				if(selected.size()<=0){
					YoukuWs.tips("请先选择要保存的音乐");
					return;
				};
				YoukuWs.tips("请选择要保存歌单.");
				$.each(selected,function(i,item){
				});

				$("#_IDList").dg({
					width:550,height:320,title:"歌单列表"
				});
				window.listFlag=true;
				YoukuWs.listList(true);
			}else{
				YoukuWs.login(function(){$("#_BtSaveAll").trigger("click");});
			}
		});
		//删除
		$("#_BtDelete").click(function(){
			var selected =$("#_ContentMusic >li.select");
			if(selected.size()<=0){
				YoukuWs.tips("请先选择要删除的音乐");
				return;
			}
			$.each(selected,function(i,item){
				YoukuWsPlaylist.del($(item).attr("vid"));
				setTimeout(function() { $(item).remove(); }, 1);
			});
			YoukuWs.tips("成功删除!");
		});
		$("#_BtDelete,#_BtTrash2").droppable({
			activeClass: "",
			hoverClass: "icon_del_active",
			accept:"#_ContentMusic >li,#_ContentList >li",
			tolerance:"pointer",
			drop: function( event, ui ) {
				YoukuWsPlaylist.del(ui.draggable.attr("vid"));
				setTimeout(function() { ui.draggable.remove();YoukuWs.tips("成功删除!"); }, 1);//fro ie patch
			}
		});
		//全选
		$("#_BtSelectAll").click(function(){
			$("#_ContentMusic >li").addClass("select");
		});
		//反选
		$("#_BtDeSelect").click(function(){
			var all =$("#_ContentMusic >li");
			var selected =$("#_ContentMusic >li.select");
			all.addClass("select");
			selected.removeClass("select");
		});





		$("#_IDListMain .btn-play-s").live('click',function(){
			$("#_IDList").dgclose();
			YoukuWs.tips("添加歌曲中...");
			var li =$(this).parentsUntil("li").parent();
			YoukuWs.listContents(li.attr("lid"),true);
		});
		$("#_IDListMain .del").live('click',function(){
			var lid =$(this).parentsUntil("li").parent().attr("lid");
			var index=2;
			$("#_IDListTable td").hide();
			$("#_IDListTable td").eq(index).attr("lid",lid).show();
			$("#_IDList .table-layer").center();

		});


		$("#_IDListMain .editEdit").live("click",function(){
			var index=1;
			$("#_IDListTable td").hide();
			var li =$(this).parentsUntil("li").parent();
			$("#_IDListTable td").eq(index).attr("lid",li.attr("lid")).show();
			$("#_IDList .table-layer").center();

			$("#_IDListName").val(li.find("a").html());
			$("#_IDListComment").val(li.find(".comment").html());

		});

		$("#_IDListMain .editContent").live("click",function(){
			var li =$(this).parentsUntil("li").parent();
			var lid=li.attr("lid");
			url="/user.list.listContents?lid="+lid;
			page=1;
			delUrl="/user.list.delcontent?vid=:vid:&lid="+lid;
			saveSortUrl="/user.list.contentsorder?lid="+lid;

			YoukuWs.loadMusic(url,page,delUrl,saveSortUrl);

		});
		//删除
		$("#_CtMusicList .MusicRemove").live('click',function(){
			var li =$(this).parentsUntil("li").parent();
			var div = $(this).parentsUntil(".mylist-cont").parent();
			var delurl = $(div).attr("delurl").replace(/:vid:/,li.attr("vid"));
			setTimeout(function() {li.remove(); }, 1);
			$.ajax({
				url: delurl,type:"post",
				success: function( result) {
					$('#_IDHeader').load("/player.main.headerV3."+out);
				}
			});
		});
		//删除选中的全部
		$("#_CtMusicList #deleteAll").live('click',function(){
			//可以优化
			$(this).parentsUntil(".content").find(".select .remove").trigger("click");
			YoukuWs.listList();
		});
		//播放
		$("#_CtMusicList .MusicPlay").live('click',function(){
			PlayType=1;
			YoukuWs.set("PlayType",PlayType);
			$("#IDNav >a").eq(1).trigger("click");
			var li =$(this).parentsUntil("li").parent();
			YoukuWsPlaylist.add(li.attr("vid"),li.attr("mvname"));
			YoukuWs.play(li.attr("vid"));
		});
		$("#_CtMusicList li >.checkbox, #_ContentMusic li >.checkbox, #_IDListMain li >.checkbox").live("click",function(){
			var li =$(this).parent();
			if(li.hasClass("select"))li.removeClass("select");else li.addClass("select");
			return false;
		});
		$("#_CtMusicList #selectlAll").live('click',function(){
			var li =$(this).parentsUntil(".content").find("li").addClass("select");
		});
		$("#_CtMusicList #deselectAll").live('click',function(){
			var all =$(this).parentsUntil(".content").find("li");
			var selected =$(this).parentsUntil(".content").find(".select");
			all.addClass("select");
			selected.removeClass("select");
		});
		$("#_CtMusicList #playAll").live('click',function(){
			var selected =$(this).parentsUntil(".content").find(".select");
			var li;
			$.each(selected,function(i,item){
				li=$(item);
				YoukuWsPlaylist.add(li.attr("vid"),li.attr("mvname"));
			});
			if(li)YoukuWs.play(li.attr("vid"));
		});
		$("#_CtMusicList #addAll").live('click',function(){
			var selected =$(this).parentsUntil(".content").find(".select");
			var li;
			$.each(selected,function(i,item){
				li=$(item);
				YoukuWsPlaylist.add(li.attr("vid"),li.attr("mvname"));
			});
		});
		$("#_CtMusicList .pg-box > a").live('click',function(){
			var page = $(this).attr("page");
			var mylist =$(this).parentsUntil(".mylist-cont").parent();
			var delUrl = mylist.attr("delUrl");
			var saveSortUrl = mylist.attr("saveSortUrl");
			var url = mylist.attr('url');
			YoukuWs.loadMusic(url,page,delUrl,saveSortUrl);
		});


		$("#_ContentMusic >li").live('click',function(){
			//{{{播放模式
			PlayType=1;
			YoukuWs.set("PlayType",PlayType);
			//}}}
			var vid = $(this).attr('vid');
			YoukuWs.play(vid);
			YoukuWs.setTitle($(this).attr("mvname"));
			return false;
		});
		$("#_ContentListen >ul >li .name,#_ContentSearch >li .name").live('click',function(){
			//{{{播放模式
			var li = $(this).parent();
			PlayType=1;
			YoukuWs.set("PlayType",PlayType);
			//}}}
			var vid = li.attr('vid');
			YoukuWs.play(vid);
			YoukuWs.setTitle(li.attr("mvname"));
			return false;
		});

		//}}}
		$("#_IDLyricsPr").click(function(){
			lyrics_offset=parseInt(lyrics_offset)+1000;
			YoukuWs.tips("歌词已经提前1秒...");
			YoukuWs.saveOffset();
		});
		$("#_IDLyricsErr").click(function(){
			if(CurrentVideoID && CurrentVideoID>0){
				$.ajax({
					url: "/player.main.LyricsError",
					data: {
						VideoID:CurrentVideoID
					},
					success: function( result) {
								 YoukuWs.tips("已经提交错误报告，谢谢！");
							 }

				});
			}
		});
		$("#_IDLyricsView").click(function(){
			$("#_ContentLyricsView .swbox-cont").html($("#_ContentLyrics").html());
			$("#_ContentLyricsView").dg({
				width:400,height:300,title:"歌词信息"
			});
		});
		$("#_IDLyricsBk").click(function(){
			lyrics_offset=parseInt(lyrics_offset)-1000;
			YoukuWs.tips("歌词已经后退1秒...");
			YoukuWs.saveOffset();
		});
		//加载播放列表
		$("#_IDLogout").live("click",function(){
			$('#_IDHeader').load("/user.main.logoutV3");
		});
		$("#_IDSignup2").live("click",function(){
			$("#CtLogin").dgclose();
			$("#_IDSignup").trigger("click");
		});
		$("#_IDLogin").live("click",YoukuWs.login);
		$("#_IDLogin2").live("click",YoukuWs.login);
		$("#_IDUsage").live("click",function(){
			$("#_ContentUsage").dg({
				width:600,height:400,title:"帮助".tr()
			});
		});
		$("#_IDAbout").live("click",function(){
			$("#_ContentAbout").dg({
				width:360,height:180,title:"关于".tr()
			});
		});
		$("#_IDSignup").live("click",function(){
			$("#_ContentSignup").dg({ title:"注册",width:360,height:240 });
		});
		$("#_ContentMusic").sortable({
			stop:function(event,ui){
					 setTimeout("YoukuWsPlaylist.save()",200);

					 $("#drag-layer").hide();
				 },
			start:function(event,ui){
					  if(YoukuWs.isLogin()){
						  $("#_ContentList").show();
					  }else{
						  $("#_ContentList").hide();
					  }
					  if(YoukuWs.ListContent){
					  }else{
						  YoukuWs.listList();
					  }
					  $("#drag-layer").show();
				  }

		});
		$( "#_ContentList >li .load" ).live("click",function(){
			var lid = $(this).parents("li").attr("lid");
			YoukuWs.listContents(lid);
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
			if(PlayType==1){
				switch(parseInt(PlayMode)){
					case 1:
						YoukuWs.play(CurrentVideoID);
						break;
					case 2:
						YoukuWs.playPre();
						break;
					case 3:
						YoukuWs.playRandom(true);
						break;
				}
			}
		});
		$("#_BtNext").click(function(){
			if(PlayType==1){
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
				}
			}else{
				//{{{如果当前播放的不是 列表里的第一个音乐，
				
				 var o= window.radioPlayList[0];
				 if(o){
					 if(CurrentVideoID == o.VideoID){
						YoukuWs.playRadioNext();	
						return;
					 }
				}
				YoukuWs.playRadio();
				//}}}
			}
		});





		$("#PlayModeSet >a").click(function(){


			PlayMode = $(this).attr("playmode");

			$("#PlayModeSet >a").each(function(i,item){
				$(item).removeClass("select");
			});
			$(this).addClass("select");
			YoukuWs.set("PlayModeSet",PlayMode);
		});
		PlayMode = parseInt(YoukuWs.get("PlayModeSet"));
		if(!PlayMode || isNaN(PlayMode) || PlayMode<1 ||PlayMode>3){
			PlayMode=2;
		}

		if(PlayMode){

			$("#PlayModeSet >a").each(function(i,item){
				$(item).removeClass("select");
			});

			$("#PlayModeSet >a").each(function(i,item){

				var _playmode = $(item).attr("playmode");
				if(PlayMode==_playmode){
					$(item).addClass("select");
					return;
				}
			});
		}
		$("#_BtSearch").click(function(){
			search();
		});
		//模式切换
		$("#IDNav >a").click(function(){
			var _index = $("#IDNav >a").index(this);
			if(_index >=0 && _index<=1){
				PlayType = _index;
				YoukuWs.set("PlayType",PlayType);
			}

			//var _this = this;
			if(_index==2){
				pre_index=0;
				YoukuWs.LyricsInterval = setInterval(YoukuWs.checkTime,200);
			}else{
				clearInterval(YoukuWs.LyricsInterval);
			};
			$("#IDNav >a").each(function(i,item){
				//{{{ save scrollTop

				window._ContentMusicTop=window._ContentMusicTop?window._ContentMusicTop:0;
				if($("#_ContentMusic").scrollTop()>0){
					window._ContentMusicTop = $("#_ContentMusic").scrollTop();
				}
				//}}}

				var _for = $(item).attr("for");
				$("#"+_for).addClass("hide");

				$(item).removeClass("current");
			});
			var _for = $(this).attr("for");
			$("#"+_for).addClass("current");
			$("#"+_for).removeClass("hide");
			$(this).addClass("current");
			//{{{ restore scrollTop
			if(PlayType==1 && window._ContentMusicTop>0){
				$("#_ContentMusic").scrollTop(window._ContentMusicTop);
			}
			//}}}
		});
		$("#_BtAddMv").click(function(){
			$( "#_DialogAdd" ).dg({
				width:500,height:320
			});
		});
		$("#_AListAdd").click(function(){
			$("#_CtListAdd").toggle("fast");
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
		$(window).bind('hashchange', function() {
			if(_location.hash.replace("#","")==""){
				PlayType=0;
				YoukuWs.set("PlayType",PlayType);
				$("#IDNav >li").eq(0).trigger("click");
				YoukuWs.playRadio();
				return;
			}
			var _tmp={};
			_location.hash.replace(
				new RegExp( "([^#=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
					_tmp[ $1 ] = $3;
				}
				);
			if(!_tmp.vid)return;
			//判断不是不在播放列表内
			if(CurrentVideoID!=_tmp.vid){
				PlayType=1;
				YoukuWs.set("PlayType",PlayType);
				YoukuWs.play(_tmp.vid);
				$("#IDNav >li").eq(1).trigger("click");
			}
		});
		var objURL={};
		_location.search.replace(
				new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
					objURL[ $1 ] = $3;
				}
				);
		_location.hash.replace(
				new RegExp( "([^#=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
					objURL[ $1 ] = $3;
				}
				);
		if(window._initLid)objURL.lid = window._initLid;
		if(window._initVid)objURL.vid = window._initVid;
		if(objURL.lid){
			PlayType=1;
			YoukuWs.set("PlayType",PlayType);
			YoukuWs.listContents(objURL.lid);
		}else if(objURL.vid){
			PlayType=1;
			YoukuWs.set("PlayType",PlayType);
			YoukuWs.getVideoByVid(objURL.vid);
		};
		//{{{显示播放模式的内容
		PlayType = YoukuWs.get("PlayType",0);
		if(PlayType>2)PlayType=0;
		$.each(YoukuWsPlaylist.list(),function(i,n){
			var o = '<li vid="'+n.v+'"><span class="checkbox"></span><a>'+n.t+'</a></li>';
			$("#_ContentMusic").append(o);
		});

		$("#IDNav >a").each(function(i,item){
			var _for = $(item).attr("for");
			if(i==PlayType){
				$("#"+_for).addClass("current");
				$("#"+_for).removeClass("hide");
				$(item).addClass("current");
			}else{
				$("#"+_for).removeClass("current");
				$("#"+_for).addClass("hide");
				$(item).removeClass("current");
			}
		});


		//}}}
		CurrentVideoID= YoukuWs.get("CurrentVideoID");
		if(PlayType==0){
			YoukuWs.playRadio();
		}else{
			if(YoukuWs.get("CurrentVideoID")){
				var time = YoukuWs.get("time",0);
				YoukuWs.play(YoukuWs.get("CurrentVideoID"),time);
			};
		}
		YoukuWs.autoLogin();

	});
	$("#keywords").ready(function(){
		$("#keywords").change(function(){
			YoukuWs.set("keywords",$("#keywords").val());
		});
		$("#keywords").keydown(function(event){
			if(event.keyCode==13){  
				$("#_BtSearch").trigger("click");
			}
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
							   response( $.map( result, function( item ) {
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
			var c = '<p time="'+gc[k].t+'" id="_ID'+k+'">'+gc[k].w+'</p>';
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
		str=str.replace(/\\/g,"");
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

	var isSupportLocalStorage = !!window.localStorage, isSupportBehavior = false;
	var configs = {
		storeName: 'editorContent'
	};
	return {
		play:function(vid,time){
				 //fix other used
				 if(document.getElementById("playerBox")==null)return;
				 if(!time)time=0;
				 if(!vid)return;
				 showLyric("");
				 pre=PlayType==0?0:1;
				 $("#_IDPause").show();
				 $("#_IDPlay").hide();
				 next=1;
				 CurrentVideoID=vid;
				 YoukuWs.set("CurrentVideoID",CurrentVideoID);
				 //获取曲库信息
				 $("#musicInfo").html("&nbsp;");
				 $.ajax({
					 url: "/player.main.getMusic",
					 data: { vid:vid }, global:false,
					 success: function( result) {
						 if(result){
							 var singer="";
							 var tmp=[];
							 var t_tmp=[];
							 if(result.Singers){
								 singer="歌手".tr()+":";

								 for(var i in result.Singers){
									 tmp.push("<a class='singer' id='"+result.Singers[i].SingerID+"'>"+result.Singers[i].SingerName+"</a>");
									 t_tmp.push(result.Singers[i].SingerName);
								 }
								 singer+=tmp.join(" / ");
							 }
							 if(result.AlbumID && result.AlbumName)
					 $("#musicInfo").html(singer+" "+"专辑".tr()+":<a class='special' id='"+result.AlbumID+"'>"+result.AlbumName+"</a>");
							 else
					 $("#musicInfo").html(singer);

							 $("#musicInfo").slideDown("fast");
							 //设置title
							 var title=""; if (t_tmp.length>0) title=t_tmp.join(" / ")+" - ";
							 YoukuWs.setTitle(title+result.VideoName);
						 }else{
							 $("#musicInfo").slideUp("fast");
						 }
					 },
					 error:function(){
							   $("#musicInfo").slideUp("fast");
						   }
				 });
				 //下载歌词
				 $.ajax({
					 url: "/player.main.getLyric",
					 data: {
						 vid:vid
					 },global:false,
					 success: function( result) {
								  if(result){
									  if(result.LyricsContent && result.LyricsContent!=""){
										  showLyric(result.LyricsContent);
										  lyrics_offset = parseInt(result.LyricsOffset);
										  $("#_IDLyricsAdmin").fadeIn("slow");
									  }else{
										  //显示没有歌词
										  $("#_IDLyricsAdmin").fadeOut("slow");
									  }
									  //如果这歌词是这个用户的，可以编辑
									  if(result.UserID==YoukuWs.uid) {
										  $("#_IDLyricsEd").fadeIn("slow");
									  }else{
										  $("#_IDLyricsEd").fadeOut("slow");
									  }
								  }
							  }
				 });
				 if(this.isIpad()){
					 var video = document.getElementById(playerId);
					 var src="http://v.youku.com/player/getM3U8/vid/"+vid+"/type/mp4/v.m3u8";
					 if(!video.src){
						 $("#playerBox").html('<video x-webkit-airplay="allow" id="'+playerId+'" style="width:100%;height:100%" src="'+src+'" controls="controls" autoplay=true></video>');
						 video = document.getElementById(playerId);
						 video.addEventListener('play', 	onPlayerStart, false);
						 video.addEventListener('ended', onPlayerComplete, false);
						 video.addEventListener('error', onPlayerError, false);
						 //this.video.addEventListener('loadedmetadata', onLoadedmetadata, false);
						 //this.video.addEventListener('ended', onEnded, false);
						 //this.video.addEventListener('timeupdate', onTimeUpdate, false);
						 //this.video.addEventListener('error', onError, false);
						 //$("#"+playerId).addEventListener('play', onPlay, false);
						 video.addEventListener('pause', onPause, false);
						 //this.video.addEventListener('volumechange', onVolumechange, false);
						 //this.video.addEventListener('playing', onPlaying, false);
						 //this.video.addEventListener('loadstart', onLoadstart, false);
						 ////this.video.addEventListener('seeked', onSeeked, false);
						 ////this.video.addEventListener('seeking', onSeeking, false);
						 ////this.video.addEventListener('waiting', onWaiting, false);
						 //this.video.addEventListener('abort', onAbort, false);
						 //this.video.addEventListener('progress', onProgress, false);
					 }else{
						 video.src=src;
					 }
					 //{{{for ipad hack code
					 video.load();
					 if(document.createEvent){
						 evt = document.createEvent("MouseEvents");
						 var evt;
						 if (evt.initMouseEvent) {
							 evt.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
							 video.dispatchEvent(evt);
						 }
					 }
					 video.play();
					 //}}}
				 }else{
					 //debug;
					 // return "";
					 try{
						 PlayerReplay(vid);
					 }catch(e){
						 
						//if(swfobject.ua.safari) par.wmode="opaque";
						 //swfobject.createSWF({data:"http://static.youku.com/v/swf/player.swf",width:"100%",height:"100%"},{allowFullScreen:true,allowscriptaccess:"always",wmode:"transparent",flashvars:"isAutoPlay=true&VideoIDS="+vid+"&winType=popup&ad=0&skincolor1=3F3F3F&skincolor2=3F3F3F&firsttime="+time},playerId);
						 swfobject.createSWF({data:"http://static.youku.com/v/swf/player.swf",width:"100%",height:"100%"},{allowFullScreen:true,allowscriptaccess:"always",wmode:"opaque",flashvars:"isAutoPlay=true&VideoIDS="+vid+"&winType=index&ad=0&skincolor1=3F3F3F&skincolor2=3F3F3F&firsttime="+time},playerId);
					 }
				 }
				 if(PlayType!=0){//非收听模式
					 //{{{
					 var t = 0;
					 var o = $("#_ContentMusic [vid='"+vid+"']");
					 if(!o)return;
					 var p = o.position();
					 if(!p)return;
					 t = p.top+o.outerHeight()-o.parent().height();
					 var offset = 52; //偏移修正，比较无语
					 t -= offset;
					 if(t>0){
						 t = o.parent().scrollTop() + p.top+o.height()-o.parent().height(); //432
						 t -= offset;
						 o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
						 });
					 }else if( t<0-(o.parent().height()-o.outerHeight())){
						 t = (o.parent().scrollTop()+p.top);
						 t -= offset;
						 o.parent().animate({scrollTop:t+"px"},"slow","linear",function(){
						 });
					 }
					 //}}}
					 $("#_ContentMusic >li").removeClass("current");
					 o.addClass('current');
					 YoukuWs.setTitle($("#_ContentMusic [vid='"+vid+"'] A").html());
					 _location.hash="vid="+vid;
				 }else{
					 _location.hash="";
				 }
			 },checkTime:function(){
				 if(!o_lyrics){
					 o_lyrics = $('#_ContentLyrics');
				 }
				 var LyricTop = $("#_LyricsTop");
				 //var time="";
				 // YoukuWs.tips("D");
				 if(YoukuWs.isIpad()){
					 var video = document.getElementById(playerId);
					 if(video!=null){
						 playTime.time= video.currentTime;
					 }else{
						 return;
					 }
				 }else{
					 var r= PlayerInfo();
					 if(!r){
						 LyricTop.hide();
						 return;
					 }
					 time = isNaN(r.time)?0:r.time;
				 }
				 var l = getLyric(playTime.time*1000+parseInt(lyrics_offset));
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
				 var t = LyricCurrent.position().top + $("#_ContentLyrics").scrollTop()- 160;
				 LyricTop.show();
				 $("#_ContentLyrics .current").removeClass("current");
				 o_lyrics.animate({scrollTop:t+"px"},"fast","linear",function(){
					 if(LyricCurrent.html().replace("&nbsp",'')!=""){
						 var t2 = LyricCurrent.position().top;
						 LyricTop.animate({"top":t2+"px"},"fast");
						 LyricTop.animate({
							 "height":LyricCurrent.height()+"px"
						 },"fast");
						 LyricCurrent.addClass("current");
					 }
				 });

			 }, getVideoName:function(Video){
				 var mvname="";
				 var names=[];
				 if(Video.Singers){
					 for(var j in Video.Singers){
						 names.push(Video.Singers[j].SingerName);
					 }
					 mvname=names.join("/")+" - ";
				 }
				 return  mvname+=Video.VideoName;
			 }, _realPlayRadio:function(){
				 var o= window.radioPlayList[0];

				 $("#_IDRadio3").hide();
				 $("#_IDRadio2").show();
				 if(o){
					 //队列里有数据
					 CurrentVideoID= o.VideoID;
					 $("#_IDVideoTitle").html(YoukuWs.getVideoName(o));
					 $("#_IDVideoPic").attr("src",o.VideoThumb);
					 YoukuWs.set("CurrentVideoID",CurrentVideoID);
					 YoukuWs.play(o.VideoID);
					 YoukuWs.setTitle(YoukuWs.getVideoName(o));
				 }
				 if(window.radioPlayList[1]){
					 $("#_IDNextVideoTitle").html(YoukuWs.getVideoName(window.radioPlayList[1]));
					 $("#_IDNextVideoPic").attr("src",window.radioPlayList[1].VideoThumb);
				 }
			 }, playRadioNext:function(){
				 window.radioPlayList.shift();
				 YoukuWs.playRadio();
			 }, playRadio:function(){
				 //获取当前队列的数据，如果为空就从服务器取
				 if(window.radioPlayList.length<2){
					 YoukuWs.loadRadio(true);
				 }else{
					 YoukuWs._realPlayRadio();
				 }
			 },loadRadio:function(play){
				 $.ajax({
					 url: "/player.main.radio",
				 data: {
					 cid:YoukuWs.get("cid"),
				 vid:CurrentVideoID,
				 length:window.radioPlayList.length
				 },
				 success: function( result) {
							  if(result && result.items){
								  YoukuWs.set("cid",result.cid);
								  window.radioPlayList=window.radioPlayList.concat(result.items);
								  if(play)YoukuWs._realPlayRadio();


								  if(window.radioPlayList[0]){
									  $("#_IDVideoTitle").html(YoukuWs.getVideoName(window.radioPlayList[0]));
									  $("#_IDVideoPic").attr("src",window.radioPlayList[0].VideoThumb);
								  }
								  if(window.radioPlayList[1]){
									  $("#_IDNextVideoTitle").html(YoukuWs.getVideoName(window.radioPlayList[1]));
									  $("#_IDNextVideoPic").attr("src",window.radioPlayList[1].VideoThumb);
								  }


							  }
						  }
				 });
			 },playRandom:function(pre){
				 if(randMusicList.length!=$('#_ContentMusic li').size()){
					 randMusicList=[];
					 $('#_ContentMusic li').each(function(i,n){
						 randMusicList.push($(n).attr("vid"));
					 });
					 randMusicList.sort(function(){return (Math.round(Math.random())-0.5);});
				 }
				 var vid ="";
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
			 }, playNext:function(){
				 /*播放下一个*/
				 if(parseInt(PlayMode)==3)return YoukuWs.playRandom();
				 var vid = $("#_ContentMusic [vid='"+CurrentVideoID+"']").next().attr("vid");
				 if(!vid){
					 vid = $("#_ContentMusic li").first().attr("vid");
				 }
				 if(vid)YoukuWs.play(vid);
			 }, playPre:function(){
				 /*播放上一个*/
				 if(parseInt(PlayMode)==3)return YoukuWs.playRandom(true);
				 var vid = $("#_ContentMusic [vid='"+CurrentVideoID+"']").prev().attr("vid");
				 if(!vid){
					 vid = $("#_ContentMusic li").last().attr("vid");
				 }
				 if(vid)YoukuWs.play(vid);
			 }, setTitle:function(t){
				 if(!t)return;
				 var t = t.replace(/<[^>]+>/g,"");
				 this.title = t;
				 if(t)$("#title").html("正在播放".tr()+":"+t);
				 if(t)document.title="YouKu.FM - "+t;
			 }, VideoAction:function(type,vid){
				 $.ajax({
					 url: "/player.main.VideoAction/"+type+"."+vid,
				 success: function( result) {
					 if(result&&result.type){
						 if(YoukuWs.isLogin()){
							 if(result.result){
								 if(result.record){
									 switch(result.type){
										 case "down":$("#_CtDown").html(parseInt($("#_CtDown").html())+1);
													 YoukuWs.tips("添加成功!");
													 break;
										 case "up":$("#_CtUp").html(parseInt($("#_CtUp").html())+1);
												   YoukuWs.tips("添加成功!");
												   break;
										 case "skip":$("#_CtSkip").html(parseInt($("#_CtSkip").html())+1);
													 break;
									 }
								 }else{
									 YoukuWs.tips("已经添加过了!");
								 }
							 }
						 }
					 }
				 }

				 });
			 }, get:function(k,defaultValue,isCookie){
				 var r=null;
				 if(isCookie){
					 if($.cookie(k))r = $.cookie(k);
				 }else{
					 if(isSupportLocalStorage){
						 r = window.localStorage.getItem(k);
					 }else{
						 if($.cookie(k))r = $.cookie(k);
					 }
				 }
				 return r?r:defaultValue;
			 }, set:function(k,v,isCookie){
				 if(isCookie){
					 $.cookie(k,v,{expires:40,path:"/"});
				 }else{
					 if(isSupportLocalStorage){
						 window.localStorage.setItem(k, v);
					 }else{
						 $.cookie(k,v,{expires:40});
					 }
				 }
				 return true;
			 }, adReload:function(){
				 if($.browser.mozilla){
					 return;
				 }
				 var a=$("#googlead").html();
				 $("#googlead").html("");
				 $("#googlead").html(a);
			 },saveOffset:function(){
				 if(CurrentVideoID>0 && uid>0){
					 $.ajax({
						 url: "/player.main.saveoffset",
						 data: {
							 VideoID:CurrentVideoID,
						 offset:lyrics_offset
						 },
						 success: function( result) {
								  }

					 });
				 }
			 },isLogin:function(){
				 return YoukuWs.get("uid",0,true);
			 },formlogin:function(){
				 $.post("/user.main.login",$("#_FormLogin").serialize(),function(data){
					 if(data && data.result==1){
						 $('#_IDHeader').load("/player.main.headerV3."+out);
						 $("#CtLogin").dgclose();
						 $("#_FormLogin .msgbox").hide();
						 //登录成功
					 }else{
						 //登录失败
						 $("#_FormLogin .msgbox").show().find("span").html("登录失败，用户名或者密码错").slideDown("fast");
						 setTimeout(function() { 
							 $("#_FormLogin .msgbox").slideUp("fast");
						 }, 3000);
					 }
				 },"json");
				 return false;
			 },formsignup: function() {
				 $.post("/user.main.signup",$("#_FormSignup").serialize(),function(data){
					 if(data.uid){
						 //注册成功
						 $('#_IDHeader').load("/player.main.headerV3."+out);
						 $("#_ContentSignup").dgclose();
					 }else{
						 //$("#_FormSignup .info").show();
						 $("#_ContentSignup .msgbox").show().find("span").html(data.info).slideDown("fast");
						 setTimeout(function() { 
							 $("#_ContentSignup .msgbox").slideUp("fast");
						 }, 3000);
					 }
				 },"json");
				 return false;
			 },showList:function(flag){
				 var li="";
				 var li_2="";//快速添加音乐入口
				 var li_index=0;
				 for(var i in YoukuWs.ListContent){
					 list = YoukuWs.ListContent[i];
					 li+='<li lid="'+list.ListID+'" ord="'+list.ListOrder+'"><span class="checkbox hide"></span>';
					 li+='<h2><a  title="">'+list.ListName+'</a><span>('+list.ListCount+')</span><a title="" class="btn-play-s"></a></h2>';
					 li+='<p>最后更新：<span>'+list.ListUpdateTime+'</span></p>';
					 li+='<p class="comment">'+list.ListComment+'</p>';
					 li+='<div class="edit"><a class="del" title="删除">删除</a><a class="editEdit" title="编辑">编辑</a><a class="editContent" title="整理歌曲">整理歌曲</a></div>';
					 li+='</li>';
					 if(li_index++<=3){
						 li_2 +='<li lid="'+list.ListID+'" ord="'+list.ListOrder+'">';
						 li_2 +='<a title="">'+list.ListName+'('+list.ListCount+')</a>';
						 li_2 +='</li>';
					 }

				 }
				 $("#_ContentList ul").html(li_2);//快速添加音乐入口
				 $("#_IDListMain ul").html(li);
				 $("#_IDList .table-layer").center();
				 if(window.listFlag){
					 $("#_IDListMain ul .checkbox").show();
					 $("#_BtListSave").show();
				 }else{
					 $("#_IDListMain ul .checkbox").hide();
					 $("#_BtListSave").hide();
				 }
				 $("#_IDListMain ul").sortable({
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
								  success: function( result) {
											   //应该修改当前的ord值
											   for(var i in  order){
												   $("#_IDListMain ul >li[lid="+order[i].lid+"]").attr("ord",order[i].order);
											   }
										   }
							  });
						  }

				 });
				 $( "#_ContentList >ul >li" ).droppable({
					 accept:"#_ContentMusic >li,#_ContentSearch >li",
					 activeClass: "",
					 hoverClass: "hover",
					 tolerance:"pointer",
					 drop: function( event, ui ) {
						 //TODO移动到另一个列表
						 var lid=$(this).attr("lid");
						 if(!lid)return;
						 $.ajax({
							 url: "/user.list.addContents",
							 data: {
								 lids:lid,
							 vids:$(ui.draggable).attr("vid")
							 },type:"post",
							 success: function( List) {
										  $("#_IDListDialogAdding").hide();
										  if(List){
											  YoukuWs.listList();
											  YoukuWs.tips("保存成功.");
										  }else{
											  YoukuWs.tips("歌单里已经有了，不要贪心哦.");
										  }
									  }

						 });
					 }
				 });


			 },login:function(callback){
				 $("#CtLogin").dg({ width:340,height:220,close:function(){
					 if(YoukuWs.isLogin() && callback && typeof(callback)=="function")callback();
				 }
				 });
			 },autoLogin:function(){
				 if(this.get("token","",true) && this.get("uid","",true)){
					 $.post("/user.main.autologin","token="+this.get("token")+"&uid="+this.get("uid"),function(data){
						 if(data){
							 $('#_IDHeader').load("/player.main.headerV3."+out);
							 //登录成功
						 }
					 },"json");
				 }
			 },loadMusic:function(url,page,delUrl,saveSortUrl){
				 /*
					url,加载的歌曲地址 "/player.main.listListen.:page:",
					delUrl,删除的地址,如果为空，就表示不删除
					saveSortUrl 保存排序结果的地址

					列表：
					不喜欢，喜欢，听过，（删除，播放，调序，拖动）
					歌单，（删除，播放，调序，拖动，）
					搜索（播放，调序，拖动）
				  */
				 var	real_url = url.replace(/:page:/,page);

				 $("#_CtMusicList").dg({width:500,height:300,title:"听过的MV"});
				 $("#_CtMusicList .loading" ).show();
				 //$("#_CtMusicList .mylist-cont" ).html('<div style="text-align:center;padding:10px"><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> 正在加载中...</div>');
				 $("#_CtMusicList .mylist-cont" ).attr("url",url);
				 $("#_CtMusicList .mylist-cont" ).attr("delUrl",delUrl);
				 $("#_CtMusicList .mylist-cont" ).attr("saveSortUrl",saveSortUrl);
				 $.ajax({
					 url: real_url,
					 success: function( result) {
						 $("#_CtMusicList .loading" ).hide();
						 var li="";
						 var ti='';
						 var od="";
						 if(saveSortUrl)ti='title="拖动可以排序哦"';
						 for(var i=0;i<result.items.length;i++){
							 var mvname=YoukuWs.getVideoName(result.items[i]);
							 if(result.items[i].MvOrder) od = 'order="'+(result.items[i].MvOrder)+'"';
							 li+='<li '+od+' _type="listen" '+ti+' mvname="'+mvname+'" vid="'+result.items[i].VideoID+'">'
					 li+='<span class="checkbox"></span><p>'+mvname+'</p>';
				 li+='<span>';
				 if(delUrl)li+='<a title="" class="btn-c MusicRemove"><i class="remove"></i></a>';
				 li+='<a class="btn-c MusicPlay"><i class="play"></i></a></span></li>';
						 }
						 //{{{ pager
						 var pager='';
						 if(result.totalPage>1){
							 result.page = parseInt(result.page);
							 pager='<div class="pg-box">';
							 if(result.page>1)pager+='<a class="fl" page="'+(result.page-1)+'" title="上一页">上一页</a>';else pager+='<i>上一页</i>';
							 for(var i=4;i>=1;i--){
								 if(result.page - i >0){
									 pager+='<a page="'+(result.page-i)+'">'+(result.page-i)+'</a>';
								 }
							 }
							 pager += '<i>'+result.page+'</i>';
							 for(var i=1;i<=4;i++){
								 if(result.page + i < result.totalPage){
									 pager+='<a page="'+(result.page+i)+'">'+(result.page+i)+'</a>';
								 }
							 }
							 if(result.page<result.totalPage)pager+='<a class="fl"  page="'+(result.page+1)+'"title="下一页">下一页</a></div>';else pager+='<i>下一页</i>';
						 }
						 //}}}
						 $("#_CtMusicList .mylist-cont" ).html('<ul class="mvlist">'+li+'</ul><div class="pages">'+pager+'</div>');
						 //{{{ action
						 var action="";
						 action+='<a title="" id="selectlAll" class="btn-layer-d">全选</a>';
						 action+='<a title="" id="deselectAll" class="btn-layer-d">反选</a>';
						 action+='<a title="" id="addAll" class="btn-layer-d">添加</a>';
						 action+='<a title="" id="playAll" class="btn-layer-d">播放</a>';
						 if(delUrl)action+='<a  title="" id="deleteAll" class="btn-layer-d">删除</a>';
						 //action+='<a  title="" class="btn-layer-d big">添加歌曲</a>';
						 //action+='<a  title="" class="btn-layer-d big icon ret"><i class="l"></i>返回</a>';
						 $("#_CtMusicList .singleBtn" ).html(action);
						 //}}}
						 if(saveSortUrl)$(".mvlist").sortable({
							 stop:function(event,ui){
									  var order=[];
									  $(this).find("li").each(function (index, domEle) { 
										  // lid = $(domEle).attr("lid");
										  if(index!=$(domEle).attr("order")){
											  var o={order:index,vid:$(domEle).attr("vid")};
											  order.push(o);
										  }
									  });
									  if(order.length==0)return;
									  $.ajax({
										  url: saveSortUrl,//"/user.list.contentsorder",
										  type:"POST",
										  data: {
											  order:order//,lid:lid
										  },
										  success: function( result) {
													   //应该修改当前的ord值
													   for(var i in  order){
														   $("#_CtMusicList .mylist-cont >ul >li[vid="+order[i].vid+"]").attr("order",order[i].order);
													   }
												   }
									  });
								  }
						 });
						 $("#_CtMusicList .table-layer").center();
					 }
				 });
			 },showMusicBox:function(result){

			 },listListen:function(page){
				 var delUrl="/player.main.delListen?vid=:vid:";
				 YoukuWs.loadMusic('/player.main.listListen.:page:',page,delUrl);
			 }, listAction:function(action,page){

				 var delUrl="/player.main.delActionV3."+action+"?vid=:vid:";
				 YoukuWs.loadMusic("/player.main.listAction."+action+".:page:",page,delUrl);
			 }, listList:function(flag){
				 $.ajax({
					 url: "/user.list.list",
				 success: function( result) {
					 if(result && result.items && result.items.length>0){
						 YoukuWs.ListContent=new Array();
						 YoukuWs.ListContent = result.items;
						 YoukuWs.showList(flag);
					 }
				 }
				 });

}, listContents:function(lid,autoPlay){
	$.ajax({
		url: "/user.list.listContents",
		data:{lid:lid},
		success: function( result) {
			if(result && result.items && result.items.length>0){
				YoukuWsPlaylist.addArray(result.items);
				if(!YoukuWs.get("CurrentVideoID") || autoPlay==true){
					YoukuWs.play(result.items[0].VideoID);
				};
			}

		}

	});
}, getVideoByVid:function(vid){
	$.ajax({
		url: "/player.main.getVideoByVid",
		data:{vid:vid},
		success: function( result) {
			YoukuWsPlaylist.add(result.VideoID,YoukuWs.getVideoName(result));
			YoukuWs.play(result.VideoID);
		}
	});
}, isIpad:function(){
	if(
			(navigator.userAgent.indexOf('iPod') != -1) ||
			(navigator.userAgent.indexOf('iPhone') != -1) ||
			(navigator.userAgent.indexOf('iPad') != -1)
	  ){
		return true;
	}
	return false;
}, tips:function(v,hold,replace){
	if(replace){
		$("#IDTips ul li").last().slideUp("fast");
	}
	var h=''
		var id="_ID"+(new Date()).getTime()+"_"+parseInt(Math.random()*10000);
	if(hold)h='<span class="x">X</span>';
	var info='<li id="'+id+'"><a><span>'+v+' </span>'+h+'</a></li>';
	$("#IDTips ul").append(info);
	if(!hold){
		setTimeout(function() { 
			$("#IDTips #"+id).remove();

		}, 2000);
	}
	$("#IDTips #"+id).click(function(){
		$(this).remove();
	});
},flag:flag
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
			m.v = arr[i].VideoID;
			m.t = YoukuWs.getVideoName(arr[i]);
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
				var html = '<li vid="'+m.v+'"><span class="checkbox"></span><a>'+m.t+'</a></li>';
				content.append(html);
				isappend=true;
			}
		};
		if(isappend){
			var t = 0;
			var o = $("#_ContentMusic [vid='"+m.v+"']");
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
	o.add=function(vid,title){
		YoukuWsPlaylist.addArray([{VideoID:vid,VideoName:title}]);
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
			m.VideoID= o.attr("vid");
			m.VideoName= o.find("a").html();
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
var radioPlayList=[];
function onPlayerStart(obj){
	if(YoukuWs.isLogin()){
		$.ajax({type:"POST",url:"/player.main.addListen",data:{"vid":CurrentVideoID},success:function(msg){
			if(msg){
				$("#_CtListen").html(parseInt($("#_CtListen").html())+1);
			}
		}
		});
	}

	$("#_IDPause").show();
	$("#_IDPlay").hide();
	//PlayerColor("000000","4F4F4F",25);
}
function onPause(){
	PlayerPause(true);
}
function onPlayerError(vid){
	if(PlayType!=0){
		YoukuWs.playNext();
		var h = $("#_ContentMusic [vid='"+vid+"'] A[error!=1]");
		h.attr("error",1);
		h.html("<font color='red'>播放失败:</font> "+h.html());
	}else{
		YoukuWs.playRadioNext();
	}
	//PlayerColor("000000","4F4F4F",25);
}
function onPlayerComplete(obj){
	if(PlayType==0){
		YoukuWs.playRadioNext();
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
var movieObject=[];
function _player(moviename) {
	//	if(movieObject[moviename])return movieObject[moviename];
	if (navigator.appName.indexOf("Microsoft") != -1){
		movieObject[moviename] = window[moviename?moviename:playerId];
	}else{
		movieObject[moviename] = document[moviename?moviename:playerId];
	}
	return movieObject[moviename];
};
function PlayerColor(bgcolor,gracolor,trans){
	try{
		return _player().setSkinColor(bgcolor,gracolor,trans);
	}catch(e){
		setTimeout("PlayerColor('"+bgcolor+"','"+gracolor+"','"+trans+"')",100);
	}
};
function PlayerReplay(vid){
	_player().playVideoByID(vid);
};
function PlayerPause(flag){
	if(YoukuWs.isIpad()){
		var video = document.getElementById(playerId);
		if(flag){
			$("#_IDPause").hide();
			$("#_IDPlay").show();
			video.pause();
		}else{
			$("#_IDPause").show();
			$("#_IDPlay").hide();
			video.play();
		}
	}else{
		try{
			_player().pauseVideo(flag);
			if(flag){
				$("#_IDPause").hide();
				$("#_IDPlay").show();
			}else{
				$("#_IDPause").show();
				$("#_IDPlay").hide();
			}
		}catch(e){
		}
	}
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
		YoukuWs.playRadioNext();
	}else{
		YoukuWs.playNext();
	}
}
//}}}
//FOR IPAD PATCH
var adCheck=0;//后贴检测
var playTime={time:0,alltime:0};
(function($){ 
	if(YoukuWs.isIpad()){
	}
	//{{{
	function getPlayTime(){												  
		var r= PlayerInfo();
		if(r){
			var time =playTime.time = isNaN(r.time)?0:r.time;
			var alltime= playTime.alltime = isNaN(r.alltime)?0:r.alltime;
			if(time>0 && alltime>0 && adCheck==time && Math.ceil(time)>=alltime){
				//先不跳过广告
				//onPlayerComplete({});
			}else{
			}
			adCheck=time;
		}

	}
	setInterval(getPlayTime,200);
	//}}}
})(jQuery);
