<?php
exit;
chdir(dirname(__FILE__));
include("../../global.php");
include("../player/db.class.php");
include("../player/api.class.php");
$db = new singer_db;
$singers = $db->listSinger(1,-1);
$w = base64_decode("MXRpbmc=");
foreach($singers->items as $singer){
		preg_match("/_(.+?)\.html/i",$singer['_TmpUrl'],$_m);
		$id = $_m[1];
		$singerid=$singer['SingerID'];
		$url = "http://www.$w.com/singer/$id/album/1";
		$content = file_get_contents($url);
		//算出有多少页
		preg_match("/cPages(.+?)div/i",$content,$_m);
		preg_match_all("/href=\"(.+?)\"/",$_m[1],$_m2);
		$specials=getSpecial($content,$singerid);
		if(!empty($_m2[1])){
				//有多页
				$i=0;
				foreach($_m2[1] as $_t){
						$i++;
						if($i==0)continue;
						$_tmpurl="http://www.$w.com/".$_t;
						$content = file_get_contents($_tmpurl);
						$specials=getSpecial($content);

						//echo $_tmpurl."\n";
				}
		}else{
				//１页
		}
		usleep(10);
}
function getSpecial($content,$singerid){
		global $db;
		global $w;
		preg_match("/albumList(.+?)div/ims",$content,$_m);
		//print_r($_m);
		preg_match_all("/\<li(.+?)li\>/ims",$_m[0],$_m2);
		//print_r($_m2[0]);
		$specials=array();
		foreach($_m2[0] as $li){
			$special=array();
			$special['SingerID']=$singerid;
			//name
			preg_match("/albumName\"\>(.+?)\</ims",$li,$_m);
			$special['SpecialName']=trim($_m[1]);
			//url
			preg_match("/href=\"(.+?)\" class=\"albumLink\"\>/ims",$li,$_m);
			$special['_TmpUrl']="http://www.$w.com".($_m[1]);
			//pubdate
			preg_match("/href=\"\/arch.+?\">(.+?)\</ims",$li,$_m);
			$special['SpecialPubDate']=trim($_m[1]);
			$db->addSpecial($special);
			print_r($special);
		}
}
exit;
