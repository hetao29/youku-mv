<?php
/*自动音乐频道*/

$config =	array(


				array(
					"ListID"=>"57",
					"ListName"=>"华语 MHZ",
					//"QUERY"=>'@videolanguage "国语" | "普通话"',
					"QUERY"=>'@videolanguage "普通话"',
					"SetFilterRange"=>array(
									//"videopubdate"=>array(20100101,20110100)
								),
					"LIMIT"=>10000
				),

				array(
					"ListID"=>"58",
					"ListName"=>"粤语 MHZ",
					"QUERY"=>'@videolanguage "粤语"',
					"SetFilterRange"=>array(
									//"videopubdate"=>array(20100101,20110100)
								),
					"LIMIT"=>10000
				),



				array(
					"ListID"=>"59",
					"ListName"=>"欧美 MHZ",
					
					//"QUERY"=>'@videoarea "欧美"',
					
					"QUERY"=>'@videolanguage "英语" | "其它"',
					"SetFilterRange"=>array(
									//"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),

				array(
					"ListID"=>"60",
					"ListName"=>"日语 MHZ",
					
					"QUERY"=>'@videolanguage "日语"',
					"SetFilterRange"=>array(
									//"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),

				array(
					"ListID"=>"61",
					"ListName"=>"韩语 MHZ",
					
					"QUERY"=>'@videolanguage "韩语"',
					"SetFilterRange"=>array(
									//"videopubdate"=>array(20110101,20120100)
								),
					"LIMIT"=>10000
				),




				array(
					"ListID"=>"63",
					"ListName"=>"70后 MHZ",
					
					"QUERY"=>'',
					"SetFilterRange"=>array(
									"videopubdate"=>array(19700101,19860101)
								),
					"LIMIT"=>10000
				),
				array(
					"ListID"=>"64",
					"ListName"=>"80后 MHZ",
					
					"QUERY"=>'',
					"SetFilterRange"=>array(
									"videopubdate"=>array(19800101,19960101)
								),
					"LIMIT"=>10000
				),

				array(
					"ListID"=>"65",
					"ListName"=>"90后 MHZ",
					
					"QUERY"=>'',
					"SetFilterRange"=>array(
									"videopubdate"=>array(19900101,20060101)
								),
					"LIMIT"=>10000
				),





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
					"ListID"=>"370",
					"ListName"=>"2012年国语新曲	",
					"QUERY"=>'@videoarea "台湾" | "大陆" | "香港"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20120101,20130100)
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
					"ListID"=>"467",
					"ListName"=>"2012年日韩新曲",
					"QUERY"=>'@videoarea "日本" | "韩国"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20120101,20130100)
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
				array(
					"ListID"=>"466",
					"ListName"=>"2012年欧美新曲",
					
					"QUERY"=>'@videolanguage "英语" | "其它"',
					"SetFilterRange"=>array(
									"videopubdate"=>array(20120101,20130100)
								),
					"LIMIT"=>10000
				),
			);

chdir(dirname(__FILE__));
require("../../global.php");

$user_db  = new user_db;

error_log("\nSTART:".date("Y-m-d H:i:s")."\n",3,"/tmp/importRadio.log");
foreach( $config as $t){
	print_r($t);
	error_log(var_export($t,true),3,"/tmp/importRadio.log");

	$sphinx_api = new sphinx_api();



	foreach($t['SetFilterRange'] as $k=>$v){
		$sphinx_api->SetFilterRange($k,$v[0],$v[1]);
	}
	$items=$sphinx_api->query($t['QUERY'],$t['LIMIT']);
	var_dump(count($items));
	error_log(count($items),3,"/tmp/importRadio.log");
	//查出来后，清空原来的列表
	$user_db->emptyList($t['ListID']);
	$i=0;
	foreach($items as $i=>$item){
		$user_db->addListContent($t['ListID'],$item['VideoID'],$i++);
	}
	echo "SUCCESS\n";
}
error_log("\nEND:".date("Y-m-d H:i:s")."\n",3,"/tmp/importRadio.log");
