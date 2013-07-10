<?php
/**
 * Velkan PHP Framework
 * User Global
 * Clase para acceder a la informacion del usuario sin crear objetos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class user{
	static $userFileName;
	static $userFileKey;
	
	private static function setFileName(){
		self::$userFileName=hash("sha1",md5(session::_getToken()));
		self::$userFileKey=hash("sha1",md5(session::_getId()));
	}
	
	static function login($user, $pass){
		if(!session::_sessionStarted()){
			session::_beginSession();
		}
		
		self::setFileName();
		
		$filename=velkan::$config["session"]["userControl"]["savePath"]."/".self::$userFileName;
		$keyFile=self::$userFileKey;
		
		$_user = new userControl($user, $pass);
		if($_user->login()){
			if (!file_exists($filename)){
				fclose(fopen($filename,'w'));
			}
			
			$fd=fopen($filename,"w");
			
			$data="user:$user|pass:$pass";
			
			foreach($_user->properties as $key=>$val){
				$data.="|$key:$val";
			}
			
			if(!empty($_user->selfDataBConection)){
				foreach($_user->selfDataBConnection as $key=>$val){
					$data.="|$key:$val";
				}
			}
			
			$data=vcrypt::encrypt($keyFile, $data);
			fputs($fd,$data);
			fclose($fd);
			chmod($filename,0600);
			
			return true;
		}
		return false;
	}
	
	static function destroy(){
		self::setFileName();
		
		$filename=velkan::$config["session"]["userControl"]["savePath"]."/".self::$userFileName;
		
		if (file_exists($filename)){
			@unlink($filename);
		}
	}
	
	static function get($key){
		self::setFileName();
		
		$filename=velkan::$config["session"]["userControl"]["savePath"]."/".self::$userFileName;
		$filekey=self::$userFileKey;
				
		if(is_readable($filename)){
			$cont=file_get_contents($filename);
		}else{
			self::noDataFound();
		}
		
		$cont=vcrypt::decrypt($filekey, $cont);
		
		$vars=explode("|",$cont);
		
		foreach($vars as $var){
			$dataV=explode(":", $var);
			$data[$dataV[0]]=$dataV[1];
		}
		
		
		
		if(key_exists($key, $data)){
			return $data[$key];
		}
		return "";
	}
	
	static function getVarius(array $varius){
		self::setFileName();
		
		$filename=velkan::$config["session"]["userControl"]["savePath"]."/".self::$userFileName;
		$filekey=self::$userFileKey;
		
		if(is_readable($filename)){
			$cont=file_get_contents($filename);
		}else{
			return false;
		}
		
		$cont=vcrypt::decrypt($filekey, $cont);
		
		$vars=explode("|",$cont);
		
		foreach($vars as $var){
			$dataV=explode(":", $var);
			$data[$dataV[0]]=$dataV[1];
		}
		
		$ret=array();
		foreach($varius as $var){
			if(key_exists($var, $data)){
				$ret[$var]=$data[$var];
			}
		}
		
		return $ret; 
	}
	
	static function getSelfDataBaseConnection(){
		$data=self::getVarius(array("dbc_host","dbc_database","dbc_user","dbc_pass"));
		if(!$data){
			return false;
		}
		if(!empty($data)){
			$dataU=array("host"=>$data["dbc_host"],"database"=>$data["dbc_database"],"user"=>$data["dbc_user"],"pass"=>$data["dbc_pass"]);
			return $dataU;
		}
		
		return false;
	}
	
	static function _isDataInitialized(){
		self::setFileName();
		
		$filename=velkan::$config["session"]["userControl"]["savePath"]."/".self::$userFileName;
		
		if(is_readable($filename)){
			return true;
		}else{
			return false;
		}
	}
	
	static function noDataFound(){
		$_user = new userControl($user, $pass);
		$_user->noDataFound();
		unset($_user);
	}
	
	static function setCurrentConection($host,$datab){
		
	}
}
?>