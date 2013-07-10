<?php
/**
 * Velkan PHP Framework
 * Clase request
 * Sirve para obtener el controlador que se esta solicitando en la URL
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 */
	class request{
		private $_controller;
		private $_method;
		private $_methodParams;
		
		private $_request_method;
		private $_ajaxFunction;
		private $_args =array();
		private $_isStandarFunction=false;
		private $_isGetCaptcha=false;
		private $cacheFunction=false;
		private $cacheFunctionId="";
		
		public $isUpload=false;
		public $hasMethodParams=false;
		
		
		public function __construct(){
			$this->method=$_SERVER["REQUEST_METHOD"];
			if($this->method=="POST"){
				$this->_args=$_POST;
				$this->_request_method="POST";
			}else{
				$this->_args=$_GET;
				$this->_request_method="GET";
			}
			
			
			//debugLogger::log("request", var_dump($this->_args));
			
			$parts=array();
			
			//Parametro 'c'
			if(isset($this->_args["c"])){
				$parts=explode('/',html_entity_decode($this->_args["c"]));
			}
			
			//Parametro 'm'
			if(isset($this->_args["m"])){
				$parts=explode('/',html_entity_decode($this->_args["m"]));
			}
			
			//Parametro 'a'
			if(isset($this->_args["a"])){
				$this->_ajaxFunction=$this->_args["a"];
				unset($this->_args["a"]);
			}
			
			if(isset($this->_args["sf"])){
				$this->_ajaxFunction=$this->_args["sf"];
				$this->_isStandarFunction=true;
				if($this->_ajaxFunction=="getCaptcha"){
					$this->_isGetCaptcha=true;
				}
				unset($this->_args["sf"]);
			}
			
			if(!empty($parts)){
				$this->_controller = ($parts[0]=="")? 'index':$parts[0];
				$this->_method = ($parts[1]=="")? 'index':$parts[1];
				if(count($parts)>2){
					unset($parts[0]);
					unset($parts[1]);
					
					foreach($parts as $part){
						$this->_args["methodParams"][]=$part;
					}
					
					$this->_methodParams=$parts;
					$this->hasMethodParams=true;
				}
			}else{
				$this->_controller = "index";
				$this->_method = "index";
			}
			
			if(isset($this->_args["c"])){
				unset($this->_args["c"]);
			}
			if(isset($this->_args["m"])){
				unset($this->_args["m"]);
			}
			
			if(isset($this->_args["u"])){
				unset($this->_args["u"]);
				$this->isUpload=true;
			}
			
			if(isset($this->_args["cacheFunction"])){
				$this->cacheFunction=true;
				$this->cacheFunctionId=$this->_args["cacheFunction"];
			}
			
			$registry=registry::getInstance();
			/*La propiedad args del objeto registry, sirve para pasar todos los parametros o argumentos ya sea que se recibieron
			 * mediante GET o POST o sean parametros internos usados desde el método velkan::redirect*/
			$registry->args=$this->_args;
			
			/*La propiedad httpArgs guarda los partametros recibidos desde GET o POST, pero no guardar los parametros internos
			 * que se definan cuando se usa el metodo velkan::redirect
			 */
			$registry->httpArgs=$this->_args;
		}
		
		public function getController(){
			return $this->_controller;
		}
		public function getMethod(){
			return $this->_method;
		}
		public function getMethodParams(){
			return $this->_methodParams;
		}
		
		public function getArgs(){
			if(!empty($this->_args)){
				return $this->_args;
			}else{
				return false;
			}
		}
		
		public function isStandarFunction(){
			return $this->_isStandarFunction;
		}
		
		public function isGetCaptchaFunction(){
			return $this->_isGetCaptcha;
		}
		
		public function getAjaxFunction(){
			return $this->_ajaxFunction;
		}
		
		public function isCacheFunction(){
			return $this->cacheFunction;
		}
		
		public function getCacheFunction(){
			return $this->cacheFunctionId;
		}
		
		public function mergeInnerParams(){
			$this->_args=array_merge($this->_args,$_SESSION["innerParams"]);
			unset($_SESSION["innerParams"]);
			
			$registry=registry::getInstance();
			unset($registry->args);
			$registry->args=$this->_args;
		}
	}
?>