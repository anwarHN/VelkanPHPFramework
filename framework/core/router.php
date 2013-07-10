<?php
/**
 * Velkan PHP Framework
 * Clase router
 * Sirve para obtener el controlador que se obtenga desde el request
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 */
class router{

	public static function route(request $request){
		//Velkan utiliza variables de sesion para su funcionamiento, por lo que siempre iniciara sesion
		session::_beginSession();
		
		//Busca si hay parametros pasados por variable de sesion
		if(isset($_SESSION["innerParams"])&&is_array($_SESSION["innerParams"])){
			$request->mergeInnerParams();
		}
		
		/*Validamos si es una ejecución AJAX*/
		if(velkan::isAjaxCall()){
			/*Validamos si es una funcion estandar de Velkan
			 * Las funciones estandar para javascript estan en el archivo:
			 * framework/core/standar_functions/generalJavaScriptFunctions
			 * */
			if($request->isStandarFunction()){
				if($request->isGetCaptchaFunction()){
					require SITE_PATH."framework/core/clientside/form/captcha/generateCaptcha.php";
				}else{
					$function=new generalJavaScriptFunction();
					
					if($function->isValid($request->getAjaxFunction())){
						unset($function);
						$obj=array("generalJavaScriptFunction",$request->getAjaxFunction());
						if($request->getArgs()){
							call_user_func($obj,$request->getArgs());
						}else{
							call_user_func($obj);
						}
					}
				}
			}else{
				if($request->isCacheFunction()){
					//echo "Cache function ".$request->getCacheFunction()."::".$_SESSION["cacheFunctions"][$request->getCacheFunction()];
					eval($_SESSION["cacheFunctions"][$request->getCacheFunction()]);
				}else{
					/*Instanciamos el modelo*/
					$file=array("model"=>$request->getController(),
							"method"=>$request->getMethod(),
							"args"=>$request->getArgs()
					);
					include_once SITE_PATH."application/modules/".$request->getController()."/".$request->getController()."Model.php";
					$class=$request->getController()."Model";
					$model=new $class;
					/*Validamos si la accion a ejecutar es subir un archivo*/
					if($request->isUpload){
						require SITE_PATH.'framework/core/filesmanagement/uploadFiles.php';
					}else{
						$obj=array($model,$request->getAjaxFunction());
						
						if($request->getArgs()){
							call_user_func($obj,$request->getArgs());
						}else{
							call_user_func($obj);
						}
					}
				}
			}
		}else{
			if($request->isGetCaptchaFunction()){
				//debugLogger::log("captcha", "Entro");
				require SITE_PATH."framework/core/clientside/form/captcha/generateCaptcha.php";
			}else{
				$file=array("controller"=>$request->getController().'Controller',
							"method"=>$request->getMethod(),
							"args"=>$request->getArgs()
							);
				
				
			self::_routeFile($file);
			}
		}
	}
	
	/**
	 * Redirecciona a un controlador en específico
	 * @param string $link Controlador a cargar
	 * @param array $innerParams Parámetros a enviar al controlador por medio de sesion
	 */
	public static function redirect($link,array $innerParams=array()){
		
		if(!empty($innerParams)){
			$_SESSION["innerParams"]=$innerParams;
		}
		
		if(!headers_sent()){
			header("location: ?c=$link");
		}else{
			page::addJavaScriptOnLoad("window.location=\"?c=".$link."\";",true);
		}
	}
	
	private static function _routeFile(array $file){
		$controller=$file["controller"];
		$method=$file["method"];
		$args=$file["args"];
		
		$registry=registry::getInstance();
		$registry->controllerName=str_replace("Controller", "", $controller);
		$registry->controllerMethod=$method;
		
		$controllerFile = SITE_PATH.'application/modules/'.str_replace("Controller", "", $controller).'/'.$controller.'.php';
		
		if(is_readable($controllerFile)){
			require_once $controllerFile;
			
			$controller = new $controller;
			$method = (is_callable(array($controller,$method))) ? $method : 'index';
			
			if(!empty($args)){
				call_user_func(array($controller,$method),$args);
			}else{
				call_user_func(array($controller,$method));
			}
			return;
		}else{
			if(velkan::$config["baseLayout"]!==""){
				$layout= SITE_PATH."application/layouts/".velkan::$config["baseLayout"].'/'.velkan::$config["baseLayout"]."View.php";
				
				$content=Error::_display_error_internal(array("error"=>"404"));
				
				if(is_readable($layout)){
					require($layout);
					return true;
				}
			}
		}
	}
	/*
	static function renderAjax(array $file){
		extract($file);
		
		$fileName=SITE_PATH."application/modules/".$model."Model.php";
		include_once $filename;
		$modelClass = new $model;
		
		if(method_exists($modelClass, $method)){
			if(!empty($args)){
				call_user_func(array($model,$method),$args);
			}else{
				call_user_func(array($model,$method));
			}
		}
	}
	*/
}
?>