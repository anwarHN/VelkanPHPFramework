<?php
/**
 * Velkan PHP Framework
 * Text area control - Coleccion de propiedades para renderizar textarea
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/jhollingworth/bootstrap-wysihtml5/
 */
class textarea extends globalAttr{
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
	 * Nombre del control en el formulario
	 * @var string
	 */
	protected $name;
	
	/**
	 * Valor del control
	 * @var string
	 */
	protected $value="";
	
	protected $readOnly=false;
	
	/**
	 * Define si el textarea sera editor HTML wysihtml
	 * @var bool
	 */
	protected $wysihtml=false; 
	
	/**
	 * Texto que aparecerá como texto de ayuda del control
	 * @var string
	 */
	protected $placeholder="";
	
	/**
	 * Array que habilitará o deshabilitará los botones
	 * @var array
	 */
	protected $buttons=array();
	
	/**
	 * Devuelve el nombre del control en el formulario
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Setea el nombre del control en el formulario
	 * @param string $value
	 */
	public function setName($value){
		$this->name=$value;
	}
	
	public function __construct($args=array()){
		$this->assingVars($args);
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}else{
			$this->name=$args["name"];
		}
		
		$this->placeholder=$args["placeholder"];
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
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
	
	/**
	 * Setea si el textarea sera editor tipo wysihtml
	 * @param unknown_type $value
	 */
	public function setWysihtml($value){
		$this->wysihtml=$value;
	}
	
	/**
	 * Setea la propiedad placeholder del control que muestra un texto de ayuda
	 * que desaparece cuando el usuario inserta valores
	 * 
	 * @param string $value
	 */
	public function setPlaceHolder($value){
		$this->placeholder=$value;
	}
	
	/**
	 * Devuelve el valor actual de la propiedad placeholder
	 * @return string
	 */
	public function getPlaceHolder(){
		return $this->placeholder;
	}
	
	/**
	 * Setea que botones se mostraran y cuales no. Los botones soportados son:
	 * "font-styles" Font styling, e.g. h1, h2, etc
	 * "emphasis" Italics, bold, etc
	 * "lists" (Un)ordered lists, e.g. Bullets, Numbers
	 * "html" Button which allows you to edit the generated HTML
	 * "link" Button to insert a link
	 * "image" Button to insert an image
	 * "color" Button to change color of font
	 *   
	 * @param array $buttons
	 * @example $textarea->setButtonDisplay(array("font-styles"=>"true","emphasis"=>"false"));
	 */
	public function setButtonsDisplay(array $buttons){
		$this->buttons=$buttons;
	}
	
	public function setReadOnly($value){
		$this->readOnly=$value;
	}
	
	/**
	 * Renderiza el control
	 */
	public function render($return=false){
		
		if($this->readOnly){
			$render="<input type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->value}\"><span class='velkan-read-only'>{$this->value}</span>";
		}else{
			$class=($this->class==""?"":"class='{$this->class}'");
			$placeholder=($this->placeholder==""?"":"placeholder='{$this->placeholder}'");
			$style=($this->style==""?"":"style='{$this->style}'");
			
			$buttons="";
			if(!empty($this->buttons)){
				foreach($this->buttons as $name=>$value){
					$buttons.=",\"$name\":$value";
				}
			}
			
			$render.="<textarea id=\"{$this->id}\" name=\"{$this->name}\" $class $placeholder $style>$this->value</textarea>";
			
			if($this->wysihtml){
				$js="\$('#{$this->id}').wysihtml5({locale: \"".velkan::$config["textarea"]["locale"]."\"$buttons});";
				page::addJavaScriptOnLoad($js,true);
			}
		}
		
		if(!$return){
			echo $render;
		}else{
			return $render;
		}
	}
}
?>