<?php
/**
 * Velkan PHP Framework
 * Link contorl - Coleccion de propiedades para renderizar accesos directos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class link {
	/**
	 * Variable de control del link al que apuntara el objeto
	 * @var string
	 */
	protected $href="";
	
	/**
	 * Soporte para distintos tipos de links
	 * @var string
	 */
	protected $type="";
	
	/**
	 * Controla si por defecto apuntara al mismo modelo y metodo y solo agregará nuevos parámetros
	 * @var bool
	 */
	protected $insideCurrentModel=false;
	
	/**
	 * Clase CSS del objeto
	 * @var string
	 */
	protected $class="";
	
	/**
	 * Variable que almacena el texto que mostrará el link
	 * @var string
	 */
	protected $display="";
	
	public function __construct($args=array()){
		if(isset($args["href"])){
			$this->href=$args["href"];
		}
		
		if(isset($args["type"])){
			$this->type=$args["type"];
		}
		
		if(isset($args["insideCurrentModel"])){
			$this->insideCurrentModel=$args["tyinsideCurrentModelpe"];
		}
		
		if(isset($args["class"])){
			$this->class=$args["class"];
		}
	}
	
	/**
	 * Reemplazará los valores que vengan en el arreglo
	 * @param array $array Arreglo asociativo
	 * @param string $href Enlace al que se quieren reemplazar las los campos encerrados en '#'
	 * 
	 * @example replaceFields(array("id"=>"1","name"=>"Nombre"),"?id=#id#&name=#name#")
	 */
	public function replaceFields($array,$href){
		foreach($array as $key=>$value){
			$href=str_replace("#$key#", $value, $href);
		}
		$this->href= $href;
	}
	
	/**
	 * Asigna el texto a mostrar en el link
	 * @param string $display
	 */
	public function setDisplay($display){
		$this->display=$display;
	}
	
	/**
	 * Renderiza la información HTML
	 * @return string
	 */
	public function render($return=false){
		$class=($this->class==""?"":"class='{$this->class}'");
		$render="<a $class href=\"";
		
		if($this->insideCurrentModel){
			$registry=registry::getInstance();
			$render.="?c=".$registry->controllerName."/".$registry->controllerMethod;
			$render.="&{$this->href}";
		}else{
			$render.="{$this->href}";
		}
		
		$render.="\">{$this->display}</a>";
		
		if(velkan::isAjaxCall()){
			$render=str_replace("'","\'",$render);
		}
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}
?>