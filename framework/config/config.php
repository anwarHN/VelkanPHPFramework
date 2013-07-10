<?php
return array(
			"appName"=>"Prueba",
			"author"=>"Anwar Garcia",
			"contact"=>"garciaanwar@gmail.com",
			"metas"=>array(
						array(
							"name"=>"viewport",
							"content"=>"width=device-width, initial-scale=1.0"
							),
						array(
							"name"=> "description",
							"content"=>"Velkan PHP Framework"
							),
						array(
							"name"=> "author",
							"content"=>"Anwar Garcia"
							),
						array("name"=>"generator",
							"content"=>"Velkan PHP Framework"
								)
					),
			"js_files"=>array("jquery.js","jquery.validate.js","jquery.dateFormat-1.0.js","jquery.form.js","jquery.ajaxq-0.0.1.js"),
			"css_files"=>array(),
			"bootstrap"=>"lib/bootstrap/",
			"appLanguage"=>"es",
			"baseLayout"=>"mainLayout",
			"charset"=>"utf-8",
			"session"=>array(
					"autoStart"=>true,
					/**
					 * lifeTime
					 * Debe ser especificado en segundos. Esta variable determinará el tiempo de vida con el que la funcion session::_validateLifeTime() va a comparar
					 */
					"lifeTime"=>"600",
					/**
					 * generateJSScriptValidation
					 * Generará una funcion javascript que validará el tiempo de vida de una sesión y hará logout automáticamente
					 */
					"generateJSScriptValidation"=>false,
					/**
					 * autoValidate
					 * Ejecutará automáticamente la verificación del tiempo de vida de la sessión
					 */
					"autoValidate"=>false,
					"savePath"=>SITE_PATH."sessions",
					"userControl"=>array(
							"savePath"=>SITE_PATH."sessions/udata"
							)
					),
			"debug"=>array(
					/*Si el debug se activa, aparecerán ventanas dentro de la pagina con información 
					 * de errores, sino, se guargará un archivo velkan.log en la ubicacion del parametro 
					 * debug->savePath
					 */
					"enabled"=>true,
					/*
					 * Ruta donde se guardará el archivo velkan.log cuando se desactive el debug 
					 */
					"savePath"=>SITE_PATH."logs"
					),
			"model"=>array(
					/**
					 * Este parametro cargará los modelos automáticamente, no tirará exception si falla
					 */
					"autoLoad"=>true),
			"cypher"=>array(
					"iv"=>"12345678"),
			/*Configuración para el objeto datagrid*/
			"datagrid"=>array(
					"containerClass"=>"",
					"tableClass"=>"table table-striped table-hover table-bordered",
					"paginationClass"=>"pagination pagination-small pagination-right",
					"maxRowsPerPage"=>10,
					"maxNumPages"=>3,
					"activePaginationButtonClass"=>"active",
					"filters"=>array(
							"inputClass"=>"span2",
							"invalidCaracter"=>"',\""
							),
					"progressBarClass"=>"progress progress-striped active"
					),
			"input"=>array(
					"defaultSize"=>input::$INPUT_SIZE_MEDIUM
					),
			/*Configuración para el objeto datepicker*/
			"datetimepicker"=>array(
					/*Estos parametros son para el objeto datetimepicker
					 * vea http://www.malot.fr/bootstrap-datetimepicker/ para las opciones del plugin
					 * */
					
					//Buscará el archivo que se especifique en la carpeta lib\bootstrap\plugins\bootstrap-datetimepicker\js\locales para cargar el objeto con el idioma que necesitamos
					"localFile"=>"bootstrap-datetimepicker.es.js",
					
					//Formatos para los tipos de datos
					//Los formatos que comienzan con la palabra dataBase, es la conversión que hará el control antes de enviar los datos al adaptador de la base de datos

					//Formatos para campos solo fecha
					"dateFormat"=>"dd/mm/yyyy",
					"dataBaseDateFormat"=>"yyyy-mm-dd",
					
					//Formatos para campos sólo hora
					"timeFormat"=>"HH:ii P",
					"dataBaseTimeFormat"=>"hh:ii:ss",
					"showMeridianView"=>true,
					
					//Formatos para campos fecha y hora
					"dateTimeFormat"=>"dd/mm/yyyy HH:ii P",
					"dataBaseDateTimeFormat"=>"yyyy-mm-dd hh:ii:ss",
					
					"hideOnClic"=>true,
					"inputClass"=>"span2"
					),
			/*Configuración para el objeto textarea*/
			"textarea"=>array(
					/*Buscara el archivo para el idioma del editor Wysihtml para el textarea
					 * en la direccion lib/bootstrap/plugins/wysihtml5/src/locales/
					 */
					"localeJSFile"=>"bootstrap-wysihtml5.es-ES.js",
					/*Seteará la configuración del idioma local en el textarea cuando se use Wysihtml*/
					"locale"=>"es-ES"
					),
			/*Configuración para el objeto checkbox*/
			"checkbox"=>array(
					/*Classe del objeto checkbox*/
					"class"=>"checkbox",
					/*Clase para el label del objeto*/
					"labelClass"=>"checkbox"
					),
			/*Configuración para el objeto radiobutton*/
			"radiobutton"=>array(
					/*Classe del objeto radio*/
					"class"=>"radio",
					/*Clase para el label del objeto*/
					"labelClass"=>"radio"
					),
			/*Configuración para el objeto file*/
			"file"=>array(
					/*Directorio para subir archivos*/
					"uploadDir"=>SITE_PATH."uploads",
					/*Máximo número de archivos que se permite subir por página*/
					"maxFilesPerPage"=>5,
					/*Tamaño máximo de los archivos a subir en bytes
					 * @see http://www.123marbella.co.uk/free-bandwidth-calculator/*/
					"maxFileSize"=>"10485760",
					/*Si se setea true, sobreescribirá el valor que se indique de esta misma
					 * propiedad a cada objeto. El objetivo es cambiar el nombre del archivo
					 * una vez se suba al servidor. Esto por ciertos sistemas que necesitan
					 * poner otros nombre a sus archivos*/
					"changeUploadedFileName"=>false),
			/*Parametros por defecto del objeto button*/
			"button"=>array(
					"class"=>"btn"
					),
			/*Parametros del objeto captcha*/
			"captcha"=>array(
					/*Nombre del archivo del tipo de letra que usará.
					 * Los archivos de tipos de letras se encuentran en framework/core/clientside/form/captcha/fonts/
					 */
					"font"=>"font28.ttf",
					/*Si se setea true, el fondo del captcha tendra varios puntos en forma aleatorea*/
					"renderDots"=>true,
					/*Si se setea true, el fondo del captcha tendra varias lineas en forma aleatorea*/
					"renderLines"=>true),
		/*Parametros del objeto selector*/
			"lookup"=>array(
					"containerDivClass"=>"input-append",
					"spanClass"=>"input-medium",
					"buttonClass"=>"btn",
					"defaultIcon"=>"icon-search",
					"modalClass"=>"modal hide fade"
					),
			"form"=>array(
					"alertSavingOkClass"=>"alert-info",
					"alertSavingNotOkClass"=>"alert-error",
					"alertWarningClass"=>"alert-warning",
					"alertErrorClass"=>"alert-error"
					),
			"htmlHelper"=>array(
					"breadcrumbs"=>array(
							"homeUrl"=>"index/index"
							)
					)
		)
?>