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
		$this->_db = SDb::getDbEngine("pdo_mysql");
		$this->_db->init($this->_dbConfig);
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
				"*",
				"ORDER BY Album"
		);
	}
}
?>
