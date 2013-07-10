<?php
/**
 * Velkan PHP Framework
 * Progress Bar - Coleccion de propiedades para renderizar barras de progreso
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class progressbar extends globalAttr{
	protected $name;
	protected $bars=array();
	protected $barClasses=array();
	
	/**
	 * Valor del control
	 * @var string
	 */
	var $value;
	
	function __construct($args=array()){
		$this->assingVars($args);
	}
	
	function setBars(array $bars){
		foreach($bars as $bar){
			$this->bars[]=$bar;
		}
	}
	
	function setBarClasses(array $barClasses){
		foreach($barClasses as $class){
			$this->barClasses[]=$class;
		}
	}
	
	/**
	 * Setea el valor del control
	 * @param string $value
	 */
	public function setValue($value){
		$this->value=$value;
	}
	
	/**
	 * Devuelve el valor del control
	 * @return string
	 */
	public function getValue(){
		return $this->value;
	}
	
	function render($return=false){
		if(empty($this->bars)){
			$e=new VException("Debe declarar por lo menos una barra de progreso");
			$e->process();
		}
		
		if($this->class==""){
			$this->class=velkan::$config["datagrid"]["progressBarClass"];
		}
		
		$render="<div class=\"{$this->class}\">";
		$count=0;
		foreach($this->bars as $bar){
			$class="";
			if(!empty($this->barClasses)){
				$class=$this->barClasses[$count];
			}
			$render.="<div class=\"bar $class\" style=\"width: $bar%;\">$bar%</div>";
			$count++;
		}
		$render.="</div>";
		
		if(!$return){
			echo $render;
		}else{
			return  $render;
		}
	}
}
?>