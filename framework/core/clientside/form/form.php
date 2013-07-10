<?php
/**
 * Velkan PHP Framework
 * Objeto form
 * Coleccion de inputs y otros metodos para la renderizacion de formularios
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
	class form extends globalAttr{
		protected $_registry;
		
		protected $started=false;
		
		/**
		 * Nombre del formulario
		 * @var string
		 */
		protected $name="";
		
		/**
		 * Metodo del formulario, puede ser GET o POST
		 * @var string
		 */
		protected $method="";
		
		/**
		 * Controlador al que iran los datos del formulario
		 * @var string
		 */
		protected $controller;
		
		/**
		 * Funcion del controlador al que se iran los datos del formulario
		 * @var string
		 */
		protected $function;
		
		/**
		 * Controla si el formulario enviará por medio de Ajax los datos, o no
		 * @var boolean
		 */
		protected $iAmAjax=false;
		
		/**
		 * Arreglo de reglas del formulario.
		 * @var array
		 */
		protected $rules=array();
		
		/**
		 * Arreglo de formatos del formulario
		 * @var array
		 */
		protected $formats=array();
		
		static $FORM_ALERT_TYPE_NORMAL=1;
		static $FORM_ALERT_TYPE_SAVING_OK=2;
		static $FORM_ALERT_TYPE_SAVING_NOTOK=3;
		static $FORM_ALERT_TYPE_WARNING=4;
		static $FORM_ALERT_TYPE_ERROR=5;
		
		function __construct(array $args){
			$this->_registry=registry::getInstance();
			
			if(!isset($args["id"])){
				$e=new VException("Tiene que especificar el atributo \"id\"");
				$e->process();
			}else{
				$this->id=$args["id"];
			}
			
			if(!isset($args["method"])){
				$e=new VException("Tiene que especificar el atributo \"method\"");
				$e->process();
			}else{
				$this->method=$args["method"];
			}
			
			if(!isset($args["function"])){
				$e= new vException("No se envio el parametro \"function\" al intentar crear \"{$this->id}\"");
				$e->process();
			}else{
				$this->function=$args["function"];
			}
			
			if(!isset($args["name"])){
				$this->name=$args["id"];
			}else{
				$this->name=$args["name"];
			}
			
			if(!isset($args["controller"])){
				$registry=registry::getInstance();
				$this->controller=$registry->controllerName;
				unset($registry);
			}else{
				$this->controller=$args["controller"];
			}
			
			if($args["table_type"]!=""){
				$this->table_type=(int)$args["table_type"];
			}
			
			$this->type=$args["type"];
			
			$this->table=$args["table"];
			$this->query=$args["query"];
			$this->key_fields=$args["key_fields"];
			$this->key_fields_values=$args["key_fields_values"];
			
			$this->reg_nav_controls=$args["reg_nav_controls"];
			
			$this->conf=$args["conf"];
			$this->lang=$args["lang"];

			if(isset($args["class"])){
				$this->class=$args["class"];
			}
			
			if(isset($args["ajaxForm"])&&is_bool($args["ajaxForm"])){
				$this->iAmAjax=$args["ajaxForm"];
			}
		}
		
		/**
		 * Agrega una regla al formulario para validar campos. No funciona para textarea con WysiHtm5 activado.
		 * @param string $validation Validación a agregar. Vea http://jqueryvalidation.org/
		 * @param string $value Valor a asignar a la validación. Si es algun valor string, debe utilizarce el caracter "'"
		 * @param string $message Mensaje a mostrar. Si no se especifica un mensaje, Velkan buscará el mensaje predefinido en la variable velkan::$lang["form"]["defaultInputValidationsMessages"]
		 * @param string $fields Campos a validar separados por coma.
		 * 
		 * @example $form->addRule("required","true","","id,text");
		 */
		function addRule($validation,$value,$fields,$message=""){
			$this->rules[]=array("validation"=>$validation,"value"=>$value,"message"=>$message,"fields"=>$fields);
		}
		
		private function prepareRules(){
			$rules=array();
			$messages=array();
			
			//Revisamos regla por regla
			foreach ($this->rules as $validation){
				//Creamos un arreglo para los fields
				$fields=explode(",",$validation["fields"]);
				
				//Por cada field asignaremos la validación
				foreach($fields as $field){
					$field=trim($field);
					if(isset($rules[$field])){
						$rules[$field].=",".$validation["validation"].":".$validation["value"];
					}else{
						$rules[$field]=$validation["validation"].":".$validation["value"];
					}
					
					$message=$validation["message"];
					//Si el mensaje viene vacio lo buscamos en la variable de configuración
					if($message==""||empty($message)){
						$message=velkan::$lang["form"]["defaultInputValidationsMessages"][$validation["validation"]];
					}
					
					if(isset($messages[$field])){
						$messages[$field].=",".$validation["validation"].":'".$message."'";
					}else{
						$messages[$field]=$validation["validation"].":'".$message."'";
					}
				}
				
				$js.="rules:{";
				$rules_to_render="";
				foreach($rules as $field=>$rule){
					if($rules_to_render==""){
						$rules_to_render="$field:{".$rule."}";
					}else{
						$rules_to_render.=",$field:{".$rule."}";
					}
				}
				$js.=$rules_to_render."}";
		
				$js.=",messages:{";
				$msg_to_render="";
				foreach($messages as $field=>$message){
					if($msg_to_render==""){
						$msg_to_render="$field:{".$message."}";
					}else{
						$msg_to_render.=",$field:{".$message."}";
					}
				}
				$js.=$msg_to_render."}";
				
				return $js;
			}
		}
		
		/**
		 * Agrega un formato definido a un campo
		 * @param string $format Formato a definir. Los valores posibles son: number, number_unsigned, uppercase 
		 * @param string $fields Campos a modificar, separados por coma
		 */
		function addFormat($format,$fields){
			$this->formats[]=array("format"=>$format,"fields"=>$fields);
		}
		
		/**
		 * Prepara los formatos para los campos en el formulario
		 */
		private function prepareFormats(){
			$js="";
			$jsAjax=new generalJavaScriptFunction();
			if(!empty($this->formats)){
				foreach($this->formats as $format){
					$fields=explode(",",$format["fields"]);
					foreach($fields as $field){
						$js.=$jsAjax->addAttrib($field, $format["format"], "");
					}
				}
			}
			if(!$js==""){
				self::addJavaScriptOnLoad($js);
				self::addJavaScript("lastKeypressPrevented='';");
				
				$jsAjax->registerFunction("applyFormats");
				unset($jsAjax);
			}
		}
		
		/**
		 * Setea si el formulario enviará los datos por medio de Ajax, o no
		 * @param boolean $value
		 */
		function setAjaxForm($value){
			if(is_bool($value)){
				$this->iAmAjax=$value;
			}
		}
		
		/**
		 * Devuelve si el formulario enviará los datos por medio de Ajax, o no
		 * @return boolean
		 */
		function getAjaxForm(){
			return $this->iAmAjax;
		}
		
		/**
		 * Agrega una clase CSS al formulario
		 * @param string $class
		 */
		function add_class($class){
			$this->class.=" $class";
		}
		
		/**
		 * Obtiene la clase del archivo de configuracion dependiendo del tipo de alerta
		 * @param number $alertType Tipos de alerta de form::$FORM_ALERT_TYPE
		 */
		static function getAlertTypeClass($alertType){
			switch ($alertType){
				case self::$FORM_ALERT_TYPE_SAVING_OK:
					return velkan::$config["form"]["alertSavingOkClass"];
					break;
				case self::$FORM_ALERT_TYPE_SAVING_NOTOK:
					return velkan::$config["form"]["alertSavingNotOkClass"];
					break;
				case self::$FORM_ALERT_TYPE_WARNING:
					return velkan::$config["form"]["alertWarningClass"];
				case self::$FORM_ALERT_TYPE_ERROR:
					return velkan::$config["form"]["alertErrorClass"];
					break;
			}
		}
		
		/**
		 * Devuelve el mensaje configurado en el archivo framework/config/language.php, para las alertas del formulario
		 * @param number $alertType Tipo de alerta. Los tipos de alerta se encuentran en las variables form::$FORM_ALERT_TYPE...
		 * @return string Mensaje devuelto
		 */
		static function getAlertTypeMessage($alertType){
			switch($alertType){
				case self::$FORM_ALERT_TYPE_SAVING_OK:
					return velkan::$lang["form"]["alertSavingOk"];
					break;
				case self::$FORM_ALERT_TYPE_SAVING_NOTOK:
					return velkan::$lang["form"]["alertSavingNotOk"];
					break;
				default:
					return "";
					break;
			}
		}
		
		
		
		/**
		 * Imprime el código HTML del formulario al empezar
		 * @param number $alertType Mensaje a mostrar antes del formulario. Los tipos de mensajes son los definidos en form::$FORM_ALERT_TYPE_
		 * @param string $alertMessage Mensaje personalizado a mostrar
		 */
		function begin($alertType=0,$alertMessage=""){
			
			$render="";
			if(!empty($alertType)&&$alertType!==0){
				$message="";
				switch ($alertType){
					case self::$FORM_ALERT_TYPE_SAVING_OK:
						//$message=((!empty($alertMessage)&&$alertMessage!=="")?$alertMessage:velkan::$lang["form"]["alertSavingOk"]);
						$message=self::getAlertTypeMessage($alertType)." ".$alertMessage;
						$render.="<div class=\"alert ".self::getAlertTypeClass($alertType)."\" id=\"{$this->id}_THEALERT_\">".$message."<button type=\"button\" class=\"close\" onclick=\"javascript:$('#{$this->id}_THEALERT_').slideUp();\">&times;</button></div>";
						break;
					case self::$FORM_ALERT_TYPE_SAVING_NOTOK:
						//$message=((!empty($alertMessage)&&$alertMessage!=="")?$alertMessage:velkan::$lang["form"]["alertSavingNotOk"]);
						$message=self::getAlertTypeMessage($alertType)." ".$alertMessage;
						$render.="<div class=\"alert ".self::getAlertTypeClass($alertType)."\" id=\"{$this->id}_THEALERT_\">".$message."<button type=\"button\" class=\"close\" onclick=\"javascript:$('#{$this->id}_THEALERT_').slideUp();\">&times;</button></div>";
						break;
					case self::$FORM_ALERT_TYPE_WARNING:
						//$message=((!empty($alertMessage)&&$alertMessage!=="")?$alertMessage:velkan::$lang["form"]["alertSavingNotOk"]);
						$message=$alertMessage;
						$render.="<div class=\"alert ".self::getAlertTypeClass($alertType)."\" id=\"{$this->id}_THEALERT_\">".$message."<button type=\"button\" class=\"close\" onclick=\"javascript:$('#{$this->id}_THEALERT_').slideUp();\">&times;</button></div>";
						break;
					case self::$FORM_ALERT_TYPE_NORMAL:
						$message=$alertMessage;
						$render.="<div class=\"alert\">".$message."<button type=\"button\" class=\"close\" onclick=\"javascript:$('#{$this->id}_THEALERT_').slideUp();\">&times;</button></div>";
						break;
				}
				
			}else{
				$render.="<div class=\"alert\" style=\"display:none;\" id=\"{$this->id}_THEALERT_\"><button type=\"button\" class=\"close\" onclick=\"javascript:$('#{$this->id}_THEALERT_').slideUp();\">&times;</button></div>";
			}
			
			$render.="<form name=\"{$this->name}\" id=\"{$this->id}\"";
			
			if($this->method!==""){
				$render.=" method=\"{$this->method}\"";
			}else{
				$render.=" method=\"POST\"";
			}
			
			//Si el formulario es Ajax, registrará el submit
			if(!velkan::isAjaxCall()){
				$this->registerJSFunction();
			}
			
			//La accion siempre estará vacia ya que se dependerá del controlador y la funcion que se deba ejecutar
			$render.=" action=\"\"";
			
			if($this->class!==""){
				$render.=" class=\"{$this->class}\"";
			}
			
			$render.=">";
			
			if($this->iAmAjax){
				$render.="<input type=\"hidden\" name=\"m\" value=\"{$this->controller}\">";
				$render.="<input type=\"hidden\" name=\"a\" value=\"{$this->function}\">";
			}else{
				$render.="<input type=\"hidden\" name=\"c\" value=\"{$this->controller}/{$this->function}\">";
			}
			
			echo $render;
		}
		
		/**
		 * Registra la funcion JavaScript a ejecutar
		 */
		private function registerJSFunction(){
			//Iniciamos el script
			$js="$(\"#{$this->id}\").validate({";
			
			$js.="submitHandler: function(form){";
			if($this->iAmAjax){
				$js.="$(form).ajaxSubmit({success:function(responseText, statusText, xhr, \$form){eval(responseText);form.reset();}});";
			}else{
				$js.="form.submit();";
			}
			
			$js.="}";
			
			//Si se han definido reglas, se hace la renderización de las mismas para el plugin jquery-validate
			if(!empty($this->rules)){
				$js.=",".$this->prepareRules();
			}
			
			$js.="});";
			
			page::addJavaScriptOnLoad($js);
		}
		
		/**
		 * Termina el formulario
		 */
		function end(){
			echo "</form>";
		}
		
		static $FORM_JSHELPER_SENDALERT="sendAlert";
		
		function jsHelper($type,array $params){
			switch ($type){
				case self::$FORM_JSHELPER_SENDALERT:
					extract($params);
					$message=self::getAlertTypeMessage($alertType)." ".$alertMessage;
					$js.="$(\"#{$this->id}_THEALERT_\").html('').removeClass().addClass('alert ".self::getAlertTypeClass($alertType)."').html('$message<button type=\"button\" class=\"close\" onclick=\"javascript:$(\'#{$this->id}_THEALERT_\').slideUp();\">&times;</button>').slideDown('slow');";
					echo $js;
					break;
			}
		}
	}
?>