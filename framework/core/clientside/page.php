<?php
/**
 * Velkan PHP Framework
 * Clase page
 * Controla todos los metodos comunes de una pagina HTML
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class page extends page_js{
	static $title="";
	
	static $appendedHTML=array();
	
	static function appendHtml($key,$html){
		if(!key_exists($key, self::$appendedHTML)){
			self::$appendedHTML[$key]=$html;
		}
	}
	
	static function getAppendedHtml(){
		foreach(self::$appendedHTML as $html){
			echo $html;
		}
	}
	
	static function _getTitle(){
		echo self::$title;
	}
	
	static function _getMetas(){
		foreach (velkan::$config["metas"] as $meta){
			echo "<meta name=\"{$meta["name"]}\" content=\"{$meta["content"]}\">".PHP_EOL;
		}
	}
	
	static function _getJsFiles(){
		foreach (velkan::$config["js_files"] as $jsFile){
			echo "<script src=\"lib/js/{$jsFile}\"></script>".PHP_EOL;
		}
	}
	
	static function _getCSSFiles(){
		foreach (velkan::$config["css_files"] as $css){
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/{$css}\" />".PHP_EOL;
		}
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"lib/velkan/velkan.css\" />".PHP_EOL;
	}
	
	static function _getBootstrapCSS(){
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"lib/bootstrap/css/bootstrap.css\" />".PHP_EOL;
		echo "<link href=\"lib/bootstrap/css/bootstrap-responsive.css\" rel=\"stylesheet\">".PHP_EOL;
		echo "<link href=\"lib/bootstrap/plugins/bootstrap-datetimepicker/css/datetimepicker.css\" rel=\"stylesheet\">".PHP_EOL;
		echo "<link href=\"lib/bootstrap/plugins/wysihtml5/src/bootstrap-wysihtml5.css\" rel=\"stylesheet\">".PHP_EOL;
	}
	
	static function _getBootstrapJS(){
		echo "<script src=\"lib/bootstrap/js/bootstrap.js\"></script>".PHP_EOL;
		
		echo "<script src=\"lib/bootstrap/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js\"></script>".PHP_EOL;
		echo "<script src=\"lib/bootstrap/plugins/bootstrap-datetimepicker/js/locales/".velkan::$config["datetimepicker"]["localFile"]."\"></script>".PHP_EOL;
		
		echo "<script src=\"lib/bootstrap/plugins/wysihtml5/lib/js/wysihtml5-0.3.0.js\"></script>".PHP_EOL;
		echo "<script src=\"lib/bootstrap/plugins/wysihtml5/src/bootstrap-wysihtml5.js\"></script>".PHP_EOL;
		echo "<script src=\"lib/bootstrap/plugins/wysihtml5/src/locales/".velkan::$config["textarea"]["localeJSFile"]."\"></script>".PHP_EOL;
		echo "<script src=\"lib/bootstrap/plugins/fileinput/bootstrap.file-input.js\"></script>".PHP_EOL;
		
		if(!empty(self::$jsFiles)&&is_array(self::$jsFiles)){
			foreach(self::$jsFiles as $file){
				echo "<script src=\"$file\"></script>".PHP_EOL;
			}
		}
		/*echo "<script src=\"lib/bootstrap/js/bootstrap-transition.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-alert.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-modal.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-dropdown.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-scrollspy.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-tab.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-tooltip.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-popover.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-button.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-collapse.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-carousel.js\"></script>";
		echo "<script src=\"lib/bootstrap/js/bootstrap-typeahead.js\"></script>";*/
	}
	
	static function getArgsSeries($without=""){
		$series="";
		$out=explode(",",$without);
		
		$registry=registry::getInstance();
		
		foreach($registry->httpArgs as $key=>$arg){
			
			if(!in_array($key, $out)){
				if($series==""){
					$series="$key=$arg";
				}else{
					$series.="&".$key."=$arg";
				}
			}
		}
		return $series;
	}
}
?>