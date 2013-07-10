<?php
/**
 * Velkan PHP Framework
 * Clase abstracta para el control de los modelos
 * Puede instanciar a traves de la clase registry y registrar metodos en la clase que cree este objeto
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */

abstract class model{
	protected $db;
	protected $_registry;
	protected $js;
	
	protected $rules=array();
	protected $formats=array();
	
	/**
	 * Nombre de la tabla, vista o procedimiento almacenado al que esta vinculado el modelo
	 * @var string
	 */
	protected $dbObjectName="";
	
	/**
	 * Campo o campos de llave primaria de la tabla, separados por coma. 
	 * Se comparara con el campo dataField que se setea con la funcion setDataField de cada control
	 * @var string
	 */
	protected $tablePrimaryKeys="";
	
	static $DBOBJECT_TYPE_TABLE=0;
	static $DBOBJECT_TYPE_PROCEDURE=0;
	static $DBOBJECT_TYPE_VIEW=0;
	
	/**
	 * Tipo del objeto de la base de datos
	 * @var number
	 */
	protected $dbObjectType=0;
	
	/**
	 * Error al ejecutar un query
	 * @var string
	 */
	protected $dbError="";
	
	/**
	 * Determina si el modelo ha sido cargado o no
	 * @var unknown_type
	 */
	protected $loaded=false;
	
	/**
	 * Controla si el modelo esta en modo readOnly
	 * @var boolean
	 */
	protected $readOnly=false;
	
	/**
	 * Controla que accion se esta ejecutando en el momento
	 * @var unknown_type
	 */
	private $currDBAction="";
	
	/**
	 * Titulo del controlador. Se utilizará por ejemplo en el breadcrumb
	 * @var string
	 */
	protected $title;
	
	final function setTitle($title){
		$this->title=$title;
		$registry=registry::getInstance();
	
		$registry->controllerMethodTitle=$title;
	
		unset($registry);
	}
	
	function __construct(){
		$this->_registry=Registry::getInstance();
		$this->js=new ajax();
		$this->db=new db();
		
		$this->load();
		$this->loaded=true;
	}
	
	final public function __set($key,$val){
		$this->_registry->$key=$val;
	}
	
	final public function __get($key){
		if($return = $this->_registry->$key){
			return $return;
		}
		return false;
	}
	
	/**
	 * Funcion reservada para inicializar valores en el modelo
	 */
	function load(){}
	
	final function getJSOnLoad(){
		return $this->js->get_js_onload();
	}
	
	/**
	 * Setea el nombre del campo o campos que son llave en la tabla
	 * @param string $keys Campo o campos separados por coma
	 */
	final function setTablePrimaryKey($keys){
		$this->tablePrimaryKeys=$keys;
	}
	
	/**
	 * Setea el objeto que se usará en la base de datos para las distintas acciones
	 * @param string $name Nombre del objeto
	 * @param number $type Tipo del objeto. Sólo existen tres posibles valores definidos en model::DB_OBJECT_TYPE
	 */
	final function setDBObject($name,$type){
		$this->dbObjectName=$name;
		$this->dbObjectType=$type;
	}
	
	private function getAllDataFieldNames(){
		$fields="";
		foreach(get_object_vars($this) as $key=>$var){
			if(method_exists($this->$key, "getDataField")&&$this->$key->getDataField()!==""){
				if($fields==""){
					$fields=$this->$key->getDataField();
				}else{
					
				}
		
				if(method_exists($this->$key, "setValue")){
					$this->$key->setValue($value);
				}
			}
		}
		
	}
	
	/**
	 * Obtendrá los valores de los argumentos enviados y los asignará a su correspondiente
	 * objeto del modelo
	 */
	final private function setValueFromArgs(){
		$return=array();
		
		$registry=registry::getInstance();
		//print_r($registry->args);
		//Recorremos todos los argumentos enviados en un formulario
		foreach($registry->args as $name=>$arg){
			//Despues recorremos todos los objetos del modelo
			foreach(get_object_vars($this) as $key=>$var){
				//Si el objeto tiene el metodo getName, significa que es un campo con datos
				if(method_exists($this->$key, "getName")){
					//Si el nombre del objeto es igual al argumento que estamos comprobando en el momento, le asignará el valor que traiga
					if($this->$key->getName()==$name){
						//Para los objetos que tienen dependencia de otros objetos, se envía el objeto del modelo
						if(method_exists($this->$key, "sendMeModel")){
							$this->$key->sendMeModel($this);
						}
						
						$this->$key->setValue($arg);
						
						$return[]=$key;
					}
				}
			}
		}
		
		return $return;
	}
	
	/**
	 * Obtiene el error que genero una acción con la base de datos
	 * @return string
	 */
	function getError(){
		return $this->dbError;
	}
	
	/**
	 * Guarda los datos en una base de datos. Si se identifica un campo como llave primaria de una tabla, Velkan tratará de hacer la actualización.
	 */
	final function save(){
		
		$this->currDBAction="save";
		
		//Campos a trabajar
		$fields=array();
		
		if(!$this->loaded){
			//Ejecutamos la funcion load del modelo
			$this->load();
		}
		
		$fieldsToSave=$this->setValueFromArgs();
		
		foreach($fieldsToSave as $key){
			$dataType="string";
			if(method_exists($this->$key, "getDataField")){
				if(method_exists($this->$key, "getDataType")){
					$dataType=$this->$key->getDataType();
				}
				$fields[$this->$key->getName()]=array("field"=>$this->$key->getDataField(),
														"primaryKey"=>false,
														"value"=>$this->$key->getValue(),
														"dataType"=>$dataType);
			}
		}
		
		switch ($this->dbObjectType){
			case self::$DBOBJECT_TYPE_TABLE:
				db::getAdapter();
				db::connect();
				
				//Condiciones para buscar si el registro existe
				$conditions="";
				$conditionsArray=array();
				$primaryKeys=explode(",",$this->tablePrimaryKeys);
				
				foreach($primaryKeys as $key){
					foreach($fields as $field=>&$dataField){
						if($dataField["field"]==$key){
							$dataField["primaryKey"]=true;
							
							if(!empty($dataField["value"])){
								$conditionsArray[$key]=$dataField["value"];
								
								if($conditions==""){
									$conditions="{$this->dbObjectName}.$key=".db::checkRealEscapeString($dataField["value"]);
								}else{
									$conditions=" AND {$this->dbObjectName}.".$key."=".db::checkRealEscapeString($dataField["value"]);
								}
							}
						}
					}
				}
				
				unset($field);
				unset($dataField);
				
				if(!empty($conditionsArray)){
					$rs=db::getFields($this->dbObjectName,"",$conditions);
				}else{
					$rs=false;
				}
				
				//Si el registro existe, se procede a hacer un update
				if($rs){
					//Si el registro existe, se procede a hacer un update
					$updates=array();
					
					foreach($fields as $field=>$dataField){
						if(!$dataField["primaryKey"]){
							$updates[$dataField["field"]]=array("value"=>$dataField["value"],
															"dataType"=>$dataField["dataType"]);
						}
					}
					
					$resultado=db::update($this->dbObjectName, $updates, $conditions);
					
					if(!$resultado){
						$this->dbError=db::getError();
						
						return false;
					}
					
					return true;
				}else{
					$inserts=array();
					foreach($fields as $field=>&$dataField){
						if(!empty($dataField["value"])){
							$inserts[$this->dbObjectName.".".$dataField["field"]]=array("dataType"=>$dataField["dataType"],
																						"value"=>$dataField["value"]);
						}
					}
					
					//Si el registro no existe, se procede a hacer un insert
					$resultado=db::insert($this->dbObjectName, $inserts);
					
					if(!$resultado){
						$this->dbError=db::getError();
						
						return false;
					}
						
					return true;
				}
				break;
			case self::$DBOBJECT_TYPE_TABLE:
				break;
			case self::$DBOBJECT_TYPE_TABLE:
				break;
		}
	}
	
	/**
	 * Elimina un registro de la base de datos.
	 * @param array $fieldsIdAndValues Arreglo de campos llave a buscar.
	 * @return boolean
	 */
	function delete(array $fieldsIdAndValues){
		$existe=false;
		
		$fields=array();
		$filters=array();
		//Recorremos los objetos del modelo
		foreach(get_object_vars($this) as $key=>$var){
			//Si el objeto tiene el metodo getName, significa que es un campo con datos
			if(method_exists($this->$key, "getDataField")){
				//Si el nombre del objeto es igual al argumento que estamos comprobando en el momento, le asignará el valor que traiga
				$fields[$this->$key->getDataField()]=$this->$key->getDataType();
			}
		}
		
		foreach($fieldsIdAndValues as $field){
			$filters[$field["field"]]=array("type"=>$field["type"],"value"=>$field["value"]);
		}
		
		db::getAdapter();
		db::connect();
		//Si el registro no existe, se procede a hacer un insert
		$resultado=db::delete($this->dbObjectName, $filters);
		
		if(!$resultado){
			$this->dbError=db::getError();
		
			return false;
		}
		
		return true;
	}
	
	/**
	 * Otiene los datos de la base de datos y los asigna a cada control.
	 * @param array $fieldsIdAndValues Arreglo de campos llave a buscar.
	 * @return boolean
	 * @example if($this->model->getById(array(array("field"=>"id","type"=>velkan::$DATATYPE_NUMBER,"value"=>$id)))){
				$this->render->view("actions");
			}else{
				$this->render->error(velkan::$ERROR_TYPE_NO_DATA_FOUND);
			}
	 */
	final function getById(array $fieldsIdAndValues){
		$existe=false;
		
		$fields=array();
		$filters=array();
		//Recorremos los objetos del modelo
		foreach(get_object_vars($this) as $key=>$var){
			//Si el objeto tiene el metodo getName, significa que es un campo con datos
			if(method_exists($this->$key, "getDataField")){
				//Si el nombre del objeto es igual al argumento que estamos comprobando en el momento, le asignará el valor que traiga
				$fields[$this->$key->getDataField()]=$this->$key->getDataType();
			}
		}
		
		foreach($fieldsIdAndValues as $field){
			$filters[$field["field"]]=array("type"=>$field["type"],"value"=>$field["value"]);
		}
		
		//print_r($fields);
		//print_r($filters);
		
		db::getAdapter();
		db::getFields($this->dbObjectName,$fields,$filters);
		
		while($row=db::fetch(db::$FETCH_TYPE_ASSOC)){
			foreach($row as $name=>$value){
				foreach(get_object_vars($this) as $key=>$var){
					//Si el objeto tiene el metodo getName, significa que es un campo con datos
					if(method_exists($this->$key, "getDataField")){
						//Si el nombre del objeto es igual al argumento que estamos comprobando en el momento, le asignará el valor que traiga
						if($this->$key->getDataField()==$name){
							//Para los objetos que tienen dependencia de otros objetos, se envía el objeto del modelo
							if(method_exists($this->$key, "sendMeModel")){
								$this->$key->sendMeModel($this);
							}
							
							$this->$key->setValue($value);
							$existe=true;
						}
					}
				}
			}
		}
		
		return $existe;
	}
	
	/**
	 * Pone todos los controles como readOnly
	 */
	final function setReadOnly($val){
		$this->readOnly=$val;
		foreach(get_object_vars($this) as $key=>$var){
			//Si el objeto tiene el metodo getName, significa que es un campo con datos
			if(method_exists($this->$key, "setReadOnly")){
				$this->$key->setReadOnly($val);
			}
		}
	}
	
	final function isReadOnly(){
		return $this->readOnly;
	}
}
?>