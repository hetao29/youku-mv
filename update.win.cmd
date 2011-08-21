rem 1.动态获取最新官方库数据命令(app/util/official.php)

rem 2.索引重做命令(app/util/rebuild.php)

rem 3.生成频道(app/util/importRadio.php)

rem 4.生成js(app/util/genjs.php)




\www\php5.2\php.exe \www\wwwroot\app\util\official.php

rem \www\php5.2\php.exe \www\wwwroot\app\util\rebuild.php

rem \www\php5.2\php.exe \www\wwwroot\app\util\importRadio.php
rem \www\php5.2\php.exe \www\wwwroot\app\util\genjs.php




rem 完全重建

rem del \www\wwwroot\app\util\sphinx.xmlpipe.log
rem \www\wwwroot\app\sphinx\win32\bin\indexer --rotate -c \www\wwwroot\app\sphinx\config\s_video.win.conf video


rem 增量重建

\www\wwwroot\app\sphinx\win32\bin\indexer --rotate -c \www\wwwroot\app\sphinx\config\s_video.win.conf video_delta

\www\wwwroot\app\sphinx\win32\bin\indexer --rotate -c \www\wwwroot\app\sphinx\config\s_video.win.conf --merge video video_delta


rem 启动服务:


net stop SlightSphinx

rem \www\wwwroot\app\sphinx\win32\bin\searchd --delete --servicename  SlightSphinx

rem \www\wwwroot\app\sphinx\win32\bin\searchd --install  -c \www\wwwroot\app\sphinx\config\s_video.win.conf --servicename  SlightSphinx

net start SlightSphinx



pause