<?php
	class velkan{
		/**
		 * Variable de configuración global. Por medio de ella se acceden a los parámetros definidos
		 * en el archivo framework/core/config/config.php
		 * @var array
		 */
		static $config;
		
		/**
		 *  Variable de configuración de parámetros para la base de datos. Por medio de ella
		 *  se accede a la configuracion del archivo framework/core/config/dbConfig.php
		 * @var unknown_type
		 */
		static $configDB;
		
		/**
		 * Variable de configuración de lenguage. Por medio de ella se accede a la configuración
		 * y mensajes predeterminados definidos en framework/core/config/language.php
		 * @var unknown_type
		 */
		static $lang;
		
		static $modules=array();
		
		static $DATATYPE_STRING="string";
		static $DATATYPE_NUMBER="number";
		static $DATATYPE_DATE="date";
		static $DATATYPE_TIME="time";
		static $DATATYPE_DATETIME="date_time";
		
		static $ERROR_TYPE_404="404";
		static $ERROR_TYPE_NO_VIEW_FOUND="noView";
		static $ERROR_TYPE_NO_DATA_FOUND="noDataFound";
		static $ERROR_TYPE_NO_CONTROLLER_FOUND="noController";
		static $ERROR_TYPE_NO_LAYOUT_FOUND="noLayout";
		static $ERROR_TYPE_NO_MODEL_FOUND="noModel";
		static $ERROR_TYPE_NO_ACTIVE_SESSION="noSession";
		static $ERROR_TYPE_NO_USER_FOUND="noUser";
		
		
		
		static function _getAppName(){
			echo self::$config["appName"];
		}
		
		static function _getLanguage(){
			echo self::$config["appLanguage"];
		}
		
		static function _getCharset(){
			echo self::$config["charset"];
		}
		
		static function widget($widget,array $args,$render=false){
			$vars=explode('.',$widget);
			try{
				include_once SITE_PATH."framework/widgets/{$vars[0]}/include.php";
			}catch (VException $e){
				$e->process();
			}
			
			if(!include_once SITE_PATH."framework/widgets/{$vars[0]}/{$vars[1]}.php"){
				$e= new VException("No se encuentra el widget: $widget");
				$e->process();
			}
			
			$__class= "widget_".str_replace(".","_",$widget);
			
			if(!$wid=new $__class){
				$e= new VException("No se encuentra el widget: $widget");
				$e->process();
			}
			
			$wid->setParams($args);
			
			if($render){
				$wid->render();
				unset($wid);
			}else{
				return $wid;
			}
		}
		
		static function _init_modules(){
			self::$modules=array(
					"vRegistry"=>SITE_PATH.'framework/core/registry.php',
					"vRender"=>SITE_PATH.'framework/core/render.php',
					"vReques"=>SITE_PATH.'framework/core/request.php',
					"vRouter"=>SITE_PATH.'framework/core/router.php',
					"vModel"=>SITE_PATH.'framework/core/abstracts/model.php',
					"vDataBaseAdapterInterface"=>SITE_PATH.'framework/db/adapters/dbAdapterBase.php',
					"vDataBase"=>SITE_PATH.'framework/db/db.php',
					"vAdapterDataBase"=>SITE_PATH.'framework/db/adapters/dbAdapterBase.php',
					"vBaseController"=>SITE_PATH.'framework/core/abstracts/controller.php',
					"vError"=>SITE_PATH.'framework/errors/error.php',
					"vSession"=>SITE_PATH.'framework/core/session.php',
					"vCrypt"=>SITE_PATH."framework/core/crypt.php",
					"vUserBase"=>SITE_PATH."framework/user_control/userBase.php",
					"vUserControl"=>SITE_PATH."framework/user_control/userControl.php",
					"vUser"=>SITE_PATH."framework/user_control/user.php",
					"vException"=>SITE_PATH."framework/exceptions/exception.php",
					"vClientSide"=>SITE_PATH."framework/core/clientside/include.php",
					"vGeneralJavaScriptFunctions"=>SITE_PATH."framework/core/generalFunctions/generalJavaScriptFunctions.php",
					"vGeneralPHPFunctions"=>SITE_PATH."framework/core/generalFunctions/generalPHPFunctions.php",
					"vDebugLogger"=>SITE_PATH."framework/core/debugLogger.php",
					"vCacheFunctions"=>SITE_PATH."framework/core/cacheFunctions/cacheFunctions.php",
					"vJSHelper"=>SITE_PATH."framework/core/helpers/jsHelper.php",
					"vHtmlHelper"=>SITE_PATH."framework/core/helpers/htmlHelper.php"
					);
			
			foreach (self::$modules as $mod){
				include_once $mod;
			}
		}
		/**
		 * Redirecciona a un controlador en específico
		 * @param string $link Controlador a cargar
		 * @param array $innerParams Parámetros a enviar al controlador por medio de sesion
		 */
		static function redirect($link,array $innerParams=array()){
			router::redirect($link,$innerParams);
		}
		
		/**
		 * Determina si la ejecución actual es por el metodo httpRequest (o Ajax), o no
		 * @return boolean
		 */
		static function isAjaxCall(){
		    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		    	return true;
		    }else{
		    	return false;
		    }
		}
	}
	
	velkan::_init_modules();
	
	velkan::$config=include SITE_PATH."framework/config/config.php";
	velkan::$configDB=include SITE_PATH."framework/config/dbConfig.php";
	velkan::$lang=include SITE_PATH."framework/config/language.php";
?>