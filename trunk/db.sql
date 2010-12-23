--歌手名
/*
CREATE TABLE `s_singer` (
`SingerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
`SingerName` varchar(200) DEFAULT NULL,
`SingerGender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '男，女，组合',
`SingerNationality` varchar(100) DEFAULT NULL COMMENT '国籍',
`SingerComment` text,
`SingerOrder` int(10) unsigned NOT NULL DEFAULT '0',
`SingerStatus` tinyint(4) NOT NULL default -1 COMMENT '１正常，-1未审核',
PRIMARY KEY (`SingerID`),
UNIQUE KEY `SingerName` (`SingerName`),
KEY `SingerStatus` (`SingerStatus`),
KEY `SingerID` (`SingerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

drop table s_user;
create table s_user(
UserID int(10) unsigned NOT NULL AUTO_INCREMENT,
UserAlias varchar(200),
UserEmail varchar(200),
UserPassword varchar(200),
UserStatus tinyint not null default 1 COMMENT '1正常',

PRIMARY KEY (`UserID`),
UNIQUE KEY `UserEmail` (`UserEmail`),
KEY `UserStatus` (`UserStatus`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT into s_user(UserID,UserAlias,UserEmail,UserPassword) values(1,'hetal','hetao@hetao.name','huoqiabc');
create table s_user_token(
	UserID int(10) unsigned NOT NULL default 0,
	UserToken char(26),
	UserTokenExpiredTime int,
	PRIMARY KEY (`UserID`,`UserToken`),
	KEY `UserTokenExpiredTime` (`UserTokenExpiredTime`)
)ENGINE=HEAP DEFAULT CHARSET=utf8;


--drop table s_mv;
--s_mv表
drop table s_mv;
create table s_mv(
MvID int(10) unsigned NOT NULL AUTO_INCREMENT,
UserID int(10) unsigned NOT NULL default 0 COMMENT '增加的用户ID',
SingerName varchar(250) NOT NULL default "" COMMENT '歌手名，乐队名等，多个用,号分开',
MvTag varchar(200) COMMENT 'MTV标签,多个用,分开',
MvName varchar(200) COMMENT '视频的真实名字,用户不可修改',
MvAlias varchar(200) COMMENT 'MV的名字，编辑后的，默认和MvName一样',
MvPic varchar(200),
CategoryID int(10) unsigned NOT NULL default 0,
SpecialID int(10) unsigned NOT NULL default 0,
MvVideoID varchar(50),
MvSourceID tinyint unsigned not null default 1 COMMENT'来源,1.优酷，2.土豆 3...',
MvPubDate date,
MvSeconds varchar(10) not null default '' COMMENT 'MTV播放时间，秒',
MvUpdateTime timestamp,
MvStatus tinyint not null default -1 COMMENT '１正常，-1未审核',

PRIMARY KEY (`MvID`),
UNIQUE KEY `Mv` (`MvVideoID`,`MvSourceID`),
Key (`UserID`),
Key (`CategoryID`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

--播放列表
create table s_list(
ListID int(10) unsigned NOT NULL AUTO_INCREMENT,
UserID int(10) unsigned NOT NULL,
ListName varchar(200),
ListOrder int unsigned not null default 0,
ListStatus tinyint not null default 1,
ListCreateTime datetime,
ListUpdateTime timestamp,

PRIMARY KEY (`ListID`),
Key (`ListName`),
Key (`UserID`),
Key (`ListUpdateTime`),
Key (`ListCreateTime`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;
--列表内容
create table s_list_content(
ListID int(10) unsigned NOT NULL,
MvID int(10) unsigned NOT NULL,
MvOrder int unsigned not null default 0,

PRIMARY KEY (`ListID`,`MvID`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;



drop table s_lyrics;
create table s_lyrics(
UserID int(10) unsigned NOT NULL DEFAULT 0,
MvID int(10) unsigned NOT NULL,
LyricsOffset int NOT NULL  DEFAULT 0 COMMENT '偏移,毫秒,正数表是延迟,负数表是推前,只有当前所属用户才能修改',
LyricsContent  text,
LyricsStatus tinyint not null default 1 COMMENT'1正常 -1没审核 -2用户报错',

UNIQUE (`MvID`),
KEY (`UserID`),
KEY (`LyricsStatus`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;

--用户喜欢的歌
create table s_user_fav(
UserID int not null default 0,
MvID int not null default 0,
FavTime	timestamp,
UNIQUE KEY `FavID` (`UserID`,MvID),
KEY `FavTime` (`FavTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--用户听过的歌
drop table s_user_listen;
create table s_user_listen(
UserID int not null default 0,
MvID int not null default 0,
ListenTime	timestamp,
ListenTotal int not null default 1,
UNIQUE KEY `ListenID` (`UserID`,MvID),
KEY ListenTime(`ListenTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
























--打分记录，一个用户只能打分一次
create table s_mv_rate(
		MvID
		UserID
		RateTime	timestamp
)
create table s_mv_comment(
		MvID
		UserID
		CommentTitle
		CommentContent
		CommentTime timestamp
		CommentStatus 1 正常-1隐藏
);
create table s_mv_status(
		MvID
		MvRate--平均打分数
		MvTotalRate	--打人总数
		MvTotalRatePeople	--打人总人数
		MvListenTimes	--视听次数
)
create table s_mv_tag(
		TagID
		TagName
);
create table s_mv_category(
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
