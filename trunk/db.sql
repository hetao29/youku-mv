--歌手名
create table s_singer(
								SingerID
								SingerName
								SingerGender --男，女，组合
								SingerNationality	--国籍
								SingerComment
								SingerOrder
								SingerStatus	--１正常，-1未审核
);
--专辑名(保留)
--create table s_special(
--								SpecialID
--								SpecialName
--								SingerID
--								SpecialPubDate
--)
--mv表
create table s_mv(
								MvID
								UserID	--增加的用户ID
								SingerIDS	--歌手信息
								MvTagIDS	--MTV标签
								MvName
								MvPic
								CategoryID	--分类ID
								SpecialID	--0
								MvVideoID	--视频ID
								MvSourceID	--来源,优酷，土豆
								MvPubDate
								MvTime	--MTV播放时间
								MvUpdateTime	timestamp
								MvStatus	--１正常，-1未审核
);
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
								source_id
								source_name
								source_url_pattern	--/http://v.youku.com/v_show/id_%id%.html
);
create table s_user(
								UserID
								UserName
								UserEmail
								UserPassword
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
--播放列表
create table s_list(
								ListID
								UserID
								ListName
								ListType
								ListStatus
								ListCreateTime
								ListUpdateTime timestamp
)
--列表内容
create table s_list_content(
								ListID
								MvID
)
--临时列表表
create table s_list_temp(
								UserID
								MvID
								ListUpdateTime timestamp
)
create table s_listen_log(
								UserID
								MvID
								ListenTime	timestamp
)
