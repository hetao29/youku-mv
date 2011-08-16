rem 1.动态获取最新官方库数据命令(app/util/official.php)
rem 2.索引重做命令(app/util/rebuild.php)
rem 3.生成频道(app/util/importRadio.php)
rem 4.生成js(app/util/genjs.php)


\www\php5.3\php.exe \www\wwwroot\app\util\official.php
\www\php5.3\php.exe \www\wwwroot\app\util\rebuild.php
\www\php5.3\php.exe \www\wwwroot\app\util\importRadio.php


完全重建
indexer --rotate -c s_video.conf video
增量重建
indexer --rotate -c s_video.conf video_delta
indexer --rotate -c s_video.conf --merge video video_delta
启动服务:
searchd -c config/s_video.conf -i video
