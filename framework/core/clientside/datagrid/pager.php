<?php
/**
 * Velkan PHP Framework
 * Clase pager
 *
 * Sirve para renderizar los botones de paginación para el datagrid
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */

class pager{
	protected $data=array();
	protected $_registry;
	
	protected $isAjaxCall=false;
	
	function set($key,$val){
		$this->data[$key]=$val;
	}
	function get($key){
		if(key_exists($key, $this->data)){
			return $this->data[$key];
		}
		return "";
	}
	
	function isAjaxCall($val){
		$this->isAjaxCall=$val;
	}
	
	function __construct($args=array()){
		$this->data=$args;
		$this->_registry=registry::getInstance();
	}
	
	function render($return=false){
		switch ($this->data["type"]){
			case "buttons":
				return $this->renderButtons($return);
				break;
			case "condensed":
				break;
		}
	}
	
	function renderButtons($return=false){
		$pagination="";
		$a_page=$this->data["currPage"];
		$a_filter="";
		$a_order="";
		
		$theFunction=$this->get("gridId")."_THEPAGERFUNCTION_";
		
		if(!empty($this->_registry->args)){
			$a_page=$this->_registry->args["page"];
			$a_filter=$this->_registry->args["filter"];
			$a_order=$this->_registry->args["order"];
		}
		
		if($this->data["pages"]>1){
			
			$prev=(int)($this->data["currPage"]-1);
			$next=(int)($this->data["currPage"]+1);
			
			$pagination="<div ".(velkan::$config["datagrid"]["paginationClass"]==""?"":"class=\"".velkan::$config["datagrid"]["paginationClass"]."\"")." id=\"{$this->data["gridId"]}_pag\">";
			$pagination.="<ul>";
			
			if($this->data["currPage"]>=2){
				$b1="<li><a href=\"";
				$b2="<li><a href=\"";
				
				$b1.="javascript:$theFunction(1);\">";
				$b2.="javascript:$theFunction(".$prev.");\">";
				
				$b1.=velkan::$lang["grid_msg"]["first"]."</a></li>";
				$b2.=velkan::$lang["grid_msg"]["prev"]."</a></li>";
				
				$pagination.="$b1$b2";
			}
			
			$add=floor($this->data["maxNumPages"]/2);
			$first=$this->data["currPage"]-$add;
			$last=$this->data["currPage"]+$add;
				
			if($first<1){
				$last+=abs($first)+1;
				$first=1;
			};
				
			if($this->data["currPage"]==$this->data["pages"]){
				$first-=1;
			}
				
			$count=1;
			for($i=$first;$i<=$last;$i++){
				if($count<=$this->data["maxNumPages"]){
					$page=$i;
					if($page<=$this->data["pages"]){
						if($this->data["currPage"]==$page){
							$pagination.="<li class=\"".velkan::$config["datagrid"]["activePaginationButtonClass"]."\"><a href=\"javascript:void(0);\">$page</a></li>";
						}else{
							$pagination.="<li><a href=\"javascript:$theFunction($page);\">$page</a></li>";
						}
					}
				}
				$count++;
			}
			if($this->data["currPage"]<$this->data["pages"]){
				$b1="<li><a href=\"";
				$b2="<li><a href=\"";
				
				$b1.="javascript:$theFunction({$this->data["pages"]});\">";
				$b2.="javascript:$theFunction($next);\">";
				
				$b1.=velkan::$lang["grid_msg"]["last"]."</a></li>";
				$b2.=velkan::$lang["grid_msg"]["next"]."</a></li>";
				
				$pagination.="$b2$b1";
				/*
				$pagination.="<li><a href=\"$link$next\">".velkan::$config["datagrid"]["next"]."</a></li>";
				$pagination.="<li><a href=\"$link{$this->data["pages"]}\">".velkan::$config["datagrid"]["last"]."</a></li>";
				*/
			}
			$pagination.="</ul>";
			$pagination.="</div>";
			
			$theMasterFunction=$this->get("gridId")."_THETIMEDFUNCTION_";
			$theTimeController=$this->get("gridId")."_THETIMECONTROLLER_";
			$theInput="grid".$this->get("gridId")."Page";
			
			$js="function ".$this->get("gridId")."_THEPAGERFUNCTION_(page){";
			$js.="$('#$theInput').val(page);";
			$js.="clearTimeout($theTimeController);";
			$js.="$theTimeController=setTimeout($theMasterFunction,1500);";
			$js.="}";
			
			page::addJavaScript($js);
		}
		
		if($return){
			return $pagination;
		}else{
			echo $pagination;
		}
	}
}
?>