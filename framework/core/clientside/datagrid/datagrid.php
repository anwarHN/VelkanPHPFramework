<?php
include_once SITE_PATH."/framework/core/clientside/datagrid/pager.php";

/**
 * Velkan PHP Framework
 * Control Datagrid
 *
 * Sirve para renderizar tablas con paginacion, reordenamiento, busqueda y para crear grids dinámicas para inserción, modificación o elmininación de datos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class datagrid extends globalAttr{
	/**
	 * Controla si el grid permitira agregar registros
	 * @var bool
	 */
	protected $canAddNew=false;
	
	/**
	 * Controla si el grid permitira actualizaciones a los registros
	 * @var bool
	 */
	protected $canUpdate=false;
	
	/**
	 * Controla si el grid permitira eliminar registros
	 * @var bool
	 */
	protected $canDelete=false;
	
	/**
	 * Controla si el grid permitira reordenar los registros
	 * @var bool
	 */
	protected $headerSortable=true;
	
	/**
	 * Controla si el grid permitira hacer filtros
	 * @var bool
	 */
	protected $headerFilterable=false;
	
	/**
	 * Controla si la fila de filtros se debe mostrar o no
	 * @var bool
	 */
	protected $ShowFilters=false;
	
	/**
	 * Controla si el grid permitira cambiar el tamaño de las columnas
	 * @var bool
	 */
	protected $headerResizable=false;
	
	/**
	 * Accede a la coleccion de objetos que se manejen durante la ejecucion
	 * @var registry
	 */
	protected $_registry;
	
	/**
	 * Clase de la tabla que tendrá los datos
	 * @var string
	 */
	protected $tableClass="";
	
	/**
	 * Clase del div que contiene toda la tabla y todos los controles
	 * @var string
	 */
	protected $containerClass="";
	
	/**
	 * Clase del grid que contiene la tabla con los datos
	 * @var string
	 */
	protected $tableContainerClass="";
	
	/**
	 * Arreglo de las cabeceras de la tabla
	 * @var array
	 */
	protected $headers=array();
	
	/**
	 * Tabla de la base de datos donde buscará la información 
	 * @var string
	 */
	protected $table="";
	
	/**
	 * Arreglo de los campos que buscara en la tabla
	 * @var array
	 */
	protected $fields=array();
		
	/**
	 * Control del límite de registros a extraer
	 * @var string
	 */
	protected $limit="";
	
	/**
	 * Define los tipos de variables para los campos
	 * @var array
	 */
	protected $types=array();
	
	/**
	 * Arreglo de los tipos añadidos como progressbar y link
	 * @var array
	 */
	protected $bindedTypes=array();
	
	/**
	 * Define los parametros para cada filtro en caso de que sea necesario
	 * @var array
	 */
	protected $bindedTypesParams=array();
	
	/**
	 * Arreglo de los datos que se obtengan desde la tabla
	 * @var array
	 */
	protected $data=array();
	
	/**
	 * Control de los filtros que se reciban como parámetro
	 * @var string
	 */
	protected $filters=array();
	
	/**
	 * Mantiene el valor original recibido por parámetro de los filtros
	 * @var string
	 */
	protected $filtersStr="";
	
	/**
	 * Query de los filtros en formato SQL
	 * @var string
	 */
	protected $filtersQuery="";
	
	/**
	 * Control del orden que se reciba como parámetro
	 * @var string
	 */
	protected $order;
	
	/**
	 * Datos del ordenamiento para SQL
	 * @var string
	 */
	protected $orderQuery="";
	
	/**
	 * Control de la página que se está consultando
	 * @var int
	 */
	protected $currPage=1;
	
	/**
	 * Numero de páginas que resultan del número de registros que se obtengan de la tabla
	 * @var int
	 */
	protected $pages=1;
	
	/**
	 * Control del maximo numero de filas por página que se mostrarán en el grid
	 * @var int
	 */
	protected $maxRowsPerPage;
	
	/**
	 * Control del máximo numero de botones que se mostrarán en el paginador
	 * @var int
	 */
	protected $maxNumPages;
	
	/**
	 * Máximo número de filas obtenidas en el query
	 * @var int
	 */
	protected $maxRows;
	
	/**
	 * Define si el control renderizará un llamado ajax
	 * @var unknown_type
	 */
	protected $iAmAjax=false;
	
	/**
	 * Define si la llamada actual es por Ajax o una llamada normal
	 * @var unknown_type
	 */
	protected $isAjaxCall=false;
	
	/**
	 * Define la funcion del modelo que será llamado desde Ajax
	 * @var unknown_type
	 */
	protected $modelFunction;
	
	/**
	 * Controla si el grid tiene un llamado a la base de datos
	 * @var boolean
	 */
	protected $hasCallToDataBase=false;
	
	/**
	 * Controla el número de filas que tiene cargado el grid
	 * @var int
	 */
	protected $rows=0;
	
	/**
	 * Controla el numero de filas que tendrá el grid
	 * @var int
	 */
	protected $cols=0;
	
	/**
	 * Define que columna se esconderá
	 * @var array
	 */
	protected $hiddenCols=array();
	
	/**
	 * Columnas adicionales al set de datos original, se adicionan al final
	 * @var array
	 */
	protected $appendedCols=array();
	
	/**
	 * Columnas adicionales al set de datos original, se adicionan al principio
	 * @var array
	 */
	protected $prependedCols=array();
	
	/**
	 * Controla si el grid puede o no registrar un script para la paginación, filtrado y reordenamiento
	 * @var boolean Por defecto esta en true
	 */
	protected $canRegisterJSFunction=true;
	
	/**
	 * Controla si el grid mostrará o no el pie donde estan las opciones de mostrar los filtros y demás
	 * @var boolean Por defecto esta en true
	 */
	protected $allowShowFooter=true;
	
	/**
	 * Controla si el grid renderizará una tabla con un tbody vacio
	 * @var boolean
	 */
	protected $renderEmptyBody=false;
	
	/**
	 * Si el usuario quiere agregar un código HTML específico en la cabecera a travez de la funcion setHeaderTemplate(), 
	 * esta variable almacenará dicho código
	 * @var string
	 */
	protected $titleTemplate="";
	
	static $DATA_GRID_COLUMN_TYPE_ACTION=1;
	static $DATA_GRID_COLUMN_TYPE_IMAGE=2;
	
	/**
	 * Añade una columna de botones al final del grid
	 * @param string $header Cabecera de la columna
	 * @param array $actions Arreglo de acciones a ejecutar. Cada elemento del arreglo debe ser la clase del boton, el texto a mostrar, y la accion a ejecutar. Se pueden utilizar los valores de cada columna. Sólo se especifica el id de cada columna encerrado en simbolos numeral (#)
	 * @example $grig->appendActionCol("Acciones",array("btn-link,Modificar,controller/update&id=#col_id#","link,Eliminar,controller/delete&id=#col_id#"));
	 */
	public function appendActionCol($header,array $actions){
		$this->appendedCols[]=array("header"=>$header,"type"=>self::$DATA_GRID_COLUMN_TYPE_ACTION,"value"=>$actions);
	}
	
	/**
	 * Añade una columna de botones al principio del grid
	 * @param string $header Cabecera de la columna
	 * @param array $actions Arreglo de acciones a ejecutar. Cada elemento del arreglo debe ser la clase del boton, el texto a mostrar, y la accion a ejecutar. Se pueden utilizar los valores de cada columna. Sólo se especifica el id de cada columna encerrado en simbolos numeral (#)
	 * @example $grig->appendActionCol("Acciones",array("btn-link,Modificar,controller/update&id=#col_id#","link,Eliminar,controller/delete&id=#col_id#"));
	 */
	public function prependActionCol($header,array $actions){
		$this->prependedCols[]=array("header"=>$header,"type"=>self::$DATA_GRID_COLUMN_TYPE_ACTION,"value"=>$actions);
	}
	
	private function renderAditionalCols(){
		
		foreach($this->appendedCols as &$col){
			switch ($col["type"]){
				case self::$DATA_GRID_COLUMN_TYPE_ACTION:
					$col["html"]="<";
					break;
			}
		}
	}
	
	/**
	 * Setea código HTML personalizado para mostrar en el título del grid
	 * @param string $html Código HTML a mostrar
	 */
	public function setTitleTemplate($html){
		$this->titleTemplate=$html;
	}
	
	/**
	 * Determina si registrará o no las funciones necesarias de JavaScript. No debe utilizarse, a menos que sea
	 * desde un control que sólamente necesite HTML
	 * @param boolean $value True registrará el script, false no lo hará
	 */
	public function setRegisterJSFunction($value){
		$this->canRegisterJSFunction=$value;
	}
	
	/**
	 * Setea el numero de filas del grid
	 * @param int $rows
	 */
	public function setRows($rows){
		$this->rows=$rows;
	}
	
	/**
	 * Obtiene el numero de filas del grid. La propiedad rows aumenta con cada llamado de addRow() en el objeto
	 * @param number $rows
	 * @return number
	 */
	public function getRows($rows){
		return $this->rows;
	}
	
	/**
	 * Setea el número de columnas que tendrá el grid
	 * @param number $cols
	 */
	public function setCols($cols){
		$this->cols=$cols;
	}
	
	
	/**
	 * Devuelve el número de columnas del grid
	 * @return number
	 */
	public function getCols(){
		return $this->cols;
	}
	
	/**
	 * Setea las columnas a esconder
	 * @param string $cols Nombres de las columnas separado por comas
	 */
	public function setHiddenCols($cols){
		$this->hiddenCols=explode(",",$cols);
	}
	
	/**
	 * Agrega una linea al grid
	 * @param array $row Arreglo de valores.
	 */
	public function addRow(array $row){
		$prependedCols=array();
		$html="";
		if(!empty($this->prependedCols)){
			foreach($this->prependedCols as $col){
				$html.=$this->renderAdditionalCol($col,$row);;
			}
			$prependedCols["prependedCol".$col["header"]]=$html;
			$row=array_merge($prependedCols,$row);
		}
		
		$appendedCols=array();
		$html="";
		if(!empty($this->appendedCols)){
			foreach($this->appendedCols as $col){
				$html.=$this->renderAdditionalCol($col,$row);
			}
			$appendedCols["appendedCol".$col["header"].$counter]=$html;
			$row=array_merge($row,$appendedCols);
		}
		
		$this->rows+=1; 		
		$this->data[]=$row;
	}
	
	private function renderAdditionalCol($col,$data){
		$html="";
		
		switch ($col["type"]) {
			case self::$DATA_GRID_COLUMN_TYPE_ACTION:
				foreach($col["value"] as $actions){
					$action=$actions;
					$html.="<button type=\"button\" class=\"btn {$action["class"]}\" onclick=\"javascript:{$action["javascript"]}\">{$action["caption"]}</button>";
					
					foreach($data as $key=>$value){
						$html=str_replace("#$key#", $value, $html);
					}
				}
				break;
					
			default:
				$html="";
				break;
		}
		
		return $html;
	}
	
	function __construct(array $args){
		$this->assingVars($args);
		
		if(!isset($args["tableClass"])){
			$this->tableClass=velkan::$config["datagrid"]["tableClass"];
		}
		if(!isset($args["containerClass"])){
			$this->containerClass=velkan::$config["datagrid"]["containerClass"];
		}
		
		if(!isset($args["maxRowsPerPage"])){
			$this->maxRowsPerPage=velkan::$config["datagrid"]["maxRowsPerPage"];
		}else{
			$this->maxRowsPerPage=$args["maxRowsPerPage"];
		}
		
		if(!isset($args["maxNumPages"])){
			$this->maxNumPages=velkan::$config["datagrid"]["maxNumPages"];
		}else{
			$this->maxNumPages=$args["maxNumPages"];
		}
		
		$this->_registry=registry::getInstance();
		
		$this->isAjaxCall=velkan::isAjaxCall();
		
		if(isset($this->_registry->args["showFilters"])&&$this->_registry->args["showFilters"]=="true"){
			$this->ShowFilters=true;
		}
		
		$this->modelFunction=$this->id."DataGridCallBack";
		
		if(isset($args["renderEmptyBody"])){
			$this->renderEmptyBody=$args["renderEmptyBody"];
		}
	}
	
	/**
	 * Define si el grid podrá agregar nuevos registros
	 * @param bool $allow
	 */
	function allowAddNew($allow){
		$this->canAddNew=$allow;
	}
	
	/**
	 * Define si se podran editar los registros mostrados
	 * @param bool $allow
	 */
	function allowUpdate($allow){
		$this->canUpdate=$allow;
	}
	
	/**
	 * Define si se podran eliminar los registros
	 * @param bool $allow
	 */
	function allowDelete($allow){
		$this->canDelete=$allow;
	}
	
	/**
	 * Permite que el grid pueda ser renderizado con llamadas Ajax
	 * @param bool $allow
	 */
	function allowAjaxCall($allow){
		$this->iAmAjax=$allow;
	}
	
	/**
	 * Define si el grid permitirá hacer filtros a los datos
	 * @param bool $allow
	 */
	function allowFilters($allow){
		$this->headerFilterable=$allow;
	}
	
	/**
	 * Define si el grid podra redimensionar sus columnas
	 * @param unknown_type $allow
	 */
	function allowResize($allow){
		$this->headerResizable=$allow;
	}
	
	/**
	 * Define si las cabeceras de la tabla van a poder reordenar los datos. Por defecto es true
	 */
	function allowColumnReorder($val){
		$this->headerSortable=$val;
	}
	
	/**
	 * Muestra o esconde el pie del grid
	 * @param boolean $value
	 */
	function showFooter($value){
		$this->allowShowFooter=$value;
	}
	
	function showFilters($value){
		$this->ShowFilters=$value;
	}
	
	/**
	 * Define los tipos de datos de las columnas segun la estructura de la base de datos
	 * Lo aceptado es number, string, date, time y date_time
	 * Se deben definir separados por coma y en el orden que se describan los campos
	 * 
	 * @param string $types
	 */
	function setTypes($types){
		$this->types=explode(",",$types);
	}
	
	/**
	 * Agrega parametros al tipo de la columna
	 * 
	 * @param string $dataField Nombre del campo del grid
	 * @param string $type Tipo de dato de la columna
	 * @param string $param Parametros a pasar al tipo de dato. * 
	 * Los tipos aceptados a los que se les puede agregar parámetros son:*
	 * link: Se le asigna la URL, aqui se pasa el parámetro al objeto para que sustituya los valores de los campos
	 * 
	 * @example $this->dataGrid->bindFieldTypeParameter("id", "link", "?c=admin/dhdh&other=#fecha#&other2=#porcentaje#"), donde #fecha# y #porcentaje# son campos declarados con setFields()
	 */
	function bindFieldTypeParameter($dataField,$type,$param){
		$key=array_search($dataField,$this->fields);
		
		if(!is_null($key)){
			$this->bindedTypes[$dataField]=$type;
			$this->bindedTypesParams[$dataField]=$param;
		}
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
		
		$type=$this->types[$field];
		
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
	 * Define el número de filas por página a mostrar en el grid
	 * @param int $rows
	 */
	function setMaxRowsPerPage($rows){
		$this->maxRowsPerPage=$rows;
	}
	
	/**
	 * Define cuantos botones se mostraran dependiendo el número de páginas que haya que crear por el query
	 * @param int $numPages
	 */
	function setMaxNumPages($numPages){
		$this->maxNumPages=$numPages;
	}
	
	/**
	 * Asigna los id de los campos de las tablas, servirá para identificar las columnas
	 * @param string $fields Nombres de los campos separados por coma
	 */
	function setFields($fields){
		$this->fields=explode(",",$fields);
		foreach($this->fields as &$field){
			$field=trim($field);
		}
	}
	
	/**
	 * Asigna los textos que apareceran en la cabecera de la tabla
	 * @param string $names Nombres de las cabeceras separadas por coma
	 */
	function setHeadersNames($names){
		$this->headers=explode(",",$names);
		foreach($this->headers as &$header){
			$header=trim($header);
		}
	}
	
	/**
	 * Registra la funcion JavaScript que se ejecutará en el cliente
	 */
	private function registerJsFunction(){
		$method=$this->modelFunction;
		
		$theTimeController="{$this->id}_THETIMECONTROLLER_";
		
		$theMasterFunction="{$this->id}_THETIMEDFUNCTION_";
		
		page::addJavaScript("var $theTimeController;");
		
		$invalidDoublePoint=velkan::$lang["grid_msg"]["invalidSeparatorCaracterMsj"];
		
		//Definimos la funcion que hará el llamado a la base de datos
		$masterFunction="function $theMasterFunction(){";
		
		//Si el llamado a la base de datos no lo hacemos por ajax, el grid necesita saber en que orden y que página esta mostrando los datos
		/*if(!$this->iAmAjax){
			$masterFunction.="$('#grid{$this->id}Page').val('{$this->currPage}');";
			$masterFunction.="$('#grid{$this->id}Order').val('{$this->order}');";
		}*/
		
		$masterFunction.="page=$('#grid{$this->id}Page').val();";
		$masterFunction.="order=$('#grid{$this->id}Order').val();";
		$masterFunction.="showFilters=$('#grid{$this->id}ShowFilters').val();";
		
		$masterFunction.="fatalError=false;";
		$masterFunction.="filters='';";
		$masterFunction.="countFilter=0;";
		
		$masterFunction.="$('[name=\"grid{$this->id}Filter[]\"]').each(function(){";
			$masterFunction.="val=$(this).val();";
			
			$masterFunction.="if(val.indexOf('::')>=0){";
				$masterFunction.="$(this).addClass('error')";
					$masterFunction.=".popover({content:\"$invalidDoublePoint\",placement:'bottom'})";
					$masterFunction.=".popover('show');";
				$masterFunction.="fatalError=true;";
			$masterFunction.="}else{";
				$masterFunction.="$(this).removeClass('error')";
					$masterFunction.=".popover('destroy');";
			$masterFunction.="}";
			
			$masterFunction.="if(val!==''){";
				$masterFunction.="if(filters==''){";
					$masterFunction.="filters=countFilter+'::'+val;";
				$masterFunction.="}else{";
					$masterFunction.="filters+='|'+countFilter+'::'+val;";
				$masterFunction.="}";
			$masterFunction.="}";
			$masterFunction.="countFilter++;";
		$masterFunction.="});";
		
		$masterFunction.="if(!fatalError){";
		
		if($this->iAmAjax){
			$masterFunction.='$.ajax({';
				
			$masterFunction.="data:'m=".$this->_registry->controllerName."&a=".$method."&page='+page+'&filter='+filters+'&order='+order";
			$masterFunction.=",dataType:'text'";
			$masterFunction.=",success: function(data){";
				
			$masterFunction.="eval(data);";
			
			$masterFunction.="}";
			$masterFunction.="});";
		}else{
			$argSeries=page::getArgsSeries("page,filter,order,showFilters");
			$masterFunction.="window.location='?c={$this->_registry->controllerName}/{$this->_registry->controllerMethod}&".($argSeries==""?"":$argSeries."&")."page='+page+'&filter='+filters+'&order='+order+'&showFilters='+showFilters;";
		}
		
		$masterFunction.="}";
		$masterFunction.="}";
		
		page::addJavaScript($masterFunction);
		//Fin de la funcion
		
		//Funciones para los filtros
		if($this->headerFilterable){
			$js="function grid{$this->id}ToggleFilters(){\$('#grid{$this->id}Filters').toggle(function(){";
			$js.="if($('#grid{$this->id}Filters').is(':visible')){";
			$js.="$('#grid{$this->id}ShowFilters').val('true');";
			$js.="}else{";
			$js.="$('#grid{$this->id}ShowFilters').val('false');";
			$js.="}";
			$js.="});} ";
			
			page::addJavaScript($js);
			
			$js="$('[name=\"grid{$this->id}Filter[]\"]').each(function(){";
				$js.="$(this).bind('keypress',function(){";
					$js.="if (event.which == 13){";
						$js.="clearTimeout($theTimeController);";
						$js.="$theTimeController=setTimeout($theMasterFunction,1500);";
						//$js.="getGrid{$this->id}(1,$(this).val(),'{$this->order}');";
					$js.="}";
				$js.="});";
				$js.="if($(this).is('[velkandate]')){";
					$js.="id=$(this).attr('container-id'); ";
					$js.="$('#'+id).datetimepicker().on('changeDate',function(dtp){";
						$js.="if(dtp.date.valueOf()!==''){";
							$js.="clearTimeout($theTimeController);";
							$js.="$theMasterFunction();";
						$js.="}";
					$js.="});";
				$js.="}";
			$js.="});";
			
			page::addJavaScriptOnLoad($js);
		}
		
		//Funciones para reordenamiento
		if($this->headerSortable){
			$js="function {$this->id}Reorder(field){";
			$js.="if($('[{$this->id}_field_number=\"'+field+'\"]').hasClass('velkan-grid-column-header-sorted-both')){";
				$js.="$('[{$this->id}_field_number=\"'+field+'\"]').removeClass('velkan-grid-column-header-sorted-both');";
				$js.="$('[{$this->id}_field_number=\"'+field+'\"]').addClass('velkan-grid-column-header-sorted-asc');";
				$js.="$('#grid{$this->id}Order').val(field+ '|asc');";
				$js.="$('[{$this->id}-column-header]:not([{$this->id}_field_number=\"'+field+'\"])').removeClass().addClass('velkan-grid-column-header velkan-grid-column-header-sorted-both');";
			$js.="}else{";
				$js.="if($('[{$this->id}_field_number=\"'+field+'\"]').hasClass('velkan-grid-column-header-sorted-asc')){";
					$js.="$('[{$this->id}_field_number=\"'+field+'\"]').removeClass('velkan-grid-column-header-sorted-asc');";
					$js.="$('[{$this->id}_field_number=\"'+field+'\"]').addClass('velkan-grid-column-header-sorted-desc');";
					$js.="$('#grid{$this->id}Order').val(field+ '|desc');";
					$js.="$('[{$this->id}-column-header]:not([{$this->id}_field_number=\"'+field+'\"])').removeClass().addClass('velkan-grid-column-header velkan-grid-column-header-sorted-both');";
				$js.="}else{";
					$js.="if($('[{$this->id}_field_number=\"'+field+'\"]').hasClass('velkan-grid-column-header-sorted-desc')){";
						$js.="$('[{$this->id}_field_number=\"'+field+'\"]').removeClass('velkan-grid-column-header-sorted-desc');";
						$js.="$('[{$this->id}_field_number=\"'+field+'\"]').addClass('velkan-grid-column-header-sorted-both');";
						$js.="$('#grid{$this->id}Order').val('');";
						$js.="$('[{$this->id}-column-header]:not([{$this->id}_field_number=\"'+field+'\"])').removeClass().addClass('velkan-grid-column-header velkan-grid-column-header-sorted-both');";
					$js.="}";
				$js.="}";
			$js.="}";
			$js.="$('#grid{$this->id}Page').val('1');";
			$js.="$theMasterFunction();";
			$js.="}";
			
			page::addJavaScript($js);
		}
	}
	
	/**
	 * Busca información desde la base de datos
	 * @param string $table
	 * @param string $page
	 * @param string $fields
	 * @param string $names
	 * @param string $filter
	 * @param string $order
	 * @return boolean
	 */
	function getFromDataBase($table,$page=1,$fields="", $names="",$filter="",$order="",$return=false){
		
		$this->hasCallToDataBase=true;
		
		$this->currPage=$page;
		
		$this->table=$table;
		
		if($this->maxNumPages<1){
			$e=new VException("El m&aacute;ximo n&uacute;mero de p&aacute;ginas a mostrar no es v&aacute;lido");
			$e->process();
			return false;
		}
		
		if($this->maxRowsPerPage<1){
			$e=new VException("El m&aacute;ximo n&uacute;mero defilas a mostrar por p&aacute;gina no es v&aacute;lido");
			$e->process();
			return false;
		}
		
		if($page==1){
			$limit="0, {$this->maxRowsPerPage}";
		}else{;
			$limitMax=(int)$this->maxRowsPerPage*($page-1);
			$limitMin=(int)$this->maxRowsPerPage;
			$limit="$limitMax, $limitMin";
		}
		
		$this->limit=$limit;
		
		if(!empty($names)&&!$names==""){
			$this->headers=explode(",",$names);
		}
		if(!empty($fields)&&!$fields==""){
			$this->fields=explode(",",$fields);
		}
		
		$orderStr="";
		if($order!=""){
			$orderArray=explode("|",$order);
			
			$this->orderQuery=$this->fields[$orderArray[0]]." ".$orderArray[1];
			
			$this->order=$order;
		}
		
		$filtersQuery="";
		if($filter!=""){
			$this->filtersStr=$filter;
			$filters=explode("|",$filter);
			foreach($filters as $filt){
				$this->filters[]=explode("::",$filt);
			}
		}
		
		$this->filtersQuery=$filtersQuery;
	}
	
	/**
	 * Obtiene los datos de la base de datos
	 * @return Ambigous <boolean, string>
	 */
	private function getData(){
		db::getAdapter();
		
		$counter=0;
		$arrayFieldQuery=array();
		foreach($this->fields as $field){
			$arrayFieldQuery[$field]=$this->types[$counter];
			$counter++;
		}
		
		$counter=0;
		$arrayFilters=array();
		foreach($this->filters as $filter){
			$arrayFilters[$this->fields[$filter[0]]]=array("type"=>$this->types[$filter[0]],"value"=>$filter[1]);
		}
		
		if(db::getFields($this->table,$arrayFieldQuery,$arrayFilters,$this->orderQuery,$this->limit,true)){
			$this->pages=ceil(((int)db::getCalculatedRows())/((int)$this->maxRowsPerPage));
			$this->maxRows=(int)db::getCalculatedRows();
			while($row=db::fetch(db::$FETCH_TYPE_ASSOC)){
				$this->addRow($row);
			}
		}
	}
	
	/**
	 * Renderiza la cabecera de la tabla
	 * @return string
	 */
	private function getHeaders(){
		$thead="";
		if(!empty($this->headers)){
			$thead="<thead>";
			$thead.="<tr>";
			$headerNumber=0;
			$fieldNumber=0;
			$count=count($this->headers)-1;
			
			//Busca si hay columnas anteriores a agregar
			if(!empty($this->prependedCols)){
				foreach($this->prependedCols as $col){
					$thead.="<th>{$col["header"]}</th>";
					$headerNumber++;
				}
			}
			
			//Busca las columnas declaradas
			foreach($this->headers as $name){
				if($this->headerSortable){
					if($this->order!==""&&!empty($this->order)){
						$order=explode('|',$this->order);
						if(is_array($order)&&$fieldNumber==$order[0]){
							$classSortable="velkan-grid-column-header velkan-grid-column-header-sorted-".$order[1];
						}else{
							$classSortable="velkan-grid-column-header velkan-grid-column-header-sorted-both";
						}
					}else{
						$classSortable="velkan-grid-column-header velkan-grid-column-header-sorted-both";
					}
					
					
					$thead.="<th {$this->id}-column-header class=\"$classSortable\" onclick=\"javascript:{$this->id}Reorder($fieldNumber);\" {$this->id}_field_number=\"$fieldNumber\">$name</th>";
				}else{
					$thead.="<th {$this->id}-column-header>$name</th>";
				}
				$fieldNumber++;
				$headerNumber++;
			}
			
			//Busca si hay columnas posteriores a agregar
			if(!empty($this->appendedCols)){
				foreach($this->appendedCols as  $col){
					$thead.="<th>{$col["header"]}</th>";
					$headerNumber++;
				}
			}
			
			$thead.="</tr>";
			
			//Guardamos el numero total de columnas
			$this->cols=$headerNumber;
			
			
			$tfilter="";
			$type="";
			if($this->headerFilterable){
				$cols=count($this->fields)-1;
				
				for($i=0;$i<=$cols;$i++){
					$meClass=velkan::$config["datagrid"]["filters"]["inputClass"];
					
					$type="";
					if(!empty($this->types)){
						$type=$this->types[$i];
					}
					$value="";
					if(!empty($this->filters)){
						foreach($this->filters  as $filter){
							if($filter[0]==$i){
								$value=$filter[1];
							}
						}
					}
					
					$tfilter.="<th class='velkan-grid-column-filter'>";
					
					switch($type){
						case "date":
							$input=new date_time(array("id"=>"grid{$this->id}Filter","name"=>"grid{$this->id}Filter[]","value"=>$value,"pickerType"=>date_time::$DATETIME_PICKER_TYPE_DATE));
							$tfilter.=$input->render(true);
							break;
						case "datetime":
							$input=new date_time(array("id"=>"grid{$this->id}Filter","name"=>"grid{$this->id}Filter[]","value"=>$value,"pickerType"=>date_time::$DATETIME_PICKER_TYPE_DATETIME));
							$tfilter.=$input->render(true);
							break;
						case "time":
							$input=new date_time(array("id"=>"grid{$this->id}Filter","name"=>"grid{$this->id}Filter[]","value"=>$value,"pickerType"=>date_time::$DATETIME_PICKER_TYPE_TIME));
							$tfilter.=$input->render(true);
							break;
						default:
							$tfilter.="<input type='search' name='grid{$this->id}Filter[]' $type value=\"$value\">";
							break;
					}
					$tfilter.="</th>";
				}
				$display=($this->ShowFilters?"":"style='display:none'");
				
				$filterPrepend="";
				if(!empty($this->prependedCols)){
					foreach($this->prependedCols as $col){
						$filterPrepend.="<th>&nbsp;</th>";
					}
				}
				
				$filterAppend="";
				if(!empty($this->appendedCols)){
					foreach($this->appendedCols as $col){
						$filterAppend.="<th>&nbsp;</th>";
					}
				}
				
				$tfilter="<tr id='grid{$this->id}Filters' $display>{$filterPrepend}{$tfilter}{$filterAppend}</tr>";
			}
			
			if($type!=""){
				$jss=new generalJavaScriptFunction();
				$jss->registerFunction("applyFormats");
			}
			
			$thead.="$tfilter</thead>";
		}
		
		return $thead;
	}
	
	/**
	 * Obtiene las opciones que apareceran en las cabeceras
	 * @param int $headerNumber
	 * @return string
	 */
	private function getHeaderButton($headerNumber){
		if($this->headerSortable){
			$langOrderAsc=velkan::$lang["grid_msg"]["orderAsc"];
			$langOrderDesc=velkan::$lang["grid_msg"]["orderDesc"];
			
			$hd=<<<HTML
			<div class="btn-group pull-right">
	  			<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="javascript:{$this->id}Reorder('{$this->fields[$headerNumber]} asc');"><i class="icon-arrow-up"></i> $langOrderAsc</a></li>
						<li><a href="javascript:{$this->id}Reorder('{$this->fields[$headerNumber]} desc');"><i class="icon-arrow-down"></i> $langOrderDesc</a></li>
					</ul>
			</div>
HTML;
			return $hd;
		}else{
			return "";
		}
	}
	
	/**
	 * Obtiene el cuerpo de la tabla
	 * @return string
	 */
	private function getBody(){
		$tbody="";
		$tfilter="";
		
		if($this->renderEmptyBody){
			return "<tbody></tbody>";
		}
		
		//Si tiene un llamado a la base de datos, obtenemos los datos
		if($this->hasCallToDataBase){
			$this->getData();
		}
		
		if(!empty($this->data)){
			foreach($this->data as $dataRow){
				$tbody.="<tr>";
				$counter=0;
				
				/*Buscamos si el grid tiene alguna columna adicional al principio*/
				if(!empty($this->prependedCols)){
					foreach($this->prependedCols as $col){
						$counter++;
					}
				}
				
				foreach($dataRow as $key=>$data){
					if(!empty($this->bindedTypes)){
						
						$type=$this->bindedTypes[$key];
						$parameter=$this->bindedTypesParams[$key];
						
						switch ($type){
							case 'progressbar':
								$bar=new progressbar(array("id"=>$key));
								$pje=$data*100;
								$bar->setBars(array($pje));
						
								$tbody.="<td>".$bar->render(true)."</td>";
								break;
							case "link":
								$link=new link();
								$link->replaceFields($dataRow, $parameter);
								$link->setDisplay($data);
						
								$tbody.="<td>".$link->render(true)."</td>";
								break;
							default:
								$tbody.="<td>$data</td>";
								break;
						}
					}else{
						$tbody.="<td>$data</td>";
					}
					$counter++;
				}
				
				/*Buscamos si el grid tiene alguna columna adicional al final*/
				if(!empty($this->appendedCols)){
					foreach($this->appendedCols as $col){
						$counter++;
					}
				}
				
				$tbody.="</tr>";
			}
			
			if($tfilter!=""){
				$tbody=$tfilter.$tbody;
			}
			
			$tbody="<tbody>$tbody</tbody>";
		}else{
			$tbody="<tbody><tr><td colspan=\"{$this->cols}\"><div class=\"alert alert-error\">".velkan::$lang["grid_msg"]["noDataFound"]."</div></td></tr></tbody>";
		}
		
		return $tbody;
	}
	
	private function getFooter(){
		
		$tfoot="";
		
		$tfoot.="<div class='footer'>";
		
		$tfoot.="<div class='options'>";
		$tfoot.="<div class='btn-toolbar'>";
		
		$tfoot.="<div class='btn-group'>";
		if($this->headerFilterable){
			$tfoot.="<a class='btn btn-mini' href='javascript:grid{$this->id}ToggleFilters();' title='".velkan::$lang["grid_msg"]["filterTip"]."' id='grid{$this->id}FilterButton' data-placement='right'><i class='icon-filter'></i></a>";
			/*page::addJavaScriptOnLoad("$('#grid{$this->id}FilterButton').tooltip();");*/
		}
		$tfoot.="</div>";
		
		$tfoot.="<div class='btn-group'>";
		if($this->canAddNew){
			$tfoot.="<a class='btn btn-mini' href='javascript:grid{$this->id}AddNew();' title='".velkan::$lang["grid_msg"]["addNewTip"]."' id='grid{$this->id}AddNewButton' data-placement='right'><i class='icon-plus-sign'></i></a>";
			/*page::addJavaScriptOnLoad("$('#grid{$this->id}AddNewButton').tooltip();");
			 * 
			 */
		}
		if($this->canUpdate){
			$tfoot.="<a class='btn btn-mini' href='javascript:grid{$this->id}Update();' title='".velkan::$lang["grid_msg"]["updateTip"]."' id='grid{$this->id}UpdateButton' data-placement='right'><i class='icon-pencil'></i></a>";
			/*page::addJavaScriptOnLoad("$('#grid{$this->id}UpdateButton').tooltip();");*/
		}
		$tfoot.="</div>";
		
		$tfoot.="<div class='btn-group'>";
		$tfoot.="<a class='btn btn-mini' href='javascript:getGrid{$this->id}({$this->currPage},\"\",\"\");' title='".velkan::$lang["grid_msg"]["refreshTip"]."'><i class='icon-refresh'></i></a>";
		$tfoot.="</div>";
		
		$tfoot.="</div>";
		$tfoot.="</div>";
		
		
		$tfoot.="<div class='paginator'>";
		
		$tfoot.=$this->getPagination();
		
		$tfoot.="</div>";
		$tfoot.="<div class='clear'>";
		$tfoot.="</div>";
		$tfoot.="</div>";
		
		return $tfoot;
	}
	
	/**
	 * Obtiene la paginacion de la tabla
	 * @return string
	 */
	private function getPagination(){
		$pager=new pager();
		$pager->isAjaxCall($this->iAmAjax);
		$pager->set("type", "buttons");
		$pager->set("gridId",$this->id);
		$pager->set("pages", $this->pages);
		$pager->set("currPage", $this->currPage);
		$pager->set("maxNumPages", $this->maxNumPages);
		$pager->set("maxNumPages", $this->maxNumPages);
		return $pager->render(true);
	}
	
	/**
	 * Renderiza el grid
	 * @return boolean
	 */
	function render($return=false){
		if($this->maxNumPages<1){
			$e=new VException("El m&aacute;ximo n&uacute;mero de p&aacute;ginas a mostrar no es v&aacute;lido");
			$e->process();
			return false;
		}
		
		if($this->maxRowsPerPage<1){
			$e=new VException("El m&aacute;ximo n&uacute;mero defilas a mostrar por p&aacute;gina no es v&aacute;lido");
			$e->process();
			return false;
		}
		
		if($this->hasCallToDataBase&&count($this->headers)!=count($this->fields)){
			$e=new VException("Los campos y los nombres no coinciden");
			$e->process();
			return false;
		}
		
		if(empty($this->types)){
			$e=new VException("Debe declarar los tipos de las columnas con \$grid->setTypes()");
			$e->process();
			return false;
		}
		
		$thead=$this->getHeaders();
		
		$tbody=$this->getBody();
		
		$table="";
		
		/*Si el llamado no es AJAX, empezamos a generar el código HTML desde el principio*/
		if(!$this->isAjaxCall){
			$render="<div id=\"{$this->id}_grid\" class=\"velkan-grid\">";
			$render.="<input type=\"hidden\" id=\"grid{$this->id}Page\" value=\"{$this->currPage}\">";
			$render.="<input type=\"hidden\" id=\"grid{$this->id}Filter\" value=\"{$this->filtersStr}\">";
			$render.="<input type=\"hidden\" id=\"grid{$this->id}Order\" value=\"{$this->order}\">";
			$render.="<input type=\"hidden\" id=\"grid{$this->id}ShowFilters\" value=\"".($this->ShowFilters?"true":"false")."\">";
			
			if(!$this->title==""&&$this->titleTemplate!==""){
				$render.="<div class=\"title\">{$this->title}</div>";
			}else{
				$render.="<div class=\"title\">{$this->titleTemplate}</div>";
			}
			
			$table="<table class=\"{$this->tableClass}\">$thead$tbody</table>";
		}else{
			$table=$tbody;
		}
		
		$render.=$table;
		
		/*Si el llamado es un AJAX, entonces devolvemos funciones javascript que reemplazaran
		* los codigos HTML actuales del objeto */
		if($this->isAjaxCall){
			$pagination=$this->getPagination();
			$pagination=str_replace("'", "\'", $pagination);
			$js="$('#{$this->id}_pag').replaceWith('$pagination');";
			
			$js.="$('#{$this->id}_grid table:not(.footer) tbody').replaceWith('$render');";
			
			$js.="$('#grid{$this->id}Page').val('{$this->currPage}');";
			$js.="$('#grid{$this->id}Filter').val('{$this->filtersStr}');";
			$js.="$('#grid{$this->id}Order').val('{$this->order}');";
			$js.="$('#grid{$this->id}ShowFilters').val('".($this->ShowFilters?"true":"false")."');";
			
			if($return){
				return $js;
			}else{
				echo $js;
			}
		}else{
			if($this->allowShowFooter){
				$render.=$this->getFooter();
			}
			
			$render.="</div>";
			
			if($this->canRegisterJSFunction){
				page::addJavaScript($this->registerJsFunction());
			}
			
			if(!$return){
				echo $render;
			}else{
				return $render;
			}
		}
	}
}
?>