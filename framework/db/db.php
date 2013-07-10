<?php
/**
 * Velkan PHP Framework
 * Clase controladora para la base de datos
 *
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */

class db{
	static $FETCH_TYPE_BOTH=0;
	static $FETCH_TYPE_ASSOC=1;
	static $FETCH_TYPE_NUM=2;
	
	static function getAdapter(){
		$_registry=Registry::getInstance();
		if(!isset($_registry->db)){
			$adapter=velkan::$configDB["adapter"];
			include_once SITE_PATH.'framework/db/adapters/'.$adapter.".php";
			$_registry->db=new $adapter;
		}
	}
	
	static function checkRealEscapeString($value,$searhToken=false){
		
		if($searhToken){
			$value='%'.str_replace(" ", "%", $value)."%";
		}
		$_registry=Registry::getInstance();
		
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		
		return $_registry->db->checkRealEscapeString($value);
	}
	
	static function connect(){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		$_registry->db->connect();
	}
	
	
	static function close(){
		$_registry=Registry::getInstance();
		$_registry->db->close();
	}
	
	static function begin(){
		$_registry=Registry::getInstance();
		$_registry->db->begin();
	}
	
	static function commit(){
		$_registry=Registry::getInstance();
		$_registry->db->commit();
	}
	
	static function rollback(){
		$_registry=Registry::getInstance();
		$_registry->db->rollback();
	}
	
	static function query($sql,$calculateRows=false,$fastHint=false){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->query($sql,$calculateRows,$fastHint);
	}
	
	static function exec($sql){
		$_registry=Registry::getInstance();
		return $_registry->db->exec($sql);
	}
	
	static function fetch($type=0){
		$_registry=Registry::getInstance();
		return $_registry->db->fetch($type);
	}
	
	static function getArray(){
		$_registry=Registry::getInstance();
		return $_registry->db->getArray();
	}
	
	static function freeResult(){
		$_registry=Registry::getInstance();
		$_registry->db->freeResult();
	}
	
	static function getLastInsertedID(){
		$_registry=Registry::getInstance();
		return $_registry->db->getLastInsertedID();
	}
	
	
	static function getByID($table,$field,$value){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->getByID($table,$field,$value);
	}
	
	
	static function getFields($table,$fields="",$condition="",$order="",$limit="",$calculateRows=false,$fastHint=false){
		$_registry=Registry::getInstance();
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		return $_registry->db->getFields($table,$fields,$condition,$order,$limit,$calculateRows,$fastHint);
	}
	
	
	static function insert($table,array $data){
		$_registry=Registry::getInstance();
		return $_registry->db->insert($table,$data);
	}
	
	
	static function update($table,array $updates,$conditions){
		$_registry=Registry::getInstance();
		return $_registry->db->update($table,$updates,$conditions);
	}
	
	
	static function delete($table, array $conditions){
		$_registry=Registry::getInstance();
		return $_registry->db->delete($table, $conditions);
	}
	
	
	static function setDatabaseConnection($host,$database,$user,$pass){
		$_registry=Registry::getInstance();
		$_registry->db->setDatabaseConnection($host,$database,$user,$pass);
	}
	
	static function getNumCols(){
		$_registry=Registry::getInstance();
		return $_registry->db->getNumCols();
	}
	
	static function getNumRows(){
		$_registry=Registry::getInstance();
		return $_registry->db->getNumRows();
	}

	static function setFetchType($type){
		$_registry=Registry::getInstance();
		$_registry->db->setFetchType($type);
	}
	
	static function getCalculatedRows(){
		$_registry=Registry::getInstance();
		return $_registry->db->getCalculatedRows();
	}
	
	static function getError(){
		$_registry=Registry::getInstance();
		return $_registry->db->getError();
	}
	
	static function formatDateForDisplay($field){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateForDisplay($field);
	}
	
	static function formatDateValueForQuery($date){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateValueForQuery($date);
	}
	
	static function formatDateValueForSaving($date){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateValueForSaving($date);
	}
	
	static function formatTimeForDisplay($field){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatTimeForDisplay($field);
	}
	
	static function formatTimeValueForQuery($time){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatTimeValueForQuery($time);
	}
	
	static function formatTimeValueForSaving($time){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatTimeValueForSaving($time);
	}
	
	static function formatDateTimeForDisplay($field){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateTimeForDisplay($field);
	}
	
	static function formatDateTimeValueForQuery($dateTime){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateTimeValueForQuery($dateTime);
	}
	
	static function formatDateTimeValueForSaving($dateTime){
		if(!isset($_registry->db)){
			self::getAdapter();
		}
		$_registry=Registry::getInstance();
		return $_registry->db->formatDateTimeValueForSaving($dateTime);
	}
}
?>