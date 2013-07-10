<?php
/**
 * Velkan PHP Framework
 * Clase Error
 * Sirve para desplegar los errores segun el codigo
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class Error{
	
	static function display_error($args){
		extract($args);
		require(SITE_PATH."framework/errors/$error.php");
		
	}
	
	static function _display_error_internal($args){
		extract($args);
		
		ob_start();
		ob_implicit_flush(false);
		require($error.".php");
		return ob_get_clean();
	}
}
?>