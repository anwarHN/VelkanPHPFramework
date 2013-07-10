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
					 * Debe ser especificado en segundos. Esta variable determinar� el tiempo de vida con el que la funcion session::_validateLifeTime() va a comparar
					 */
					"lifeTime"=>"600",
					/**
					 * generateJSScriptValidation
					 * Generar� una funcion javascript que validar� el tiempo de vida de una sesi�n y har� logout autom�ticamente
					 */
					"generateJSScriptValidation"=>false,
					/**
					 * autoValidate
					 * Ejecutar� autom�ticamente la verificaci�n del tiempo de vida de la sessi�n
					 */
					"autoValidate"=>false,
					"savePath"=>SITE_PATH."sessions",
					"userControl"=>array(
							"savePath"=>SITE_PATH."sessions/udata"
							)
					),
			"debug"=>array(
					/*Si el debug se activa, aparecer�n ventanas dentro de la pagina con informaci�n 
					 * de errores, sino, se guargar� un archivo velkan.log en la ubicacion del parametro 
					 * debug->savePath
					 */
					"enabled"=>true,
					/*
					 * Ruta donde se guardar� el archivo velkan.log cuando se desactive el debug 
					 */
					"savePath"=>SITE_PATH."logs"
					),
			"model"=>array(
					/**
					 * Este parametro cargar� los modelos autom�ticamente, no tirar� exception si falla
					 */
					"autoLoad"=>true),
			"cypher"=>array(
					"iv"=>"12345678"),
			/*Configuraci�n para el objeto datagrid*/
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
			/*Configuraci�n para el objeto datepicker*/
			"datetimepicker"=>array(
					/*Estos parametros son para el objeto datetimepicker
					 * vea http://www.malot.fr/bootstrap-datetimepicker/ para las opciones del plugin
					 * */
					
					//Buscar� el archivo que se especifique en la carpeta lib\bootstrap\plugins\bootstrap-datetimepicker\js\locales para cargar el objeto con el idioma que necesitamos
					"localFile"=>"bootstrap-datetimepicker.es.js",
					
					//Formatos para los tipos de datos
					//Los formatos que comienzan con la palabra dataBase, es la conversi�n que har� el control antes de enviar los datos al adaptador de la base de datos

					//Formatos para campos solo fecha
					"dateFormat"=>"dd/mm/yyyy",
					"dataBaseDateFormat"=>"yyyy-mm-dd",
					
					//Formatos para campos s�lo hora
					"timeFormat"=>"HH:ii P",
					"dataBaseTimeFormat"=>"hh:ii:ss",
					"showMeridianView"=>true,
					
					//Formatos para campos fecha y hora
					"dateTimeFormat"=>"dd/mm/yyyy HH:ii P",
					"dataBaseDateTimeFormat"=>"yyyy-mm-dd hh:ii:ss",
					
					"hideOnClic"=>true,
					"inputClass"=>"span2"
					),
			/*Configuraci�n para el objeto textarea*/
			"textarea"=>array(
					/*Buscara el archivo para el idioma del editor Wysihtml para el textarea
					 * en la direccion lib/bootstrap/plugins/wysihtml5/src/locales/
					 */
					"localeJSFile"=>"bootstrap-wysihtml5.es-ES.js",
					/*Setear� la configuraci�n del idioma local en el textarea cuando se use Wysihtml*/
					"locale"=>"es-ES"
					),
			/*Configuraci�n para el objeto checkbox*/
			"checkbox"=>array(
					/*Classe del objeto checkbox*/
					"class"=>"checkbox",
					/*Clase para el label del objeto*/
					"labelClass"=>"checkbox"
					),
			/*Configuraci�n para el objeto radiobutton*/
			"radiobutton"=>array(
					/*Classe del objeto radio*/
					"class"=>"radio",
					/*Clase para el label del objeto*/
					"labelClass"=>"radio"
					),
			/*Configuraci�n para el objeto file*/
			"file"=>array(
					/*Directorio para subir archivos*/
					"uploadDir"=>SITE_PATH."uploads",
					/*M�ximo n�mero de archivos que se permite subir por p�gina*/
					"maxFilesPerPage"=>5,
					/*Tama�o m�ximo de los archivos a subir en bytes
					 * @see http://www.123marbella.co.uk/free-bandwidth-calculator/*/
					"maxFileSize"=>"10485760",
					/*Si se setea true, sobreescribir� el valor que se indique de esta misma
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
					/*Nombre del archivo del tipo de letra que usar�.
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