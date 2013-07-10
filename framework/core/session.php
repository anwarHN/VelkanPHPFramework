<?php
/**
 * Velkan PHP Framework
 * Clase Sesion
 * Desde aqui controlaran las sesiones del usuasio
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */

class vsess{
	protected $savePath;
	protected $sessionName;
	protected $name;
	
	function __construct() {
		session_set_save_handler(
		array($this, "open"),
		array($this, "close"),
		array($this, "read"),
		array($this, "write"),
		array($this, "destroy"),
		array($this, "gc")
		);
		
		register_shutdown_function('session_write_close');
	}
	
	function open($sess_path, $session_name){
		global $_sess_data;
		
		$this->savePath=$sess_path;
		$this->sessionName=$session_name;
		
		$name="vsess";
		
		$this->name=$name;
		
		$md5=md5(session_id());
		$token=vcrypt::aesCrypt($md5, session_id());
		
		$registry=registry::getInstance();
		$registry->token=$token;
		/*$_sess_data["int"]["key"]=$token;*/
		$_sess_data["int"]["filename"]=$filename=$sess_path."/$name".md5(session_id().$md5);
		
		if (!file_exists($filename)){
			fclose(fopen($filename,'w'));
		}
		
		if (!$_sess_data['int']['fd']=fopen($filename,'r')){
			$_sess_data['data']=serialize(array());
			return 0;
		}
		
		$data_enc="";
		if(filesize($filename)>0){
			$data_enc=fread($_sess_data['int']['fd'],filesize($filename));
		}
		
		fclose($_sess_data['int']['fd']);
		
		if ($data_enc!=""){
			$data=vcrypt::decrypt($token, $data_enc);
		}else{
			$data="";
		}
		
		
		$_sess_data['data']=$data;
		$_sess_data['int']['hash']=md5($_sess_data['data']);
		
		return 1;
	}

	function close(){
		return true;
	}
	
	function read($key){
		return $GLOBALS['_sess_data']['data'];
	}
	
	function write($id,$data){
		global $_sess_data;
		
		$sd=$data;
		
		if ($_sess_data["int"]["hash"] != md5($sd)){
			
			$fd=fopen($_sess_data["int"]["filename"],"w");
			
			$registry=registry::getInstance();
			$data=vcrypt::encrypt($registry->token, $sd);
			unset($registry);
			
			fputs($fd,$data);
			
			fclose($fd);
			
			chmod($_sess_data["int"]["filename"],0600);
		}
	}
	
	function destroy($key){
		setcookie("vsess","");
		@unlink($GLOBALS["_sess_data"]["int"]["filename"]);
		unset($GLOBALS['_sess_data']);
		session_regenerate_id();
		return true;
	}
	
	function gc($maxlifetime){
		user::destroy();
	}
}

class session{
	static function _getId(){
		return session_id();
	}
	static function _getToken(){
		$registry=registry::getInstance();
		/*return $GLOBALS["_sess_data"]["int"]["key"];*/
		return $registry->token;
	}
	static function _endSession(){
		if(self::_sessionStarted()){
			user::destroy();
			session_destroy();
			session_write_close();
		}
	}
	static function _beginSession(){
		session_start();
		/*Bandera para determinar si se inicio la sesion antes de destruirla*/
		$_SESSION["started"]=true;
		if(!isset($_SESSION["thisAccess"])){
			$_SESSION["thisAccess"]=time();
		}else{
			$_SESSION["lastAccess"]=$_SESSION["thisAccess"];
			$_SESSION["thisAccess"]=time();
		}
	}
	
	static function _set($name,$value){
		$_SESSION[$name]=$value;
	}
	static function _get($name){
		if(isset($_SESSION[$name])){
			return $_SESSION[$name];
		}else{
			return false;
		}
	}
	static function _sessionStarted(){
		if(isset($_SESSION['started'])){
			return true;
		}else{
			return false;
		}
	}
	static function _validateLifeTime(){
		$time=time();
		$lifeTime=(int)velkan::$config["session"]["lifeTime"];
		$lastAccess = (int)$_SESSION["lastAccess"];
		if(($time-$lastAccess)<=$lifeTime){
			return true;
		}
		
		return false;
	}
}

session_save_path(velkan::$config["session"]["savePath"]);

new vsess();
?>