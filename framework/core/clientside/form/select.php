<?php
/**
 * Velkan PHP Framework
 * Combobox (select) contorl - Coleccion de propiedades para renderizar combobox
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class select extends globalAttr{
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
	 * Tipo de dato que almacenará el objeto
	 * @var string
	 */
	protected $dataType="string";
	
	/**
	 * Retorna el tipo de dato del objeto
	 * @return string
	 */
	function getDataType(){
		return $this->dataType;
	}
	
	/**
	 * Arreglo que almancena los valores del array
	 * @var array
	 */
	protected $values=array();
	
	/**
	 * Control del valor seleccionado del select
	 * @var string
	 */
	protected $selected="";
	
	/**
	 * Nombre del control
	 * @var string
	 */
	protected $name;
	
	protected $_registry;
	
	/**
	 * ID del control del que dependera se dispare una funcion para llenar el select
	 * @var unknown_type
	 */
	protected $dependency;
	
	/**
	 * Funcion del modelo que se ejecutará con un llamado ajax para llenar el select
	 * @var string
	 */
	protected $modelFunction="";
	
	/**
	 * Texto que aparecerá cuando el select este vacío
	 * @var string
	 */
	protected $emptyPromt="";
	
	/**
	 * Texto que aparecerá cuando se necesite un valor vacio antes de todos los demas valores
	 * @var string
	 */
	protected $promt="";
	
	/**
	 * Valor del control
	 * @var string
	 */
	protected $value="";
	
	/**
	 * Nombre de los campos en la base de datos de las dependencias
	 * @var string
	 */
	protected $dependencyDataFieldName="";
	
	/**
	 * Determina si el select fue llenado por la funcion getFromDataBase()
	 * @var bool
	 */
	private $isFilledByDataBase=false;
	
	/**
	 * Determina si el objeto depende de otro para llenar sus datos
	 * @var boolean
	 */
	private $hasDependency=false;
	
	/**
	 * Tabla que se obtiene mediante la funcion getFromDataBase
	 * @var string
	 */
	protected $table="";
	
	/**
	 * Campos a cargar desde la base de datos
	 * @var string
	 */
	protected $fields="";
	
	/**
	 * Filtro para buscar datos en la base de datos
	 * @var string
	 */
	protected $condition="";
	
	/**
	 * Control si el objeto sera de solo lectura
	 * @var bool
	 */
	protected $readonly=false;
	
	/**
	 * Control del texto que aparece en el select
	 * @var string
	 */
	private $text;
	
	/**
	 * Controlara la funcion que se ejecutará automáticamente desde ajax
	 * @var string
	 */
	private $cacheFunction="";
	private $cacheFunctionConstruct="";
	private $dependencyFunction="";
	
	/**
	 * Modelo al que pertenece el objeto
	 * @var model
	 */
	protected $model;
	
	/**
	 * Funcion para recibir el modelo al que pertenece el objeto
	 * @param model $model
	 */
	function sendMeModel($model){
		if(empty($this->model)){
			$this->model=$model;
		}
	}
	
	/**
	 * Setea el objeto a solo lectura
	 * @param bool $value
	 */
	function setReadOnly($value){
		$this->readonly=$value;
	}
	
	/**
	 * Obtiene si el contorl es solo lectura
	 * @return boolean
	 */
	function getReadOnly(){
		return $this->readonly;
	}
	
	/**
	 * Setea la tabla en la que buscará el select
	 * @param string $table
	 */
	function setTable($table){
		$this->table=$table;
		$this->isFilledByDataBase=true;
		$this->cacheFunction.="\$obj->setTable(\"$table\");";
	}
	
	/**
	 * Setea los campos que traera el select
	 * @param string $fields Se deben especificar dos a lo máximo y separados por coma
	 */
	function setFields($fields){
		$this->fields=$fields;
		$proof=explode(",",$fields);
		if(count($proof)>=3){
			$e=new VException("No puede especificar mas de dos campos de base de datos para el select");
			$e->process();
		}
		
		$this->cacheFunction.="\$obj->setFields(\"$fields\");";
	}
	
	/**
	 * Setea el valor del control
	 * @param string $value
	 */
	public function setValue($value){
		$this->value=$value;
		$this->selected=$value;
		
		if($this->hasDependency){
			if(empty($this->model)){
				$e=new VException("No puede solicitar que se obtengan los valores de las dependencias si no se ha pasado el modelo. Utilice \$select->sendMeModel(\$model);");
				$e->process();
			}
			
			if(empty($this->dependencyDataFieldName)){
				$e=new VException("No puede solicitar que se obtengan los valores de las dependencias si no se han definido los nombres de los campos de los objetos que se depende. Utilice \$select->setDependencyDataFieldName();");
				$e->process();
			}
			
			$condition=$this->getDependencyValues();
			$this->getFromDataBase($this->table, $this->fields,$condition,$value);
		}
		
		$this->cacheFunction.="\$obj->setValue(\"$value\");";
	}
	
	/**
	 * Devuelve el valor del control
	 * @return string
	 */
	public function getValue(){
		return $this->value;
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
	
	function __construct($args=array()){
		$this->assingVars($args);
		
		$this->modelFunction=$this->id."DependencyCallback";
		
		if(isset($args["values"])){
			$this->values=$args["values"];
		}
		
		if(isset($args["selected"])){
			$this->selected=$args["selected"];
		}
		
		if(isset($args["name"])){
			$this->name=$args["name"];
		}else{
			$this->name=$args["id"];
		}
		
		if(isset($args["dependency"])){
			$this->dependency=$args["dependency"];
		}
		
		if(isset($args["promt"])){
			$this->promt=$args["promt"];
		}
		
		if(isset($args["emptyPromt"])){
			$this->emptyPromt=$args["emptyPromt"];
		}
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
		}
		
		$this->_registry=registry::getInstance();
		
		$this->cacheFunctionConstruct.="\$obj = new select(".getArrayDefinition($args).");";
		//page::addJavaScriptOnLoad("alert('{$this->cacheFunctionConstruct}');");
	}
	
	/**
	 * Sirve para indicar de que control depende el select para ser llenado. Se disparará el evento change de JQuery.
	 * Esta función también sirve para cargar los valores cuando se carga la página si se definen los parametros $table, $fields y $dependencyDataFieldName
	 * @param string $id ID's de los controles de los que el select depende. Separados por coma
	 * @param string $table Tabla donde buscará la información. Si se define este parametro, el select pordra cargar los valores dependiendo del los valores de los objetos que depende
	 * @param string $fields Campos de la tabla
	 * @param string $dependencyDataFieldName Nombre de los campos en la tabla con los que comparará los objetos de los que depende
	 * @example $this->combo2->setDependency("usu","getCombo2","select_test_dependency","id,text","id_parent");
	 */
	function setDependency($id,$table="",$fields="",$dependencyDataFieldName=""){
		$this->dependency=$id;
		$this->hasDependency=true;
		
		if($table!=""){
			$this->isFilledByDataBase=true;
		}
		
		$this->table=$table;
		$this->fields=$fields;
		$this->dependencyDataFieldName=$dependencyDataFieldName;
		
		//$this->cacheFunction="\$obj->setDependency(\"$id\",\"$table\",\"$fields\",\"$dependencyDataFieldName\");";
		
		$cacheFunction="\$registry=registry::getInstance();\$params=\"\";\$condition=\"\";";
		$depends=explode(",",$this->dependency);
		$dependsFields=explode(",",$this->dependencyDataFieldName);
		$counter=0;
		foreach($depends as $dependeny){
			$cacheFunction.="if(isset(\$registry->args[\"$dependeny\"])){";
			$cacheFunction.="if(\$condition==\"\"){";
			$cacheFunction.="\$condition.=\" ".$dependsFields[$counter]."=\".\$registry->args[\"$dependeny\"];";
			$cacheFunction.="}else{";
			$cacheFunction.="\$condition.=\" AND ".$dependsFields[$counter]."=\".\$registry->args[\"$dependeny\"];";
			$cacheFunction.="}";
			$cacheFunction.="}";
			$counter+=1;
		}
		$cacheFunction.="\$obj->getFromDataBase(\"$table\", \"$fields\", \$condition, \"\");";
		$this->cacheFunction.=$cacheFunction;
		
		$this->dependencyFunction=$this->cacheFunctionConstruct.$cacheFunction."\$obj->render();";
		cacheFunction::saveCacheFunction($this->id."depCallback", $this->dependencyFunction);
	}
	
	/**
	 * Setea los nombre de los campos en la base de datos de los atributos de los cuales
	 * el select depende para llenar su información.
	 * 
	 * Si la propiedad "dataField" del objeto del que se depende no esta definida, se tomará el valor en la propiedad "id"
	 * @param array $dependency Se espera un array donde la llave es el id del objeto que se depende y el valor el nombre del campo en la base de datos
	 * @example $select_municipio->setDependencyDataFieldName(array("select_pais"=>"cod_pais","select_depto"=>"cod_depto");
	 */
	function setDependencyDataFieldName(array $dependency){
		$this->dependencyDataFieldName=$dependency;
		$argStr=getArrayDefinition($dependency);
		$this->cacheFunction="\$obj->setDependencyDataFieldName($argStr);";
		
		$this->hasDependency=true;
	}
	
	/**
	 * Setea el texto que aparecerá cuando no hayan datos que mostrar
	 * @param string $display
	 */
	function setEmptyPromt($promt){
		$this->emptyPromt=$promt;
	}
	
	/**
	 * Setea el texto que aparecerá antes de todos los valores del select
	 * @param string $display
	 */
	function setPromt($promt){
		$this->promt=$promt;
	}
	
	/**
	 * Ontiene los valores de los objetos que se encuentran en el modelo y que sirven para
	 * llenar el select
	 * @return string
	 */
	function getDependencyValues(){
		$condition="";
		
		$arrAsoc=array();
		$arrDeps=explode(",",$this->dependency);
		$arrDepsNames=explode(",",$this->dependencyDataFieldName);
		$count=0;
		foreach($arrDeps as $dep){
			$arrAsoc[$dep]=$arrDepsNames[$count];
			$count++;
		}
		
		foreach(get_object_vars($this->model) as $key=>$var){
			if(method_exists($this->model->$key, "getValue")){
				foreach ($arrAsoc as $id=>$field){
					if($this->model->$key->getId()==$id){
						if($condition==""){
							$condition="$field=".db::checkRealEscapeString($this->model->$key->getValue());
						}else{
							$condition.=" AND $field=".db::checkRealEscapeString($this->model->$key->getValue());
						}
					}
				}
			}
		}
		
		return $condition;
	}
	
	/**
	 * Obtiene los valores del select desde una tabla de la base de datos
	 * @param string $table Tabla de la base de datos
	 * @param string $fields Campos a traer. Se esperan dos: el valor, y la descripcion
	 * @param string $condition Condicion para el query que se ejecutará
	 * @param string $selected Valor que sera el seleccionado segun el listado del select
	 * @return boolean
	 */
	function getFromDataBase($table, $fields, $condition="", $selected=""){
		$this->table=$table;
		$this->fields=$fields;
		$this->condition=$condition;
		$this->selected=$selected;
		
		$this->isFilledByDataBase=true;
	}

	private function getData(){
		if(count(explode(",",$this->fields))>=3){
			$e=new VException("No puede especificar mas de dos campos de base de datos para el select");
			$e->process();
		}
		
		$rs=db::getFields($this->table,$this->fields, $this->condition);
		
		if(!$rs){
			return false;
		}
		
		$ret="";
		while($row=db::fetch() ) {
			$this->values[]=array("value"=>$row[0],"desc"=>$row[1]);
		}
	}
	/**
	 * Agrega un item al select
	 * @param string $value Valor del item
	 * @param string $desc Texto que aparecerá en el select
	 */
	public function addItem($value,$desc){
		$this->values[]=array("value"=>$value,"desc"=>$desc);
	}
	
	/**
	 * Registra la funcion JavaScript que se ejecutará en el cliente
	 */
	private function registerJsFunction(){
		$depends=explode(",",$this->dependency);
		
		foreach($depends as $depend){
			$js="$('#{$depend}').bind('change',function(){select{$this->id}_load();});";
			page::addJavaScriptOnLoad($js);
		}
		
		$deps="";
		foreach($depends as $depend){
			if($deps==""){
				$deps="$depend='+$('#$depend').val()";
			}else{
				$deps.="+'&$depend='+$('#$depend').val()";
			}
		}
		
		$js="function select{$this->id}_load(){";
		
		$js.='$.ajax({';
		$js.="url:'?cacheFunction=".$this->id."depCallback&$deps";
		//$js.="data:'m=".$this->_registry->controllerName."&a=".$this->modelFunction."&$deps";
		$js.=",dataType:'text'";
		$js.=",async:false";
		$js.=",success: function(data){";
		//$js.="alert(data);";
		$js.="$('#{$this->id}').html(data);";
		$js.="}";
		
		$js.="});";
		
		$js.="}";
		page::addJavaScript($js);
	}
	
	/**
	 * Renderiza el control a código HTML
	 */
	function render($return=false){
		$render="";
		$render.="<select id=\"{$this->id}\" name=\"{$this->name}\">";
		$options="";
		
		if($this->isFilledByDataBase){
			if($this->hasDependency){
				if((!empty($this->value)&&$this->value!=="")||velkan::isAjaxCall()){
					$this->getData();
				}
			}else{
				$this->getData();
			}
		}
		
		if(!empty($this->values)){
			$count=0;
			foreach($this->values as $val){
				if($this->selected!==""){
					if(!empty($this->promt)&&$this->promt!==""&&$count==0){
						$options.="<option value=\"\">{$this->promt}</option>";
					}
					if($val["value"]==$this->selected){
						$options.="<option value=\"{$val["value"]}\" selected>{$val["desc"]}</option>";
						$this->text=$val["desc"];
					}else{
						$options.="<option value=\"{$val["value"]}\">{$val["desc"]}</option>";
					}
				}else{
					if(!empty($this->promt)&&$this->promt!==""&&$count==0){
						$options.="<option value=\"\" selected>{$this->promt}</option>";
						$this->text=$val["desc"];
						$count++;
					}
					
					if($count==0){
						$options.="<option value=\"{$val["value"]}\" selected>{$val["desc"]}</option>";
						$this->text=$val["desc"];
					}else{
						$options.="<option value=\"{$val["value"]}\">{$val["desc"]}</option>";
					}
				}
				$count++;
			}
		}
		
		if(velkan::isAjaxCall()){
			if($this->readonly){
				$render = "<span class=\"velkan-read-only\"><input type=\"hidden\" value=\"{$this->selected}\" name=\"{$this->name}\" id=\"{$this->id}\">$this->text</span>";
			}else{
				echo $options;
			}
			
		}else{
			if($this->dependency!=""&&!velkan::isAjaxCall()){
				$this->registerJsFunction();
			}
			
			if($this->readonly){
				$render = "<span class=\"velkan-read-only\"><input type=\"hidden\" value=\"{$this->selected}\" name=\"{$this->name}\" id=\"{$this->id}\">$this->text</span>";
			}else{
				$render.=$options."</select>";
			}
			
			if($return){
				return $render;
			}else{
				echo $render;
			}
		}
	}
}
?>