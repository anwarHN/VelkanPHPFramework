<?php
/**
 * Velkan PHP Framework
 * Lookup control - Coleccion de propiedades para renderizar control con boton que levanta un
 * popup para seleccionar o buscar registros
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class lookup extends globalAttr{
	/**
	 * Nombre del campo de base de datos
	 * @var string
	 */
	protected $dataField;
	
	/**
	 * Setea el nombre del campo de la base de datos
	 * @param string $dataField
	 */
	function setDataField($dataField){
		$this->dataField=$dataField;
	}
	
	/**
	 * Obtiene el valor del nombre del campo asignado en la base de datos
	 * @return string
	 */
	function getDataField(){
		return $this->dataField;
	}
	
	/**
	 * Nombre del contorl
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Texto que aparecera cuando no hayan datos en el control
	 * @var string
	 */
	protected $placeholder="";
	
	/**
	 * Texto que aparecerá en el boton de buscar
	 * @var string
	 */
	protected $caption="";
	
	/**
	 * Nombre del icono a cargar
	 * @var string
	 */
	protected $icon="";
	
	/**
	 * Clase a asignar al div modal
	 * @var string
	 */
	protected $modalClass="";
	
	/**
	 * Colección de elementos a mostrar
	 * @var array
	 */
	protected $listElements=array();
	
	/**
	 * Nombre de la funcion cache a guardar
	 * @var string
	 */
	protected $callbackFunction="";
	
	/**
	 * Coleccion de filtros que apareceran en la ventana cuando se llame
	 * @var array
	 */
	protected $filters=array();
	
	/**
	 * Cabeceras de la tabla de resultado
	 * @var string
	 */
	protected $headers="";
	
	/**
	 * Controla si el objeto tiene un llamado a la base de datos
	 * @var boolean
	 */
	protected $hasDataBaseCall=false;
	
	/**
	 * Coleccion de parametros para el llamado a la base de datos
	 * @var array
	 */
	protected $dataBaseCallData=array();
	
	/**
	 * Nombre del campo llave que devolvera el control cuando el usuario seleccione el valor
	 * @var string
	 */
	protected $keyField="";
	
	/**
	 * Nombre del campo que mostrará el control al momento que el usuario seleccione el valor
	 * @var string
	 */
	protected $descriptionField="";
	
	/**
	 * Codigo a guardar en la funcion cache para que sea ejecutado mediante AJAX
	 * @var string
	 */
	protected $cacheFunction="";
	
	/**
	 * Control del tiempo que transcurrira entre el evento keypress y la ejecución AJAX para buscar
	 * los valores
	 * @var number
	 */
	protected $timeOut=500;
	
	/**
	 * Setea el tiempo a transcurrir desde que se presione una tecla en los filtros
	 * hasta que se actualicen los resultados a mostrar
	 * @param number $time Tiempo en milisegundos, por defecto esta en 500
	 */
	public function setTimeout($time){
		$this->timeOut=$time;
	}
	
	/**
	 * Devuelve el numero de milisegundos que transcurriran desde que se presione una tecla en los filtros
	 * hasta que se actualicen los resultados a mostrar. Por defecto esta en 500
	 * @return number
	 */
	public function getTimeout(){
		return $this->timeOut;
	}
	
	/**
	 * Setea el nombre del objeto que se pasará como parámetro al momento de enviar datos de un
	 * formulario
	 * @param string $name
	 */
	public function setName($name){
		$this->name=$name;
	}
	
	/**
	 * Devuelve el nombre del objeto que se pasará como parámetro al momento de enviar datos de un
	 * formulario
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Setea el valor que aparecerá en el campo cuando no hayan datos
	 * @param string $placeholder
	 */
	public function setPlaceholder($placeholder){
		$this->placeholder=$placeholder;
	}
	
	/**
	 * Devuelve el valor que aparecerá en el campo cuando no hayan datos
	 * @return string
	 */
	public function getPlaceholder(){
		return $this->placeholder;
	}
	
	/**
	 * Setea el texto que aparecerá en el boton que levantará la ventana popup
	 * @param string $caption
	 */
	public function setCaption($caption){
		$this->caption=$caption;
	}
	
	/**
	 * Devuelve el texto que aparecerá en el boton que levantará la ventana popup
	 * @return string
	 */
	public function getCaption(){
		return $this->caption;
	}
	
	/**
	 * Setea el icono que aparecerá en el boton que levantará la ventana popup
	 * @param string $icon
	 */
	public function setIcon($icon){
		$this->icon=$icon;
	}
	
	/**
	 * Devuelve el icono que aparecerá en el boton que levantará la ventana popup
	 * @return string
	 */
	public function getIcon(){
		return $this->icon;
	}
	/**
	 * Setea la clase a asignar al div tipo modal que genera el objeto
	 * @param string $class
	 */
	public function setModalClass($class){
		$this->modalClass=$class;
	}
	
	/**
	 * Obtiene la clase del div tipo modal que genera el objeto
	 * @return string
	 */
	public function getModalClass(){
		return $this->modalClass;
	}
	
	/**
	 * Agrega un elemento a la lista de posibles seleccionables
	 * @param string $value
	 * @param string $text
	 */
	public function addListElement($value, $text){
		$this->listElements[]=array($value,$text);
	}
	
	/**
	 * Agrega una cabecera a la tabla de resultado
	 * @param unknown_type $header Cabeceras separados por comas
	 * @example $obj->setHeaders("Header 1","Header 2",...);
	 */
	public function setHeaders($headers){
		$this->headers=$headers;
	}
	
	public function __construct($args=array()){
		$this->assingVars($args);
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}else{
			$this->name=$args["name"];
		}
		
		if(isset($args["caption"])){
			$this->caption=$args["caption"];
		}
		
		if(isset($args["placeholder"])){
			$this->placeholder=$args["placeholder"];
		}
		
		if(isset($args["icon"])){
			$this->icon=$args["icon"];
		}
		
		$this->callbackFunction=$this->id."CallBack";
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
		}
	}
	
	/**
	 * Registra la funcion principal de javascript que devuelve el valor y texto al input
	 */
	private function renderJSFunction(){
		$js="function {$this->id}_SELECTOR_THEFUNCTION_(value,text){";
		$js.="$('#{$this->id}_SELECTOR_THEMODAL_').modal('hide');";
		$js.="$('#{$this->id}_SELECTOR').val(value);";
		$js.="$('#{$this->id}').html(text);";
		$js.="}";
		
		page::addJavaScript($js);
		
		/*Si el control tiene un llamado a la base de datos, este se disparará por primera vez
		 * hasta que se muestre el div tipo modal
		 */
		if($this->hasDataBaseCall){
			$js="$('#{$this->id}_SELECTOR_THEMODAL_').on('shown',function(){";
			$js.="$.ajax({";
			$js.="async:false,";
			$js.="url:'?cacheFunction=".$this->callbackFunction."&{$this->id}_FILTERS=',";
			$js.="dataType:'text',";
			$js.="success:function(data){eval(data);},";
			$js.="error:function(a,b,c){alert(c);}";
			$js.="});";
			$js.="});";
			
			/*Limpia el div tipo modal después de esconderse*/
			$js.="$('#{$this->id}_SELECTOR_THEMODAL_').on('hide',function(){";
			$js.="$('[filter-id=\"{$this->id}_SELECTOR_FILTERS\"]').val('');";
			$js.="$('#{$this->id}_THEGRIDCONTAINER_').html('');";
			$js.="clearTimeout({$this->id}timeOut);";
			$js.="});";
			
			page::addJavaScript($js);
		}
		
		/*Variable que controlara el disparo de la funcion de búsqueda
		 * para que no se dispare con cada evento keypress, sino que despues de un tiempo.
		 * Esto sirve por si la busqueda se hace con por ejemplo una pistola lectora de codigos
		 * de barra, o si el usuario escribe una descripción completa
		 */
		$js="var {$this->id}timeOut;";
		page::addJavaScript($js);
		
		if(!empty($this->filters)){
			$js="$('[filter-id=\"{$this->id}_SELECTOR_FILTERS\"]').keyup(function(e){";
			$js.="filters='';";
			$js.="$('[filter-id=\"{$this->id}_SELECTOR_FILTERS\"]').each(function(){";
			$js.="filters+=$(this).attr('filter-index')+':'+$(this).val()+'|';";
			$js.="});";
			$js.="clearTimeout({$this->id}timeOut);";
			$js.="{$this->id}timeOut=setTimeout(function(){";
			$js.="$.ajax({";
			$js.="url:'?cacheFunction=".$this->callbackFunction."&{$this->id}_FILTERS='+filters,";
			$js.="dataType:'text',";
			$js.="success:function(data){eval(data);}";
			$js.="});";
			$js.="},{$this->timeOut});";
			$js.="});";
				
			page::addJavaScriptOnLoad($js);
		}
	}
	
	/**
	 * Agrega un filtro al lookup que aparecera en la parte superior de la ventana modal
	 * @param string $type Tipo de dato del filtro
	 * @param string $caption Valor que aparecera en el filtro como titulo
	 * @param string $fieldName Nombre del campo de la tabla en la que busca el lookup
	 */
	public function addFilter($type,$caption,$fieldName){
		$this->filters[]=array("type"=>$type,"caption"=>$caption,"fieldName"=>$fieldName);
		$this->cacheFunction.="\$ob->addFilter(\"$type\",\"$caption\",\"$fieldName\");";
	}
	
	/**
	 * Setea el control para que busque la información en una base de datos
	 * @param string $table Tabla en la base de datos
	 * @param string $fields Campos a retornar
	 * @param string $keyField Nombre del campo que tendra el link de retorno y que retornará el valor
	 * @param string $conditions Condiciones del query
	 * @param string $order Orden del query
	 */
	public function getFromDataBase($table,$fields,$keyField,$descriptionField,$conditions="",$order=""){
		$registry=registry::getInstance();
		
		if($registry->args[$this->id."_FILTERS"]){
			$conditions=$registry->args[$this->id."_FILTERS"];
		}
		
		$this->dataBaseCallData=array("table"=>$table,
									  "fields"=>$fields,
									  "conditions"=>$conditions,
									  "order"=>$order);
		$this->hasDataBaseCall=true;
		$this->keyField=$keyField;
		$this->descriptionField=$descriptionField;
	}
	
	/**
	 * Guarda una funcion en la variable de sesion que se ejecutará cuando se haga un
	 * callback con Ajax para usar los filtros
	 */
	public function saveCacheFunction(){
		$registry=registry::getInstance();
		
		$filters=$registry->args[$this->id."Filters"];
		$f="";
		$f="\$ob=new lookup(array(\"id\"=>\"{$this->id}\"));";
		$f.="\$ob->setHeaders(\"{$this->headers}\");";
		$f.=$this->cacheFunction;
		$f.="\$ob->getFromDataBase(\"{$this->dataBaseCallData["table"]}\",";
		$f.="							\"{$this->dataBaseCallData["fields"]}\",";
		$f.="							\"{$this->keyField}\",";
		$f.="							\"{$this->descriptionField}\",";
		$f.="							\"{$filters}\",";
		$f.="							\"{$this->dataBaseCallData["order"]}\");";
		$f.="\$ob->render();";
		
		cacheFunction::saveCacheFunction($this->callbackFunction, $f);
	}
	
	/**
	 * Busca los filtros declarados en el control, registra la funcion javascript
	 * y devuelve el código HTML de los input
	 * @return string
	 */
	private function getFilters(){
		$filters="";
		$formats=array();
		if(!empty($this->filters)){
			$filters.="<form class='form-inline' id='{$this->id}_THEFILTERFORM_'>";
			$counter=0;
			foreach($this->filters as $filter){
				//$modal.="<div class='row-fluid'>";
				$filters.="<input type='text'
				class='input-small'
				id='{$this->id}_SELECTOR_FILTER_{$counter}'
				name='{$this->id}_SELECTOR_FILTER_{$counter}'
						filter-id='{$this->id}_SELECTOR_FILTERS'
						filter-index='$counter'
						placeholder='{$filter["caption"]}'> ";
				
				if($filter["type"]!==""){
					$formats[]=array($filter["type"],"{$this->id}_SELECTOR_FILTER_{$counter}");
				}
				
				$counter++;
			}
			
			/*
			if(!empty($formats)){
				page::prepareFormats($formats);
			}
			*/
			
			
			
			//$filters.="<button class='btn' type='button'><i class='icon-search'></i></button>";
			$filters.="</form>";
		}
		
		return $filters;
	}
	
	/**
	 * Valida los tipos de datos que se ingresan en el los filtros
	 * @param string $field
	 * @param string $value
	 * @return string
	 */
	function checkTypeForFilter($field, $value){
		if (get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}
		
		$type=$this->filters[$field]["type"];
		
		
		switch ($type){
			case "date":
	
				$value=date_ymd($value);
				$return=" = '$value'";
	
				break;
			case "number":
				$return="= $value";
				break;
			case "progressbar":
				$pje=$value/100;
				return "= $pje";
				break;
				case "string":
				default:
				$return="LIKE ".db::checkRealEscapeString($value,true);
				break;
		}
	
		return $return;
	}
	
	/**
	 * Renderiza el objeto
	 * @param boolean $return Si se setea true, en lugar de imprimir pantalla devolverá el código
	 * HTML que cree.
	 */
	public function render($return=false){
		$icon=($this->icon==""?
								(velkan::$config["lookup"]["defaultIcon"]==""?
											"":
											"<i class='".velkan::$config["lookup"]["defaultIcon"]."'></i>")
							:"<i class='".$this->icon."'></i>");
		
		$modalClass=($this->modalClass==""?
								(velkan::$config["lookup"]["modalClass"]==""?
											"":
											velkan::$config["lookup"]["modalClass"])
							:$this->modalClass);
		
		/*Codigo HTML para renderizar el input y el boton añadido al mismo
		 * Para pasar el valor y no el texto se utiliza un campo oculto*/
		$render="<div class='".velkan::$config["lookup"]["containerDivClass"]."'>";
		$render.="<span id='{$this->id}' placeholder='{$this->placeholder}' class='uneditable-input'></span>";
		$render.="<button class='".velkan::$config["lookup"]["buttonClass"]."' type='button' id='{$this->id}_THEBUTTON_' data-toggle='modal' data-target='#{$this->id}_SELECTOR_THEMODAL_'>$icon{$this->caption}</button>";
		$render.="</div>";
		$render.="<input type='hidden' 'name='{$this->name}' id='{$this->id}_SELECTOR'>";
		
		/*Codigo HTML para el modal*/
		$modal="<div class=\"$modalClass\" id=\"{$this->id}_SELECTOR_THEMODAL_\">";
  		$modal.="<div class=\"modal-header\">";
		$modal.="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>";
		$modal.="<h3>{$this->title}</h3>";
		$modal.="</div>";
		$modal.="<div class=\"modal-body\" id='{$this->id}_SELECTOR_THEMODALBODY_'>";
		
		$modal.=$this->getFilters();
		
		$in="";
		
		//Creamos la tabla que mostrará los datos
		$table="<table class='table table-striped' id='{$this->id}_SELECTOR_THEGRID_'><thead><tr>";
		$headers=explode(",",$this->headers);
		
		foreach($headers as $header){
			$table.="<th>$header</th>";
		}
		$table.="</tr></thead><tbody>";
		
		if(!empty($this->listElements)&&!$this->hasDataBaseCall){
			foreach($this->listElements as $value){
				$table.="<tr><td><button type='link' class='btn-link' onclick=\"javascript:{$this->id}_SELECTOR_THEFUNCTION_('{$value[0]}','{$value[1]}');\">{$value[1]}</button></td></tr>";
			}
			$table.="</tbody></table>";
		}else{
			if($this->hasDataBaseCall){
				if(velkan::isAjaxCall()){
					db::getAdapter();
					db::connect();
					
					$fields=explode(",",$this->dataBaseCallData["fields"]);
					$counter=0;
					/*El siguiente foreach es para comparar los campos que voy a llamar a la BD
					 * contra los que se declararon como llave y descripción para devolver un valor
					 * al input que aparece en pantalla
					 */
					foreach($fields as $field){
						if($field==$this->keyField){
							$keyField=$counter;
						}
						if($field==$this->descriptionField){
							$descriptionField=$counter;
						}
						$counter++;
					}
					
					$filtersStr="";
					$filterArray=array();
					if($this->dataBaseCallData["conditions"]!=""){
						$filters=explode("|",$this->dataBaseCallData["conditions"]);
						foreach($filters as $filt){
							$filterArray[]=explode(":",$filt);
						}
						
						if(!empty($filterArray)){
							foreach($filterArray as $filt){
								if($filt[1]!=""){
									if($filtersStr==""){
										$filtersStr=$fields[$filt[0]]." ".$this->checkTypeForFilter($filt[0], $filt[1]);
									}else{
										$filtersStr.=" AND ".$fields[$filt[0]]." ".$this->checkTypeForFilter($filt[0], $filt[1]);
									}
								}
							}
						}
					}
					
					if(db::getFields($this->dataBaseCallData["table"],$this->dataBaseCallData["fields"],$filtersStr,$this->dataBaseCallData["order"],'0, 15',false,true)&&db::getNumRows()>0){
						while($arr=db::fetch(db::$FETCH_TYPE_BOTH)){
							$table.="<tr>";
							for($i=0;$i<count($arr);$i++){
								if(!empty($arr[$i])){
									//if(isset($keyField)&&$keyField==$i){
										$table.="<td><button type='link' class='btn-link' onclick=\"javascript:{$this->id}_SELECTOR_THEFUNCTION_('{$arr[$this->keyField]}','{$arr[$this->descriptionField]}');\">{$arr[$i]}</button></td>";
									//}else{
									//	$table.="<td>{$arr[$i]}</td>";
									//}
								}
							}
							$table.="</tr>";
						}
						
						$table.="</tbody></table>";
					}else{
						$table="<div class='alert alert-error'>".velkan::$lang["lookup"]["noDataFound"]."</div>";
					}
				}else{
					$table.="</tbody></table>";
				}
			}
		}
		
		$modal.="<div id='{$this->id}_THEGRIDCONTAINER_'>$table</div>";
		
		$modal.="</div>";
		$modal.="<div class=\"modal-footer\">";
		$modal.="<a href=\"javascript:void(0);\" class=\"btn\" data-dismiss=\"modal\">".velkan::$lang["lookup"]["closeButton"]."</a>";
		$modal.="</div>";
		$modal.="</div>";
		
		$render.=$modal;
		
		if(!velkan::isAjaxCall()){
			$this->renderJSFunction();
			$this->saveCacheFunction();
		}
		
		if($return){
			return $render;
		}else{
			if(velkan::isAjaxCall()){
				$table=str_replace("'", "\'", $table);
				$js="$('#{$this->id}_THEGRIDCONTAINER_').html('$table');";
				echo $js;
			}else{
				echo $render;
			}
		}
	}
}