#!/bin/sh
#1.动态获取最新官方库数据命令(app/util/official.php)
#2.索引重做命令(app/util/rebuild.php)
#3.生成频道(app/util/importRadio.php)
#4.生成js(app/util/genjs.php)


php -c /opt/youku-fm-read-only/php.ini /opt/youku-fm-read-only/app/util/official.php

#完全重建
rm /opt/youku-fm-read-only/app/util/sphinx.xmlpipe.log
/usr/local/sphinx/bin/indexer --rotate -c /opt/youku-fm-read-only/app/sphinx/config/s_video.conf video
#增量重建
#/usr/local/sphinx/bin/indexer --rotate -c /opt/youku-fm-read-only/app/sphinx/config/s_video.conf video_delta
#/usr/local/sphinx/bin/indexer --rotate -c /opt/youku-fm-read-only/app/sphinx/config/s_video.conf --merge video video_delta
#启动服务:
#/usr/local/sphinx/bin/searchd -c /opt/youku-fm-read-only/app/sphinx/config/s_video.conf -i video
php -c /opt/youku-fm-read-only/php.ini /opt/youku-fm-read-only/app/util/importRadio.php
