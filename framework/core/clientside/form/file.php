<?php
/**
 * Velkan PHP Framework
 * File control - Coleccion de propiedades para renderizar control de subir archivos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class file extends globalAttr{
	/**
	 * Controla cuantos archivos se pueden subir por página
	 * @var int
	 */
	protected $maxFilesPerPage=0;
	
	/**
	 * Tamaño máximo de los archivos en bytes
	 * @var int
	 */
	protected $maxFileSize=0;
	
	/**
	 * Directorio al que se subiran los archivos
	 * @var string
	 */
	protected $uploadDir="";
	
	/**
	 * Nombre del contorl
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Extensiones permitidas
	 * @var array
	 */
	protected $allowedFileExtensions=array();
	
	protected $allowedFileExtensionsStr="";
	
	/**
	 * Define si se pueden seleccionar varios archivos a la vez
	 * @var boolean
	 */
	protected $multiple=false;
	
	/**
	 * Determina si el control subirá automáticamente los archivos
	 * @var boolean
	 */
	protected $uploadAtOnce=false;
	
	/**
	 * Arreglo de parámetros adicionales
	 * @var array
	 */
	protected $additionalParameters=array();
	
	protected $_registry;
	
	/**
	 * Determina si se cambiará el nombre del archivo al subirlo.
	 * Puede ser sobreescribido por la variable velkan::$config["file"]["changeUploadedFileName"]
	 * @var boolean
	 */
	protected $changeUploadedFileName=false;
	
	/**
	 * Controla si el objeto mostrará el boton de subir
	 * @var boolean
	 */
	protected $showUploadButton=true;
	
	/**
	 * Tipo de dato que almacenará el objeto
	 * @var string
	 */
	protected $dataType="file";
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
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
		
		if(isset($args["name"])){
			$this->name=$args["name"];
		}else{
			$this->name=$this->id;
		}
		
		$this->maxFileSize=velkan::$config["file"]["maxFileSize"];
		$this->uploadDir=velkan::$config["file"]["uploadDir"];
		$this->maxFilesPerPage=velkan::$config["file"]["maxFilesPerPage"];
		
		if(isset($args["allowedFileExtensions"])){
			$this->allowedFileExtensions=explode(",",$args["allowedFileExtensions"]);
			foreach($this->allowedFileExtensions as $ext){
				if($this->allowedFileExtensionsStr==""){
					$this->allowedFileExtensionsStr.=".$ext";
				}else{
					$this->allowedFileExtensionsStr.=",.$ext";
				}
			}
		}
		
		if(isset($args["multiple"])){
			$this->multiple=$args["multiple"];
		}
		
		if(isset($args["maxFileSize"])){
			$this->maxFileSize=(int)$args["maxFileSize"];
		}
		
		$this->_registry=registry::getInstance();
	}
	
	/**
	 * Setea el tamaño máximo del archivo a subir
	 * @param integer $size Tamaño del archivo en bytes
	 * @see http://www.123marbella.co.uk/free-bandwidth-calculator/
	 */
	public function setMaxFileSize($size){
		$this->maxFileSize=(int)$size;
	}
	
	/**
	 * Setea las extensiones permitidas
	 * @param string $fileExtensions Extensiones permitidas
	 * @example $upload->setAllowedFileExtensions("jpg,jpeg,mp3");
	 */
	public function setAllowedFileExtensions($fileExtensions){
		$this->allowedFileExtensions=explode(",",$fileExtensions);
		foreach($this->allowedFileExtensions as $ext){
			if($this->allowedFileExtensionsStr==""){
				$this->allowedFileExtensionsStr.=".$ext";
			}else{
				$this->allowedFileExtensionsStr.=",.$ext";
			}
		}
	}
	
	/**
	 * Setea si permitirá seleccionar varios archivos a la ves
	 * @param boolean $value Si se define true, permitirá subir varios archivos
	 * @example $upload->setMultiple(true);
	 */
	public function setMultiple($value){
		$this->multiple=$value;
	}
	
	/**
	 * Setea si el control subirá los archivos de forma automática
	 * @param boolean $value
	 * @example $upload->setUploadAtOnce(true);
	 */
	public function setUploadAtOnce($value){
		$this->uploadAtOnce=$value;
	}
	
	/**
	 * Setea si el control cambiará los nombres de los archivos.
	 * El nombre compuesto sera el ID de session, mas el año, mes, dia, hora, minuto, segundo, milisegundo
	 * @param boolean $value
	 * @example $upload->setChangeUploadFileName(true). Si el archivo se llama "Mi song.mp3", lo camiará por algo como "3415jmbarvsjjgk117mbo5vdl0_201304201434385360"
	 */
	public function setChangeUploadFileName($value){
		$this->changeUploadedFileName=$value;
	}
	
	/**
	 * Setea si mostrará o no el boton de Subir
	 * @param boolean $value
	 */
	public function setShowUploadButton($value){
		$this->showUploadButton=$value;
	}
	
	/**
	 * Renderiza la funcion javascript que se ejecutará del lado del cliente
	 */
	private function renderJsFunction(){
		if(velkan::$config["file"]["changeUploadedFileName"]){
			$this->changeUploadedFileName=true;
		}
		
		$extValidation="";
		
		if(!empty($this->allowedFileExtensions)){
			foreach($this->allowedFileExtensions as $fileExt){
				$extValidation.="case '$fileExt': ";
			}
			
			$msj=velkan::$lang["file"]["notAllowedFileExtension"];
			
			$extValidation="switch(extension){".$extValidation;
			$extValidation.="error=false;break;";
			$extValidation.="default: alert(extension);alert('$msj');el=document.getElementById('{$this->id}__THEFORM__');el.reset();error=true;}";
		}
		
		$queue="{$this->id}Queue";
		
		page::addJavaScript($js);
		
		$js="{$this->id}__THEFILECOUNTER__=0;";
		$js.="{$this->id}__THECURRENTFILE__=0;";
		$js.="function {$this->id}Validate(me){";
			$js.="var error=false;";
			$js.="for(i=0;i<me.files.length;i++){";
				$js.="var file = me.files[i];";
				$js.="var name = file.name;";
				$js.="extension=name.split('.').pop().toLowerCase();";
				$js.="size = file.size;";
				$js.="sizeMB = (size / 1024)/1024;";
				$js.="type = file.type;";
				$js.="if(size>{$this->maxFileSize}){";
					$js.="error=true;";
					$js.="alert('".velkan::$lang["file"]["maxFileSizeExceeded"]."');";
				$js.="}";
		
		if($extValidation!==""){
				$js.="else{".$extValidation."}";
		}
			$js.="}";
		
		$js.="if(!error){";
		$js.="{$this->id}__THEFUNCTION__(me);";
		$js.="}";
		$js.="}";
		
		$js.="{$this->id}__THEFILECOUNTER__=0;";
		
		$uploadButton=velkan::$lang["file"]["uploadButton"];
		$deleteButton=velkan::$lang["file"]["deleteButton"];
		
		/*Funcion que maneja la barra de progreso*/
		$jsFH="function (e){";
		$jsFH.="if(e.lengthComputable){";
		$jsFH.="progress=Math.round((e.loaded/e.total)*100);";
		$jsFH.="$('#{$this->id}__THEPROGRESSBAR__'+theFile).css('width',progress+'%');";
		$jsFH.="$('#{$this->id}__THEPROGRESSBAR__'+theFile).html(progress+'%');";
		$jsFH.="}";
		$jsFH.="}";
		
		/*Funcion que manjea la subida del archivo*/
		//$jsFU.="var uploadFunction=\"";
		//$jsFU.="$('#{$this->id}\"+{$this->id}__THEFILECOUNTER__+\"_uploadbutton').bind('click',function(){";
		$jsFU="function {$this->id}_THEUPLOADFUNCTION_(theForm,theFile,theButtonsSpan){";
		
		//$jsFU.="{$this->id}__THECURRENTFILE__=\"+{$this->id}__THEFILECOUNTER__+\";";
		$jsFU.="{$this->id}__THECURRENTFILE__=theFile;";
		$jsFU.="var formData = new FormData($('#'+theForm)[0]);";
		//$jsFU.="console.log(formData);";
		//$jsFU.="console.log('Velkan: Subiendo archivo \"+theForm+\", numero: \"+{$this->id}__THEFILECOUNTER__+\"');";
		$jsFU.="$.ajax({";
			$jsFU.="url: '',";
			//$jsFU.="async: false,";
			$jsFU.="type: 'POST',";
			$jsFU.="xhr: function() {";
				$jsFU.="myXhr = $.ajaxSettings.xhr();";
				$jsFU.="if(myXhr.upload){";
					$jsFU.="myXhr.upload.addEventListener('progress',$jsFH, false);";
				//$jsFU.="}else{";
				//$jsFU.="\$('#{$this->id}_THEERROR_ div.alert-error').html(myXhr.status).show();";
				$jsFU.="}";
				$jsFU.="return myXhr;";
			$jsFU.="},";
			//Ajax events
			//$jsFU.="beforeSend: function(){\$('#{$this->id}\"+{$this->id}__THEFILECOUNTER__+\"_uploadbutton').attr('disabled','true');\$('#{$this->id}\"+{$this->id}__THEFILECOUNTER__+\"_deletebutton').attr('disabled','true');},";
			$jsFU.="beforeSend: function(){\$('#{$this->id}'+theFile+'_uploadbutton').attr('disabled','true');\$('#{$this->id}'+theFile+'_deletebutton').attr('disabled','true');},";
			//$jsFU.="complete: function(data){\$('#\"+theButtonsSpan+\"').toggle('slow');/*alert(data.responseText);*/},";
			$jsFU.="complete: function(data){\$('#'+theButtonsSpan).toggle('slow');console.log(data.responseText);},";
			$jsFU.="error: function(request, status, error){\$('#{$this->id}_THEERROR_ div.alert-error').html(error).show();\$('#{$this->id}'+theFile+'_uploadbutton').attr('disabled','false');},";
			// Form data
			$jsFU.="data: formData,";
			//Options to tell JQuery not to process data or worry about content-type
			$jsFU.="cache: false,";
			$jsFU.="contentType: false,";
			$jsFU.="dataType:'text',";
			$jsFU.="processData: false";
		$jsFU.="});";
		$jsFU.="}";
		
		page::addJavaScript($jsFU);
		
		$jsFD="$(\'#'+theRow+'\').remove();";
		
		/*Funcion que agrega el elemento al div contenedor de los archivos a subir*/
		$jsF="function {$this->id}__THEFUNCTION__(theInput){";
				$jsF.="{$this->id}__THEFILECOUNTER__+=1;";
				
				$jsF.="var clonedInput=$(theInput).clone(true);";
				$jsF.="$(theInput).after(clonedInput);";
				
				//$jsF.="theName='{$this->name}__THEINPUT__'+{$this->id}__THEFILECOUNTER__;";
				$jsF.="theName='{$this->name}__THEINPUT__'+{$this->id}__THEFILECOUNTER__;";
				$jsF.="theForm='{$this->id}__THEFORM__'+{$this->id}__THEFILECOUNTER__;";
				$jsF.="theRow ='{$this->id}__THEROW__'+{$this->id}__THEFILECOUNTER__;";
				$jsF.="theButtonsSpan ='{$this->id}__THEBUTTONSSPAN__'+{$this->id}__THEFILECOUNTER__;";
				
				//$jsF.="previus=$('#{$this->id}__THEFILES__').html();";
				
				$jsF.="toAdd='<tr id=\"'+theRow+'\"><td>';";
				//$jsF.="toAdd+='<table class=\"table\"><tr>';";
				//$jsF.="toAdd+='<td style=\"width:25%\">';";
				
				$jsF.="toAdd+='<div class=\"row-fluid\"><div class=\"span4\">';";
				
				$jsF.="toAdd+='<div style=\"display:none\">';";
				$jsF.="toAdd+='<form name=\"'+theForm+'\" method=\"POST\" enctype=\"multipart/form-data\" id=\"'+theForm+'\">';";
				
				$jsF.="toAdd+='<input type=\"hidden\" name=\"__THEINPUTNAME__\" value=\"'+theName+'\">';";
				$jsF.="toAdd+='<input type=\"hidden\" name=\"u\" value=\"true\">';";
				$jsF.="toAdd+='<input type=\"hidden\" name=\"fu\" value=\"{$this->id}CallBack\">';";
				$jsF.="toAdd+='<input type=\"hidden\" name=\"m\" value=\"".$this->_registry->controllerName."\">';";
				
				if($this->changeUploadedFileName){
					$jsF.="toAdd+='<input type=\"hidden\" name=\"changeFileName\" value=\"true\">';";
				}else{
					$jsF.="toAdd+='<input type=\"hidden\" name=\"changeFileName\" value=\"false\">';";
				}
				
				$jsF.="toAdd+='</form>';";
				$jsF.="toAdd+='</div>';";
				
				//Nombre de los archivos
				$jsF.="for(i=0;i<theInput.files.length;i++){";
				$jsF.="var file=theInput.files[i];";
				$jsF.="toAdd+=file.name+'<br/>';";
				$jsF.="}";
				//$jsF.="toAdd+='</td>';";
				$jsF.="toAdd+='</div>';";
				$jsF.="toAdd+='<div class=\"span2\">';";
				//Los botones
				//$jsF.="toAdd+='<td style=\"width:25%\">';";
				$jsF.="toAdd+='<div id=\"'+theButtonsSpan+'\">';";
					$jsF.="toAdd+='<div class=\"btn-group\">';";
						if($this->showUploadButton){
							$jsF.="toAdd+='<button class=\"btn btn-mini\" id=\"{$this->id}'+{$this->id}__THEFILECOUNTER__+'_uploadbutton\" title=\"$uploadButton\" onclick=\"javascript:{$this->id}_THEUPLOADFUNCTION_(\''+theForm+'\',\''+{$this->id}__THEFILECOUNTER__+'\',\''+theButtonsSpan+'\');\">';";
							$jsF.="toAdd+='<i class=\"icon-upload\" ></i></button>';";
						}
						$jsF.="toAdd+='<button class=\"btn btn-mini\" title=\"$deleteButton\" id=\"{$this->id}'+{$this->id}__THEFILECOUNTER__+'_deletebutton\" onclick=\"javascript:$jsFD\">';";
							$jsF.="toAdd+='<i class=\"icon-trash\"></i></button>';";
					$jsF.="toAdd+='</div>';";
				$jsF.="toAdd+='</div>';";
				//$jsF.="toAdd+='</td>';";
				
				//La barra de progreso
				//$jsF.="toAdd+='<td style=\"width:50%\">';";
				$jsF.="toAdd+='</div>';";
				$jsF.="toAdd+='<div class=\"span6\">';";
				
				$jsF.="toAdd+='<div class=\"progress progress-info progress-striped\">';";
					$jsF.="toAdd+='<div class=\"bar\" style=\"width:0%;\" id=\"{$this->id}__THEPROGRESSBAR__'+{$this->id}__THEFILECOUNTER__+'\"></div>';";
				$jsF.="toAdd+='</div>';";
				//$jsF.="toAdd+='</td>';";
				
				//Fin de la linea
				//$jsF.="toAdd+='</tr>';";
				$jsF.="toAdd+='</div></div>';";
				$jsF.="toAdd+='<div class=\"row-fluid hide\" id=\"{$this->id}_THEERROR_\">';";
				$jsF.="toAdd+='<div class=\"alert alert-error\">';";
				//$jsF.="toAdd+='<tr id=\"{$this->id}_ERROR_\" class=\"error\"><td colspan=3>Ocurrio un error al subir los archivos</td></tr>';";
				//$jsF.="toAdd+='</table></td></tr>';";
				$jsF.="toAdd+='</div></div>';";
				$jsF.="toAdd+='</td></tr>';";
				$jsF.="$('#{$this->id}__THEFILES__ tbody').append(toAdd);";
				
				$jsF.="$(theInput).removeAttr('onchange');";
				$jsF.="$(theInput).removeAttr('style');";
				$jsF.="$(theInput).removeAttr('title');";
				$jsF.="$(theInput).attr('name',theName+'[]');";
				$jsF.="$(theInput).attr('id',theName);";
				
				$jsF.="$(theInput).appendTo('#'+theForm);";
				$jsF.="$('#'+theRow).fadeIn('slow');";
				
				/*
				$jsF.=$jsFU;
				$jsF.="eval(uploadFunction);";
				*/
				
				if($this->uploadAtOnce){
					$jsF.="\$('#{$this->id}'+{$this->id}__THEFILECOUNTER__+'_uploadbutton').click();";
				}
			$jsF.="}";
		
		page::addJavaScript($js);
		page::addJavaScript($jsF);
	}
	
	/**
	 * Renderiza el objeto
	 */
	public function render(){
		if($this->maxFileSize==0){
			$this->maxFileSize=(int)velkan::$config["file"]["maxFileSize"];
		}
		
		$this->renderJsFunction();
		
		$label=velkan::$lang["file"]["label"]
		;
		$multiple=($this->multiple?"multiple":"");
		
		$render="<div id='{$this->id}__THECONTAINER__'>";
		$render.="<input type='file' onchange='javascript:{$this->id}Validate(this);' accept='{$this->allowedFileExtensionsStr}' title='$label' $multiple>";
		$render.="<table class='table table-striped' id='{$this->id}__THEFILES__' style=\"margin-top:10px\"><tbody></tbody></div>";
		$render.="</div>";
		echo $render;
	}
}
?>