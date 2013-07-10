<?php
/**
 * Velkan PHP Framework
 * Checkbox control - Coleccion de propiedades para renderizar checkbox
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class checkbox extends globalAttr{
	/**
	 * Nombre del campo de base de datos
	 * @var string
	 */
	protected $dataField;
	
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
	 * Tipo de dato que almacenará el objeto
	 * @var string
	 */
	protected $dataType;
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
	/**
	 * Valor del control
	 * @var string
	 */
	protected $value="";
	
	/**
	 * Valor del control cuando este checked
	 * @var string
	 */
	protected $checkedValue="";
	
	/**
	 * Valor del control cuando este unchecked
	 * @var string
	 */
	protected $uncheckedValue="";
	
	/**
	 * Nombre del control
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Leyenda del control
	 * @var string
	 */
	protected $label="";
	
	/**
	 * Clase del label del control
	 * @var string
	 */
	protected $labelClass;
	
	/**
	 * Setea si el control aparecera chequeado
	 * @var boolean
	 */
	protected $checked=false;
	
	/**
	 * Controla si el objeto es editable o no
	 * @var boolean
	 */
	protected $readonly=false;
	
	/**
	 * Controla si el control estará deshabilitado o no
	 * @var boolean
	 */
	protected $disabled=false;
	
	/**
	 * Setea el valor de cuando el control este chequeeado
	 * @param string $value
	 */
	public function setCheckedValue($value){
		$this->checkedValue=$value;
	}
	
	/**
	 * Setea el valor de cuando el control no este chequeeado
	 * @param string $value
	 */
	public function setUncheckedValue($value){
		$this->uncheckedValue=$value;
	}
	
	/**
	 * Setea si el control estará deshabilitado o no
	 * @param boolean $value
	 */
	public function setDisabled($value){
		$this->disabled=$value;
	}
	
	/**
	 * Setea el valor de solo lectura del objeto
	 * @param boolean $value
	 */
	public function setReadOnly($value){
		$this->readonly=$value;
	}
	
	/**
	 * Setea el valor de la propiedad checked del control
	 * @param boolean $value
	 */
	public function setChecked($value){
		$this->checked=$value;
	}
	
	/**
	 * Obtiene el valor de la propiedad checked del control
	 * @return boolean
	 */
	public function getChecked(){
		return $this->checked;
	}
	
	/**
	 * Setea la clase del label del control
	 * @param string $class
	 */
	function setLabelClass($class){
		$this->labelClass=$class;
	}
	
	function __construct($args=array()){
		$this->assingVars($args);
		
		$this->value=$args["value"];
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}else{
			$this->name=$args["name"];
		}
		
		$this->label=$args["label"];
		$this->labelClass=$args["labelClass"];
		
		$this->checkedValue=$args["checkedValue"];
		$this->uncheckedValue=$args["uncheckedValue"];
		
		$this->checked=$args["checked"];
		
		if(isset($args["disabled"])){
			$this->disabled=$args["disabled"];
		}
		
		if(isset($args["readonly"])){
			$this->readonly=$args["readonly"];
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
	 * Setea el valor del objeto
	 * @param string $value
	 */
	function setValue($value){
		$this->value=$value;
		
		if($this->checkedValue==$value){
			
			$this->checked=true;
		}
		if($this->uncheckedValue==$value){
			$this->checked=false;
		}
	}
	
	/**
	 * Devuelve el valor del objeto
	 * @return string
	 */
	function getValue(){
		return $this->value;
	}
	
	/**
	 * Setea el nombre del control
	 * @param string $name
	 */
	function setName($name){
		$this->name=$name;
	}
	
	/**
	 * Devuelve el nombre del control
	 * @return string
	 */
	function getName(){
		return $this->name;
	}
	
	/**
	 * Renderiza el control
	 */
	function render($return=false){
		if($this->checkedValue==""){
			$e=new VException("Debe especificar el valor de checkedValue, ya sea al construir el objeto, o mediante el m&eacute;todo setCheckedValue()");
			$e->process();
		}
		
		if($this->uncheckedValue==""){
			$e=new VException("Debe especificar el valor de uncheckedValue, ya sea al construir el objeto, o mediante el m&eacute;todo setUncheckedValue()");
			$e->process();
		}
		
		$labelClass=($this->labelClass==""?(velkan::$config["checkbox"]["labelClass"]==""?"":"class='".velkan::$config["checkbox"]["labelClass"]."'"):"class='{$this->labelClass}'");
		$class=($this->class==""?(velkan::$config["checkbox"]["class"]==""?"":"class='".velkan::$config["checkbox"]["class"]."'"):"class='{$this->class}'");
		$checked=($this->checked?"checked='true'":"");
		$readonly=($this->readonly?"readonly='true'":"");
		$disabled=($this->disabled?"disabled='true'":"");
		
		
		$render="<input type='hidden' name='{$this->name}' value='{$this->uncheckedValue}'>";
		if($this->readonly){
			$imgChecked=($this->checked?"checked":"unchecked");
			$render.="<span class='velkan-read-only'><label $labelClass><div class='pull-left'><img src='lib/velkan/checkbox_$imgChecked.png' class='velkan-icon' style='margin-left:-20px'></div>{$this->label}</label></span>";
		}else{
			$render.="<label $labelClass><input type='checkbox' $class id='{$this->id}' name='{$this->name}' value='{$this->checkedValue}' $checked $disabled>{$this->label}</label>";
		}
		
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}
?>