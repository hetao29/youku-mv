<?php
/**
 * 专辑表
 * s_album
 */
class album_db{
	private $_dbConfig;
	private $_zone;
	function __construct($zone="album"){
		$this->_zone = $zone;
		$this->_dbConfig = SDb::getConfig($this->_zone);
		$this->_db = new SDb("pdo_mysql");
		$this->_db->init($this->_dbConfig);
	}
	function getAlbum($AlbumID){
		return $this->_db->selectOne("s_album",array("AlbumID"=>$AlbumID),array("AlbumID","AlbumName"));
	}
	function getAlbumName($AlbumID){
		$album = $this->_db->selectOne("s_album",array("AlbumID"=>$AlbumID),array("AlbumID","AlbumName"));
		return !empty($album['AlbumName'])?$album['AlbumName']:"";
	}
	function getAlbumByName($AlbumName,$SingerIDS){
		return $this->_db->selectOne("s_album",array("AlbumName"=>$AlbumName,"SingerIDS"=>$SingerIDS),array("AlbumID","AlbumName","SingerIDS"));
	}
	function addAlbum($Album){
		return $this->_db->insert("s_album",$Album);
	}
	function updateAlbum($Album){
		return $this->_db->update("s_special",array("AlbumID"=>$Album['AlbumID']),$Album);
	}
	function listAlbum($page,$pageSize=50){
		$this->_db->setLimit($pageSize);
		$this->_db->setPage($page);
		return $this->_db->select(
				array("s_album"),
				array(),
				array("AlbumID","AlbumName"),
				"",
				"AlbumID"
		);
	}
}
?>
