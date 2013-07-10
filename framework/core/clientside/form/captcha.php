<?php
/**
 * Velkan PHP Framework
 * Captcha control - Coleccion de propiedades para renderizar control captcha
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class captcha extends globalAttr{
	
	/**
	 * Nombre del control
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Ancho del control
	 * @var int
	 */
	protected $width=150;
	
	/**
	 * Alto del control
	 * @var int
	 */
	protected $height=50;
	
	/**
	 * Controla si se renderizarán puntos en el fondo de la imagen
	 * @var boolean
	 */
	protected $renderDots="notSet";
	
	/**
	 * Controla si se renderizarán lineas en el fondo de la imagen
	 * @var boolean
	 */
	protected $renderLines="notSet";
	
	/**
	 * Texto que aparecerá en el control
	 * @var string
	 */
	protected $label="";
	
	/**
	 * Tipo de dato que almacenará el objeto
	 * @var string
	 */
	protected $dataType="";
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
	public function __construct($args=array()){
		$this->assingVars($args);
		
		if(!isset($args["name"])){
			$this->name=$args["name"];
		}
		
		/*
		if(isset($args["width"])){
			$this->width=(int)$args["width"];
		}
		
		if(isset($args["height"])){
			$this->height=(int)$args["height"];
		}
		*/
		if(isset($args["renderDots"])){
			$this->renderDots=$args["renderDots"];
		}
		
		if(isset($args["renderLines"])){
			$this->renderLines=$args["renderLines"];
		}
		
		$this->label=$args["label"];
		
		$this->dataType="string";
	}
	
	/**
	 * Setea el ancho del control
	 * @param int $value Ancho en pixeles
	 */
	/*
	public function setWidth($value){
		$this->width=$value;
	}*/
	
	/**
	 * Setea el alto del control
	 * @param int $value Alto en pixeles
	 */
	/*
	public function setHeight($value){
		$this->height=$value;
	}
	*/
	
	/**
	 * Setea si el control renderizará puntos en el fondo de la imagen
	 * @param boolean $value
	 */
	public function setRenderDots($value){
		$this->renderDots=$value;
	}
	
	/**
	 * Setea si el control renderizará lineas en el fondo de la imagen
	 * @param boolean $value
	 */
	public function setRenderLines($value){
		$this->renderLines=$value;
	}
	
	/**
	 * Setea el texto que aparecera en el control
	 * @param string $label
	 */
	public function setLabel($label){
		$this->label=$label;
	}
	
	private function registerJsFunction(){
		$renderDots="";
		if($this->renderDots=="notSet"){
			if(velkan::$config["captcha"]["renderDots"]){
				$renderDots="&renderDots=true";
			}
		}else{
			if($this->renderDots){
				$renderDots="&renderDots=true";
			}
		}
		
		$renderLines="";
		if($this->renderLines=="notSet"){
			if(velkan::$config["captcha"]["renderLines"]){
				$renderLines="&renderLines=true";
			}
		}else{
			if($this->renderLines){
				$renderLines="&renderLines=true";
			}
		}
		$js="function renew{$this->id}_captcha(){";
		$js.="$('#{$this->id}_THECAPTCHAIMAGE_').attr('src','?sf=getCaptcha&width={$this->width}&height={$this->height}{$renderDots}{$renderLines}');";
		$js.="}";
		
		page::addJavaScript($js);
	}
	
	public function render($return=false){
		$renderDots="";
		if($this->renderDots=="notSet"){
			if(velkan::$config["captcha"]["renderDots"]){
				$renderDots="&renderDots=true";
			}
		}else{
			if($this->renderDots){
				$renderDots="&renderDots=true";
			}
		}
		
		$renderLines="";
		if($this->renderLines=="notSet"){
			if(velkan::$config["captcha"]["renderLines"]){
				$renderLines="&renderLines=true";
			}
		}else{
			if($this->renderLines){
				$renderLines="&renderLines=true";
			}
		}
		
		if($this->width==0){
			$this->width=velkan::$config["captcha"]["defaultWidth"];
		}
		
		if($this->height==0){
			$this->height=velkan::$config["captcha"]["defaultHeight"];
		}
		
		
		
		$render="<div class=''>";
		$render.="<div class='row-fluid'>$this->label";
		$render.="</div>";
		$render.="<div class='row-fluid'>";
		$render.="<div class='span2'>";
		$render.="<img id='{$this->id}_THECAPTCHAIMAGE_' src='?sf=getCaptcha&width={$this->width}&height={$this->height}{$renderDots}{$renderLines}' class='img-polaroid'>";
		$render.="</div>";
		$render.="<div class='span4'>";
		$render.="<div class=\"input-append\"><input type='text' class='input-medium'><button type='button' class='btn' onclick='javascript:renew{$this->id}_captcha();'><i class='icon-repeat'></i></button></div>";
		$render.="</div>";
		$render.="</div>";
		$render.="</div>";
		
		$this->registerJsFunction();
		
		if($return){
			return $render;
		}else{
			echo $render;
		}
	}
}