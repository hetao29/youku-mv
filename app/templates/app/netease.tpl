<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>优酷电台 - 应用授权</title>

			<style>
				@charset "utf-8";
				body{ background:#fff; color:#000; font-family:Arial, Helvetica, sans-serif; font-size:12px; }
				* { margin:0; padding:0; border: 0; outline: 0; }
				table { border-collapse:collapse; border-spacing:0; }
				input, textarea { margin:0; padding:0; font-size:12px; font-family:Arial, Helvetica, sans-serif; outline:none; color:#333 }
				textarea { resize:none }
				fieldset, img { border:0; }
				li { list-style:none; }
				caption, th { text-align:left; }
				h1, h2, h3, h4, h5, h6 { font-size:100%; }
				q:before, q:after { content:''; }
				abbr, acronym { border:0; font-variant:normal; }
				input.labelbox { border:0; }
				/*link*/
				a, a:link, a:hover, a:visited { text-decoration: none; color:#347cbe; }
				a.line { text-decoration:underline; }
				a:hover { text-decoration:underline; }
				strong, h1, h2, h3, h4, h5, h6 { font-weight:normal }
				/* to preserve line-height and selector apiearance */
				sup { vertical-align:text-top; }
				sub { vertical-align:text-bottom; }
				input { line-height:1.2em; overflow:hidden; }
				/*to enable resizing for IE*/
				input, textarea, select { *font-size:100%;
				}
				.clear, .clearit { clear:both; padding:0; margin:0; }
				.clearFix { clear:both;zoom:1 }
				.clearFix:after { content:"";display:block;overflow:hidden;height:0;clear:both;}
				a em { font-family:"宋体"; font-style:normal; }
				.fb { font-weight:bold; }
				.gray6{ color:#666;}
				.gray9{ color:#999;}


				.mbi_Wrap {  height:358px; display:block; overflow:hidden; text-align:center; min-width:320px;}
				.mbi_Wrap .mib_top { border:1px solid #999999; background:#5198d7; height:28px; width:100%; display:block; overflow:hidden; }
				.mbi_Wrap .mib_top .logo { float:left; display:block; padding-left:20px; line-height:28px; color:#fff; }
				.mbi_Wrap .mib_top .logo img { margin:0px 8px 1px 0; vertical-align:middle; }
				.mbi_Wrap .mib_top .rt_link { float:right; display:block; padding-right:20px; line-height:28px; color:#fff; }
				.mbi_Wrap .mib_top .rt_link a { color:#bfeeff; }
				.mbi_Wrap .mib_content { border:1px solid #999999; border-top:none; background:#fff; height:327px; overflow:hidden;}
				.mbi_Wrap .mib_content .txt_blbg { height:48px; line-height:48px; background:#e2eef9; border-top:1px solid #fff; border-bottom:1px solid #e1e1e1; padding:0 20px; }
				.mbi_Wrap .mib_content .txt_blbg .txt_if{ width:290px; margin:0 auto; text-align: left;}
				.mbi_Wrap .mib_content .info_mib { padding:20px 20px 1px; height:90px; width:280px; margin:0 auto; }
				.mbi_Wrap .mib_content .info_mib .lf { float:left; display:block; width:162px; line-height:24px; color:#666; text-align:left; }
				.mbi_Wrap .mib_content .info_mib .rt { float:right; display:block; width:115px; }
				.mbi_Wrap .mib_content .info_mib .rt img { vertical-align:middle; }
				.mbi_Wrap .mib_content .form_wrap { padding:24px 20px 7px; position:relative; width:280px; margin:0 auto; }
				.mbi_Wrap .mib_content .form_wrap .row_fm { width:100%; padding-bottom:10px; height:30px; }
				.mbi_Wrap .mib_content .form_wrap .lable_fm { float:left; display:block; width:40px; line-height:28px; }
				.mbi_Wrap .mib_content .form_wrap .inp_fm { float:left; display:block; padding-bottom:10px; }
				.mbi_Wrap .mib_content .form_wrap .inp_fm .iptbg { background:#e2eef9; color:#999999; width:218px; padding:5px 10px; height:18px; line-height:18px; border:1px solid #999999; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;}
				.mbi_Wrap .mib_content .form_wrap .iptbg:focus{ border:1px solid #666; color:#666; background:#c7e1fa;}

				.mbi_Wrap .mib_content .form_wrap .error_wp{ position:absolute;right:20px;top:0px;background:#ffeaea;border:1px solid #e5c3c4;width:226px;padding:0 6px;height:22px;line-height:22px;}
				.error_txt{ background:url(/assets/images/api/ico_error.png) no-repeat scroll 0 3px; line-height:22px; padding-left:22px; color:#cc0000; display:inline-block;}
				.error_txt_large{ background:url(/assets/images/api/ico_error_new.png) no-repeat; line-height:22px; padding-left:48px;}
				.error_txt_large h3{ font-weight:bold; font-size:14px; color:#333; margin-bottom:8px;}
				.error_txt_large p{ color:#666;}
				.mbi_Wrap .mib_content .des_content{ text-align:center;padding:0 20px; height:111px; line-height:111px;}
				.mbi_Wrap .mib_content .des_content1{ padding:111px 20px 50px; height:110px; line-height:20px; width:280px; margin:0 auto;}
				.mbi_Wrap .mib_content .des_content a{ text-decoration:underline;} 
				.mbi_Wrap .mib_content .btn_wp { border-top:1px solid #e1e1e1; background:#f1f1f1; padding:12px 20px 12px; text-align:center; height:30px; line-height:30px; color:#666;}
				.mbi_Wrap .mib_content .btn_wp .btn_green{ margin-right:15px;}
				.mbi_Wrap .getCodeWrap{ padding:10px; font-size:14px; text-align:center; }

				a.btn_green, a.btn_green:link, a.btn_gray, a.btn_gray:link{ background:url(/assets/images/api/btn_at.gif) no-repeat scroll 0 0; color:#333333; display:inline-block; height:30px; line-height:30px; text-decoration:none; padding-left:5px; text-decoration:none; }
				.btn_green em, .btn_gray em { background:url(/assets/images/api/btn_at.gif) no-repeat scroll 100% -30px; color:#333333; display:inline-block; height:30px; line-height:30px; color:#fff; font-size:14px; font-weight:bold; padding:0 10px 0 5px; }
				a.btn_gray, a.btn_gray:link { background-position: 0 -60px;}
				.btn_gray em { background-position: 100% -90px;color:#727272;}

				a.btn_greenS, a.btn_greenS:link, a.btn_greenS:hover, a.btn_grayS, a.btn_grayS:link, a.btn_grayS:hover{ background:url(/assets/images/api/btn_at.gif) no-repeat scroll 0 -120px; color:#333333; display:inline-block; height:23px; line-height:23px; padding-left:5px; text-decoration:none; cursor:pointer; }
				a.btn_greenS em, a.btn_grayS em { background:url(/assets/images/api/btn_at.gif) no-repeat scroll 100% -143px; color:#333333; display:inline-block;height:23px; line-height:23px; color:#fff;  padding:0 15px 0 10px;text-decoration:none; }
				a.btn_grayS, a.btn_grayS:link, a.btn_grayS:hover{ background-position: 0 -166px;}
				a.btn_grayS em { background-position: 100% -188px; color:#333333;}


				.btnwdt_01 em{ width:110px; text-align:center; display: inline-block;}
				.btnwdt_02 em{ width:79px; text-align:center; display: inline-block;}

				.mbi_12Wrap{ width:242px; height:322px;}
				.mbi_12Wrap .mib_content { height:291px;}
				.mbi_12Wrap .mib_top .logo { padding-left:15px;}
				.mbi_12Wrap .mib_top .rt_link { padding-right:15px;}
				.mbi_12Wrap .mib_content .txt_blbg{ height:41px;line-height:21px;padding:8px 15px;}
				.mbi_12Wrap .mib_content .txt_lineHg1{ line-height:41px;}
				.mbi_12Wrap .mib_content .info_mib { text-align:center;padding:18px 15px 0; height:80px;}
				.mbi_12Wrap .mib_content .form_wrap { padding:20px 15px 6px;}
				.mbi_12Wrap .mib_content .form_wrap .inp_fm { width:170px;}
				.mbi_12Wrap .mib_content .form_wrap .lable_fm{ line-height:24px;}
				.mbi_12Wrap .mib_content .form_wrap .inp_fm .iptbg { width:150px; padding:2px 10px;}
				.mbi_12Wrap .mib_content .btn_wp { background:none; height:; border:none; height:20px; line-height:20px; padding:4px 15px 6px; text-align:left;}
				.mbi_12Wrap .mib_content .btnwdt_80{ margin-left:40px;}
				.mbi_12Wrap .mib_content .btn_wp a{ text-decoration:underline;}
				.mbi_12Wrap .mib_content .form_wrap .error_wp{ color:#CC0000; background:none; border:none;height:22px;line-height:22px;padding:0;position:absolute;right:13px;top:0;width:170px;}
				.mbi_12Wrap .mib_content .des_content { height:94px;line-height:94px;padding:0 15px;}
				.mbi_12Wrap .mib_content .des_content1{ padding:102px 5px 50px 15px}
				.mbi_12Wrap .error_txt_large{ line-height:44px; margin-left:40px;}
				.mbi_12Wrap .getCodeWrap{ text-align:left; padding:25px 10px;}

				.mbi_20Wrap{ height:336px; text-align:center;min-width:242px;}
				.mbi_20Wrap .mib_content { height:305px;}
				.mbi_20Wrap .mib_top .logo { padding-left:15px;}
				.mbi_20Wrap .mib_top .rt_link { padding-right:15px;}
				.mbi_20Wrap .mib_content .txt_blbg{ height:41px;line-height:21px;padding:8px 15px;}
				.mbi_20Wrap .mib_content .txt_blbg .txt_if{ width:210px; margin:0 auto; text-align:left;}
				.mbi_20Wrap .mib_content .txt_lineHg1{ line-height:41px;}
				.mbi_20Wrap .mib_content .info_mib { text-align:center;padding:18px 15px 0; height:80px; width:210px;}
				.mbi_20Wrap .mib_content .form_wrap { padding:20px 15px 6px; width:210px;}
				.mbi_20Wrap .mib_content .form_wrap .inp_fm { width:170px;}
				.mbi_20Wrap .mib_content .form_wrap .lable_fm{ line-height:24px;}
				.mbi_20Wrap .mib_content .form_wrap .inp_fm .iptbg { width:150px; padding:2px 10px;}
				.mbi_20Wrap .mib_content .btn_wp { background:none; height:30px; border:none; height:30px; line-height:30px; padding:0px 15px 0px; text-align:center;}
				.mbi_20Wrap .mib_content .btnwdt_80{ margin-left:40px;}
				.mbi_20Wrap .mib_content .form_wrap .error_wp{ color:#CC0000; background:none; border:none;height:22px;line-height:22px;padding:0;position:absolute;right:13px;top:0;width:170px;}
				.mbi_20Wrap .mib_content .des_content { height:94px;line-height:94px;padding:0 15px;}
				.mbi_20Wrap .mib_content .des_content1{ padding:102px 5px 50px 15px; width:220px;}
				.mbi_20Wrap .error_txt_large{ line-height:44px; margin-left:40px;}
				.mbi_20Wrap .mib_content .btn_wp .btn_green{ margin-right:12px;}
				.mbi_20Wrap .getCodeWrap{ text-align:left; padding:25px 10px;}

				.oauth_top { background: url(/assets/images/api/bg_rextop.jpg) repeat-x scroll 0 0; height:36px;display:block; overflow:hidden; }
				.oauth_top .logo { float:left; display:block;color:#fff;line-height:45px; *line-height:50px; }
				.oauth_top .logo img { margin:2px 8px 0 0; vertical-align:middle; float: left; display:block; }
				.oauth_top .rt_link { float:right; display:block;  color:#fff;padding-right:27px; line-height:40px; *line-height:44px;}
				.oauth_top .rt_link a { color:#bfeeff; }
				.oauth_top .ico_del{ background: url(/assets/images/api/ico_error.png) no-repeat scroll 2px -180px; width:10px; height:10px; line-height:8px; float:right;display:inline-block; vertical-align:middle; float:right; display:block; margin:14px 10px 0 0;_margin-right:5px; }
				.txt_oauth{ height:50px;line-height:50px;background:#e2eefa;}
				.au_cWrap{ width:550px;margin:0 auto;}
				.oauth_cont{ padding:28px 0 13px;}
				.oauth_cont .lf{ float:left;display:block; width:270px;}
				.oauth_cont .lf .msg_txtls{ float:left; display:block; width:200px;}
				.oauth_cont .lf .mt_arr{ float:right; display:block; width:45px; margin-top:5px; padding-bottom:67px;}
				.oauth_cont .rt{ float:right; display:block; width:270px; overflow:hidden;} 
				.oauth_cont .rt .lf_img{ float:left; display:inline-block; width:80px; height:80px; overflow:hidden;}
				.oauth_cont .rt .des_txt{ float:right; display:block; width:182px;}
				.oauth_cont .rt .des_txt h3{ font-size:12px; font-weight:bold; margin-bottom:11px;}
				.oauth_cont .rt .des_txt p{ line-height:18px; word-break:break-all; word-wrap:break-word;}
				.oauth_cont .gs_uls{ padding:33px 0 45px;}
				.oauth_cont .gs_uls li{ background:url(/assets/images/api/dot_1.png) no-repeat scroll 0 50%;color:#666; line-height:21px; padding-left:12px;}
				.oauth_cont .lt_msg{ display:block; padding-bottom:15px;}
				.oauth_cont .form_wrap{ background:url(/assets/images/api/dot_rex.gif) repeat-x scroll 0 0;padding-top:10px; width:260px;margin:25px 10px 0 0;padding-top:17px;width:272px;*margin-top:20px; position:relative;}
				.oauth_cont .form_wrap .row_fm { width:100%; padding-bottom:10px;*padding-bottom:0px; }
				.oauth_cont .form_wrap .lable_fm { float:left; display:block; width:40px; line-height:24px; color:#676767; }
				.oauth_cont .form_wrap .inp_fm { float:left; display:block; width:216px; padding-bottom:10px; }
				.oauth_cont  .form_wrap .inp_fm .iptbg { background:#fff; color:#989898; width:218px; padding:2px 5px; height:18px; line-height:18px; border:1px solid #e8e8e8; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; }
				.oauth_cont .form_wrap .error_wp{ position:absolute;right:2px;top:-14px;width:216px;background:#ffeaea;border:1px solid #e5c3c4;padding:0 6px;height:22px;line-height:22px;}

				input.ipt_cb{ vertical-align:middle; margin:0 3px 0;_margin-top:-2px;}
				.oauth_btn{ text-align:center; background:#f1f1f1;height:22px;line-height:22px; padding:7px 0;} 
				.oauth_btn .btn_greenS{ padding-right:10px;}
				.oauth_btn .lf_half{ width:50%; float:left; text-align:left;}
				.lf_half_r{ float:left; text-align:left; padding-left:45px;}
				.oauth_cont .des_content1{ padding:80px 110px 110px;}
				.oauth_cont .getCodeWrap{ padding:10px; font-size:14px; text-align:center; }

				.popWrap_tDiv{ position:absolute; left:50%; top:130px; margin-left:-286px;}
				.popWrap_oauth{ width:515px;background: url(/assets/images/api/bg_layerr.png);-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px; padding:6px;}
				.popWrap_oauth .boderWrap_oauth{ border:1px solid #c6c6c6; background:#fff;}
				.popWrap_oauth .oauth_cont { padding:28px 20px 11px; background:#fff;}
				.popWrap_oauth .au_cWrap{ width:540px;}
				.popWrap_oauth .oauth_btn{ background:#fff; height:32px; text-align:right; padding:14px 0 12px 0; border-top:1px solid #f2f2f2; margin:0 20px;}
				.popWrap_oauth .lf_title_oauth { font-weight:bold; color:#fff; font-size:14px; padding-left:20px; width:445px; float:left; display:block;}
				.au_divLs{ width:570px;}
				.popWrap_oauth .txt_oauth{ height:30px;line-height:32px;background: url(/assets/images/api/bg_tprex.png) repeat-x scroll 0 0;}
				.popWrap_oauth .tz_hd1{ padding-bottom:4px;}

				.oauth_cont_xms .lf{ width:244px;}
				.oauth_cont_xms .lf .msg_txtls{ width:180px;}
				.oauth_cont_xms .gs_uls{ padding-bottom:15px;}
				.oauth_cont_xms .lf .mt_arr{ margin-top:28px; padding-bottom:20px;}
				.oauth_cont_xms .rt{ padding-top:44px; width:210px;}
				.oauth_cont_xms .rt .lf_img{ width:80px;}
				.oauth_cont_xms .rt .des_txt{ width:120px;}
				.txt_oauth_xms{ height:30px; line-height:33px; overflow:hidden;}
				.txt_oauth_xms .au_cWrap{ float:left; display:block; padding-left:15px; width:520px;}
				.txt_oauth_xms .ico_del{ background: url(/assets/images/api/ico_error.png) no-repeat scroll 0 -221px; width:10px; height:10px; line-height:8px; float:right;display:inline-block; vertical-align:middle; float:right; display:block; margin:11px 19px 0 0;_margin-right:10px;}

				/**ifram内的样式**/
				.iframe_inside{ background:none}
				.iframe_inside h4{ margin-top:12px;margin-top:15px\9;*margin-top:15px;_margin-top:13px;}
				.iframe_inside .CH{ font-family:'宋体'}
				.iframe_inside .popWrap_oauth{ -moz-border-radius:8px;-webkit-border-radius:8px}
				.iframe_inside .popWrap_oauth .oauth_cont{ padding:24px 20px 0px}
				.iframe_inside .popWrap_oauth .oauth_btn{ padding:10px 0 11px;margin-top:2px;margin-top:3px;margin-top:3px\9;_margin-top:2px}
				.iframe_inside .oauth_btn .btn_greenS{ padding-right:2px}
				.iframe_inside a.btn_greenS,.iframe_inside a.btn_greenS:link,.iframe_inside a.btn_greenS:hover{ padding-left:6px}
				.iframe_inside a.btn_grayS,.iframe_inside a.btn_grayS:link,.iframe_inside a.btn_grayS:hover{ margin-left:8px;padding-left:6px}
				.iframe_inside a.btn_greenS em{ padding:0 15px 0 10px}
				.iframe_inside .oauth_cont .gs_uls{ padding:28px 0 25px}
				.iframe_inside .oauth_cont .gs_uls li{ padding-left:13px}
				.iframe_inside .oauth_cont_xms .rt{ padding-top:34px}
				.iframe_inside .oauth_cont_xms .lf .mt_arr{ margin-top:21px;padding-bottom:0}
				.iframe_inside .oauth_cont .rt .des_txt p{ margin-top:5px}
				.iframe_inside .popWrap_oauth .boderWrap_oauth{ border: 1px solid #888;-moz-border-radius:3px;-webkit-border-radius:3px}

				/**ifram-授权出错**/
				.oauth_cont_new{ height:155px; width:100%; overflow:hidden;}
				.oauth_cont_new .error_txt_large{ width:250px; margin:20px auto;}

			</style>
		</head>

		<body class="iframe_inside">

			<div id="authDiv" style="width: 530px; height: 285px;center; margin:25px auto;">

				<div class="popWrap_tDiv">
					<div class="popWrap_oauth">
						<div class="boderWrap_oauth">
							<div class="txt_oauth txt_oauth_xms">
								<div class="lf_title_oauth CH">应用授权</div>
								<a class="ico_del" href="javascript:closeWindow();"></a> </div>
							<div class="oauth_cont oauth_cont_xms clearFix">
								<div class="lf"> <span class="gray6 CH">将允许</span> <span class="fb"><span class="CH">优酷电台</span></span> <span class="gray6 CH">进行以下操作：</span>
									<div class="clearFix">
										<div class="msg_txtls">
											<ul class="gs_uls CH">
												<li>获得你的个人信息，好友关系</li><li>分享内容到你的微博</li><li>获得你的评论</li></ul>
										</div>
										<div class="mt_arr"> <img src="/assets/images/api/img_arr1.png" alt=""> </div>
										</div>
									</div>

									<div class="rt">
										<div class="clearFix">
											<div class="lf_img"><img src="/assets/images/api/5551ae1bjw1dmyocbuw0cj.jpg" width="80px" alt=""></div>
												<div class="des_txt">
													<h3><span class="CH">优酷电台</span></h3>
													<h4 class="gray6 CH">开发者：优酷电台</h4>
													<p class="gray6"><span class="gray9">共15161</span><span class="CH">人在用</span>
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="oauth_btn clearFix"> 
										<a onclick="location='{$aurl}'" class="btn_greenS">
											<em>授权</em></a>
										<a onclick="window.close();" class="btn_grayS"><em>取消</em></a> </div>
								</div>
							</div>
						</div>

					</div>

				</body>
			</html>
