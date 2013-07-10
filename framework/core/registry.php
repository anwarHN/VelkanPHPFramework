<?php
/**
 * Velkan PHP Framework
 * Clase Registry
 * Sirve para instanciar un solo objeto cuando necesitamos llamar otros metodos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 * 
 * Propiedades generales que se crean mediante código
 * ::args - Arreglo de argumentos que se reciban mediante los metodos GET o POST, o los que se definan como internos cuando se usa el método velkan::redirect
 * ::httpArgs - Arreglo de argumentos que se reciban mediante el método velkan::redirect
 * 
 */
class registry{

	private static $_instance;
	private $_storage;
	private function __construct(){}
	
	/*En esta funcion se instancian los objetos como Registry. Asi, podemos tener objetos a lo largo del codigo como si fueran clases estaticas.*/
	public static function getInstance(){
		if(!self::$_instance instanceof self){
			self::$_instance = new Registry;
		}
		return self::$_instance;
	}
	
	/*Metodo mágico para instanciar variables*/
	public function __set($key,$val){
		$this->_storage[$key] = $val;
	}
	
	/*Metodo mágico para obtener variables*/
	public function __get($key){
		if(isset($this->_storage[$key])){
			return $this->_storage[$key];
		}
		return false;
	}
}
?>
