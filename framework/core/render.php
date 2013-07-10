<?php
/**
 * Velkan PHP Framework
 * Clase render
 * Sirve para renderizar las vistas e incluir los modelos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class render{
	private $module;
	private $_registry;
	
	private $model;
	private $view;
	
	function __construct($module){
		$this->module=$module;
		$this->_registry=Registry::getInstance();
	}
	
	/**
	 * Renderiza una vista
	 * @param string $view Nombre de la vista a renderizar
	 * @param array $args Parametros a enviar a la vista
	 */
	public function view($view,$args=array()){
		$js=new generalJavaScriptFunction();
		
		$file = SITE_PATH.'application/modules/'.$this->module.'/'.$view.'View.php';
		
		if(velkan::$config["session"]["generateJSScriptValidation"]){
			page::addJavaScriptOnLoad($js->getDefinition("validateSession"),true);
			unset($js);
		}
		
		$js->registerFunction("generalFunctions");
		
		if($this->_registry->model){
			page::addJavaScriptOnLoad($this->_registry->model->getJSOnLoad());
		}
		
		$this->render_file($file, $args);
	}
	
	/**
	 * Despliega un error como si fuera una vista creada por el usuario. Las páginas se encuentran en framework/errors/
	 * @param string $error Nombre del error. Los tipos de error aceptados estan en velkan::ERROR_TYPE...
	 * @param array $args Argumentos a pasar a los archivos de error.
	 */
	public function error($error,$args=array()){
		$file=SITE_PATH."framework/errors/$error.php";
		$this->render_file($file, $args);
	}
	
	private function render_file($file,$args){
		if(velkan::$config["baseLayout"]==""){
			if(!$this->renderView($file, $args)){
				Error::display_error(array("error"=>"noView"));
			}
			return true;
		}else{
			
			if($this->_registry->layout){
				$layout= SITE_PATH."application/layouts/".$this->_registry->layout.'/'.$this->_registry->layout."View.php";
				$layoutControllerClass=$this->_registry->layout;
				$layoutControllerFile=SITE_PATH."application/layouts/".$this->_registry->layout."/".$this->_registry->layout."Controller.php";
			}else{
				$layout= SITE_PATH."application/layouts/".velkan::$config["baseLayout"].'/'.velkan::$config["baseLayout"]."View.php";
				$layoutControllerClass=velkan::$config["baseLayout"];
				$layoutControllerFile=SITE_PATH."application/layouts/".velkan::$config["baseLayout"]."/".velkan::$config["baseLayout"]."Controller.php";
			}
			
			if(file_exists($layoutControllerFile)){
				include_once $layoutControllerFile;
				$layoutObj=new $layoutControllerClass;
				if(!$layoutObj->validations()){
					return false;
				}
				unset($layoutObj);
			}
			
			$content=$this->renderView($file, $args,true);
			if(!$content){
				$content=Error::_display_error_internal(array("error"=>"noView"));
			}
			if(is_readable($layout)){
				require($layout);
				return true;
			}
			
			Error::display_error(array("error"=>"noLayout"));
		}
	
	}
	
	private function renderView($__file,$__args, $__return=false){
		if(is_array($__args)){
			extract($__args);
		}
		
		if($this->_registry->model){
			/*
			 * La variable $model sirve para que se tenga fácil acceso desde los views
			 */
			$model=&$this->_registry->model;
		}
		if(is_readable($__file)){
			if($__return){
				
				ob_start();
				ob_implicit_flush(false);
				require $__file;
				return ob_get_clean();
			}else{
				require $__file;
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Obtiene un modelo en específico
	 * @param string $name Nombre del modelo a cargar
	 * @param boolean $noError Define si mostrará un error si no encuentra el archivo
	 * @return boolean
	 */
	public function getModel($name,$noError=false){
		$model = $name.'Model';
		$controller=$this->_registry->controllerName;
		$modelPath = SITE_PATH.'application/modules/'.$controller.'/'.$model.'.php';
		
		$this->_registry = Registry::getInstance();
		
		if(is_readable($modelPath)){
			require_once($modelPath);
			if(class_exists($model)){
				/*Utilizar la funcion Registry::getInstance nos permite acceder a los metodos
				 * que tenga el modelo que estamos cargando como si fueran parte del controlador*/
				/*$registry = Registry::getInstance();
				$registry->model = new $model;
				$registry->modelLoaded=true;*/
				
				$this->_registry->model = new $model;
				$this->_registry->modelLoaded=true;
				
				return $this->_registry->model;
			}
		}
		if(!$noError){
			Error::display_error(array("error"=>"noModel"));
		}
		
		$this->_registry->modelLoaded=false;
		
		return false;
	}
	
	final public function __get($key){
		if($return = $this->_registry->$key){
			return $return;
		}
		return false;
	}
}