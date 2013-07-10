<?php
/**
 * Velkan PHP Framework
 * Input contorl - Coleccion de propiedades para renderizar inputs
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class input extends globalAttr{
	/**
	 * Clase input-mini para el input
	 * @var string
	 */
	static $INPUT_SIZE_MINI="mini";
	
	/**
	 * Clase input-small para el input
	 * @var string
	 */
	static $INPUT_SIZE_SMALL="small";
	
	/**
	 * Clase input-medium para el input
	 * @var string
	 */
	static $INPUT_SIZE_MEDIUM="medium";
	
	/**
	 * Clase input-large para el input
	 * @var string
	 */
	static $INPUT_SIZE_LARGE="large";
	
	/**
	 * Clase input-xlarge para el input
	 * @var string
	 */
	static $INPUT_SIZE_XLARGE="xlarge";
	
	/**
	 * Clase input-xxlarge para el input
	 * @var string
	 */
	static $INPUT_SIZE_XXLARGE="xxlarge";
	
	/**
	 * Nombre del input en el formulario
	 * @var string
	 */
	protected $name;
	
	/**
	 * Valor del control
	 * @var string
	 */
	protected $value;
	
	/**
	 * Tipo del input
	 * @var string
	 * @see http://www.w3schools.com/html/html5_form_input_types.asp
	 */
	protected $type;
	
	/**
	 * Texto que aparecerá sobre el input como marca de agua
	 * @var string
	 */
	protected $placeholder;
	
	/**
	 * Controla si el input es de solo lectura o no
	 * @var boolean
	 */
	protected $readonly=false;
	
	/**
	 * Controla si el input esta habilitado o no
	 * @var boolean
	 */
	protected $disabled=false;
	
	/**
	 * Almacena el valor para el atributo size del input
	 * @var string
	 */
	protected $size;
	
	/**
	 * Almacena el texto a agregar antes del input
	 * @var string
	 */
	protected $prepend;
	
	/**
	 * Almacena el texto a agregar despues del input
	 * @var string
	 */
	protected $append;
		
	/**
	 * Nombre del campo de base de datos
	 * @var string
	 */
	protected $dataField;
	
	/**
	 * Tipo de dato que almacenará el objeto. Por defecto es string
	 * @var string
	 */
	protected $dataType="string";
		
	function __construct($args){
		$this->assingVars($args);
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}else{
			$this->name=$args["name"];
		}
		
		if(isset($args["value"])){
			$this->value=$args["value"];
		}
		
		if(isset($args["type"])){
			$this->type=$args["type"];
		}else{
			$this->type="text";
		}
		
		if(isset($args["placeholder"])){
			$this->placeholder=$args["placeholder"];
		}
		
		if(isset($args["label"])){
			$this->label=$args["label"];
		}
		
		if(isset($args["label_class"])){
			$this->label_class=$args["label_class"];
		}
		
		if(isset($args["size"])){
			$this->size=$args["size"];
		}else{
			$this->size=velkan::$config["input"]["defaultSize"];
		}
		
		if(isset($args["disabled"])){
			$this->disabled=$args["disabled"];
		}
		
		if(isset($args["readonly"])){
			$this->readonly=$args["readonly"];
		}
		
		$this->prepend=$args["prepend"];
		$this->append=$args["append"];
		
		$this->field=$args["field"];
		
		$this->form_type=$args["form_type"];
		
		$this->js_validation=$args["js_validation"];
		
		if(isset($args["attributes"])){
			$this->attribs=$args["attributes"];
		}
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
		}
		
		if(isset($args["dataType"])){
			$this->dataType=$args["dataType"];
		}else{
			$this->dataType=velkan::$DATATYPE_STRING;
		}
	}
	
	/**
	 * Setea el nombre del input en el formulario
	 * @param string $name
	 */
	function setName($name){
		$this->name=$name;
	}
	
	/**
	 * Obtiene el nombre del input en el formulario
	 * @return string
	 */
	function getName(){
		return $this->name;
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
	
	/**
	 * Setea el tipo del input
	 * @see http://www.w3schools.com/html/html5_form_input_types.asp
	 * @param string $type
	 */
	function setType($type){
		$this->type=$type;
	}
	
	/**
	 * Obtiene el tipo del input
	 * @return string
	 */
	function getType(){
		return $this->type;
	}
	
	/**
	 * Setea el nombre del campo de la base de datos
	 * @param string $dataField
	 */
	function setDataField($dataField){
		$this->dataField=$dataField;
	}
	
	/**
	 * Obtiene el valor del nombre del campo asignado en la base de datos
	 * @return string
	 */
	function getDataField(){
		return $this->dataField;
	}
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
	/**
	 * Setea el texto que aparecerá como marca de agua
	 * @param string $placeholder
	 */
	function setPlaceHolder($placeholder){
		$this->placeholder=$placeholder;
	}
	/**
	 * Obtiene el texto que aparecerá como marca de agua
	 * @return string
	 */
	function getPlaceHolder(){
		return $this->placeholder;
	}
	
	/**
	 * Setea si el control sera de solo lectura o no
	 * @param boolean $ro
	 */
	function setReadOnly($ro){
		$this->readonly=$ro;
	}
	
	/**
	 * Obtiene si el texto es de solo lectura o no
	 * @return boolean
	 */
	function getReadOnly(){
		return $this->readonly;
	}
	
	function setSize($size){
		$this->size=$size;
	}
	function getSize(){
		return $this->size;
	}
	
	function setPrepend($prepend){
		$this->prepend=$prepend;
	}
	function getPrepend($append){
		return $this->prepend;
	}
	
	function setAppend($append){
		$this->append=$append;
	}
	function getAppend(){
		return $this->append;
	}
	
	function setFormType($form_type){
		$this->form_type=$form_type;
	}
	function getFormType(){
		return $this->form_type;
	}
	
	
	function render($return=false){
		$msg="";
		
		if($this->readonly){
			$render = "<input type=\"hidden\" value=\"{$this->value}\" name=\"{$this->name}\" id=\"{$this->id}\"><span class='velkan-read-only'>{$this->value}</span>";
		}else{
			$render="<input type=\"{$this->type}\" id=\"{$this->id}\" name=\"{$this->name}\" class=\"$this->class\"";
				
			if($this->placeholder!=""){
				$render.=" placeholder=\"{$this->placeholder}\"";
			}
			
			if(!empty($this->attribs)){
				foreach($this->attribs as $key=>$value){
					$render.=" $key=\"$value\"";
				}
			}
						
			if($this->disabled){
				$render.=" disabled";
			}
			
			if($this->value!=""){
				$render.=" value=\"{$this->value}\"";
			}
			
			$render.=">";
			
			if($this->prepend!=""&&$this->append==""){
				$render="<div class=\"input-prepend\"><span class=\"add-on\">{$this->prepend}</span>$render</div>";
			}elseif($this->prepend==""&&$this->append!=""){
				$render="<div class=\"input-append\">$render<span class=\"add-on\">{$this->append}</span></div>";
			}elseif($this->prepend!=""&&$this->append!=""){
				$render="<div class=\"input-prepend input-append\"><span class=\"add-on\">{$this->prepend}</span>$render<span class=\"add-on\">{$this->append}</span></div>";
			}
		}
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}
?>