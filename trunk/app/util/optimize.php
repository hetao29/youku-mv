<?php
/**
 * 重作所有索引
 */
chdir(dirname(__FILE__));
require("../../global.php");
$search_api = new search_api;
$search_api->optimize();
