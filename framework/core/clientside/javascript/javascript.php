<?php
	abstract class page_js{
		/**$(document).ready() funciton of jQuery*/
		private static $js_onLoad;
		
		/**
		 * Agrega un script dentro de la funcion $(document).ready() de jQuery
		 * @param string $js Script a agregar
		 * @param boolean $append Si se setea verdadero, agregar� el script antes de los script que ya se hayan agregado
		 */
		static function addJavaScriptOnLoad($js,$append=false){
			if(!$append){
				self::$js_onLoad.=$js;
			}else{
				self::$js_onLoad=$js.self::$js_onLoad;
			}
		}
		
		/**
		 * Obtiene los script a agregar a la funcion $(document).ready() de jQuery
		 */
		static function getJavaScriptOnLoad(){
			echo "<script>\$(document).ready(function(){".self::$js_onLoad."});</script>".PHP_EOL;
		}
		
		/**
		 * Controla los script a a�adir a la p�gina
		 * @var string
		 */
		private static $js_str="";
		
		/**
		 * Agrega c�digo JavaScript a la p�gina que se mostrar� al usuario
		 * @param string $js
		 */
		static function addJavaScript($js){
			self::$js_str.=$js;
		}
		
		/**
		 * Obtiene los script a�adidos a la pagina mediante page::addJavaScript($script);
		 */
		static function getJavaScript(){
			echo "<script>".self::$js_str;
			
			foreach(self::$generalJavaScriptFunctions as $js){
				echo $js;
			}
			
			echo "</script>";
		}
		
		/**
		 * Arreglo de archivos javaScript adicionales
		 * @var unknown_type
		 */
		protected static $jsFiles=array();
		
		/**
		 * Agrega un archivo javaScript personalizado
		 * @param strin $file Ruta del archivo a a�adir desde la raiz del sitio
		 */
		static function addJsFile($file){
			self::$jsFiles[]=$file;
		}
		
		static function _default_functions($funct){
			switch ($funct){
				case "validateSession":
						$js="$.ajax(";
					break;
			}
		}
		
		/**
		 * Arreglo que almacena las funciones generales de Velkan para Java Script, para no agregar dos veces la misma funcion, aunque se llame desde diferentes controles
		 * @var array
		 */
		static $generalJavaScriptFunctions=array();
		
		/**
		 * Registra una funcion general de Velkan para Java Script
		 * @param string $function Identificador de la funcion
		 * @param string $script Script de la funcion
		 */
		static function addGeneralJavaScriptFunction($function,$script){
			if(!key_exists($function, self::$generalJavaScriptFunctions)){
				self::$generalJavaScriptFunctions[$function]=$script;
			}
		}
	}
?>