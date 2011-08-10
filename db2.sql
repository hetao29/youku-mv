--
中间层音乐查询
--showcategory:音乐 completed:1 releasedate:-19800101	--80年代以前的
showcategory:音乐 completed:1 showid:105077-106077
fields:	showname show_thumburl mv_genre singer showlastupdate firstepisode_videoid releasedate area singertype language album
orderby:showid:desc

--音乐表,核心表
CREATE TABLE `s_video`(
`VideoID` int(10) unsigned NOT NULL ,
`VideoName` varchar(200) COMMENT '音乐名',
`SingerIDS` varchar(200) COMMENT '歌手ID,用/分开',
`AlbumID` int(10) unsigned  not null default 0 COMMENT '专辑ID',
`VideoLanguage` varchar(100) COMMENT '语言',
`VideoStyle` varchar(200) COMMENT '音乐风格,用/分开,流行,电子,舞曲',
`VideoThumb` varchar(200),
`VideoDuration` int(10) unsigned COMMENT 'MTV播放时间，秒',
`VideoArea` varchar(100),
`VideoPubdate` date,
`VideoSourceID` tinyint unsigned not null default 1 COMMENT'来源,1.优酷，2.土豆 3...',
`VideoUpdateTime` timestamp,
`VideoStatus` tinyint not null default -1 COMMENT '１正常，-1未审核',
PRIMARY KEY `VideoID` (`VideoID`),
KEY VideoUpdateTime(VideoUpdateTime)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--音乐动态信息
create table s_video_extension(
`VideoID` int(10) unsigned NOT NULL,
`VideoSkipTimes` int(10) unsigned NOT NULL default 0,
`VideoUpTimes` int(10) unsigned NOT NULL default 0,
`VideoDownTimes` int(10) unsigned NOT NULL default 0,
PRIMARY KEY (`VideoID`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
--歌手名
CREATE TABLE `s_singer` (
`SingerID` int(10) unsigned not null AUTO_INCREMENT,
`SingerName` varchar(200) DEFAULT NULL,
`SingerNamePinYin` varchar(200) DEFAULT NULL,
`SingerGender`  varchar(30) DEFAULT '' COMMENT '男，女，组合',
`SingerCountry` varchar(8) NOT NULL DEFAULT "",
`SingerComment` text,
`SingerOrder` int(10) unsigned NOT NULL DEFAULT '0',
`MvCount` int(10) unsigned NOT NULL DEFAULT '0',
`SingerStatus` tinyint(4) NOT NULL default -1 COMMENT '１正常，-1未审核',
KEY `SingerName`(`SingerName`),
PRIMARY KEY (`SingerID`),
KEY `SingerStatus` (`SingerStatus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--专辑信息表
CREATE TABLE `s_album`(
`SingerIDS` varchar(200) COMMENT '歌手ID,用/分开',
`AlbumID` int(10) unsigned not null AUTO_INCREMENT,
`AlbumName` varchar(200) DEFAULT NULL,
`AlbumLanguage` varchar(20) DEFAULT NULL,
`AlbumPubDate` date,
`AlbumType` tinyint default 0,
`AlbumStyle` varchar(200) DEFAULT NULL,
`AlbumCompany` varchar(200) DEFAULT NULL,
`AlbumTotalScore` tinyint not null default 0,
`AlbumComment` text,
`AlbumCover` varchar(200),
PRIMARY KEY (`AlbumID`),
KEY (`AlbumName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


create table s_user
create table s_user_token
create table s_list
create table s_list_content
create table s_lyrics
create table s_user_action
create table s_user_listen























--打分记录，一个用户只能打分一次
create table s_video_rate(
		VideoID
		UserID
		RateTime	timestamp
)
create table s_video_comment(
		VideoID
		UserID
		CommentTitle
		CommentContent
		CommentTime timestamp
		CommentStatus 1 正常-1隐藏
);
create table s_video_status(
		VideoID
		MvRate--平均打分数
		MvTotalRate	--打人总数
		MvTotalRatePeople	--打人总人数
		MvListenTimes	--视听次数
)
create table s_video_tag(
		VideoID
		TagID
		TagName
);
create table s_video_category(
		CategoryID
		CategoryParentID	0
		CategoryName
);
create table s_source(
		source_id	1.优酷
		source_name
		source_url_pattern	--/http://v.youku.com/v_show/id_%id%.html
);
create table s_invite(
		UserID - 邀请方ID
		InviteCode -　邀请code
		InviteUserID - 邀请接收并注册成功的用户ID
		InviteCodeExpiredTime	datetime 过期时间
);
--用户积分,增加
--.邀请用户并成功得５分
--.新加mv并能过得５分
--.评分得分,一个mv只能评一次 1
--.评论得分 1
--.创建非空列表得分 2
--.列表被其它用户收藏一次加1


create table s_user_score(
		UserID
		UserScore
);
create table s_user_score_log(
		UserID
		UserScoreLog	--加分为正，消费分为负
		UserScoreTimestamp
);

--临时列表表
create table s_list_temp(
		UserID
		MvID
		MvOrder
		ListUpdateTime timestamp
)
