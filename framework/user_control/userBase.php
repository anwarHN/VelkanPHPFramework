<?php
/**
 * Velkan PHP Framework
 * Control de usuario
 * Clase predeterminada para el control de usuarios
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
abstract class userBase{
	var $user;
	var $pass;
	var $name;
	
	var $_registry;
	
	var $properties=array();
	var $selfDataBConnection=array();
	
	function __construct($user, $pass){
		$this->_registry=registry::getInstance();
		$this->user=$user;
		$this->pass=$pass;
		db::getAdapter();
	}
	
	function login(){}
	
	function logout(){}
	
	final public function __get($key){
		if($return = $this->_registry->$key){
			return $return;
		}
		return false;
	}
	
	/**
	 * Se disparará cuando el archivo de informacion no sea encontrado.
	 */
	function noDataFound(){}
	
	/**
	 * Sirve para definir datos de conexion para un usuario en particular.
	 * 
	 * @param string $host
	 * @param string $datab
	 * @param string $user
	 * @param string $pass
	 */
	final function setSelfDataBaseConnection($host,$datab,$user,$pass){
		$this->selfDataBConnection=array("dbc_host"=>$host,"dbc_database"=>$datab,"dbc_user"=>$user,"dbc_pass"=>$pass);
	}
}
?>