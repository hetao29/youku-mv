--歌手名
CREATE TABLE `s_singer` (
`_TmpUrl` varchar(250),
`_Finished` tinyint not null default 0,
`SingerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
`SingerName` varchar(200) DEFAULT NULL,
`SingerNamePinYin` varchar(200) DEFAULT NULL,
`SingerGender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '男，女，组合',
`SingerCountry` varchar(8) NOT NULL DEFAULT "",
`SingerType` int(10) NOT NULL DEFAULT 0,
`SingerComment` text,
`SingerOrder` int(10) unsigned NOT NULL DEFAULT '0',
`MvCount` int(10) unsigned NOT NULL DEFAULT '0',
`SingerStatus` tinyint(4) NOT NULL default -1 COMMENT '１正常，-1未审核',
PRIMARY KEY (`SingerID`),
UNIQUE KEY `SingerName` (`SingerName`,`SingerType`),
KEY `SingerStatus` (`SingerStatus`),
KEY `SingerType` (`SingerType`),
KEY `SingerID` (`SingerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `s_special`(
`_TmpUrl` varchar(250),
`_Finished` tinyint not null default 0,
`SpecialID` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`SingerID` int(10) unsigned NOT NULL default 0, 
`SpecialName` varchar(200) DEFAULT NULL,
`SpecialLanguage` varchar(20) DEFAULT NULL,
`SpecialPubDate` date,
`SpecialType` tinyint default 0,
`SpecialStyle` varchar(200) DEFAULT NULL,
`SpecialCompany` varchar(200) DEFAULT NULL,
`SpecialTotalScore` tinyint not null default 0,
`SpecialComment` text,
`SpecialCover` varchar(200),
`_TmpSpecialCover` varchar(200),
PRIMARY KEY(`SpecialID`),
UNIQUE KEY `SpecialName` (`SpecialName`,`SingerID`),
KEY SingerID(`SingerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/**
音乐表
*/
CREATE TABLE `s_music`(
`_Finished` tinyint not null default 0,
`MusicID` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`SingerID` int(10) unsigned NOT NULL default 0,
`SpecialID` int(10) unsigned NOT NULL default 0,
`MusicName` varchar(200),
`MusicPubdate` date,
`VideoID` int(10) unsigned NOT NULL default 0,
PRIMARY KEY (`MusicID`),
KEY `VideoID` (`VideoID`),
UNIQUE KEY `MusicName` (`MusicName`,`SpecialID`),
KEY `MusicPubdate` (`MusicPubdate`),
KEY `SpecialID` (`SpecialID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/**
音乐和视频临时关联表
*/
CREATE TABLE `s_music_video`(
`MusicID` int(10) unsigned NOT NULL, 
`VideoID` int(10) unsigned NOT NULL default 0,
`title` varchar(250),
`snapshot` varchar(200),
`duration` varchar(20),
`author` varchar(200),
`pubDate` datetime,
`pv` int,
UNIQUE KEY `MusicID` (`MusicID`,`VideoID`),
KEY `pubDate` (`pubDate`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `s_singer_profile` (
`SingerID` int(10) unsigned NOT NULL ,
PRIMARY KEY (`SingerID`),
KEY `SingerStatus` (`SingerStatus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
ParterID 1:Youku
*/
drop table s_user;
create table s_user(
UserID int(10) unsigned NOT NULL AUTO_INCREMENT,
UserAlias varchar(200),
UserEmail varchar(200),
ParterID int(10) unsigned NOT NULL default 0 COMMENT '0站外合作伙伴,1优酷,2新浪',
UserPassword varchar(200) COMMENT "用户密码",
UserStatus tinyint not null default 1 COMMENT '1正常',
UserType tinyint(10) unsigned NOT NULL default 0 COMMENT '用户组,0普通用户,1管理员',

PRIMARY KEY (`UserID`),
UNIQUE KEY `UserEmail` (`UserEmail`,`ParterID`),
KEY `UserStatus` (`UserStatus`)
)ENGINE=MyISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
INSERT into s_user(UserID,UserAlias,UserEmail,UserPassword) values(1,'hetal','hetao@hetao.name','huoqiabc');
create table s_user_token(
	UserID int(10) unsigned NOT NULL default 0,
	UserToken char(26),
	UserTokenExpiredTime int,
	PRIMARY KEY (`UserID`,`UserToken`),
	KEY `UserTokenExpiredTime` (`UserTokenExpiredTime`)
)ENGINE=HEAP DEFAULT CHARSET=utf8;


drop table s_video;
create table s_video(
VideoID int(10) unsigned NOT NULL,
UserID int(10) unsigned NOT NULL default 0 COMMENT '增加的用户ID',
MvTag varchar(200) COMMENT 'MTV标签,多个用,分开',
MvName varchar(200) COMMENT '视频的真实名字,用户不可修改',
MvAlias varchar(200) COMMENT 'MV的名字，编辑后的，默认和MvName一样',
MvPic varchar(200),
MvSkipTimes int(10) unsigned NOT NULL default 0,
MvUpTimes int(10) unsigned NOT NULL default 0,
MvDownTimes int(10) unsigned NOT NULL default 0,
CategoryID int(10) unsigned NOT NULL default 0,
MvSourceID tinyint unsigned not null default 1 COMMENT'来源,1.优酷，2.土豆 3...',
MvPubDate date,
MvSeconds varchar(10) not null default '' COMMENT 'MTV播放时间，秒',
MvUpdateTime timestamp,
MvStatus tinyint not null default -1 COMMENT '１正常，-1未审核',

PRIMARY KEY (`VideoID`),
UNIQUE KEY `Mv` (`MvVideoID`,`MvSourceID`),
Key (`UserID`),
Key (`CategoryID`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

--播放列表
drop table s_list;
create table s_list(
ListID int(10) unsigned NOT NULL AUTO_INCREMENT,
UserID int(10) unsigned NOT NULL default 0 COMMENT '0表示系统用户',
ListName varchar(200),
ListType tinyint unsigned NOT NULL default 0 COMMENT '列表类型,0表示用户自已建立的,1表示频道',
ListCount int unsigned NOT NULL default 0 COMMENT '总数',
ListOrder int unsigned not null default 0,
EditOrder int unsigned not null default 0 COMMENT '编辑指定的频道顺序',
ListStatus tinyint not null default 1,
ListCreateTime datetime,
ListUpdateTime timestamp,

PRIMARY KEY (`ListID`),
Key (`ListName`),
Key (`ListOrder`),
Key (`UserID`),
Key (`ListType`),
Key (`ListUpdateTime`),
Key (`ListCreateTime`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;
--列表内容
create table s_list_content(
ListID int(10) unsigned NOT NULL,
VideoID int(10) unsigned NOT NULL,
MvOrder int unsigned not null default 0,

PRIMARY KEY (`ListID`,`VideoID`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;



drop table s_lyrics;
create table s_lyrics(
UserID int(10) unsigned NOT NULL DEFAULT 0,
VideoID int(10) unsigned NOT NULL,
LyricsOffset int NOT NULL  DEFAULT 0 COMMENT '偏移,毫秒,正数表是延迟,负数表是推前,只有当前所属用户才能修改',
LyricsContent  text,
LyricsStatus tinyint not null default 1 COMMENT'1正常 -1没审核 -2用户报错',

UNIQUE (`VideoID`),
KEY (`UserID`),
KEY (`LyricsStatus`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;
--用户行为表
--ActionType 
--0 喜欢(up)
--1 删除(down)
--2 跳过(skip)
--用户顶,踩的歌,一个视频可以顶,也可以踩,踩过的视频不再给用户播放
create table s_user_action(
UserID int not null default 0,
VideoID int not null default 0,
ActionType int not null default 0,
ActionTime timestamp,
UNIQUE KEY `Action` (`UserID`,VideoID,ActionType),
KEY `ActionTime` (`ActionTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--跳过的视频,跳过的视频表示用户不喜欢,也不给用户推荐

--用户听过的歌
drop table s_user_listen;
create table s_user_listen(
UserID int not null default 0,
VideoID int not null default 0,
ListenTime	timestamp,
ListenTotal int not null default 1,
UNIQUE KEY `ListenID` (`UserID`,VideoID),
KEY ListenTime(`ListenTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
























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
