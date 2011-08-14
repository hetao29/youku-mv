<?php
/*自动音乐频道*/

$config =	array(
				array(
					"ListID"=>"1",
					"ListName"=>"去年流行金曲",
					"QUERY"=>"VideoPubdate:[20100101 TO 20110100] AND AND VideoArea:(台湾 大陆 香港)",
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"2",
					"ListName"=>"2011年国语新曲	",
					"QUERY"=>"VideoPubdate:[20110101 TO 20120100] AND AND VideoArea:(台湾 大陆 香港)",
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"3",
					"ListName"=>"2011年日韩新曲",
					"QUERY"=>"VideoPubdate:[20110101 TO 20120100] AND VideoArea:(日本 韩国)",
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"4",
					"ListName"=>"2011年欧美新曲",
					"QUERY"=>"VideoPubdate:[20110101 TO 20120100] AND VideoLanguage:(英语 其它)",
					"LIMIT"=>10000
				),
			);

chdir(dirname(__FILE__));
require("../../global.php");

$user_db  = new user_db;
$search_api = new search_api("data");

foreach( $config as $t){
	print_r($t);
				$items=$search_api->query($t['QUERY'],$t['LIMIT'],false);
				//查出来后，清空原来的列表
				$user_db->emptyList($t['ListID']);
				$i=0;
				foreach($items as $i=>$item){
						$user_db->addListContent($t['ListID'],$item['VideoID'],$i++);
				}
	echo "SUCCESS\n";
}
	