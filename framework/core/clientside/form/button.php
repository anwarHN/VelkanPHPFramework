<?php
/**
 * Velkan PHP Framework
 * Button control - Coleccion de propiedades para renderizar control button
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class button extends globalAttr{
	/**
	 * Nombre del objeto
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Controla si ejecutara un callback de Ajax al hacer click
	 * @var boolean
	 */
	protected $callBackOnClick=false;
	
	/**
	 * Tipo del boton
	 * @var string
	 */
	protected $type="";
	
	/**
	 * Dato que aparecerá en el boton
	 * @var string
	 */
	protected $caption="";
	
	public function __construct($args=array()){
		$this->assingVars($args);
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}
		
		if(isset($args["caption"])){
			$this->caption=$args["caption"];
		}
		
		$this->class=velkan::$config["button"]["class"];
		
		if(isset($args["type"])){
			$this->type=$args["type"];
		}
	}
	
	/**
	 * Setea el valor que aparecerá en el boton
	 * @param string $value
	 */
	public function setCaption($caption){
		$this->caption=$caption;
	}
	
	/**
	 * Renderiza el objeto
	 * @param boolean $return Si es true, devolverá el código HTML generado. Si es false, imprimirá en pantalla.
	 * @return string Código HTML generado si el parámetro $return es especificado
	 */
	public function render($return=false){
		$this->checkEvents($this->id);
		$type=($this->type==""?"":"type=\"{$this->type}\"");
		$class=$this->class;
		$render="<button name='{$this->name}' class='{$this->class}' id='{$this->id}' $type>{$this->caption}</button>";
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}