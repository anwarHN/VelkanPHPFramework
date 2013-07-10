<?php
/**
 * Velkan PHP Framework
 * Cache functions control
 * 
 * Sirve para guardar funciones a ejecutar por medio de ajax y para que el usuario
 * no tenga que escribirlas en código
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class cacheFunction{
	static function saveCacheFunction($id,$function){
		if(!isset($_SESSION["cacheFunctions"])){
			$_SESSION["cacheFunctions"]=array();
		}
		$_SESSION["cacheFunctions"][$id]=$function;
	}
}