<?php
/**
 * Velkan PHP Framework
 * Clase abstracta para las clases controladoras
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
abstract class controller{
	protected $_registry;
	protected $render;
	
	public $view;
	
	/**
	 * Modelo cargado por el controlador. Se carga automáticamente el modelo que tenga el mismo nombre del controlador. Se puede
	 * cambiar de modelo mediante la funcion $this->getModel();
	 * @var unknown_type
	 */
	public $model;
	
	/**
	 * Titulo del controlador. Se utilizará por ejemplo en el breadcrumb
	 * @var string
	 */
	protected $title;
	
	final function setTitle($title){
		$this->title=$title;
		$registry=registry::getInstance();
		
		$registry->controllerTitle=$title;
		
		unset($registry);
	}
	
	function __construct(){
		/*Para instanciar otros objetos en una sola instancia*/
		$this->_registry = Registry::getInstance();
		
		/*El metodo render recibe como parametro el modulo, que es el nombre de la clase controladora
		 * sin el texto "Controller", de esa forma, podemos guardar las vistas en carpetas
		 * como si fueran modulos para un mejor orden. El modulo sera igual al nombre de la carpeta
		 * que tenga el view.
		 * 
		 * Si la clase controladora se llama indexController, el modulo será index, y la carpeta
		 * donde esten las vistas se deberá llamar index.*/
		$controller=str_replace("Controller", "", get_class($this));
		
		$this->render = new render($controller);
		
		$this->_registry->modelLoaded=false;
		
		if(velkan::$config["model"]["autoLoad"]){
			$this->model=$this->render->getModel($controller,true);
			/*
			$this->model=$this->_registry->model;
			*/
		}
	}
	
	/**
	 * Esta funcion sirve para declarar un layout diferente al definido en la variable
	 * de configuracion
	 * 
	 * @param string $layout
	 */
	final function setLayout($layout){
		$this->_registry->layout=$layout;
	}
	
	/**
	 * Obtiene el modelo en caso de que no se haya cargado automáticamente
	 */
	final public function getModel($modelName=""){
		if(!empty($modelName)&&$modelName!==""){
			$this->render->getModel($modelName,false);
			$this->model=$this->_registry->model;
		}else{
			$this->render->getModel($controller,true);
			$this->model=$this->_registry->model;
		}
	}
	
	final public function __get($key){
		if($return = $this->_registry->$key){
			return $return;
		}
		return false;
	}
	
	function __toString(){
		return get_class($this);
	}
}
?>