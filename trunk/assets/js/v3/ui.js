(function($){
	$.fn.bt = function(options){
		var defaults = {position:"left"}; 
		var options = $.extend(defaults, options); 
		this.each(function(item){ 
			var t = $(this);
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
			var	html2='<span class="bt_b"><span class="bt_c">&nbsp;</span> <span class="bt_d">'+html+'</span> </span>';
			//}
			t.html(html2);
			if(!t.hasClass("bt"))t.addClass("bt");
			t.attr("bt_set",true);
			t.attr("href","javascript:void(0);");
		}); 
		return this;
	}; 
})(jQuery); 

jQuery.extend(String.prototype, { tr:function(){
	if(window.locale!==undefined && window.locale[this]){
		return window.locale[this];
	}
	return this;
}
});





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
				var html = '<li vid="'+m.v+'"><a>'+m.t+'</a></li>';
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

var YoukuWs = function(){
	var fullScreen=false;
	var o_lyrics;
	var gc= new Array();
	var lyrics_offset=0;
	//�û�ID
	var uid=1;
	var LyricsInterval=0;
	var flag=true;
	var title="";
	var order=[];
	$(document).ready(function(){
		$("#_IDLyricsAdmin >a").bt();
		//{{{
		if (!$.support.borderRadius){
			$('#box').corner("tr tl 8px");
			$("#_IDRight").corner("tr br 8px");
		}
		//}}}

		//{{{���̿�ݼ���
		/*
		   ��/�� Up��		��һ��
		   ��/�� Down��	��һ��
		   �ո� Space:		����/��ͣ
		 */

		$(document).keydown(function(e){
			var name 	= e.target.nodeName.toLowerCase();
			if( name !== "input" && name !== "textarea" && name !=="button" && !e.altKey && !e.ctrlKey ) {
				switch(e.which){
					case 38://��
						//ֻ�в���ģʽ�²�����һ��
						if(PlayType==1){
							$("#_BtPre").trigger("click");
						}
						break;
					case 40://��
						if(PlayType==0){
							$("#_IDSkip").trigger("click");
						}else{
							$("#_BtNext").trigger("click");
						}
						break;
					case 37://��
						var li=$("#IDNav >li");
						var i =li.index($("#IDNav .current"));
						i = i>=1?i-1:li.size()-1;
						$("#IDNav >li").eq(i).trigger("click");
						break;
					case 39://��
						var li=$("#IDNav >li");
						var i =li.index($("#IDNav .current"));
						i = i>li.size()-i?0:i+1;
						$("#IDNav >li").eq(i).trigger("click");
						break;
					case 32://Space
						PlayerPause(YoukuWs.flag);
						YoukuWs.flag=!YoukuWs.flag;
						break;
					case 13://Enter
						$("#_IDThx").trigger("click");
						break;
					case 46://Del
						if(PlayType==0){
							$("#_IDDown").trigger("click");
						}else{
							$("#_BtTrash").trigger("click");
						}
						break;
				}
			}
			//	$("#IDInfo").html(e.currentTarget +":"+e.target.nodeName+":"+e.which +":"+e.keyCode);
		});
		//}}}
		//��̨��ť
		$("#_RadioChannel button").live("click",function(){
			$("#_RadioChannel").dialog("close");
			YoukuWs.set("cid",$(this).attr("id"));
			window.radioPlayList=new Array();
			//��̨������Ҫ������Ӧ 
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
		//������Ϣ���
		$("#musicInfo .singer").live("click",function(){
			$("#_ContentListen DIV").html("");
			$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');
			$("#_ContentListen").dialog({
				title:"����".tr()+" MV",width:400,height:300, buttons: [
			{
				text:_LabelOk,
				click: function() {
					$("#_ContentListen").dialog("close");
				}
			}
			]
			});
			$.ajax({
				url: "/player.main.getSinger",
				data: { sid:$(this).attr("id")},
				success: function( result) {
					if(result){
						var o = $("#_ContentListen >ul");
						o.html("");
						for(var i=0;i<result.items.length;i++){
							var mvname=YoukuWs.getVideoName(result.items[i]);
							var html='<li title="����϶����ұ߲����б�" mvname="'+mvname+'" vid="'+result.items[i].VideoID+'">'+
				'<span class="left name" title="�������:'+mvname+'">'+mvname+'</span>'+
				'<span class="right">('+ result.items[i].VideoPubdate+") "+timeFormat(result.items[i].VideoDuration)+' <img title="�����ӵ������б�" class="add" src="/assets/images/style2/plus.png" style="vertical-align:top"></span>'+
					'<div class="clear"></div>'+
					'</li>';
					o.append(html);
					}
					}
					}
					});
				});
			$("#musicInfo .special").live("click",function(){
				$("#_ContentListen DIV").html("");
				$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');
				$("#_ContentListen").dialog({
					width:400,height:300,title:"ר��".tr()+" MV", buttons: [
				{
					text:_LabelOk,
					click: function() {
						$("#_ContentListen").dialog("close");
					}
				}
				]
				});
				$.ajax({
					url: "/player.main.getAlbum",
					data: { sid:$(this).attr("id")},
					success: function( result) {
						if(result){
							var o = $("#_ContentListen >ul");
							o.html("");
							for(var i=0;i<result.items.length;i++){
								var mvname=YoukuWs.getVideoName(result.items[i]);
								var html='<li title="����϶����ұ߲����б�" mvname="'+mvname+'" vid="'+result.items[i].VideoID+'">'+
					'<span class="left name" title="�������:'+mvname+'">'+mvname+'</span>'+
					'<span class="right">('+ result.items[i].VideoPubdate+") "+timeFormat(result.items[i].VideoDuration)+' <img title="�����ӵ������б�" class="add" src="/assets/images/style2/plus.png" style="vertical-align:top"></span>'+
						'<div class="clear"></div>'+
						'</li>';
						o.append(html);
						}
						}
						}
						});
					});
				$("#share a").click(function(){
					var href = ($(this).attr("_href")).replace(/:vid:/g,CurrentVideoID).replace(/:title:/g,"������%23�ſ��̨%23������ "+YoukuWs.title+" ������Ҳ��������: ");
					$(this).attr("href",href);
				});
				$("#share_handle").click(function(){
					if($("#share").css("display")=="none"){
						//$("#share_handle").html(">>");
						$("#ImgUp").show();
						$("#ImgDown").hide();

						$("#share").slideDown("fast");
						//$("#share").show();
						//$("#share").animate({height:$("#share").height()+30},function(){
						//});
					}else{
						$("#ImgUp").hide();
						$("#ImgDown").show();
						//$("#share_handle").html("<<");
						$("#share").slideUp("fast");
						//$("#share").animate({height:$("#share").height()-30},function(){
						//$("#share").hide();
						//});
					};
				});
				$("#share_insite_handle a").click(function(){
					var url= ($(this).attr("_source")).replace(/:vid:/g,CurrentVideoID);
					var postUrl = $(this).attr("_post");
					$.get(url,function(data){
						var data="<div style='width:320px;height:220px;overflow:hidden'><textarea style='width:100%;height:100%'>"+data+"</textarea><div>";

						$(data).dialog({
							resizable: false,
							height:220,width:320,title:"����΢��",
							modal: true,title:"����΢��",
							buttons: [{
								text:"����΢��",click:function() {
									var _data=$(this).parent('.ui-dialog').find("textarea").val();
									$.post(postUrl,{content:_data},function(data){

									if(data){
										YoukuWs.tips("������Ƶ�ɹ�.");
									}else{
										YoukuWs.tips("������Ƶʧ�ܣ����Ժ�����!");
									}
									},"json");
									YoukuWs.tips("���ڷ���΢��...");
									$( this ).dialog( "destroy");
								}},
							{
								text:_LabelCancel,
							click: function() {
								$( this ).dialog( "destroy" );
							}
							}
						]});
					},"text");
					return false;
				});
				$("#_IDPlay").click(function(){
					//{{{����ģʽ
					PlayType=0;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					YoukuWs.playRadio();
				}).bt({icon:"ui-icon-play"});
				$("#_IDThx").click(function(){
					//����ģʽ
					var o = $(this).find("span");
					if(YoukuWs.get("thx")!="open"){
						//to open
						$("#_IDRight").hide();
						$("#box").css("width","756px");
						YoukuWs.set("thx","open");
						o.removeClass("thx_close");
						o.addClass("thx_open");
					}else{
						//to close
						$("#box").css("width","496px");//.hide();
						$("#_IDRight").show();
						o.addClass("thx_close");
						o.removeClass("thx_open");
						YoukuWs.set("thx","close");
					}
				});
				if(YoukuWs.get("thx")=="open"){
					YoukuWs.set("thx","close");
					$("#_IDThx").trigger("click");
				}
				$("#_IDSkip").click(function(){
					YoukuWs.VideoAction("skip",CurrentVideoID);
					//{{{����ģʽ
					PlayType=0;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					YoukuWs.playRadioNext();
				}).bt({icon:"ui-icon-seek-next",position:"left"});
				$("#_IDChange").click(function(){
					//��̨ģʽ
					$("#_RadioChannel ul").html("");
					$("#_RadioChannel >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');

					$("#_RadioChannel").dialog({
						width:400,height:300,title:"Ƶ���б�"
					});
					$.ajax({
						url: "/player.main.radioList",
						type:"post",
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
									$("#_RadioChannel ul").append("<li><button "+dsb+" id='"+result.items[i].ListID+"'>����</button> "+result.items[i].ListName+"</li>");

									$("#_RadioChannel button").button({icons:{primary:"ui-icon-play"}});
								}
							}
						}
					});
				}).bt();
				$("#_IDDown").click(function(){
					if(YoukuWs.isLogin()){
						YoukuWs.VideoAction("down",CurrentVideoID);
						YoukuWs.playRadioNext();
					}else{
						YoukuWs.login(function(){$("#_IDDown").trigger("click");});
					}
				}).bt();
				$("#_IDUp").click(function(){
					if(YoukuWs.isLogin()){
						YoukuWs.VideoAction("up",CurrentVideoID);
					}else{
						YoukuWs.login(function(){$("#_IDUp").trigger("click");});
					}
				}).bt();
				$("#_LiUp").live('click',function(){
					$("#_ContentListen").dialog({
						width:400,height:300,title:"ϲ����MV", buttons: [
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
						width:400,height:300,title:"��ϲ����MV", buttons: [
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
						width:410,height:280,title:"�赥�б�",buttons: [],open:function(event,ui){
							      YoukuWs.listList();
						      }
					});
				});
				$("#_LiListen").live('click',function(){
					$("#_ContentListen").dialog({
						width:400,height:300,title:"������MV", buttons: [
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
				$("#_ContentListen >ul >li .add,#_ContentSearch >li .add").live('click',function(){
					var li =$(this).parentsUntil("li").parent();
					YoukuWsPlaylist.add(li.attr("vid"),li.attr("mvname"));
					$("#IDNav >li").eq(1).trigger("click");
				});
				$("#_ContentMusic >li").live('click',function(){
					//{{{����ģʽ
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					var vid = $(this).attr('vid');
					YoukuWs.play(vid);
					YoukuWs.setTitle($(this).attr("mvname"));
					return false;
				});
				$("#_ContentListen >ul >li .name,#_ContentSearch >li .name").live('click',function(){
					//{{{����ģʽ
					var li = $(this).parent();
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					//}}}
					var vid = li.attr('vid');
					YoukuWs.play(vid);
					YoukuWs.setTitle(li.attr("mvname"));
					return false;
				});
				$("#_IDLyricsPr").click(function(){
					lyrics_offset=parseInt(lyrics_offset)+1000;
					$("#_IDLyricsInfo").html("��ǰ��").fadeIn("slow",function(){
						$("#_IDLyricsInfo").fadeOut("slow");	
					});
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
									 $("#_IDLyricsInfo").html("�ѱ���").fadeIn("slow",function(){
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
						width:400,height:300,title:"�����Ϣ", buttons: [
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
					$("#_IDLyricsInfo").html("�Ѻ���").fadeIn("slow",function(){
						$("#_IDLyricsInfo").fadeOut("slow");	
					});
					YoukuWs.saveOffset();
				});
				//���ز����б�
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
						width:700,height:540,title:"����".tr(), buttons: [
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
						width:300,height:180,title:"����".tr(), buttons: [
					{
						text:_LabelOk,click: function() {
							     $( this ).dialog( "close" );
						     }
					}
					]
					});
				});
				$("#_IDSignup").live("click",function(){
					$("#_IDSingupSubmit").button();
					$("#_ContentSignup").dialog({ title:"ע��",width:320,height:240 });
				});
				//���Ա�����ͱ�����
				$( "#_ContentSearch" ).sortable();
				$( "#_Content" ).droppable({
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-error",
					tolerance:"pointer",
					accept:"#_ContentSearch >li,#_ContentListen >ul >li",
					drop: function( event, ui ) {
						//�����Ǵ���������ϵ���ǰ�����б�
						YoukuWsPlaylist.add(ui.draggable.attr("vid"),ui.draggable.attr("mvname"));
						//TODO ���񱣴�
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
					$("<div>��ȷ��Ҫɾ��ô?</div>" ).dialog({
						resizable: false,
						height:140,
						modal: true,
						buttons: {
							"ɾ��": function() {
								_this2=this;
								var lid = $(_this).parents("li").attr("lid");
								$.ajax({
									url: "/user.list.del",
									data: {
										ListID:lid
									},type:"post",
									success: function( List) {
											 $('.header').load("/player.main.header."+out);
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
					$("<div>��ȷ��Ҫ���ô?</div>" ).dialog({
						resizable: false,
						height:140,
						modal: true,
						buttons: {
							"���": function() {
								_this2=this;
								var lid = $(_this).parents("li").attr("lid");
								$.ajax({
									url: "/user.list.empty",
									data: {
										ListID:lid
									},type:"post",
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
								     var o={order:index,vid:$(domEle).attr("vid")};
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
							     success: function( result) {
									      //Ӧ���޸ĵ�ǰ��ordֵ
									      for(var i in  order){
										      $("#_ContentListen >ul >li[vid="+order[i].vid+"]").attr("ord",order[i].order);
									      }
								      }
						     });
					     }
				});
				$( "#_ContentList >li .edit" ).live("click",function(){
					var lid = $(this).parents("li").attr("lid");
					$("#_ContentListen DIV").html("");
					$("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');
					$("#_ContentListen").dialog({
						width:400,height:300,title:"MV�б�", buttons: [
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
						success: function( result) {
							if(result && result.items && result.items.length>0){
								var o = $("#_ContentListen >ul");
								o.html('');
								for(var i=0;i<result.items.length;i++){
									mvname =YoukuWs.getVideoName(result.items[i]);
									var html='<li _type="list" title="����϶����ұ߲����б�" mvname="'+mvname+'" lid="'+result.items[i].ListID+'" ord="'+result.items[i].MvOrder+'" vid="'+result.items[i].VideoID+'">'+
						'<span class="left name" title="�������:'+mvname+'">'+mvname+'</span>'+
						'<span class="right">'+timeFormat(result.items[i].VideoDuration)+' <a class="delMv" title="ɾ��"><img src="/assets/images/style2/DeleteDisabled.png" style="vertical-align:middle" /></a><img title="�����ӵ������б�" class="add" src="/assets/images/style2/plus.png" style="vertical-align:top"></span>'+
						'<div class="clear"></div>'+
						'</li>';
					o.append(html);
								}
							}
						}
					});
				});
				$( "#_ContentListen .delMv" ).live("click",function(){
					var type= $(this).parents("li").attr("_type");
					var vid= $(this).parents("li").attr("vid");
					var _this=this;
					if(type=="list"){
						var lid= $(this).parents("li").attr("lid");
						//ɾ���б���ĸ���
						$.ajax({
							url: "/user.list.delcontent",
							data: {
								lid:lid,
							vid:vid
							},type:"post",
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
							vid:vid
							},type:"post",
							success: function( result) {
									 $('#_IDHeader').load("/player.main.header."+out);
									 setTimeout(function() { $(_this).parents("li").remove(); }, 1);//fro ie patch
								 }
						});
					}else if(type=="listen"){
						$.ajax({
							url: "/player.main.delListen",
							data: {
								vid:vid
							},type:"post",
							success: function( result) {
									 $('#_IDHeader').load("/player.main.header."+out);
									 setTimeout(function() { $(_this).parents("li").remove(); }, 1);//fro ie patch
								 }
						});
					};
					return false;
				});
				$( "#_ContentList >li .rename" ).live("click",function(){
					var lname = $(this).parents("li").find(".name").html();//attr("lid");
					var lid = $(this).parents("li").attr("lid");
					var html='<div>�µĸ赥��<input type="text" value="'+lname+'"/></div>';
					$(html).dialog({
						resizable: false,
						height:140,
						modal: true,
						buttons: {
							"����": function() {
								_this=this;
								if($("#_IDNewName").val()=="")return;
								$.ajax({
									url: "/user.list.edit",
									data: {
										ListID:lid,
									ListName:$(_this).find("input").val()
									},type:"post",
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
							     success: function( result) {
									      //Ӧ���޸ĵ�ǰ��ordֵ
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
				}).bt();//button({icons:{primary:"ui-icon-seek-prev"}});;
				$("#_BtNext").click(function(){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.playNext();
				}).bt();//({icons:{primary:"ui-icon-seek-next"}});;
				$("#_BtTrash").bt().droppable({
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
				$("#_BtSearch").bt().click(function(){
					search();
				});
				//$("button").bt().show();
				//$("button").button().show();



				$("#_BtClearList").bt().click(function(){
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
				$("#IDNav >li").click(function(){
					var _this = this;
					if($("#IDNav >li").index(_this)==2){
						pre_index=0;
						YoukuWs.LyricsInterval = setInterval(YoukuWs.checkTime,200);
					}else{
						clearInterval(YoukuWs.LyricsInterval);
					};
					$("#IDNav >li").each(function(i,item){
						//{{{ save scrollTop
						window._ContentMusicTop=window._ContentMusicTop?window._ContentMusicTop:0;
						if($("#_ContentMusic").scrollTop()>0){
							window._ContentMusicTop = $("#_ContentMusic").scrollTop();
						}
						//}}}
						$(item).removeClass("current");
						//$(item).css("background-color","#ddd");
						$("#_IDRight >.list").eq(i).hide();
					});
					$("#IDNav >li").each(function(i,item){
						if($(_this).html()==$(item).html()){
							//$(item).css("background-color","");
							$(item).addClass("current");
							$("#_IDRight >.list").eq(i).show();

							//{{{ restore scrollTop
							if(i==1 && window._ContentMusicTop>0){
								$("#_ContentMusic").scrollTop(window._ContentMusicTop);
							}
							//}}}
						}
					});
				});
				$("#_BtAddList").button();
				$("#_BtAddMv").bt().click(function(){
					$( "#_DialogAdd" ).dialog({
						width:500,height:320, buttons: {
							      "����": function() {
								      var k =($("#_DialogAdd textarea").val());
								      $.ajax({type:"POST",url:"/player.main.getVideo",data:{"k":k},success:function(msg){
									      YoukuWsPlaylist.addArray(msg);
									      $("#_DialogAdding").hide();
									      $("#_DialogAdd").dialog( "close" );
								      },beforeSend:function(xhr){
									      $("#_DialogAdding").show();
								      }
								      });
							      },
						"ȡ��": function() {
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
						success: function( List) {
								 if(List){
									 $('#_IDHeader').load("/player.main.header."+out);
									 YoukuWs.listList();
								 }
							 }

					});
				});
				$("#_BtSaveList").bt().click(function(){
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
									var vids=[];
									$("#_ContentMusic >li").each(function(i,n){
										vids.push($(n).attr("vid"));
									});
									$("#_IDListDialogAdding").show();
									$.ajax({
										url: "/user.list.addContents",
										data: {
											lids:lids,
										vids:vids
										},type:"post",
										success: function( List) {
												 $("#_IDListDialogAdding").hide();
												 if(List){
													 YoukuWs.listList(1);
												 }
												 $( _this2 ).dialog( "destroy");
												 alert("����ɹ�");
											 }

									});


								}else{
									alert("��ѡ����Ҫ����ĸ赥");
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
						//��ʾ�б�
						$("#_ContentList").dialog({
							width:300,height:250
						});
					}else{
						YoukuWs.login(function(){$("#_BtOpenList").trigger("click");});
					}
				}).show();

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
					//�жϲ��ǲ��ڲ����б���
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
				if(objURL.lid){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.listContents(objURL.lid);
				}else if(objURL.vid){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.getVideoByVid(objURL.vid);

				}else if(window._initVid){
					PlayType=1;
					YoukuWs.set("PlayType",PlayType);
					YoukuWs.getVideoByVid(_initVid);
				};
				//{{{��ʾ����ģʽ������
				PlayType = YoukuWs.get("PlayType",0);
				$.each(YoukuWsPlaylist.list(),function(i,n){
					var o = '<li vid="'+n.v+'"><a>'+n.t+'</a></li>';
					$("#_ContentMusic").append(o);
				});
				$("#_IDRight >.list").each(function(i,item){
					if(i==PlayType){
						$("#IDNav >li").eq(i).addClass("current").show();
						$(item).show();
					}else{
						$("#IDNav >li").eq(i).removeClass("current").show();
						$(item).hide();
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
			var c = '<div time="'+gc[k].t+'" id="_ID'+k+'">'+gc[k].w+'</div>';
			o.append(c);
		}
	}

	function parseLyric(str)
	{
		if(!str || str=="")return;
		ti=/\[ti:(.+)\]/i.test(str)?"���⣺"+RegExp.$1:"";
		ar=/\[ar:(.+)\]/i.test(str)?"���֣�"+RegExp.$1:"";
		al=/\[al:(.+)\]/i.test(str)?"ר����"+RegExp.$1:"";
		by=/\[by:(.+)\]/i.test(str)?"������"+RegExp.$1:"";
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
	/*�����Ż�Ϊ2���㷨*/
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
			     if(PlayType==0){
				     $("#_IDSkip").show();
				     $("#_IDPlay").hide();
			     }else{
				     $("#_IDSkip").hide();
				     $("#_IDPlay").show();
			     }
			     next=1;
			     CurrentVideoID=vid;
			     YoukuWs.set("CurrentVideoID",CurrentVideoID);
			     //��ȡ������Ϣ
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
							     singer="����".tr()+":";

							     for(var i in result.Singers){
								     tmp.push("<a class='singer' id='"+result.Singers[i].SingerID+"'>"+result.Singers[i].SingerName+"</a>");
								     t_tmp.push(result.Singers[i].SingerName);
							     }
							     singer+=tmp.join(" / ");
						     }
						     if(result.AlbumID && result.AlbumName)
				     $("#musicInfo").html(singer+" "+"ר��".tr()+":<a class='special' id='"+result.AlbumID+"'>"+result.AlbumName+"</a>");
						     else
				     $("#musicInfo").html(singer);

						     $("#musicInfo").slideDown("fast");
						     //����title
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
			     //���ظ��
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
								      //��ʾû�и��
								      $("#_IDLyricsAdmin").fadeOut("slow");
							      }
							      //�������������û��ģ����Ա༭
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
					     //this.video.addEventListener('pause', onPause, false);
					     //this.video.addEventListener('volumechange', onVolumechange, false);
					     //this.video.addEventListener('playing', onPlaying, false);
					     //this.video.addEventListener('loadstart', onLoadstart, false);
					     ////this.video.addEventListener('seeked', onSeeked, false);
					     ////this.video.addEventListener('seeking', onSeeking, false);
					     ////this.video.addEventListener('waiting', onWaiting, false);
					     //this.video.addEventListener('abort', onAbort, false);
					     //this.video.addEventListener('progress', onProgress, false);
				     }else{
					     //video.src="http://hetalbeta.youku.com/player/getm3u8/vid/51809490/type/mp4/v.m3u8";
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
				     try{
					     PlayerReplay(vid);
				     }catch(e){
					     //swfobject.createSWF({data:"http://static.youku.com/v/swf/player.swf",width:"100%",height:"100%"},{allowFullScreen:true,allowscriptaccess:"always",wmode:"transparent",flashvars:"isAutoPlay=true&VideoIDS="+vid+"&winType=popup&ad=0&skincolor1=3F3F3F&skincolor2=3F3F3F&firsttime="+time},playerId);
					     swfobject.createSWF({data:"http://static.youku.com/v/swf/player.swf",width:"100%",height:"100%"},{allowFullScreen:true,allowscriptaccess:"always",wmode:"transparent",flashvars:"isAutoPlay=true&VideoIDS="+vid+"&winType=index&ad=0&skincolor1=3F3F3F&skincolor2=3F3F3F&firsttime="+time},playerId);
				     }
			     }
			     if(PlayType!=0){//������ģʽ
				     //{{{
				     var t = 0;
				     var o = $("#_ContentMusic [vid='"+vid+"']");
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
			     if(YoukuWs.isIpad()){
				     var video = document.getElementById(playerId);
				     if(video!=null){
					     playTime.time= video.currentTime;
				     }else{
					     return;
				     }
			     }else{
				     //var r= PlayerInfo();
				     //if(!r){
				     //  	  LyricTop.hide();
				     //  	  return;
				     //}
				     //time = isNaN(r.time)?0:r.time;
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
			     //�����ƶ�
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
				     //������������
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
			     //��ȡ��ǰ���е����ݣ����Ϊ�վʹӷ�����ȡ
			     if(window.radioPlayList.length<2){
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
								      YoukuWs._realPlayRadio();
							      }
						      }
				     });
			     }else{
				     YoukuWs._realPlayRadio();
			     }
		     }, playRandom:function(pre){
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
			     /*������һ��*/
			     if(parseInt(PlayMode)==3)return YoukuWs.playRandom();
			     var vid = $("#_ContentMusic [vid='"+CurrentVideoID+"']").next().attr("vid");
			     if(!vid){
				     vid = $("#_ContentMusic li").first().attr("vid");
			     }
			     if(vid)YoukuWs.play(vid);
		     }, playPre:function(){
			     /*������һ��*/
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
			     if(t)$("#title").html("���ڲ���".tr()+":"+t);
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
											 YoukuWs.tips("��ӳɹ�!");
											 break;
									     case "up":$("#_CtUp").html(parseInt($("#_CtUp").html())+1);
										       YoukuWs.tips("��ӳɹ�!");
										       break;
									     case "skip":$("#_CtSkip").html(parseInt($("#_CtSkip").html())+1);
											 break;
								     }
							     }else{
								     YoukuWs.tips("�Ѿ���ӹ���!");
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
					     $('.header').load("/player.main.header."+out);
					     $("#_ContentLogin").dialog( "close" );
					     //��¼�ɹ�
				     }else{
					     //��¼ʧ��
					     $("#_FormLogin .info").html("<b>��¼ʧ�ܣ��û������������</b>").slideDown("fast");
				     }
			     },"json");
			     return false;
		     },login:function(callback){
			     $("#_IDLoginSubmit").button();
			     $("#_ContentLogin").dialog({ width:320,height:220,close:function(){
				     if(YoukuWs.isLogin() && callback && typeof(callback)=="function")callback();
			     }
			     });
		     },autoLogin:function(){
			     if(this.get("token","",true) && this.get("uid","",true)){
				     $.post("/user.main.autologin","token="+this.get("token")+"&uid="+this.get("uid"),function(data){
					     if(data){
						     $('#_IDHeader').load("/player.main.header."+out);
						     //��¼�ɹ�
					     }
				     },"json");
			     }
		     },formsignup: function() {
			     $.post("/user.main.signup",$("#_FormSignup").serialize(),function(data){
				     if(data.uid){
					     //ע��ɹ�
					     $('.header').load("/player.main.header."+out);
					     $("#_ContentSignup").dialog( "close" );
					     //��¼�ɹ�
				     }else{
					     //��¼ʧ��
					     $("#_FormSignup .info").html("<b>"+data.info+"</b>").slideDown("fast");
				     }
			     },"json");
			     return false;
		     },listListen:function(page){
			     $("#_ContentListen DIV").html("");
			     $("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');
			     $.ajax({
				     url: "/player.main.listListen."+page,
				     success: function( result) {
					     var o = $("#_ContentListen >ul");
					     o.html('');
					     for(var i=0;i<result.items.length;i++){
						     var mvname=YoukuWs.getVideoName(result.items[i]);
						     var html='<li _type="listen"  title="����϶����ұ߲����б�" mvname="'+mvname+
				     '" vid="'+result.items[i].VideoID+'">'+
				     '<span class="left name" title="�������:'+mvname+'">'+mvname+'</span>'+
				     '<span class="right">'+timeFormat(result.items[i].VideoDuration)+' <a class="delMv" title="ɾ��"><img src="/assets/images/style2/DeleteDisabled.png" style="vertical-align:middle" /></a><img title="�����ӵ������б�" class="add" src="/assets/images/style2/plus.png" style="vertical-align:top"></span>'+
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
		     }, listAction:function(action,page){
			     $("#_ContentListen DIV").html("");
			     $("#_ContentListen >ul" ).html('<li><img style="vertical-align: middle;" src="/assets/images/loading/loading9.gif" /> ���ڼ�����...</li>');
			     $.ajax({
				     url: "/player.main.listAction."+action+"."+page,
				     success: function( result) {
					     var o = $("#_ContentListen >ul");
					     o.html("");
					     for(var i=0;i<result.items.length;i++){
						     if(result.items[i]){
							     var mvname=YoukuWs.getVideoName(result.items[i]);
							     var html='<li _type="action"  actiontype="'+result.actiontype+'" title="����϶����ұ߲����б�" mvname="'+mvname+'" vid="'+result.items[i].VideoID+'">'+
				     '<span class="left name" title="�������:'+mvname+'">'+mvname+'</span>'+
				     '<span class="right">'+timeFormat(result.items[i].VideoDuration)+' <a class="delMv" title="ɾ��"><img src="/assets/images/style2/DeleteDisabled.png" style="vertical-align:middle" /></a><img title="�����ӵ������б�" class="add" src="/assets/images/style2/plus.png" style="vertical-align:top"></span>'+
				     '<div class="clear"></div>'+
				     '</li>';
						     }
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
		     }, listList:function(flag){
			     $("#_ContentList").html("");
			     var t="";
			     //if(flag!=1)
			     {
				     //t='type="hidden"';
			     }
			     $.ajax({
				     url: "/user.list.list",
				     success: function( result) {
					     if(result && result.items && result.items.length>0){
						     var o = $("#_ContentList");
						     for(var i=0;i<result.items.length;i++){
							     //var r='<li ord="'+result.items[i].ListOrder+'" lid="'+result.items[i].ListID+'"><div class="left"><input value="'+result.items[i].ListID+'" style="vertical-align:top" type="checkbox"/><span class="name">'+result.items[i].ListName+'</span> ('+result.items[i].ListCount+'��)</div><div class="right hide">';
							     var r='<li ord="'+result.items[i].ListOrder+'" lid="'+result.items[i].ListID+'"><div class="left"><input '+t+' value="'+result.items[i].ListID+'" style="vertical-align:top" type="checkbox"/><span class="name">'+result.items[i].ListName+'</span> ('+result.items[i].ListCount+'��)</div><div class="right hide">';
							     if(result.items[i].ListCount>0)r+='<span class="edit">��������</span> ';
							     r+='<span class="load">����</span> <span class="empty">���</span> <span class="del">ɾ��</span> <span class="rename">����</span></div><div class="clear"></div></li>';
							     o.append(r);
						     }
						     $( "#_ContentList >li" ).droppable({
							     accept:"#_ContentMusic >li,#_ContentSearch >li",
							     activeClass: "ui-state-highlight",
							     hoverClass: "ui-state-error",
							     tolerance:"pointer",
							     drop: function( event, ui ) {
								     //TODO�ƶ�����һ���б�
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
												      $("#_IDSaveTips").html("����ɹ�");
												      $("#_IDSaveTips").show("clip");
											      }else{
												      $("#_IDSaveTips").html("�赥���Ѿ����ˣ���Ҫ̰��Ŷ");
												      $("#_IDSaveTips").show("clip");
											      }
											      setTimeout(function() { $("#_IDSaveTips").hide("clip");}, 2000);
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
		     }, listContents:function(lid){
			     $.ajax({
				     url: "/user.list.listContents",
			     data:{lid:lid},
			     success: function( result) {
				     if(result && result.items && result.items.length>0){
					     YoukuWsPlaylist.addArray(result.items);
					     if(!YoukuWs.get("CurrentVideoID")){
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
		     }, tips:function(v,hold){
			     $("#IDTips span").html(v);
			     $("#IDTips").slideDown("fast",function(){
					 if(hold)return;
				     setTimeout(function() { 
					     $("#IDTips").slideUp("fast");

				     }, 2000);//fro ie patch

			     });

		     },flag:flag
	}
}();
