<?php
include_once SITE_PATH."/framework/core/clientside/datagrid/pager.php";
/**
 * Velkan PHP Framework
 * Control Dataview
 *
 * Sirve para renderizar codigo HTML personalizado obteniendo los datos de la base de datos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class dataview extends globalAttr{
	/**
	 * Almacena el código HTML que mostrará por cada linea de datos
	 * @var string
	 */
	protected $html;
	
	/**
	 * Clase del div contenedor de los datos
	 * @var string
	 */
	protected $containerClass="";
	
	/**
	 * Nombre de la tabla donde buscará los datos
	 * @var string
	 */
	protected $table;
	
	/**
	 * Pagina a mostrar
	 * @var number
	 */
	protected $page;
	
	/**
	 * Campos a mostrar
	 * @var string
	 */
	protected $fields;
	
	/**
	 * Tipos de datos de los campos en la base de datos
	 * @var string
	 */
	protected $fieldsTypes;
	
	/**
	 * Filtros a agregar en el query
	 * @var string
	 */
	protected $filters=array();
	
	/**
	 * Orden a mostrar en el query
	 * @var string
	 */
	protected $order;
	
	/**
	 * Controla si vamos a devolver o no los datos obtenidos de la base de datos
	 * @var boolean
	 */
	protected $returnData=false;
	
	/**
	 * Controla si el objeto buscará los datos en la base de datos
	 * @var boolean
	 */
	protected $hasDatabaseCall=false;
	
	/**
	 * Control del maximo numero de filas por página que se mostrarán
	 * @var int
	 */
	protected $maxRowsPerPage=1;
	
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
	 * Datos obtenidos desde la base de datos, o agregados mediante addElement
	 * @var string
	 */
	protected $data=array();
	
	/**
	 * Define si la llamada actual es por Ajax o una llamada normal
	 * @var unknown_type
	 */
	protected $isAjaxCall=false;
	
	function __construct(array $args){
		$this->assingVars($args);
		
		if(isset($args["html"])){
			$this->html=$args["html"];
		}
	}
	
	/**
	 * Setea el código HTML que mostrará por cada línea de datos. Los campos de la base de datos se deben encerrar en '#'
	 * @param string $html
	 * @example $dataview->setHtml("<div class=header>#txt_header#</div><div class=content>#txt_content#</div>");
	 */
	function setHtml($html){
		$this->html=$html;
	}
	
	function addItem($item){
		$this->data[]=$item;
	}
	
	function setContainerClass($class){
		$this->containerClass=$class;
	}
	
	/**
	 * Setea los parametros para buscar en la base de datos
	 * @param string $table Tabla donde buscar
	 * @param number $page Pagina a mostrar
	 * @param string $fields Campos a buscar en la tabla
	 * @param string $fieldsTypes Tipos de datos de los campos
	 * @param string $filter
	 * @param unknown_type $order
	 * @param unknown_type $return
	 */
	function getFromDataBase($table,$page=1,$fields="", $fieldsTypes="", $filter="",$order="",$return=false){
		$this->table=$table;
		$this->page=$page;
		
		if(!empty($fields)){
			$this->fields=explode(",",$fields);
		}
		
		if(!empty($fieldsTypes)){
			$this->fieldsTypes=explode(",",$fieldsTypes);
		}
		
		if(!empty($filter)){
			$filters=explode("|",$filter);
			foreach($filters as $filt){
				$this->filters[]=explode("::",$filt);
			}
		}
		
		if(!empty($order)){
			$orderArray=explode("|",$order);
			$this->order=$this->fields[$orderArray[0]]." ".$orderArray[1];
		}
		
		$this->order=$order;
		$this->returnData=$return;
		
		$this->hasDatabaseCall=true;
	}
	
	private function getData(){
		db::getAdapter();
		
		$counter=0;
		$arrayFieldQuery=array();
		if(!empty($this->fields)){
			foreach($this->fields as $field){
				$arrayFieldQuery[$field]=$this->fieldsTypes[$counter];
				$counter++;
			}
		}
		
		$counter=0;
		$arrayFilters=array();
		if(!empty($this->filters)){
			foreach($this->filters as $filter){
				$arrayFilters[$this->fields[$filter[0]]]=array("type"=>$this->fieldsTypes[$filter[0]],"value"=>$filter[1]);
			}
		}
		
		
		if(db::getFields($this->table,$arrayFieldQuery,$arrayFilters,$this->order,$this->limit,true)){
			$this->pages=ceil(((int)db::getCalculatedRows())/((int)$this->maxRowsPerPage));
			$this->maxRows=(int)db::getCalculatedRows();
			while($row=db::fetch(db::$FETCH_TYPE_ASSOC)){
				$this->addItem($row);
			}
		}
	}
	
	/**
	 * Renderiza el objeto
	 * @param boolean $return Si se especifica true, en lugar de imprimir en pantalla, devolverá el código HTML generado
	 */
	function render($return=false){
		$items="";
		if($this->hasDatabaseCall){
			$this->getData();
			
			if(!empty($this->data)){
				foreach($this->data as $data){
					$item=$this->html;
					foreach($data as $key=>$value){
						$item=str_replace("#$key#", $value, $item);
					}
					$items.=$item;
				}
			}
		}
		
		$render="<div id='{$this->id}' class='{$this->containerClass}'>$items</div>";
		
		if($return){
			return $render;
			
		}else{
			echo $render;
		}
	}
}