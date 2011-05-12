<?php
class singer_music{
	public static function encode($videoId){
		if(!self::isEncode($videoId)){
			return "X".((base64_encode($videoId<<2)));
		}else{
			return $videoId;
		}
	}
	public static function decode($videoId){
	        if(self::isEncode($videoId)){
	            return (base64_decode(substr($videoId,1)))>>2;
	        }else{
	            return $videoId;
	        }
	
	}
	private static function isEncode($videoId){
		if(stripos($videoId,"X")===0){
			return true;
		}else{
			return false;
		}
	}
}
/*
echo singer_music::encode("332");
echo "\n";
echo singer_music::decode("332");
echo "\n";
echo singer_music::decode("XMjQzMTU2MDMy");
echo "\n";
*/
