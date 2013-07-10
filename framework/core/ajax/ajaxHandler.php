<?php
class ajaxHandler{
	var $functions=array();
	var $model;
	
	function registerFunction($function,$params=array()){
		$this->functions[$function]=array();
		if(!empty($params)){
			registerParams($function,$params);
		}
	}
	function registerParams($function,$params){
		if(key_exists($function, $this->functions)){
			$this->functions[$function]=$params;
		}
	}
	function __construct($model){
		
	}
}
?>