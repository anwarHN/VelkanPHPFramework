<?php
/**
 * Velkan PHP Framework
 * Encriptacion
 * Control de los metodos de encriptacion y dencriptacion
 * Se basa en otras clases, debe especificarse los metodos encrypt y decrypt
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class vcrypt{
	static function encrypt($key,$data){
		/*$cipher=MCRYPT_DES;
		return @mcrypt_ecb($cipher,$key,$data,MCRYPT_ENCRYPT);*/
		
		$cc = $data;
		$iv = velkan::$config["cypher"]["iv"];
		
		$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
		
		mcrypt_generic_init($cipher, $key, $iv);
		$encrypted = mcrypt_generic($cipher,$cc);
		mcrypt_generic_deinit($cipher);
		return $encrypted;
		
		/*
		$Cipher = new AES(AES::AES256);
		$content = $Cipher->stringToHex($data);
		$content = $Cipher->encrypt($content, $key);
		
		return $content;*/
	}
	static function decrypt($key,$data){
		/*$cipher=MCRYPT_DES;
		return @mcrypt_ecb($cipher,$key,$data,MCRYPT_DECRYPT);*/
		
		$encrypted = $data;
		$iv = velkan::$config["cypher"]["iv"];
		
		$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
		mcrypt_generic_init($cipher, $key, $iv);
		$decrypted = @mdecrypt_generic($cipher,$encrypted);
		mcrypt_generic_deinit($cipher);
		return $decrypted;
	}
	
	static function aesCrypt($key,$data){
		include_once "framework/core/cryptClass/AES.class.php";
		include_once "framework/core/cryptClass/AESCipher.class.php";
		
		$Cipher = new AES(AES::AES256);
		$content = $Cipher->stringToHex($data);
		$content = $Cipher->encrypt($content, $key);
		
		return $content;
	}
}
?>