<?php
/*自动音乐频道*/

$config =	array(
				array(
					"ListID"=>"1",
					"ListName"=>"去年流行金曲",
					"QUERY"=>'@videoarea "台湾" | "大陆" | "香港"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20100101,20110100)
								),
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"2",
					"ListName"=>"2011年国语新曲	",
					"QUERY"=>'@videoarea "台湾" | "大陆" | "香港"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"3",
					"ListName"=>"2011年日韩新曲",
					"QUERY"=>'@videoarea "日本" | "韩国"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"4",
					"ListName"=>"2011年欧美新曲",
					
					"QUERY"=>'@videolanguage "英语" | "其它"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),
			);

chdir(dirname(__FILE__));
require("../../global.php");

$user_db  = new user_db;

foreach( $config as $t){
	print_r($t);
	
			$sphinx_api = new sphinx_api();



			foreach($t['SetFilterRange'] as $k=>$v){
				$sphinx_api->SetFilterRange($k,$v[0],$v[1]);
			}
			$items=$sphinx_api->query($t['QUERY'],$t['LIMIT']);
			//查出来后，清空原来的列表
			$user_db->emptyList($t['ListID']);
			$i=0;
			foreach($items as $i=>$item){
					$user_db->addListContent($t['ListID'],$item['VideoID'],$i++);
			}
			var_dump(count($items));
	echo "SUCCESS\n";
}
	