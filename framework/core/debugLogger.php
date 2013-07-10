<?php
/**
 * Velkan PHP Framework
 * Pequeña clase para guardar logs de las acciones de ciertos archivos del core
 * 
 * @author Anwar Garcia
 *
 */
class debugLogger{
	static function log($fileName,$string){
		$f=fopen(SITE_PATH."debug_logs/$fileName.log", "a");
		fwrite($f, $string.PHP_EOL);
		fclose($f);
	}
}
?>