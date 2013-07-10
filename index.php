<?php
/**
 * Velkan PHP Framework
 * Archivo de inicio
 * Desde aqui se renderizara el sitio
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 */
	
	define('SITE_PATH',realpath(dirname(__FILE__)).'/');
	
	require_once(SITE_PATH.'framework/core/velkan.php');
	
	router::route(new request);
?>