<?php
/**
 * Velkan PHP Framework
 * Radio button control - Coleccion de propiedades para renderizar radio buttons
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class radiobutton extends globalAttr{
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
	protected $dataType="string";
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
	/**
	 * Valor del radiobutton
	 * @var string
	 */
	protected $value="";
	
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
	 * Controla si el control será disabled
	 * @var boolean
	 */
	protected $disabled=false;
	
	/**
	 * Arreglo de todas las opcciones que tiene el control
	 * @var unknown_type
	 */
	protected $options=array();
	
	/**
	 * Tabla donde buscará la información
	 * @var string
	 */
	protected $table="";
	
	/**
	 * Campos que utilizará para mostrar los valores y los labels
	 * @var string
	 */
	protected $fields="";
	
	/**
	 * Condicion para filtrar los datos en la base de datos
	 * @var string
	 */
	protected $condition="";
	
	/**
	 * Determina si el control deberá de ir a buscar datos a la base de datos
	 * @var boolean
	 */
	protected $hasDataBaseCall=false;
	
	/**
	 * Obtiene los valores del select desde una tabla de la base de datos
	 * @param string $table Tabla de la base de datos
	 * @param string $fields Campos a traer. Se esperan dos: el valor, y la descripcion
	 * @param string $condition Condicion para el query que se ejecutará
	 * @param string $value Valor seleccionado por defecto
	 */
	public function getFromDataBase($table,$fields,$condition="",$value=""){
		$this->table=$table;
		$this->fields=$fields;
		$this->condition=$condition;
		$this->value=$value;
		
		$this->hasDataBaseCall=true;
	}
	
	private function getData(){
		if(!db::getFields($this->table,$this->fields,$this->condition)){
			return false;
		}
		while($row=db::fetch()){
			$this->options[$row[1]]=$row[0];
		}
	}
	
	/**
	 * Setea el arreglo de botones del control
	 * 
	 * @param array $options Arreglo de opciones
	 * @example $radiobutton->setOptionButtons(array("label"=>"value","label2"=>"value2"));
	 */
	public function setOptionButtons(array $options){
		$this->options=$options;
	}
	
	/**
	 * Setea si el control estará deshabilitado o no
	 * @param unknown_type $value
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
		
		if(isset($args["options"])){
			
			if(!is_array($args["options"])){
				$e=new VException("Las distintas opciones del radio button deben ser un arreglo");
				$e->process();
			}
			
			$this->options=$args["options"];
		}
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
		}
	}
	
	/**
	 * Setea el valor del objeto
	 * @param string $value
	 */
	function setValue($value){
		$this->value=$value;
		if($this->table!=""&&empty($this->options)){
			$this->getFromDB($this->table, $this->fields);
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
		if($this->hasDataBaseCall){
			$this->getData();
		}
		
		$labelClass=($this->labelClass==""?(velkan::$config["radiobutton"]["labelClass"]==""?"":"class='".velkan::$config["radiobutton"]["labelClass"]."'"):"class='{$this->labelClass}'");
		$class=($this->class==""?(velkan::$config["radiobutton"]["class"]==""?"":"class='".velkan::$config["radiobutton"]["class"]."'"):"class='{$this->class}'");
		
		$readonly=($this->readonly?"readonly='true'":"");
		$disabled=($this->disabled?"disabled='true'":"");
		
		$render="<input type='hidden' name='{$this->name}' value='NULL'>";
		
		foreach($this->options as $label=>$value){
			if($value==$this->value){
				$checked="checked='true'";
			}else{
				$checked="";
			}
			
			if($this->readonly){
				if($value==$this->value){
					$render.="<label $labelClass><input type='hidden' name='{$this->name}' value='{$value}'><div class='pull-left'><img src='lib/velkan/radiobutton_checked.png' class='velkan-icon' style='margin-left:-20px'></div>{$label}</label>";
				}else{
					$render.="<label $labelClass><div class='pull-left'><img src='lib/velkan/radiobutton_unchecked.png' class='velkan-icon' style='margin-left:-20px'></div>{$label}</label>";
				}
			}else{
				$render.="<label $labelClass><input type='radio' name='{$this->name}' value='{$value}' $checked $disabled>{$label}</label>";
			}
		}
		
		if($this->readonly){
			$render="<span class='velkan-read-only'>$render</span>";
		}
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}
?>